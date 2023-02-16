<?php

namespace App\Services;

abstract class Service
{

	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	abstract public function findOne($condition);
	abstract public function find($condition);

}
