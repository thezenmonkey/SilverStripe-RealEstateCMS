<?php

class RMSLogging extends DataObject {
	
	private static $db = array (
		"Title" => "Varchar",
		"Value" => "Text",
		"Duration" => "Text"
	);
	
	
}

class RMSProcess extends RMSLogging {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		
	);	
	
	private static $has_many = array (
		"Events" => "RMSEvent"
	);
	
	public function onBeforeDelete() {
		$events = $this->Events();
		if($events->count()) {
			foreach ($events as $event) $event->delete(); 
		}
	}
	
}

class RMSEvent extends RMSLogging {
	
	private static $db = array (
		
	);
	
	private static $has_one = array (
		"Process" => "RMSProcess"
	);
}