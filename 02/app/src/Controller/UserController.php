<?php

namespace App\Controller;

use App\Exception\BaseAppException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends BaseController
{
	/* @var \App\User $userService */
	private $userService;

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		$this->userService = new \App\User($this->container->get('db'));
	}

	public function get(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		if (!isset($args['userId']) || !$args['userId'])
		{
			return $this->error($request, $response, $args);
		}

		try
		{
			$user = $this->userService->get((int) $args['userId']);
		}
		catch (BaseAppException $e)
		{
			return $this->error($request, $response, $args);
		}

		return $response;
	}

	public function post(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		return $response;
	}

	public function put(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		return $response;
	}

	public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		return $response;
	}
}