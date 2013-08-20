<?php

/**
 * 	Class to hold extra Objects TOo small to their own Table 
 *  Add fields here and create a new class that extends this 
 *  and only calls fields needed
 * @package Real Estate
 * @author 
 * @children OpenHouseDate,
 */
 
class ExtraData extends DataObject {
	
	private static $db = array(
		// Open House Dates for Listings
		'OpenHouseDate' => 'Date',
		'OpenHouseStart' => 'Time',
		'OpenHouseEnd' => 'Time',
		'CTAName' => 'Varchar',
		'CTAButtonText' => 'Varchar',
		'CTAButtonClass' => 'Varchar',
		'CTACopy' => 'HTMLText',
		'SortOrder' => 'Int',
	);
	
	private static $has_one = array(
		'Listing' => 'Listing',
		'Page' => 'Page',
		//'CTAPage' => 'CTAPage',
		//"TargetPage" => "Page"
	);
	
}