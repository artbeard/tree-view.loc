<?php

namespace App\Controller;

use App\Services\PartService;

class Home extends Controller
{
	public function action_home(PartService $partService)
	{
		$tree = $partService->getTreeArray();
		return $this->render('tmpl/home.html.php', [
			'title' => 'Каталог документов',
			'list' => $tree
		]);
	}
}
