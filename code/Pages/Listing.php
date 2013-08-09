<?php
/**
 * 	
 * @package Realestate Listing System - Property Listing DataObject 
 * @requires DataObjectAsPage, Mappable, DataObjectManager
 * @author Richard Rudy twitter:thezenmonkey web: http://designplusawesome.com
 */
 
 
class Listing extends Page {
	/**
	 * Static vars
	 * ----------------------------------*/
	
	
	private static $can_be_root = false;
	
	//static $defaults;	


	/**
	 * Object vars
	 * ----------------------------------*/




	/**
	 * Data model
	 * ----------------------------------*/
	
	private static $db = array(
		//basic sale data
		'Status' => "Enum('Available,Sold,Unavailable')",
		'Feature' => 'Boolean',
		'IsNew' => 'Boolean',
		'MLS' => "Varchar(100)",
		'Type' => "Enum('House,Condo,Commercial,Agriculture,Semi-Detached,Townhouse,Cottage,Link,Farm,Live/Work,Vacant Land')",
		'SaleOrRent' => "Enum('Sale,Lease')",
		//basic address data
		'Address' => 'Varchar',
		'Unit' => 'Varchar',
		'Town' => 'Varchar',
		'PostalCode' => 'Varchar(7)',
		'Street' => 'Varchar',
		//basic home details
		'TotalArea' => 'Text',
		'NumberBed' => 'Varchar',
		'NumberBath' => 'Varchar',
		'NumberRooms' => 'Varchar',
		//baisc financial data
		'Price' => 'Int',
		'Taxes' => 'Varchar',
		'TaxYear' => 'Int',
		'HideMonthly' => 'Boolean',
		//lot size
		'LotLength' => 'Varchar',
		'LotWidth' => 'Varchar',
		'LotAcreage' => 'Varchar',
		'Irregular' => 'Boolean',
		
		'Headline' => 'Text',
		'Summary' => 'HTMLText',
		
		//mapping data
		'Lat' => 'Varchar',
		'Lon' => 'Varchar',
		'SVHeading' => 'Varchar(25)',
		'SVPitch' => 'Varchar(25)',
		'SVZoom' => 'Varchar(25)',
		//open house data
		'OpenHouseDate' => 'Date',
		'OpenHouseStart' => 'Time',
		'OpenHouseEnd' => 'Time',
		//feature sheet data
		'AdditionalMLS' => "Varchar(100)",
		'KeyPoints' => "HTMLText",
		'Vendors' => "Varchar(100)",
		'Possession' => 'Varchar',
		'Lockbox' => 'Boolean',
		'Fireplaces' => 'Varchar',
		'Garage' => 'Varchar',
		'Driveway' => 'Varchar',
		'District' => 'Varchar',
		'Occupied' => "Enum('Owner,Tenant,Not Occupied')",
		'AC' => 'Boolean',
		'Heat' => 'Varchar',
		'Basement' => 'Varchar',
		'Construction'  => 'Varchar',
		'Topography' => 'Varchar',
		'Age' => 'Varchar',
		'Water' => "Enum('Municipal,Well')",
		'Sewer' => 'Boolean',
		'Restrictions' => 'Varchar',
		'Zoning' => "Enum('Residential,Commerical,Mixed,Agricultural')",
		'LegalDesc' => 'Varchar',
		'Deposit' => 'Varchar(100)',
		'SideOfRoad' => "Enum('North,North East,East, South East, South, South West ,West, North West')",
		'ListingDate' => 'Date',
		'Mortgage' => 'Varchar(100)',
		
		//Extra Features
		'VideoURL' => 'HTMLVarchar(255)',
		
		//onbeforewritehack
		'CityIDHolder' => 'Varchar(100)'
		
	);
	
	private static $has_one = array(
		'Neighbourhood' => 'Neighbourhood',
		'FeatureSheet' => 'File',
		'Folder' => 'Folder',
		'City' => 'City',
	);
	
	
	private static $has_many = array(
		'Rooms' => 'Room',
		"OpenHouseDates" => "OpenHouseDate",
		
	);
	
	private static $many_many = array(
		'Schools' => 'NeighbourhoodFeature'
	);
	
	private static $searchable_fields = array(
		'Address',
		'MLS'
	);
	
	private static $summary_fields = array(
		'Address',
		'Municipality',
		'MLS',
		'Type',
		'Feature',
		//'Sold',
		//'City'
	);
	
	//private static $default_sort = "Street ASC";
	



	/**
	 * Common methods
	 * ----------------------------------*/
	 	 
	 public function getCMSFields() {
	 	$fields = parent::getCMSFields();
	 	
	 	$siteConfig = SiteConfig::current_site_config();
	 	
	 	Requirements::javascript("RealEstate/javascript/cmsmap.js");
	 	Requirements::css("RealEstate/css/realestatecms.css");
	 	
	 	
	 	$fields->removeFieldsFromTab('Root.Main', array(
		 	'URLSegment',
		 	'Title',
			'MenuTitle',
			'FeatureBlock',
			'Street'
	 	));
	 	
	 	//DataLists for Dropdown Maps
	 	$cities = City::get();
	 	
	 	//Create Composite Fields
	 	
	 	$statusField = ToggleCompositeField::create(
	 		"StatusGroup",
	 		"Status",
	 		array(
	 			DropdownField::create("Status", "Status", singleton('Listing')->dbObject('Status')->enumValues()),
	 			CheckboxField::create("Feature"),
	 			CheckboxField::create("IsNew"),
	 			TextField::create("MLS", "MLS Number"),
	 			DropdownField::create("SaleOrRent", "Sale Or Rent", array("Sale" => "Sale", "Lease" => "Lease")),
	 		)
	 	);
	 	
	 	/**
	 	 *  Check if Multiple Cities or Default City is Set and configure Dropdown Accordingly
	 	 */
	 	
	 	if ($cities->count() == 1) {
		 	$cityField = DropdownField::create('CityID', 'City', City::get()->map('ID', 'Title'))->setEmptyString('(Select one or Add Town)')->setHasEmptyDefault(false);
	 	} elseif ($cities->count() > 1 && $siteConfig->DefaultCityID != 0) {
		 	$cityField = DropdownField::create('CityID', 'City', City::get()->map('ID', 'Title'), $siteConfig->DefaultCityID)->setEmptyString('(Select one or Add Town)')->setHasEmptyDefault(false);
	 	} else {
		 	$cityField = DropdownField::create('CityID', 'City', City::get()->map('ID', 'Title'))->setEmptyString('(Select one or Add Town)');
	 	}
	 	
	 	$addressField = CompositeField::create(
	 		
	 		array (
	 			HeaderField::create("Address",2),
	 			TextField::create("Address")->addExtraClass('stacked'),
	 			TextField::create("Unit")->addExtraClass('stacked'),
	 			CompositeField::create(
	 				$cityField->addExtraClass('stacked leftcol'),
	 				Textfield::create("Town")->setDescription('Use ONLY for Smaller Communities Outside Target Markets')->addExtraClass('stacked rightcol')
	 			)->addExtraClass('clearfix'),
	 			
	 			TextField::create("PostalCode", "Postal Code")->addExtraClass('stacked')
	 		)
	 	)->addExtraClass("addDeets");
	 	
	 	$detailField = CompositeField::create(
	 		array (
	 			HeaderField::create("Property Details",2),
	 			
	 			DropdownField::create('Type','Type',singleton('Listing')->dbObject('Type')->enumValues())->addExtraClass('stacked'),
	 			TextField::create("TotalArea", "Total Approximate Area")->addExtraClass('stacked'),
	 			CompositeField::create(
	 				TextField::create("NumberBed", "# Bedrooms")->addExtraClass('stacked oneThird'),
	 				TextField::create("NumberBath", "# Bathrooms")->addExtraClass('stacked oneThird'),
	 				TextField::create("NumberRooms", "# Rooms")->addExtraClass('stacked oneThird')
	 			)->addExtraClass('clearfix'),
	 			CompositeField::create(
	 				TextField::create("LotWidth", "Lot Width")->addExtraClass('stacked oneThird'),
	 				TextField::create("LotLength", "Lot Depth")->addExtraClass('stacked oneThird'),
	 				TextField::create("LotAcreage", "Acreage")->addExtraClass('stacked oneThird')
	 			)->addExtraClass('clearfix'),
	 			
	 			
	 			CheckboxField::create("Irregular", "Irregular Lot"),
	 		)
	 	)->addExtraClass("propDeets");
	 	
	 	$financeDetails = CompositeField::create(
	 		array (
	 			HeaderField::create("Financial",2),
	 			NumericField::create("Price")->addExtraClass('stacked'),
	 			NumericField::create("Taxes")->addExtraClass('stacked'),
	 			TextField::create("TaxYear", "Tax Assessment Year")->addExtraClass('stacked'),
	 			CheckboxField::create("HideMonthly", "Hide Monthly Price"),
	 		)
	 	)->addExtraClass("finDeets");
	 	

	 	
	 	
	 	
	 	//open collapsed fields on new listigs
	 	if($this->ID == 0){
		 	$statusField->setStartClosed(false);
	 	}
	 	
	 	$fields->insertBefore($statusField, "Content");
	 	$fields->insertBefore(
	 		CompositeField::create(
	 			$addressField,
	 			$detailField,
	 			$financeDetails
	 		)->addExtraClass('clearfix rmsListDetails'),
	 		"Content"
	 	);
	 	
	 	$fields->insertBefore( new HeaderField('ContentHead','Content',2), 'Content' );
	 	
	 	$fields->insertBefore(
	 		CompositeField::create(
	 			TextField::create('Headline')->addExtraClass('stacked'),
	 			HTMLEditorField::create('Summary')->addExtraClass('stacked')
	 		)->addExtraClass('clearfix rmsListDetails'),
	 		"Content"
	 	);
	 	
        $fields->addFieldToTab ("Root.Main", new HiddenField('CityIDHolder'), 'Summary' );
		
		if($this->ID == 0 ) {
			$mainListingsPage = SiteTree::get_by_link("listings");
			$fields->addFieldToTab("Root.Main", new HiddenField("ParentID", "Parent", $mainListingsPage->ID));
		}
		
		if ($this->ID != 0){
		
			
			
			
			
			$neighbourhoodList = Neighbourhood::get()->filter(array("CityID" => $this->CityID))->sort('Name')->map('ID', 'Name');
			if($neighbourhoodList->count() >= 1) {
				$neighbourhoodField = new DropdownField('NeighbourhoodID', 'Neighbourhood', $neighbourhoodList);
				$neighbourhoodField->setEmptyString('(Select one)');
				$fields->insertAfter( $neighbourhoodField , 'AddressHead');
			}
			
			
			$galleryField = GalleryUploadField::create('Images', 'Images')
				->setFolderName("/Homes/".$this->Folder()->Name)
				->addExtraClass('stacked');
			
			//$fields->addFieldToTab("Root.PictureAndResources", new LiteralField('showFolderName','<span>'.$this->Folder()->FileName.'</span>'));
			$featuresheetField = new UploadField('FeatureSheet');
			$featuresheetField->setFolderName("/Homes/".$this->Folder()->Name);
		 	
		 	$fields->addFieldsToTab("Root.PictureAndResources", array(
		 		CompositeField::create(
		 			CompositeField::create(
			 			$featuresheetField->addExtraClass('stacked'),
			 			TextField::create('VideoURL', "Video Embed Code")->addExtraClass('stacked')
		 			)->addExtraClass('leftcol'),
		 			CompositeField::create( 
		 				$galleryField
		 			)->addExtraClass('rightcol')
		 		)->addExtraClass('clearfix'),
		 		
		 	));
		 	
		 	/*
$schoolManagerConfig = GridFieldConfig::create();
		 	$schoolManagerConfig->addComponents(
				new GridFieldManyRelationHandler(true),
				new GridFieldToolbarHeader(),
				new GridFieldSortableHeader(),
				new GridFieldDataColumns(),
				new GridFieldPaginator(20),
				new GridFieldEditButton(),
				new GridFieldDeleteAction(),
				new GridFieldDetailForm(),
				'GridFieldPaginator'
		 	);
		 	$schoolManager = new GridField(
		 		"Schools", "Schools",
		 		$this->Schools()->filter(array(
		 			"CityID" => $this->CityID,
		 			"Type" => array('Elementary School','Middle School','Secondary School','RC Elementary School','RC Middle School','RC Secondary School'),
		 		))->sort("Name"), 
		 		$schoolManagerConfig
		 	);
		 	$fields->addFieldToTab('Root.Schools', $schoolManager);
*/
		 	
		 	
		 	$openHouseManager = new GridField(
		 		"OpenHouseDates",
		 		"Open House Dates",
		 		$this->OpenHouseDates(),
		 		GridFieldConfig_RelationEditor::create()
		 	);
		 	$fields->addFieldToTab('Root.OpenHouse', $openHouseManager);
		 	
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('AdditionalMLS', 'Additional MLS Number'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Vendors'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Possession'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new CheckboxField('Lockbox', 'Lockbox'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Fireplaces'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Garage'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Driveway'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('District'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new DropdownField('Occupied','Occupied',singleton('Listing')->dbObject('Occupied')->enumValues()));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new CheckboxField('AC', 'Air Conditioning'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Heat'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Basement'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Construction'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Topography'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Age'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new DropdownField('Water','Water',singleton('Listing')->dbObject('Water')->enumValues()));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new CheckboxField('Sewer'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Restrictions'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new DropdownField('Zoning','Zoning',singleton('Listing')->dbObject('Zoning')->enumValues()));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('LegalDesc', 'Legal Description'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Deposit'));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new DropdownField('SideOfRoad','Side Of Road',singleton('Listing')->dbObject('SideOfRoad')->enumValues()));
		 	$fields->addFieldToTab('Root.FeatureSheetData', new TextField('Mortgage'));
		 	
		 	$roomManagerConfig = GridFieldConfig_RelationEditor::create();
		 	$roomManagerConfig->addComponents(
		 		new GridFieldDetailForm('Room')
		 	);
		 	$roomManager = new GridField(
		 		"Rooms", "Rooms",
		 		$this->Rooms(), 
		 		$roomManagerConfig
		 	);
		 	$fields->addFieldToTab('Root.FeatureSheetData', $roomManager);
		 	
		 	//mapping system
		 	
		 	$fields->addFieldToTab("Root.Maps", new TextField('Lat', 'Latitude'));
			$fields->addFieldToTab("Root.Maps", new HiddenField('NewLat'));
			$fields->addFieldToTab("Root.Maps", new TextField('Lon', 'Longitude'));
			$fields->addFieldToTab("Root.Maps", new HiddenField('NewLon'));
			$fields->addFieldToTab("Root.Maps", new TextField('SVHeading', 'Street View Heading'));
			$fields->addFieldToTab("Root.Maps", new HiddenField('NewSVHeading'));
			$fields->addFieldToTab("Root.Maps", new TextField('SVPitch', 'Street View Pitch'));
			$fields->addFieldToTab("Root.Maps", new HiddenField('NewSVHeading'));
			$fields->addFieldToTab("Root.Maps", new TextField('SVZoom', 'Street View Zoom'));
			$fields->addFieldToTab("Root.Maps", new HiddenField('NewSVZoom'));
			
			$mapContent = "<div class='clearfix'><div class='clearfix'><button value='Show Map' class='action action ss-ui-button ui-corner-all ui-button ui-widget ui-state-default ui-button-text-icon-primary ui-state-hover ui-state-active' id='ShowMap' role='button' aria-disabled='false'><span class='ui-button-text'>Show Map</span></button><button style='display:none;' value='Set Street View' class='action action ss-ui-action-constructive ss-ui-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-state-hover ui-state-active' id='StreetViewSet' role='button' aria-disabled='false'><span class='ui-button-text'>Set Street View</span></button></div><div style='height:500px; width:50%; float:left;' id='GoogleMap' data-position='".$this->Lat.",".$this->Lon."' ></div><div style='height:500px; width:50%; float:left;' id='StreetView' data-lat='".$this->Lat."' data-lon='".$this->Lon."'></div></div>";
			
			$fields->addFieldToTab("Root.Maps", new LiteralField(
				$name = "googlemapfield",
				$content = $mapContent
			));
		 	
		 	
		}
		
	 	return $fields;
	 	
	 }
	 
	 	 
	 
	function onBeforeWrite() {
		if ( is_null($this->Lat) || is_null($this->Lon) ) {
		
			$LatLon = Geocoder::Geocode($this->Address." ".($this->Town ? $this->Town : $this->City()->Title).", Ontario ".$this->PostalCode);
			
			if($LatLon) {
				
				$this->Lat = $LatLon["Lat"];
				$this->Lon = $LatLon["Lon"];
			}
			
			
		}
		
		
		if(!$this->ID || $this->FolderID == 0) {
			/**
			* Find or Create Folder under assets/Homes named $address-$city 
			* Finds and attached the FolderID after its created
			*/
			$filter = URLSegmentFilter::create();
			$folderName = $filter->filter($this->Address." ".($this->Town ? $this->Town : $this->City()->Title));
			$folderExists = Folder::find_or_make('Homes/'.$folderName.'/');
			$this->FolderID = $folderExists->ID;
		}
		
		
		$URLFilter = URLSegmentFilter::create();
		
		if($this->isChanged("Status") || $this->isChanged("Unit") || $this->isChanged("CityID") || $this->isChanged("Town") || $this->isChanged("Address") || !$this->ID == 0 ) {
			
			$this->Street = trim(str_replace(range(0,9),'', $this->Address));
			
			if($this->Status == "Available") {
				//$this->URLSegment = $URLFilter->filter($this->Address." ".(!empty($this->Unit) ? $this->Unit." ").$this->City()->Title);
				if ($this->Unit) {
					$this->URLSegment = $URLFilter->filter($this->Address." Unit ".$this->Unit." ".($this->Town ? $this->Town : $this->City()->Title));
					$this->MetaTitle = $this->Address." Unit ".$this->Unit." ". ($this->Town ? $this->Town : $this->City()->Title)." MLS ".$this->MLS;
					$this->Title = $this->Address." Unit ".$this->Unit." ". ($this->Town ? $this->Town : $this->City()->Title);
				} else {
					$this->URLSegment = $URLFilter->filter($this->Address." ".($this->Town ? $this->Town : $this->City()->Title));
					$this->MetaTitle = $this->Address." ". ($this->Town ? $this->Town : $this->City()->Title)." MLS ".$this->MLS;
					$this->Title = $this->Address." ". ($this->Town ? $this->Town : $this->City()->Title);
				}
				if (!$this->MetaDescription) {
					$this->MetaDescription = $this->Title." | ".strip_tags($this->Summary);
				}
				
			} else {
				$this->URLSegment = $URLFilter->filter($this->MLS." ".($this->Town ? $this->Town : $this->City()->Title));
				$this->MetaTitle = $this->MLS." ". ($this->Town ? $this->Town : $this->City()->Title);
				$this->Title = $this->MLS." ". ($this->Town ? $this->Town : $this->City()->Title);
				$this->MetaDescription = $this->Title." sold by the Dan Cooper Group";
			}	
			
		}
		
		
		
		
		
		
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
	
	function onBeforeDelete() {
	
		if($this->FolderID != 0 && !$this->isPublished()){
			$folder = Folder::get()->byID($this->FolderID);
			
			if($folder) {
				$folder->delete();	
			}
		}
		parent::onBeforeDelete();
	}

	
	/*
function onAfterWrite() {
		
		if($this->GalleryID != 0) {
			$gallery = Gallery::get()->byID($this->GalleryID);
			$gallery->PageID = $this->ID;
			$gallery->write();
		}
		
		parent::onAfterWrite();
	}
*/


	/**
	 * Accessor methods
	 * ----------------------------------*/
	
	public function getCity(){
		return $this->City()->Title;
	}
	
	
	
public function Images() {
		return $this->getManyManyComponents(
			'Images',
			'',
			"\"Page_Images\".\"SortOrder\" ASC"
		);
	}
	
	public function ImagesCaptions() {
		$captions = Page_Images::get()
			->where("\"PageID\" = '{$this->ID}'")
			->map('ImageID', 'Caption')
			->toArray();
	}

	 


	/**
	 * Controller actions
	 * ----------------------------------*/
	 


	/**
	 * Template accessors
	 * ----------------------------------*/

	/**
	 *Return Money Formated Values for Price 
	 *
	 * @return Formated Price
	 */
	 
	 public function AbsoluteURLEncoded() {
	 	return urlencode($this->BaseHref().$this->URLSegment);
	 }
	
	public function FormattedPrice() {
		setlocale(LC_MONETARY, 'en_CA');
		if($this->Price){
			return money_format('%.0n', $this->Price);
		} else {
			return false;
		}
	}
	
	public function GroupedSchools(){
		if($this->Schools()->count()){
			return GroupedList::create($this->Schools()->sort("Type"));
		} else {
			return false;
		}
		
		
	}
	
	
	
	/**
	 *function to Populate a Feature Image set to metered out in various points in the template 
	 * 
	 * @return DataObject set into $featureImage
	 */
	
	
	protected $featureImageCache = null;
	protected $featureImageFlag = "new";
	
	public function FeatureImages($operation, $number) {
		if (empty($this->featureImageCache) && $this->featureImageFlag == "new"){
			$this->featureImageCache = new ArrayList();
			foreach($this->Images()->where("Feature = 1")->sort("SortOrder") as $img) $this->featureImageCache->push($img);
			$this->featureImageFlag = "old";
		} elseif (!$this->featureImageCache->count() && $this->featureImageFlag == "old"){
			return false;
		}
		if($operation == "check" && $this->featureImageCache->count() >= $number) {
			return true;
		} elseif ($operation == "get") {
			$requested = new ArrayList();
			foreach($this->featureImageCache->limit($number) as $img) $requested->push($img);
			foreach($requested as $request) $this->featureImageCache->remove($request);
			return $requested;
		} else {
			return false;
		}
		
	}
		
	//checks if Pased Item is with 15 miles of this DataObject
	public function getDistance($lat,$lon) {
		return ( 3959 * acos( cos( deg2rad($lat) ) * cos( deg2rad( $this->Lat ) ) * cos( deg2rad($this->Lon ) - deg2rad($lon) ) + sin( deg2rad($lat) ) * sin( deg2rad( $this->Lat ) ) ) );
	}
	
	/**
	 *Return Money Formated Values for Taxes 
	 *
	 * @return Formated Taxes
	 */
	
	public function FormattedTaxes() {
		if($this->Taxes){
			setlocale(LC_MONETARY, 'en_CA');
			return money_format('%.0n', $this->Taxes);
		} else {
			return false;
		}
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
	
	/**
	 *Check if there is an open house and if it is the future 
	 *
	 * @return Formated Taxes
	 */
	 
	 public function GetCover() {
	 	return $this->Images()->where("Cover = 1")->First();
	 }
	
	 
	 function ContactForm() {
	 	  return new ListingRequestForm($this, 'RequestForm');
	 }
	 
	 function RelatedProperties() {
	 	$method = $_GET["method"];
	 	$value = $_GET["value"];
	 	if($method == "price") {
	 		$items = Listing::get()->filter(array(
	 			"CityID" => $this->CityID,
	 			"Sold" => 0,
	 			"Price:LessThan" => $value + 50000,
	 			"Price:GreaterThan" => $value - 50000
	 		))->limit(5);
	 	} elseif ($method == "neighbourhood") {
	 		if($this->NeighbourhoodID != 0) {
		 		$items = Listing::get()->filter(array("NeighbourhoodID" => $this->NeighbourhoodID, "Sold" => 0))->limit(5);
	 		} else {
		 		$items = Listing::get()->filter(array("CityID" => $this->CityID, "Sold" => 0))->limit(5);
	 		}
	 	} else {
		 	$items = Listing::get()->filter(array("CityID" => $this->CityID, "Sold" => 0))->limit(5);
	 	}
	 	if($items) {
	 		return $items;
	 	} else {
	 		return false;
	 	}
	 	
	 }
	 
	 //cache key for listing
	 
	 function ListingCacheKey() {
		 return implode('_', array(
		 $this->URLSegment,
	        $this->LasteEdited,
	        $this->RelationshipAggregate('Schools')->Max('LastEdited'),
	        $this->RelationshipAggregate('Images')->Max('LastEdited'),
	        $this->Neighbourhood()->LastEdited,
	        $this->RelationshipAggregate('Rooms')->Max('LastEdited'),
	        $this->FeatureSheet()->LastEdited
	    ));
	 }
	 
	
	
	public function MonthlyPrice(){
		$siteConfig = SiteConfig::current_site_config();
		
		if($this->Price){
			$borrowed = $this->Price - ceil($this->Price*($siteConfig->DownPayment/100));
			$int = ($siteConfig->InterestRate/100)/12;
			$term = 360;
			setlocale(LC_MONETARY, 'en_CA');
			return money_format('%.0n',floor((($borrowed*$int)/(1-pow(1+$int, (-1*$term)))*100)/100));
		} else {
			return false;
		}
	}
	
	public function DownPayment() {
		$siteConfig = SiteConfig::current_site_config();
		return ceil($this->Price*($siteConfig->DownPayment/100));
	}
	
	function ShowListingsPage() {
		return ListingsPage::get()->where("City = ".$this->CityID)->count() ? ListingsPage::get()->where("City = ".$this->CityID)->First() : false;
	}
	
	public function UpcomingOpenHouse() {
		if($this->OpenHouseDates()->count()) {
			$set = new ArrayList();
			foreach($this->OpenHouseDates() as $openHouse) {
				strtotime($openHouse->OpenHouseDate) >= strtotime("today") ? $set->push($openHouse) : false;
				//date(strtotime($openHouse->OpenHouseDate)) >= time() ? $set->push($openHouse) : false; 
			}
			
			if($set->count()){
				//Debug::show($set);
				return $set;
				
			} else {
				return false;
			}
			
		} else {
			return false;
		}
	}
	
	
	public function NextOpenHouse() {
		if($this->OpenHouseDates()->count()) { 
			$openHouse = $this->OpenHouseDates()->filter(array ("OpenHouseDate:GreaterThan" => strtotime('Today'), "OpenHouseDate:LessThan" => strtotime("1 week")))->First();
			if($openHouse) {
				$date = new DateTime($openHouse->OpenHouseDate);
				$startTime = new DateTime($openHouse->OpenHouseStart);
				$endTime = new DateTime($openHouse->OpenHouseEnd);
				return "Open House ".$date->format('l')." ".$startTime->format('ga')."-".$endTime->format('ga');
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function GetOpenHouseThisWeekend() {
		if($this->OpenHouseDates()->count()) {
			
			$set = new ArrayList();
			foreach($this->OpenHouseDates() as $openHouse) {
				strtotime($openHouse->OpenHouseDate) == strtotime('this Saturday') || strtotime($openHouse->OpenHouseDate) == strtotime('this Sunday') ? $set->push($openHouse) : false;
				
			}
			
			if($set->count() == 2){
				$weekendSet;
				if($set->First()->OpenHouseStart == $set->offsetGet(1)->OpenHouseStart && $set->First()->OpenHouseEnd == $set->offsetGet(1)->OpenHouseEnd){
					$weekendSet = new ArrayData(array(
						"OpenHouse" => "Saturday and Sunday",
						"GetOpenHouseTime" => date('ga', strtotime($set->First()->OpenHouseStart)) ."-".date('ga', strtotime($set->First()->OpenHouseEnd))
					));
				} else {
					
					
					$weekendSet = new ArrayList();
					foreach($set as $day){
						$weekendSet->push(new ArrayData(array(
							"OpenHouse" => "Saturday",
							"GetOpenHouseTime" => date('ga', strtotime($set->First()->OpenHouseStart)) ."-".date('ga', strtotime($set->First()->OpenHouseEnd))
						)));
					}
				}
				
				return $weekendSet;
				
				
			} elseif($set->count() == 1) {
				return $set;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
		
	}
	
	public function getMunicipality() {
		return $this->Town ? $this->Town : $this->City()->Title;
	}

	 

	


	/**
	 * Object methods
	 * ----------------------------------*/
	
	 
	 

}


class Listing_Controller extends Page_Controller {

	public function index() { 
	if ($this->Status == "Unavailable") { 
		return $this->renderWith(array('SoldListing','Page')); 
	} 
		else return $this->renderWith(array('Listing','Page')); 
	
	}	
	
	
	public function ListingRequestForm() {
		return new ListingRequestForm($this, 'ListingRequestForm');
	}
	
	
	
	function RelatedProperties() {
	 	$method = $_GET["method"];
	 	$value = $_GET["value"];
	 	$set = new ArrayList();
	 	if($method == "price") {
	 		$filter = array(
	 			"Price:LessThan" => $value + 50000,
	 			"Price:GreaterThan" => $value - 50000,
	 			"CityID" => $this->CityID,
	 			"Sold" => 0
	 		);
	 		foreach(Listing::get()->filter($filter)->exclude('ID', $this->ID)->limit(4) as $obj) $set->push($obj);
	 	} elseif ($method == "neighbourhood") {
	 		$filter = array(
	 			"CityID" => $this->CityID,
	 			"Sold" => 0
	 		);
	 		$items = Listing::get()->filter($filter)->exclude('ID', $this->ID);
	 		if($items->count()){
		 		foreach($items as $item) {
			 		$this->getDistance($item->Lat, $item->Lon) <= 15 ? $set->push($item) : false;
		 		}
		 		$set->count() && $set->count() > 4 ? $set = $set->limit(4) : false;
	 		}
	 		
	 	}
	 	
	 	
	 	if(!$set->count() || $set->count() < 4) {
		 	$limit = 4 - $set->count();
		 	if($method == "price") {
		 		$filter = array(
		 			"ListPrice:LessThan" => $value + 50000,
		 			"ListPrice:GreaterThan" => $value - 50000,
		 			"CityID" => $this->CityID
		 		);
		 		foreach(MLSListing::get()->filter($filter)->limit($limit) as $obj) $set->push($obj);
		 	} elseif ($method == "neighbourhood") {
		 		$newSet = new ArrayList();
		 		$filter = array(
		 			"CityID" => $this->CityID
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
	
}