<?php

namespace app\models;

use app\core\Model;

class GalleryModel extends Model
{
	public function getAllImages()
	{
		$res = $this->db->query_fetched('SELECT * FROM `gallery`;');
		return ($res);
	}
}