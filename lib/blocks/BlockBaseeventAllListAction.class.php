<?php
/**
 * event_BlockBaseeventAllListAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventAllListAction extends event_BlockBaseeventBaseListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return website_WebsiteModuleService::getInstance()->getCurrentWebsite();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param integer $offset
	 * @param integer $itemsPerPage
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = $this->getConfigurationValue('blockTitle');
		if (!$title)
		{
			$title = LocaleService::getInstance()->transFO('m.event.fo.baseevents-from-website-title', array('ucf'));
		}
		return $title;
	}
}