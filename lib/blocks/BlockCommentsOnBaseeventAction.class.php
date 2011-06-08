<?php
/**
 * event_BlockCommentsOnBaseeventAction
 * @package modules.event.lib.blocks
 */
class event_BlockCommentsOnBaseeventAction extends comment_BlockCommentsBaseAction
{	
	/**
	 * @param f_mvc_Request $request
	 * @param event_persistentdocument_baseevent $target
	 */
	protected function getDisableRSS($request, $target)
	{
		return $target->getExcludeFromRss();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param event_persistentdocument_baseevent $target
	 */
	protected function getCloseComments($request, $target)
	{
		return !$target->getAllowComments();
	}
}