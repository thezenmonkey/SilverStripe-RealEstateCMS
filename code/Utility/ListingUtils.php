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
	public static function DistanceQuery($class, $lat, $lon, $distance = 25) {
		$db = DB::getConn();
		if($db->hasField($class, 'Lat') && $db->hasField($class, 'Lon')) {
			$sqlQuery = new SQLQuery();
			$sqlQuery->setFrom($class);
			//$sqlQuery->setSelect('ID');
			if($class == "Listing") {
				$sqlQuery->addWhere("Status = 'Available'");
			}
			$sqlQuery->selectField('( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( "Lat" ) ) * cos( radians( "Lon" ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( "Lat" ) ) ) )', 'Distance');
			$sqlQuery->setHaving("Distance < ".$distance);
			
			$items = $sqlQuery->execute()->map();
			return $items ? $items : false;
		} else {
			return false;
		}
		
	}
	
	public static function BoundsQuery($class, $bounds) {
		$db = DB::getConn();
		if($db->hasField($class, 'Lat') && $db->hasField($class, 'Lon')) {
			$sqlQuery = new SQLQuery();
			$sqlQuery->setFrom($class);
			$sqlQuery->setSelect('ID,Lat,Lon');
			if($class == "Listing") {
				$sqlQuery->addWhere("Status = 'Available'");
			}
			$south = $bounds['south'];
			$north = $bounds['north'];
			$west = $bounds['east'];
			$east = $bounds['west'];
			
			$sqlQuery->addWhere("Lat > $south AND Lat < $north AND Lon < $west AND Lon > $east");
			
			$results = $sqlQuery->execute();
			$itemList = new ArrayList();
			foreach($results as $row){
				$itemList->push($row);
				//array_push($itemList, $row);
			}
			return $itemList;
			
		} else {
			return false;
		}
	}
	
}