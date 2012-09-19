<?php
/**
 * @package modules.event
 * @method event_ListAvailablemodelsService getInstance()
 */
class event_ListAvailablemodelsService extends change_BaseService implements list_ListItemsService
{
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
			if ($model->getName() == $modelName)
			{
				$items[] = new list_Item($ls->trans($model->getLabelKey(), array('ucf')), $modelName);
			}
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