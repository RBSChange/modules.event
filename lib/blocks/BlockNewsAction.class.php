<?php
/**
 * event_BlockNewsAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewsAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		return website_BlockView::SUCCESS;
	}
}