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
	static $listing_page_class = 'ListingsPage';
	//Class Naming (optional but reccomended)
	static $plural_name = 'MLSListings';
	static $singular_name = 'MLSListing';
	
	static $summary_fields = array(
		'FrontCover',
		"Title",
		"Municipality",
		"Price",
		"IsFeatured",
		"MLS"
	);
	
	private static $searchable_fields = array(
		'Title' => array("title" => "Address")
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
		'Shares' => "Varchar",
		'Acreage' => "Varchar",
		'AddlMonthlyFees' => "Varchar",
		'Address' => "Varchar",
		'AirConditioning' => "Varchar",
		'AllInclusiveRental' => "Varchar",
		'ApproxAge' => "Varchar",
		'ApproxSquareFootage' => "Varchar",
		'AptUnit' => "Varchar",
		'Area' => "Varchar",
		'Assessment' => "Decimal(9,2)",
		'AssessmentYear' => "Varchar",
		'Balcony' => "Varchar",
		'Basement' => "Varchar",
		'Bedrooms' => "Varchar",
		'BedroomsPlus' => "Varchar",
		'BuildingAmenities' => "Text",
		'BuildingInsuranceIncluded' => "Boolean",
		'CableTVIncluded' => "Boolean",
		'CACIncluded' => "Boolean",
		'CentralVac' => "Boolean",
		'CommonElementsIncluded' => "Boolean",
		'Community' => "Varchar", //neighbourhood
		'CommunityCode' => "Varchar",
		'CondoCorpNum' => "Varchar",
		'CondoRegistryOffice' => "Varchar",
		'CondoTaxesIncluded' => "Boolean",
		'DirectionsCrossStreets' => "Varchar",
		'Drive' => "Varchar",
		'Elevator' => "Varchar",
		'Exterior' => "Varchar",
		'EnsuiteLaundry' => "Boolean",
		'Exposure' => "Varchar",
		'Extras' => "Varchar",
		'FarmAgriculture' => "Varchar",
		'FireplaceStove' => "Boolean",
		'Fronting' => "Varchar",
		'Furnished' => "Varchar",
		'GarageSpaces' => "Int",
		'GarageType' => "Varchar",
		'HeatIncluded' => "Boolean",
		'HeatSource' => "Varchar",
		'HeatType' => "Varchar",
		'HydroIncluded' => "Boolean",
		'IDXUpdatedDate' => "SS_Datetime",
		'Kitchens' => "Varchar",
		'KitchensPlus' => "Varchar",
		'LaundryAccess' => "Varchar",
		'LaundryLevel' => "Varchar",
		'LeaseTerm' => "Varchar",
		'LegalDescription' => "Varchar",
		'ListBrokerage' => "Varchar",
		'Price' => "Int",
		'Locker' => "Varchar",
		'LockerNum' => "Varchar",
		'LotDepth' => "Decimal(9,2)",
		'LotFront' => "Decimal(9,2)",
		'LotIrregularities' => "Varchar",
		'LotSizeCode' => "Varchar",
		'Maintenance' => "Currency",
		'MapNum' => "Varchar",
		'MapColumnnNum' => "Varchar",
		'MapRow' => "Varchar",
		'MLS' => "Varchar",
		'Municipality' => "Varchar",
		'MunicipalityDistrict' => "Varchar",
		'MunicpCode' => "Varchar",
		'OtherStructures' => "Varchar",
		'OutofAreaMunicipality' => "Varchar",
		'ParkCostMo' => "Currency",
		'ParkingIncluded' => "Boolean",
		'ParkingLegalDescription' => "Varchar",
		'ParkingSpaces' => "Varchar",
		'ParkingSpot1' => "Varchar",
		'ParkingSpot2' => "Varchar",
		'ParkingType' => "Varchar",
		'ParkingType2' => "Varchar",
		'ParkingDrive' => "Varchar",
		'PetsPermitted' => "Varchar",
		'PIN' => "Varchar",
		'PixUpdatedDate' => "SS_Datetime",
		'Pool' => "Varchar",
		'PostalCode' => "Varchar",
		'PrivateEntrance' => "Boolean",
		'PropertyFeatures1' => "Varchar",
		'Province' => "Varchar",
		'RemarksForClients' => "Text",
		'Retirement' => "Boolean",
		'TotalRooms' => "Varchar",
		'RoomsPlus' => "Varchar",
		'SaleLease' => "Varchar",
		'SaleOrRent' => "Varchar", //Keep consistent with Listing
		'SellerPropertyInfoStatement' => "Varchar",
		'Sewers' => "Varchar",
		'SpecialDesignation1' => "Varchar",
		'MLSStatus' => "Varchar",
		'StreetNum' => "Varchar",
		'StreetAbbreviation' => "Varchar",
		'StreetDirection' => "Varchar",
		'StreetName' => "Varchar",
		'Style' => "Varchar",
		'TaxYear' => "Varchar",
		'Taxes' => "Currency",
		'Type' => "Varchar",
		'UFFI' => "Varchar",
		'UnitNum' => "Varchar",
		'UpdatedTimestamp' => "SS_Datetime",
		'UtilitiesCable' => "Boolean",
		'UtilitiesGas' => "Boolean",
		'UtilitiesHydro' => "Boolean",
		'UtilitiesTelephone' => "Boolean",
		'Washrooms' => "Varchar",
		'Water' => "Varchar",
		'WaterIncluded' => "Boolean",
		'WaterSupplyTypes' => "Varchar",
		'Waterfront' => "Varchar",
		'Zoning' => "Varchar",
		'Lat' => 'Varchar',
		'Lon' => 'Varchar',
		'SourceKey' => 'Varchar'
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
	 	
	 	
	 	$fields->makeFieldReadonly('ListingType');
		$fields->makeFieldReadonly('Shares');
		$fields->makeFieldReadonly('Acreage');
		$fields->makeFieldReadonly('AddlMonthlyFees');
		$fields->makeFieldReadonly('Address');
		$fields->makeFieldReadonly('AirConditioning');
		$fields->makeFieldReadonly('AllInclusiveRental');
		$fields->makeFieldReadonly('ApproxAge');
		$fields->makeFieldReadonly('ApproxSquareFootage');
		$fields->makeFieldReadonly('AptUnit');
		$fields->makeFieldReadonly('Area');
		$fields->makeFieldReadonly('Assessment');
		$fields->makeFieldReadonly('AssessmentYear');
		$fields->makeFieldReadonly('Balcony');
		$fields->makeFieldReadonly('Basement');
		$fields->makeFieldReadonly('Bedrooms');
		$fields->makeFieldReadonly('BedroomsPlus');
		$fields->makeFieldReadonly('BuildingAmenities');
		$fields->makeFieldReadonly('BuildingInsuranceIncluded');
		$fields->makeFieldReadonly('CableTVIncluded');
		$fields->makeFieldReadonly('CACIncluded');
		$fields->makeFieldReadonly('CentralVac');
		$fields->makeFieldReadonly('CommonElementsIncluded');
		$fields->makeFieldReadonly('Community'); //neighbourhood
		$fields->makeFieldReadonly('CommunityCode');
		$fields->makeFieldReadonly('CondoCorpNum');
		$fields->makeFieldReadonly('CondoRegistryOffice');
		$fields->makeFieldReadonly('CondoTaxesIncluded');
		$fields->makeFieldReadonly('DirectionsCrossStreets');
		$fields->makeFieldReadonly('Drive');
		$fields->makeFieldReadonly('Elevator');
		$fields->makeFieldReadonly('Exterior');
		$fields->makeFieldReadonly('EnsuiteLaundry');
		$fields->makeFieldReadonly('Exposure');
		$fields->makeFieldReadonly('Extras');
		$fields->makeFieldReadonly('FarmAgriculture');
		$fields->makeFieldReadonly('FireplaceStove');
		$fields->makeFieldReadonly('Fronting');
		$fields->makeFieldReadonly('Furnished');
		$fields->makeFieldReadonly('GarageSpaces');
		$fields->makeFieldReadonly('GarageType');
		$fields->makeFieldReadonly('HeatIncluded');
		$fields->makeFieldReadonly('HeatSource');
		$fields->makeFieldReadonly('HeatType');
		$fields->makeFieldReadonly('HydroIncluded');
		$fields->makeFieldReadonly('IDXUpdatedDate');
		$fields->makeFieldReadonly('Kitchens');
		$fields->makeFieldReadonly('KitchensPlus');
		$fields->makeFieldReadonly('LaundryAccess');
		$fields->makeFieldReadonly('LaundryLevel');
		$fields->makeFieldReadonly('LeaseTerm');
		$fields->makeFieldReadonly('LegalDescription');
		$fields->makeFieldReadonly('ListBrokerage');
		$fields->makeFieldReadonly('Price');
		$fields->makeFieldReadonly('Locker');
		$fields->makeFieldReadonly('LockerNum');
		$fields->makeFieldReadonly('LotDepth');
		$fields->makeFieldReadonly('LotFront');
		$fields->makeFieldReadonly('LotIrregularities');
		$fields->makeFieldReadonly('LotSizeCode');
		$fields->makeFieldReadonly('Maintenance');
		$fields->makeFieldReadonly('MapNum');
		$fields->makeFieldReadonly('MapColumnnNum');
		$fields->makeFieldReadonly('MapRow');
		$fields->makeFieldReadonly('MLS');
		$fields->makeFieldReadonly('Municipality');
		$fields->makeFieldReadonly('MunicipalityDistrict');
		$fields->makeFieldReadonly('MunicpCode');
		$fields->makeFieldReadonly('OtherStructures');
		$fields->makeFieldReadonly('OutofAreaMunicipality');
		$fields->makeFieldReadonly('ParkCostMo');
		$fields->makeFieldReadonly('ParkingIncluded');
		$fields->makeFieldReadonly('ParkingLegalDescription');
		$fields->makeFieldReadonly('ParkingSpaces');
		$fields->makeFieldReadonly('ParkingSpot1');
		$fields->makeFieldReadonly('ParkingSpot2');
		$fields->makeFieldReadonly('ParkingType');
		$fields->makeFieldReadonly('ParkingType2');
		$fields->makeFieldReadonly('ParkingDrive');
		$fields->makeFieldReadonly('PetsPermitted');
		$fields->makeFieldReadonly('PIN');
		$fields->makeFieldReadonly('PixUpdatedDate');
		$fields->makeFieldReadonly('Pool');
		$fields->makeFieldReadonly('PostalCode');
		$fields->makeFieldReadonly('PrivateEntrance');
		$fields->makeFieldReadonly('PropertyFeatures1');
		$fields->makeFieldReadonly('Province');
		$fields->makeFieldReadonly('RemarksForClients');
		$fields->makeFieldReadonly('Retirement');
		$fields->makeFieldReadonly('TotalRooms');
		$fields->makeFieldReadonly('RoomsPlus');
		$fields->makeFieldReadonly('SaleLease');
		$fields->makeFieldReadonly('SaleOrRent');
		$fields->makeFieldReadonly('SellerPropertyInfoStatement');
		$fields->makeFieldReadonly('Sewers');
		$fields->makeFieldReadonly('SpecialDesignation1');
		$fields->makeFieldReadonly('MLSStatus');
		$fields->makeFieldReadonly('StreetNum');
		$fields->makeFieldReadonly('StreetAbbreviation');
		$fields->makeFieldReadonly('StreetDirection');
		$fields->makeFieldReadonly('StreetName');
		$fields->makeFieldReadonly('Style');
		$fields->makeFieldReadonly('TaxYear');
		$fields->makeFieldReadonly('Taxes');
		$fields->makeFieldReadonly('Type');
		$fields->makeFieldReadonly('UFFI');
		$fields->makeFieldReadonly('UnitNum');
		$fields->makeFieldReadonly('UpdatedTimestamp');
		$fields->makeFieldReadonly('UtilitiesCable');
		$fields->makeFieldReadonly('UtilitiesGas');
		$fields->makeFieldReadonly('UtilitiesHydro');
		$fields->makeFieldReadonly('UtilitiesTelephone');
		$fields->makeFieldReadonly('Washrooms');
		$fields->makeFieldReadonly('Water');
		$fields->makeFieldReadonly('WaterIncluded');
		$fields->makeFieldReadonly('WaterSupplyTypes');
		$fields->makeFieldReadonly('Waterfront');
		$fields->makeFieldReadonly('Zoning');
		
		 	
	 	$gridFieldConfig = GridFieldConfig_RelationEditor::create();
	 	$gridFieldConfig->addComponent(
	 		new GridFieldDeleteAction()
	 	);
	 	$gridField = new GridField('Images', 'Linked images', $this->Images(), $gridFieldConfig);
	 	
	 	$fields->insertBefore ( HeaderField::create('AddressHead','Address Info',2), 'ListingType' );
	 	if($this->CityID) {
		 	$fields->insertAfter(DropdownField::create('NeighbourhoodID', "Neighbourhood", NeighbourhoodPage::get()->filter(array('ParentID' => $this->CityID))->map("ID", "Title"))->setEmptyString('(Select one)'), "IsFeatured");
	 	}
	 	
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
				
				$this->URLSegment = $filter->filter($this->Address.(!empty($this->UnitNum) ? " ".$this->UnitNum : '')." ". $this->Municipality." ".$this->PostalCode." ".$this->MLS);
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
		return $this->LotDepth != "0.00" ? floor($this->LotDepth) : false;
	}
	
	public function LotWidth() {
		return $this->LotFront != "0.00" ? floor($this->LotFront) : false;
	}
	
	public function LotAcreage() {
		return !$this->Acreage ? $this->Acreage : false;
	}
	
	//TODO ADD TO DOC
	
	public function Garage() {
		return !$this->GarageType ? $this->GarageType : false;
	}
	
	public function DriveWay() {
		return !$this->Drive ? $this->Drive : false;
	}
	
	public function AC() {
		return !$this->AirConditioning ? $this->AirConditioning : false;
	}
	
	public function Heat() {
		return !$this->HeatType ? $this->HeatType : false;
	}
	
	public function Construction() {
		return !$this->Exterior ? $this->Exterior : false;
	}
	
	public function Age() {
		return !$this->ApproxAge ? $this->ApproxAge : false;
	}
	
	public function Sewer() {
		return !$this->Sewers ? $this->Sewers : false;
	}
	
	public function TotalRooms() {
		return !$this->NumberRooms ? $this->NumberRooms.(!$this->RoomsPlus ? '+'.$this->RoomsPlus : '') : false;
	}
	
	public function TotalArea() {
		return !$this->ApproxSquareFootage ? $this->ApproxSquareFootage : false;
	}
	
	
	// END TO DO
	
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
	
	public function CoverImage() {
		return $this->Images()->First() ? $this->Images()->First() : false;
	}
	
	function getFrontCover() {
		if($this->Images()->exists()) return $this->Images()->First()->SetWidth(100); 
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
	
	public function Town() {
		return ($this->CityID != 0) ? $this->City()->Title : $this->Municipality;
	}
	
	public function OrderedImages() {
		return $this->Images()->count() ? $this->Images() : false;
	}
	
	public function SiteConfig() {
		return SiteConfig::current_site_config();
	}
	
	
	function RelatedProperties($count = 4) {
	 	$siteConfig = SiteConfig::current_site_config();
	 	
	 	if($siteConfig->RelatedPriceRange != 0) {
		 	$varience = $siteConfig->RelatedPriceRange;
	 	} else {
		 	$varience = 50000;
	 	}
	 	
	 	$items = new ArrayList();
	 	
	 	$ownItems = Listing::get()->filter(array(
 			"CityID" => $this->CityID,
 			"Status" => "Available",
 			"Price:LessThan" => $this->Price + 50000,
 			"Price:GreaterThan" => $this->Price - 50000
 		))->limit($count);
	 	
	 	if($ownItems && $ownItems->count()) {
		 	$items->merge($ownItems);
	 	}
	 	
	 	$mlsItems = MLSListing::get()->filter(array(
 			"CityID" => $this->CityID,
 			"IsFeatured" => 1,
 			"Price:LessThan" => $this->Price + 50000,
 			"Price:GreaterThan" => $this->Price - 50000
 		))->exclude("ID", $this->ID)->limit($count);
	 	
	 	if($mlsItems && $mlsItems->count()) {
		 	$items->merge($mlsItems);
	 	}
	 	
	 	if($items->count()) {
	 		return $items->limit($count);
	 	} else {
	 		return false;
	 	}
	 	
	 }
	 
	 public function ListingRequestForm() {
		return new ListingRequestForm($this, 'ListingRequestForm');
	}
	
	public function DownPayment() {
		return ceil($this->Price*0.2);
	}
	
	public function getSummary() {
		return $this->obj('Content')->Summary(20)."...";
	}
	
	
	
	
	/**
	 * Object methods
	 * ----------------------------------*/
	
}