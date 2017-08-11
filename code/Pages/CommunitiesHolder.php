<?php

use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HeaderField;
// use PageController;

class CommunitiesHolder extends Page {
	
	/**
	 * Static vars
	 * ----------------------------------*/

    private static $allowed_children = array(
        'MunicipalityPage'
    );

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
	
	/**
	 * Common methods
	 * ----------------------------------*/

    public function getCMSFields() {
        $fields = parent::getCMSFIelds();

        //Create a list of Towns
//        $sqlQuery = new SQLQuery();
//        $sqlQuery->setFrom('Listing');
//        $sqlQuery->setWhere('CityID = 0');
//        $sqlQuery->selectField('Town');
//        $sqlQuery->setDistinct(true);
//        $result = $sqlQuery->execute();
//
//        $townList = '<ul>';
//
//        foreach($result as $row){
//            $townList = $townList.'<li>'.$row['Town'].'</li>';
//        }
//
//        $townList = $townList.'</ul>';
//
//        $townDisplay = LiteralField::create('TownList', $townList);

        $fields->addFieldsToTab('Root.ChildPages', array(
            HeaderField::create('TownHeader', 'Other Towns Used', 2),
            //$townDisplay
        ));

        //Reorder Main Tab
        $mainTab = $fields->fieldByName('Root.Main');
        $fields->removeByName('Main');

        $fields->findOrMakeTab('Root.Main', $mainTab);

        return $fields;
    }

    public function getLumberjackTitle() {
        return "Cities";
    }
	
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


class CommunitiesHolder_Controller extends PageController {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}