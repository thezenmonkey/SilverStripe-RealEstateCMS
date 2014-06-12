<?php

class MapPage extends Page {
	
	/**
	 * Static vars
	 * ----------------------------------*/
	
	

	/**
	 * Object vars
	 * ----------------------------------*/
	
	
	
	/**
	 * Static methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Data model
	 * ----------------------------------*/

	private static $db = array (
		
	);
	

	private static $has_one = array (
		
	);
	
	private static $has_many = array (
		
	);
	
	/**
	 * Common methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Accessor methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Controller actions	
	 * ----------------------------------*/
	
	
	
	/**
	 * Template accessors
	 * ----------------------------------*/
	
	
	
	/**
	 * Object methods
	 * ----------------------------------*/

	 public function Items() {
		 return ListingUtils::BoundsQuery("MLSListing", array('north' => 43.71007507416407, 'south' => 43.211681801365906, 'east' => -78.93882785156251, 'west' => -80.42198214843751));
	 }
	

	
}


class MapPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array (
		"GetListingsList",
		"GetListing"
	);

	public function init() {
		Requirements::javascript("http://maps.google.com/maps/api/js?sensor=false");	
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript("realestate/javascript/gmap3.min.js");
		
		parent::init();
		
		
	}
	
}