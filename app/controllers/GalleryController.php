<?php

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller
{
	private function saveImage($data)
	{
		if (AccountController::checkUserToken()) {
			$path = $_SERVER['DOCUMENT_ROOT'] . '/public/gallery/' . time() . $_SESSION['authorization']['login'] . '.jpg';
			if (file_exists($path) || empty($data)){
				return (false);
			}
			$img = str_replace('data:image/png;base64,', '', $data);
			$img = base64_decode($img);
			file_put_contents($path, $img);
			if (file_exists($path)){
				return (true);
			}
		}
		return (false);
	}

	public function indexAction()
	{
		$images = $this->model->getAllImages();
		$this->ViewData['img'] = $images;
		$this->view->render('Gallery', $this->ViewData);
	}


}