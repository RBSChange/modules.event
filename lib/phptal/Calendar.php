<?php
// change:calendar
// <tal:block change:calendar="counts counts; dayUrl dayUrl />
// <tal:block change:calendar="counts counts; dayUrl dayUrl; date '2011-6-10'; templateModule 'event'; templateName 'default' />

/**
 * @package order.lib.phptal
 */
class PHPTAL_Php_Attribute_CHANGE_calendar extends ChangeTalAttribute 
{
	protected function evaluateAll()
	{
		return true;
	}

	/**
	 * @param array $params
	 * @return string
	 */
	public static function renderCalendar($params)
	{
		$moduleName = self::getFromParams('templateModule', $params);
		$moduleName = $moduleName ? $moduleName : 'event';
		$templateName = self::getFromParams('templateName', $params, 'default');
		$templateName = $templateName ? $templateName : 'default';
		$templateLoader = TemplateLoader::getInstance()->setMimeContentType(K::HTML);
		$templateLoader->setDirectory('templates')->setPackageName('modules_' . $moduleName);			
		$template = $templateLoader->load(ucfirst($moduleName) . '-Inc-Calendar-'.ucfirst($templateName));
		
		$counts = self::getFromParams('counts', $params, array());
		$dayUrl = self::getFromParams('dayUrl', $params, null);
		$now = date_Calendar::getInstance();
		$dateString = self::getFromParams('date', $params, null);
		$date = $dateString ? date_Calendar::getInstanceFromFormat($dateString, 'Y-m-d') : clone $now;
		$month = $date->getMonth();		
		$template->setAttribute('dateCalendar', $date);
		
		$weeks = array();
		$currentWeek = null;
		$isCurrentMonth = ($now->getYear() == $date->getYear() && $now->getMonth() == $date->getMonth());
		$tempDate = clone $date;
		$tempDate->setDay(1);
		while ($tempDate->getMonth() == $month)
		{
			$number = $tempDate->getDay();
			
			$classes = array();
			if ($isCurrentMonth && $now->getDay() == $number)
			{
				$classes[] = 'today';
			}
			if ($date->getDay() == $number)
			{
				$classes[] = 'current';
			}
			$day = array(
				'class' => implode(' ', $classes),
				'number' => $tempDate->getDay(),
				'count' => (isset($counts[$number]) ? $counts[$number] : 0)
			);
			if ($day['count'] && $dayUrl)
			{
				$day['url'] = str_replace('%7Bdate%7D', date_Formatter::format($tempDate, 'Y-m-d'), $dayUrl);
			}
			$dayOfWeek = ($tempDate->getDayOfWeek()+6)%7;
			if ($dayOfWeek == 0 && $currentWeek !== null)
			{
				$weeks[] = $currentWeek;
				$currentWeek = self::getClearWeek();
			}
			else if ($currentWeek === null)
			{
				$currentWeek = self::getClearWeek();
			}
			$currentWeek[$dayOfWeek] = $day;
			$tempDate->add(date_Calendar::DAY, 1);
		}
		$weeks[] = $currentWeek;
		$template->setAttribute('weeks', $weeks);
		
		if ($dayUrl)
		{
			$prevDate = clone $date;
			$prevDate->sub(date_Calendar::MONTH, 1);
			$template->setAttribute('previousMonthUrl', str_replace('%7Bdate%7D', date_Formatter::format($prevDate, 'Y-m-d'), $dayUrl));
			$nextDate = clone $date;
			$nextDate->add(date_Calendar::MONTH, 1);
			$template->setAttribute('nextMonthUrl', str_replace('%7Bdate%7D', date_Formatter::format($nextDate, 'Y-m-d'), $dayUrl));
		}		
		
		return $template->execute();
	}
	
	/**
	 * @return array
	 */
	private static function getClearWeek()
	{
		$week = array();
		for ($i = 0; $i < 7; $i++)
		{
			$week[] = array('number' => null);
		}
		return $week;
	}

	/**
	 * @param string $key
	 * @param array $params
	 * @return string
	 */
	private static function getFromParams($key, $params, $default = null)
	{
		return (array_key_exists($key, $params)) ? $params[$key] : $default;
	}
}