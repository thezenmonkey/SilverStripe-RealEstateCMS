<?php

use SilverStripe\Security\Member;
use SilverStripe\Core\Convert;
use SilverStripe\View\ArrayData;
use SilverStripe\Security\Security;
//use PageController;

class TeamPage extends Page {
	
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


class TeamPage_Controller extends PageController {
	
	private static $allowed_actions = array (
		"show"
	);

	public function init() {
		parent::init();
		
	}
	
	public function getCurrentItem($itemID = null) {
		$params = $this->request->allParams();
		$class =  Member::class;		
		
		if($itemID)
		{
			return $class::get()->byID($itemID);
		}
		elseif(isset($params['ID']))
		{
			//Sanitize
			$URL = Convert::raw2sql($params['ID']);
			
			return $class::get()->filter("URLSegment", $URL)->first();
		}		
	}
	
	function show() {
		if(($item = $this->getCurrentItem()))
		{
			if ($this->getCurrentItem()->canView())
			{
				$data = array(
					'Item' => $item,
					'BackLink' => base64_decode($this->request->getVar('backlink'))
				);

				return $this->customise(new ArrayData($data));
			}
			else
			{
				return Security::permissionFailure($this);
			}
		}
		else
		{
			return $this->httpError(404);
		}
	}
	
}