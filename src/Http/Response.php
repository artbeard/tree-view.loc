<?php

namespace App\Http;

class Response implements \App\Interfaces\ResponseInterface
{
	protected $status = 200;
	protected $headers = [];
	protected $content = null;


	/**
	 * @inheritDoc
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @inheritDoc
	 */
	public function setContent($content)
	{
		if (is_array($content))
		{
			$this->setHeader('Content-Type', 'application/json');
			$this->content = json_encode($content);
		}
		else
		{
			$this->setHeader('Content-Type','text/html; charset=utf-8');
			$this->content = $content;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function setHeader($name, $value)
	{
		$this->headers[$name] = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function setRedirect($location, $code = 301)
	{
		$this->status = $code;
		$this->setHeader('Location', $location);
	}

	/**
	 * @inheritDoc
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * @inheritDoc
	 */
	public function send()
	{
		$this->sendHeaders();
		$this->sendBody();
	}

	/**
	 * Отправляем звголовки
	 */
	protected function sendHeaders()
	{
		http_response_code($this->status);
		if ( !empty($this->headers) )
		{
			foreach ($this->headers as $name => $value)
			{
				header($name.': '.$value);
			}
		}
	}

	/**
	 * Отправляем тело ответа
	 */
	protected function sendBody()
	{
		echo is_null($this->content) ? '' : $this->content;
	}


}