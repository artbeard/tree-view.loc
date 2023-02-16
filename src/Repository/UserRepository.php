<?php

namespace App\Repository;

use App\Entity\UserEntity;

class UserRepository extends Repository
{
	public function findByLogin($login)
	{
		$res = $this->db->query(
			'SELECT * FROM user WHERE login=:login',
			[':login' => $login],
			UserEntity::class
		);
		return !empty($res) ? $res[0] : null;
	}
}
