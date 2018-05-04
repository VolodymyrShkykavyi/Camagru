<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;

class MontageController extends Controller
{
	public function __construct($route)
	{
		parent::__construct($route);
		if (!AccountController::checkUserToken()) {
			View::redirect('/');
			exit(0);
		}
	}

	public function indexAction()
	{
		if (AccountController::checkUserToken()) {
			$this->model = $this->loadModel('Gallery');
			$this->ViewData['thumbnails'] = $this->model->getUserImagesAll($_SESSION['authorization']['id']);
			$decorations = glob('public/gallery/decorations/*.{png,jpeg,jpg}', GLOB_BRACE);
			foreach ($decorations as &$value){
				$value = '/' . $value;
			}
			$this->ViewData['decorations'] = $decorations;
			$this->view->render('Montage photo', $this->ViewData);
		} else {
			View::redirect('/');
		}
	}

	/**
	 * function get data in base64 string for two layers
	 */
	public function uploadAction()
	{
		if (!isset($_POST['layer1']) || !isset($_POST['layer2']) ||
			empty($_POST['layer1']) || empty($_POST['layer2'])) {
			echo 'ERROR';
			return;
		}
		$data1 = base64_decode(explode(',', $_POST['layer1'])[1]);
		$data2 = base64_decode(explode(',', $_POST['layer2'])[1]);
		if (!$data1 || !$data2) {
			echo 'ERROR';
			return;
		}
		$destImg = imagecreatefromstring($data1);
		$srcImg = imagecreatefromstring($data2);
		imagesavealpha($destImg, true);
		imagesavealpha($srcImg, true);
		$width = imagesx($destImg);
		$height = imagesy($destImg);

		imagecopy($destImg, $srcImg, 0, 0, 0, 0, $width, $height);
		header('Content-Type: image/gif');
		$path = '/public/gallery/' . time() . $_SESSION['authorization']['login'] . '.png';

		//save image
		if (imagepng($destImg, ROOT . $path)) {
			$this->model = $this->loadModel('Gallery');
			if (!($id = $this->model->saveImage([
				'userId' => $_SESSION['authorization']['id'],
				'src' => $path
				]))){
				unlink(ROOT . $path);
				echo 'ERROR';
			}
			echo json_encode(['id' => $id, 'src' => $path], JSON_UNESCAPED_SLASHES);
		}
		else{
			echo 'ERROR';
		}
	}
}