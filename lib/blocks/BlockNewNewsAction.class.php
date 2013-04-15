<?php
/**
 * event_BlockNewNewsAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewNewsAction extends event_BlockAbstractNewBaseeventAction
{
	/**
	 * @return string[]|null
	 */
	public function getNewsBeanInclude()
	{
		if (Framework::getConfigurationValue('modules/website/useBeanPopulateStrictMode') != 'false')
		{
			return array('label', 'date', 'detailvisual', 'summary', 'text', 'authorEmail', 'authorFirstName',
				'authorLastName', 'authorWebsiteUrl');
		}
		return null;
	}

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