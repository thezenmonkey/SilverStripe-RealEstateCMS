<?php

class CREAConvert {
	
	static public function Convert($MLSListing, $class, $MLSRecord) {
		
		// TREB CONVERSION FUNCTIONS
		$MLSListing->Acreage = $MLSRecord['LotSizeArea'];
		//$MLSListing->AddlMonthlyFees = $MLSRecord['Addl_mo_fee'];
		//$MLSListing->Drive = $MLSRecord['Drive'];
		//$MLSListing->Extras = $MLSRecord['Extras'];
		$MLSListing->GarageSpaces = $MLSRecord['ParkingTotal'];
		$MLSListing->Fronting = $MLSRecord['FrontageType'];
		//$MLSListing->LegalDescription = $MLSRecord['Legal_desc'];
		//$MLSListing->LotDepth = $MLSRecord['Depth'];
		//$MLSListing->LotFront = $MLSRecord['Front_ft'];
		//$MLSListing->LotIrregularities = $MLSRecord['Irreg'];
		//$MLSListing->LotSizeCode = $MLSRecord['Lotsz_code'];
		//$MLSListing->OtherStructures = $MLSRecord['Oth_struc1_out'].(!empty($MLSRecord['Oth_struc2_out']) ? ", ".$MLSRecord['Oth_struc2_out'] : '');
		//$MLSListing->ParkCostMo = $MLSRecord['Park_chgs'];
		$MLSListing->Pool = $MLSRecord['PoolYN'];
		$MLSListing->PropertyFeatures = $MLSRecord['PublicRemarks'];
		//$MLSListing->SellerPropertyInfoStatement = $MLSRecord['Vend_pis'];
		$MLSListing->Sewers = $MLSRecord['Sewer'];
		//$MLSListing->UtilitiesCable = $MLSRecord['Util_cable'];
		//$MLSListing->UtilitiesGas = $MLSRecord['Gas'];
		//$MLSListing->UtilitiesHydro = $MLSRecord['Elec'];
		//$MLSListing->UtilitiesTelephone = $MLSRecord['Util_tel'];
		//$MLSListing->Water = $MLSRecord['Water'];
		//$MLSListing->WaterIncluded = $MLSRecord['Water_inc'];
		//$MLSListing->WaterSupplyTypes = $MLSRecord['Wtr_suptyp'];
		$MLSListing->Waterfront = $MLSRecord['WaterfrontYN'];
		
		//$MLSListing->LeaseTerm = $MLSRecord['Lease'];
		
		//confo specific
		//$MLSListing->BuildingInsuranceIncluded = $MLSRecord['Insur_bldg'];
		//$MLSListing->Shares = $MLSRecord['Share_perc'];
		//$MLSListing->Balcony = $MLSRecord['Patio_ter'];
		$MLSListing->AptUnit = $MLSRecord['UnitNumber'];
		//$MLSListing->BuildingAmenities = $MLSRecord['Bldg_amen1_out'].(!empty($MLSRecord['Bldg_amen2_out']) ? ", ".$MLSRecord['Bldg_amen2_out'].(!empty($MLSRecord['Bldg_amen3_out']) ? ", ".$MLSRecord['Bldg_amen3_out'].(!empty($MLSRecord['Bldg_amen4_out']) ? ", ".$MLSRecord['Bldg_amen4_out'].(!empty($MLSRecord['Bldg_amen5_out']) ? ", ".$MLSRecord['Bldg_amen5_out'].(!empty($MLSRecord['Bldg_amen6_out']) ? ", ".$MLSRecord['Bldg_amen6_out'] : '') : '') : '') : '') : '');
		//$MLSListing->Exterior = $MLSRecord['Constr1_out'].(!empty($MLSRecord['Constr2_out']) ? ", ".$MLSRecord['Constr2_out'] : '');
		//$MLSListing->CondoCorpNum = $MLSRecord['Corp_num'];
		//$MLSListing->CondoRegistryOffice = $MLSRecord['Condo_corp'];
		//$MLSListing->CondoTaxesIncluded = $MLSRecord['Cond_txinc'];
		//$MLSListing->EnsuiteLaundry = $MLSRecord['Ens_lndry'];
		//$MLSListing->Exposure = $MLSRecord['Condo_exp'];
		//$MLSListing->ParkingLegalDescription = $MLSRecord['Park_lgl_desc1'].(!empty($MLSRecord['Park_lgl_desc2']) ? ", ".$MLSRecord['Park_lgl_desc2'] : '');
		//$MLSListing->ParkingSpot1 = $MLSRecord['Park_spc1'];
		//$MLSListing->ParkingSpot2 = $MLSRecord['Park_spc2'];
		//$MLSListing->ParkingType = $MLSRecord['Park_desig'];
		//$MLSListing->ParkingType2 = $MLSRecord['Park_desig_2'];
		//$MLSListing->ParkingDrive = $MLSRecord['Park_fac'];
		//$MLSListing->PetsPermitted = $MLSRecord['Pets'];
		//$MLSListing->Locker = $MLSRecord['Locker'];
		//$MLSListing->LockerNum = $MLSRecord['Locker_num'];
		//$MLSListing->UnitNum = $MLSRecord['Unit_num'];
		
		//$MLSListing->CentralVac = $MLSRecord['Central_vac'];
		//$MLSListing->LeaseTerm = $MLSRecord['Lease_term'];
		//$MLSListing->Maintenance = $MLSRecord['Maint'];
		//$MLSListing->ListingType = 'Condo';
		
			
		//Genreal
		$MLSListing->Content = "<p>".$MLSRecord["PublicRemarks"]."</p>";		
		$MLSListing->Address = $MLSRecord['UnparsedAddress'];
		$MLSListing->AirConditioning = $MLSRecord['CoolingYN'];
		//$MLSListing->AllInclusiveRental = $MLSRecord['All_inc'];
		$MLSListing->ApproxAge = $MLSRecord['YearBuilt'];
		$MLSListing->ApproxSquareFootage = $MLSRecord['BuildingAreaTotal'].$MLSRecord['BuildingAreaUnits'];
		//$MLSListing->Area = $MLSRecord['Area'];
		//$MLSListing->Assessment = $MLSRecord['Tv'];
		//$MLSListing->AssessmentYear = $MLSRecord['Ass_year'];
		//$MLSListing->Basement = $MLSRecord['Bsmt1_out'].", ".$MLSRecord['Bsmt2_out'];
		$MLSListing->Bedrooms = $MLSRecord['BedroomsTotal'];
		//$MLSListing->BedroomsPlus = $MLSRecord['Br_plus'];
		
		//$MLSListing->CableTVIncluded = $MLSRecord['Cable'];
		//$MLSListing->CACIncluded = $MLSRecord['Cac_inc'];
		
		//$MLSListing->CommonElementsIncluded = $MLSRecord['Comel_inc'];
		//$MLSListing->Community = $MLSRecord['Community']; //Neighbourhood
		//$MLSListing->CommunityCode = $MLSRecord['Community_code'];
		//$MLSListing->DirectionsCrossStreets = $MLSRecord['Cross_st'];
		//$MLSListing->Elevator = $MLSRecord['Elevator'];
		$MLSListing->FireplaceStove = $MLSRecord['FireplacesTotal'];
		//$MLSListing->Furnished = $MLSRecord['Furnished'];
		//$MLSListing->GarageType = $MLSRecord['Gar_type'];
		//$MLSListing->HeatIncluded = $MLSRecord['Heat_inc'];
		$MLSListing->HeatSource = $MLSRecord['HeatingFuel'];
		$MLSListing->HeatType = $MLSRecord['Heating'];
		//$MLSListing->HydroIncluded = $MLSRecord['Hydro_inc'];
		$MLSListing->IDXUpdatedDate = $MLSRecord['ModificationTimestamp'];
		//$MLSListing->Kitchens = $MLSRecord['Num_kit'];
		//$MLSListing->KitchensPlus = $MLSRecord['Kit_plus'];
		//$MLSListing->LaundryAccess = $MLSRecord['Laundry'];
		//$MLSListing->LaundryLevel = $MLSRecord['Laundry_lev'];
		
		$MLSListing->ListBrokerage = $MLSRecord['ListOfficeName'];
		$MLSListing->Price = $MLSRecord['ListPrice'];
		//$MLSListing->MapNum = $MLSRecord['Mmap_page'];
		//$MLSListing->MapColumnnNum = $MLSRecord['Mmap_col'];
		//$MLSListing->MapRow = $MLSRecord['Mmap_row'];
		$MLSListing->MLS = $MLSRecord['OriginatingSystemKey'];
		$MLSListing->Municipality = $MLSRecord['City'];
		//$MLSListing->MunicipalityDistrict = $MLSRecord['Municipality_district'];
		//$MLSListing->MunicpCode = $MLSRecord['Municipality_code'];
		//$MLSListing->OutofAreaMunicipality = $MLSRecord['Outof_area'];
		//$MLSListing->ParkingIncluded = $MLSRecord['Prkg_inc'];
		//$MLSListing->ParkingSpaces = $MLSRecord['ParkingTotal'];
		//$MLSListing->PIN = $MLSRecord['Parcel_id'];
		$MLSListing->PixUpdatedDate = $MLSRecord['PhotosChangeTimestamp'];
		$MLSListing->PostalCode = $MLSRecord['PostalCode'];
		//$MLSListing->PrivateEntrance = $MLSRecord['Pvt_ent'];
		$MLSListing->Province = $MLSRecord['StateOrProvince'];
		$MLSListing->RemarksForClients = $MLSRecord['PublicRemarks'];
		//$MLSListing->Retirement = $MLSRecord['Retirement'];
		//$MLSListing->TotalRooms = $MLSRecord['Rms'];
		//$MLSListing->RoomsPlus = $MLSRecord['Rooms_plus'];
		$MLSListing->SaleLease = (empty($MLSRecord['LeaseTerm'])) ? "Sale" : "Lease";
		$MLSListing->SaleOrRent = ($MLSListing->SaleLease == "Sale") ? "Sale" : "Lease"; //Keep Consistant with Listing
		//$MLSListing->SpecialDesignation = $MLSRecord['Spec_des1_out'].(!empty($MLSRecord['Spec_des2_out']) ? ", ".$MLSRecord['Spec_des2_out'].(!empty($MLSRecord['Spec_des3_out']) ? ", ".$MLSRecord['Spec_des3_out'].(!empty($MLSRecord['Spec_des4_out']) ? ", ".$MLSRecord['Spec_des4_out'].(!empty($MLSRecord['Spec_des5_out']) ? ", ".$MLSRecord['Spec_des5_out'].(!empty($MLSRecord['Spec_des6_out']) ? ", ".$MLSRecord['Spec_des6_out'] : '') : '') : '') : '') : '');
		//$MLSListing->MLSStatus = $MLSRecord['Status'];
		$MLSListing->StreetNum = $MLSRecord['StreetNumber'];
		$MLSListing->StreetAbbreviation = $MLSRecord['StreetSuffix'];
		$MLSListing->StreetDirection = $MLSRecord['StreetDirSuffix'];
		$MLSListing->StreetName = $MLSRecord['StreetName'];
		$MLSListing->Style = $MLSRecord['PropertyType'];
		//$MLSListing->TaxYear = $MLSRecord['Yr'];
		//$MLSListing->Taxes = $MLSRecord['Taxes'];
		$MLSListing->Type = $MLSRecord['PropertyType'];
		//$MLSListing->UFFI = $MLSRecord['Uffi'];
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