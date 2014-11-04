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
		 	"SortOrder" => "Int",
		 	"Bio" => "HTMLText",
		 	"URLSegment" => "Varchar"
		 );
		 
		 static $has_many = array(
		 	"Testimonials" => "Testimonial",
		 	"Listings" => "Listing"
		 );
		 
		 static $has_one = array(
		 	"Headshot" => "Image",
		 	'Folder' => 'Folder',
		 );
		 
		 static $default_sort = array('SortOrder');
	
	
		/**
		 * Common methods
		 * ----------------------------------*/
	public function updateCMSFields(FieldList $fields) {
		
		$fields->removeFieldFromTab ( "Root", "Pictures");
		$fields->removeFieldFromTab ( "Root", "Folder");
		$fields->removeFieldFromTab ( "Root", "SortOrder");
		
		$fields->insertAfter(TextField::create("JobTitle", "Job Title"), "Surname");
		$fields->insertAfter(TextField::create("PhoneNumber"), "Password");
		$fields->insertAfter(TextField::create("Cell"), "PhoneNumber");
		$fields->insertAfter(HTMLEditorField::create("Bio"), "Cell");
		
		if($this->owner->FolderID != 0) {
			$fields->insertAfter(UploadField::create("Headshot")->setFolderName("/Uploads/Agents/".$this->owner->Folder()->Name), "Password");
		}
		$fields->addFieldToTab("Root.Main", TextField::create("SortOrder"));
	}
	
	function onBeforeWrite() {
		
		$filter = URLSegmentFilter::create();
		$folderName = $filter->filter($this->owner->Title);
			
		if ($this->owner->FolderID == 0) {
		
		
			/**
			* Find or Create Folder under assets/Homes named $address-$city 
			* Finds and attached the FolderID after its created
			*/
			$folderExists = Folder::find_or_make('Uploads/Agents/'.$folderName.'/');
			$this->owner->FolderID = $folderExists->ID;
		}
		
		if(!$this->owner->URLSegment) {
			$this->owner->URLSegment = $folderName;
		}
		
		parent::onBeforeWrite();
	}
	
	function requireDefaultRecords() {
		if(!Group::get()->filter(array("Code" => "team-member"))->First()){
			$group = new Group();
			$group->Title = "Team Member";
			$group->Code = "team-member";
			$group->Sort = 2;
			$group->write();
			$group->flushCache();
			DB::alteration_message('Team Member Group created', 'created');
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