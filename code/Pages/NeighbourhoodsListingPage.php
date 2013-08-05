<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Listings Page 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */


class NeighbourhoodsListingPage extends DataObjectAsPageHolder 
{
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



	/**
	 * Common methods
	 * ----------------------------------*/



	/**
	 * Accessor methods
	 * ----------------------------------*/



	/**
	 * Controller actions
	 * ----------------------------------*/

	public function ajaxHood() {
			
	}


	/**
	 * Template accessors
	 * ----------------------------------*/



	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}

class NeighbourhoodsListingPage_Controller extends DataObjectAsPageHolder_Controller 
{
	//This needs to know be the Class of the DataObject you want this page to list
	private static $item_class = 'Neighbourhood';
	//Set the sort for the items (defaults to Created DESC)
	private static $item_sort = 'Title ASC';
	
	public function init() {
		
		
		
		
		parent::init();
		
	}
	function index() { // index runs if no other function is being called - it is like a second init()
	 if(Director::is_ajax()/* || $_GET["ajaxDebug"]*/) {
	 	return $this->renderWith(array('NeighbourhoodsListingPage_show_ajax'));
	 } else {
	 	return Array();
	 } 
	  
	}
	
}