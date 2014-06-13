<?php

class RMSMaintenance extends Controller {
	
	private static $allowed_actions = array (
		'Test'
	);
	
	private static $url_handlers = array(
        'Test/$Action/$ID/$Name' => 'Test'
    );
	
	public function Test(SS_HTTPRequest $request) {
		print_r($request->allParams());
	}
}