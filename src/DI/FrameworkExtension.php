<?php

namespace Annotate\Framework\DI;

use Annotate\Diagnostics\CmsPanel;
use Annotate\Framework\Application\Components\Factories\IContainerFactory;
use Annotate\Framework\Routing\LinkFactory;
use Annotate\Framework\Routing\RouterConfigurator;
use Annotate\Framework\Security\Authorizator;
use Nette;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use Tracy\Debugger;


class FrameworkExtension extends CompilerExtension
{

	const TAG_RUN = "run";



	public function loadConfiguration()
	{

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('routerConfigurator'))
			->setClass(RouterConfigurator::class)
			->addTag(self::TAG_RUN);

		$builder->addDefinition($this->prefix('containerComponent'))
			->setImplement(IContainerFactory::class);

		$builder->addDefinition($this->prefix('authorizator'))
			->setClass(Authorizator::class);

		$builder->addDefinition($this->prefix('linkFactory'))
			->setClass(LinkFactory::class);

		$builder->getDefinition('application')
			->addSetup('!headers_sent() && header(?);', ['X-Powered-By: AnnotateFramework']);
	}



	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		$configuration = $this->getConfig($this->getDefaults());

		Validators::assertField($configuration, 'routing', 'array');
		Validators::assertField($configuration['routing'], 'providers', 'array');

		$routerConfigurator = $builder->getDefinition($this->prefix('routerConfigurator'));
		foreach ($configuration['routing']['providers'] as $provider) {
			$routerConfigurator->addSetup('registerProvider', [$provider]);
		}
	}



	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$config = $this->getConfig($this->getDefaults());
		Validators::assert($config['debugger'], 'boolean');

		if (!$config['debugger']) {
			return;
		}

		$initialize = $class->getMethods()['initialize'];
		$initialize->addBody(
			Debugger::class . '::getBar()->addPanel(new ' . CmsPanel::class . '(), "cms-panel");'
		);
	}



	private function  getDefaults()
	{
		return [
			'debugger' => TRUE,
			'routing' => [
				'providers' => [],
			],
		];
	}

}
