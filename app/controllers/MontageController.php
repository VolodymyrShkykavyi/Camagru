<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class MontageController extends Controller
{
	public function __construct($route)
	{
		parent::__construct($route);
		if (!AccountController::checkUserToken()){
			View::redirect('/');
			exit(0);
		}
	}
}