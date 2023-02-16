<?php

namespace App\Router;
use App\Exceptions\NotFoundException;
use \App\Interfaces\RouterInterface;
class Router implements RouterInterface
{

	protected $routes = [];
	/**
	 * @inheritDoc
	 */
	public function addRoute($path, $callable, $argumentResolver = null)
	{
		$newRouter = [$callable];
		if (!is_null($argumentResolver))
		{
			$newRouter[] = $argumentResolver;
		}
		$this->routes[$path] = $newRouter;
	}

	/**
	 * @inheritDoc
	 */
	public function matchRoute($path, $method)
	{
		if (array_key_exists($method.' '.$path, $this->routes))
		{
			return $this->routes[$method.' '.$path];
		}
		if (array_key_exists($path, $this->routes))
		{
			return $this->routes[$path];
		}
		throw new NotFoundException('Page Not found');
	}
}
