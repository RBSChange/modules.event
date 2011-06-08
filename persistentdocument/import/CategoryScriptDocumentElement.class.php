<?php
/**
 * event_CategoryScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_CategoryScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return event_persistentdocument_category
     */
    protected function initPersistentDocument()
    {
    	return event_CategoryService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/category');
	}
}