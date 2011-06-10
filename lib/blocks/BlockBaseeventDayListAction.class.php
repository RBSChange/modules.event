<?php
/**
 * event_BlockBaseeventDayListAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventDayListAction extends event_BlockBaseeventBaseListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return website_WebsiteModuleService::getInstance()->getCurrentWebsite();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return boolean 
	 */
	protected function addRssFeeds($request)
	{
		return false;
	}	
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return integer 
	 */
	protected function getDocCount($request, $modelNames)
	{
		$bes = event_BaseeventService::getInstance();
		$parentDoc = $this->getParentDoc($request);
		list($startDate, $endDate) = $this->getPeriod($request);
		return $bes->getPublishedCountByWebsiteAndPeriod($parentDoc, $startDate, $endDate, $modelNames);
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param integer $offset
	 * @param integer $itemsPerPage
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	protected function getDocs($request, $offset, $itemsPerPage, $modelNames)
	{
		$bes = event_BaseeventService::getInstance();
		$parentDoc = $this->getParentDoc($request);
		list($startDate, $endDate) = $this->getPeriod($request);
		return $bes->getPublishedByWebsiteAndPeriod($parentDoc, $startDate, $endDate, $offset, $itemsPerPage, $modelNames);
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param integer $offset
	 * @param integer $itemsPerPage
	 * @param string[] $modelNames
	 * @return event_persistentdocument_baseevent
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = $this->getConfigurationValue('blockTitle');
		if (!$title)
		{
			$date = date_Calendar::getInstanceFromFormat($request->getParameter('date'), 'Y-m-d');
			$params = array('date' => date_Formatter::toDefaultDate($date));
			$title = LocaleService::getInstance()->transFO('m.event.fo.baseevents-of-day-title', array('ucf'), $params);
		}
		return $title;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return string[]
	 */
	protected function getPeriod($request)
	{
		$date = $request->getParameter('date');
		$startDate = date_Calendar::getInstanceFromFormat($date, 'Y-m-d')->setHour(0)->setMinute(0)->setSecond(0);
		$endDate = date_Calendar::getInstanceFromFormat($date, 'Y-m-d')->setHour(23)->setMinute(59)->setSecond(59);
		return array($startDate, $endDate);
	}
	
	/**
	 * @return array<String, String>
	 */
	public function getMetas()
	{
		$date = date_Calendar::getInstanceFromFormat($this->getRequest()->getParameter('date'), 'Y-m-d');
		return array('date' => date_Formatter::toDefaultDate($date));
	}
}