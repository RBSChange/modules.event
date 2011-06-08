<?php
/**
 * event_BlockCategoryContextualListAction
 * @package modules.event.lib.blocks
 */
class event_BlockCategoryContextualListAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackoffice())
		{
			return website_BlockView::NONE;
		}
		
		$modelNames = null;
		if ($this->getConfiguration()->getFilterByModel())
		{
			$modelNames = explode(',', $this->getConfiguration()->getIncludedModels());
		}
		
		$topic = $this->getContext()->getParent();
		$request->setAttribute('topic', $topic);
		$categoriesInfos = event_CategoryService::getInstance()->getPublishedInfosByTopic($topic, $modelNames);
		if (count($categoriesInfos) > 0)
		{
			$request->setAttribute('categoriesInfos', $categoriesInfos);
		}
		
		$request->setAttribute('blockTitle', $this->getConfiguration()->getBlockTitle());

		return website_BlockView::SUCCESS;
	}
}