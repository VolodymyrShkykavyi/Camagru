<?php

namespace app\models;

use app\core\Model;

class MainModel extends Model
{
    public function getNews()
    {
       $res = $this->db->query_fetched('SELECT * FROM users');
        return $res;
    }
}