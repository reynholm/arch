<?php
namespace App;

class User
{
	private $db;

	/**
	 * User constructor.
	 * @param Db $db
	 */
	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	/**
	 * @param int $id
	 * @return UserModel
	 */
	public function get(int $id): UserModel
	{

	}

	/**
	 * @param UserModel $model
	 * @return UserModel
	 */
	public function save(UserModel $model): UserModel
	{
		$model->validate();

		if ($model->id)
		{
			// update
		}
		else
		{
			// add
		}
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function delete(int $id): bool
	{

	}
}