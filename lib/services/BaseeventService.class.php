<?php
/**
 * event_BaseeventService
 * @package modules.event
 */
class event_BaseeventService extends f_persistentdocument_DocumentService
{
	/**
	 * @var event_BaseeventService
	 */
	private static $instance;

	/**
	 * @return event_BaseeventService
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
	 * @return event_persistentdocument_baseevent
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_event/baseevent');
	}

	/**
	 * Create a query based on 'modules_event/baseevent' model.
	 * Return document that are instance of modules_event/baseevent,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_event/baseevent');
	}
	
	/**
	 * Create a query based on 'modules_event/baseevent' model.
	 * Only documents that are strictly instance of modules_event/baseevent
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_event/baseevent', false);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountAnywhere($modelNames = null, $withoutExcludedFromRss = false)
	{
		return $this->findPublishedCount($this->createQuery(), $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedAnywhere($offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		return $this->findPublished($this->createQuery(), $offset, $limit, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountByWebsite($website, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		return $this->findPublishedCount($query, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedByWebsite($website, $offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		return $this->findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_topic $topic
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountByTopic($topic, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('topic', $topic));
		return $this->findPublishedCount($query, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_topic $topic
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedByTopic($topic, $offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('topic', $topic));
		return $this->findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss);
	}
		
	/**
	 * @param event_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountByCategoryAndWebsite($category, $website, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('website', $website));
		return $this->findPublishedCount($query, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param event_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedByCategoryAndWebsite($category, $website, $offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('website', $website));
		return $this->findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss);
	}
		
	/**
	 * @param event_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountByCategoryAndTopic($category, $topic, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('topic', $topic));
		return $this->findPublishedCount($query, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param event_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedByCategoryAndTopic($category, $topic, $offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('topic', $topic));
		return $this->findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return f_persistentdocument_criteria_Query
	 */
	protected function findPublishedCount($query, $modelNames, $withoutExcludedFromRss)
	{
		$query->add(Restrictions::published())->add(Restrictions::isNotEmpty('website'));
		if ($withoutExcludedFromRss)
		{
			$query->add(Restrictions::eq('excludeFromRss', false));
		}
		if (is_array($modelNames) && count($modelNames) > 0)
		{
			$query->add(Restrictions::in('model', $modelNames));
		}
		$query->setProjection(Projections::rowCount('count'));
		return f_util_ArrayUtils::firstElement($query->findColumn('count'));
	}
	
	/**
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return f_persistentdocument_criteria_Query
	 */
	protected function findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss)
	{
		$query->add(Restrictions::published())->add(Restrictions::isNotEmpty('website'));
		if ($withoutExcludedFromRss)
		{
			$query->add(Restrictions::eq('excludeFromRss', false));
		}
		if (is_array($modelNames) && count($modelNames) > 0)
		{
			$query->add(Restrictions::in('model', $modelNames));
		}
		$query->addOrder(Order::desc('date'))->addOrder(Order::asc('endDate'))->addOrder(Order::desc('label'));
		$query->setFirstResult($offset)->setMaxResults($limit);
		return $query->find();
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		if ($document->isPropertyModified('topic'))
		{
			$this->refreshWebsites($document);
		}
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 */
	public function refreshWebsites($document)
	{
		$websiteIds = array();
		foreach ($document->getTopicArray() as $topic)
		{
			$websiteIds[] = $topic->getDocumentService()->getWebsiteId($topic);
		}
		$websites = website_WebsiteService::getInstance()->createQuery()->add(Restrictions::in('id', $websiteIds))->find();
		$document->setWebsiteArray($websites);
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return integer | null
	 */
	public function getWebsiteId($document)
	{
		$website = $document->getWebsite(0);
		return ($website !== null) ? $website->getId() : null;
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return integer[] | null
	 */
	public function getWebsiteIds($document)
	{
		$websites = $document->getWebsiteArray();
		return DocumentHelper::getIdArrayFromDocumentArray($websites);
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return website_persistentdocument_page | null
	 */
	public function getDisplayPage($document)
	{
		$linkedPage = $document->getLinkedpage();
		if ($linkedPage instanceof website_persistentdocument_page)
		{
			return $linkedPage;
		}
		else
		{
			$request = HttpController::getInstance()->getContext()->getRequest();
			if ($request->hasModuleParameter('event', 'topicId'))
			{
				$topicId = $request->getModuleParameter('event', 'topicId');
			}
			else
			{
				$topic = $this->getPrimaryTopicForWebsite($document, website_WebsiteModuleService::getInstance()->getCurrentWebsite());
				$topicId = $topic ? $topic->getId() : null;
			}
			
			if ($topicId > 0)
			{
				return website_PageService::getInstance()->createQuery()
					->add(Restrictions::published())
					->add(Restrictions::childOf($topicId))
					->add(Restrictions::hasTag('functional_event_baseevent-detail'))
					->findUnique();
			}
		}
		return null;
	}
	
	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param website_persistentdocument_website $website
	 */
	public function getPrimaryTopicForWebsite($event, $website)
	{
		$query = website_TopicService::getInstance()->createQuery()->add(Restrictions::descendentOf($website->getId()));
		$query->add(Restrictions::published())->add(Restrictions::eq('baseevent', $event))->setMaxResults(1);
		return f_util_ArrayUtils::firstElement($query->find());
	}

	/**
	 * @param event_persistentdocument_baseevent $document
	 * @param integer $websiteId
	 * @return array
	 */
	public function getReplacementsForTweet($document, $websiteId)
	{
		$label = array(
			'name' => 'label',
			'label' => LocaleService::getInstance()->transBO('m.event.document.baseevent.label', array('ucf')),
			'maxLength' => 80
		);
		$shortUrl = array(
			'name' => 'shortUrl', 
			'label' => LocaleService::getInstance()->transBO('m.twitterconnect.bo.general.short-url', array('ucf')),
			'maxLength' => 30
		);
		if ($document !== null)
		{
			$website = website_persistentdocument_website::getInstanceById($websiteId);
			$label['value'] = f_util_StringUtils::shortenString($document->getLabel(), 80);
			$shortUrl['value'] = website_ShortenUrlService::getInstance()->shortenUrl(LinkHelper::getDocumentUrlForWebsite($document, $website));
		}
		return array($label, $shortUrl);
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return $document->getPublishedWebsiteArray();
	}
}