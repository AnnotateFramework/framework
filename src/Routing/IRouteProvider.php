<?php

namespace Annotate\Framework\Routing;

use Nette\Application\IRouter;


interface IRouteProvider
{

	function register(IRouter $router);

}
