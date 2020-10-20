<?php
namespace App;

use App\Exception;

class Db
{
	private static $instance;

	private $dsn;
	private $username;
	private $password;

	private $connect;

	/**
	 * @return static
	 */
	public static function getInstance(): self
	{
		if (!self::$instance)
		{
			self::$instance  = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{

	}

	/**
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @return $this
	 */
	public function configure(string $dsn, string $username, string $password): self
	{
		$this->dsn 		= $dsn;
		$this->username = $username;
		$this->password = $password;
		return $this;
	}

	/**
	 * @param string $sql
	 * @param array $values
	 * @return bool
	 * @throws Exception\DbConfigException
	 * @throws Exception\DbException
	 */
	public function query(string $sql, array $values = [])
	{
		try
		{
			$state = $this->getConnect()->prepare($sql);
			$res = $state->execute($values);
		}
		catch (\PDOException $e)
		{
			throw new Exception\DbException($e->getMessage());
		}
		catch(Exception\DbException $e)
		{
			throw $e;
		}

		return $res;
	}

	/**
	 * @return \PDO|null
	 * @throws Exception\DbConfigException
	 */
	private function getConnect(): ?\PDO
	{
		if (!$this->dsn)
		{
			throw new Exception\DbConfigException();
		}

		if (!$this->connect)
		{
			try
			{
				$this->connect = new \PDO(
					$this->dsn,
					$this->username,
					$this->password
				);
				$this->connect->exec("set names utf8");
			}
			catch (\PDOException $e)
			{
				throw new Exception\DbException($e->getMessage());
			}
		}
		return $this->connect;
	}

}