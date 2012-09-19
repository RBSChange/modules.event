<?php
/**
 * @package modules.event
 * @method event_HighlightfolderService getInstance()
 */
class event_HighlightfolderService extends generic_FolderService
{
	/**
	 * @return event_persistentdocument_highlightfolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/highlightfolder');
	}

	/**
	 * Create a query based on 'modules_event/highlightfolder' model.
	 * Return document that are instance of modules_event/highlightfolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/highlightfolder');
	}
	
	/**
	 * Create a query based on 'modules_event/highlightfolder' model.
	 * Only documents that are strictly instance of modules_event/highlightfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/highlightfolder', false);
	}
}