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
	 * @param website_persistentdocument_website $website
	 * @param date_Calendar $startDate
	 * @param date_Calendar $endDate
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	public function getPublishedCountByWebsiteAndPeriod($website, $startDate, $endDate, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		$query->add(Restrictions::andExp(Restrictions::le('date', $endDate->toString()), Restrictions::ge('endDate', $startDate->toString())));
		return $this->findPublishedCount($query, $modelNames, $withoutExcludedFromRss);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param date_Calendar $startDate
	 * @param date_Calendar $endDate
	 * @param integer $offset
	 * @param integer $limit
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	public function getPublishedByWebsiteAndPeriod($website, $startDate, $endDate, $offset, $limit, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		$query->add(Restrictions::andExp(Restrictions::le('date', $endDate->toString()), Restrictions::ge('endDate', $startDate->toString())));
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
	 * @param website_persistentdocument_website $website
	 * @param integer $month
	 * @param integer $year
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer[]
	 */
	public function getPublishedDaysCountByWebsiteAndMonth($website, $month, $year, $modelNames = null, $withoutExcludedFromRss = false)
	{
		$startDate = date_Calendar::getInstanceFromFormat($year.'-'.$month.'-1', 'Y-m-d');
		$endDate = date_Calendar::getInstanceFromFormat($year.'-'.$month.'-1', 'Y-m-d')->add(date_Calendar::MONTH, 1)->sub(date_Calendar::SECOND, 1);
		$startDateString = date_Converter::convertDateToGMT($startDate)->toString();
		$endDateString = date_Converter::convertDateToGMT($endDate)->toString();
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		$query->add(Restrictions::andExp(Restrictions::le('date', $endDateString), Restrictions::ge('endDate', $startDateString)));
		$query = $this->completeQueryForPublished($query, $modelNames, $withoutExcludedFromRss);
		$query->setProjection(Projections::property('date'), Projections::property('endDate'));
		
		$counts = array();
		foreach ($query->find() as $row)
		{
			$eventStartDate = date_Calendar::getInstance(max($row['date'], $startDateString));
			$eventEndDate = date_Calendar::getInstance(min($row['endDate'], $endDateString));
			while ($eventStartDate->isBefore($eventEndDate, false))
			{
				$day = $eventStartDate->getDay();
				if (!isset($counts[$day]))
				{
					$counts[$day] = 1;
				}
				else
				{
					$counts[$day]++;
				}
				$eventStartDate->add(date_Calendar::DAY, 1);
			}
		}
		return $counts;
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return integer
	 */
	protected function findPublishedCount($query, $modelNames, $withoutExcludedFromRss)
	{
		$query = $this->completeQueryForPublished($query, $modelNames, $withoutExcludedFromRss);
		$query->setProjection(Projections::rowCount('count'));
		return f_util_ArrayUtils::firstElement($query->findColumn('count'));
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @param integer $offset
	 * @param $limit $offset
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return event_persistentdocument_baseevent[]
	 */
	protected function findPublished($query, $offset, $limit, $modelNames, $withoutExcludedFromRss)
	{
		$query = $this->completeQueryForPublished($query, $modelNames, $withoutExcludedFromRss);
		$query->addOrder(Order::desc('date'))->addOrder(Order::asc('endDate'))->addOrder(Order::desc('label'));
		$query->setFirstResult($offset)->setMaxResults($limit);
		return $query->find();
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @param string[] $modelNames
	 * @param boolean $withoutExcludedFromRss
	 * @return f_persistentdocument_criteria_Query
	 */
	protected function completeQueryForPublished($query, $modelNames, $withoutExcludedFromRss)
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
		return $query;
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
		return null;
	}
	
	/**
	 * @param website_UrlRewritingService $urlRewritingService
	 * @param event_persistentdocument_baseevent $document
	 * @param website_persistentdocument_website $website
	 * @param string $lang
	 * @param array $parameters
	 * @return f_web_Link | null
	 */
	public function getWebLink($urlRewritingService, $document, $website, $lang, $parameters)
	{
		$linkedPage = $document->getLinkedpage();
		if ($linkedPage instanceof website_persistentdocument_page)
		{
			unset($parameters['eventParam[topicId]']);
			unset($parameters['eventParam']['topicId']);
			return $urlRewritingService->getDocumentLinkForWebsite($linkedPage, null, $lang, $parameters);
		}
		
		if (isset($parameters['eventParam[topicId]']))
		{
			$topicId = $parameters['eventParam[topicId]'];
		}
		elseif (isset($parameters['eventParam']['topicId']))
		{
			$topicId = $parameters['eventParam']['topicId'];
		}
		else { return null; }
		
		$twebsite = website_WebsiteService::getInstance()->getByDescendentId($topicId);
		if ($twebsite !== null && $twebsite !== $website)
		{
			return $urlRewritingService->getDocumentLinkForWebsite($document, $twebsite, $lang, $parameters);
		}
		return null;
	}

	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param website_persistentdocument_website $website
	 */
	public function getPrimaryTopicForWebsite($document, $website)
	{
		$topics = $document->getPublishedTopicArray();
		$topicIds = DocumentHelper::getIdArrayFromDocumentArray($topics);
		
		$query = website_TopicService::getInstance()->createQuery()->add(Restrictions::descendentOf($website->getId()));
		$query->add(Restrictions::published())->add(Restrictions::in('id', $topicIds))->setProjection(Projections::property('id'));
		$ids = $query->findColumn('id');
		
		foreach ($topics as $topic)
		{
			if (in_array($topic->getId(), $ids))
			{
				return $topic;
			}
		}
		return null;
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections = null)
	{
		$resume = parent::getResume($document, $forModuleName, $allowedSections);
		
		if ($document->getAuthorEmail())
		{
			$authorInfos = array();
			$authorInfos['email'] = $document->getAuthorEmail(); 
			$authorInfos['firstName'] = $document->getAuthorFirstName(); 
			$authorInfos['lastName'] = $document->getAuthorLastName(); 
			$authorInfos['websiteUrl'] = $document->getAuthorWebsiteUrl();
			
			$websiteId = $document->getSubmissionWebsiteId();
			if ($websiteId)
			{
				try 
				{
					$website = website_persistentdocument_website::getInstanceById($websiteId);
					$authorInfos['submissionWebsite'] = $website->getLabel();
				}
				catch (Exception $e)
				{
					$authorInfos['submissionWebsite'] = LocaleService::getInstance()->transBO('m.event.bo.general.unexisting-website');
				}
			}
			
			$resume['authorinfos'] = $authorInfos;
		}
		
		return $resume;
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
	 * @return f_persistentdocument_PersistentDocument[]
	 */
	public function getContainersForTweets($document)
	{
		$containers = $document->getCategoryArray();
		$containers[] = $this->getParentOf($document);
		return $containers;
	}
		
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return $document->getPublishedWebsiteArray();
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */
	public function addTreeAttributes($document, $moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['date'] = date_Formatter::formatBO($document->getUIDate());
	}
	
	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param event_persistentdocument_treefolder $folder
	 * @param string $websiteId
	 * @param string $lang
	 */
	public function sendSubmissionNotification($event, $folder, $websiteId = null, $lang = null)
	{
		$model = $event->getPersistentModel();
		$suffix = $model->getModuleName() . '-' . $model->getDocumentName();
		$ns = notification_NotificationService::getInstance();
		$notif = $ns->getConfiguredByCodeNameAndSuffix('modules_event/baseeventsubmitted', $suffix, $websiteId, $lang);
		if ($notif instanceof notification_persistentdocument_notification)
		{
			$permissionService = f_permission_PermissionService::getInstance();
			$roleName = $permissionService->resolveRole('NotifiedForSubmissions', $folder->getId());
			$userIds = $permissionService->getUsersByRoleAndDocumentId($roleName, $folder->getId());
			$callback = array($event->getDocumentService(), 'getNotificationParameters');
			$params = array('document' => $event);
			foreach ($userIds as $userId)
			{
				$user = users_persistentdocument_user::getInstanceById($userId);
				$user->getDocumentService()->sendNotificationToUserCallback($notif, $user, $callback, $params);
			}
		}
	}
	
	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param string $message
	 * @return boolean
	 */
	public function sendMessageToAuthor($event, $message)
	{
		$email = $event->getAuthorEmail();
		if (!$email)
		{
			return false;
		}
		
		$model = $event->getPersistentModel();
		$suffix = $model->getModuleName() . '-' . $model->getDocumentName();
		$websiteId = $event->getSubmissionWebsiteId();
		$lang = $event->getI18nInfo()->getVo();
		$ns = notification_NotificationService::getInstance();
		$notif = $ns->getConfiguredByCodeNameAndSuffix('modules_event/messagetoauthor', $suffix, $websiteId, $lang);
		if ($notif instanceof notification_persistentdocument_notification)
		{
			$callback = array($event->getDocumentService(), 'getNotificationParameters');
			$params = array('document' => $event);
			$userId = $event->getAuthorid();
			if ($userId)
			{
				$params['specificParams'] = array('message' => f_util_HtmlUtils::textToHtml($message));
				$user = users_persistentdocument_user::getInstanceById($userId);
				return $user->getDocumentService()->sendNotificationToUserCallback($notif, $user, $callback, $params);
			}
			else 
			{
				$params['specificParams'] = array(
					'message' => f_util_HtmlUtils::textToHtml($message),
					'receiverFirstName' => $event->getAuthorFirstNameAsHtml(),
					'receiverLastName' => $event->getAuthorLastNameAsHtml(),
					'receiverFullName' => $user->getAuthorFullNameAsHtml(),
					'receiverTitle' => '',
					'receiverEmail' => $event->getAuthorEmailAsHtml()
				);
				$recipients = new mail_MessageRecipients($event->getAuthorEmail());
				return $notif->getDocumentService()->sendNotificationCallback($notif, $recipients, $callback, $params);
			}
		}
		return false;
	}
	
	/**
	 * @param array $infos
	 * @return array
	 */
	public function getNotificationParameters($infos)
	{
		$document = $infos['document'];
		$params = array(
			'documentLabel' => $document->getLabelAsHtml(),
			'documentDate' => date_Formatter::toDefaultDate($document->getUIDate()),
			'documentSummary' => $document->getSummaryAsHtml(),
			'documentText' => $document->getTextAsHtml(),
		);
		
		if (isset($infos['specificParams']) && is_array($infos['specificParams']))
		{
			return array_merge($params, $infos['specificParams']);
		}
		return $params;
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return string
	 */
	public function getDetailBlockModule($doc)
	{
		return $doc->getPersistentModel()->getModuleName();
	}
	
	/**
	 * @param event_persistentdocument_baseevent $document
	 * @return string
	 */
	public function getDetailBlockName($doc)
	{
		return $doc->getPersistentModel()->getDocumentName();
	}

	/**
	 * @return string
	 */
	public function getNewBlockModule()
	{
		return $this->getNewDocumentInstance()->getPersistentModel()->getModuleName();
	}
	
	/**
	 * @return string
	 */
	public function getNewBlockName()
	{
		return 'new' . ucfirst($this->getNewDocumentInstance()->getPersistentModel()->getDocumentName());
	}
}