<?php
/**
 * Class where to put your custom methods for document event_persistentdocument_baseevent
 * @package modules.event.persistentdocument
 */
class event_persistentdocument_baseevent extends event_persistentdocument_baseeventbase implements indexer_IndexableDocument, rss_Item
{
	/**
	 * Get the indexable document
	 *
	 * @return indexer_IndexedDocument
	 */
	public function getIndexedDocument()
	{
		$indexedDoc = new indexer_IndexedDocument();
		$indexedDoc->setId($this->getId());
		$indexedDoc->setDocumentModel($this->getPersistentModel()->getName());
		$indexedDoc->setLabel($this->getLabel());
		$indexedDoc->setLang(RequestContext::getInstance()->getLang());
		$indexedDoc->setText(
			f_util_StringUtils::htmlToText($this->getSummary())
			. ' ' . f_util_StringUtils::htmlToText($this->getText())
		);
		return $indexedDoc;
	}
	
	/**
	 * @return string
	 */
	public function getListItemTemplateModule()
	{
		return $this->getPersistentModel()->getModuleName();
	}
	
	/**
	 * @return string
	 */
	public function getListItemTemplateName()
	{
		return ucfirst($this->getListItemTemplateModule()) . '-Inc-' . ucfirst($this->getPersistentModel()->getDocumentName()) . '-Item';
	}
	
	/**
	 * @return string
	 */
	public function getDetailBlockModule()
	{
		return $this->getPersistentModel()->getModuleName();
	}
	
	/**
	 * @return string
	 */
	public function getDetailBlockName()
	{
		return $this->getPersistentModel()->getDocumentName();
	}
	
	/**
	 * @return string
	 */
	public function getRSSLabel()
	{
		return $this->getLabel();
	}
	
	/**
	 * @return string
	 */
	public function getRSSDescription()
	{
		return $this->getSummaryAsHtml();
	}
	
	/**
	 * @return string
	 */
	public function getRSSGuid()
	{
		return LinkHelper::getDocumentUrl($this);
	}
	
	/**
	 * @return string
	 */
	public function getRSSDate()
	{
		return $this->getDate();
	}
}