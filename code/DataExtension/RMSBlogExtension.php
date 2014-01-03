<?php
/**
 * Extensions for connecting SilverStripe Blog module and RMS	
 * @package Real Estate Manaagemtn System
 * @author Richard Rudy @thezenmonkey http://designplusawesome.com
 */

/**
 * Extend BlogEntry to inlude community
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
		
		$fields->insertAfter(TreeMultiselectField::create("Communities","Communities","MunicipalityPage","ID","Title"), "Tags");
		
	}

	
	/**
	 * Get Listings based on tags
	 *
	 * @param boolean - check City Titles
	 * @param booleran - check neighbourhood titles
	 * @param int - number to return
	 * @return DataList() 
	 * 
	 * @todo Actually Test it
	 */
	
	/*
public function GetListings($getCity, $getHood, $limit = null) {
		$tags = preg_split(" *, *", trim($this->owner->Tags));
		
		$filter = array();
		
		$getCity ? $filter = array_merge(array('City.Title' => $tags, 'Town' => $tags)) : false;
		$getHood ? $filter = array_merge(array('Neigbourhood.Title' => $tags)) : false;
		
		$filter2 = array();
		
		$listings = Listing::get()->filterAny($filter)->exclude('Status', 'Unavailable');
		
		return $listings->count() ? $listing->limit($limit) : false;
		
	}
*/
}

/**
 * Extend Community to inlude BlogEntry
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
	
	/*
public function updateCMSFields(FieldList $fields) {
		
	}
*/
}