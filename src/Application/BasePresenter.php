<?php

namespace Annotate\Framework\Application;

use Annotate\Templating\ITemplateFactory;
use Nette;
use Nette\Application\UI\Presenter;


class BasePresenter extends Presenter
{

	/** @var Components\Factories\IContainerFactory @inject */
	public $containerFactory;

	/** @var ITemplateFactory|NULL */
	protected $templateFactory;

	protected $templateFile;



	public function __construct(ITemplateFactory $templateFactory = NULL)
	{
		$this->templateFactory = $templateFactory;
	}



	public function formatTemplateFiles()
	{
		if (!$this->templateFile) {
			$this->templateFile = $this->action;
		}

		return $this->templateFactory->formatTemplateFiles($this->templateFile, $this);
	}



	public function formatLayoutTemplateFiles()
	{
		$layout = $this->layout ? $this->layout : "layout";

		return $this->templateFactory->formatLayoutTemplateFiles($layout, $this);
	}



	protected function beforeRender()
	{
		$this->templateFactory->setupTemplate($this->template);
	}



	protected function createComponentContainer($name)
	{
		return $this->containerFactory->create($name);
	}

}
