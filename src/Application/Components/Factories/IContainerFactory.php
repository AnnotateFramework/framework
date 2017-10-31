<?php

namespace Annotate\Framework\Application\Components\Factories;

use Annotate\Framework\Application\Components\Container;


interface IContainerFactory
{

	/**
	 * @return Container
	 */
	function create();

}
