<?php

namespace App;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\NotFoundException;
use App\Http\Request;
use App\Http\Response;
use App\Repository\PartRepository;
use App\Services\PartService;
use App\Services\UserService;
use App\View\View;
use App\Controller\Controller;
use App\Db\Db;
use App\Repository\UserRepository;

/**
 * ************ вместо DI )) *********
 */
$config = [
	'dbname' => 'treeview',
	'dbUser' => 'root', //подставить свое
	'dbPass' => 'root', //подставить свое
];
$router = new Router\Router();
$request = new Request();

$action_home_resolver = function () use ($config) {
	$db = new Db('mysql:host=localhost;dbname='.$config['dbname'], $config['dbUser'], $config['dbPass']);
	$partRepository = new PartRepository($db);
	$partService = new PartService($partRepository);
	return [
		'partService' => $partService,
	];
};
$action_authenticate_resolver = function() use ($config) {
	$db = new Db('mysql:host=localhost;dbname='.$config['dbname'], $config['dbUser'], $config['dbPass']);
	$userRepository = new UserRepository($db);
	$userService = new UserService($userRepository);
	return [
		'userService' => $userService
	];
};

function controllerResolver($controller, $request)
{
	if (is_subclass_of($controller[0], Controller::class))
	{
		return [
			new $controller[0]($request, new Response(), new View()),
			$controller[1]
		];
	}
	else
	{
		return [
			new $controller[0](),
			$controller[1]
		];
	}
}

//РОутинг
//Публичная страница
$router->addRoute('/', [\App\Controller\Home::class, 'action_home', $action_home_resolver]);
//Роутеры авторизации
$router->addRoute('/login', [\App\Controller\Auth::class, 'action_login']);
$router->addRoute('POST /login', [\App\Controller\Auth::class, 'action_authenticate', $action_authenticate_resolver]);
$router->addRoute('/logout', [\App\Controller\Auth::class, 'action_logout']);
//Админка
$router->addRoute('/admin', [\App\Controller\Admin::class, 'action_admin', $action_home_resolver]);
$router->addRoute('/api/list', [\App\Controller\Api::class, 'get_list', $action_home_resolver]);
$router->addRoute('POST /api/list', [\App\Controller\Api::class, 'add_node', $action_home_resolver]);
$router->addRoute('PATCH /api/list', [\App\Controller\Api::class, 'update_node', $action_home_resolver]);
$router->addRoute('DELETE /api/list', [\App\Controller\Api::class, 'delete_chain', $action_home_resolver]);
$router->addRoute('PATCH /api/list/move', [\App\Controller\Api::class, 'move_node', $action_home_resolver]);

// выполняем запрос
try {
	$route = $router->matchRoute($request->getPath(), $request->getMethod())[0];
	$controller = controllerResolver($route, $request);
	//Если response готов - отдаем
	if ($controller[0]->getResponse()->isReady())
	{
		$controller[0]->getResponse()->send();
	}
	//Иначе, резолвим аргументы и вызываем action
	else
	{
		$arguments = [];
		if (isset($route[2]))
		{
			$arguments = $route[2]();
		}
		$response = call_user_func_array($controller, $arguments);
		$response->send();
	}
}
catch (NotFoundException $e)
{
	echo $e->getMessage();
}
catch (AccessDeniedException $e)
{
	echo $e->getMessage();
}
catch (\Exception $e) //вывод иных неотловленных ошибок
{
	echo '<h1>'.$e->getMessage().'</h1>';
}
