<?php
/**
 * event_BlockCategoryAllListAction
 * @package modules.event.lib.blocks
 */
class event_BlockCategoryAllListAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return string
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::NONE;
		}
		
		$modelNames = null;
		if ($this->getConfiguration()->getFilterByModel())
		{
			$modelNames = explode(',', $this->getConfiguration()->getIncludedModels());
		}
		
		$cs = event_CategoryService::getInstance();
		$website = website_WebsiteService::getInstance()->getCurrentWebsite();
		$request->setAttribute('website', $website);
		$categoriesInfos = $cs->getPublishedInfosByWebsite($website, $modelNames);
		if (count($categoriesInfos) > 0)
		{
			$request->setAttribute('categoriesInfos', $categoriesInfos);
		}
		
		$request->setAttribute('blockTitle', $this->getConfiguration()->getBlockTitle());

		return website_BlockView::SUCCESS;
	}
}