<?php
/**
 * event_HighlightfolderScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_HighlightfolderScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return event_persistentdocument_highlightfolder
	 */
	protected function initPersistentDocument()
	{
		return event_HighlightfolderService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/highlightfolder');
	}
}