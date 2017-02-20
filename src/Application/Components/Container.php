<?php

namespace Annotate\Framework\Application\Components;

class Container extends BaseComponent
{

	public function __construct()
	{
	}



	public function render()
	{
		if ($this->templateName == "") {
			/** @var $component BaseComponent */
			foreach ($this->components as $component) {
				$component->render();
			}
		} else {
			parent::render();
		}
	}



	public function build($args = [])
	{
	}



	public function setTemplate($templateName)
	{
		$this->templateName = $templateName;
	}

}
