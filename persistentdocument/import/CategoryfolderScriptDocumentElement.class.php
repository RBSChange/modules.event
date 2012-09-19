<?php
/**
 * event_CategoryfolderScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_CategoryfolderScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return event_persistentdocument_categoryfolder
	 */
	protected function initPersistentDocument()
	{
		return event_CategoryfolderService::getInstance()->getNewDocumentInstance();
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/categoryfolder');
	}
}