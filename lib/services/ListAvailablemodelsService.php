<?php
/**
 * event_ListAvailablemodelsService
 * @package modules.event.lib.services
 */
class event_ListAvailablemodelsService extends BaseService implements list_ListItemsService
{
	/**
	 * @var event_ListAvailablemodelsService
	 */
	private static $instance;

	/**
	 * @return event_ListAvailablemodelsService
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
	 * @see list_persistentdocument_dynamiclist::getItems()
	 * @return list_Item[]
	 */
	public final function getItems()
	{
		$items = array();
		
		$ls = LocaleService::getInstance();
		$baseModel = f_persistentdocument_PersistentDocumentModel::getInstance('event', 'baseevent');
		foreach ($baseModel->getChildrenNames() as $modelName)
		{
			$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName($modelName);
			$items[] = new list_Item($ls->transBO($model->getLabelKey(), array('ucf')), $modelName);
		}
		
		return $items;
	}

	/**
	 * @var Array
	 */
	private $parameters = array();
	
	/**
	 * @see list_persistentdocument_dynamiclist::getListService()
	 * @param array $parameters
	 */
	public function setParameters($parameters)
	{
		$this->parameters = $parameters;
	}
}