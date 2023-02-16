<?php

namespace App\Repository;

use App\Entity\PartEntity;

class PartRepository extends Repository
{
	public function findAll()
	{
		$sql = 'SELECT * FROM part';
		$res = $this->db->query($sql, [], PartEntity::class);
		return !empty($res) ? $res : null;
	}
}
