<?php


class RMSFileExtension extends DataExtension {
	
	private static $db = array(
		
	);
	
	private static $has_one = array(
		"Listing" => "Listing"
	);
	
	private static $has_many = array(
		
	);
	
	public function updateCMSFields(FieldList $fields) {
		
	}
}