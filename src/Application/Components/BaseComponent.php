<?php

namespace Annotate\Framework\Application\Components;


use Annotate\Framework\ComponentModel\Exceptions\ComponentTemplateNotFoundException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;


/**
 * @method onAttached($this)
 */
abstract class BaseComponent extends Control
{

	public $onAttached = [];

	protected $templateName = "";

	protected $addChildComponents = TRUE;

	protected $config = [];

	protected $configDefinition = [];



	public function render()
	{
		if ($this->templateName == "") {
			$this->templateName = $this->formatTemplateName();
		}
		$this->build(func_get_args());

		if ($this->addChildComponents) {
			$this->addChildComponents();
		}

		try {
			/** @var Template $templateFile */
			$templateFile = $this->prepareTemplate(
				dirname($this->getReflection()->getFileName()) . '/templates/' . $this->templateName
			);
			if ($templateFile) {
				$templateFile->render();
			}
		} catch (ComponentTemplateNotFoundException $e) {
			if (isset($this["form"])) {
				$this["form"]->render();
			} else {
				throw $e;
			}
		}
	}



	/**
	 * @return string
	 */
	private function formatTemplateName()
	{
		return lcfirst($this->getReflection()->getShortName()) . '.latte';
	}



	public abstract function build($args = []);



	private function addChildComponents()
	{
		/** @var $component BaseComponent */
		foreach ($this->getComponents() as $component) {
			$component->render();
		}
	}



	/**
	 * @param $localPath
	 *
	 * @throws ComponentTemplateNotFoundException
	 * @return Template
	 */
	private function prepareTemplate($localPath)
	{
		/** @var Template $template */
		$template = $this->getTemplate();
		$this->presenter->context->getByType('Annotate\Templating\ITemplateFactory')
			->formatComponentTemplateFiles($template, $this->templateName, $localPath);

		if (!$template->getFile()) {
			throw new ComponentTemplateNotFoundException("Template for component '{$this->getName()}' was not found.");
		}

		return $template;
	}



	protected function attached($parent)
	{
		parent::attached($parent);
		$this->onAttached($this);
	}

}
