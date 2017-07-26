<?php

class Router
{
    private $routes;
    private $uri;

    public function __construct()
    {
        $routePath = DIR_CONFIG . '/routes.php';
        $this->routes = include $routePath;
    }

    public function getUri()
    {
        if ( !empty( $_SERVER['REQUEST_URI'] ) ):
            return trim( $_SERVER['REQUEST_URI'], '/' );
        endif;
    }

    public function start()
    {
        $this->uri = $this->getUri();

        foreach ( $this->routes as $uriPattern => $route ):
            if ( preg_match( '~' . $uriPattern . '~', $this->uri ) ):
                $controllerFolder = $route[ 'path' ];
                $controllerName = $route[ 'controller' ];
                $controllerAction = $route[ 'action' ];

                $controllerFile = DIR_CONTROLLER . '/' . $controllerFolder . '/' . $controllerName . '.php';

                if( file_exists( $controllerFile ) ):
                    include_once $controllerFile;

                    $controllerClass = ucfirst($controllerName) . 'Controller';
                    $controller = new $controllerClass;

                    if( method_exists( $controller, $controllerAction ) ):
                        $controller->$controllerAction();
                    else:
                        throw new Exception('Error: Could not find method ' . $controllerAction . ' in file ' . $controllerFile . '.');
                    endif;

                else:
                    throw new Exception( 'Error: Could not load controller ' . $controllerFile . '!' );
                endif;
            endif;
        endforeach;
    }
}