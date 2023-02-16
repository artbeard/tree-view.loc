<?php

namespace App\Controller;


class Auth  extends Controller
{
	use SecureTrait;

	public function action_login()
	{
		return $this->render('tmpl/auth.html.php', [
			'title' => 'Авторизуйтесь для продолжения'
		]);
	}

	public function action_authenticate()
	{
		$dataAuth = $this->request->getBody();
		if ($dataAuth['login'] == 'admin' && $dataAuth['password'] == 'admin')
		{
			$this->setAuthCoolie();
			return $this->renderJson([], 204);
		}

		return $this->renderJson([
			'message' => 'Неверный логин или пароль'
		], 401);
	}


	public function action_logout()
	{
		$this->removeAuthCoolie();
		return $this->redirect('/');
	}
}
