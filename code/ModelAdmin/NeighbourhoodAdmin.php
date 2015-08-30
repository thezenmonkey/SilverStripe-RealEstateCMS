<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Admin 
 * @requires Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class NeighbourhoodAdmin extends ModelAdmin {
   
	public static $managed_models = array(
		'School'
	);

	static $url_segment = 'communities';
	static $menu_title = 'Community Tools';
	static $menu_icon = 'realestate/images/communities.png';
	
}