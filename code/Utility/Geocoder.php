<?php

class Geocoder  {
	
	static public function Geocode($address) {
		global $_GOOGLE_API;
		//CODE FROM GOOGLE
		//---------------------------------------------------------
		
		// Initialize delay in geocode speed
		$delay = 0;
		$base_url = "http://maps.googleapis.com/maps/api/geocode/xml?sensor=false";// . "&key=" . KEY;
		
		
		
		// Iterate through the rows, geocoding each address
		$geocode_pending = true;
		
		while ($geocode_pending) {
			//$address = $this->Address." ".$this->City()->Title." Ontario ".$this->PostalCode;
			$request_url = $base_url . "&address=" . urlencode($address);
			$xml = simplexml_load_file($request_url);					
			
			if (!$xml){
				FormResponse::status_message(sprintf($request_url),'bad');
				return FormResponse::respond();
			}
			$status = $xml->status;
			
			if ($status == "OK") {
			  // Successful geocode
			  $geocode_pending = false;
			  // Format: Longitude, Latitude, Altitude
			  $lat = str_replace("</lat>", "", str_replace("<lat>", "", $xml->result->geometry->location->lat->asXML()))  ;
			  $lng = str_replace("</lng>", "", str_replace("<lng>", "", $xml->result->geometry->location->lng->asXML()))  ;
			  
			  
			  //$this->Lat = $lat;
			  //$this->Lon = $lng;
			  
			  $LatLon = array(
			  	"Lat" => $lat,
			  	"Lon" => $lng
			  );
			  
			  return $LatLon;
			  
			} else if (strcmp($status, "620") == 0) {
			  // sent geocodes too fast
			  $delay += 100000;
			} else {
			  // failure to geocode
			  $geocode_pending = false;
			  echo "Address " . $address . " failed to geocoded. ";
			  echo "Received status " . $status . "\n";
			}
		usleep($delay);
		}

	}
	
	public function getDistance($testLocation) {
		
		$location = Geocoder::getLocation();
		
		if ($location) {
			$latlon = explode(",", $location);
			return ( 6373 * acos( cos( deg2rad($latlon[0]) ) * cos( deg2rad( $testLocation['Lat'] ) ) * cos( deg2rad($testLocation['Lon'] ) - deg2rad($latlon[1]) ) + sin( deg2rad($latlon[0]) ) * sin( deg2rad( $testLocation['Lat'] ) ) ) );
		} else {
			return 99999999;
		}
	}
	
	public function getLocation(){
		if($_COOKIE['pAndSvisitorLocation']!='' || $_COOKIE['pAndSvisitorLocation']!='not supported'){
			return $_COOKIE['pAndSvisitorLocation'];
		} else {
			return false;
		}
	}
	
	
	
}