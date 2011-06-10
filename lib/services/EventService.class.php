<?php
/**
 * event_EventService
 * @package modules.event
 */
class event_EventService extends event_BaseeventService
{
	/**
	 * @var event_EventService
	 */
	private static $instance;

	/**
	 * @return event_EventService
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
	 * @return event_persistentdocument_event
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/event');
	}

	/**
	 * Create a query based on 'modules_event/event' model.
	 * Return document that are instance of modules_event/event,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_event/event');
	}
	
	/**
	 * Create a query based on 'modules_event/event' model.
	 * Only documents that are strictly instance of modules_event/event
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/event', false);
	}
	
	/**
	 * @param event_persistentdocument_event $document
	 * @param string $bockName
	 * @return array with entries 'module' and 'template'. 
	 */
	public function getSolrserachResultItemTemplate($document, $bockName)
	{
		return array('module' => 'event', 'template' => 'Event-Inc-EventResultDetail');
	}
	
	/**
	 * @param event_persistentdocument_event $document
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	public function addTreeAttributes($document, $moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['date'] = date_Formatter::formatBO($document->getUIDate()) . ' - ' . date_Formatter::formatBO($document->getUIEndDate());
	}
}