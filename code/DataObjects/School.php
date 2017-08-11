<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;

class School extends NeighbourhoodFeature {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		
	);
	
	private static $has_many = array (
		
	);
	
	function getCMSFields() {
		$cityfield = new DropdownField('CityID', 'City', MunicipalityPage::get()->map('ID', 'Title'));
        $cityfield->setEmptyString('(Select one)');
		
		return new FieldList(
			TextField::create('Name'),
			TextField::create('Address'),
			$cityfield,
			TextField::create('Town'),
			TextField::create('PostalCode'),
			DropdownField::create('Type','Type',array(
				'Elementary School' => 'Elementary School',
				'Middle School' => 'Middle School',
				'Secondary School' => 'Secondary School',
				'RC Elementary School' => 'RC Elementary School',
				'RC Middle School' => 'RC Middle School',
				'RC Secondary School' => 'RC Secondary School',
				'College' => 'College'
			)),
			TextField::create('Grades'),
			TextField::create('Note')
		);
	
	}
	
}