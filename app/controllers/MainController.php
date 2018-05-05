<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class MainController extends Controller
{
    public function indexAction(){
    	View::redirect('/gallery');
    }
}