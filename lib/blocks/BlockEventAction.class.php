<?php
/**
 * event_BlockEventAction
 * @package modules.event.lib.blocks
 */
class event_BlockEventAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		return $request->getAttribute('displayMode', website_BlockView::SUCCESS);
	}
}