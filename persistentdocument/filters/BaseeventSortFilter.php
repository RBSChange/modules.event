<?php
/**
 * event_BaseeventSortFilter
 * @package modules.event.persistentdocument.filters
 */
class event_BaseeventSortFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$info = new BeanPropertyInfoImpl('sorttype', 'String');
		$info->setListId('modules_event/sorttypefilter');
		$parameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		
		$this->setParameter('sorttype', $parameter);
	}
	
	/**
	 * @return String
	 */
	public static function getDocumentModelName()
	{
		return 'modules_event/baseevent';
	}

	/**
	 * Check a single given object.
	 * @param event_persistentdocument_baseevent $value
	 * @return boolean
	 */
	public function checkValue($value)
	{
		return true;
	}
	
	/**
	 * Get the query to find documents matching this filter.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function getQuery()
	{
		$query = event_BaseeventService::getInstance()->createQuery();
		if($this->getParameter('sorttype')->getValue() === 'asc')
		{
			$query->addOrder(Order::asc('date'));
		}
		else
		{
			$query->addOrder(Order::desc('date'));
		}
		return $query;
	}
}