<?php

namespace App\Controller;

class HomeController extends BaseController
{
	public function get($args)
	{
		return $this->message();
	}
}