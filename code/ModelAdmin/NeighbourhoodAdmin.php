<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Admin 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class NeighbourhoodAdmin extends DataObjectAsPageAdmin {
   
	public static $managed_models = array(
		'City',
		'Neighbourhood',
		'NeighbourhoodFeature'
	);

	static $url_segment = 'communities';
	static $menu_title = 'Communities';
	static $menu_icon = 'realestate/images/communities.png';
	
	public function getEditForm($id = null, $fields = null) {

	    $form = parent::getEditForm($id = null, $fields = null);    
	    
		if(Singleton($this->modelClass)->isVersioned)
		{
		    $listfield = $form->Fields()->fieldByName($this->modelClass);
		
			$gridFieldConfig = $listfield->getConfig();
		
		    $gridFieldConfig->getComponentByType('GridFieldDetailForm')
		        ->setItemRequestClass('VersionedGridFieldDetailForm_ItemRequest');		
				
			$gridFieldConfig->removeComponentsByType('GridFieldDeleteAction');
			$gridFieldConfig->addComponent(new VersionedGridFieldDeleteAction());
		}
		
		if(Singleton($this->modelClass) == "NeighbourhoodFeature")
		{
		    $listfield = $form->Fields()->fieldByName($this->modelClass);
		
			$gridFieldConfig = $listfield->getConfig();
		
		    $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton')
				->addComponent(new GridFieldAddNewMultiClass());
		}

	    return $form;
	}
}