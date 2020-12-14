<?php

namespace App\Controller;


use Prometheus\RenderTextFormat;

class MetricsController extends BaseController
{
	public function get($args)
	{
		$registry = $this->container->get('promRegistry');
		$renderer = new RenderTextFormat();
		$result = $renderer->render($registry->getMetricFamilySamples());

		$this->response->getBody()->write($result);
		$this->response->withHeader('Content-Type', RenderTextFormat::MIME_TYPE);
		return $this->response;
	}
}