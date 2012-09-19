<?php
/**
 * event_BlockBaseeventAllListAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventAllListAction extends event_BlockAbstractBaseeventListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return website_WebsiteService::getInstance()->getCurrentWebsite();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return string
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = parent::getBlockTitle($request, $modelNames);
		if (!$title)
		{
			$title = LocaleService::getInstance()->trans('m.event.fo.baseevents-from-website-title', array('ucf'));
		}
		return $title;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return boolean 
	 */
	protected function isOnDetailPage($request)
	{
		$tag = 'contextual_website_website_modules_event_baseeventalllist';
		return TagService::getInstance()->hasTag($this->getContext()->getPersistentPage(), $tag);
	}
}