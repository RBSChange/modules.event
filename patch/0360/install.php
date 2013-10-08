<?php
/**
 * event_patch_0360
 * @package modules.event
 */
class event_patch_0360 extends patch_BasePatch
{
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		$this->executeModuleScript('lists.xml', 'event');
	}
}