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
	
	public function getName() {
		if($this->ClassName = "NeighbourhoodPage") {
			return $this->Municipality()->Title." - ".$this->Title;
		} else {
			return $this->Title;
		}
	} 
	
	/**
	 * Get All Avaibalbe Listings (Status = Available)
	 *
	 * @return DataList
	 */
	
	public function AvailableListings() {
		 $listings = $this->Listings()->filter(array("Status" => "Available"))->sort(array("Feature" => "DESC", "ID" => "DESC"));
		 
		 return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Marked as Sold but Not Closed
	 *
	 * @return DatList
	 */
	public function SoldListings() {
		$listings = $this->Listings()->filter(array("Status" => "Sold"))->sort(array("ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Marked as Closed
	 *
	 * @return DatList
	 */
	public function ClosedListings() {
		$listings = $this->Listings()->filter(array("Status" => "Closed"))->sort(array("ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Available AND Sold
	 *
	 * @return DataList
	 */
	public function AllListings() {
		$listings = $this->Listings()->filter(array("Status" => array("Available","Sold")))->sort(array("Status" => "ASC", "ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Retun ALLlistings in the system regardless of Status
	 *
	 * @return DataList
	 */
	public function MasterListings() {
		$listings = $this->Listings();
		
		return $listings->count() ? $listings : false;
	}
	
	/**
	 * Retun MLS Listings 
	 *
	 * @param $count number of listings to return
	 * @return DataList
	 */
	public function AllMLSListings($count = null) {
		
		if(!is_null($count)) {
			$listings = $this->MLSListings()->limit($count);
		} else {
			$listings = $this->MLSListings();
		}
		
		return $listings->count() ? $listings : false;
	}
	
	/**
	 * Retun Only Featured MLS Listings 
	 *
	 * @param $count number of listings to return
	 * @return DataList
	 */
	public function FeaturedMLSListings($count = null) {
		
		if(!is_null($count)) {
			$listings = $this->MLSListings()->filter(array("IsFeatured" => 1))->limit($count);
		} else {
			$listings = $this->MLSListings()->filter(array("IsFeatured" => 1));
		}
		
		return $listings->count() ? $listings : false;
	}
	
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