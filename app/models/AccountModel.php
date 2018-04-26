<?php

namespace app\models;

use app\core\Model;

class AccountModel extends Model
{
    public function authorization($login, $pswd)
    {
        $params = [
            'login' => trim($login),
            'passw' => hash('whirlpool', $pswd),
        ];
        $res = $this->db->query_fetched('SELECT * FROM users WHERE `login` = :login AND `passw` = :passw', $params);
        if (!empty($res)){
            return $res[0];
        }
        return $res;
    }

    public function registration($arr)
	{
		$pattern_email = '@\A[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\z@';
		if (empty($arr)){
			return (false);
		}
		if (!isset($arr['login']) || empty($arr['login'])||
			!isset($arr['password']) || empty($arr['password']) || strlen($arr['password']) < 6 ||
			!isset($arr['email']) || !preg_match($pattern_email, $arr['email'])){
			return (false);
		}
		$arr['login'] = trim($arr['login']);
		$arr['password'] = hash('whirlpool', $arr['password']);
		$params = [
			'login' => $arr['login'],
			'email' => $arr['email']
		];
		$res_check = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login OR `email` = :email;', $params);
		if (!empty($res_check)){
			return (false);
		}
		$params['password'] = $arr['password'];
		if (!($this->db->query('INSERT INTO `users` (`login`, `passw`, `email`) VALUES (:login, :password, :email);', $params))){
			return (false);
		}
		return (true);
	}

	public function verify($login)
	{
		$params = [
			'login' => $login
		];
		$this->db->query('UPDATE `users` SET `verified` = 1 WHERE `login` = :login;', $params);
	}

	public function isVerified($login)
	{
		$params = [
			'login' => $login
		];
		$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login;', $params);
		if(!empty($res) && $res[0]['verified']){
			return (true);
		}
		return (false);
	}

	public function getUserEmail($login)
	{
		$params = [
			'login' => $login
		];
		$res = $this->db->query_fetched('SELECT * FROM `users` WHERE `login` = :login;', $params);
		if (!empty($res)){
			return ($res[0]['email']);
		}
		return (false);
	}
}