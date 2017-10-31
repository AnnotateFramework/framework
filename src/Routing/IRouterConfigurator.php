<?php

namespace Annotate\Framework\Routing;


interface IRouterConfigurator
{

	function registerProvider(IRouteProvider $provider);

}
