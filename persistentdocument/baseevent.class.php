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
		return $this->getDocumentService()->getDetailBlockModule($this);
	}
	
	/**
	 * @return string
	 */
	public function getDetailBlockName()
	{
		return $this->getDocumentService()->getDetailBlockName($this);
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
	
	/**
	 * @return string
	 */
	public function getAuthorEmail()
	{
		return $this->getMeta('authorEmail');
	}
	
	/**
	 * @return string
	 */
	public function getAuthorEmailAsHtml()
	{
		return f_util_HtmlUtils::textToHtml($this->getAuthorEmail());
	}
	
	/**
	 * @return string
	 */
	public function setAuthorEmail($value)
	{
		return $this->setMeta('authorEmail', $value ? $value : null);
	}
	
	/**
	 * @return string
	 */
	public function getAuthorFirstName()
	{
		return $this->getMeta('authorFirstName');
	}
	
	/**
	 * @return string
	 */
	public function getAuthorFirstNameAsHtml()
	{
		return f_util_HtmlUtils::textToHtml($this->getAuthorFirstName());
	}
	
	/**
	 * @return string
	 */
	public function setAuthorFirstName($value)
	{
		return $this->setMeta('authorFirstName', $value ? $value : null);
	}
	
	/**
	 * @return string
	 */
	public function getAuthorLastName()
	{
		return $this->getMeta('authorLastName');
	}
	
	/**
	 * @return string
	 */
	public function getAuthorLastNameAsHtml()
	{
		return f_util_HtmlUtils::textToHtml($this->getAuthorLastName());
	}
	
	/**
	 * @return string
	 */
	public function setAuthorLastName($value)
	{
		return $this->setMeta('authorLastName', $value ? $value : null);
	}
	
	/**
	 * @return string
	 */
	public function getAuthorFullName()
	{
		return $this->getAuthorFirstName() . ' ' . $this->getAuthorLastName();
	}
	
	/**
	 * @return string
	 */
	public function getAuthorFullNameAsHtml()
	{
		return f_util_HtmlUtils::textToHtml($this->getAuthorFullName());
	}
	
	/**
	 * @return string
	 */
	public function getAuthorWebsiteUrl()
	{
		return $this->getMeta('authorWebsiteUrl');
	}
	
	/**
	 * @return string
	 */
	public function getAuthorWebsiteUrlAsHtml()
	{
		return f_util_HtmlUtils::textToHtml($this->getAuthorWebsiteUrl());
	}
	
	/**
	 * @return string
	 */
	public function setAuthorWebsiteUrl($value)
	{
		return $this->setMeta('authorWebsiteUrl', $value ? $value : null);
	}
	
	/**
	 * @return integer
	 */
	public function getSubmissionWebsiteId()
	{
		return $this->getMeta('submissionWebsiteId');
	}
	
	/**
	 * @return integer
	 */
	public function setSubmissionWebsiteId($value)
	{
		return $this->setMeta('submissionWebsiteId', $value ? $value : null);
	}
}