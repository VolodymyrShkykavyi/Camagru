<?php

namespace app\models;

use app\core\Model;

class GalleryModel extends Model
{
	public function getImages($limits)
	{
		if (!isset($limits['start']) || !isset($limits['offset'])
			|| !is_numeric($limits['start']) || !is_numeric($limits['offset']) ||
			$limits['offset'] <= 0 || $limits['start'] < 0){
			return (array());
		}

		$sql = "SELECT * FROM `gallery`
 				LEFT JOIN (
 					SELECT `imageId`, COUNT(`imageId`) AS `likes_count` FROM `likes` GROUP BY `imageId`
 				) AS `t_likes` ON `t_likes`.`imageId` = `gallery`.`id`
 				JOIN (
 					SELECT `id` AS `userId`, `login` FROM `users`
 				) AS `t_users` ON `gallery`.`userId` = `t_users`.`userId`
 				ORDER BY `gallery`.`date` DESC
 				LIMIT {$limits['start']}, {$limits['offset']};";
		$res = $this->db->query_fetched($sql, $limits);
		return ($res);
	}

	public function getImagesCount()
	{
		$res = $this->db->query_fetched('SELECT COUNT(*) AS `count` FROM `gallery`;');
		return($res[0]['count']);
	}

	public function getUploadsCount($id)
	{
		if (!is_numeric($id) || $id <= 0){
			return (array());
		}
		$res = $this->db->query_fetched('SELECT COUNT(*) AS `count` FROM `gallery` WHERE `userId` = :id;', ['id' => $id]);
		return($res[0]['count']);
	}

	public function saveImage($data)
	{
		if (empty($data) || !isset($data['userId']) || !isset($data['src'])){
			return (false);
		}
		$id = $this->db->query_insert('INSERT INTO `gallery` (`userId`, `src`) VALUES (:userId, :src);', $data);
		return ($id);
	}

	public function getUserImages($id, $limits)
	{
		if (!is_numeric($id) || $id <= 0){
			return (array());
		}
		if (!isset($limits['start']) || !isset($limits['offset'])
			|| !is_numeric($limits['start']) || !is_numeric($limits['offset']) ||
			$limits['offset'] <= 0 || $limits['start'] < 0){
			return (array());
		}
		$res = $this->db->query_fetched("SELECT * FROM `gallery` WHERE `userId` = :id ORDER BY `date` DESC 
										LIMIT {$limits['start']}, {$limits['offset']};",
			['id' => $id]);
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
		$this->db->query('DELETE FROM `likes` WHERE `imageId` = :id', ['id' => $data['imageId']]);
		$this->db->query('DELETE FROM `comments` WHERE `imageId` = :id', ['id' => $data['imageId']]);
		return ($img[0]['src']);
	}

	public function addLike($data)
	{
		if (!$data || !isset($data['imageId']) || !isset($data['userId'])){
			return (false);
		}
		if (!empty(
			$this->db->query_fetched(
				'SELECT * FROM `likes` WHERE `userId` = :userId AND `imageId` = :imageId;',
				$data))){
			return (true);
		}
		$this->db->query(
			'INSERT INTO `likes` (`userId`, `imageId`) VALUES (:userId, :imageId);',
			$data);
		return (true);
	}

	public function delLike($data)
	{
		if (!$data || !isset($data['imageId']) || !isset($data['userId'])){
			return (false);
		}
		if (empty(
		$this->db->query_fetched(
			'SELECT * FROM `likes` WHERE `userId` = :userId AND `imageId` = :imageId;',
			$data))){
			return (true);
		}
		$this->db->query(
			'DELETE FROM `likes` WHERE `userId` = :userId AND `imageId` = :imageId;',
			$data);
		return (true);
	}

	public function isImageLiked($data)
	{
		if (empty($data) || !isset($data['userId']) || !isset($data['imageId']) ||
			!is_numeric($data['userId']) || !is_numeric($data['imageId'])){
			return (false);
		}
		$res = $this->db->query_fetched(
			'SELECT * FROM `likes` WHERE `userId` = :userId AND `imageId` = :imageId;',
			$data);
		if (!empty($res)){
			return (true);
		}
		return (false);
	}

	public function getCommentsAll($imageId)
	{
		if (!is_numeric($imageId)){
			return (array());
		}
		$res = $this->db->query_fetched(
			'SELECT * FROM `comments` JOIN (
					SELECT `login`, `id` FROM `users`
				  ) AS `t_user` ON `t_user`.`id` = `userId`
				   WHERE `imageId` = :id;',
			['id' => $imageId]);
		return ($res);
	}

	public function getComments($imageId, $num)
	{
		if (!is_numeric($imageId) || !is_numeric($num) || $num < 1){
			return (array());
		}
		$res = $this->db->query_fetched(
			"SELECT * FROM `comments` JOIN (
					SELECT `login`, `id` FROM `users`
				  ) AS `t_user` ON `t_user`.`id` = `userId`
				   WHERE `imageId` = :id ORDER BY `date` DESC LIMIT {$num};",
			['id' => $imageId]);
		return (array_reverse($res));
	}

	public function addComment($data)
	{
		if (!isset($data['userId']) || !isset($data['imageId']) || !isset($data['comment'])
			|| !is_numeric($data['userId']) || !is_numeric($data['imageId']) ||
			empty(trim($data['comment']))){
			return (false);
		}
		$data['comment'] = preg_replace('/\s+/', ' ', trim($data['comment']));
		$res = $this->db->query_insert('INSERT INTO `comments` (`userId`, `imageId`, `text`) 
										VALUES (:userId, :imageId, :comment);', $data);
		return ($res);
	}
}