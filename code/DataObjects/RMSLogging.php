<?php

class RMSLogging extends DataObject {
	
	private static $db = array (
		"Title" => "Varchar",
		"Value" => "Text",
		"Duration" => "Text"
	);
	
	function createEvent($title = null, $value = null) {
		$event = new RMSEvent();
		$event->Title = $title;
		$event->Value = $value;
		return $event;
	}
	
	function ensure2Digit($number) {
	    if($number < 10) {
	        $number = '0' . $number;
	    }
	    return $number;
	}
	
	function getTime() {
		if($this->Duration){
			$ss = $this->Duration;
			$s = $this->ensure2Digit($ss%60);
			$m = $this->ensure2Digit(floor(($ss%3600)/60));
			$h = $this->ensure2Digit(floor(($ss%86400)/3600));
			
			return "$h:$m:$s";
		} else {
			return false;
		}
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
		"Title",
		"Value",
		"Created",
		"Time"
	);
	
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
		"Title",
		"Value",
		"Created",
		"Time"
	);
}