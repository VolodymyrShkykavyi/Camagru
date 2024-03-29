<?php

namespace app\models;

use app\core\Model;

class AccountModel extends Model
{
	public function authorization($login, $pswd)
	{
		$params = [
			'login' => htmlspecialchars(trim($login)),
			'passw' => hash('whirlpool', $pswd),
		];
		$res = $this->db->query_fetched('SELECT * FROM users WHERE `login` = :login AND `passw` = :passw', $params);
		if (!empty($res)) {
			return $res[0];
		}
		return $res;
	}

	public function registration($arr)
	{
		$pattern_email = '@\A[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\z@';
		if (empty($arr)) {
			return (false);
		}
		if (!isset($arr['login']) || empty($arr['login']) ||
			!isset($arr['password']) || empty($arr['password']) || strlen($arr['password']) < 6 ||
			!isset($arr['email']) || !preg_match($pattern_email, $arr['email'])) {
			return (false);
		}
		$arr['login'] = htmlspecialchars(trim($arr['login']));
		if (empty($arr['login'])) {
			return (false);
		}
		$arr['password'] = hash('whirlpool', $arr['password']);
		$params = [
			'login' => $arr['login'],
			'email' => $arr['email']
		];
		$res_check = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login OR `email` = :email;', $params);
		if (!empty($res_check)) {
			return (false);
		}
		$params['password'] = $arr['password'];
		if (!($this->db->query('INSERT INTO `users` (`login`, `passw`, `email`) VALUES (:login, :password, :email);', $params))) {
			return (false);
		}
		return (true);
	}

	public function verify($login)
	{
		$params = [
			'login' => htmlspecialchars(trim($login))
		];
		$this->db->query('UPDATE `users` SET `verified` = 1 WHERE `login` = :login;', $params);
	}

	public function isVerified($login)
	{
		$params = [
			'login' => htmlspecialchars(trim($login))
		];
		$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login;', $params);
		if (!empty($res) && $res[0]['verified']) {
			return (true);
		}
		return (false);
	}

	public function getUserEmail($login)
	{
		$params = [
			'login' => htmlspecialchars(trim($login))
		];
		$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login;', $params);
		if (!empty($res)) {
			return ($res[0]['email']);
		}
		return (false);
	}

	public function getUserId($login)
	{
		$params = [
			'login' => htmlspecialchars(trim($login))
		];
		$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login;', $params);
		if (!empty($res)) {
			return ($res[0]['id']);
		}
		return (false);
	}

	public function validLoginEmail($arr)
	{
		if (isset($arr['login'])) {
			$params = [
				'login' => htmlspecialchars(trim($arr['login']))
			];
			$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login', $params);
			if (!empty($res)) {
				return (false);
			}
			return (true);
		} elseif (isset($arr['email'])) {
			$params = [
				'email' => $arr['email']
			];
			$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `email` = :email', $params);
			if (!empty($res)) {
				return (false);
			}
			return (true);
		}
		return (false);
	}

	public function updateLogin($data)
	{
		if (empty($data) || !isset($data['login']) || !isset($data['newLogin'])
			|| !isset($data['password'])) {
			return (false);
		}
		$data['login'] = trim($data['login']);
		if (empty($this->authorization($data['login'], $data['password']))) {
			return (false);
		}
		$this->db->query('UPDATE `users` SET `login` = :newLogin WHERE `login` = :login', [
			'login' => htmlspecialchars($data['login']),
			'newLogin' => $data['newLogin']
		]);
		if (empty($this->authorization($data['newLogin'], $data['password']))) {
			return (false);
		}
		return (true);
	}

	public function updateEmail($data)
	{
		if (empty($data) || !isset($data['login']) || !isset($data['newEmail'])
			|| !isset($data['password'])) {
			return (false);
		}
		$data['login'] = trim($data['login']);
		if (empty($this->authorization($data['login'], $data['password']))) {
			return (false);
		}

		if (!$this->validLoginEmail([
			'email' => $data['newEmail']
		])) {
			return (false);
		}
		$this->db->query('UPDATE `users` SET `email` = :newEmail WHERE `login` = :login;', [
			'newEmail' => $data['newEmail'],
			'login' => $data['login']
		]);
		if (!$this->validLoginEmail([
			'email' => $data['newEmail']
		])) {
			return (true);
		}
		return (false);
	}

	public function updatePassword($data)
	{
		if (empty($data) || !isset($data['login']) || !isset($data['currentPassword']) ||
			!isset($data['newPassword'])) {
			return (false);
		}
		if (empty($this->authorization($data['login'], $data['currentPassword']))) {
			return (false);
		}
		$this->db->query('UPDATE `users` SET `passw` = :newPassword WHERE `login` = :login;', [
			'newPassword' => hash('whirlpool', $data['newPassword']),
			'login' => $data['login']
		]);
		if (empty($this->authorization($data['login'], $data['newPassword']))) {
			return (false);
		}
		return (true);
	}

	public function getUserSettings($id)
	{
		if (!$id || !is_numeric($id) || $id <= 0) {
			return (array());
		}
		$res = $this->db->query_fetched('SELECT * FROM `settings` WHERE `userId` = :id', ['id' => $id]);
		if (!empty($res)) {
			return ($res[0]);
		}
		return ($res);
	}

	public function updateUserSettings($data)
	{
		if (empty($data) || !isset($data['notifyLike']) ||
			!isset($data['notifyComment']) || !isset($data['userId'])
			|| !is_numeric($data['userId'])) {
			return (false);
		}
		$this->db->query('UPDATE `settings` SET `mailComment` = :notifyComment,
						`mailLike` = :notifyLike WHERE `userId` = :userId', [
			'notifyLike' => $data['notifyLike'],
			'notifyComment' => $data['notifyComment'],
			'userId' => $data['userId']
		]);
		return (true);
	}

	public function addUserSettings($data)
	{
		if (empty($data) || !isset($data['notifyLike']) ||
			!isset($data['notifyComment']) || !isset($data['userId'])
			|| !is_numeric($data['userId']) || $data['userId'] <= 0) {
			return (false);
		}
		if (!empty($this->getUserSettings($data['userId']))) {
			return (false);
		}
		$res = $this->db->query_insert('INSERT INTO `settings` (`userId`, `mailComment`, `mailLike`) VALUES 
								(:userId, :notifyComment, :notifyLike);', [
			'userId' => $data['userId'],
			'notifyComment' => $data['notifyComment'],
			'notifyLike' => $data['notifyLike']
		]);
		if ($res) {
			return (true);
		}
		return (false);
	}

	public function resetUserPassword($data)
	{
		if (empty($data) || !isset($data['login']) || !isset($data['newPassword'])){
			return (false);
		}
		if (!$this->getUserId($data['login'])){
			return (false);
		}
		$data['newPassword'] = hash('whirlpool', $data['newPassword']);
		$this->db->query('UPDATE `users` SET `passw` = :newPassword WHERE `login` = :login', [
			'login' => $data['login'],
			'newPassword' => $data['newPassword']
		]);
		return (true);
	}
}