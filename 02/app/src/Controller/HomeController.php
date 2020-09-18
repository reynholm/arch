<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
	public function get(Request $request, Response $response, $args)
	{
		$response->getBody()->write('home');
		return $response;
	}
}