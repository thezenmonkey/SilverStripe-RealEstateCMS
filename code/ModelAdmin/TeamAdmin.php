<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Admin 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class TeamAdmin extends ModelAdmin {
   
	private static $managed_models = array(
		'Member',
		'Testimonial',
		'Partner'
	);

	static $url_segment = 'team';
	static $menu_title = 'Team';
	static $menu_icon = 'mysite/images/our_team.png';
	
}