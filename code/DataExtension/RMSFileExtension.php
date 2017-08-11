<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * Class: RMSFileExtension
 * Extension Class for Files
 * Description
 * @author: Richard Rudy (rick@desigmplusawesome.com)
 * @version: 2.0
 */

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