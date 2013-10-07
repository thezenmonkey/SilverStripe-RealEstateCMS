<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Listings Page 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */


class MLSListingsPage extends DataObjectAsPageHolder 
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

	


	/**
	 * Template accessors
	 * ----------------------------------*/



	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}

class MLSListingsPage_Controller extends DataObjectAsPageHolder_Controller 
{
	//This needs to know be the Class of the DataObject you want this page to list
	static $item_class = 'MLSListing';
	//Set the sort for the items (defaults to Created DESC)
	static $item_sort = 'Created DESC';
	
	 public function ListingRequestForm() {
		return new ListingRequestForm($this, 'ListingRequestForm');
	}
	
	
}