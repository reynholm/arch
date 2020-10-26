<?php

use App\Db;

$basedir = dirname(__DIR__);

require_once  $basedir.'/vendor/autoload.php';

$config = require_once($basedir.'/config.php');
$db = Db::getInstance()->configure($config['db']['dsn'], $config['db']['username'], $config['db']['password']);

$sql = "
	CREATE TABLE `users` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `username` varchar(255) NOT NULL DEFAULT '',
	  `firstName` varchar(255) NOT NULL DEFAULT '',
	  `lastName` varchar(255) NOT NULL DEFAULT '',
	  `email` varchar(255) NOT NULL DEFAULT '',
	  `phone` varchar(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$db->query($sql);