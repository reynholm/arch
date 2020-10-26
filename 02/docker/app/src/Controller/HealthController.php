<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HealthController extends BaseController
{
	public function get(Request $request, Response $response, $args)
	{
		$response->getBody()->write('health');
		return $response;
	}
}