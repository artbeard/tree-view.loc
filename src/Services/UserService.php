<?php

namespace App\Services;

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
}
