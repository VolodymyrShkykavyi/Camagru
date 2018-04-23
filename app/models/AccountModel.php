<?php

namespace app\models;

use app\core\Model;

class AccountModel extends Model
{
    public function authorization($login, $pswd)
    {
        $params = [
            'login' => trim($login),
            'passw' => $pswd,
        ];
        $res = $this->db->query('SELECT * FROM users WHERE login= :login AND passw= :passw', $params);
        if (!empty($res)){
            return $res[0];
        }
        return $res;
    }
}