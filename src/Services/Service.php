<?php

namespace App\Services;

abstract class Service
{
	protected $repository;

	public function __construct($repository)
	{
		$this->repository = $repository;
	}

}
