<?php
namespace App\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

abstract class BaseController
{
	protected $container;

	protected $request;
	protected $response;

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
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		$this->request = $request;
		$this->response = $response;

		return $this->$method($args);
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @return ResponseInterface
	 */
	protected function message(int $code = StatusCodeInterface::STATUS_OK, string $message = ''): ResponseInterface
	{
		$this->response->withStatus($code);

		$data = [
			'code' => ($code === 200) ? 0 : $code,
			'message' => $message
		];

		$this->response->getBody()->write(json_encode($data));
		return $this->response;
	}
}