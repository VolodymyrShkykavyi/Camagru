<?php

namespace app\lib;

use app\core\View;
use PDO;
use PDOException;

class Db
{
    protected $db;

    public function __construct()
    {
        require_once (ROOT . '/config/database.php');
        try {
            $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $err){
            echo 'Can\'t connect to Database';
            View::errorCode(503);
            exit;
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)){
            foreach ($params as $key => $value){
                $stmt->bindValue(':' . $key, $value);
            }
        }
        if (!$stmt->execute()){
        	return (false);
		}
        return ($stmt);
	}

	public function query_insert($sql, $params = [])
	{
		if (!$this->query($sql, $params)){
			return (false);
		}
		return ($this->db->lastInsertId());
	}

    public function query_fetched($sql, $params = []){
    	if (($stmt = $this->query($sql, $params))) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return ($result);
		}
		return (array());
	}
}