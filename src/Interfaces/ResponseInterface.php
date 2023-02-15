<?php

namespace App\Interfaces;

interface ResponseInterface
{
	/**
	 * @return mixed
	 */
	public function getContent();

	/**
	 * @return mixed
	 */
	public function setContent($content);

	/**
	 * @return mixed
	 */
	public function setHeader($name, $value);

	/**
	 * @param $location
	 * @param $code
	 * @return mixed
	 */
	public function setRedirect($location, $code);

	/**
	 * @param $status
	 * @return mixed
	 */
	public function setStatus($status);

	/**
	 * @return mixed
	 */
	public function send();

}
