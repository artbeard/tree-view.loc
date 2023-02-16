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

	public function createUser($login, $password)
	{
		$res = $this->db->query(
			'INSERT INTO user (login, password) VALUES (:login, :password)',
			[':login' => $login, ':password' =>$password]
		);
		return $res;
	}
}
