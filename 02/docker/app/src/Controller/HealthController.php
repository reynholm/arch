<?php

namespace App\Controller;


class HealthController extends BaseController
{
	public function get($args)
	{
		return $this->message();
	}
}