<?php
/**
 * 	
 * @package Realestate Listing System - Property Listing Administration 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class ListingAdmin extends DataObjectAsPageAdmin {
   
	public static $managed_models = array(
		'Listing' => array("title" => 'Listings'), 
		'MLSListing'  => array("title" => 'MLS Listings'),
		'PrintAd' => array("title" => 'Print Ads')
	);

	static $url_segment = 'listings';
	static $menu_title = 'Listings';
	static $menu_icon = 'realestate/images/home.png';
	
	public function init() 
	{
	    parent::init();
		
	    //map interface JS
	    Requirements::javascript("http://maps.google.com/maps/api/js?sensor=false");
	    //Requirements::javascript("mysite/js/jquery-1.7.2.min.js");
	    
	    
	   // LeftAndMain::require_javascript("RealEstate/javascript/cmsmap.js");
	    Requirements::javascript("RealEstate/javascript/jquery.ui.map.min.js");
	}
	
	public function getList() {
		$list = parent::getList();
		// Always limit by model class, in case you're managing multiple
		if($this->modelClass == 'Listing') {
			$list->sort(array('Status' => 'ASC','Street' => 'ASC'));
		}
		return $list;
	}
}