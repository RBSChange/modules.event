<?php
/**
 * event_BlockCategoryAction
 * @package modules.event.lib.blocks
 */
class event_BlockCategoryAction extends event_BlockBaseeventBaseListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackoffice())
		{
			return website_BlockView::NONE;
		}
		
		$website = website_WebsiteModuleService::getInstance()->getCurrentWebsite();
		if ($request->hasParameter('topicId'))
		{
			$topic = website_persistentdocument_topic::getInstanceById($request->getParameter('topicId'));
			$request->setAttribute('topic', $topic);
		}
		
		return parent::execute($request, $response);
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		$doc = $this->getDocumentParameter();
		return ($doc instanceof event_persistentdocument_category) ? $doc : null;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return boolean 
	 */
	protected function isOnDetailPage($request)
	{
		$tag = 'contextual_website_website_modules_event_category';
		return TagService::getInstance()->hasTag($this->getContext()->getPersistentPage(), $tag);
	}

	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return integer 
	 */
	protected function getDocCount($request, $modelNames)
	{
		$bes = event_BaseeventService::getInstance();
		$parentDoc = $this->getParentDoc($request);
		$website = website_WebsiteModuleService::getInstance()->getCurrentWebsite();
		if ($request->hasAttribute('topic'))
		{
			return $bes->getPublishedCountByCategoryAndTopic($parentDoc, $request->getAttribute('topic'), $modelNames);
		}
		else
		{
			return $bes->getPublishedCountByCategoryAndWebsite($parentDoc, $website, $modelNames);
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
		$bes = event_BaseeventService::getInstance();
		$parentDoc = $this->getParentDoc($request);
		$website = website_WebsiteModuleService::getInstance()->getCurrentWebsite();
		if ($request->hasAttribute('topic'))
		{
			return $bes->getPublishedByCategoryAndTopic($parentDoc, $request->getAttribute('topic'), $offset, $itemsPerPage, $modelNames);
		}
		else
		{
			return $bes->getPublishedByCategoryAndWebsite($parentDoc, $website, $offset, $itemsPerPage, $modelNames);
		}
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
			$doc = $this->getParentDoc($request);
			$title = LocaleService::getInstance()->transFO('m.event.fo.category-title', array('ucf', 'html'), array('category' => $doc->getLabel()));
		}
		return $title;
	}
}