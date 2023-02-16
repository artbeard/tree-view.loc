<?php

namespace App\Repository;

use App\Entity\UserEntity;

class UserRepository extends Repository
{
	public function findByLogin($login)
	{
		$sql = 'SELECT * FROM user WHERE login=:login';
		$res = $this->db->query($sql, [':login' => $login], UserEntity::class);
		return !empty($res) ? $res[0] : null;
	}

	public function createUser($login, $password)
	{
		$sql = 'INSERT INTO user (login, password) VALUES (:login, :password)';
		return $this->db->query($sql, [':login' => $login, ':password' =>$password]);
	}
}
