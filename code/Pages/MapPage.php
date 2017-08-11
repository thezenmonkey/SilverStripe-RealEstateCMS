<?php

use SilverStripe\View\Requirements;
// use PageController;

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

	

	
}


class MapPage_Controller extends PageController {
	
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