<?php

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

	 static $db = array(
	 	"Title" => "Varchar",
	 	"Content" => "HTMLText",
	 	"Video" => "Varchar",
	 	"Client" => "Varchar"
	 );
	 
	 static $has_one = array(
	 	"Agent" => "Member"
	 );
	 
	 static $summary_fields = array(
	 	"Title",
	 	"Agent.Title",
	 	"Client"
	 );
	 
	 static $search_fields = array(
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