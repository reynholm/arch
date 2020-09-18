<?php

use Slim\Factory\AppFactory;

require_once  dirname(__FILE__).'/vendor/autoload.php';
require_once  dirname(__FILE__).'/config.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();

$app->any('/', App\Controller\HomeController::class . ':action');
$app->any('/health', App\Controller\HealthController::class . ':action');
$app->any('/user', App\Controller\UserController::class . ':action');


$app->run();