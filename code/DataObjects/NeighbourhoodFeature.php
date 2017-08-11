<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
/**
 * 	
 * @package Realestate Listing System - Neighbourhood DataObject 
 * @requires DataObjectManager
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
 
class NeighbourhoodFeature extends DataObject {
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
	
	private static $db = array(
		'Name' => 'Varchar',
		'Address' => 'Varchar',
		'Town' => 'Varchar',
		'PostalCode' => 'Varchar(7)',
		'Lat' => 'Varchar',
		'Lon' => 'Varchar',
		'Type' => "Enum('Elementary School,Middle School,Secondary School,RC Elementary School,RC Middle School,RC Secondary School,College,Shopping,Church,Synagogue,Mosque')",
		'Grades' => 'Varchar',
		'Note' =>  'Varchar'
	);
	
	private static $has_one = array(
		'Neighbourhood' => 'NeighbourhoodPage',
		'City' => 'MunicipalityPage'
	);
	
	private static $belongs_many_many = array(
		'Listings' => 'Listing'
	);
	
	private static $summary_fields = array(
		'Name' => 'Name',
		'Type' => 'Type',
		'City.Title' => 'City'
		
	);
	
	private static $searchable_fields = array(
		'Name',
		'City.Title'
	);


	/**
	 * Common methods
	 * ----------------------------------*/
	 
	 
	  
	function getCMSFields() {
		$cityfield = new DropdownField('CityID', 'City', MunicipalityPage::get()->map('ID', 'Title'));
        $cityfield->setEmptyString('(Select one)');
		
		return new FieldList(
			new TextField('Name'),
			new TextField('Address'),
			$cityfield,
			new TextField('Town'),
			new TextField('PostalCode'),
			new DropdownField('Type','Type',singleton('NeighbourhoodFeature')->dbObject('Type')->enumValues()),
			new TextField('Grades'),
			new TextField('Note')
		);
	
	}
	  		
	function onBeforeWrite() {
		parent::onBeforeWrite();
		
		if ( is_null($this->Lat) || is_null($this->Lon) ) {
		
			$LatLon = Geocoder::Geocode($this->Address." ".$this->City()->Title." Ontario ".$this->PostalCode);
				
			if($LatLon) {
				$this->Lat = $LatLon["Lat"];
				$this->Lon = $LatLon["Lon"];
			}
		}
	
	}

	/**
	 * Accessor methods
	 * ----------------------------------*/

	public function getGeocoded() {
		if($this->Lat != 0) {
			return "coded";
		} else {
			return "uncoded";
		}
	}
	


	/**
	 * Controller actions
	 * ----------------------------------*/
	
	


	/**
	 * Template accessors
	 * ----------------------------------*/

	public function CleanType() {
		return str_replace(" ", "", $this->Type);
	}


	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}