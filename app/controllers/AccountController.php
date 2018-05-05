<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Mail;

class  AccountController extends Controller
{
	public static function getUserToken($login)
	{
		return (hash('whirlpool', $login . 'salt123'));
	}

	public static function checkUserToken()
	{
		if (isset($_SESSION['authorization']) && isset($_SESSION['authorization']['token'])) {
			if ($_SESSION['authorization']['token'] == AccountController::getUserToken($_SESSION['authorization']['login'])) {
				return (true);
			}
		}
		return (false);
	}

	private function sendVerifyMail($login)
	{
		if (!empty($login)) {
			$email = $this->model->getUserEmail($login);
			$text = 'Follow this link:' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/account/verify?login=' .
				urlencode($login) . '&token=' .
				urlencode(hash('md5', $login . date('Y-m-d'))) .
				"<br> Good luck!";
			Mail::sendMail($email, 'account verification', $text);
		}
	}

	public function loginAction()
	{
		if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
			$res = $this->model->authorization($_POST['login_username'], $_POST['login_password']);
			if (!empty($res)) {
				$_SESSION['authorization']['id'] = $res['id'];
				$_SESSION['authorization']['login'] = $res['login'];
				$_SESSION['authorization']['token'] = AccountController::getUserToken($res['login']);
				$_SESSION['authorization']['admin'] = $res['admin'];
				$_SESSION['authorization']['verified'] = $res['verified'];
				if (!$res['verified']) {
					$this->view->redirect('/account/verify');
				}
			}
		}
		if (!empty($_SERVER['HTTP_REFERER'])) {
			$this->view->redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->view->redirect('/');
		}
	}

	public function settingsAction()
	{
		$settings = $this->model->getUserSettings($_SESSION['authorization']['id']);
		$this->ViewData['settings'] = $settings;
		$this->view->render('Account settings', $this->ViewData);
	}

	public function logoutAction()
	{
		$_SESSION['authorization'] = [];
		unset($_SESSION['authorization']);
		$this->view->redirect('/');
	}

	public function registerAction()
	{
		if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])) {
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

	public function verifyAction()
	{
		if (isset($_POST['send_mail'])) {
			if (isset($_SESSION['authorization']) && isset($_SESSION['authorization']['login'])) {
				$this->sendVerifyMail($_SESSION['authorization']['login']);
			}
			unset($_POST['sent_mail']);
		}
		if (isset($_GET['login']) && isset($_GET['token'])) {
			$token_check = hash('md5', $_GET['login'] . date('Y-m-d'));
			if ($token_check == $_GET['token']) {
				$this->model->verify($_GET['login']);
				if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])) {
					$_SESSION['authorization']['verified'] = 1;
					View::redirect('/');
				}
			}
		}
		if (isset($_SESSION['authorization']) && !$_SESSION['authorization']['verified']) {
			if ($this->model->isVerified($_SESSION['authorization']['login'])) {
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
		if (isset($_POST['login'])) {
			if ($this->model->validLoginEmail(['login' => $_POST['login']])) {
				echo 'OK';
			} else {
				echo 'ERROR';
			}
			return;
		} elseif (isset($_POST['email'])) {
			if ($this->model->validLoginEmail(['email' => $_POST['email']])) {
				echo 'OK';
			} else {
				echo 'ERROR';
			}
			return;
		}
	}

	public function modifyAction()
	{
		if (AccountController::checkUserToken()) {
			if (isset($_POST['action'])) {
				if ($_POST['action'] == 'changeLogin') {
					if (isset($_POST['newLogin']) && isset($_POST['password'])) {
						$_POST['login'] = $_SESSION['authorization']['login'];
						if ($this->model->updateLogin($_POST)) {
							$_SESSION['authorization']['login'] = htmlspecialchars(trim($_POST['newLogin']));
							$_SESSION['authorization']['token'] = AccountController::getUserToken($_SESSION['authorization']['login']);
							echo 'OK';
							return;
						}
					}
				} elseif ($_POST['action'] == 'changeEmail') {
					if (isset($_POST['newEmail']) && isset($_POST['password'])) {
						$_POST['login'] = $_SESSION['authorization']['login'];
						if ($this->model->updateEmail($_POST)) {
							echo 'OK';
							return;
						}
					}
				} elseif ($_POST['action'] == 'changePassword') {
					if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) &&
						isset($_POST['confirmPassword'])) {
						if ($_POST['newPassword'] == $_POST['confirmPassword'] &&
							strlen($_POST['newPassword']) >= 6) {
							if ($this->model->updatePassword([
								'login' => $_SESSION['authorization']['login'],
								'currentPassword' => $_POST['currentPassword'],
								'newPassword' => $_POST['newPassword']
							])) {
								echo 'OK';
								return;
							}
						}
					}
				} elseif ($_POST['action'] == 'changeNotifications'){
					if (isset($_POST['notifyLike']) && isset($_POST['notifyComment'])){
						$settings = $this->model->getUserSettings($_SESSION['authorization']['id']);
						$_POST['userId'] = $_SESSION['authorization']['id'];
						$_POST['notifyLike'] = ($_POST['notifyLike'] == '0') ? '0' : '1';
						$_POST['notifyComment'] = ($_POST['notifyComment'] == '0') ? '0' : '1';
						if (!empty($settings)) {
							if ($this->model->updateUserSettings($_POST)) {
								echo 'OK';
								return;
							}
						}
						else {
							if ($this->model->addUserSettings($_POST)) {
								echo 'OK';
								return;
							}
						}
					}
				}
			}
		}
		echo 'ERROR';
	}

	public function lostAction()
	{
		if (AccountController::checkUserToken()){
			View::redirect('/');
		}
		if (isset($_REQUEST['token']) && isset($_REQUEST['login'])){
			if ($id = $this->model->getUserId($_REQUEST['login'])) {
				$token = hash('whirlpool', AccountController::getUserToken($_REQUEST['login']) . $id);
				if ($token === $_REQUEST['token']) {
					$this->ViewData['token'] = $token;
					$this->ViewData['login'] = $_REQUEST['login'];
					if (isset($_POST['newPassword']) && isset($_POST['repeatPassword']) &&
						isset($_POST['action']) && $_POST['action'] == 'resetPassword' &&
						isset($_POST['login']) &&
						$_POST['newPassword'] === $_POST['repeatPassword'] &&
						strlen($_POST['repeatPassword']) >= 6){
						if ($this->model->resetUserPassword([
							'login' => $_POST['login'],
							'newPassword' => $_POST['newPassword']
						])) {
							$this->ViewData['result'] = 'OK';
						}
						else {
							$this->ViewData['result'] = 'ERROR';
						}
					}
				}
				else{
					$this->ViewData['token'] = false;
				}
			}
		}
		else {
			if (isset($_POST['login']) && isset($_POST['action']) &&
			$_POST['action'] == 'sendMail') {
				if ($id = $this->model->getUserId($_POST['login'])) {
					$token = hash('whirlpool', AccountController::getUserToken($_REQUEST['login']) . $id);
					$email = $this->model->getUserEmail($_POST['login']);
					$text = 'Follow <a href="' .
						$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/account/lost?login=' .
						urlencode($_POST['login']) . '&token=' . urlencode($token) .
						'">this link</a> if you want reset your current password';
					Mail::sendMail($email, 'Reset password', $text);
				}
			}
		}
		$this->view->render('Lost password?', $this->ViewData);
	}
}