<?php

/**
 * 	
 * @package
 * @author
 */
 
 
class Agent extends DataExtension {
			
	
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
		 	"SortOrder" => "Int"
		 );
		 
		 static $has_many = array(
		 	"Testimonials" => "Testimonial",
		 );
		 
		 static $has_one = array(
		 	"Headshot" => "Image",
		 	'Folder' => 'Folder',
		 );
	
	
		/**
		 * Common methods
		 * ----------------------------------*/
	function getCMSFields() {
		$fields = parent::getCMSFIelds();
		
		$fields->removeFieldFromTab ( "Root", "Pictures");
		$fields->removeFieldFromTab ( "Root", "Folder");
		
		
		
		$fields->insertBefore(new TextField("Title", "Name"), "JobTitle");
		$fields->insertAfter(UploadField::create("Headshot")->setFolderName("/assets/Agents/".$this->Folder()->Name), "SortOrder");
		$fields->insertAfter(GalleryUploadField::create('Pictures')->setFolderName("/assets/Agents/".$this->Folder()->Name), "Content");
		
		
		return $fields;
		
	}
	
	function onBeforeWrite() {
		if(!$this->ID) {
			
			if ($this->FolderID == 0) {
			
			
				/**
				* Find or Create Folder under assets/Homes named $address-$city 
				* Finds and attached the FolderID after its created
				*/
				$filter = URLSegmentFilter::create();
				$folderName = $filter->filter($this->Title);
				$folderExists = Folder::find_or_make('Uploads/Agents/'.$folderName.'/');
				$this->FolderID = $folderExists->ID;
			}
		}
		
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