<?php

class ListingUtils {
	
	
	/**
	 * Perform a a Distance Based Query
	 *
	 * @param $class Class to Check, target must include Lat && Lon Feilds
	 * @param $lat GPS Latitude
	 * @param $lon GPS Longitude
	 * @param $distance distandce in Km 
	 * @return Array ($ID => $Distence from query point)
	 */
	public static function DistanceQuery($class, $lat, $lon, $distance = 25, $filter = null) {
		$db = DB::getConn();
		if($db->hasField($class, 'Lat') && $db->hasField($class, 'Lon')) {
			$sqlQuery = new SQLQuery();
			$sqlQuery->setFrom($class);
			if($class == "Listing") {
				$sqlQuery->addWhere("Status = 'Available'");
			}
			
			if($filter) {
				$sqlQuery->addWhere($filter);
			}
			
			$sqlQuery->selectField('( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( "Lat" ) ) * cos( radians( "Lon" ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( "Lat" ) ) ) )', 'Distance');
			$sqlQuery->setHaving("Distance < ".$distance);
			
			$results = $sqlQuery->execute();
			$itemList = new ArrayList();
			foreach($results as $row){
				$row['ClassName'] = $class;
				$itemList->push($row);
			}
			return $itemList;
			
		} else {
			return false;
		}
		
	}
	
	/**
	 * Generate ArrayList of Searched Properties
	 *
	 * @param $class DataObject Class to Search
	 * @param $bounds = Array of map bounds: Requires north, south east and west keys
	 * @return ArrayList()
	 */
	public static function BoundsQuery($class, $bounds, $filter = null) {
		$foundlistings = Session::get('FoundListings');
		if(!$foundlistings) {
			$foundlistings = array($class => array());
		}
		//Debug::show($foundlistings);
		if($foundlistings && !array_key_exists($class,$foundlistings) ){
			$foundlistings[$class] = array();
		}
		
		$db = DB::getConn();
		if($db->hasField($class, 'Lat') && $db->hasField($class, 'Lon')) {
			$sqlQuery = new SQLQuery();
			$sqlQuery->setFrom($class);
			$sqlQuery->setSelect('ID,Lat,Lon,ListingType,Price');
			if($class == "Listing") {
				$sqlQuery->addWhere("Status = 'Available'");
			}
			if($filter) {
				$sqlQuery->addWhere($filter);
			}
			$south = $bounds['south'];
			$north = $bounds['north'];
			$west = $bounds['east'];
			$east = $bounds['west'];
			
			$sqlQuery->addWhere("Lat > $south AND Lat < $north AND Lon < $west AND Lon > $east");
			
			$results = $sqlQuery->execute();
			$itemList = new ArrayList();
			foreach($results as $row){
				/*
if( !in_array($row['ID'],$foundlistings[$class]) ) {
					array_push($foundlistings[$class],$row['ID']);
					$row['ClassName'] = $class;
					$itemList->push($row);
				}
*/
				$row['ClassName'] = $class;
				$itemList->push($row);
				
			}
			
			Session::set('FoundListings', $foundlistings);
			//Debug::show(Session::get('FoundListings'));
			return $itemList;
			
		} else {
			return false;
		}
	}
	
}