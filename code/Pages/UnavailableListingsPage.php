<?php

class UnavailableListingsPage extends Page {
	
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
	
	function requireDefaultRecords() {
		
		
			if(!SiteTree::get_by_link("listing-unavailable")){
				$listingPage = new UnavailableListingsPage();
				$listingPage->Title = "Listing Unavailable";
				$listingPage->URLSegment = "listing-unavailable";
				$listingPage->Sort = 1;
				$listingPage->write();
				$listingPage->publish('Stage', 'Live');
				$listingPage->flushCache();
				DB::alteration_message('Unavailable Listings page created', 'created');
			}
		
		parent::requireDefaultRecords();
	}
	
	
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


class UnavailableListingsPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
	public function RelatedListings() {
		$session = Session::get("UnavailListing");
		if ($session) {
			$filter = array(
				"Price:LessThan" => $session['Price'] + 50000,
				"Price:GreaterThan" => $session['Price'] - 50000
			);
			$cityFilter = array("CityID" => $session['City']);
			$townFilter = array("Town" => $session['Town']);
			if($session['City'])  $filter = array("Price:LessThan" => $session['Price'] + 50000, "Price:GreaterThan" => $session['Price'] - 50000, "CityID" => $session['City']);
			if($session['Town'])  $filter = array("Price:LessThan" => $session['Price'] + 50000, "Price:GreaterThan" => $session['Price'] - 50000, "Town" => $session['Town']);
			$listings = Listing::get()->filter($filter);
			$listings->count() ? $listings : false;
			
		} 
	}
	
}