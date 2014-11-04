<?php

class RMSUpgrade extends Controller {
	
	private static $allowed_actions = array (
		'Upgrade210'
	);
	
	private static $url_handlers = array(
        'Upgrade210' => 'Upgrade210'
    );
	
	
	//Change Listing FLag to new system
	public function Upgrade210(SS_HTTPRequest $request) {
		echo "Start Upgrade <br>\n";
		
		$listings = Listing::get()->filter(array("IsNew" => '1'));
		
		echo "Upgrading ".$listings->count()."<br>\n";
		
		if($listings->count()) {
			
			foreach($listings as $listing) {
				$listing->Flag = "New";
				
				Debug::show($listing);
				
				//$listing->write();
				//$listing->doPublish();
				//$listing->destroy();
			}
			
		}
		
		echo "Done";
		
		
	}
}