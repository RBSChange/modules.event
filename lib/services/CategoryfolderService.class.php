<?php
/**
 * event_CategoryfolderService
 * @package modules.event
 */
class event_CategoryfolderService extends generic_FolderService
{
	/**
	 * @var event_CategoryfolderService
	 */
	private static $instance;

	/**
	 * @return event_CategoryfolderService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

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
		return $this->pp->createQuery('modules_event/categoryfolder');
	}
	
	/**
	 * Create a query based on 'modules_event/categoryfolder' model.
	 * Only documents that are strictly instance of modules_event/categoryfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/categoryfolder', false);
	}
}