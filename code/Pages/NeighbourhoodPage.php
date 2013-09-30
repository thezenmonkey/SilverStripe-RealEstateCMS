<?php

class NeighbourhoodPage extends Community {
	
	/**
	 * Static vars
	 * ----------------------------------*/
	
	
	private static $hide_ancestor = 'Community';

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
		"Listings" => "Listing"
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


class NeighbourhoodPage_Controller extends Community_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}