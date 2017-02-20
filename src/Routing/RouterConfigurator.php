<?php

namespace Annotate\Framework\Routing;

use Nette\Application\IRouter;
use Nette\Object;


class RouterConfigurator extends Object implements IRouterConfigurator
{

	/** @var  IRouter */
	private $router;



	public function __construct(IRouter $router)
	{
		$this->router = $router;
	}



	public function clearRouter()
	{
		foreach ($this->router as $route) {
			unset($this->router[0]);
		}
	}



	public function registerProvider(IRouteProvider $provider)
	{
		$provider->register($this->router);
	}

}
