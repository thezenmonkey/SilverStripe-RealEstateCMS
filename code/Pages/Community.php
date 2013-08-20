<?php

class Community extends Page {
	
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
		"Municipality" => "MunicipalityPage"
	);
	
	private static $has_many = array (
		"Neighbourhoods" => "NeighbourhoodPage"
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


class Community_Controller extends Page_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}