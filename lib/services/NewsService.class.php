<?php
/**
 * @package modules.event
 * @method event_NewsService getInstance()
 */
class event_NewsService extends event_BaseeventService
{
	/**
	 * @return event_persistentdocument_news
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/news');
	}

	/**
	 * Create a query based on 'modules_event/news' model.
	 * Return document that are instance of modules_event/news,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/news');
	}
	
	/**
	 * Create a query based on 'modules_event/news' model.
	 * Only documents that are strictly instance of modules_event/news
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/news', false);
	}
	
	/**
	 * @param event_persistentdocument_news $document
	 * @param integer $parentNodeId Parent node ID where to save the document (optionnal).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		if ($document->getEndDate() != $document->getDate())
		{
			$document->setEndDate($document->getDate());
		}
		parent::preSave($document, $parentNodeId);
	}
	
	/**
	 * @param event_persistentdocument_news $document
	 * @param string $bockName
	 * @return array with entries 'module' and 'template'. 
	 */
	public function getSolrsearchResultItemTemplate($document, $bockName)
	{
		return array('module' => 'event', 'template' => 'Event-Inc-NewsResultDetail');
	}
}