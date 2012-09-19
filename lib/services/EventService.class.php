<?php
/**
 * @package modules.event
 * @method event_EventService getInstance()
 */
class event_EventService extends event_BaseeventService
{
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
		return $this->getPersistentProvider()->createQuery('modules_event/event');
	}
	
	/**
	 * Create a query based on 'modules_event/event' model.
	 * Only documents that are strictly instance of modules_event/event
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/event', false);
	}
	
	/**
	 * @param event_persistentdocument_event $document
	 * @param string $bockName
	 * @return array with entries 'module' and 'template'. 
	 */
	public function getSolrsearchResultItemTemplate($document, $bockName)
	{
		return array('module' => 'event', 'template' => 'Event-Inc-EventResultDetail');
	}
		
	/**
	 * @param event_persistentdocument_event $document
	 * @param array<string, string> $attributes
	 * @param integer $mode
	 * @param string $moduleName
	 */
	public function completeBOAttributes($document, &$attributes, $mode, $moduleName)
	{
		if ($mode & DocumentHelper::MODE_CUSTOM)
		{
			$attributes['date'] = date_Formatter::toDefaultDateTimeBO($document->getUIDate()) . ' - ' . date_Formatter::toDefaultDateTimeBO($document->getUIEndDate());
		}
	}
	
	/**
	 * @param array $infos
	 * @return array
	 */
	public function getNotificationParameters($infos)
	{
		$document = $infos['document'];
		$params = parent::getNotificationParameters($infos);
		$params['documentEndDate'] = date_Formatter::toDefaultDate($document->getUIDate());
		return $params;
	}
}