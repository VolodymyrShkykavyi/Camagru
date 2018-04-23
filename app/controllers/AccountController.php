<?php

namespace app\controllers;

use app\core\Controller;

class  AccountController extends Controller
{
    public function loginAction(){
        $res = $this->model->authorization($_POST['login_username'], $_POST['login_password']);
        if (!empty($res)) {
            $_SESSION['authorization']['login'] = $res['login'];
            $_SESSION['authorization']['token'] = 'qwerqrq';
            $_SESSION['authorization']['admin'] = $res['admin'];
        }
        //$this->view->redirect('/');
        $this->view->render('Login', ['res' => $res]);
    }

    public function logoutAction(){
        $_SESSION['authorization'] = [];
        unset($_SESSION['authorization']);
        $this->view->redirect('/');
    }

    public function registerAction(){
        $this->view->render('Register account');
    }
}