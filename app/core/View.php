<?php

namespace app\core;

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        if (file_exists(ROOT . '/app/views/' . $this->path . '.php') &&
            file_exists(ROOT . '/app/views/layouts/' . $this->layout . '.php')){
            ob_start();
            require ROOT . '/app/views/' . $this->path . '.php';
            $content = ob_get_clean();
            require ROOT . '/app/views/layouts/' . $this->layout . '.php';
        } else{
            echo 'View not found' . $this->path;
        }
    }
}