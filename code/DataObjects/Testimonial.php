<?php

use SilverStripe\Security\Member;
use SilverStripe\ORM\DataObject;

/**
 * 	
 * @package Testimonials
 * @author
 */
 
class Testimonial extends DataObject {

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

	 private static $db = array(
	 	"Title" => "Varchar",
	 	"Content" => "HTMLText",
	 	"Video" => "Varchar",
	 	"Client" => "Varchar"
	 );

	private static $has_one = array(
	 	"Agent" => Member::class
	 );

	private static $summary_fields = array(
	 	"Title",
	 	"Agent.Title",
	 	"Client"
	 );

	private static $search_fields = array(
	 	"Title",
	 	"Agent",
	 	"Client"
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



	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 


}