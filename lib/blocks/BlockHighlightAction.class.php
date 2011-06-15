<?php
/**
 * event_BlockHighlightAction
 * @package modules.event.lib.blocks
 */
class event_BlockHighlightAction extends event_BlockAbstractBaseeventListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		$doc = $this->getDocumentParameter();
		return ($doc instanceof event_persistentdocument_highlight) ? $doc : null;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return boolean 
	 */
	protected function isOnDetailPage($request)
	{
		$tag = 'contextual_website_website_modules_event_highlight';
		return TagService::getInstance()->hasTag($this->getContext()->getPersistentPage(), $tag);
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return integer 
	 */
	protected function getDocCount($request, $modelNames)
	{
		$configuration = $this->getConfiguration();
		$highlight = $this->getParentDoc($request);
		if ($configuration->getRandom())
		{
			return $this->getItemsPerPage($request);
		}
		else if ($configuration->getOnlyFromCurrentWebsite())
		{
			$website = website_WebsiteModuleService::getInstance()->getCurrentWebsite();
			return $highlight->getDocumentService()->getPublishedBaseeventCountByWebsite($highlight, $website, $modelNames);
		}
		else
		{
			return $highlight->getDocumentService()->getPublishedBaseeventCount($highlight, $modelNames);
		}
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param integer $offset
	 * @param integer $itemsPerPage
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	protected function getDocs($request, $offset, $itemsPerPage, $modelNames)
	{
		$configuration = $this->getConfiguration();
		$highlight = $this->getParentDoc($request);
		$website = null;
		if ($configuration->getOnlyFromCurrentWebsite())
		{
			$website = website_WebsiteModuleService::getInstance()->getCurrentWebsite();
		}
		
		if ($configuration->getRandom())
		{
			return $highlight->getDocumentService()->getRandomPublishedBaseeventsByWebsite($highlight, $website, $itemsPerPage, $modelNames);
		}
		else
		{
			return $highlight->getDocumentService()->getPublishedBaseeventsByWebsite($highlight, $website, $offset, $itemsPerPage, $modelNames);
		}
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return string
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = $this->getConfigurationValue('blockTitle');
		if (!$title)
		{
			$doc = $this->getParentDoc($request);
			$title = LocaleService::getInstance()->transFO('m.event.fo.highlight-title', array('ucf', 'html'), array('highlight' => $doc->getLabel()));
		}
		return $title;
	}
}