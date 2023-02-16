<?php

namespace App\Controller;

trait SecureTrait
{
	/**
	 * @var string Секретный ключ для cookie
	 */
	protected $authSecretKey = '5d06ec3125564caa73a7e3f275ca8641513cb7f8';

	/**
	 * Установка cookie
	 * @param null $expire время жизни, по умолчанию, час
	 */
	protected function setAuthCoolie($expire = null)
	{
		$cookieValue = md5($this->authSecretKey);
		if (is_null($expire))
		{
			$expire = time() + 60 * 60;
		}
		if ($expire <= 0)
		{
			$cookieValue = 0;
		}
		setcookie('auth', $cookieValue, time() + 60 * 60 ,'/', $_SERVER['HTTP_HOST'], false, true);
	}

	/**
	 * Проверяем cookie на валидность, иобновляем, еслм валидна
	 * @return bool
	 */
	protected function checkAuthCoolie()
	{
		if (isset($_COOKIE['auth']) && $_COOKIE['auth'] == md5($this->authSecretKey))
		{
			$this->setAuthCoolie();
			return true;
		}
		return false;
	}

	/**
	 * Стираем cookie
	 */
	protected function removeAuthCoolie()
	{
		if (isset($_COOKIE['auth']))
		{
			unset($_COOKIE['auth']);
		}
		$this->setAuthCoolie(-1);
	}
}
