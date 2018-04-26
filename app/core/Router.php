<?php

namespace app\core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct(){
        $arr = require ROOT . '/config/routes.php';
        foreach ($arr as $key => $value){
            $this->add($key, $value);
        }
    }

    public function add($route, $params){
        $route = '~^' . $route . '$~';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim(strtok($_SERVER['REQUEST_URI'], '?'),'/');
        foreach ($this->routes as $key => $value){
            if (preg_match($key, $url, $matches)){
                $this->params = $value;
                return (true);
            }
        }
        return (false);
    }

    public function run()
    {
        if ($this->match()){
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)){
               $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)){
                    $controller = new $path($this->params);
                    $controller->$action();
                } else{
                    View::errorCode(404);
                }
            } else{
                View::errorCode(404);
            }
        } else{
            View::errorCode(404);
        }
    }
}