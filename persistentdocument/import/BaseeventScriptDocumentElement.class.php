<?php
/**
 * event_BaseeventScriptDocumentElement
 * @package modules.event.persistentdocument.import
 */
class event_BaseeventScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return event_persistentdocument_baseevent
     */
    protected function initPersistentDocument()
    {
    	return event_BaseeventService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/baseevent');
	}
	
	/**
	 * @return array
	 */
	protected function getDocumentProperties()
	{
		$properties = parent::getDocumentProperties();
		
		$event = $this->getPersistentDocument();
		if (in_array($event->getPublicationstatus(), array('ACTIVE', 'PUBLICATED', 'DEACTIVATED')))
		{
			if (!isset($properties['publicationstatus']))
			{
				$properties['publicationstatus'] = 'DRAFT';
			}
		}
		
		return $properties;
	}
	
	public function endProcess()
	{
		$document = $this->getPersistentDocument();
		$rc = RequestContext::getInstance();
		foreach ($rc->getSupportedLanguages() as $lang)
		{
			if ($document->isLangAvailable($lang))
			{
				$rc->beginI18nWork($lang);
				if ($document->getPublicationstatus() == 'DRAFT')
				{
					$document->getDocumentService()->activate($document->getId());
				}
				$rc->endI18nWork();
			}
		}
	}
}