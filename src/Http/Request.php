<?php

namespace App\Http;
use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
	protected $method = 'GET';
	protected $path = '/';
	protected $body = null;



	public function __construct()
	{
		$this->method = strtoupper($_SERVER['REQUEST_METHOD']);
		$this->path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
	}

	/**ну
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}


	/**
	 * @return mixed
	 */
	public function getBody()
	{
		if (is_null($this->body))
		{
			if (in_array($this->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']))
			{
				$this->body = file_get_contents('php://input');
				//парсим json, если он есть в теле
				$parced = json_decode($this->body, true);
				if (!is_null($parced))
				{
					$this->body = $parced;
				}
			}
		}
		return $this->body;
	}


}
