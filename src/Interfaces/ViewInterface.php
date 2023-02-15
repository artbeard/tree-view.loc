<?php

namespace App\Interfaces;

interface ViewInterface
{
	/**
	 * @param $template string файл шаблона для рендеринга
	 * @param $data array Массив с переменными
	 * @return string
	 */
	public function render($template, $data);

}
