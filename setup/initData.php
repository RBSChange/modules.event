<?php
/**
 * @package modules.event.setup
 */
class event_Setup extends object_InitDataSetup
{
	public function install()
	{
		$this->executeModuleScript('init.xml');
	}
}