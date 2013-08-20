<?php

class HomePage extends Page implements HiddenClass {

	static $db = array(
		//"LeaderCopy" => "HTMLText",
		//'SqueezePageCTA' => "Text"
	);

	static $has_many = array(
		//"FeatureBlocks" => "FeatureBlock",
	);
	
	
	/*
public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->insertBefore(new TextField("LeaderCopy", "Leader"), "Content");
		$fields->insertBefore(new TextField("SqueezePageCTA", "Squeeze Page CTA"), "Content");
		
		$featureManagerConfig = GridFieldConfig_RelationEditor::create();
		$featureManagerConfig->addComponents(
			new GridFieldSortableRows('Order')
		);
		$featureManager = new GridField(
	 		"FeatureBlock", "FeatureBlocks",
	 		$this->FeatureBlocks(), 
	 		$featureManagerConfig
	 	);
	 	
	 	$fields->insertAfter($featureManager, "Content");
		
		return $fields;
	}
*/

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