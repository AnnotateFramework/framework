<?php

namespace Annotate\Framework\Application\Components;


use Annotate\Framework\ComponentModel\Exceptions\ComponentTemplateNotFoundException;


class Container extends BaseComponent
{

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
	{
	}



    /**
     * @throws ComponentTemplateNotFoundException
     */
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
