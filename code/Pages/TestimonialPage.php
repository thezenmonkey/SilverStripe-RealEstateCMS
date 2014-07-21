<?php

class TestimonialPage extends Page {
	
	/**
	 * Static vars
	 * ----------------------------------*/
	
	

	/**
	 * Object vars
	 * ----------------------------------*/
	
	
	
	/**
	 * Static methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Data model
	 * ----------------------------------*/

	private static $db = array (
		
	);
	

	private static $has_one = array (
		
	);
	
	private static $has_many = array (
		
	);
	
	/**
	 * Common methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Accessor methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Controller actions	
	 * ----------------------------------*/
	
	
	
	/**
	 * Template accessors
	 * ----------------------------------*/
	
	public function Testimonials() {
		$Testimonials = Testimonial::get();
		return $Testimonials->count() ? $Testimonials : false;
	}
	
	public function TeamMembers() {
		$team = Member::get()->filterByCallback(
			function($item){
				return $item->inGroup('team-member');
			}
		);
		return $team->count() ? $team : false;
	}
	
	/**
	 * Object methods
	 * ----------------------------------*/

	

	
}


class TestimonialPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}