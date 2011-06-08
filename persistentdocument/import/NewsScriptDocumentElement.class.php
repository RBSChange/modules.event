<?php
/**
 * event_NewsScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_NewsScriptDocumentElement extends event_BaseeventScriptDocumentElement
{
    /**
     * @return event_persistentdocument_news
     */
    protected function initPersistentDocument()
    {
    	return event_NewsService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/news');
	}
}