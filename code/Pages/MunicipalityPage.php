<?php

class MunicipalityPage extends Community {
	
	/**
	 * Static vars
	 * ----------------------------------*/
	
	private static $hide_ancestor = 'Community';
	private static $singular_name = 'City';
    private static $plural_name = 'Cities';
    private static $description = 'Landing Page for Target Market City';
    private static $icon = 'realestate/images/communities.png';
	

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
		"Listings" => "Listing",
		"MLSListings" => "MLSListings"
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


class MunicipalityPage_Controller extends Community_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}