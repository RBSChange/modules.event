<?php
/**
 * event_ViewFeedAction
 * @package modules.event.actions
 */
class event_ViewFeedAction extends change_Action
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		try 
		{
			$parentId = $request->getParameter('parentref');
			$parent = DocumentHelper::getDocumentInstance($parentId);
			if (!$parent->isPublished())
			{
				throw new Exception('Unpublished parent: ' . $parentId);
			}
			
			$limit = 50; // TODO parameter?
			$ds = $parent->getDocumentService();
			if (f_util_ClassUtils::methodExists($ds, 'getRSSFeedWriter'))
			{
				$writer = $ds->getRSSFeedWriter($parent, $limit);
			}
			else
			{
				$writer = new rss_FeedWriter();
				$bes = event_BaseeventService::getInstance();
				$getter = 'getPublishedBy' . ucfirst($parent->getPersistentModel()->getDocumentName());
				if (!f_util_ClassUtils::methodExists($bes, $getter))
				{
					throw new Exception('No method ' . $getter . ' in ' . get_class($bes));
				}
				foreach ($bes->{$getter}($parent, 0, $limit, null, true) as $doc)
				{
					$writer->addItem($doc);
				}
			}
			
			// Set the link, title and description of the feed.
			$title = $request->getModuleParameter('event', 'title');
			$writer->setTitle($title ? $title : $parent->getLabel());
			$writer->setDescription(f_util_HtmlUtils::htmlToText($parent->getDescriptionAsHtml()));
			$writer->setLink(LinkHelper::getDocumentUrl($parent));
		}
		catch (Exception $e)
		{
			$ls = LocaleService::getInstance();
			$writer = new rss_FeedWriter();
			$writer->setTitle($ls->trans('m.rss.fo.invalid-rss-feed-title', array('ucf')));
			$description = $ls->trans('m.rss.fo.invalid-rss-feed-description', array('ucf'));
			if (Framework::isInfoEnabled())
			{
				Framework::exception($e);
				$description .= " : " . $e->getMessage();
			}
			$writer->setDescription($description);
			$writer->setLink(website_WebsiteService::getInstance()->getCurrentWebsite()->getUrl());
		}
		$this->setContentType('text/xml');
		echo $writer->toString();
	}
	
	/**
	 * @return boolean
	 */
	public function isSecure()
	{
		return false;
	}
	
	/**
	 * @return boolean
	 */
	protected function isDocumentAction()
	{
		return false;
	}
}