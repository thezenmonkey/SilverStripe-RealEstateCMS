<?php

class RMSController extends Controller {
	
	private static $allowed_actions = array (
		'FindNear',
		'AjaxMapSearch',
		'AjaxListing'
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
	
	public function AjaxMapSearch($request) {
		
		$classes = array('Listing','MLSListing');
		
		$searchType = $_GET["type"];
		
		$filter = null;
		
		$min = (isset($_GET["min"])) ? $_GET["min"] : false; 
		$max = (isset($_GET["max"])) ? $_GET["max"] : false; 
		
		
		if($min && $max) {
			$filter = "Price >= $min AND Price <= $max";
		} elseif ($min && !$max) {
			$filter = "Price >= $min";
		} elseif (!$min && $max) {
			$filter = "Price <= $max";
		}
		
		if($searchType == "bounds") {
			$north = Convert::raw2sql($_GET["north"]);
			$south = Convert::raw2sql($_GET["south"]);
			$east = Convert::raw2sql($_GET["east"]);
			$west = Convert::raw2sql($_GET["west"]);
			
			$set = new ArrayList();
			
			
			if ($north && $south && $east && $west) {
				foreach($classes as $class) {
					$set->merge(ListingUtils::BoundsQuery($class, array('north' => $north, 'south' => $south, 'east' => $east, 'west' => $west), $filter) );
				}
				
			}
		}
		
		//If No Listings Return a 404
	    if(!$set->Count()) return new HTTPResponse("Not found", 404);
	     
	    // Use HTTPResponse to pass custom status messages
	    $this->response->setStatusCode(200, "Found " . $set->Count() . " elements");
	 	$this->response->addHeader('Content-Type', 'application/json');
	 	
	 	return json_encode($set->toNestedArray());
	}
	
	public function AjaxListing($request) {
		
		if(!isset($_GET["class"]) || !isset($_GET["id"])) return new HTTPResponse("Not found", 404);
		
		$class = $_GET["class"];
		$id = $_GET["id"];
		
		
		$listing = $class::get()->byID($id);
		
		//If No Listings Return a 404
	    if(!$listing) return new HTTPResponse("Not found", 404);
	     
	    // Use HTTPResponse to pass custom status messages
	    $this->response->setStatusCode(200, "Found " . 1 . " elements");
	    if(isset($_GET["return"]) && $_GET["return"] == "json") {
			if($listing->ClassName == "Listing"){
				$listing->URLSegment = "listings/".$listing->URLSegment;
			} else {
				$listing->URLSegment = "listings/show/".$listing->URLSegment;
			}
		    
		    //Debug::show($listing);
		    $this->response->addHeader('Content-Type', 'application/json');
		 	$f = new JSONDataFormatter();
		 	//Debug::show($set);
		 	return $f->convertDataObject($listing);
	    }
	 	
	 	
	 	$vd = new ViewableData();
	    return $vd->customise(array(
	      "Result" => $listing
	    ))->renderWith('AjaxListing');
	}
	
	
}