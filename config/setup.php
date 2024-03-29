<?php
use app\lib\Db;

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once ('../app/lib/Db.php');
$db = new Db('mysql:host=localhost', 'root', '1234567890');

if (empty($db->query_fetched('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = \'camagru\'')))
{
	$db->query('CREATE DATABASE camagru');
	$db = new Db();

	$db->query('CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passw` text NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT \'0\',
  `admin` tinyint(1) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
);');

	$db->query('CREATE TABLE IF NOT EXISTS `gallery` (
	`id` int NOT NULL AUTO_INCREMENT,
	`userId` int NOT NULL,
	`src` TEXT NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY (`id`)
);');

	$db->query('CREATE TABLE IF NOT EXISTS `likes` (
	`userId` int NOT NULL,
	`imageId` int NOT NULL
);');

	$db->query('CREATE TABLE IF NOT EXISTS `comments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`userId` int NOT NULL,
	`imageId` int NOT NULL,
	`text` TEXT NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY (`id`)
);');

	$db->query('CREATE TABLE IF NOT EXISTS `settings` (
	`id` int NOT NULL AUTO_INCREMENT,
	`userId` INT NOT NULL UNIQUE , 
	`mailComment` tinyint(1),
	`mailLike` tinyint(1),
	PRIMARY KEY (`id`)
);');

	$db->query('INSERT INTO `users` (`login`, `email`, `passw`, `verified`, `admin`) VALUES
(\'admin\', \'email@email.com\', \'' . hash('whirlpool', '12345') . '\', 1, 1),
(\'user\', \'usermail@mail.com\', \''. hash('whirlpool', '12345') . '\', 1, 0)
;');

}

header("Location: http://{$_SERVER['HTTP_HOST']}/index.php");
