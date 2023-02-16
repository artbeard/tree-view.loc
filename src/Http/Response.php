<?php

namespace App\Http;

class Response implements \App\Interfaces\ResponseInterface
{
	protected $status = 200;
	protected $headers = [];
	protected $content = null;
	/**
	 * @var bool Флаг готовности response к отдаче
	 */
	protected $isReady = false;

	/**
	 * Возвращает готовность response к отдаче
	 * @return bool
	 */
	public function isReady()
	{
		return $this->isReady;
	}

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
		$this->isReady = true;
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
		$this->setHeader('Pragma', 'no-cache');
		$this->setHeader('Cache-Control', 'no-cache, must-revalidate');
		$this->isReady = true;
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
