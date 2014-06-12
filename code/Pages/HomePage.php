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
	
	
	public function LatestPosts($count = 6){
		$post = BlogEntry::get()->sort("Date", "DESC");
		
		if(is_null($count)) {
			return $post->count() ? $post : false;
		}  else {
			return $post->count() ? $post->limit($count) : false; 
		}
	}
	
	public function GetTestimonial() {
		return $testimonial = Testimonial::get()->sort("Created", "DESC")->First() ? $testimonial : false;
	}
	
	public function FeaturedHomes($count = null) {
		
		$listings = Listing::get()->filter(array("Status" => "Available", "Feature" => 1));
		
		if(is_null($count)) {
			return $listings->count() ? $listings : false;
		}  else {
			return $listings->count() ? $listings->limit($count) : false; 
		}
	}
	
	
			
}