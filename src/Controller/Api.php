<?php

namespace App\Controller;

use App\Interfaces\Guard;

class Api  extends Controller implements Guard
{

	public function hasAccess()
	{
		return isset($_COOKIE['auth']);
	}

	public function get_list()
	{
		if (!$this->hasAccess())
		{
			return $this->redirect('/login');
		}

//Для отладки
		$structure = [
			['id' => 1, 'title' => 'Каталог', 'desc' => 'Каталог документов о языках программирования', 'pid' => null],

			['id' => 2, 'title' => 'PHP', 'desc' => 'Раздел о PHP', 'pid' => 1],
			['id' => 3, 'title' => 'JavaScript', 'desc' => 'Раздел о JavaScript', 'pid' => 1],
			['id' => 4, 'title' => 'Cи', 'desc' => 'Раздел о Си', 'pid' => 1],

			['id' => 5, 'title' => 'Фреймворки Php', 'desc' => 'Раздел о фреймоврках', 'pid' => 2],
			['id' => 6, 'title' => 'Стандарты кодирования PHP', 'desc' => 'Раздел о стандартах PSR', 'pid' => 2],

			['id' => 7, 'title' => 'Фреймворки JavaScript', 'desc' => 'Раздел о фреймворках', 'pid' => 3],
			['id' => 8, 'title' => 'Версии языка JS', 'desc' => 'Раздел о версиях', 'pid' => 3],

			['id' => 9, 'title' => 'Указатели и ссылки в языке CИ', 'desc' => 'Раздел об указателях', 'pid' => 4],
			['id' => 10, 'title' => 'Типы данных в Си',		 'desc' => 'Раздел о типах данных',			'pid' => 4],
			['id' => 11, 'title' => 'Работа с памятью в Си', 'desc' => 'раздел о работе с памятью',	'pid' => 4],

			['id' => 12, 'title' => 'PSR-1', 'desc' => 'Basic Coding Standard', 'pid' => 6],

			//todo почему этот не попадает???
			['id' => 13, 'title' => 'Еще один в корне', 'desc' => 'Basic Coding Standard', 'pid' => null],
		];

		function map2tree(&$data, $pid = null)
		{
			$tree = [];
			foreach ($data as $n => $node)
			{
				if ($node['pid'] == $pid)
				{
					//unset($data[$n]);
					$child = map2tree($data, $node['id']);
					if (!empty($child))
					{
						$node['child'] = $child;
					}
					unset($node['pid']);
					$tree[] = $node;
				}
			}
			return $tree;
		}

		$tree = map2tree($structure);

		return $this->renderJson([
			'treeList' => $tree
		]);

	}
}
