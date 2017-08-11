<?php

use SilverStripe\Security\Member;
use SilverStripe\Admin\ModelAdmin;
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Admin 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class TeamAdmin extends ModelAdmin {
   
	private static $managed_models = array(
		Member::class,
		'Testimonial',
	);

	private static $url_segment = 'team';
	private static $menu_title = 'Team';
	private static $menu_icon = 'realestate/images/our_team.png';
	
}