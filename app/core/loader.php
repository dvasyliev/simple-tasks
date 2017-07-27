<?php

final class Loader
{
    private $registry;

    public function __construct( $registry )
    {
        // Получаем экземпляр класса регистратора
        $this->registry = $registry;
    }

    public function model( $model )
    {
        $file = DIR_MODEL . '/' . $model . '.php';

        if( file_exists( $file ) ):
            // Подключаем модель
            include_once $file;

            // Разбиваем ствроку с местоположением модели относительно
            // папки 'app/model' и получаем название класса можели
            $modelRoutes = explode( '/', $model );
            $modelName = array_pop( $modelRoutes );
            $modelClass = ucfirst($modelName) . 'Model';

            // Регистрируем экземпляр класса модели в масиве регистратора,
            // что бы могли вызвать ее методы во всех других классах
            $this->registry->set(
                'model_' . str_replace( '/', '_', $model ),
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

            // Включение буферизации вывода
            ob_start();

            include $file;

            // Запись содержимого из буфера вывода в переменную '$output'
            $output = ob_get_contents();

            // Очистка буфера вывода и отключение буферизации вывода
            ob_end_clean();
        else:
            trigger_error( 'Error: Could not load template ' . $file . '!' );
        endif;

        return $output;
    }
}