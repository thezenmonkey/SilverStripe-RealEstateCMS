<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Controller;

class RMSMaintenance extends Controller {
	
	private static $allowed_actions = array (
		'Test'
	);
	
	private static $url_handlers = array(
        'Test/$Action/$ID/$Name' => 'Test'
    );
	
	public function Test(HTTPRequest $request) {
		print_r($request->allParams());
	}
}