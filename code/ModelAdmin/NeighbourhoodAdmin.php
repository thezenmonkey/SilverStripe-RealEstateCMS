<?php

use SilverStripe\Admin\ModelAdmin;
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Admin 
 * @requires Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class NeighbourhoodAdmin extends ModelAdmin {
   
	private static $managed_models = array(
		'School'
	);

	private static $url_segment = 'communities';
	private static $menu_title = 'Community Tools';
	private static $menu_icon = 'realestate/images/communities.png';
	
}