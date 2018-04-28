<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class  AccountController extends Controller
{
	public static function getUserToken($login)
	{
		return (hash('whirlpool', $login . 'salt123'));
	}

	public static function checkUserToken()
	{
		if (isset($_SESSION['authorization']) && isset($_SESSION['authorization']['token'])){
			if ($_SESSION['authorization']['token'] == AccountController::getUserToken($_SESSION['authorization']['login'])){
				return (true);
			}
		}
		return (false);
	}

	public static function sendMail($email, $subject, $message)
	{
		if (empty($email) || empty($subject) || empty($message)){
			return;
		}

		$encoding = "utf-8";

		// Set preferences for Subject field
		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);

		$config = require ROOT . '/config/email.php';
		// Set mail header
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: " . $config['from_name'] . " <" . $config['from_email'] ."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

		// Send mail
		mail($email, $subject, $message, $header);
	}

	private function sendVerifyMail($login)
	{
		if (!empty($login)){
			$email = $this->model->getUserEmail($login);
			$text = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/account/verify?login=' .
				urlencode($login) . '&token=' .
				urlencode(hash('md5', $login . date('Y-m-d')));
			AccountController::sendMail($email, 'account verification', $text);
		}
	}

    public function loginAction(){
        if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
			$res = $this->model->authorization($_POST['login_username'], $_POST['login_password']);
			if (!empty($res)) {
				$_SESSION['authorization']['id'] = $res['id'];
				$_SESSION['authorization']['login'] = $res['login'];
				$_SESSION['authorization']['token'] = AccountController::getUserToken($res['login']);
				$_SESSION['authorization']['admin'] = $res['admin'];
				$_SESSION['authorization']['verified'] = $res['verified'];
				if (!$res['verified']){
					$this->view->redirect('/account/verify');
				}
			}
		}
        $this->view->redirect('/');
    }

    public function settingsAction()
	{
		$this->view->render('Account settings');
	}

    public function logoutAction(){
        $_SESSION['authorization'] = [];
        unset($_SESSION['authorization']);
        $this->view->redirect('/');
    }

    public function registerAction(){
		if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])){
			View::redirect('/');
			return;
		}
    	if (isset($_POST['register_login']) && isset($_POST['register_email']) && isset($_POST['register_password'])) {
			$data = [
				'login' => $_POST['register_login'],
				'email' => strtolower($_POST['register_email']),
				'password' => $_POST['register_password']
			];
			$res = $this->model->registration($data);
			if (!$res) {
				$this->ViewData['errors'] = 'model error';
			} else {
				$_POST['login_username'] = $_POST['register_login'];
				$_POST['login_password'] = $_POST['register_password'];
				$this->sendVerifyMail($data['login']);
				$this->loginAction();
				return;
			}
		}
        $this->view->render('Register account', $this->ViewData);
    }

	public  function verifyAction()
	{
		if (isset($_POST['send_mail'])){
			if (isset($_SESSION['authorization']) && isset($_SESSION['authorization']['login'])) {
				$this->sendVerifyMail($_SESSION['authorization']['login']);
				var_dump($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/account/verify?login=' .
					urlencode($_SESSION['authorization']['login']) . '&token=' .
					urlencode(hash('md5', $_SESSION['authorization']['login'] . date('Y-m-d'))));
			}
			unset($_POST['sent_mail']);
		}
		if (isset($_GET['login']) && isset($_GET['token'])){
			$token_check = hash('md5', urldecode($_GET['login']) . date('Y-m-d'));
			if ($token_check == urldecode($_GET['token'])){
				$this->model->verify(urldecode($_GET['login']));
				if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])){
					$_SESSION['authorization']['verified'] = 1;
				}
			}
		}
		if (isset($_SESSION['authorization']) && !$_SESSION['authorization']['verified']) {
			if ($this->model->isVerified($_SESSION['authorization']['login'])){
				$_SESSION['authorization']['verified'] = 1;
			} else {
				$this->view->render('Verify account', $this->ViewData);
				return;
			}
		}
		$this->view->redirect('/');
	}

	public function registerValidateAction()
	{
		if (isset($_POST['login'])){
			if ($this->model->validLoginEmail(['login' => $_POST['login']])){
				echo 'OK';
			}
			else{
				echo 'ERROR';
			}
			return;
		}
		elseif (isset($_POST['email'])){
			if ($this->model->validLoginEmail(['email' => $_POST['email']])){
				echo 'OK';
			}
			else{
				echo 'ERROR';
			}
			return;
		}
	}
}