<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends BaseController
{
	public function get(Request $request, Response $response, $args)
	{
		$response->getBody()->write('user');
		return $response;
	}

	public function post(Request $request, Response $response, $args)
	{
		return $response;
	}

	public function put(Request $request, Response $response, $args)
	{
		return $response;
	}

	public function delete(Request $request, Response $response, $args)
	{
		return $response;
	}
}