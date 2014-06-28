<?php
/**
 * 	
 * @package Realestate Listing System - Property Listing DataObject 
 * @requires DataObjectAsPage, Mappable, DataObjectManager
 * @author Richard Rudy twitter:thezenmonkey web: http://designplusawesome.com
 */
 
 
class Listing extends Page implements HiddenClass {
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
		'Status' => "Enum('Available,Sold,Closed,Unavailable')", //Listing Availabilty (see onBeforeWrite)
		'Feature' => 'Boolean', //Flag to define if the listing is considerd a "Feature Listing"
		'IsNew' => 'Boolean', //Flag to define if a listing is considerd New
		'MLS' => "Varchar(100)", //MLS number for primary board (see AddiionalMLS)
		'ListingType' => "Enum('Residential,Condo,Commercial')", //Type of property based of TREB IDX classification
		'SaleOrRent' => "Enum('Sale,Lease')", //If listing is classified as a For Sale or For Rent
		//basic address data
		'Address' => 'Varchar', //Street Address
		'Unit' => 'Varchar', //Optional Unit Number
		'Town' => 'Varchar', //Stores City/Town for properties outside of key market
		'PostalCode' => 'Varchar(7)', //Zip or POstal Code
		'Street' => 'Varchar', //Generated Value strips building number off address (used for sorting)
		//basic home details
		'TotalArea' => 'Text', //Square footage/meters of home
		'NumberBed' => 'Varchar', //Number of Bedrooms
		'NumberBath' => 'Varchar', //Number of Bathrooms
		'NumberRooms' => 'Varchar', //Total Number of Rooms
		//baisc financial data
		'Price' => 'Int', //Listing Price
		'Taxes' => 'Varchar', //Assessed Property Tax
		'TaxYear' => 'Int',  //Year of Property TAx Assessment
		'CondoFee' => 'Int', //Fee for Condo Buildings
		'HideMonthly' => 'Boolean', //Flag to hide Calulated Mortgage Payment 
		//lot size
		'LotLength' => 'Varchar', //Length of Lot
		'LotWidth' => 'Varchar',  //width of Lot
		'LotAcreage' => 'Varchar', //Total Acrege
		'Irregular' => 'Boolean', //Flag if lot is irresgular
		
		'Headline' => 'Text', //Teaser headline for template (Listing Item or Listing Page)
		'Summary' => 'HTMLText', //Short Summary Text which can be used on Listing Item or Listing Page
		
		//mapping data
		'Lat' => 'Varchar', //Genreated Geocoded Latitude (see onBeforeWrite)
		'Lon' => 'Varchar', //Genreated Geocoded Longitude (see onBeforeWrite)
		'SVHeading' => 'Varchar(25)', //Street View Heading
		'SVPitch' => 'Varchar(25)', //Street View Pitch
		'SVZoom' => 'Varchar(25)', //STreet View Zoom Level
		
		//feature sheet data
		'AdditionalMLS' => "Varchar(100)", //USed to store MLS nubmers for additional boards (useful for MLSListing Dublicate checks)
		'KeyPoints' => "HTMLText", //Key Selling features of Home
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
		'VideoURL' => 'HTMLVarchar(255)', //YouTube/Vimeo oEmbed URL
		
		//onbeforewritehack
		'CityIDHolder' => 'Varchar(100)'
		
	);
	
	private static $has_one = array(
		'Neighbourhood' => 'NeighbourhoodPage', //Optional Neighbourhood Page (see code/Pages/NeighbourhoodPage.php)
		'FeatureSheet' => 'File', //PDF/DOC feature sheet
		'Folder' => 'Folder', //Generated Folder for to organize related file uploads  
		'City' => 'MunicipalityPage', //City Page (see code/Pages/MunicipailtyPage.php)
		'Agent' => 'Member' //Listing Agent (see code/DataExtensions/Agent.php)
	);
	
	
	private static $has_many = array(
		'Rooms' => 'Room', //Optional Rooms (see code/DataObjects/Room.php)
		"OpenHouseDates" => "OpenHouseDate", //Open House (see code/DataObjects/OpenHouseDate.php)
		"Floorplans" => "File" //Floorplans PDF or JPG
	);
	
	private static $many_many = array(
		'Schools' => 'School' //Local Schools (see code/DataObjects/NeighbourhoodFeature.php)
	);
	
	private static $searchable_fields = array(
		'Address',
		'MLS'
	);
	
	
	
	private static $summary_fields = array(
		'FrontCover',
		'Address',
		'City.Title',
		'MLS',
		'ListingType',
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
	 	
	 	Requirements::javascript("http://maps.google.com/maps/api/js?sensor=false");
	 	Requirements::javascript("realestate/javascript/cmsmap.js");
	 	//Requirements::css("RealEstate/css/realestatecms.css");
	 	
	 	
	 	$fields->removeFieldsFromTab('Root.Main', array(
		 	'URLSegment',
		 	'Title',
			'MenuTitle',
			'FeatureBlock',
			'Street'
	 	));
	 	
		$fields->removeFieldsFromTab('Root.Gallery', array(
			'Images'
	 	));
	 	$fields->removeByName("Gallery");

	 	
	 	
	 	//DataLists for Dropdown Maps
	 	$cities = MunicipalityPage::get();
	 	
	 	//Create Composite Fields
	 	
	 	$statusField = ToggleCompositeField::create(
	 		"StatusGroup",
	 		"Status",
	 		array(
	 			DropdownField::create("Status", "Status", singleton('Listing')->dbObject('Status')->enumValues())->addExtraClass('noborder'),
	 			DropdownField::create("SaleOrRent", "Sale Or Rent", array("Sale" => "Sale", "Lease" => "Lease"))->addExtraClass('noborder'),
	 			CheckboxField::create("Feature")->addExtraClass('noborder'),
	 			CheckboxField::create("IsNew")->addExtraClass('noborder'),
	 			TextField::create("MLS", "MLS Number"),
	 		)
	 	);
	 	
	 	/**
	 	 *  Check if Multiple Cities or Default City is Set and configure Dropdown Accordingly
	 	 */
	 	
	 	if ($cities->count() == 1) {
		 	$cityField = DropdownField::create('CityID', 'City', $cities->map('ID', 'Title'))->setEmptyString('(Select one or Add Town)')->setHasEmptyDefault(false);
	 	} elseif ($cities->count() > 1 && $siteConfig->DefaultCityID != 0) {
		 	$cityField = DropdownField::create('CityID', 'City', $cities->map('ID', 'Title'), $siteConfig->DefaultCityID)->setEmptyString('(Select one or Add Town)')->setHasEmptyDefault(false);
	 	} else {
		 	$cityField = DropdownField::create('CityID', 'City', $cities->map('ID', 'Title'))->setEmptyString('(Select one or Add Town)');
	 	}
	 	
	 	/**
	 	 * Address Fields
	 	 */
	 	$neighbourhoodField = LiteralField::create("Blank","");
	 	if ($this->ID != 0 && $this->CityID != 0) {
		 	// Check if Neighbourhood Pages 
		 	$neighbourhoodList = NeighbourhoodPage::get()->filter(array("ParentID" => $this->CityID))->sort('Title')->map('ID', 'Title');
			if($neighbourhoodList->count() >= 1) {
				$neighbourhoodField = DropdownField::create('NeighbourhoodID', 'Neighbourhood', $neighbourhoodList);
				$neighbourhoodField->setEmptyString('(Select one)')->addExtraClass('stacked');
			}
	 	}
	 	
	 	$addressField = CompositeField::create(
	 		array (
	 			HeaderField::create("Address",2),
	 			TextField::create("Address")->addExtraClass('stacked noborder'),
	 			TextField::create("Unit")->addExtraClass('stacked noborder'),
	 			CompositeField::create(
	 				$cityField->addExtraClass('stacked leftcol noborder'),
	 				Textfield::create("Town")->setDescription('Use ONLY for Smaller Communities Outside Target Markets')->addExtraClass('stacked rightcol')
	 			)->addExtraClass('clearfix'),
	 			TextField::create("PostalCode", "Postal Code")->addExtraClass('stacked noborder'),
	 			$neighbourhoodField
	 		)
	 	)->addExtraClass("addDeets");
	 	
	 	/**
	 	 * Property Deatils
	 	 */
	 	
	 	$detailField = CompositeField::create(
	 		array (
	 			HeaderField::create("Property Details",2),
	 			DropdownField::create('ListingType','Listing Type',singleton('Listing')->dbObject('ListingType')->enumValues())->addExtraClass('stacked noborder'),
	 			TextField::create("TotalArea", "Total Approximate Area")->addExtraClass('stacked noborder'),
	 			CompositeField::create(
	 				TextField::create("NumberBed", "# Bedrooms")->addExtraClass('stacked oneThird noborder'),
	 				TextField::create("NumberBath", "# Bathrooms")->addExtraClass('stacked oneThird noborder'),
	 				TextField::create("NumberRooms", "# Rooms")->addExtraClass('stacked oneThird')
	 			)->addExtraClass('clearfix'),
	 			CheckboxField::create("Irregular", "Irregular Lot")->addExtraClass('noborder'),
	 			CompositeField::create(
	 				TextField::create("LotWidth", "Lot Width")->addExtraClass('stacked oneThird noborder'),
	 				TextField::create("LotLength", "Lot Depth")->addExtraClass('stacked oneThird noborder'),
	 				TextField::create("LotAcreage", "Acreage")->addExtraClass('stacked oneThird')
	 			)->addExtraClass('clearfix'),
	 			
	 		)
	 	)->addExtraClass("propDeets");
	 	
	 	/**
	 	 * Financial Details
	 	 */
	 	
	 	$financeDetails = CompositeField::create(
	 		array (
	 			HeaderField::create("Financial",2),
	 			NumericField::create("Price")->addExtraClass('stacked noborder'),
	 			NumericField::create("Taxes")->addExtraClass('stacked noborder'),
	 			TextField::create("TaxYear", "Tax Assessment Year")->addExtraClass('stacked noborder'),
	 			NumericField::create("CondoFee")->addExtraClass('stacked noborder'),
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
	 			HTMLEditorField::create('Summary')->addExtraClass('stacked')->setRows(4)
	 		)->addExtraClass('clearfix rmsListDetails'),
	 		"Content"
	 	);
	 	
        $fields->addFieldToTab ("Root.Main", new HiddenField('CityIDHolder'), 'Summary' );
		
		if($this->ID == 0 ) {
			$mainListingsPage = SiteTree::get_by_link("listings");
			$fields->addFieldToTab("Root.Main", new HiddenField("ParentID", "Parent", $mainListingsPage->ID));
		}
		
		$fields->renameField("Content", "Write-up");
		
		if ($this->ID != 0){
			
			
			$galleryField = GalleryUploadField::create('Images', 'Images', $this->OrderedImages())
				->setFolderName("/Homes/".$this->Folder()->Name)
				->addExtraClass('stacked');
			
			$featuresheetField = new UploadField('FeatureSheet');
			$featuresheetField->setFolderName("/Homes/".$this->Folder()->Name);
		 	
		 	$fields->addFieldsToTab("Root.PictureAndResources", array(
		 		CompositeField::create(
		 			CompositeField::create(
			 			$featuresheetField->addExtraClass('stacked'),
			 			TextField::create('VideoURL', "Video Embed Code")->addExtraClass('stacked')->setDescription('YouTube "Share this video" code'),
			 			UploadField::create("Floorplans")
			 				->addExtraClass('stacked')
			 				->setDescription('Upload Floorplans. Click edit on uploaded file to set Title for each floorplan. ie 1st floor, basement, etc.')
			 				->setFolderName("/Homes/".$this->Folder()->Name)
		 			)->addExtraClass('leftcol'),
		 			CompositeField::create( 
		 				$galleryField
		 			)->addExtraClass('rightcol')
		 		)->addExtraClass('clearfix'),
		 		
		 	));
		 	
		 	$schoolManager = LiteralField::create("Blank2", "");
		 	$schoolHeader = LiteralField::create("Blank3", "");
		 	if($this->CityID != 0 ) {
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
			 	$schoolHeader = HeaderField::create("SchoolHeader", "Schools", 2);
			 	//$fields->addFieldToTab('Root.Schools', $schoolManager);
			 }
			
					 	
		 	$openHouseManager = new GridField(
		 		"OpenHouseDates",
		 		"Open House Dates",
		 		$this->OpenHouseDates(),
		 		GridFieldConfig_RelationEditor::create()
		 			->removeComponentsByType('GridFieldAddNewButton')
		 			//->removeComponentsByType('GridFieldSortableHeader')
		 			->removeComponentsByType('GridFieldDataColumns')
		 			//->removeComponentsByType('GridFieldDeleteAction')
		 			//->removeComponentsByType('GridFieldEditButton')
		 			->removeComponentsByType('GridFieldAddExistingAutocompleter')
		 			//->addComponent(new GridFieldButtonRow('before'))
		 			//->addComponent(new GridFieldToolbarHeader())
		 			//->addComponent(new GridFieldTitleHeader())
		 			->addComponent(new GridFieldEditableColumns())
		 			->addComponent(new GridFieldDeleteAction())
		 			->addComponent(new GridFieldAddNewInlineButton())
		 			
		 	);
		 	$fields->addFieldToTab('Root.OpenHouse', $openHouseManager);
		 	
		 	$fields->addFieldToTab("Root.FeatureSheetData",  CompositeField::create(
		 		array(
		 			TextField::create('AdditionalMLS', 'Additional MLS Number'),
		 			TextField::create('Vendors'),
		 			TextField::create('Possession'),
		 			CheckboxField::create('Lockbox', 'Lockbox'),
		 			TextField::create('Fireplaces'),
		 			TextField::create('Garage'),
		 			TextField::create('Driveway'),
		 			TextField::create('District'),
		 			DropdownField::create('Occupied','Occupied',singleton('Listing')->dbObject('Occupied')->enumValues()),
		 			CheckboxField::create('AC', 'Air Conditioning'),
		 			TextField::create('Heat'),
		 			TextField::create('Basement'),
		 			TextField::create('Construction'),
		 			TextField::create('Topography'),
		 			TextField::create('Age'),
		 			DropdownField::create('Water','Water',singleton('Listing')->dbObject('Water')->enumValues()),
		 			CheckboxField::create('Sewer'),
		 			TextField::create('Restrictions'),
		 			DropdownField::create('Zoning','Zoning',singleton('Listing')->dbObject('Zoning')->enumValues()),
		 			TextField::create('LegalDesc', 'Legal Description'),
		 			TextField::create('Deposit'),
		 			DropdownField::create('SideOfRoad','Side Of Road',singleton('Listing')->dbObject('SideOfRoad')->enumValues()),
		 			TextField::create('Mortgage')
		 		)
		 	)->addExtraClass('leftcol'));
		 	
		 	$roomManagerConfig = GridFieldConfig_RelationEditor::create();
		 	$roomManagerConfig->removeComponentsByType('GridFieldDataColumns')
		 		->removeComponentsByType('GridFieldAddExistingAutocompleter')
		 		->removeComponentsByType('GridFieldAddNewButton');
		 	$roomManagerConfig->addComponents(
		 		//new GridFieldDetailForm('Room')
		 		new GridFieldEditableColumns(),
		 		new GridFieldDeleteAction(),
		 		new GridFieldAddNewInlineButton()
		 	);
		 	$roomManager = new GridField(
		 		"Rooms", "Rooms",
		 		$this->Rooms(), 
		 		$roomManagerConfig
		 	);
		 	
		 	$fields->addFieldToTab("Root.FeatureSheetData",  CompositeField::create(
		 		array(
		 			$roomManager,
		 			LiteralField::create("HR", "<hr>"),
		 			$schoolHeader,
		 			$schoolManager
		 		)
		 	)->addExtraClass('rightcol'));
		 	
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
		
		
		if($this->ID == 0 || $this->FolderID == 0) {
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
					$this->URLSegment = $URLFilter->filter($this->Address." Unit ".$this->Unit." ".$this->Town);
					$this->MetaTitle = $this->Address." Unit ".$this->Unit." ". $this->Town." MLS ".$this->MLS;
					$this->Title = $this->Address." Unit ".$this->Unit." ". $this->Town." ".$this->PostalCode;
				} else {
					$this->URLSegment = $URLFilter->filter($this->Address." ".$this->Town);
					$this->MetaTitle = $this->Address." ". $this->Town." MLS ".$this->MLS;
					$this->Title = $this->Address." ". $this->Town;
				}
				if (!$this->MetaDescription) {
					$this->MetaDescription = $this->Town." Homes for Sale ".$this->Title." | ".strip_tags($this->Summary);
				}
				
			} else {
				$config = SiteConfig::current_site_config(); 
				$this->URLSegment = $URLFilter->filter($this->MLS." ".$this->Town);
				$this->MetaTitle = $this->MLS." ". $this->Town;
				$this->Title = $this->MLS." ". $this->Town ;
				$this->MetaDescription = "Homes for Sale in ".$this->Town." ".$this->Title." sold by ".$config->BusinessName;
			}
			
			if(($this->Status == "Available" || $this->Status == "Sold") && $this->ClassName != "Listing") {
				$this->ClassName = "Listing";
			} elseif( ( $this->Status == "Unavailable" || $this->Status == "Closed") && $this->ClassName != "UnavailableListing")  {
				$this->ClassName = "UnavailableListing";
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
	
		if($this->FolderID != 0){
			$folder = Folder::get()->byID($this->FolderID);
			
			if($folder) {
				$folder->delete();	
			}
		}
		
		$rooms = $this->Rooms();
		if($rooms->count()) {
			foreach ($rooms as $room) $room->delete();
		}
		
		$openHouses = $this->OpenHouseDates();
		if($openHouses->count()){
			foreach ($openHouses as $openHouse) $openHouse->delete();
		}
		
		parent::onBeforeDelete();
	}

	public function providePermissions() { 
		return array( 
			'LISTING_VIEW' => 'Read listing', 
			'LISTING_EDIT' => 'Edit listing', 
			'LISTING_DELETE' => 'Delete listing', 
			'LISTING_CREATE' => 'Create listings', 
			'LISTING_VIEWEXT' => 'Read listing extended info', 
		); 
	} 
	
	/**
	 * Accessor methods
	 * ----------------------------------*/
	
	public function getTown(){
		return $this->City() ? $this->City()->Title : $this->Town;
	}
	
	public function getProvince() {
		$siteConfig = SiteConfig::current_site_config();
		return $siteConfig->DefaultProvince;
	}

	function getFrontCover() {
		if($this->OrderedImages()->exists()) return $this->OrderedImages()->First()->SetWidth(100); 
	}	 


	/**
	 * Controller actions
	 * ----------------------------------*/
	 


	/**
	 * Template accessors
	 * ----------------------------------*/
	 
	public function CoverImage() {
		 $images = $this->OrderedImages();
		 
		 return $images->count() ? $images->First() : false;
	 }
	 
	public function AbsoluteURLEncoded() {
		return urlencode($this->BaseHref().$this->URLSegment);
	}
	
	
	public function GroupedSchools(){
		if($this->Schools()->count()){
			return GroupedList::create($this->Schools()->sort("Type"));
		} else {
			return false;
		}
		
		
	}
	
	
	//MOVE TO A UTILITY CLASS
	//checks if Pased Item is with 15 miles of this DataObject
	public function getDistance($lat,$lon) {
		return ( 3959 * acos( cos( deg2rad($lat) ) * cos( deg2rad( $this->Lat ) ) * cos( deg2rad($this->Lon ) - deg2rad($lon) ) + sin( deg2rad($lat) ) * sin( deg2rad( $this->Lat ) ) ) );
	}
	
	
	/**
	 * Fin Nearby Listing
	 *
	 * @param $lat GPS Latitude
	 * @param $lon GPS Longitude
	 * @param $distance distandce in Km 
	 * @return ArrayList
	 */
	public function FindNear($lat, $lon, $distance = '25', $limit = null) {
		
		if($lat && $lon) {
			return RMSController::FindNear($lat, $lon, $distance, $limit);
		} else {
			return false;
		}
		
	}
	
	/**
	 * Return Money Formated Values  
	 *
	 * @return 
	 */
	
	public function FormattedPrice() {
		setlocale(LC_MONETARY, 'en_CA');
		if($this->Price && $this->Price != 0){
			return money_format('%.0n', $this->Price);
		} else {
			return false;
		}
	}
	
	public function FormattedTaxes() {
		if($this->Taxes && $this->Price != 0){
			setlocale(LC_MONETARY, 'en_CA');
			return money_format('%.0n', $this->Taxes);
		} else {
			return false;
		}
	}
	
	public function MonthlyPrice(){
		$siteConfig = SiteConfig::current_site_config();
		
		if($siteConfig->DownPayment != 0) {
			$down = $siteConfig->DownPayment/100;
		} else {
			$down = 0.2;
		}
		
		if(($this->Price && $this->Price != 0) && $siteConfig->InterestRate != 0){
			$borrowed = $this->Price - ceil($this->Price * $down);
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
		if($siteConfig->DownPayment != 0) {
			$down = $siteConfig->DownPayment/100;
		} else {
			$down = 0.2;
		}
		if($this->Taxes && $this->Price != 0){ 
			return ceil($this->Price * $down);
		} else {
			return false;
		}
	}
	
	public function InterestRate() {
		$siteConfig = SiteConfig::current_site_config();
		
		return $siteConfig->InterestRate;
	}
	
	public function DefaultDown() {
		$siteConfig = SiteConfig::current_site_config();
		
		if($siteConfig->DownPayment != 0) {
			return $siteConfig->DownPayment;
		} else {
			return 20;
		}
	}
	
	 
	function RelatedProperties($count = 4) {
	 	$siteConfig = SiteConfig::current_site_config();
	 	
	 	if($siteConfig->RelatedPriceRange != 0) {
		 	$varience = $siteConfig->RelatedPriceRange;
	 	} else {
		 	$varience = 50000;
	 	} 		$items = Listing::get()->filter(array(
 			"CityID" => $this->CityID,
 			"Status" => "Available",
 			"Price:LessThan" => $this->Price + 50000,
 			"Price:GreaterThan" => $this->Price - 50000
 		))->limit($count);
	 	
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
	        //has_one
	        $this->City()->LastEdited,
	        $this->Neighbourhood()->LastEdited,
	        $this->FeatureSheet()->LastEdited,
	        //has_many
	        $this->RelationshipAggregate('Rooms')->Max('LastEdited'),
	        $this->RelationshipAggregate('OpenHouseDates')->Max('LastEdited'),
	        $this->RelationshipAggregate('Floorplans')->Max('LastEdited'),
	        //many_many
	        $this->RelationshipAggregate('Schools')->Max('LastEdited'),
	        $this->RelationshipAggregate('Images')->Max('LastEdited'),
	        
	       
	        
	    ));
	 }
	
	
	function ShowListingsPage() {
		return ListingsPage::get()->where("City = ".$this->CityID)->count() ? ListingsPage::get()->where("City = ".$this->CityID)->First() : false;
	}
	
	
	
	public function UpcomingOpenHouse() {
		$OpenHouses = $this->OpenHouseDates()->filter(array("OpenHouseDate:greaterThan" => strtotime("today")));
		return $OpenHouses->count() ? $OpenHouses : false;
	}
	
	
	public function NextOpenHouse() {
		if($this->OpenHouseDates()->count()) { 
			$openHouse = $this->OpenHouseDates()->filter(array ("OpenHouseDate:GreaterThan" => strtotime('yesterday'), "OpenHouseDate:LessThan" => strtotime("1 week")))->First();
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
	
	private static $allowed_actions = array("ContactForm");
	
	public function init() {
		parent::init();
		
		if($this->Status == "Unavailable" || $this->Status == "Closed") {
			Session::set("UnavailListing", array("Price" => $this->Price, "Lat" => $this->Lat, "Lon" => $this->Lon, "City" => $this->City, "Town" => $this->Town));
			$redirect = SiteTree::get_by_link("listing-unavailable");
			$this->redirect($redirect->Link(), 301);
			return;
		}
	}
	
	public function index() { 
		if ($this->Status == "Sold") { 
			return $this->renderWith(array('SoldListing', 'Listing', 'Page')); 
		} 
			else return $this->renderWith(array('Listing','Page')); 
	}		
	
	public function ContactForm() {
		$form = new ListingRequestForm($this, 'ContactForm');
		
		if($form->hasExtension('FormSpamProtectionExtension')) {
		    $form->enableSpamProtection();
		}
		
		return $form;
	}
	
	function RelatedProperties($count = 4) {
	 	$siteConfig = SiteConfig::current_site_config();
	 	
	 	if($siteConfig->RelatedPriceRange != 0) {
		 	$varience = $siteConfig->RelatedPriceRange;
	 	} else {
		 	$varience = 50000;
	 	} 		$items = Listing::get()->filter(array(
 			"CityID" => $this->CityID,
 			"Status" => "Available",
 			"Price:LessThan" => $this->Price + 50000,
 			"Price:GreaterThan" => $this->Price - 50000
 		))->limit($count);
	 	
	 	if($items) {
	 		return $items;
	 	} else {
	 		return false;
	 	}
	 	
	 }
	
}

class Listing_Images extends DataObject {

    static $db = array (
        'PageID' => 'Int',
        'ImageID' => 'Int',
        'Caption' => 'Text',
        'SortOrder' => 'Int'
    );
}