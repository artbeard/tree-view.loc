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
			return password_verify($password, $user->getPassword());
		}
		return false;
	}

	public function createUser(UserEntity $user)
	{
		$this->repository->createUser($user->getLogin(), password_hash($user->getPassword(), PASSWORD_BCRYPT ));
	}
}
