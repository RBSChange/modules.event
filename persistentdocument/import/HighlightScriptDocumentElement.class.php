<?php
/**
 * event_HighlightScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_HighlightScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return event_persistentdocument_highlight
	 */
	protected function initPersistentDocument()
	{
		return event_HighlightService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/highlight');
	}
}