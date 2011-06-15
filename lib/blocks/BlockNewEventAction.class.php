<?php
/**
 * event_BlockNewEventAction
 * @package modules.event.lib.blocks
 */
class event_BlockNewEventAction extends event_BlockAbstractNewBaseeventAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @param event_persistentdocument_event $event
	 * @return String
	 */
	public function executeSubmit($request, $response, event_persistentdocument_event $event)
	{
		return parent::executeSubmit($request, $response, $event);
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