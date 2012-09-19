<?php
/**
 * @package modules.event
 * @method event_TreefolderService getInstance()
 */
class event_TreefolderService extends generic_FolderService
{
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
		return $this->getPersistentProvider()->createQuery('modules_event/treefolder');
	}
	
	/**
	 * Create a query based on 'modules_event/treefolder' model.
	 * Only documents that are strictly instance of modules_event/treefolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/treefolder', false);
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