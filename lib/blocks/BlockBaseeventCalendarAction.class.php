<?php
/**
 * event_BlockBaseeventCalendarAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventCalendarAction extends website_BlockAction
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
		
		$dateParam = $this->findLocalParameterValue('date');
		if ($dateParam)
		{
			$date = date_Calendar::getInstanceFromFormat($dateParam, 'Y-m-d');
		}
		else
		{
			$date = date_Calendar::getInstance();
		}
		$request->setAttribute('date', date_Formatter::format($date, 'Y-m-d'));
		
		$website = website_WebsiteService::getInstance()->getCurrentWebsite();
		$modelNames = null;
		$filterByModel = $this->findLocalParameterValue('filterByModel');
		if ($filterByModel === true || $filterByModel === 'true')
		{
			$modelNames = explode(',', $this->findLocalParameterValue('includedModels'));
		}		
		$counts = event_BaseeventService::getInstance()->getPublishedDaysCountByWebsiteAndMonth($website, $date->getMonth(), $date->getYear(), $modelNames);
		$request->setAttribute('counts', $counts);
		
		$params = array('eventParam[date]' => '{date}');
		$request->setAttribute('dayUrl', LinkHelper::getTagUrl('contextual_website_website_modules_event_baseeventdaylist', null, $params));
		
		return $this->getConfiguration()->getDisplayMode();
	}
}