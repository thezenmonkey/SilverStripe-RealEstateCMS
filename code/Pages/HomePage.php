<?php

class HomePage extends Page implements HiddenClass {

	static $db = array(
		
	);

	static $has_many = array(
		
	);

	/**
	 * Change the home page to HomePage type
	 */
	
	function requireDefaultRecords() {
		if(!SiteTree::get_by_link("home")){
			$homepage = new HomePage();
			$$homepage->Title = "Home";
			$homepage->URLSegment = "home";
			$homepage->Sort = 1;
			$homepage->write();
			$homepage->publish('Stage', 'Live');
			$homepage->flushCache();
			DB::alteration_message('Home Page created', 'created');
		} else {
			$homepage = SiteTree::get_by_link("home");
			if($homepage->ClassName != "HomePage") {
				$homepage = $homepage->newClassInstance("HomePage");
				$homepage->write();
				$homepage->publish('Stage', 'Live');
				$homepage->flushCache();
				DB::alteration_message('Home changed to HomePage', 'changed');
			}
		}
	
		parent::requireDefaultRecords();
	}
	
}

class HomePage_Controller extends Page_Controller 
{
	public function init() {
 		
 		parent::init();
 	}
	
	public function FeaturedPost(){
		return $post = BlogEntry::get()->filter(array("IsFeatured" => 1))->sort("Date", "ASC")->First() ? $post : false;
	}
	
	
	public function LatestPost(){
		return $post = BlogEntry::get()->sort("Date", "ASC")->First() ? $post : false;
	}
	
	public function GetTestimonial() {
		return $testimonial = Testimonial::get()->sort("Created", "DESC")->First() ? $testimonial : false;
	}
	
	public function FeaturedHomes() {
		return $listings = Listing::get()->filter(array("Sold" => 0, "Unavailable" => 0, "Feature" => 1))->count() ? $listings : false;
	}
	
	
			
}