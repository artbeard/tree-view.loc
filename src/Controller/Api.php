<?php

namespace App\Controller;

use App\Interfaces\Guard;

class Api  extends Controller implements Guard
{

	public function hasAccess()
	{
		return false;
	}
}
