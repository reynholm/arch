<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage tasks
 * @copyright 2001-2021 Bitrix
 */

namespace App;


use App\Exception\DbException;
use App\Exception\UserNotFoundException;
use App\Exception\UserSetException;
use App\Exception\UserValidateException;

class User
{
	private $db;

	public $id;
	public $username 	= '';
	public $lastName 	= '';
	public $firstName 	= '';
	public $email 		= '';
	public $phone 		= '';

	/**
	 * @return string
	 */
	public static function getTableName(): string
	{
		return 'user';
	}

	/**
	 * User constructor.
	 * @param Db $db
	 */
	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function fill(array $data): self
	{
		$props = $this->getProps();

		foreach ($props as $prop)
		{
			if ($prop->name === 'id')
			{
				continue;
			}
			if (array_key_exists($prop->name, $data))
			{
				$this->{$prop->name} = $data[$prop->name];
			}
		}

		return $this;
	}

	/**
	 * @param int $id
	 * @return $this
	 * @throws DbException
	 * @throws Exception\DbConfigException
	 * @throws UserNotFoundException
	 */
	public function load(int $id): self
	{
		$sql = "SELECT * FROM `". self::getTableName() ."` WHERE id = :id";
		$res = $this->db->query($sql, [':id' => $id]);
		if (!$res->rowCount())
		{
			throw new UserNotFoundException();
		}

		$user = $res->fetchObject();

		$this->id 			= $user->id;
		$this->username 	= $user->username;
		$this->firstName 	= $user->firstName;
		$this->lastName 	= $user->lastName;
		$this->email 		= $user->email;
		$this->phone 		= $user->phone;

		return $this;
	}

	/**
	 * @param bool $validate
	 * @return $this
	 * @throws DbException
	 * @throws Exception\DbConfigException
	 * @throws UserValidateException
	 */
	public function save(bool $validate = true): self
	{
		if ($validate)
		{
			$this->validate();
		}

		$values = [
			':username' 	=> $this->username,
			':firstName' 	=> $this->firstName,
			':lastName' 	=> $this->lastName,
			':email' 		=> $this->email,
			':phone' 		=> $this->phone,
		];

		if (!$this->id)
		{
			$sql = "
				INSERT INTO `". self::getTableName() ."`
				(`username`, `firstName`, `lastName`, `email`, `phone`)
				VALUES
				(:username, :firstName, :lastName, :email, :phone)
			";
		}
		else
		{
			$sql = "
				UPDATE `". self::getTableName() ."`
				SET
					`username` 		= :username,
					`firstName` 	= :firstName,
					`lastName` 		= :lastName,
					`email` 		= :email,
					`phone` 		= :phone
				WHERE `id` = :id
			";

			$values[':id'] = $this->id;
		}

		$this->db->query($sql, $values);
		$id = $this->id ?? $this->db->getLastInsertId();
		if (!$id)
		{
			throw new DbException();
		}

		$this->id = $id;

		return $this;
	}

	/**
	 * @param int $id
	 * @throws DbException
	 * @throws Exception\DbConfigException
	 */
	public function delete(int $id)
	{
		$sql = "DELETE FROM `". self::getTableName() ."` WHERE id = :id";
		$this->db->query($sql, [':id' => $id]);
	}

	/**
	 * @return string
	 */
	public function toJson(): string
	{
		$props = $this->getProps();

		$data = [];
		foreach ($props as $prop)
		{
			$data[$prop->name] = $this->{$prop->name};
		}

		$data = json_encode($data);

		if ($data === false)
		{
			throw new UserSetException();
		}

		return $data;
	}

	/**
	 * @return bool
	 * @throws UserValidateException
	 *
	 * Stub. Implementation required.
	 */
	private function validate(): bool
	{
		if (1 === 0)
		{
			throw new UserValidateException();
		}
		return true;
	}

	/**
	 * @return array
	 */
	private function getProps(): array
	{
		$reflect = new \ReflectionClass(self::class);
		return $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
	}
}