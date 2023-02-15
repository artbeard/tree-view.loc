<?php

namespace App\Interfaces;

interface RouterInterface
{
	/**
	 * Добавляет роут с список
	 * @param string $path Строка, содержащя путь, либо метод и путь
	 * @param callable $callable объект callable
	 * @param \Closure $argumentResolver Функция, разрешающая аргументы вызова для $callable
	 * @return void
	 */
	public function addRoute($path, $callable, $argumentResolver);

	/**
	 * Ищет подходящий роут и возвращат контроллер и ресолвер аргументов для контроллера
	 * @param string $path //Путь запроса
	 * @param string $method Метод запроса
	 * @return array //массив роута
	 */
	public function matchRoute($path, $method);
}
