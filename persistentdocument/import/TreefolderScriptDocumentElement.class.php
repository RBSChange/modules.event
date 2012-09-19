<?php
/**
 * event_TreefolderScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_TreefolderScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return event_persistentdocument_treefolder
	 */
	protected function initPersistentDocument()
	{
		return event_TreefolderService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/treefolder');
	}
}