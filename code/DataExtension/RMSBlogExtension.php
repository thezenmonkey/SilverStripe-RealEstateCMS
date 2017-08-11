<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
/**
 * Extensions for connecting SilverStripe Blog module and RMS	
 * @package Real Estate Manaagemtn System
 * @author Richard Rudy @thezenmonkey http://designplusawesome.com
 */

/**
 * Extend BlogEntry to include community
 */

class RMSBlogExtension extends DataExtension {
	/*

	private static $db = array(
		
	);
	
	private static $has_one = array(
		
	);
	
	private static $has_many = array(
		
	);
	*/
	private static $many_many = array(
		"Communities" => "Community"
	);

	public function updateCMSFields(FieldList $fields) {
		
		$fields->insertAfter(TreeMultiselectField::create("Communities","Communities","Community","ID","Title")->setSourceObject("Community"), "Tags");
		
		if ($this->owner->ParentID == 0) {
			$blogHolder = BlogHolder::get();
			
			if($blogHolder->count() > 1) {
				$fields->insertAfter(DropdownField::create("ParentID","Blog", $blogHolder->map("ID","Title"), $this->owner->ParentID), "MenuTitle");
			} else {
				$fields->insertAfter(HiddenField::create("ParentID","Blog ID", $blogHolder->First()->ID), "MenuTitle");
			}
			
		} else {
			$fields->insertAfter(HiddenField::create("ParentID","Blog ID", $this->owner->ParentID), "MenuTitle");
		}
	}
	
	public function Listings($count = null) {
		$communities = $this->owner->Communities()->filter(array("ClassName"=>"NeighbourhoodPage"));
		if($communities->count()) {
			$listings = new ArrayList();
			foreach($communities as $community) {
				
				$localList = $community->Listings()->filter(array("Status" => "Available"));
				
				if($localList->count()){
					foreach($localList as $listing) {
						$listings->push($listing);
					}
					
				}
			}
			return $listings->count() ? $listings : false;
			
		} else {
			return false;
		}
		
		
	}
	/*
public function onBeforeWrite() {
		if ( !$this->owner->ParentID || $this->owner->ParentID == 0 ) {
			$blogTree = BlogHolder::get()->First();
			$this->owner->setParent($blogTree);
		}
		
		parent::onBeforeWrite();
	}
*/
}

/**
 * Extend Community to include BlogEntry
 */

class BlogCommunityExtension extends DataExtension {
	
	private static $db = array(
		
	);
	
	private static $has_one = array(
		
	);
	
	private static $has_many = array(
		
	);
	
	private static $belongs_many_many = array(
		"BlogEntries" => "BlogEntry"
	);
}