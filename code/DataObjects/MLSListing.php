<?php 

/**
 * 	
 * @package RETS System 
 * @requires 
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */
 
class MLSListing extends DataObjectAsPage {
	/**
	 * Static vars
	 * ----------------------------------*/
	//The class of the page which will list this DataObject
	static $listing_page_class = 'MLSListingsPage';
	//Class Naming (optional but reccomended)
	static $plural_name = 'MLSListings';
	static $singular_name = 'MLSListing';
	
	static $summary_fields = array(
		"Title",
		"Municipality",
		"Price",
		"IsFeatured",
		"MLS"
	);
	
	
	
	/**
	 * Object vars
	 * ----------------------------------*/
	
	
	
	/**
	 * Static methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Data model
	 * ----------------------------------*/
	
	static $db = array(
		'IsFeatured' => "Boolean",
		'ListingType' => "Enum('House,Condo,Commercial')",
		'Shares' => "Varchar(6)",
		'Acreage' => "Varchar(8)",
		'AddlMonthlyFees' => "Varchar(10)",
		'Address' => "Varchar(35)",
		'AirConditioning' => "Varchar(11)",
		'AllInclusiveRental' => "Varchar(1)",
		'ApproxAge' => "Varchar(5)",
		'ApproxSquareFootage' => "Varchar(9)",
		'AptUnit' => "Varchar(5)",
		'Area' => "Varchar(40)",
		'Assessment' => "Decimal(9,2)",
		'AssessmentYear' => "Varchar(10)",
		'Balcony' => "Varchar(4)",
		'Basement' => "Varchar",
		'Bedrooms' => "Varchar(10)",
		'BedroomsPlus' => "Varchar(10)",
		'BuildingAmenities' => "Text",
		'BuildingInsuranceIncluded' => "Boolean",
		'CableTVIncluded' => "Boolean",
		'CACIncluded' => "Boolean",
		'CentralVac' => "Boolean",
		'CommonElementsIncluded' => "Boolean",
		'Community' => "Varchar(44)", //neighbourhood
		'CommunityCode' => "Varchar",
		'CondoCorpNum' => "Varchar",
		'CondoRegistryOffice' => "Varchar",
		'CondoTaxesIncluded' => "Boolean",
		'DirectionsCrossStreets' => "Varchar(20)",
		'Drive' => "Varchar(10)",
		'Elevator' => "Varchar(7)",
		'Exterior' => "Varchar",
		'EnsuiteLaundry' => "Boolean",
		'Exposure' => "Varchar(2)",
		'Extras' => "Varchar(240)",
		'FarmAgriculture' => "Varchar(12)",
		'FireplaceStove' => "Boolean",
		'Fronting' => "Varchar(1)",
		'Furnished' => "Varchar(4)",
		'GarageSpaces' => "Int",
		'GarageType' => "Varchar(16)",
		'HeatIncluded' => "Boolean",
		'HeatSource' => "Varchar(9)",
		'HeatType' => "Varchar()",
		'HydroIncluded' => "Boolean",
		'IDXUpdatedDate' => "SS_Datetime",
		'Kitchens' => "Varchar(10)",
		'KitchensPlus' => "Varchar(10)",
		'LaundryAccess' => "Varchar(13)",
		'LaundryLevel' => "Varchar(5)",
		'LeaseTerm' => "Varchar()",
		'LegalDescription' => "Varchar(40)",
		'ListBrokerage' => "Varchar(60)",
		'Price' => "Int",
		'Locker' => "Varchar(17)",
		'LockerNum' => "Varchar(17)",
		'LotDepth' => "Decimal(9,2)",
		'LotFront' => "Decimal(9,2)",
		'LotIrregularities' => "Varchar(21)",
		'LotSizeCode' => "Varchar(8)",
		'Maintenance' => "Currency",
		'MapNum' => "Varchar(10)",
		'MapColumnnNum' => "Varchar(10)",
		'MapRow' => "Varchar(1)",
		'MLS' => "Varchar(8)",
		'Municipality' => "Varchar(40)",
		'MunicipalityDistrict' => "Varchar(44)",
		'MunicpCode' => "Varchar(10)",
		'OtherStructures' => "Varchar",
		'OutofAreaMunicipality' => "Varchar(16)",
		'ParkCostMo' => "Currency",
		'ParkingIncluded' => "Boolean",
		'ParkingLegalDescription' => "Varchar",
		'ParkingSpaces' => "Varchar(10)",
		'ParkingSpot1' => "Varchar(4)",
		'ParkingSpot2' => "Varchar(4)",
		'ParkingType' => "Varchar(10)",
		'ParkingType2' => "Varchar(10)",
		'ParkingDrive' => "Varchar(10)",
		'PetsPermitted' => "Varchar(8)",
		'PIN' => "Varchar(9)",
		'PixUpdatedDate' => "SS_Datetime",
		'Pool' => "Varchar()",
		'PostalCode' => "Varchar(8)",
		'PrivateEntrance' => "Boolean",
		'PropertyFeatures1' => "Varchar",
		'Province' => "Varchar(16)",
		'RemarksForClients' => "Text",
		'Retirement' => "Boolean",
		'TotalRooms' => "Varchar(10)",
		'RoomsPlus' => "Varchar(10)",
		'SaleLease' => "Varchar(9)",
		'SellerPropertyInfoStatement' => "Varchar(10)",
		'Sewers' => "Varchar(15)",
		'SpecialDesignation1' => "Varchar",
		'MLSStatus' => "Varchar(1)",
		'StreetNum' => "Varchar(7)",
		'StreetAbbreviation' => "Varchar(4)",
		'StreetDirection' => "Varchar(1)",
		'StreetName' => "Varchar(20)",
		'Style' => "Varchar(16)",
		'TaxYear' => "Varchar(10)",
		'Taxes' => "Currency",
		'Type' => "Varchar(18)",
		'UFFI' => "Varchar(12)",
		'UnitNum' => "Varchar(4)",
		'UpdatedTimestamp' => "SS_Datetime",
		'UtilitiesCable' => "Boolean",
		'UtilitiesGas' => "Boolean",
		'UtilitiesHydro' => "Boolean",
		'UtilitiesTelephone' => "Boolean",
		'Washrooms' => "Varchar(10)",
		'Water' => "Varchar(9)",
		'WaterIncluded' => "Boolean",
		'WaterSupplyTypes' => "Varchar(12)",
		'Waterfront' => "Varchar(8)",
		'Zoning' => "Varchar(16)",
		'Lat' => 'Varchar(50)',
		'Lon' => 'Varchar(50)',
	);
	
	static $has_many = array(
		'Rooms' => 'Room',
		'Images' => 'Image'	
	);
	
	static $has_one = array(
		"City" => "MunicipalityPage",
		"Neighbourhood" => "NeighbourhoodPage",
	);
	
	/**
	 * Common methods
	 * ----------------------------------*/
	 
	 
	public function getCMSFields() {
	 	$fields = parent::getCMSFields();
	 	
	 	$fields->insertBefore ( new HeaderField('AddressHead','Address Info',2), 'ListingType' );
	 	
	 	$fields->makeReadOnly();
	 	
	 	$gridFieldConfig = GridFieldConfig_RelationEditor::create();
	 	$gridFieldConfig->addComponent(
	 		new GridFieldDeleteAction()
	 	);
	 	$gridField = new GridField('Images', 'Linked images', $this->Images(), $gridFieldConfig);
	 	
	 	
	 	$fields->addFieldToTab("Root.Images", $gridField);
	 	
	 	return $fields;
	 	
	 }
	
	function onBeforeWrite()
	 	{
			if(!$this->ID) {
			
				//Encode Google Maps Data
				if ( is_null($this->Lat) || is_null($this->Lon) ) {
					
					$LatLon = Geocoder::Geocode($this->Address." ".$this->Municipality." ".$this->Province." ".$this->PostalCode);
					
					if($LatLon) {
						$this->Lat = $LatLon["Lat"];
						$this->Lon = $LatLon["Lon"];
					}
					
				}
				
				
			}
			
			//change urls and titles segment to include city
				$filter = URLSegmentFilter::create();
				
				$this->URLSegment = $filter->filter($this->Address.(!empty($this->UnitNum) ? " ".$this->UnitNum : '')." ". $this->Municipality);
				$this->MetaTitle = $this->Address." ". $this->Municipality;
				$this->Title = $this->Address.(!empty($this->UnitNum) ? " ".$this->UnitNum : '')." ". $this->Municipality;
			
			/**
			 * Clean Values
			 */
			$searchArray = array('$',',');
			if(!empty($this->Price)){
				$this->Price = trim(str_replace($searchArray, "", $this->Price));
			}
			
			if(!empty($this->Taxes)){
				$this->Taxes = trim(str_replace($searchArray, "", $this->Taxes));
			}
			
			if(!empty($this->Address)){
				$this->Address = trim(ucwords(strtolower($this->Address)));
			}
			
			
			if(!empty($this->PostalCode)){
				$this->PostalCode = trim(strtoupper($this->PostalCode));
			}
			
			parent::onBeforeWrite();	
			
			
	 		
	 		
	 	}
	 	
		public function onBeforeDelete() {
			
			if($this->Rooms()->count()) {
				$rooms = $this->Rooms();
				foreach($rooms as $room) {
					$room->delete();
				}
			}
			
			if($this->Images()->count()){
				$pictures = $this->Images();
				foreach($pictures as $picture) {
					$picture->delete();
				}
			}
			
			parent::onBeforeDelete();
		}
		
	function requireDefaultRecords() {
	
		Folder::find_or_make('Homes/MLS');
	
		parent::requireDefaultRecords();
	}
	
	/**
	 * Accessor methods
	 * ----------------------------------*/
	
	
	
	/**
	 * Controller actions
	 * ----------------------------------*/
	
	
	/**
	 * Template accessors
	 * ----------------------------------*/
	
	public function NumberBed(){
		return $this->Bedrooms.($this->BedroomsPlus != 0 ? "+".$this->BedroomsPlus : '');
	}
	
	public function NumberBath(){
		return $this->Washrooms;
	}
	
	public function LotLength() {
		return $this->LotDepth != "0.00" ? $this->LotDepth : false;
	}
	
	public function LotWidth() {
		return $this->LotFront != "0.00" ? $this->LotFront : false;
	}
	
	public function LotAcreage() {
		return !$this->Acreage ? $this->Acreage : false;
	}
	
	public function FormattedPrice() {
		setlocale(LC_MONETARY, 'en_CA');
		return $this->Price != 0 ? money_format('%.0n', $this->Price) : false;
	}
	
	public function PriceClass(){
		$PriceClass = false;
		switch ($this->Price) {
			case ($this->Price >= 0 && $this->Price <= 500000 ):
				$PriceClass = "price0-500k";
				break;
			case ($this->Price >= 500001 && $this->Price <= 1000000 ):
				$PriceClass = "price500-1m";
				break;
			case ($this->Price >= 1000001 && $this->Price <= 2000000 ):
				$PriceClass = "price1-2m";
				break;
			case ($this->Price >= 2000001):
				$PriceClass = "price2m";
				break;
		}
		return $PriceClass;
	}
	
	public function FormattedTaxes() {
		setlocale(LC_MONETARY, 'en_CA');
		return $this->Taxes != 0 ? money_format('%.0n', $this->Taxes) : false;
	}
	
	public function GetCover() {
		return $this->Images()->First() ? $this->Images()->First() : false;
	}
	
	public function MonthlyPrice(){
		if($this->Price){
			$borrowed = $this->Price - ceil($this->Price*0.2);
			$int = 0.0289/12;
			$term = 360;
			setlocale(LC_MONETARY, 'en_CA');
			return money_format('%.0n',floor((($borrowed*$int)/(1-pow(1+$int, (-1*$term)))*100)/100));
		} else {
			return false;
		}
	}
	
	public function ShowBroker() {
		return ucwords(strtolower($this->ListBrokerage));
	}
	
	
	
	 function RelatedProperties() {
	 	$method = $_GET["method"];
	 	$value = $_GET["value"];
	 	$set = new ArrayList();
	 	
	 	if($this->CityID != 0) {
		 	
			if($method == "price") {
		 		$filter = array(
		 			"Price:LessThan" => $value + 50000,
		 			"Price:GreaterThan" => $value - 50000,
		 			"CityID" => $this->CityID,
		 			"Sold" => 0
		 		);
		 		foreach(Listing::get()->filter($filter)->limit(4) as $obj) $set->push($obj);
		 	} elseif ($method == "neighbourhood") {
		 		$filter = array(
		 			"CityID" => $this->CityID,
		 			"Sold" => 0
		 		);
		 		$items = Listing::get()->filter($filter);
		 		if($items->count()){
			 		foreach($items as $item) {
				 		$this->getDistance($item->Lat, $item->Lon) <= 15 ? $set->push($item) : false;
			 		}
			 		$set->count() && $set->count() > 4 ? $set = $set->limit(4) : false;
		 		}
		 		
		 	} 	
		 	
		 	
	 	}
	 	
	 	
	 	
	 	if(!$set->count() || $set->count() < 4) {
		 	$limit = 4 - $set->count();
		 	if($method == "price") {
		 		$filter = array(
		 			"Price:LessThan" => $value + 50000,
		 			"Price:GreaterThan" => $value - 50000,
		 			"Municipality" => $this->Municipality
		 		);
		 		foreach(MLSListing::get()->filter($filter)->limit($limit) as $obj) $set->push($obj);
		 	} elseif ($method == "neighbourhood") {
		 		$newSet = new ArrayList();
		 		$filter = array(
		 			"Municipality" => $this->Municipality
		 		);
		 		$newItems = MLSListing::get()->filter($filter);
		 		if($newItems->count()){
			 		foreach($newItems as $item){
			 			$this->getDistance($item->Lat, $item->Lon) <= 15 ? $newSet->push($item) : false;
			 		}
			 		$newSet->count() && $newSet->count() > $limit ? $newSet = $newSet->limit($limit) : false;
			 		foreach($newSet as $obj ) $set->push($obj);
		 		}
		 	}
		 	
		 	
		 	
		 	
	 	}
	 	
	    if(!$set) return new HTTPResponse("Not found", 404);
	     
	    // Use HTTPResponse to pass custom status messages
	    $this->response->setStatusCode(200, "Found " . $set->Count() . " elements");
	 	
		$vd = new ViewableData();
	    return $vd->customise(array(
	      "Results" => $set
	    ))->renderWith('AjaxRelated');
	 	
	 }
	 
	 public function ListingRequestForm() {
		return new ListingRequestForm($this, 'ListingRequestForm');
	}
	
	public function DownPayment() {
		return ceil($this->Price()*0.2);
	}
	
	
	
	
	
	/**
	 * Object methods
	 * ----------------------------------*/
	
}