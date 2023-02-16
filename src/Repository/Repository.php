<?php

namespace App\Repository;

abstract class Repository
{
	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

//	abstract public function findOne($condition);
//	abstract public function find($condition);
}
