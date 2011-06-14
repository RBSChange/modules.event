<?php
/**
 * event_BlockNewEventAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewEventAction extends website_BlockAction
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
	 * @param event_persistentdocument_event $event
	 * @return String
	 */
	public function executeSubmit($request, $response, event_persistentdocument_event $event)
	{
		$event->setAuthorEmail($request->getParameter('authorEmail'));
		$event->setAuthorFirstName($request->getParameter('authorFirstName'));
		$event->setAuthorLastName($request->getParameter('authorLastName'));
		$event->setAuthorWebsiteUrl($request->getParameter('authorWebsiteUrl'));
		$event->save($request->getAttribute('baseconfiguration')->getDestinationFolder()->getId());
		
		return website_BlockView::SUCCESS;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @param event_persistentdocument_event $event
	 * @return String
	 */
	public function executePreview($request, $response, event_persistentdocument_event $event)
	{
		$request->setAttribute('event', $event);
		return $this->getInputViewName();
	}
}