<?php

namespace app\models;

use app\core\Model;

class GalleryModel extends Model
{
	public function getAllImages()
	{
		$res = $this->db->query_fetched('SELECT * FROM `gallery` ORDER BY `date` DESC;');
		return ($res);
	}

	public function saveImage($data)
	{
		if (empty($data) || !isset($data['userId']) || !isset($data['src'])){
			return (false);
		}
		$id = $this->db->query_insert('INSERT INTO `gallery` (`userId`, `src`) VALUES (:userId, :src);', $data);
		return ($id);
	}

	public function getUserImagesAll($id)
	{
		if (!is_numeric($id) || $id <= 0){
			return (array());
		}
		$res = $this->db->query_fetched('SELECT * FROM `gallery` WHERE `userId` = :id ORDER BY `date` DESC;', ['id' => $id]);
		return ($res);
	}

	public function getImage($id)
	{
		if (!is_numeric($id) || $id <= 0){
			return (array());
		}
		$res = $this->db->query_fetched('SELECT * FROM `gallery` WHERE `id` = :id;', ['id' => $id]);
		if (!empty($res)){
			return ($res[0]);
		}
		return ($res);
	}

	public function deleteImage($data)
	{
		if (empty($data) || !isset($data['userId']) || !isset($data['imageId']) ||
			!is_numeric($data['userId']) || !is_numeric($data['imageId'])){
			return (false);
		}
		$img = $this->db->query_fetched('SELECT * FROM `gallery` WHERE `userId` = :userId AND `id` = :imageId;', $data);
		if (empty($img)){
			return (false);
		}
		$this->db->query('DELETE FROM `gallery` WHERE `id` = :id;', ['id' => $data['imageId']]);
		return ($img[0]['src']);
	}
}