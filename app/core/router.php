<?php

class Router
{
    private $file;
    private $class;
    private $action;
    private $routes;

    public function __construct()
    {
        $routePath = DIR_CONFIG . '/routes.php';
        $this->routes = include $routePath;
    }

    public function getUri()
    {
        if ( !empty( $_SERVER[ 'REQUEST_URI' ] ) ):
            return trim( $_SERVER[ 'REQUEST_URI' ], '/' );
        endif;
    }

    public function start( $registry )
    {
        $uri = $this->getUri();
        $routes_keys = array_keys( $this->routes );
        
        // Откидаем все поисковые параметры, что бы сравнить
        // маршрут с маршрутами в масиве
        preg_match( "/[^\?]+/", $uri, $uri_matches );

        if( in_array( $uri_matches[0], $routes_keys ) ):
            // Перебираем все полученные маршруты
            foreach ( $this->routes as $uriPattern => $route ):
                // Проверяем существует ли текуший маршрут в этом масиве
                if ( preg_match( '~' . $uriPattern . '~', $uri ) ):
                    $this->execute_action( $registry, $route );
                endif;
            endforeach;
        else:
            $this->execute_action( $registry, $this->routes[ "page404"] );
        endif;
    }

    public function execute_action( $registry, $route )
    {
        // Определяем файл контролера
        $this->file = DIR_CONTROLLER . '/' . $route[ 'path' ] . '/' . $route[ 'controller' ] . '.php';

        if( file_exists( $this->file ) ):
            // Определяем название класса контролера и метода
            // Получаем название класса контроллера
            $route[ 'controller' ] = ucwords( $route[ 'controller' ] );
            $controllerName = ucwords(  $route[ 'path' ] ) . ucwords(  $route[ 'controller' ] );
            $this->class = 'Controller' . $controllerName;
            $this->action = $route[ 'action' ];

            // Подключаем контролер
            include_once $this->file;

            // Создаем екземпляр класса контролера и передаем
            // в него екземпляр класса регистраора
            $controller = new $this->class( $registry );

            // Проверяем, может ли быть вызвано
            // значение переменной в качестве функции
            if( is_callable( array( $controller, $this->action ) ) ):
                // Вызываем метод контроллера
                call_user_func( array( $controller, $this->action ) );
            else:
                trigger_error('Error: Could not find method ' . $this->action . ' in file ' . $this->file . '.');
            endif;

        else:
            trigger_error( 'Error: Could not load controller ' . $this->file . '!' );
        endif;
    }
}