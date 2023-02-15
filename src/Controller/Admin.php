<?php

namespace App\Controller;

use App\Interfaces\Guard;

class Admin  extends Controller implements Guard
{

	public function hasAccess()
	{
		return isset($_COOKIE['auth']);
	}

	public function action_admin()
	{
		if (!$this->hasAccess())
		{
			return $this->redirect('/login');
		}

		return $this->render('tmpl/admin.html.php', [
			'body' => 'Панель администратора'
		]);
	}
}
