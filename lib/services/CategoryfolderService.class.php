<?php
/**
 * @package modules.event
 * @method event_CategoryfolderService getInstance()
 */
class event_CategoryfolderService extends generic_FolderService
{
	/**
	 * @return event_persistentdocument_categoryfolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/categoryfolder');
	}

	/**
	 * Create a query based on 'modules_event/categoryfolder' model.
	 * Return document that are instance of modules_event/categoryfolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/categoryfolder');
	}
	
	/**
	 * Create a query based on 'modules_event/categoryfolder' model.
	 * Only documents that are strictly instance of modules_event/categoryfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/categoryfolder', false);
	}
}