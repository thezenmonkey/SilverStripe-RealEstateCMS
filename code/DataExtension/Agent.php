<?php

/**
 * 	
 * @package
 * @author
 */
 
 
class Agent extends DataExtension {
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
	 
	 static $db = array(
	 	"JobTitle" => "Varchar",
	 	"PhoneNumber" => "Varchar",
	 	"Cell" => "Varchar",
	 	"Email" => "Varchar",
	 	"Bio" => "HTMLText",
	 	"SortOrder" => "Int"
	 );
	 
	 static $has_many = array(
	 	"Testimonials" => "Testimonial",
	 );
	 
	 static $has_one = array(
	 	"Headshot" => "Image",
	 );


	/**
	 * Common methods
	 * ----------------------------------*/
	function getCMSFields() {
		$fields = parent::getCMSFIelds();
		
		//$fields->removeFieldFromTab ( "Root", "Pictures");
		//$fields->removeFieldFromTab ( "Root", "Folder");
		
		
		
		$fields->insertBefore(new TextField("Title", "Name"), "JobTitle");
		$fields->insertAfter(UploadField::create("Headshot")->setFolderName("/assets/Team/"), "SortOrder");
		
		
		return $fields;
		
	}
	
	function onBeforeWrite() {
		
		parent::onBeforeWrite();
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