<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Services\PartService;
use App\View\View;

class Admin  extends Controller
{
	use SecureTrait;

	public function __construct(...$args)
	{
		parent::__construct(...$args);
		//Проверка аутентификации
		if (!$this->checkAuthCoolie())
		{
			$this->response->setRedirect('/login');
		}
	}

	public function action_admin(PartService $partService)
	{
		$tree = $partService->getTreeArray();
		return $this->render('tmpl/admin.html.php', [
			'title' => 'Панель администратора',
			'list' => $tree
		]);
	}
}
