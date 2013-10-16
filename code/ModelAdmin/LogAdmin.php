<?php
/**
 * 	
 * @package Realestate Listing System - Logging Admin 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class LogAdmin extends ModelAdmin {
   
	private static $managed_models = array(
		'RMSProcess'
	);

	static $url_segment = 'logging';
	static $menu_title = 'Log';
	//static $menu_icon = 'mysite/images/our_team.png';
	
}