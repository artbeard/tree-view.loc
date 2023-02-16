<?php

namespace App\Controller;


use App\Services\UserService;

class Auth  extends Controller
{
	use SecureTrait;

	/**
	 * Вывод формы для аутентификации
	 * @return \App\Http\Response
	 */
	public function action_login()
	{
		return $this->render('tmpl/auth.html.php', [
			'title' => 'Авторизуйтесь для продолжения'
		]);
	}

	/**
	 * Аутентификация
	 * @param UserService $userService
	 * @return \App\Http\Response|mixed
	 */
	public function action_authenticate(UserService $userService)
	{
		$dataAuth = $this->request->getBody();

		if ($userService->checkAuth($dataAuth['login'], $dataAuth['password']))
		{
			$this->setAuthCoolie();
			return $this->renderJson([], 204);
		}

		return $this->renderJson([
			'message' => 'Неверный логин или пароль'
		], 401);
	}

	/**
	 * Разлогивание
	 * @return \App\Http\Response|mixed
	 */
	public function action_logout()
	{
		$this->removeAuthCoolie();
		return $this->redirect('/');
	}
}
