<?php

namespace App\Db;

class Db
{
	private $dbHandler;

	public function __construct($dsn, $user, $pass)
	{
		$this->dbHandler = new \PDO($dsn, $user, $pass);
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @return array|false
	 */
	public function insert($sql, array $params = [])
	{
		$q = $this->dbHandler->prepare($sql);
		if ($q->execute($params))
		{
			return ['id' => $this->dbHandler->lastInsertId()];
		}
		return false;
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @return bool
	 */
	public function update($sql, array $params = [])
	{
		$q = $this->dbHandler->prepare($sql);
		return $q->execute($params);
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @return bool
	 */
	public function remove($sql, array $params = [])
	{
		$q = $this->dbHandler->prepare($sql);
		return $q->execute($params);
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @param string $class
	 * @return array|false
	 */
	public function query($sql, array $params = [], $class = \stdClass::class)
	{
		$q = $this->dbHandler->prepare($sql);
		$q->execute($params);
		return $q->fetchAll(\PDO::FETCH_CLASS, $class);
	}
}
