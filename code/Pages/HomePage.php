<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\HiddenClass;


class HomePage extends Page implements HiddenClass {

	private static $db = array(
		
	);

	private static $has_many = array(
		
	);

	/**
	 * Change the home page to HomePage type
	 */
	
	function requireDefaultRecords() {
		if(!SiteTree::get_by_link("home")){
			$homepage = new HomePage();
			$homepage->Title = "Home";
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

