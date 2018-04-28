<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction(){

        $res = $this->model->getNews();
        $ViewData = [
            'users' => $res,
        ];
		$this->view->render('Main page', $ViewData);
		//$this->view->redirect('/gallery');
    }
}