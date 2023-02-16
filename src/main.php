<?php

namespace App;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\NotFoundException;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;
use App\View\View;
use App\Controller\Controller;
use App\Db\Db;
use App\Repository\UserRepository;

$router = new Router\Router();
$request = new Request();

/*
 * CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` varchar(15) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
user	$2y$10$65.QH5OR.d3bgoVtzgi7i.nMebFvIdV82dW4j4VF4n6MjsdcwzRua
 *
 *
 * CREATE TABLE `parts` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(128) NOT NULL,
  `desc` varchar(512) NOT NULL,
  `pid` int NOT NULL
) ENGINE='InnoDB';
 * */


//Публичная страница
$router->addRoute('/', [\App\Controller\Home::class, 'action_home']);

//Роутеры авторизации
$router->addRoute('/login', [\App\Controller\Auth::class, 'action_login']);
$router->addRoute('POST /login', [\App\Controller\Auth::class, 'action_authenticate', function(){
	$db = new Db('mysql:host=localhost;dbname=treeview', 'root', 'root');
	$userRepository = new UserRepository($db);
	$userService = new UserService($userRepository);
	return [
		'userService' => $userService
	];
}]);
$router->addRoute('/logout', [\App\Controller\Auth::class, 'action_logout']);

//Админка
$router->addRoute('/admin', [\App\Controller\Admin::class, 'action_admin']);
$router->addRoute('/api/list', [\App\Controller\Api::class, 'get_list']);




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

try {

	$route = $router->matchRoute($request->getPath(), $request->getMethod());
	$controller = controllerResolver($route[0], $request);


	//Если response готов - отдаем
	if ($controller[0]->getResponse()->isReady())
	{
		$controller[0]->getResponse()->send();
	}
	//Иначе, резолвим аргументы и вызываем action
	else
	{
		$arguments = [];
		//print_r($route[0][2]); exit;
		if (isset($route[0][2]))
		{
			$arguments = $route[0][2]();
		}
		//print_r($arguments); exit;
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
catch (\Exception $e)
{
	echo 'Неотловленная ошибка: '.$e->getMessage();
}


