<?php

namespace App\Interfaces;

interface RequestInterface
{

	/**
	 * @return string Метод запроса
	 */
	public function getMethod();

	/**
	 * @return string Путь
	 */
	public function getPath();

	/**
	 * Получаем данные из тела запроса
	 * @return mixed
	 */
	public function getBody();
}
