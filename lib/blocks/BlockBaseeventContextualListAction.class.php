<?php
/**
 * event_BlockEventContextualListAction
 * @package modules.event.lib.blocks
 */
class event_BlockBaseeventContextualListAction extends event_BlockAbstractBaseeventListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return $this->getContext()->getParent();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param string[] $modelNames
	 * @return string
	 */
	protected function getBlockTitle($request, $modelNames)
	{
		$title = $this->getConfigurationValue('blockTitle');
		if (!$title)
		{
			$doc = $this->getParentDoc($request);
			$title = LocaleService::getInstance()->transFO('m.event.fo.topic-title', array('ucf', 'html'), array('topic' => $doc->getLabel()));
		}
		return $title;
	}
}