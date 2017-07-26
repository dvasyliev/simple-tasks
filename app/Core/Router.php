<?php

class Router
{
    private $routes;
    private $uri;

    public function __construct()
    {
        $routePath = CONFIG . '/routes.php';
        $this->routes = include $routePath;
    }

    public function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])):
            return trim($_SERVER['REQUEST_URI'], '/');
        endif;
    }

    public function start()
    {
        $this->uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $route):
            if (preg_match('~' . $uriPattern . '~', $this->uri)):
                $segments = explode('/', $route);

                $controllerName = ucfirst(array_shift($segments));
                $actionName = array_shift($segments);
                $controllerFile = CONTROLLER . $controllerName . '.php';

                if(file_exists($controllerFile)):
                    include_once $controllerFile;

                    $controller = new $controllerName;

                    if(method_exists($controller, $actionName)):
                        $controller->$actionName();
                    else:
                        throw new Exception('Error: Method ' . $actionName . ' not exist in file ' . $controllerFile . '.');
                    endif;
                else:
                    throw new Exception('Error: File ' . $controllerFile . ' not found.');
                endif;
            endif;
        endforeach;
    }
}