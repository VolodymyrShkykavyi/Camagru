<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Mail;
use app\lib\Pagination;

class GalleryController extends Controller
{
	private $pagination;
	
	public function indexAction()
	{
		$itemsPerPage = 5;

		$this->pagination = new Pagination([
			'itemsTotal' => $this->model->getImagesCount(),
			'itemsPerPage' => $itemsPerPage
		]);

		//if request page number too big redirect to last page
		if ($this->pagination->getRedirect()){
			View::redirect(array_reverse($this->pagination->getPagination())[1]['href']);
		}
		$images = $this->model->getImages([
			'start' => ($this->pagination->getCurrentPage() - 1) * $itemsPerPage,
			'offset' => $itemsPerPage
		]);
		$signed = AccountController::checkUserToken();
		foreach ($images as &$img) {
			if ($signed) {
				if (!empty($this->model->isImageLiked([
					'userId' => $_SESSION['authorization']['id'],
					'imageId' => $img['id']
				]))) {
					$img['liked'] = true;
				}
			}
			$img['comments'] = $this->model->getComments($img['id'], 3);
		}
		$this->ViewData['images'] = $images;
		$this->ViewData['pagination'] = $this->pagination->getPagination();
		$this->view->render('Gallery', $this->ViewData);
	}

	public function uploadAction()
	{
		$itemsPerPage = 6;
		if (AccountController::checkUserToken()) {
			if (!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
				if (is_uploaded_file($_FILES['image']['tmp_name'])) {
					try {
						$size = getimagesize($_FILES['image']['tmp_name']);
						$path = '/public/gallery/' . time() . $_SESSION['authorization']['login'] . '.png';
						if (!$size) {
							throw new \Exception("Wrong file format");
						}
						if ($_FILES['image']['size'] > 2000000) {
							throw new \Exception("Too large file");
						}
						if ($size['mime'] != 'image/jpeg' && $size['mime'] != 'image/jpg' &&
							$size['mime'] != 'image/png' && $size['mime'] != 'image/gif') {
							throw new \Exception("Wrong file extension. Only JPG, JPEG, PNG and GIF formats are allowed.");
						}
						if (!($id = $this->model->saveImage([
							'userId' => $_SESSION['authorization']['id'],
							'src' => $path
						]))) {
							throw new \Exception("Server error. Please try again later.");
						}
						move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path);
					} catch (\Exception $e) {
						$this->ViewData['errors'] = $e->getMessage();
					}
					unset($_FILES['image']);
				}
			}
			$this->pagination = new Pagination([
				'itemsTotal' => $this->model->getUploadsCount($_SESSION['authorization']['id']),
				'itemsPerPage' => $itemsPerPage
			]);

			//if request page number too big redirect to last page
			if ($this->pagination->getRedirect()){
				View::redirect(array_reverse($this->pagination->getPagination())[1]['href']);
			}
			$this->ViewData['pagination'] = $this->pagination->getPagination();
			$this->ViewData['userImg'] = $this->model->getUserImages(
				$_SESSION['authorization']['id'],
				[
					'start' => ($this->pagination->getCurrentPage() - 1) * $itemsPerPage,
					'offset' => $itemsPerPage
				]);
			$this->view->render('Upload photos', $this->ViewData);
		} else {
			View::redirect('/gallery');
		}
	}

	public function imageAction()
	{
		if (isset($this->route['params'])) {
			$this->ViewData['image'] = $this->model->getImage($this->route['params'][0]);
			if (AccountController::checkUserToken()){
				if (!empty($this->model->isImageLiked([
					'userId' => $_SESSION['authorization']['id'],
					'imageId' => $this->route['params'][0]
				]))) {
					$this->ViewData['image']['liked'] = true;
				}
			}
			$this->ViewData['comments'] = $this->model->getCommentsAll($this->route['params'][0]);
			$this->view->render('Gallery', $this->ViewData);
		} else {
			View::redirect('/gallery');
		}
	}

	public function deleteAction()
	{
		if (!AccountController::checkUserToken() || !isset($_POST['delId'])) {
			echo "ERROR";
			return;
		}
		if ($src = $this->model->deleteImage(['imageId' => $_POST['delId'], 'userId' => $_SESSION['authorization']['id']])) {
			$src = ROOT . $src;
			try {
				unlink($src);
			} catch (\Exception $e) {
				echo "ERROR";
			}
			echo "OK";
		} else {
			echo "ERROR";
		}
	}

	public function changeLikeAction()
	{
		if (!AccountController::checkUserToken() ||
			!isset($_POST['imageId']) || !is_numeric($_POST['imageId'])) {
			echo "ERROR";
			return;
		}
		$data = [
			'userId' => $_SESSION['authorization']['id'],
			'imageId' => $_POST['imageId']
		];
		if (isset($_POST['addLike'])) {
			if ($this->model->addLike($data)) {
				$this->model = $this->loadModel('Account');
				$settings = $this->model->getUserSettings($_SESSION['authorization']['id']);
				if (!empty($settings) && isset($settings['mailLike']) &&
					$settings['mailLike'] == '0'){
					echo "OK";
					return;
				}
				$email = $this->model->getUserEmail($_SESSION['authorization']['login']);
				$text = 'Your image has been liked.<br>link: ' .
					$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/gallery/image/' . $_POST['imageId'];
				//TODO: maybe async?
				Mail::sendMail($email, 'Image update', $text);
			}
		} elseif (isset($_POST['delLike'])) {
			$this->model->delLike($data);
		} else {
			echo "ERROR";
			return;
		}
		echo "OK";
	}

	public function commentAddAction()
	{
		if (AccountController::checkUserToken() &&
			isset($_POST['comment']) && isset($_POST['imageId'])) {
			$id = $this->model->addComment([
				'userId' => $_SESSION['authorization']['id'],
				'imageId' => $_POST['imageId'],
				'comment' => htmlspecialchars($_POST['comment'])
			]);
			$this->model = $this->loadModel('Account');
			$settings = $this->model->getUserSettings($_SESSION['authorization']['id']);
			if (!empty($settings) && isset($settings['mailComment']) &&
				$settings['mailComment'] == '0'){
				echo $id;
				return;
			}
			$email = $this->model->getUserEmail($_SESSION['authorization']['login']);
			$text = 'Your image has been commented.<br>link: ' .
				$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/gallery/image/' . $_POST['imageId'];
			//TODO: maybe async?
			Mail::sendMail($email, 'Image update', $text);
			echo($id);
			return;
		}
		echo "ERROR";
	}

}