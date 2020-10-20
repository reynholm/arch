<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

abstract class BaseController
{
	protected $container;

	/**
	 * BaseController constructor.
	 * @param ContainerInterface|null $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $args
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$method = mb_strtolower($request->getMethod());

		if (!method_exists($this, $method))
		{
			return $this->error($request, $response, $args);
		}

		return $this->$method($request, $response, $args);
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param $args
	 * @return ResponseInterface
	 */
	public function error(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
	{
		$response->withStatus(404);
		$response->getBody()->write('Error 404');
		return $response;
	}
}