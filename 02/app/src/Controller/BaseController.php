<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

abstract class BaseController
{
	protected $container;

	public function __construct(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function action(Request $request, Response $response, $args): Response
	{
		$method = mb_strtolower($request->getMethod());
var_dump($method);exit();
		if (!method_exists($this, $method))
		{
			return $this->error($request, $response, $args);
		}

		return $this->$method($request, $response, $args);
	}

	public function error(Request $request, Response $response, $args): Response
	{
		$response->withStatus(404);
		$response->getBody()->write('Error 404');
		return $response;
	}
}