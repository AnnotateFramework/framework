<?php

namespace Annotate\Framework\Security;

use Nette\Security\Permission;


class Authorizator extends Permission
{

	public $onResourcesLoad = [];

	public $onRolesLoad = [];

	public $onRulesLoad = [];

	public $onMissingResource = [];

	private $loaded = FALSE;



	public function isAllowed($role = self::ALL, $resource = self::ALL, $privilege = self::ALL)
	{
		if (!$this->loaded) {
			$this->triggerLoadEvents();
		}
		if (!$this->hasResource($resource)) {
			$this->missingResource($resource);
		}

		return parent::isAllowed($role, $resource, $privilege);
	}



	private function triggerLoadEvents()
	{
		$this->onResourcesLoad();
		$this->onRolesLoad();
		$this->onRulesLoad();
		$this->loaded = TRUE;
	}



	public function missingResource($resourceName)
	{
		$this->onMissingResource($resourceName);
	}

}
