<?php
/**
 * event_HighlightfolderService
 * @package modules.event
 */
class event_HighlightfolderService extends generic_FolderService
{
	/**
	 * @var event_HighlightfolderService
	 */
	private static $instance;

	/**
	 * @return event_HighlightfolderService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

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
		return $this->pp->createQuery('modules_event/highlightfolder');
	}
	
	/**
	 * Create a query based on 'modules_event/highlightfolder' model.
	 * Only documents that are strictly instance of modules_event/highlightfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/highlightfolder', false);
	}
}