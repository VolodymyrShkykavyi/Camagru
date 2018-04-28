<?php

namespace app\core;

use app\core\View;

abstract class  Controller
{
	public $route;
	public $view;
	public $model;
	public $ViewData = array();

	public function __construct($route)
	{
		if (isset($_SESSION['authorization'])) {
			if (!$_SESSION['authorization']['verified']) {
				if (!($route['controller'] == 'account' &&
						($route['action'] == 'verify' || $route['action'] == 'logout')) &&
					!($route['controller'] == 'gallery' && $route['action'] == 'index')){
					View::redirect('/account/verify');
					return;
				}
			}
		}
		$this->route = $route;
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
	}

	public function loadModel($name)
	{
		$path = 'app\models\\' . ucfirst($name) . 'Model';
		if (class_exists($path)) {
			return new $path;
		}
	}
}