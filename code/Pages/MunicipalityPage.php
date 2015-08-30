<?php

class MunicipalityPage extends Community {
	
	/**
	 * Static vars
	 * ----------------------------------*/
	
	private static $hide_ancestor = 'Community';
	private static $singular_name = 'City';
    private static $plural_name = 'Cities';
    private static $description = 'Landing Page for Target Market City';
    private static $icon = 'realestate/images/communities.png';

    private static $allowed_children = array(
        'NeighbourhoodPage'
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
	

	private static $has_one = array (
		
	);
	
	private static $has_many = array (
		"Listings" => "Listing",
		"MLSListings" => "MLSListing"
	);
	
	/**
	 * Common methods
	 * ----------------------------------*/

    public function getCMSFields() {
        $fields = parent::getCMSFIelds();

        //Create Neighbourhood Gridfield
        $pages = SiteTree::get()->filter(array(
            'ParentID' => $this->ID,
            'ClassName' => 'NeighbourhoodPage'
        ));

        $gridConfig = GridFieldConfig_Lumberjack::create();

        $gridConfig->addComponents(
            new GridFieldSiteTreeAddNewButton('buttons-before-left')
        );

        $gridField = new GridField(
            "Ex",
            'Neighbourhoods',
            $pages,
            $gridConfig
        );


        //Create Listing Gridfield
        $listings = $this->Listings();

        $listingConfig = GridFieldConfig_Lumberjack::create();

        $listingGrid = new GridField(
            "Listings",
            "Listings",
            $listings,
            $listingConfig
        );

        $tab = new Tab('NeighbourhoodsTabs', 'Neighbourhoods', $gridField);
        $fields->insertAfter($tab, 'Main');

        $listingTab = new Tab('ListingsTab', 'Listings', $listingGrid);
        $fields->insertAfter($listingTab, 'NeighbourhoodsTabs');

        //$fields->removeFieldFromTab('Root', 'ChildPages');


        return $fields;
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


class MunicipalityPage_Controller extends Community_Controller {
	
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		
	}
	
}