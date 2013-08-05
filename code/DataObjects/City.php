<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood DataObject 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
 
class City extends Community {
	/**
	 * Static vars
	 * ----------------------------------*/
	 
	//The class of the page which will list this DataObject
	private static $listing_page_class = 'CitiesPage';
	//Class Naming (optional but reccomended)
	private static $plural_name = 'Cities';
	private static $singular_name = 'City';
	


	/**
	 * Object vars
	 * ----------------------------------*/



	/**
	 * Static methods
	 * ----------------------------------*/



	/**
	 * Data model
	 * ----------------------------------*/
	
	private static $db = array(
		"Summary" => "HTMLText"
	);
	
	private static $has_one = array(
		"HeaderImage" => "Image",
	);
	
	
	private static $has_many = array(
		'Neighbourhoods' => 'Neighbourhood',
		'Listings' => 'Listing',
		'NeighbourhoodFeatures' => 'NeighbourhoodFeature',
		//'MLSListings' => 'MLSListing',
		'Pictures' => 'Image',
		//'Partners' => 'Partner',
	);
	
	private static $searchable_fields = array(
		'Title',
		'URLSegment'
	);


	/**
	 * Common methods
	 * ----------------------------------*/
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->insertAfter(new HTMLEditorField("Summary"), "Content");
		$fields->insertAfter(new UploadField('Pictures'), "Summary");
		
		
		return $fields;
			
	}
	
	 


	/**
	 * Accessor methods
	 * ----------------------------------*/


	/**
	 * Controller actions
	 * ----------------------------------*/

	public function TheseListings($count){
		
		$set = new ArrayList();
		if($count != "all"){
			//get own listings
			foreach($this->Listings()->where("Unavailable = 0")->sort(array("Price"=>"DESC"))->limit($count) as $obj) $set->push($obj);
			
			if($set->count() < $count) {
				$limit = $count - $set->count();
				//add any MLS Listings from Same City
				foreach($this->MLSListings()->sort("IsFeatured","DESC")->limit($limit) as $obj) $obj->Pictures()->count() ? $set->push($obj) : false;
				return $set;
			} else {
				return $set;
			}
		} else {
			foreach($this->Listings()->where("Unavailable = 0")->sort(array("Price"=>"DESC")) as $obj) $set->push($obj);
			foreach($this->MLSListings()->sort(array("IsFeatured"=>"DESC","ListPrice"=>"DESC")) as $obj) $set->push($obj);
			//foreach($this->Listings()->where("Sold = 1")->sort("LastEdited", "DESC")->limit(3) as $obj) $set->push($obj);
		}
		return $set;
		
	}
	
	
	public function OurListings($count){
		
		$set = new ArrayList();
		
		if($count != 'all') {
			foreach($this->Listings()->where("Unavailable = 0")->sort(array("Price"=>"DESC"))->limit($count) as $obj) $set->push($obj);
			
		} else {
			foreach($this->Listings()->where("Unavailable = 0")->sort(array("Price"=>"DESC")) as $obj) $set->push($obj);
			//foreach($this->Listings()->where("Sold = 1")->sort("LastEdited", "DESC")->limit(4) as $obj) $set->push($obj);
		}
		
		
		
		return $set;
		
	}
	
	public function TheirListings(){
		
		$set = new ArrayList();
		
		foreach($this->MLSListings()->sort("IsFeatured","DESC") as $obj) $set->push($obj);
		
		return $set;
		
	}
	
	public function getListings($count = null){
		
		$listings = $this->Listings()->where("Unavailable = 0")->sort(array("Price"=>"DESC"));
		
		if(!$listings->count()) {
			return false;
		}
		
		return $count ? $listings->limit($count) : $listings;
		
	}
	
	public function getMLSListings($count = null){
		
		$mlsListings = $this->MLSListings();
		
		if(!$mlsListings->count()) {
			return false;
		}
		
		return $count ? $$mlsListings->limit($count) : $$mlsListings;
		
	}
	
	function ContactForm() {
		  return new ContactForm($this, 'ContactForm');
	}
	
	function ShowListingsPage() {
		return ListingsPage::get()->where("City = ".$this->ID)->count() ? ListingsPage::get()->where("City = ".$this->ID)->First() : false;
	}


	/**
	 * Template accessors
	 * ----------------------------------*/



	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}