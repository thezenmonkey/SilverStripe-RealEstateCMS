<?php
/**
 * 	
 * @package Realestate Listing System - Property Listing Administration 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class ListingAdmin extends CatalogPageAdmin {
   
   private static $allowed_actions = array(
   		'EditorToolbar'
   );
   
   
	public static $managed_models = array(
		'Listing' => array("title" => 'Listings'),
		'MLSListing' => array("title" => 'MLS Listings'),
		'UnavailableListing' => array("title" => 'Unavailable Listings')
	);

	static $url_segment = 'listings';
	static $menu_title = 'Listings';
	static $menu_icon = 'realestate/images/home.png';
	
/*
	public function onBeforeInit() {
		Versioned::reading_stage('Stage');
	}
*/
	
	public function init() 
	{
	   // 
	    parent::init();
		
		Versioned::reading_stage('Stage');
	    //map interface JS
	    Requirements::javascript("http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCRMWuSPxE8ZrOrUSc9sJzHghKilvr7LkI");
	 	Requirements::javascript("realestate/javascript/cmsmap.js");
	    //Requirements::javascript("mysite/js/jquery-1.7.2.min.js");
	    
	    
	   // LeftAndMain::require_javascript("RealEstate/javascript/cmsmap.js");
	   Requirements::javascript("realestate/javascript/jquery.ui.map.full.min.js");
	   Requirements::css("realestate/css/realestatecms.css");
	}
	
	public function getList() {
		$list = parent::getList();
		// Always limit by model class, in case you're managing multiple
		
		if($this->modelClass == 'Listing') {
			$list = Versioned::get_by_stage('Listing', 'Stage');
			$list = $list->sort(array('Status' => 'ASC','Feature' => "DESC",'Street' => 'ASC'));
		}
		return $list;
	}
	
	public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
        // is managed by this ModelAdmin, the GridField for it will also be named 'Product'
        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        $gridField = $form->Fields()->fieldByName($gridFieldName);
        $gridField->getConfig()->removeComponentsByType('GridFieldDeleteAction');
        return $form;
    }
	
}