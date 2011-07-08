<?php
/**
 * Class where to put your custom methods for document event_persistentdocument_event
 * @package modules.event.persistentdocument
 */
class event_persistentdocument_event extends event_persistentdocument_eventbase 
{
	/**
	 * @return boolean
	 */
	public function onOneDay()
	{
		$start = date_Calendar::getInstance($this->getDate());
		$end = date_Calendar::getInstance($this->getEndDate());
		return $start->getDay() == $end->getDay() && $start->getMonth() == $end->getMonth() && $start->getYear() == $end->getYear();
	}
	
	/**
	 * @return boolean
	 */
	public function onOneMinute()
	{
		$start = date_Calendar::getInstance($this->getDate());
		$end = date_Calendar::getInstance($this->getEndDate());
		return $start->getMinute() == $end->getMinute() && $start->getHour() == $end->getHour() && $this->isOneDay();
	}
}