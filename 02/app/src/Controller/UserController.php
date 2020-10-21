<?php

namespace App\Controller;

use App\Exception\BaseAppException;
use App\Exception\UserValidateException;
use Fig\Http\Message\StatusCodeInterface;
use App\User;

class UserController extends BaseController
{
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
			return $this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
		}

		return $this->response;
	}

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
			$this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}
		catch(BaseAppException $e)
		{
			$this->message(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
		}

		return $this->response;
	}

	public function put(array $args)
	{
		return $this->response;
	}

	public function delete($args)
	{
		if (!isset($args['userId']) || !$args['userId'])
		{
			return $this->message(StatusCodeInterface::STATUS_BAD_REQUEST);
		}

		return $this->response;
	}
}