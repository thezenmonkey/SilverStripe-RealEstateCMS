<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood DataObject 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
 
class Neighbourhood extends Community {
	/**
	 * Static vars
	 * ----------------------------------*/
	 
	//The class of the page which will list this DataObject
	private static $listing_page_class = 'NeighbourhoodsListingPage';
	//Class Naming (optional but reccomended)
	private static $plural_name = 'Neighbourhoods';
	private static $singular_name = 'Neighbourhood';
	


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
		'Name' => 'Varchar'
	);
	
	private static $has_one = array(
		'City' => 'City'
	);
		



	/**
	 * Common methods
	 * ----------------------------------*/
	
	
	
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Title');
		
		
		
		$cityField = new DropdownField('CityID', 'City', City::get()->map('ID', 'Title'));
		$cityField->setEmptyString('(Select one)');
		
		
		$fields->insertAfter( $cityField, 'Name');
		$fields->insertAfter( new ReadOnlyField('Title'), 'Name');
		
		return $fields;
			
	}
	
	function onBeforeWrite() {
	
		$this->Title = $this->City()->Title." - ".$this->Name;
		
		parent::onBeforeWrite();
		
	}
	
	
	
	/**
	 * Accessor methods
	 * ----------------------------------*/

	function getTitle() {
		if ($this->CityID){
			return $this->City()->Title." - ".$this->Name;
		} else {
			return $this->Name;
		}
	}
	
	function getURLSegment() {
		$URLFilter = URLSegmentFilter::create();
		if ($this->CityID){
			return $URLFilter->filter($this->City()->Title." ".$this->Name);
		} else {
			return $URLFilter->filter($this->Name);
		}
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