<?php
/**
 * event_BlockNewEventAction
 * @package modules.event.lib.blocks
 */
abstract class event_BlockAbstractNewBaseeventAction extends website_BlockAction
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
	 * @param event_persistentdocument_baseevent $event
	 * @return String
	 */
	public function executeSubmit($request, $response, $event)
	{
		$folder = $this->getDestinationFolder();
		$this->prepareDocument($event, $folder);
		$this->saveDocument($event, $folder);
		$this->sendSubmissionNotification($event, $folder);
		return website_BlockView::SUCCESS;
	}
	
	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param event_persistentdocument_treefolder $folder
	 */
	protected function prepareDocument($event, $folder)
	{
		$request = $this->getRequest();
		$event->setAuthorEmail($request->getParameter('authorEmail'));
		$event->setAuthorFirstName($request->getParameter('authorFirstName'));
		$event->setAuthorLastName($request->getParameter('authorLastName'));
		$event->setAuthorWebsiteUrl($request->getParameter('authorWebsiteUrl'));
		$event->setSubmissionWebsiteId(website_WebsiteModuleService::getInstance()->getCurrentWebsite()->getId());
	}
	
	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param event_persistentdocument_treefolder $folder
	 */
	protected function saveDocument($event, $folder)
	{
		$event->save($folder->getId());
	}

	/**
	 * @param event_persistentdocument_baseevent $event
	 * @param event_persistentdocument_treefolder $folder
	 */
	protected function sendSubmissionNotification($event, $folder)
	{
		$event->getDocumentService()->sendSubmissionNotification($event, $folder);
	}
	
	/**
	 * @return event_persistentdocument_treefolder
	 */
	protected function getDestinationFolder()
	{
		return $this->getRequest()->getAttribute('baseconfiguration')->getDestinationFolder();
	}
}