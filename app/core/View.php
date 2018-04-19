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

    public function render($title, $ViewData = [])
    {
        $pathView = ROOT . '/app/views/' . $this->path . '.php';
        $pathLayout = ROOT . '/app/views/layouts/' . $this->layout . '.php';
        if (file_exists($pathView) && file_exists($pathLayout)){
            ob_start();
            require $pathView;
            $content = ob_get_clean();
            require $pathLayout;
        } else{
            View::errorCode(404);
        }
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        if (file_exists(ROOT . '/app/views/errors/' . $code . '.php')) {
            require ROOT . '/app/views/errors/' . $code . '.php';
        }
        exit;
    }
}