<?php
/**
 * event_TreefolderService
 * @package modules.event
 */
class event_TreefolderService extends generic_FolderService
{
	/**
	 * @var event_TreefolderService
	 */
	private static $instance;

	/**
	 * @return event_TreefolderService
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
	 * @return event_persistentdocument_treefolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/treefolder');
	}

	/**
	 * Create a query based on 'modules_event/treefolder' model.
	 * Return document that are instance of modules_event/treefolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_event/treefolder');
	}
	
	/**
	 * Create a query based on 'modules_event/treefolder' model.
	 * Only documents that are strictly instance of modules_event/treefolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/treefolder', false);
	}
	
	/**
	 * @param integer $websiteId
	 */
	public function getDefaultFrontofficeInbox($websiteId)
	{
		$query = $this->createQuery()->add(Restrictions::orExp(Restrictions::eq('label', 'm.event.bo.general.inbox'), Restrictions::eq('label', 'Contributions des internautes')));
		$folder = $query->addOrder(Order::desc('label'))->setMaxResults(1)->findUnique();
		if (!$folder)
		{
			$folder = $this->getNewDocumentInstance();
			$folder->setLabel('m.event.bo.general.inbox');
			$folder->save(ModuleService::getInstance()->getRootFolderId('event'));
		}
		return $folder;
	}
	
	/**
	 * @param event_persistentdocument_highlight $document
	 * @return string[]
	 */
	public function getDocumentsModelNamesForTweet($document)
	{
		return array('modules_event/baseevent');
	}
	
	/**
	 * @param event_persistentdocument_highlight $document
	 * @return boolean
	 */
	public function canSendTweetOnContainedDocumentPublish($document)
	{
		return true;
	}
	
	/**
	 * @param event_persistentdocument_highlight $document
	 * @param string $modelName
	 * @return integer[]
	 */
	public function getContainedIdsForTweet($document, $modelName)
	{
		$query = event_BaseeventService::getInstance()->createQuery()->add(Restrictions::published());
		$query->add(Restrictions::descendentOf($document->getId()))->setProjection(Projections::property('id'));
		return $query->findColumn('id');
	}
	
	/**
	 * @param event_persistentdocument_highlight $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return website_WebsiteService::getInstance()->createQuery()->add(Restrictions::published())->find();
	}
}