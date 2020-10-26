<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage tasks
 * @copyright 2001-2021 Bitrix
 */

namespace App;


use App\Exception\UserValidateException;

class UserModel
{
	public $id;
	public $username;
	public $lastName;
	public $firstName;
	public $email;
	public $phone;

	public function __construct()
	{

	}

	/**
	 * @return bool
	 * @throws UserValidateException
	 *
	 * Stub. Implementation required.
	 */
	public function validate(): bool
	{
		if (1 === 0)
		{
			throw new UserValidateException();
		}
		return true;
	}
}