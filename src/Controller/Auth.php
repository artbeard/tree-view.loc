<?php

namespace App\Controller;

//use App\Interfaces\Guard;

class Auth  extends Controller
{

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
			setcookie(
				'auth',
				md5(time()),
				time() + 60 * 60
				//,'/', $_SERVER['HTTP_HOST'], false, true
			);
			return $this->renderJson([], 204);
		}

		return $this->renderJson([
			'message' => 'Неверный логин или пароль'
		], 401);
	}


	public function action_logout()
	{
		setcookie(
			'auth',
			0,
			time() - 60 * 60
		//,'/', $_SERVER['HTTP_HOST'], false, true
		);
		return $this->redirect('/');
	}
}
