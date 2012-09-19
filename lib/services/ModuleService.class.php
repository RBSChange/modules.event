<?php
/**
 * @package modules.event
 * @method event_ModuleService getInstance()
 */
class event_ModuleService extends ModuleBaseService
{
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	public function getStructureInitializationAttributes($container, $attributes, $script)
	{
		switch ($script)
		{
			case 'globalDefaultStructure':
				return $this->getGlobalStructureInitializationAttributes($container, $attributes, $script);
				
			case 'localDefaultStructure' :
				return $this->getLocalStructureInitializationAttributes($container, $attributes, $script);
			
			default:
				throw new BaseException('Unknown structure initialization script: '.$script, 'm.website.bo.actions.unknown-structure-initialization-script', array('script' => $script));
		}
	}
	
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	protected function getGlobalStructureInitializationAttributes($container, $attributes, $script)
	{
		// Check container.
		if (!$container instanceof website_persistentdocument_topic)
		{
			throw new BaseException('Invalid topic', 'm.event.bo.general.Invalid-topic');
		}
		$websiteId = $container->getDocumentService()->getWebsiteId($container);
	
		$website = DocumentHelper::getDocumentInstance($websiteId, 'modules_website/website');
		if (TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_event_baseeventalllist', $website) || 
			TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_event_baseeventdaylist', $website) || 
			TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_event_category', $website) || 
			TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_event_highlight', $website))
		{
			throw new BaseException('Invalid topic', 'm.website.bo.actions.invalid-topic');
		}
		
		// Set atrtibutes.
		$attributes['byDocumentId'] = $container->getId();
		$attributes['type'] = $container->getPersistentModel()->getName();
		return $attributes;
	}
	
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	protected function getLocalStructureInitializationAttributes($container, $attributes, $script)
	{
		// Check container.
		if (!$container instanceof website_persistentdocument_topic)
		{
			throw new BaseException('Invalid topic', 'm.event.bo.general.Invalid-topic');
		}
		
		$query = website_PageService::getInstance()->createQuery()->add(Restrictions::orExp(
			Restrictions::hasTag('functional_event_baseevent-list'),
			Restrictions::hasTag('functional_event_baseevent-detail')
		));
		$query->add(Restrictions::childOf($container->getId()))->setProjection(Projections::rowCount('count'));
		if (f_util_ArrayUtils::firstElement($query->findColumn('count')) > 0)
		{
			throw new BaseException('Invalid topic', 'm.website.bo.actions.invalid-topic');
		}
		
		// Set atrtibutes.
		$attributes['byDocumentId'] = $container->getId();
		$attributes['type'] = $container->getPersistentModel()->getName();
		return $attributes;
	}
}