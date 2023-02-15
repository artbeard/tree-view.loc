<?php

namespace App\Controller;

use App\Interfaces\Guard;

class Admin  extends Controller implements Guard
{

	public function hasAccess()
	{
		return false;
	}

	public function action_admin()
	{
		if (!$this->hasAccess())
		{
			return $this->redirect('/login');
		}
	}
}
