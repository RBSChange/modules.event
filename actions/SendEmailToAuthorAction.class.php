<?php
/**
 * event_SendEmailToAuthorAction
 * @package modules.event.actions
 */
class event_SendEmailToAuthorAction extends change_JSONAction
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		$result = array();

		$event = event_persistentdocument_baseevent::getInstanceById($request->getParameter('cmpref'));
		$message = $request->getParameter('message');
		if (!$event->getDocumentService()->sendMessageToAuthor($event, $message))
		{
			return $this->sendJSONError(LocaleService::getInstance()->transBO('m.event.bo.general.error-on-mail-sending', array('ucf')));
		}

		return $this->sendJSON($result);
	}
}