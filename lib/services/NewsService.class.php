<?php
/**
 * event_NewsService
 * @package modules.event
 */
class event_NewsService extends event_BaseeventService
{
	/**
	 * @var event_NewsService
	 */
	private static $instance;

	/**
	 * @return event_NewsService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

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
		return $this->pp->createQuery('modules_event/news');
	}
	
	/**
	 * Create a query based on 'modules_event/news' model.
	 * Only documents that are strictly instance of modules_event/news
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/news', false);
	}

	/**
	 * @param event_persistentdocument_news $document
	 * @param string $bockName
	 * @return array with entries 'module' and 'template'. 
	 */
	public function getSolrserachResultItemTemplate($document, $bockName)
	{
		return array('module' => 'event', 'template' => 'Event-Inc-NewsResultDetail');
	}
}