<?php

namespace App;

use App\Exceptions\NotFoundException;
use App\Http\Request;
use App\Http\Response;
use App\View\View;
use App\Controller\Controller;

$router = new Router\Router();
$request = new Request();

//Публичная страница
$router->addRoute('/', [\App\Controller\Home::class, 'action_home']);

//Роутеры авторизации
$router->addRoute('/login', [\App\Controller\Auth::class, 'action_login']);
$router->addRoute('POST /login', [\App\Controller\Auth::class, 'action_authenticate']);
$router->addRoute('/logout', [\App\Controller\Auth::class, 'action_logout']);

//Админка
$router->addRoute('/admin', [\App\Controller\Admin::class, 'action_admin']);




function controllerResolver($controller, $request)
{
	if (is_array($controller))
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
	return $controller;
}

try {

	$route = $router->matchRoute($request->getPath(), $request->getMethod());
	$controller = controllerResolver($route[0], $request);
	$arguments = [];
	if (isset($route[1]))
	{
		$arguments = $route[1]();
	}

	$response = call_user_func_array($controller, $arguments);
	$response->send();

}
catch (NotFoundException $e)
{
	echo $e->getMessage();
}
catch (\Exception $e)
{
	echo 'Неотловленная ошибка: '.$e->getMessage();
}


