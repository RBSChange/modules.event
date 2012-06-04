<?php
/**
 * event_BlockBaseeventAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::NONE;
		}
	
		$context = $this->getContext();
		$isOnDetailPage = TagService::getInstance()->hasTag($context->getPersistentPage(), 'functional_event_baseevent-detail');
		$doc = $this->getDocumentParameter();
		if (!($doc instanceof event_persistentdocument_baseevent) || !$doc->isPublished())
		{
			if ($isOnDetailPage && !$this->isInBackofficePreview())
			{
				change_Controller::getInstance()->redirect("website", "Error404");
			}
			return website_BlockView::NONE;
		}
		else if ($isOnDetailPage)
		{
			$context->addCanonicalParam('topicId', null, 'event');
		}
		
		$config = $this->getConfiguration();
		$request->setAttribute('doc', $this->getDocumentParameter());
		$request->setAttribute('cmpref', $doc->getId());
		$request->setAttribute('isOnDetailPage', $isOnDetailPage);
		$request->setAttribute('displayConfig', $this->getDisplayConfig($request, $doc));
		$request->setAttribute('baseconfiguration', $config);
		$request->setAttribute('navigationPosition', $config->getNavigationPosition());
		$request->setAttribute('linkToTopic', $config->getLinkToTopic());
		$request->setAttribute('linkToAll', $config->getLinkToAll());
		$request->setAttribute('showTime', $config->getShowTime());
		$request->setAttribute('showCategories', $config->getShowCategories());

		return $this->forward($doc->getDetailBlockModule(), $doc->getDetailBlockName());
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param f_persistentdocument_PersistentDocument $doc
	 * @return array
	 */
	protected function getDisplayConfig($request, $doc)
	{
		return array();
	}
	
	/**
	 * @return array<String, String>
	 */
	public function getMetas()
	{
		$doc = $this->getDocumentParameter();
		if ($doc instanceof event_persistentdocument_baseevent && $doc->isPublished())
		{
			$uidate = date_Calendar::getInstance($doc->getUIDate());
			return array(
				'label' => $doc->getLabel(), 
				'summary' => f_util_HtmlUtils::htmlToText($doc->getSummary()),
				'type' => LocaleService::getInstance()->transFO($doc->getPersistentModel()->getLabelKey(), array('ucf')),
			 	'date' => date_Formatter::toDefaultDate($uidate),
			 	'datetime' => date_Formatter::toDefaultDateTime($uidate)
			);
		}
		return array();
	}
}