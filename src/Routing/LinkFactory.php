<?php

namespace Annotate\Framework\Routing;

use Nette\Application\Application;


class LinkFactory
{

	/** @var Application */
	private $application;



	public function __construct(Application $application)
	{
		$this->application = $application;
	}



	public function link()
	{
		return call_user_func_array([$this->application->getPresenter(), 'link'], func_get_args());
	}

}
