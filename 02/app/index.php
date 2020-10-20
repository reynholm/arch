<?php

use Slim\Factory\AppFactory;
use App\Db;

require_once  dirname(__FILE__).'/vendor/autoload.php';

/* Config && DB connect */
$config = require_once(dirname(__FILE__).'/config.php');
$db = Db::getInstance()->configure($config['db']['dsn'], $config['db']['username'], $config['db']['password']);

/* Container */
$container = new \DI\Container();
$container->set('db', $db);

/* Slim App */
AppFactory::setContainer($container);
$app = AppFactory::create();

/* Routes */
$app->any('/', App\Controller\HomeController::class);
$app->any('/health', App\Controller\HealthController::class);
$app->any('/user/[{userId}]', App\Controller\UserController::class);

/* ARRRGH! */
$app->run();