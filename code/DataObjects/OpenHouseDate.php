<?php


/**
 * Open House Dates for Listing	
 * @package
 * @author
 */
 
class OpenHouseDate extends ExtraData {
	
	private static $summary_fields = array(
		'OpenHouseDate',
		'OpenHouseTime',
	);
	
	public function getCMSFields() {
	
		$fields = parent::getCMSFields();
		
		// Add Unrelated Fields
		$fields->removeFieldsFromTab('Root.Main', array(
			'ListingID',
			'PageID',
			'TargetPageID',
			'CTAPageID',
			'CTAName',
			'CTAButtonText',
			'CTAButtonClass',
			'CTACopy',
			'SortOrder',
			
		));
		
		$OpenHouseDateField = new DateField("OpenHouseDate", "Date");
		
		$OpenHouseDateField->setConfig('showcalendar', true);
		
		$StartTimeField = new TimeField(
			'OpenHouseStart',
			'Start'
		);
		
		$EndTimeField = new TimeField(
			'OpenHouseEnd',
			'End'
		);
		
		
		$fields->addFieldToTab('Root.Main', $OpenHouseDateField);
	 	$fields->addFieldToTab('Root.Main', $StartTimeField);
	 	$fields->addFieldToTab('Root.Main', $EndTimeField);
		
		return $fields;
		
	}
	
	public function GetOpenHouseTime() {
		return date('ga', strtotime($this->OpenHouseStart)) ."-".date('ga', strtotime($this->OpenHouseEnd));
	}
	
	
	
}