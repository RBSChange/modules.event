<?php
/**
 * event_EventScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_EventScriptDocumentElement extends event_BaseeventScriptDocumentElement
{
	/**
	 * @return event_persistentdocument_event
	 */
	protected function initPersistentDocument()
	{
		return event_EventService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/event');
	}
}