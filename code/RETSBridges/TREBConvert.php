<?php

class TREBConvert {
	
	static public function Convert($MLSListing, $class, $MLSRecord) {
		
		// TREB CONVERSION FUNCTIONS
		if($class == "ResidentialProperty") {
			$MLSListing->Acreage = $MLSRecord['Acres'];
			$MLSListing->AddlMonthlyFees = $MLSRecord['Addl_mo_fee'];
			$MLSListing->Drive = $MLSRecord['Drive'];
			$MLSListing->Extras = $MLSRecord['Extras'];
			$MLSListing->GarageSpaces = $MLSRecord['Gar_spaces'];
			//$MLSListing->Fronting = $MLSRecord['Comp_pts'];
			$MLSListing->LegalDescription = $MLSRecord['Legal_desc'];
			$MLSListing->LotDepth = $MLSRecord['Depth'];
			$MLSListing->LotFront = $MLSRecord['Front_ft'];
			$MLSListing->LotIrregularities = $MLSRecord['Irreg'];
			$MLSListing->LotSizeCode = $MLSRecord['Lotsz_code'];
			$MLSListing->OtherStructures = $MLSRecord['Oth_struc1_out'].(!empty($MLSRecord['Oth_struc2_out']) ? ", ".$MLSRecord['Oth_struc2_out'] : '');
			$MLSListing->ParkCostMo = $MLSRecord['Park_chgs'];
			$MLSListing->Pool = $MLSRecord['Pool'];
			$MLSListing->PropertyFeatures = $MLSRecord['Prop_feat1_out'].(!empty($MLSRecord['Prop_feat2_out']) ? ", ".$MLSRecord['Prop_feat2_out'].(!empty($MLSRecord['Prop_feat3_out']) ? ", ".$MLSRecord['Prop_feat3_out'].(!empty($MLSRecord['Prop_feat4_out']) ? ", ".$MLSRecord['Prop_feat4_out'].(!empty($MLSRecord['Prop_feat5_out']) ? ", ".$MLSRecord['Prop_feat5_out'].(!empty($MLSRecord['Prop_feat6_out']) ? ", ".$MLSRecord['Prop_feat6_out'] : '') : '') : '') : '') : '');
			$MLSListing->SellerPropertyInfoStatement = $MLSRecord['Vend_pis'];
			$MLSListing->Sewers = $MLSRecord['Sewer'];
			$MLSListing->UtilitiesCable = $MLSRecord['Util_cable'];
			$MLSListing->UtilitiesGas = $MLSRecord['Gas'];
			$MLSListing->UtilitiesHydro = $MLSRecord['Elec'];
			//$MLSListing->UtilitiesTelephone = $MLSRecord['Util_tel'];
			$MLSListing->Water = $MLSRecord['Water'];
			$MLSListing->WaterIncluded = $MLSRecord['Water_inc'];
			$MLSListing->WaterSupplyTypes = $MLSRecord['Wtr_suptyp'];
			$MLSListing->Waterfront = $MLSRecord['Waterfront'];
			
			//$MLSListing->LeaseTerm = $MLSRecord['Lease'];
			
		} elseif ($class == "CondoProperty") {
			
			$MLSListing->BuildingInsuranceIncluded = $MLSRecord['Insur_bldg'];
			$MLSListing->Shares = $MLSRecord['Share_perc'];
			$MLSListing->Balcony = $MLSRecord['Patio_ter'];
			$MLSListing->AptUnit = $MLSRecord['Apt_num'];
			$MLSListing->BuildingAmenities = $MLSRecord['Bldg_amen1_out'].(!empty($MLSRecord['Bldg_amen2_out']) ? ", ".$MLSRecord['Bldg_amen2_out'].(!empty($MLSRecord['Bldg_amen3_out']) ? ", ".$MLSRecord['Bldg_amen3_out'].(!empty($MLSRecord['Bldg_amen4_out']) ? ", ".$MLSRecord['Bldg_amen4_out'].(!empty($MLSRecord['Bldg_amen5_out']) ? ", ".$MLSRecord['Bldg_amen5_out'].(!empty($MLSRecord['Bldg_amen6_out']) ? ", ".$MLSRecord['Bldg_amen6_out'] : '') : '') : '') : '') : '');
			$MLSListing->Exterior = $MLSRecord['Constr1_out'].(!empty($MLSRecord['Constr2_out']) ? ", ".$MLSRecord['Constr2_out'] : '');
			$MLSListing->CondoCorpNum = $MLSRecord['Corp_num'];
			$MLSListing->CondoRegistryOffice = $MLSRecord['Condo_corp'];
			$MLSListing->CondoTaxesIncluded = $MLSRecord['Cond_txinc'];
			$MLSListing->EnsuiteLaundry = $MLSRecord['Ens_lndry'];
			$MLSListing->Exposure = $MLSRecord['Condo_exp'];
			$MLSListing->ParkingLegalDescription = $MLSRecord['Park_lgl_desc1'].(!empty($MLSRecord['Park_lgl_desc2']) ? ", ".$MLSRecord['Park_lgl_desc2'] : '');
			$MLSListing->ParkingSpot1 = $MLSRecord['Park_spc1'];
			$MLSListing->ParkingSpot2 = $MLSRecord['Park_spc2'];
			$MLSListing->ParkingType = $MLSRecord['Park_desig'];
			$MLSListing->ParkingType2 = $MLSRecord['Park_desig_2'];
			$MLSListing->ParkingDrive = $MLSRecord['Park_fac'];
			$MLSListing->PetsPermitted = $MLSRecord['Pets'];
			$MLSListing->Locker = $MLSRecord['Locker'];
			$MLSListing->LockerNum = $MLSRecord['Locker_num'];
			$MLSListing->UnitNum = $MLSRecord['Unit_num'];
			
			$MLSListing->CentralVac = $MLSRecord['Central_vac'];
			$MLSListing->LeaseTerm = $MLSRecord['Lease_term'];
			$MLSListing->Maintenance = $MLSRecord['Maint'];
			$MLSListing->ListingType = 'Condo';
			
			
		}
		
			
			
		$MLSListing->Content = "<p>".$MLSRecord["Ad_text"]."</p>";
		$MLSListing->Address = $MLSRecord['Addr'];
		//$MLSListing->AirConditioning = $MLSRecord['A_c'];
		$MLSListing->AllInclusiveRental = $MLSRecord['All_inc'];
		$MLSListing->ApproxAge = $MLSRecord['Yr_built'];
		$MLSListing->ApproxSquareFootage = $MLSRecord['Sqft'];
		$MLSListing->Area = $MLSRecord['Area'];
		$MLSListing->Assessment = $MLSRecord['Tv'];
		$MLSListing->AssessmentYear = $MLSRecord['Ass_year'];
		$MLSListing->Basement = $MLSRecord['Bsmt1_out'].", ".$MLSRecord['Bsmt2_out'];
		$MLSListing->Bedrooms = $MLSRecord['Br'];
		$MLSListing->BedroomsPlus = $MLSRecord['Br_plus'];
		
		$MLSListing->CableTVIncluded = $MLSRecord['Cable'];
		$MLSListing->CACIncluded = $MLSRecord['Cac_inc'];
		
		$MLSListing->CommonElementsIncluded = $MLSRecord['Comel_inc'];
		$MLSListing->Community = $MLSRecord['Community']; //Neighbourhood
		$MLSListing->CommunityCode = $MLSRecord['Community_code'];
		$MLSListing->DirectionsCrossStreets = $MLSRecord['Cross_st'];
		$MLSListing->Elevator = $MLSRecord['Elevator'];
		$MLSListing->FireplaceStove = $MLSRecord['Fpl_num'];
		$MLSListing->Furnished = $MLSRecord['Furnished'];
		$MLSListing->GarageType = $MLSRecord['Gar_type'];
		$MLSListing->HeatIncluded = $MLSRecord['Heat_inc'];
		$MLSListing->HeatSource = $MLSRecord['Fuel'];
		$MLSListing->HeatType = $MLSRecord['Heating'];
		$MLSListing->HydroIncluded = $MLSRecord['Hydro_inc'];
		$MLSListing->IDXUpdatedDate = $MLSRecord['Idx_dt'];
		$MLSListing->Kitchens = $MLSRecord['Num_kit'];
		$MLSListing->KitchensPlus = $MLSRecord['Kit_plus'];
		$MLSListing->LaundryAccess = $MLSRecord['Laundry'];
		$MLSListing->LaundryLevel = $MLSRecord['Laundry_lev'];
		
		$MLSListing->ListBrokerage = $MLSRecord['Rltr'];
		$MLSListing->Price = $MLSRecord['Lp_dol'];
		$MLSListing->MapNum = $MLSRecord['Mmap_page'];
		$MLSListing->MapColumnnNum = $MLSRecord['Mmap_col'];
		$MLSListing->MapRow = $MLSRecord['Mmap_row'];
		$MLSListing->MLS = $MLSRecord['Ml_num'];
		$MLSListing->Municipality = $MLSRecord['Municipality'];
		$MLSListing->MunicipalityDistrict = $MLSRecord['Municipality_district'];
		$MLSListing->MunicpCode = $MLSRecord['Municipality_code'];
		$MLSListing->OutofAreaMunicipality = $MLSRecord['Outof_area'];
		$MLSListing->ParkingIncluded = $MLSRecord['Prkg_inc'];
		$MLSListing->ParkingSpaces = $MLSRecord['Park_spcs'];
		$MLSListing->PIN = $MLSRecord['Parcel_id'];
		$MLSListing->PixUpdatedDate = $MLSRecord['Pix_updt'];
		$MLSListing->PostalCode = $MLSRecord['Zip'];
		$MLSListing->PrivateEntrance = $MLSRecord['Pvt_ent'];
		$MLSListing->Province = $MLSRecord['County'];
		$MLSListing->RemarksForClients = $MLSRecord['Ad_text'];
		$MLSListing->Retirement = $MLSRecord['Retirement'];
		$MLSListing->TotalRooms = $MLSRecord['Rms'];
		$MLSListing->RoomsPlus = $MLSRecord['Rooms_plus'];
		$MLSListing->SaleLease = $MLSRecord['S_r'];
		$MLSListing->SpecialDesignation = $MLSRecord['Spec_des1_out'].(!empty($MLSRecord['Spec_des2_out']) ? ", ".$MLSRecord['Spec_des2_out'].(!empty($MLSRecord['Spec_des3_out']) ? ", ".$MLSRecord['Spec_des3_out'].(!empty($MLSRecord['Spec_des4_out']) ? ", ".$MLSRecord['Spec_des4_out'].(!empty($MLSRecord['Spec_des5_out']) ? ", ".$MLSRecord['Spec_des5_out'].(!empty($MLSRecord['Spec_des6_out']) ? ", ".$MLSRecord['Spec_des6_out'] : '') : '') : '') : '') : '');
		$MLSListing->MLSStatus = $MLSRecord['Status'];
		$MLSListing->StreetNum = $MLSRecord['St_num'];
		$MLSListing->StreetAbbreviation = $MLSRecord['St_sfx'];
		$MLSListing->StreetDirection = $MLSRecord['St_dir'];
		$MLSListing->StreetName = $MLSRecord['St'];
		$MLSListing->Style = $MLSRecord['Style'];
		$MLSListing->TaxYear = $MLSRecord['Yr'];
		$MLSListing->Taxes = $MLSRecord['Taxes'];
		$MLSListing->Type = $MLSRecord['Type_own_srch'].(!empty($MLSRecord['Type_own1_srch']) ? ", ".$MLSRecord['Type_own1_srch'] : '');
		$MLSListing->UFFI = $MLSRecord['Uffi'];
		$MLSListing->UpdatedTimestamp = $MLSRecord['Timestamp_sql'];
		$MLSListing->Washrooms = $MLSRecord['Bath_tot'];
		$MLSListing->Zoning = $MLSRecord['Zoning'];
		
		return $MLSListing;
	}
	
	
	static public function generateRoomArray($MLSRecord) {
		$roomArray = array();
		!empty($MLSRecord['Rm1_out']) ? array_push($roomArray, array($MLSRecord['Rm1_out'] => array ("length" => $MLSRecord['Rm1_len'], "width" => $MLSRecord['Rm1_wth'], "desc" => $MLSRecord['Rm1_dc1_out']." ".$MLSRecord['Rm1_dc2_out']." ".$MLSRecord['Rm1_dc3_out'], "level" => $MLSRecord['Level1']))) : ''; //room 1
		
		!empty($MLSRecord['Rm2_out']) ? array_push($roomArray, array($MLSRecord['Rm2_out'] => array ("length" => $MLSRecord['Rm2_len'], "width" => $MLSRecord['Rm2_wth'], "desc" => $MLSRecord['Rm2_dc1_out']." ".$MLSRecord['Rm2_dc2_out']." ".$MLSRecord['Rm2_dc3_out'], "level" => $MLSRecord['Level2']))) : ''; //room 2
		
		!empty($MLSRecord['Rm3_out']) ? array_push($roomArray, array($MLSRecord['Rm3_out'] => array ("length" => $MLSRecord['Rm3_len'], "width" => $MLSRecord['Rm3_wth'], "desc" => $MLSRecord['Rm3_dc1_out']." ".$MLSRecord['Rm3_dc2_out']." ".$MLSRecord['Rm3_dc3_out'], "level" => $MLSRecord['Level3']))) : ''; //room 3
		
		!empty($MLSRecord['Rm4_out']) ? array_push($roomArray, array($MLSRecord['Rm4_out'] => array ("length" => $MLSRecord['Rm4_len'], "width" => $MLSRecord['Rm4_wth'], "desc" => $MLSRecord['Rm4_dc1_out']." ".$MLSRecord['Rm4_dc2_out']." ".$MLSRecord['Rm4_dc3_out'], "level" => $MLSRecord['Level4']))) : ''; //room 4
		
		!empty($MLSRecord['Rm5_out']) ? array_push($roomArray, array($MLSRecord['Rm5_out'] => array ("length" => $MLSRecord['Rm5_len'], "width" => $MLSRecord['Rm5_wth'], "desc" => $MLSRecord['Rm5_dc1_out']." ".$MLSRecord['Rm5_dc2_out']." ".$MLSRecord['Rm5_dc3_out'], "level" => $MLSRecord['Level5']))) : ''; //room 5
		
		!empty($MLSRecord['Rm6_out']) ? array_push($roomArray, array($MLSRecord['Rm6_out'] => array ("length" => $MLSRecord['Rm6_len'], "width" => $MLSRecord['Rm6_wth'], "desc" => $MLSRecord['Rm6_dc1_out']." ".$MLSRecord['Rm6_dc2_out']." ".$MLSRecord['Rm6_dc3_out'], "level" => $MLSRecord['Level6']))) : ''; //room 6
		
		!empty($MLSRecord['Rm7_out']) ? array_push($roomArray, array($MLSRecord['Rm7_out'] => array ("length" => $MLSRecord['Rm7_len'], "width" => $MLSRecord['Rm7_wth'], "desc" => $MLSRecord['Rm7_dc1_out']." ".$MLSRecord['Rm7_dc2_out']." ".$MLSRecord['Rm7_dc3_out'], "level" => $MLSRecord['Level7']))) : ''; //room 7
		
		!empty($MLSRecord['Rm8_out']) ? array_push($roomArray, array($MLSRecord['Rm8_out'] => array ("length" => $MLSRecord['Rm8_len'], "width" => $MLSRecord['Rm8_wth'], "desc" => $MLSRecord['Rm8_dc1_out']." ".$MLSRecord['Rm8_dc2_out']." ".$MLSRecord['Rm8_dc3_out'], "level" => $MLSRecord['Level8']))) : ''; //room 8
		
		
		
		
			!empty($MLSRecord['Rm9_out']) ? array_push($roomArray, array($MLSRecord['Rm9_out'] => array ("length" => $MLSRecord['Rm9_len'], "width" => $MLSRecord['Rm9_wth'], "desc" => $MLSRecord['Rm9_dc1_out']." ".$MLSRecord['Rm9_dc2_out']." ".$MLSRecord['Rm9_dc3_out'], "level" => $MLSRecord['Level9']))) : ''; //room 9
			
			!empty($MLSRecord['Rm10_out']) ? array_push($roomArray, array($MLSRecord['Rm10_out'] => array ("length" => $MLSRecord['Rm10_len'], "width" => $MLSRecord['Rm10_wth'], "desc" => $MLSRecord['Rm10_dc1_out']." ".$MLSRecord['Rm10_dc2_out']." ".$MLSRecord['Rm10_dc3_out'], "level" => $MLSRecord['Level10']))) : ''; //room 10
			
			!empty($MLSRecord['Rm11_out']) ? array_push($roomArray, array($MLSRecord['Rm11_out'] => array ("length" => $MLSRecord['Rm11_len'], "width" => $MLSRecord['Rm11_wth'], "desc" => $MLSRecord['Rm11_dc1_out']." ".$MLSRecord['Rm11_dc2_out']." ".$MLSRecord['Rm11_dc3_out'], "level" => $MLSRecord['Level11']))) : ''; //room 11
			
			!empty($MLSRecord['Rm12_out']) ? array_push($roomArray, array($MLSRecord['Rm12_out'] => array ("length" => $MLSRecord['Rm12_len'], "width" => $MLSRecord['Rm12_wth'], "desc" => $MLSRecord['Rm12_dc1_out']." ".$MLSRecord['Rm12_dc2_out']." ".$MLSRecord['Rm12_dc3_out'], "level" => $MLSRecord['Level12']))) : ''; //room 12
		
		
		return $roomArray;
		
	}
}