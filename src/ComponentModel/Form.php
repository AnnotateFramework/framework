<?php

namespace Annotate\Framework\ComponentModel;

use Annotate\Framework\Application\Components\BaseComponent;
use Annotate\Framework\ComponentModel\Forms\IFillable;
use Nette;
use Nette\Application\UI as UI;
use Nextras\Forms\Rendering\Bs3FormRenderer;


abstract class Form extends BaseComponent
{

	protected $addChildComponents = FALSE;



	public function build($args = [])
	{
	}



	protected function attached($parent)
	{
		parent::attached($parent);
		if ($parent instanceof UI\PresenterComponent) {
			if ($this instanceof IFillable) {
				$this->fillForm($this['form']);
			}
		}
		$this['form']->setRenderer(new Bs3FormRenderer);
	}



	abstract protected function createComponentForm();

}
