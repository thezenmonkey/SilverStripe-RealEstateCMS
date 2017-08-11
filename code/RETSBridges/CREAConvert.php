<?php

class CREAConvert {
	
	static public function Convert($MLSListing, $class, $MLSRecord) {
		
		// TREB CONVERSION FUNCTIONS
		$MLSListing->Acreage = $MLSRecord['LotSizeArea'];
		$MLSListing->GarageSpaces = $MLSRecord['ParkingTotal'];
		$MLSListing->Fronting = $MLSRecord['FrontageType'];
		$MLSListing->Pool = $MLSRecord['PoolYN'];
		$MLSListing->PropertyFeatures = $MLSRecord['PublicRemarks'];
		$MLSListing->Sewers = $MLSRecord['Sewer'];
		$MLSListing->Waterfront = $MLSRecord['WaterfrontYN'];
		
		//confo specific
		$MLSListing->AptUnit = $MLSRecord['UnitNumber'];

		//General

        $MLSListing->Content = "<p>".$MLSRecord["PublicRemarks"]."</p>";
		$MLSListing->Address = $MLSRecord['UnparsedAddress'];
		$MLSListing->AirConditioning = $MLSRecord['CoolingYN'];
		$MLSListing->ApproxAge = $MLSRecord['YearBuilt'];
		$MLSListing->ApproxSquareFootage = $MLSRecord['BuildingAreaTotal'].$MLSRecord['BuildingAreaUnits'];
		$MLSListing->Bedrooms = $MLSRecord['BedroomsTotal'];
		$MLSListing->FireplaceStove = $MLSRecord['FireplacesTotal'];
		$MLSListing->HeatSource = $MLSRecord['HeatingFuel'];
		$MLSListing->HeatType = $MLSRecord['Heating'];
		$MLSListing->IDXUpdatedDate = $MLSRecord['ModificationTimestamp'];
		
		$MLSListing->ListBrokerage = $MLSRecord['ListOfficeName'];
		$MLSListing->Price = $MLSRecord['ListPrice'];
		$MLSListing->MLS = $MLSRecord['OriginatingSystemKey'];
		$MLSListing->Municipality = $MLSRecord['City'];
		$MLSListing->PixUpdatedDate = $MLSRecord['PhotosChangeTimestamp'];
		$MLSListing->PostalCode = $MLSRecord['PostalCode'];
		$MLSListing->Province = $MLSRecord['StateOrProvince'];
		$MLSListing->RemarksForClients = $MLSRecord['PublicRemarks'];
		$MLSListing->SaleLease = (empty($MLSRecord['LeaseTerm'])) ? "Sale" : "Lease";
		$MLSListing->SaleOrRent = ($MLSListing->SaleLease == "Sale") ? "Sale" : "Lease"; //Keep Consistant with Listing
		$MLSListing->StreetNum = $MLSRecord['StreetNumber'];
		$MLSListing->StreetAbbreviation = $MLSRecord['StreetSuffix'];
		$MLSListing->StreetDirection = $MLSRecord['StreetDirSuffix'];
		$MLSListing->StreetName = $MLSRecord['StreetName'];
		$MLSListing->Style = $MLSRecord['PropertyType'];
		$MLSListing->Type = $MLSRecord['PropertyType'];
		$MLSListing->UpdatedTimestamp = $MLSRecord['ModificationTimestamp'];
		$MLSListing->Washrooms = $MLSRecord['BathroomsTotal'];
		$MLSListing->Zoning = $MLSRecord['Zoning'];
		$MLSListing->SourceKey = $MLSRecord['ListingKey'];
		
		return $MLSListing;
	}
	
	
	static public function generateRoomArray($MLSRecord) {
		$roomArray = array();
		
		!empty($MLSRecord['RoomType1']) ? array_push($roomArray, array($MLSRecord['RoomType1'] => array ("length" => $MLSRecord['RoomLength1'], "width" => $MLSRecord['RoomWidth1'], "level" => $MLSRecord['RoomLevel1'], 'desc' => ''))) : ''; //room 1
		!empty($MLSRecord['RoomType2']) ? array_push($roomArray, array($MLSRecord['RoomType2'] => array ("length" => $MLSRecord['RoomLength2'], "width" => $MLSRecord['RoomWidth2'], "level" => $MLSRecord['RoomLevel2'], 'desc' => ''))) : ''; //room 2
		!empty($MLSRecord['RoomType3']) ? array_push($roomArray, array($MLSRecord['RoomType3'] => array ("length" => $MLSRecord['RoomLength3'], "width" => $MLSRecord['RoomWidth3'], "level" => $MLSRecord['RoomLevel3'], 'desc' => ''))) : ''; //room 3
		!empty($MLSRecord['RoomType4']) ? array_push($roomArray, array($MLSRecord['RoomType4'] => array ("length" => $MLSRecord['RoomLength4'], "width" => $MLSRecord['RoomWidth4'], "level" => $MLSRecord['RoomLevel4'], 'desc' => ''))) : ''; //room 4
		!empty($MLSRecord['RoomType5']) ? array_push($roomArray, array($MLSRecord['RoomType5'] => array ("length" => $MLSRecord['RoomLength5'], "width" => $MLSRecord['RoomWidth5'], "level" => $MLSRecord['RoomLevel5'], 'desc' => ''))) : ''; //room 5
		!empty($MLSRecord['RoomType6']) ? array_push($roomArray, array($MLSRecord['RoomType6'] => array ("length" => $MLSRecord['RoomLength6'], "width" => $MLSRecord['RoomWidth6'], "level" => $MLSRecord['RoomLevel6'], 'desc' => ''))) : ''; //room 6
		!empty($MLSRecord['RoomType7']) ? array_push($roomArray, array($MLSRecord['RoomType7'] => array ("length" => $MLSRecord['RoomLength7'], "width" => $MLSRecord['RoomWidth7'], "level" => $MLSRecord['RoomLevel7'], 'desc' => ''))) : ''; //room 7
		!empty($MLSRecord['RoomType8']) ? array_push($roomArray, array($MLSRecord['RoomType8'] => array ("length" => $MLSRecord['RoomLength8'], "width" => $MLSRecord['RoomWidth8'], "level" => $MLSRecord['RoomLevel8'], 'desc' => ''))) : ''; //room 8
		!empty($MLSRecord['RoomType9']) ? array_push($roomArray, array($MLSRecord['RoomType9'] => array ("length" => $MLSRecord['RoomLength9'], "width" => $MLSRecord['RoomWidth9'], "level" => $MLSRecord['RoomLevel9'], 'desc' => ''))) : ''; //room 9
		!empty($MLSRecord['RoomType10']) ? array_push($roomArray, array($MLSRecord['RoomType10'] => array ("length" => $MLSRecord['RoomLength10'], "width" => $MLSRecord['RoomWidth10'], "level" => $MLSRecord['RoomLevel10'], 'desc' => ''))) : ''; //room 10
		!empty($MLSRecord['RoomType11']) ? array_push($roomArray, array($MLSRecord['RoomType11'] => array ("length" => $MLSRecord['RoomLength11'], "width" => $MLSRecord['RoomWidth11'], "level" => $MLSRecord['RoomLevel11'], 'desc' => ''))) : ''; //room 11
		!empty($MLSRecord['RoomType12']) ? array_push($roomArray, array($MLSRecord['RoomType12'] => array ("length" => $MLSRecord['RoomLength12'], "width" => $MLSRecord['RoomWidth12'], "level" => $MLSRecord['RoomLevel12'], 'desc' => ''))) : ''; //room 12
		!empty($MLSRecord['RoomType13']) ? array_push($roomArray, array($MLSRecord['RoomType13'] => array ("length" => $MLSRecord['RoomLength13'], "width" => $MLSRecord['RoomWidth13'], "level" => $MLSRecord['RoomLevel13'], 'desc' => ''))) : ''; //room 13
		!empty($MLSRecord['RoomType14']) ? array_push($roomArray, array($MLSRecord['RoomType14'] => array ("length" => $MLSRecord['RoomLength14'], "width" => $MLSRecord['RoomWidth14'], "level" => $MLSRecord['RoomLevel14'], 'desc' => ''))) : ''; //room 14
		!empty($MLSRecord['RoomType15']) ? array_push($roomArray, array($MLSRecord['RoomType15'] => array ("length" => $MLSRecord['RoomLength15'], "width" => $MLSRecord['RoomWidth15'], "level" => $MLSRecord['RoomLevel15'], 'desc' => ''))) : ''; //room 15
		!empty($MLSRecord['RoomType16']) ? array_push($roomArray, array($MLSRecord['RoomType16'] => array ("length" => $MLSRecord['RoomLength16'], "width" => $MLSRecord['RoomWidth16'], "level" => $MLSRecord['RoomLevel16'], 'desc' => ''))) : ''; //room 16
		!empty($MLSRecord['RoomType17']) ? array_push($roomArray, array($MLSRecord['RoomType17'] => array ("length" => $MLSRecord['RoomLength17'], "width" => $MLSRecord['RoomWidth17'], "level" => $MLSRecord['RoomLevel17'], 'desc' => ''))) : ''; //room 17
		!empty($MLSRecord['RoomType18']) ? array_push($roomArray, array($MLSRecord['RoomType18'] => array ("length" => $MLSRecord['RoomLength18'], "width" => $MLSRecord['RoomWidth18'], "level" => $MLSRecord['RoomLevel18'], 'desc' => ''))) : ''; //room 18
		!empty($MLSRecord['RoomType19']) ? array_push($roomArray, array($MLSRecord['RoomType19'] => array ("length" => $MLSRecord['RoomLength19'], "width" => $MLSRecord['RoomWidth19'], "level" => $MLSRecord['RoomLevel19'], 'desc' => ''))) : ''; //room 19
		!empty($MLSRecord['RoomType20']) ? array_push($roomArray, array($MLSRecord['RoomType20'] => array ("length" => $MLSRecord['RoomLength20'], "width" => $MLSRecord['RoomWidth20'], "level" => $MLSRecord['RoomLevel20'], 'desc' => ''))) : ''; //room 20
		
		
		return $roomArray;
		
	}
}