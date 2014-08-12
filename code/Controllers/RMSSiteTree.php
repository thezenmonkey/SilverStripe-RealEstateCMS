<?php

//Currently a hack to get ModalAdmin to manage Listings

class RMSSiteTree extends DataExtension {
	
	private static $db = array(
		"Status" => "Enum('Available,Sold,Closed,Unavailable')",
		"Feature" => "Boolean",
		"Street" => "Varchar"
	);
	
	private static $has_one = array(
		
	);
	
	private static $has_many = array(
		
	);
	
	public function updateCMSFields(FieldList $fields) {
		
	}
}