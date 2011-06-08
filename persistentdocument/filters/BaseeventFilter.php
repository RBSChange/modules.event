<?php
/**
 * event_BaseeventFilter
 * @package modules.event.persistentdocument.filters
 */
class event_BaseeventFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$parameter = f_persistentdocument_DocumentFilterRestrictionParameter::getNewInstance();
		$parameter->setAllowedPropertyNames(array(
			'modules_event/baseevent.creationdate',
			'modules_event/baseevent.date',
			'modules_event/baseevent.topic',
			'modules_event/baseevent.category'
		));
		$this->setParameter('property', $parameter);
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
		if ($value instanceof event_persistentdocument_baseevent)
		{
			$param = $this->getParameter('property');
			$restriction = $param->getRestriction();
			$val = $param->getParameter()->getValue();
			list(, $propertyName) = explode('.', $param->getPropertyName());
			$testVal = $this->getTestValueForPropertyName($value, $propertyName);
			return $this->evalRestriction($testVal, $restriction, $val);
		}
		return false;
	}

	/**
	 * Get the query to find documents matching this filter.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function getQuery()
	{
		$query = event_BaseeventService::getInstance()->createQuery();
		$query->add($this->getParameter('property')->getValueForQuery());
		return $query;
	}
}