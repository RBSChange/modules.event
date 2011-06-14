<?php
/**
 * event_BlockNewNewsAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewNewsAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		$user = users_UserService::getInstance()->getCurrentFrontEndUser();
		if ($user !== null)
		{
			$request->setAttribute('authorEmail', $user->getEmail());
			$request->setAttribute('authorFirstName', $user->getFirstName());
			$request->setAttribute('authorLastName', $user->getLastName());
		}
		return $this->getInputViewName();
	}

	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @param event_persistentdocument_news $news
	 * @return String
	 */
	public function executeSubmit($request, $response, event_persistentdocument_news $news)
	{
		$news->setAuthorEmail($request->getParameter('authorEmail'));
		$news->setAuthorFirstName($request->getParameter('authorFirstName'));
		$news->setAuthorLastName($request->getParameter('authorLastName'));
		$news->setAuthorWebsiteUrl($request->getParameter('authorWebsiteUrl'));
		$news->save($request->getAttribute('baseconfiguration')->getDestinationFolder()->getId());
		
		return website_BlockView::SUCCESS;
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