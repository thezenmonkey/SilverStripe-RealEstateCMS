<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;

class StoresAndServices extends NeighbourhoodFeature {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		
	);
	
	private static $has_many = array (
		
	);
	
	function getCMSFields() {
		$cityfield = new DropdownField('CityID', 'City', City::get()->map('ID', 'Title'));
        $cityfield->setEmptyString('(Select one)');
		
		return new FieldList(
			TextField::create('Name'),
			TextField::create('Address'),
			$cityfield,
			TextField::create('Town'),
			TextField::create('PostalCode'),
			DropdownField::create('Type','Type',array(
				'Shopping' => 'Shopping',
			)),
			TextField::create('Note')
		);
	
	}
	
}