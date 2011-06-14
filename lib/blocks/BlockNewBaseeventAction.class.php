<?php
/**
 * event_BlockNewBaseeventAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewBaseeventAction extends website_BlockAction
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
		
		$configuration = $this->getConfiguration();
		
		// Check the destinationfolder.
		if (!($configuration->getDestinationFolder() instanceof event_persistentdocument_treefolder))
		{
			return website_BlockView::NONE;
		}
		
		$selectedModelName = null;
		if ($request->hasParameter('modelName'))
		{
			$selectedModelName = $request->getParameter('modelName');
		}
		
		if ($configuration->getRestrictModel())
		{
			$modelNames = explode(',', $configuration->getAllowedModels());
		}
		else 
		{
			$baseModel = f_persistentdocument_PersistentDocumentModel::getInstance('event', 'baseevent');
			$modelNames = $baseModel->getChildrenNames();
		}		
		$request->setAttribute('blockTitle', $this->getBlockTitle($request, $modelNames));
		
		// Check registered user restriction.
		if ($configuration->getAllowNotRegistered() && users_UserService::getInstance()->getCurrentFrontEndUser() === null)
		{
			$agaviUser = Controller::getInstance()->getContext()->getUser();
			$agaviUser->setAttribute('illegalAccessPage', $_SERVER["REQUEST_URI"]);
			return 'Forbidden';
		}
				
		// If valid model selected, forward to the appropriate block.
		if ($selectedModelName && in_array($selectedModelName, $modelNames))
		{
			$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName($selectedModelName);
			$service = $model->getDocumentService();
			$request->setAttribute('baseconfiguration', $configuration);
			return $this->forward($service->getNewBlockModule(), $service->getNewBlockName());
		}
	
		// Choose the model.
		$ls = LocaleService::getInstance();
		if ($selectedModelName && !in_array($selectedModelName, $modelNames))
		{
			$this->addError($ls->transFO('m.event.fo.invalid-model', array('ucf')));
		}
		
		$modelOptions = array();
		foreach ($modelNames as $modelName)
		{
			$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName($modelName);
			$modelOptions[] = array('label' => $ls->transFO($model->getLabelKey(), array('ucf')), 'value' => $modelName);
		}
		$request->setAttribute('modelOptions', $modelOptions);
		return 'ModelSelection';
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return string
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = $this->getConfiguration()->getBlockTitle();
		if (!$title)
		{
			$title = LocaleService::getInstance()->transFO('m.event.fo.baseevent-submission', array('ucf', 'html'));
		}
		return $title;
	}
}