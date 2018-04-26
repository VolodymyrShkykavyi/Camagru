<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction(){
    	if (isset($_SESSION['authorization'])){
    		if (!$_SESSION['authorization']['verified']){
    			$this->view->redirect('/account/verify');
    			return;
			}
		}
        $res = $this->model->getNews();
        $ViewData = [
            'users' => $res,
        ];
		$this->view->render('Main page', $ViewData);
		//$this->view->redirect('/gallery');
    }
}