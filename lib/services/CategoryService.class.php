<?php
/**
 * @package modules.event
 * @method event_CategoryService getInstance()
 */
class event_CategoryService extends f_persistentdocument_DocumentService
{
	/**
	 * @return event_persistentdocument_category
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/category');
	}

	/**
	 * Create a query based on 'modules_event/category' model.
	 * Return document that are instance of modules_event/category,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/category');
	}
	
	/**
	 * Create a query based on 'modules_event/category' model.
	 * Only documents that are strictly instance of modules_event/category
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_event/category', false);
	}
	
	/**
	 * @param website_persistentdocument_topic $topic
	 * @param string[] $modelNames
	 * @return array each element is associative array with the category as 'category' and the event count as 'count'  
	 */
	public function getPublishedInfosByTopic($topic, $modelNames)
	{
		return $this->doGetPublishedInfos($topic, $modelNames);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @return array each element is associative array with the category as 'category' and the event count as 'count'
	 */
	public function getPublishedInfosByWebsite($website, $modelNames)
	{
		return $this->doGetPublishedInfos($website, $modelNames);
	}
	
	/**
	 * @param string[] $modelNames
	 * @return array each element is associative array with the category as 'category' and the event count as 'count'
	 */
	public function getPublishedInfos($modelNames)
	{
		return $this->doGetPublishedInfos(null, $modelNames);
	}
	
	/**
	 * @param f_persistentdocument_PersistentDocument $context
	 * @param string[] $modelNames
	 * @return array each element is associative array with the category as 'category' and the event count as 'count'
	 */
	protected function doGetPublishedInfos($context, $modelNames)
	{
		$query = $this->createQuery()->add(Restrictions::published());
		$criteria = $query->createCriteria('baseevent')->add(Restrictions::published());
		$criteria->setProjection(Projections::rowCount('count'));
		if (is_array($modelNames) && count($modelNames) > 0)
		{
			$criteria->add(Restrictions::in('model', $modelNames));
		}
		$query->setProjection(Projections::this())->addOrder(Order::iasc('label'));
		
		if ($context instanceof website_persistentdocument_topic)
		{
			$criteria->add(Restrictions::eq('topic', $context));
		}
		else if ($context instanceof website_persistentdocument_website)
		{
			$criteria->add(Restrictions::eq('website', $context));
		}
		else if ($context !== null)
		{
			Framework::warn(__METHOD__ . ' Context ignored: unexpected document type (' . get_class($context) . ')');
		}
		
		$rows = $query->find();
		$result = array();
		foreach ($rows as $row)
		{
			$result[] = array('category' => $row['this'], 'count' => $row['count']);
		}
		return $result;
	}
	
	/**
	 * @param event_persistentdocument_category $highlight
	 * @return rss_FeedWriter
	 */
	public function getRSSFeedWriter($category, $limit)
	{
		$bes = event_BaseeventService::getInstance();
		$writer = new rss_FeedWriter();
		$website = website_WebsiteService::getInstance()->getCurrentWebsite();
		foreach ($bes->getPublishedByCategoryAndWebsite($category, $website, 0, $limit, null, true) as $doc)
		{
			$writer->addItem($doc);
		}
		return $writer;
	}
	
	/**
	 * @param event_persistentdocument_category $document
	 * @return website_persistentdocument_page | null
	 */
	public function getDisplayPage($document)
	{
		$tag = 'contextual_website_website_modules_event_category';
		$website = website_WebsiteService::getInstance()->getCurrentWebsite();
		return TagService::getInstance()->getDocumentByContextualTag($tag, $website);
	}
	
	/**
	 * @param event_persistentdocument_category $document
	 * @return string[]
	 */
	public function getDocumentsModelNamesForTweet($document)
	{
		return array('modules_event/baseevent');
	}
	
	/**
	 * @param event_persistentdocument_category $document
	 * @return boolean
	 */
	public function canSendTweetOnContainedDocumentPublish($document)
	{
		return true;
	}
	
	/**
	 * @param event_persistentdocument_category $document
	 * @param string $modelName
	 * @return integer[]
	 */
	public function getContainedIdsForTweet($document, $modelName)
	{
		$query = event_BaseeventService::getInstance()->createQuery()->add(Restrictions::published());
		$query->add(Restrictions::eq('category', $document))->setProjection(Projections::property('id'));
		return $query->findColumn('id');
	}
	
	/**
	 * @param event_persistentdocument_category $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return website_WebsiteService::getInstance()->createQuery()->add(Restrictions::published())->find();
	}
}