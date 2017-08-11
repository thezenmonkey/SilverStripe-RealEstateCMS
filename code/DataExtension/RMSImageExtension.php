<?php 
use SilverStripe\ORM\DataExtension;
use SilverStripeRMS\Model\Listing;

/**
 * Class: RMSImageExtension
 * Extension Class for Images
 * Description
 * @author: Richard Rudy (rick@desigmplusawesome.com)
 * @version: 2.0
 *
 * TODO Update MLSListing to many_many realtion
 *
 */
class RMSImageExtension extends DataExtension {
	
	private static $has_one = [
		"MLSListing" => "MLSListing"
	];

	private static $belongs_many_many = [
	    "Listings" => Listing::class
    ];
	
}