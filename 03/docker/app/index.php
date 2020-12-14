<?php

use Slim\Factory\AppFactory;
use App\Db;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;

require_once  dirname(__FILE__).'/vendor/autoload.php';

$startTime = microtime(true);

/* Config && DB connect */
$config = require_once(dirname(__FILE__).'/config.php');
$db = Db::getInstance()->configure($config['db']['dsn'], $config['db']['username'], $config['db']['password']);

/* Prometheus client */
$promRegistry = new CollectorRegistry(new APC());

/* Container */
$container = new \DI\Container();
$container->set('db', $db);
$container->set('promRegistry', $promRegistry);

/* Slim App */
AppFactory::setContainer($container);
$app = AppFactory::create();

/* Routes */
$app->any('/', App\Controller\HomeController::class);
$app->any('/health', App\Controller\HealthController::class);
$app->any('/user[/{userId}]', App\Controller\UserController::class);
$app->any('/metrics', App\Controller\MetricsController::class);

/* ARRRGH! */
try
{
	$app->run();

	$container->get('promRegistry')
		->getOrRegisterCounter('app', 'app_request_count', 'Request counter', ['method', 'endpoint', 'http_status'])
		->inc([$_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], http_response_code()]);

	$finishTime = microtime(true);
	$container->get('promRegistry')
		->getOrRegisterHistogram('app', 'app_request_latency_msec', 'Request latency', ['method', 'endpoint'], [1, 10, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000])
		->observe(round(($finishTime - $startTime) * 1000), [$_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]]);
}
catch (\Slim\Exception\HttpSpecializedException $e)
{
	die('OOPS');
}
