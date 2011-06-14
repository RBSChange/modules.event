<?php
/**
 * event_patch_0350
 * @package modules.event
 */
class event_patch_0350 extends patch_BasePatch
{
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		$this->executeSQLQuery('ALTER TABLE `m_event_doc_baseevent` ADD `document_s18s` mediumtext;');
	}
}