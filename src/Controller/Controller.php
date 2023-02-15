<?php

namespace App\Controller;

use App\Http\Response;
use App\Http\Request;
use App\View\View;

class Controller
{
	protected $request;
	protected $response;
	protected $view;

	public function __construct(Request $request, Response $response, View $view)
	{
		$this->request = $request;
		$this->response = $response;
		$this->view = $view;
	}

	/**
	 * Возврат Response с отрендеренным результатом
	 * @param $template
	 * @param $data
	 * @param $statusCode
	 * @return mixed
	 */
	protected function render($template, $data, $statusCode = 200)
	{
		$this->response->setStatus($statusCode);
		$this->response->setContent(
			$this->view->render($template, $data)
		);
		return $this->response;
	}

	/**
	 * Возврат Response с JSON данными
	 * @param $data
	 * @param $statusCode
	 * @return mixed
	 */
	protected function renderJson($data, $statusCode)
	{
		$this->response->setStatus($statusCode);
		$this->response->setContent($data);
		return $this->response;
	}

	/**
	 * Возврат Response с перенаправлением
	 * @param $location
	 * @return mixed
	 */
	protected function redirect($location)
	{
		$this->response->setRedirect($location);
		return $this->response;
	}
}
