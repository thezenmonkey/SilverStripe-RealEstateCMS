<?php
/**
 * 	
 * @package RETS System 
 * @requires  MLSListing.php phrets.php
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
class RETS_Controller extends Controller {
	
	private static $allowed_actions = array(
		'MLSUpdate' => 'ADMIN',
		'ImageUpdate' => 'ADMIN'
	);
	
	private static $url_handlers = array(
        'MLSUpdate/$Action/$ID/$Name' => 'MLSUpdate'
    );
	
	public function MLSUpdate() {
		global $_RETS_SERVER_INFO;
		$rets_login_url = $_RETS_SERVER_INFO['URL'];
		$params = Controller::getURLParams();
		//rets config;
		$bridge = $this->config()->RETSBridge;
		// Create Log
		$log = new RMSProcess();
		$log->Title = "MLS Update";
		$log->Value = $params['ID'];
		$log->write();
		if($params['ID'] == "all"){
			$rets_username = $_RETS_SERVER_INFO['LOGIN_ALL'];
			$previous_start_time = "2012-01-01T00:00:00";
		} elseif  ($params['ID'] == "update"){
			$rets_username = $_RETS_SERVER_INFO['LOGIN_UPDATE'];
			$previous_start_time = date("Y-m-d", time() - 60 * 60 * 24)."T00:00:00";
			//$previous_start_time = "2012-10-10T00:00:00";
		} elseif ($params['ID'] == "check") {
			$rets_username = $_RETS_SERVER_INFO['LOGIN_ALL'];
			$previous_start_time = date("Y-m-d", time() - 60 * 60 * 24)."T00:00:00";
			$clean = array();
		} elseif ($params['ID'] == "quick") {
			$rets_username = $_RETS_SERVER_INFO['LOGIN_UPDATE'];
			$previous_start_time = date("Y-m-d")."T".date("H:i:s", time() - 60 * 60 * 3);
		} else {
			return "Invalid Parameter";
		}
		$rets_password = $_RETS_SERVER_INFO['PASSWORD'];
		
		echo "+ Yesterday {$previous_start_time}<br>\n";
		
		//$previous_start_time = "2012-09-31T00:00:00";
		
		// use http://retsmd.com to help determine the SystemName of the DateTime field which
		// designates when a record was last modified
		//$rets_modtimestamp_field = "timestamp_sql";
		
		// use http://retsmd.com to help determine the names of the classes you want to pull.
		// these might be something like RE_1, RES, RESI, 1, etc.
		$property_classes = array("ResidentialProperty","CondoProperty");
		
		
		
		//////////////////////////////
		
		
		
		// start rets connection
		$rets = new phRETS;
		
		// only enable this if you know the server supports the optional RETS feature called 'Offset'
		$rets->SetParam("offset_support", true);
		
		echo "+ Connecting to {$rets_login_url} as {$rets_username}<br>\n";
		$connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);
		
		if ($connect) {
		        echo "  + Connected<br>\n";
		}
		else {
		        echo "  + Not connected:<br>\n";
		        print_r($rets->Error());
		        exit;
		}
		
		$listingEdited = array();
		
		foreach ($property_classes as $class) {
				$log->Events()->add(RMSLogging::createEvent("Start". $class. "Query"));
		        echo "+ Property:{$class}<br>\n";
		        
		        $todaysDate = date("Y-m-d");
		
		        $fields_order = array();
		        
		        $config = SiteConfig::current_site_config();
		        if($config->MLSMax != 0) {
			        $minVal = $config->MLSMin;
					$maxVal = $config->MLSMax;
		        } else {
			        return "Please configure MLS Defaults in Site Settings";
		        }
		        
		        if($params['ID'] == "all") {
		        	
			        $query = "(Status = A),(lp_dol = $minVal-$maxVal),(s_r = Sale)";
		
			        // run RETS search
			        echo "   + Resource: Property   Class: {$class}   Query: {$query}<br>\n";
			        $log->Events()->add(RMSLogging::createEvent("Query", $query));
			        $search = $rets->SearchQuery("Property", $class, $query); //set to 100 for testing
		        } elseif ($params['ID'] == "check") {
			        $query = "(Status = A)";
		
			        // run RETS search
			        echo "   + Resource: Property   Class: {$class}   Query: {$query}<br>\n";
			        $log->Events()->add(RMSLogging::createEvent("Query", $query));
			        $search = $rets->SearchQuery("Property", $class, $query);
			        
		        } else {
			        $query = "(timestamp_sql = {$previous_start_time}+),(lp_dol = $minVal-$maxVal),(s_r = Sale)";
		
			        // run RETS search
			        echo "   + Resource: Property   Class: {$class}   Query: {$query}<br>\n";
			        $log->Events()->add(RMSLogging::createEvent("Query", $query));
			        $search = $rets->SearchQuery("Property", $class, $query);
		        }
			    
		
		        if ($rets->NumRows($search) > 0) {
						$log->Events()->add(RMSLogging::createEvent("RETS returns", $rets->NumRows($search)));
		                // print filename headers as first line
		                $fields_order = $rets->SearchGetFields($search);
		                //fputcsv($fh, $fields_order);
						if ($params['ID'] != "check") {
							$log->Events()->add(RMSLogging::createEvent("Start MLS Listing Create"));
						}
		                // process results
		                while ($record = $rets->FetchRow($search)) {
		                        $this_record = array();
		                        foreach ($fields_order as $fo) {
		                        		
		                                $this_record[$fo] = $record[$fo];
		                                
		                        }
		                        if ($params['ID'] != "check") {
		                        	array_push($listingEdited, $this->createMLSListing($record, $class, $bridge));
		                        } else {
			                        array_push($clean, $record['Ml_num']);
		                        }
		                        //fputcsv($fh, $this_record);
		                }
		                
		                if ($params['ID'] != "check") {
							$log->Events()->add(RMSLogging::createEvent("End MLS Listing Create"));
						}
		
		        } else {
			        $log->Events()->add(RMSLogging::createEvent("RETS Fail", $rets->Error()));
			        print_r($rets->Error());
		        }
		
		        echo "    + Total found: {$rets->TotalRecordsFound($search)}<br>\n";
		        
		        
		        
		        $rets->FreeResult($search);
		        
		        
		
		        //fclose($fh);
		
		        echo "  - done<br>\n";
		
		}
		
		//Debug::show($listingEdited);
		if ($params['ID'] == "check") {
	        $log->Events()->add(RMSLogging::createEvent("Start MLS Listing Cleanup"));
	        $cleanCount = $this->MLSClean($clean);
	        $startEvent = $log->Events()->filter(array("Title" => "Start MLS Listing Cleanup"))->First();
	        $event = $log->Events()->add(RMSLogging::createEvent("Cleaned", $cleanCount));
	        $event->Duration = time() - strtotime($startEvent->Created) ;
	        $event->write();
        } else {
	        $log->Events()->add(RMSLogging::createEvent("Start MLS Image Download"));
	        $this->MLSImageUpdate($listingEdited, $rets);
	        $event = $log->Events()->filter(array("Title" => "Start MLS Image Download"))->First();
	        $event->Duration = time() - strtotime($event->Created);
	        $event->write();
        }
		
		
		echo "+ Disconnecting<br>\n";
		$log->Events()->add(RMSLogging::createEvent("Disconenect from RETS server"));
		$rets->Disconnect();
		$log->Events()->add(RMSLogging::createEvent("Complete"));
		$log->Duration = time() - strtotime($log->Created);
		$log->write();
		
	}
	
	
	// Clean MLS listings and return number delteted.
	public function MLSClean($clean) {
		$sqlQuery = new SQLQuery();
		$sqlQuery->setFrom('MLSListing');
		$sqlQuery->setSelect('ID');
		$sqlQuery->addSelect('MLS');
		$sqlQuery->addSelect('PropType');
		$sqlQuery->addWhere("PropType = 'Condo'");
		 
		// Get the raw SQL (optional)
		$rawSQL = $sqlQuery->sql();
		
		// Execute and return a Query object
		$result = $sqlQuery->execute();
		$deleteList = array();
		
		$counter = $result->numRecords();
		$i = 0;
		while ($counter > 0) {
			set_time_limit ( 30 );
			$row = $result->nextRecord();
			if(!in_array($row['MLS'],$clean)) {
				echo $row['MLS']." Not in list<br>\n";
				$listing = MLSListing::get()->byID($row['ID']);
				if ($listing) {
					echo "listing found<br>\n";
					$listing->delete();
					echo "listing deleted<br>\n";  
				} 
			
			} else {
				echo $row['MLS']." IS in list<br>\n";
			}
			$counter--;
			$i++;
		}
		return $i;	
	}
	
	
	
	/**
	 * Create new MLS Listing Object
	 *
	 * @param $MLSRecord array - should contain the RETS record from the board
	 * @param $class string - RETS property class for the record 
	 * @param $board string - Realeste Board Name (included just incase the system needs to handle multiple board confiurations)
	 * @return array(MLSListing ID => MLISLISTING MLS Number)
	 *
	 * @todo clean up unused fields from Property classes and fix concacted values to check source feild isn't blank before adding to target
	 * 
	 *
	 *
	 */
	 
	 
	public function createMLSListing($MLSRecord, $class, $board) {
		
		echo "+ MLS  = ".$MLSRecord['Ml_num'].Listing::get()->filter(array("MLS:PartialMatch" => $MLSRecord['Ml_num']))->count()." ".Listing::get()->filter(array("AdditionalMLS:PartialMatch" => $MLSRecord['Ml_num']))->count()."<br>\n";
			
		//check if own listing exists
		if(!Listing::get()->where("MLS = '".$MLSRecord['Ml_num']."'")->count() && !Listing::get()->filter(array("AdditionalMLS:PartialMatch" => $MLSRecord['Ml_num']))->count()) {
			if (!MLSListing::get()->filter("MLS", $MLSRecord['Ml_num'])->count()) {
				echo "+ New MLSListing <br>\n";
				$MLSListing = new MLSListing();
				$listState = "new";
			} else {
				$stageMLSListing = MLSListing::get()->filter("MLS", $MLSRecord['Ml_num'])->First();
				
				if($stageMLSListing->isVersioned) {
					$MLSListing = Versioned::get_by_stage('MLSListing', 'Live')->byID($stageMLSListing->ID);
				} else {
					$MLSListing = $stageMLSListing;
				}
				
				echo "+ Found MLSListing ".$MLSListing->ID." <br>\n";
				$listState = "old";
			}
		} else {
			echo "+ Own Listing <br>\n";
			return false;
		}
		
		
		$MLSlisting = $board::Convert($MLSListing, $class, $MLSRecord);
		$roomArray = $board::generateRoomArray($MLSRecord);
		
		/*
// TREB CONVERSION FUNCTIONS
		if($class == "ResidentialProperty" && $board == "TREB") {
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
			
		} elseif ($class == "CondoProperty" && $board == "TREB") {
			
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
			$MLSListing->PropType = 'Condo';
			
			
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
		$MLSListing->ListPrice = $MLSRecord['Lp_dol'];
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
		$MLSListing->Rooms = $MLSRecord['Rms'];
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
		
		
		$roomArray = array();
		!empty($MLSRecord['Rm1_out']) ? array_push($roomArray, array($MLSRecord['Rm1_out'] => array ("length" => $MLSRecord['Rm1_len'], "width" => $MLSRecord['Rm1_wth'], "desc" => $MLSRecord['Rm1_dc1_out']." ".$MLSRecord['Rm1_dc2_out']." ".$MLSRecord['Rm1_dc3_out'], "level" => $MLSRecord['Level1']))) : ''; //room 1
		
		!empty($MLSRecord['Rm2_out']) ? array_push($roomArray, array($MLSRecord['Rm2_out'] => array ("length" => $MLSRecord['Rm2_len'], "width" => $MLSRecord['Rm2_wth'], "desc" => $MLSRecord['Rm2_dc1_out']." ".$MLSRecord['Rm2_dc2_out']." ".$MLSRecord['Rm2_dc3_out'], "level" => $MLSRecord['Level2']))) : ''; //room 2
		
		!empty($MLSRecord['Rm3_out']) ? array_push($roomArray, array($MLSRecord['Rm3_out'] => array ("length" => $MLSRecord['Rm3_len'], "width" => $MLSRecord['Rm3_wth'], "desc" => $MLSRecord['Rm3_dc1_out']." ".$MLSRecord['Rm3_dc2_out']." ".$MLSRecord['Rm3_dc3_out'], "level" => $MLSRecord['Level3']))) : ''; //room 3
		
		!empty($MLSRecord['Rm4_out']) ? array_push($roomArray, array($MLSRecord['Rm4_out'] => array ("length" => $MLSRecord['Rm4_len'], "width" => $MLSRecord['Rm4_wth'], "desc" => $MLSRecord['Rm4_dc1_out']." ".$MLSRecord['Rm4_dc2_out']." ".$MLSRecord['Rm4_dc3_out'], "level" => $MLSRecord['Level4']))) : ''; //room 4
		
		!empty($MLSRecord['Rm5_out']) ? array_push($roomArray, array($MLSRecord['Rm5_out'] => array ("length" => $MLSRecord['Rm5_len'], "width" => $MLSRecord['Rm5_wth'], "desc" => $MLSRecord['Rm5_dc1_out']." ".$MLSRecord['Rm5_dc2_out']." ".$MLSRecord['Rm5_dc3_out'], "level" => $MLSRecord['Level5']))) : ''; //room 5
		
		!empty($MLSRecord['Rm6_out']) ? array_push($roomArray, array($MLSRecord['Rm6_out'] => array ("length" => $MLSRecord['Rm6_len'], "width" => $MLSRecord['Rm6_wth'], "desc" => $MLSRecord['Rm6_dc1_out']." ".$MLSRecord['Rm6_dc2_out']." ".$MLSRecord['Rm6_dc3_out'], "level" => $MLSRecord['Level6']))) : ''; //room 6
		
		!empty($MLSRecord['Rm7_out']) ? array_push($roomArray, array($MLSRecord['Rm7_out'] => array ("length" => $MLSRecord['Rm7_len'], "width" => $MLSRecord['Rm7_wth'], "desc" => $MLSRecord['Rm7_dc1_out']." ".$MLSRecord['Rm7_dc2_out']." ".$MLSRecord['Rm7_dc3_out'], "level" => $MLSRecord['Level7']))) : ''; //room 7
		
		!empty($MLSRecord['Rm8_out']) ? array_push($roomArray, array($MLSRecord['Rm8_out'] => array ("length" => $MLSRecord['Rm8_len'], "width" => $MLSRecord['Rm8_wth'], "desc" => $MLSRecord['Rm8_dc1_out']." ".$MLSRecord['Rm8_dc2_out']." ".$MLSRecord['Rm8_dc3_out'], "level" => $MLSRecord['Level8']))) : ''; //room 8
		
		
		
		if($class == "ResidentialProperty" && $board == "TREB") {
			!empty($MLSRecord['Rm9_out']) ? array_push($roomArray, array($MLSRecord['Rm9_out'] => array ("length" => $MLSRecord['Rm9_len'], "width" => $MLSRecord['Rm9_wth'], "desc" => $MLSRecord['Rm9_dc1_out']." ".$MLSRecord['Rm9_dc2_out']." ".$MLSRecord['Rm9_dc3_out'], "level" => $MLSRecord['Level9']))) : ''; //room 9
			
			!empty($MLSRecord['Rm10_out']) ? array_push($roomArray, array($MLSRecord['Rm10_out'] => array ("length" => $MLSRecord['Rm10_len'], "width" => $MLSRecord['Rm10_wth'], "desc" => $MLSRecord['Rm10_dc1_out']." ".$MLSRecord['Rm10_dc2_out']." ".$MLSRecord['Rm10_dc3_out'], "level" => $MLSRecord['Level10']))) : ''; //room 10
			
			!empty($MLSRecord['Rm11_out']) ? array_push($roomArray, array($MLSRecord['Rm11_out'] => array ("length" => $MLSRecord['Rm11_len'], "width" => $MLSRecord['Rm11_wth'], "desc" => $MLSRecord['Rm11_dc1_out']." ".$MLSRecord['Rm11_dc2_out']." ".$MLSRecord['Rm11_dc3_out'], "level" => $MLSRecord['Level11']))) : ''; //room 11
			
			!empty($MLSRecord['Rm12_out']) ? array_push($roomArray, array($MLSRecord['Rm12_out'] => array ("length" => $MLSRecord['Rm12_len'], "width" => $MLSRecord['Rm12_wth'], "desc" => $MLSRecord['Rm12_dc1_out']." ".$MLSRecord['Rm12_dc2_out']." ".$MLSRecord['Rm12_dc3_out'], "level" => $MLSRecord['Level12']))) : ''; //room 12
		}
*/
		
		$listingCity = Convert::raw2sql($MLSListing->Municipality);
		$listingHood = Convert::raw2sql($MLSListing->Community);
		$listingStatus = $MLSListing->MLSStatus;
		// END TREB
		
		// Link MLS Listing to Existing Cities and Neighbourhoods
		
		$city = DataObject::get_one('MunicipalityPage', "Title = '".$listingCity."'");
		
		if($city) {
			$MLSListing->CityID = $city->ID;
		} else {
			$sqlQuery = new SQLQuery();
			$sqlQuery->setFrom('Listing');
			$sqlQuery->selectField('Town');
			$sqlQuery->setDistinct(true);
			$result = $sqlQuery->execute();
			$townList = array();
			foreach($result as $row){
				array_push($townList, $row['Town']);
			}
			 
			$filterList = (array_filter($townList));
			$city = MunicipalityPage::get()->where("Title = 'Rural Communities'")->First();
			if($city){
				in_array($listingCity, $filterList) ? $MLSListing->CityID = $city->ID : false;
			}
		}
		if($MLSListing->CityID != 0){
			$hood = NeighbourhoodPage::get()->where("Title = '".$listingHood."'")->First();
			if($hood){
				$MLSlisting->NeighbourhoodID = $hood->ID;
			}
		}
		
		// check that the listing is avaialble
		if ($MLSListing->MLSStatus == "U") {
			echo "+ Now Unavailable <br>\n";
			if($listState == "new") {
				return false;
			} else {
				echo "+ Deleting Listing <br>\n";
				$MLSListing->delete();
				return false;
			}
		}
		
		// write listing (added destroy)
		if($MLSListing->isVersioned) {
			if($listState == "new") {
				echo "+ Writing MLSListing <br>\n";
				$MLSListing->Status = "Published";
				
				$MLSListing->write();
				$mlsID = $MLSListing->ID;
				$MLSListing->destroy();
			} else {
				echo "+ Writing Without Version MLSListing <br>\n";
				$MLSListing->write();
				$mlsID = $stageMLSListing->ID;
				$$MLSListing->destroy();
				}
		} else {
			echo "+ Writing MLSListing <br>\n";
			$MLSListing->write();
			$mlsID = $MLSListing->ID;
			$MLSListing->destroy();
		}
		
		
		//create Room() for new listings
		if($listState == "new") {
			$this->createRooms($roomArray, $mlsID);
			
			/*
foreach($roomArray as $room) {
				//$listingRoom = new Room();
				
				$roomName = key($room);
				
				if (!Room::get()->filter(
					array(
						"MLSListingID" => $mlsID, 
						"Name" => $roomName, 
						"Level" => $room[$roomName]['level'],
						"Width" => $room[$roomName]['width'],
						"Length" => $room[$roomName]['length']
					)
				)->count()) {
					$listingRoom = new Room();
				} else {
					$listingRoom = Room::get()->filter(
						array(
							"MLSListingID" => $mlsID, 
							"Name" => $roomName, 
							"Level" => $room[$roomName]['level'],
							"Width" => $room[$roomName]['width'],
							"Length" => $room[$roomName]['length']
						)
					)->First();
				}
				
				
				$listingRoom->Name = $roomName;
				$listingRoom->Level = $room[$roomName]['level'];
				$listingRoom->Width = $room[$roomName]['width'];
				$listingRoom->Length = $room[$roomName]['length'];
				$listingRoom->Note = $room[$roomName]['desc'];
				
				$listingRoom->MLSListingID = $mlsID; 
				echo "Writing ".$roomName."<br>\n";
				$listingRoom->write();
				$listingRoom->destroy();
				
			}
*/
			
		}
		
		
		if($listState == "new" && $MLSListing->isVersioned) {
			$MLSListing->publish('Stage', 'Live');
		}
		
		// if its a new listing pass back MLS number for ImageUpdate function
		if($listState =="new") {
			return array($mlsID, $MLSListing->MLS, $MLSListing->PixUpdatedDate);
		} else {
			return false;
		}
		
	}
	
	
	/**
	 * Create Rooms for New Listing
	 *
	 * @param $roomArray List of Rooms from the MLS Object
	 * @param $mlsID ID of MLSListing Object
	 */
	
	public function createRooms($roomArray = null, $mlsID = null) {
		 if($roomArray) {
			 foreach($roomArray as $room) {
				//$listingRoom = new Room();
				
				$roomName = key($room);
				
				if (!Room::get()->filter(
					array(
						"MLSListingID" => $mlsID, 
						"Name" => $roomName, 
						"Level" => $room[$roomName]['level'],
						"Width" => $room[$roomName]['width'],
						"Length" => $room[$roomName]['length']
					)
				)->count()) {
					$listingRoom = new Room();
				} else {
					$listingRoom = Room::get()->filter(
						array(
							"MLSListingID" => $mlsID, 
							"Name" => $roomName, 
							"Level" => $room[$roomName]['level'],
							"Width" => $room[$roomName]['width'],
							"Length" => $room[$roomName]['length']
						)
					)->First();
				}
				
				
				$listingRoom->Name = $roomName;
				$listingRoom->Level = $room[$roomName]['level'];
				$listingRoom->Width = $room[$roomName]['width'];
				$listingRoom->Length = $room[$roomName]['length'];
				$listingRoom->Note = $room[$roomName]['desc'];
				
				$listingRoom->MLSListingID = $mlsID; 
				echo "Writing ".$roomName."<br>\n";
				$listingRoom->write();
				$listingRoom->destroy();
				
			}
			 
			 
		 }	
		
	} 

	
	public function ImageUpdate() {
		global $_RETS_SERVER_INFO;
		$rets_login_url = $_RETS_SERVER_INFO['URL'];
		$params = Controller::getURLParams();
		if($params['ID'] == "all"){
			$rets_username = $_RETS_SERVER_INFO['LOGIN_UPDATE'];
			$previous_start_time = "1980-01-01T00:00:00";
		} elseif ($params['ID'] == "update"){
			$rets_username = $_RETS_SERVER_INFO['LOGIN_UPDATE'];
			$previous_start_time = date("Y-m-d", time() - 60 * 60 * 24)."T00:00:00";
			//$previous_start_time = "2012-10-10T00:00:00";
		} else {
			return "Invalid Parameter";
		}
		$rets_password = $_RETS_SERVER_INFO['PASSWORD'];
		
		echo "+ Yesterday {$previous_start_time}<br>\n";
		
		//$previous_start_time = "2012-09-31T00:00:00";
		
		// use http://retsmd.com to help determine the SystemName of the DateTime field which
		// designates when a record was last modified
		$rets_modtimestamp_field = "timestamp_sql";
		
		// use http://retsmd.com to help determine the names of the classes you want to pull.
		// these might be something like RE_1, RES, RESI, 1, etc.
		$property_classes = array("ResidentialProperty","CondoProperty");
		
		
		//////////////////////////////
		
		$rets = new phRETS;
		// only enable this if you know the server supports the optional RETS feature called 'Offset'
		$rets->SetParam("offset_support", true);
		
		echo "+ Connecting to {$rets_login_url} as {$rets_username}<br>\n";
		$connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);
		
		if ($connect) {
		        echo "  + Connected<br>\n";
		}
		else {
		        echo "  + Not connected:<br>\n";
		        print_r($rets->Error());
		        exit;
		}
		
		$MLSListings = MLSListing::get();
		
		echo " + ".$MLSListings->count()." Listings<br>\n";
		
		
		foreach ($MLSListings as $MLSlisting) {
			if($MLSlisting->PixUpdateDate >= $previous_start_time) {
				echo "<br>\n  +Photos Updated:<br>\n";
			}
			
			if(!$MLSlisting->Images()->count()) {
				echo "<br>\n  +No Images:<br>\n";
			}
			
			
			if(!$MLSlisting->Images()->count() || $MLSlisting->PixUpdateDate >= $previous_start_time) {
				echo "  + MLS: ".$MLSlisting->MLS."<br>\n";
				$photos = $rets->GetObject("Property", "Photo", $MLSlisting->MLS, "*", 0);
				//print_r($photos);
				foreach ($photos as $photo) {
				        $listing = $photo['Content-ID'];
				        $number = $photo['Object-ID'];
				        echo "  + Photo ". $photo['Object-ID'].":<br>\n";
				        if ($photo['Success'] == true) {
				                file_put_contents("../assets/Homes/MLS/image-{$listing}-{$number}.jpg", $photo['Data']);
				                echo "  + writing image-{$listing}-{$number}.jpg:<br>\n";
				                if(!Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->count()){
					                $image = new Image();
					                $image->Filename = "assets/Homes/MLS/image-{$listing}-{$number}.jpg";
					                $image->Title = "{$listing}-{$number}";
					                $image->MLSListingID = $MLSlisting->ID;
					                $folder = Folder::get()->filter("Filename","assets/Homes/MLS/")->First();
					                $image->ParentID = $folder->ID;
					                echo "  + Creating image-{$listing}-{$number} Listing Image:<br>\n";
					                if($number == 1) {
						                $image->Cover = 1;
					                }
					                $image->write();
					                $image->destroy();
				                } elseif (Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->First()->MLSListingID != $MLSlisting->ID) {
					                echo "+ getting image object <br>/n";
					                $image = Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->First();
					                echo "+ ID set to".$MLSlisting->ID." <br>/n";
					                $image->MLSListingID = $MLSlisting->ID;
					                if($number == 1) {
						                $image->Cover = 1;
					                }
					                $image->write();
					                $image->destroy();
				                }
				        }
				        else {
				                echo "({$listing}-{$number}): {$photo['ReplyCode']} = {$photo['ReplyText']}\n";
				        }
				}
			}
			
			
		}
		
		
		
		echo "+ Disconnecting<br>\n";
		$rets->Disconnect();
		
	}


	public function MLSImageUpdate($listingArray, $rets) {
		
		foreach($listingArray as $listingItem) {
			if(is_array($listingItem)) {
				if( strtotime($listingItem[2])  >= date("Y-m-d", time() - 60 * 60 * 24)) {
					
					$photos = $rets->GetObject("Property", "Photo", $listingItem[1], "*", 0);
					//print_r($photos);
					foreach ($photos as $photo) {
					        $listing = $photo['Content-ID'];
					        $number = $photo['Object-ID'];
					        echo "  + Photo ". $photo['Object-ID'].":<br>\n";
					        if ($photo['Success'] == true) {
					                file_put_contents("../assets/Homes/MLS/image-{$listing}-{$number}.jpg", $photo['Data']);
					                echo "  + writing image-{$listing}-{$number}.jpg:<br>\n";
					                if(!Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->count()){
						                $image = new Image();
						                $image->Filename = "assets/Homes/MLS/image-{$listing}-{$number}.jpg";
						                $image->Title = "{$listing}-{$number}";
						                $image->MLSListingID = $listingItem[0];
						                $folder = Folder::get()->filter("Filename","assets/Homes/MLS/")->First();
						                $image->ParentID = $folder->ID;
						                if($number == 1) {
							                $image->Cover = 1;
						                }
						                $image->write();
						                $image->destroy();
					                }
					                
					        }
					        else {
					                echo "({$listing}-{$number}): {$photo['ReplyCode']} = {$photo['ReplyText']}\n";
					        }
					}
					
				}
					
			}
		}
		
	}
	
	public function FixNeighbourhoods($option) {
		echo "  + Fixing Neighbourhoods:<br>\n";
		$listings = MLSListing::get()->filter(array("CityID:GreaterThan" => 0, "NeighbourhoodID" => 0));
		
		foreach($listings as $listing) {
			echo "  + MLS ". $listing->MLS.":<br>\n";
			echo "  + City ". $listing->City()->Title.":<br>\n";
			echo "  + Hood ". $listing->Community.":<br>\n";
			$hoodTitle = $listing->City()->Title." - ".$listing->Community;
			$hood = Neighbourhood::get()->where("MetaTitle = '$hoodTitle'")->First();
			if($hood){
				echo " + Found ". $hood->Title;
				$listing->NeighbourhoodID = $hood->ID;
				$listing->write();
			}
			
		}
		
	}


	public function FixStreets() {
		$listings = Listing::get();
		
		foreach($listings as $listing) {
			if ( is_null($listing->Street) ) {
				echo "  + needs street<br>\n";
				$listing->Street = trim(str_replace(range(0,9),'',$listing->Address));
				echo "  + ".$listing->Street."<br><br>\n";
				$listing->write();
			} else {
				echo "  + has street<br>\n";
			}
			
			
		}
	}

	
	
}