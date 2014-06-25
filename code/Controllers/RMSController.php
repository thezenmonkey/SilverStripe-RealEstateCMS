<?php

class RMSController extends Controller {
	
	private static $allowed_actions = array (
		'FindNear',
		'AjaxMapSearch',
		'AjaxListing',
		'iCal'
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
	
	/**
	 * Create iCal event for Open House and send to browser
	 *
	 * @return .ics file
	 * TODO Configuarable Description and Additon of Agent to $title  
	 */
	
	public function iCal($request) {
		if(!isset($_GET["id"]))  return new HTTPResponse("Not found", 404);
		
		$id = $_GET["id"];
		
		$openHouse = OpenHouseDate::get()->byID($id);
		if(!$openHouse)  return new HTTPResponse("Not found", 404);
		
		$URLFilter = URLSegmentFilter::create();
		
		$title = "Open House";
		$startTime = $openHouse->obj('OpenHouseDate')->Format('Y-m-d')." ".$openHouse->OpenHouseStart;
		$endTime = $openHouse->obj('OpenHouseDate')->Format('Y-m-d')." ".$openHouse->OpenHouseEnd;
		$description = "";
		
		$data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($startTime))."\nDTEND:".date("Ymd\THis\Z",strtotime($endTime))."\nLOCATION:".$openHouse->Listing()->Title."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$title."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
		
		$URLSegment = $URLFilter->filter($title);
		
		header("Cache-Control: private");
		header("Content-Description: File Transfer");
		header("Content-Type: text/calendar");
		header("Content-Transfer-Encoding: binary");
		$filename = $URLSegment. '.ics';
		if(stristr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
 			header("Content-disposition: filename=" . $filename . "; attachment;");
  		} else {
 			header("Content-disposition: attachment; filename=" . $filename);
  		}
		$this->response->setStatusCode(200, "Found " . 1 . " elements");
		$this->response->addHeader('Content-Type', 'text/calendar');
		$this->response->addHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');
		$this->response->addHeader('Content-Length', strlen($data));
		$this->response->addHeader('Connection', 'close');
		echo $data;
		
		
	}
	
	
}