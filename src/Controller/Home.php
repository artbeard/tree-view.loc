<?php

namespace App\Controller;

class Home extends Controller
{
	public function action_home()
	{
		return $this->render('tmpl/home.html.php', [
			'body' => 'Рендер из контроллера Home'
		]);
	}
}
