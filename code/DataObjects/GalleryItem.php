<?php
class GalleryItem extends DataObject {
	
	private static $db = array (
		"SortOrder" => "Int",
		"Cover" => "Boolean"
	);
	
	private static $has_one = array (
		"Image" => "Image",
		"Listing" => "Listing"
	);
	
	private static $has_many = array (
		
	);
	
	private static $summary_fields = array(
		"Cover",
		"Image" => "Image.CMSThumbnail"
	);
	
	static $searchable_fields = array( 
		'ID' 
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFIelds();
		
		return $fields;
	}
	
	
	
}