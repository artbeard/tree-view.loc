<?php

namespace App\Db;

class Db
{
	private $dbHandler;

	public function __construct($dsn, $user, $pass)
	{
		$this->dbHandler = new \PDO($dsn, $user, $pass);
	}

	public function query($sql, array $params = [], $class = \stdClass::class)
	{
		$q = $this->dbHandler->prepare($sql);
		$q->execute($params);
		return $q->fetchAll(\PDO::FETCH_CLASS, $class);
	}
}
