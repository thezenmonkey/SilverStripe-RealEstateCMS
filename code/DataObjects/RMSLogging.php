<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\Forms\GridField\GridField;

class RMSLogging extends DataObject {
	
	private static $db = array (
		"Title" => "Varchar",
		"Value" => "Text",
		"Duration" => "Text"
	);
	
	static public function createEvent($title = null, $value = null) {
		$event = new RMSEvent();
		$event->Title = $title;
		$event->Value = $value;
		return $event;
	}
	
	static public function ensure2Digit($number) {
	    if($number < 10) {
	        $number = '0' . $number;
	    }
	    return $number;
	}
	
	static public function getTime() {
		if($duration = self::getDuration()){

			$s = self::ensure2Digit($duration%60);
			$m = self::ensure2Digit(floor(($duration%3600)/60));
			$h = self::ensure2Digit(floor(($duration%86400)/3600));
			
			return "$h:$m:$s";
		} else {
			return false;
		}
	}

	public function getDuration() {
		return $this->Duration;
	}
	
}

class RMSProcess extends RMSLogging {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		
	);	
	
	private static $has_many = array (
		"Events" => "RMSEvent"
	);
	
	private static $summary_fields = array(
		"Title" => array(
			"title" => 'Process'
		),
		"Value" => array(
			"title" => 'Value'
		),
		"Created" => array(
			"title" => 'Started'
		),
		"Time" => array(
			"title" => 'Total Time'
		)
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFIelds();
		
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Title", "Process"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Value", "Details"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Created", "Started"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create('Time', "Total Time"));
		$fields->removeByName("Duration");
		
		$gridField = new GridField('Events', 'Events', $this->Events(), GridFieldConfig_RecordViewer::create());
		
		$fields->addFieldToTab("Root.Main", $gridField);
		
		return $fields;
	}
	
	public function onBeforeDelete() {
		$events = $this->Events();
		if($events->count()) {
			foreach ($events as $event) $event->delete(); 
		}
		
		parent::onBeforeDelete();
	}
	
}

class RMSEvent extends RMSLogging {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		"Process" => "RMSProcess"
	);
	
	private static $summary_fields = array(
		"Title" => array(
			"title" => 'Event'
		),
		"Value" => array(
			"title" => 'Details'
		),
		"Created" => array(
			"title" => 'Started'
		),
		"Time" => array(
			"title" => 'Total Time'
		)
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFIelds();
		
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Title", "Event"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Value", "Details"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create("Created", "Started"));
		$fields->addFieldToTab("Root.Main", ReadonlyField::create('Time', "Total Time"));
		$fields->removeByName("Duration");
		
		return $fields;
	}
}