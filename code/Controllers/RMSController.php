<?php

class RMSController extends ContentController {
	
	private static $allowed_actions = array (
		'FindNear'
	);
	
	/**
	 * Fin Nearby Listing
	 *
	 * @param $lat GPS Latitude
	 * @param $lon GPS Longitude
	 * @param $distance distandce in Km 
	 * @return ArrayList 
	 * @TODO Add config for includeing MLSListings
	 */
	public static function FindNear($lat, $lon, $distance = '25', $limit = null, $options = null) {
		
		if($lat && $lon) {
			
			$listingItems = ListingUtils::DistanceQuery('Listing', $lat, $lon, $distance);
			
			$listings = new ArrayList();
			
			if(!empty($listingItems)) {
				foreach ($listingItems as $id => $distance) {
					$listing = Listing::get()->byID($id);
					if($listing) {
						$listing->setField('Distance', round($distance, 2));
						$listings->push($listing);
					}
				}
			}
			
			$mlsItems =ListingUtils::DistanceQuery('MLSListing', $lat, $lon, $distance);
			if(!empty($mlsItems)) {
				foreach ($mlsItems as $id => $distance) {
					$listing = MLSListing::get()->byID($id);
					if($listing) {
						$listing->setField('Distance', round($distance, 2));
						$listings->push($listing);
					}
				}
			}
			
			return $listings->count() ? $listings->sort('Distance')->limit($limit) : false;
			
		} else {
			return false; //no $lat and $lon
		}
		
	}
	
	
}