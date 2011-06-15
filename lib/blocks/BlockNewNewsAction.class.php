<?php
/**
 * event_BlockNewNewsAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewNewsAction extends event_BlockAbstractNewBaseeventAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @param event_persistentdocument_news $news
	 * @return String
	 */
	public function executeSubmit($request, $response, event_persistentdocument_news $news)
	{
		return parent::executeSubmit($request, $response, $news);
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @param event_persistentdocument_news $news
	 * @return String
	 */
	public function executePreview($request, $response, event_persistentdocument_news $news)
	{
		$request->setAttribute('news', $news);
		return $this->getInputViewName();
	}
}