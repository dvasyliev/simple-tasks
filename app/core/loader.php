<?php

final class Loader
{
    private $registry;

    public function __construct( $registry )
    {
        // Получаем экземпляр класса регистратора
        $this->registry = $registry;
    }

    public function controller( $controller )
    {
        $file = DIR_CONTROLLER . '/' . $controller . '.php';

        if( file_exists( $file ) ):
            // Подключаем  контроллер
            include_once $file;

            // Получаем название класса контроллера
            $controller = ucwords( $controller );
            $controllerName = str_replace( '/', '', $controller );
            $controllerClass = 'Controller' . $controllerName;

            new $controllerClass( $this->registry );

            $controllerAction = "index";

            if ( is_callable( array( $controllerClass, $controllerAction ) ) ):
                call_user_func( array( $controllerClass, $controllerAction ) );
            endif;
        else:
            trigger_error( 'Error: Could not load controller ' . $file . '!' );
        endif;
    }

    public function model( $model )
    {
        $file = DIR_MODEL . '/' . $model . '.php';

        if( file_exists( $file ) ):
            // Подключаем модель
            include_once $file;

            // Получаем название класса модели
            $model = ucwords( $model );
            $modelName = str_replace( '/', '', $model );
            $modelClass = 'Model' . $modelName;

            // Регистрируем экземпляр класса модели в масиве регистратора,
            // что бы могли вызвать ее методы во всех других классах
            $this->registry->set(
                'model_' . str_replace( '/', '_', strtolower( $model ) ),
                new $modelClass( $this->registry )
            );
        else:
            trigger_error( 'Error: Could not load model ' . $file . '!' );
        endif;
    }

    public function view( $template, $data = array() )
    {
        $file = DIR_TEMPLATE . '/' . $template . '.php';

        if( file_exists( $file ) ):
            // Преобразовуем масив данных в переменные
            extract( $data );

            include $file;
        else:
            trigger_error( 'Error: Could not load template ' . $file . '!' );
        endif;
    }
}