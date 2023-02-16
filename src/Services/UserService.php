<?php

namespace App\Services;

use App\Entity\UserEntity;

class UserService extends Service
{
	public function checkAuth($login, $password)
	{
		$user = $this->repository->findByLogin($login);
		if (!is_null($user))
		{
			return password_verify($password, $user->password);
		}
		return false;
	}

	public function createUser(UserEntity $user)
	{
		$this->repository->createUser($user->login, password_hash($user->password, PASSWORD_BCRYPT ));
	}
}
