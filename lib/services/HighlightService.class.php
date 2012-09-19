<?php
/**
 * @package modules.event
 * @method event_HighlightService getInstance()
 */
class event_HighlightService extends f_persistentdocument_DocumentService
{
	/**
	 * @return event_persistentdocument_highlight
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/highlight');
	}

	/**
	 * Create a query based on 'modules_event/highlight' model.
	 * Return document that are instance of modules_event/highlight,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/highlight');
	}
	
	/**
	 * Create a query based on 'modules_event/highlight' model.
	 * Only documents that are strictly instance of modules_event/highlight
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/highlight', false);
	}
	
	/**
	 * @param filter_persistentdocument_queryfolder $document
	 * @param string[] $subModelNames
	 * @param integer $locateDocumentId null if use startindex
	 * @param integer $pageSize
	 * @param integer $startIndex
	 * @param integer $totalCount
	 * @return f_persistentdocument_PersistentDocument[]
	 */
	public function getVirtualChildrenAt($document, $subModelNames, $locateDocumentId, $pageSize, &$startIndex, &$totalCount)
	{
		$dfs = f_persistentdocument_DocumentFilterService::getInstance();
		$queryIntersection = $dfs->getQueryIntersectionFromJson($document->getQuery());
		$result = $queryIntersection->findAtOffset($startIndex, $pageSize, $totalCount);
		return $result;
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param string[] $modelNames
	 * @return integer
	 */
	public function getPublishedBaseeventCount($highlight, $modelNames)
	{
		return count($this->getQueryIntersection($highlight, null, $modelNames)->findIds());
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	public function getPublishedBaseevents($highlight, $offset, $limit, $modelNames)
	{
		$count = null;
		return $this->getQueryIntersection($highlight, null, $modelNames)->findAtOffset($offset, $limit, $count, 'DESC');
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	public function getRandomPublishedBaseevents($highlight, $limit, $modelNames)
	{
		$ids = $this->getQueryIntersection($highlight, null, $modelNames)->findIds();
		shuffle($ids);
		return event_BaseeventService::getInstance()->createQuery()->add(Restrictions::in('id', array_slice($ids, 0, $limit)))->find();
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param string[] $modelNames
	 * @return integer
	 */
	public function getPublishedBaseeventCountByWebsite($highlight, $website, $modelNames)
	{
		return count($this->getQueryIntersection($highlight, $website, $modelNames)->findIds());
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	public function getPublishedBaseeventsByWebsite($highlight, $website, $offset, $limit, $modelNames)
	{
		$count = null;
		return $this->getQueryIntersection($highlight, $website, $modelNames)->findAtOffset($offset, $limit, $count, 'DESC');
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	public function getRandomPublishedBaseeventsByWebsite($highlight, $website, $limit, $modelNames)
	{
		$ids = $this->getQueryIntersection($highlight, $website, $modelNames)->findIds();
		shuffle($ids);
		return event_BaseeventService::getInstance()->createQuery()->add(Restrictions::in('id', array_slice($ids, 0, $limit)))->find();
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent
	 */
	protected function getQueryIntersection($highlight, $website, $modelNames, $withoutExcludedFromRss = false)
	{
		$dfs = f_persistentdocument_DocumentFilterService::getInstance();
		$queryIntersection = $dfs->getQueryIntersectionFromJson($highlight->getQuery());
		$publishedQuery = event_BaseeventService::getInstance()->createQuery()->add(Restrictions::published());
		if (is_array($modelNames) && count($modelNames) > 0)
		{
			$publishedQuery->add(Restrictions::in('model', $modelNames));
		}
		if ($withoutExcludedFromRss)
		{
			$publishedQuery->add(Restrictions::eq('excludeFromRss', false));
		}
		if ($website !== null)
		{
			$publishedQuery->add(Restrictions::eq('website', $website));
		}
		else 
		{
			$publishedQuery->add(Restrictions::isNotEmpty('website'));
		}
		$queryIntersection->add($publishedQuery);
		$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_event/baseevent');
		$queryIntersection->setDocumentModel($model);
		return $queryIntersection;
	}
	
	/**
	 * @param event_persistentdocument_highlight $highlight
	 * @return rss_FeedWriter
	 */
	public function getRSSFeedWriter($highlight, $limit)
	{
		$writer = new rss_FeedWriter();
		$ids = $this->getQueryIntersection($highlight, null, true)->findIds();
		$query = event_BaseeventService::getInstance()->createQuery();
		$query->add(Restrictions::published())->add(Restrictions::in('id', $ids));
		$query->addOrder(Order::desc('date'))->addOrder(Order::asc('endDate'))->addOrder(Order::desc('label'));
		foreach ($query->setMaxResults($limit)->find() as $doc)
		{
			$writer->addItem($doc);
		}
		return $writer;
	}
		
	/**
	 * @param event_persistentdocument_highlight $document
	 * @return boolean
	 */
	public function canSendTweetOnContainedDocumentPublish($document)
	{
		return false;
	}
	
	/**
	 * @param event_persistentdocument_highlight $document
	 * @param string $modelName
	 * @return integer[]
	 */
	public function getContainedIdsForTweet($document, $modelName)
	{
		$dfs = f_persistentdocument_DocumentFilterService::getInstance();
		$queryIntersection = $dfs->getQueryIntersectionFromJson($document->getQuery());
		$queryIntersection->add(event_BaseeventService::getInstance()->createQuery()->add(Restrictions::published()));
		return $queryIntersection->findIds();
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