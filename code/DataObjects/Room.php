<?php

/**
 * 	
 * @package Realestate Listing System - Room DataObject 
 * @requires DataObjectManager
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
 
 class Room extends DataObject {
 	/**
 	 * Static vars
 	 * ----------------------------------*/
 		
 
 
 	/**
 	 * Object vars
 	 * ----------------------------------*/
 
 
 
 	/**
 	 * Static methods
 	 * ----------------------------------*/
 	private static $db = array(
 		'Name' => 'Varchar',
 		'Type' => "Enum('Living Room,Dining Room,Kitchen,Family Room,Den,Laundry,Recreation Room,Bedroom,Bathroom,Utility,Storage,Garage,Other')",
 		'Level' => "Varchar",
 		'Length' => 'Varchar',
 		'Width' => 'Varchar',
 		'Note' => 'Varchar',
 		'Feature' => 'Boolean'
 	);
 	
 	private static $has_one = array(
 		'Listing' => 'Listing',
 		'MLSListing' => 'MLSListing'
 	);
 	
 	private static $has_many = array(
 		'Pictures' => 'Image'
 	);
 	
 	private static $summary_fields = array(
 		'Name', 'Level','Type', 'Width', 'Length'
 	);
 
 
 	/**
 	 * Data model
 	 * ----------------------------------*/
 
 
 
 	/**
 	 * Common methods
 	 * ----------------------------------*/
 	function getCMSFields() {
 		return new FieldList(
			new TextField('Name'),
			new DropdownField('Type','Type',singleton('Room')->dbObject('Type')->enumValues()),
			new TextField("Level"),
			new TextField('Length'),
			new TextField('Width'),
			new CheckboxField("Feature")
		);
 		
 	}
 	
 	function getCMSFields_forPopup() {
 		return new FieldList(
			new TextField('Name'),
			new DropdownField('Type','Type',singleton('Room')->dbObject('Type')->enumValues()),
			new TextField("Level"),
			new TextField('Length'),
			new TextField('Width'),
			new CheckboxField("Feature")
		);
 		
 	}
 
 	/**
 	 * Accessor methods
 	 * ----------------------------------*/
 	
 	public function getTitle() {
 		if($this->Type == "Other") {
 			return $this->Name;
 		} else { 
 			return $this->Name." ".$this->Type;
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