<?php

namespace App\View;

use App\Interfaces\ViewInterface;

class View implements ViewInterface
{
	public function render($template, $data = [])
	{
		ob_get_clean();
		extract($data);
		include APP_DIR . $template;
		return ob_get_clean();
	}
}
