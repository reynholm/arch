<?php

namespace App\Controller;

use App\Exception\BaseAppException;
use App\Exception\UserNotFoundException;
use App\Exception\UserValidateException;
use Fig\Http\Message\StatusCodeInterface;
use App\User;

class UserController extends BaseController
{
	/**
	 * @param array $args
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \App\Exception\DbConfigException
	 */
	public function get(array $args)
	{
		if (!isset($args['userId']) || !$args['userId'])
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		try
		{
			$user = (new User($this->container->get('db')))->load((int) $args['userId']);
			if (!$user)
			{
				return $this->message(StatusCodeInterface::STATUS_NOT_FOUND);
			}

			$this->response->getBody()->write($user->toJson());
		}
		catch (BaseAppException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
		}

		return $this->response;
	}

	/**
	 * @param array $args
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \App\Exception\DbConfigException
	 */
	public function post(array $args)
	{
		$data = $this->request->getParsedBody();
		if (empty($data))
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		try
		{
			$user = (new User($this->container->get('db')))->fill($data);
			$user->save();
			$this->response->getBody()->write($user->toJson());
		}
		catch (UserValidateException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}
		catch(BaseAppException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
		}

		return $this->response;
	}

	/**
	 * @param array $args
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \App\Exception\DbConfigException
	 */
	public function put(array $args)
	{
		if (!isset($args['userId']) || !$args['userId'])
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		$data = $this->request->getParsedBody() ?? $this->request->getQueryParams();
		if (empty($data))
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		try
		{
			$user = (new User($this->container->get('db')))
				->load((int) $args['userId'])
				->fill($data)
				->save();
			$this->response->getBody()->write($user->toJson());
		}
		catch (UserNotFoundException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_NOT_FOUND);
		}
		catch (UserValidateException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}
		catch(BaseAppException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
		}

		return $this->response;
	}

	/**
	 * @param $args
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function delete($args)
	{
		if (!isset($args['userId']) || !$args['userId'])
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		try
		{
			(new User($this->container->get('db')))->delete((int) $args['userId']);
		}
		catch (BaseAppException $e)
		{
			return $this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, $e->getMessage());
		}

		return $this->message(StatusCodeInterface::STATUS_NO_CONTENT);
	}
}