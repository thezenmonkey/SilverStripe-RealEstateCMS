<?php
 
class RealEstateSiteConfig extends DataExtension {
	
	private static $db = array(
		//Business Info
		'BusinessName' => 'Varchar',
		'StreetAddress' => 'Varchar',
		'City' => 'Varchar',
		'Province' => 'Varchar',
		'PostalCode' => 'Varchar',
		'PhoneNumber' => 'Varchar',
		'FaxNumber' => 'Varchar',
		'MainEmail' => 'Varchar',
		'SiteEmail' => 'Varchar',
		//Social Media
		'Twitter' => 'Varchar',
		'LinkedInURL' => 'Varchar',
		'FacebookURL' => 'Varchar',
		'GooglePlusURL' => 'Varchar',
		'PinterestURL' => 'Varchar',
		'YouTubeURL' => 'Varchar',
		'InstagramURL' => 'Varchar',
		'TumblrURL' => 'Varchar',
		//Real Estate Defaults
		"DefaultProvince" => "Varchar",
		"InterestRate" => "Decimal",
		"LandTrasfer" => "Decimal",
		"DownPayment" => "Int",
		'MLSMin' => 'Int',
		'MLSMax' => 'Int'
	);
	
	private static $has_one = array(
		"Picture" => "Image",
		"DefaultCity" => "MunicipalityPage"
	);
	
	
	
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab("Root.Main", TextField::create("BusinessName"));
		$fields->addFieldToTab("Root.Main", TextField::create("StreetAddress"));
		$fields->addFieldToTab("Root.Main", TextField::create("City"));
		$fields->addFieldToTab("Root.Main", TextField::create("Province"));
		$fields->addFieldToTab("Root.Main", TextField::create("PostalCode"));
		$fields->addFieldToTab("Root.Main", TextField::create("PhoneNumber"));
		$fields->addFieldToTab("Root.Main", TextField::create("FaxNumber"));
		$fields->addFieldToTab("Root.Main", EmailField::create("MainEmail", 'Main Contact Email'));
		$fields->addFieldToTab("Root.Main", EmailField::create("SiteEmail", 'Email for Contact Forms'));
		$fields->addFieldToTab("Root.Main", UploadField::create("Picture"));
		
		$socialField = ToggleCompositeField::create(
	 		"SocialGroup",
	 		"Social Media",
	 		array (
	 			TextField::create("Twitter", 'Twitter User Name')->setDescription('User Name WITHOUT the at symobole (@) '),
	 			TextField::create("FacebookURL", 'Facebook URL'),
	 			TextField::create("LinkedInURL", 'LinkedIn URL'),
	 			TextField::create("GooglePlusURL", 'Google+ URL'),
	 			TextField::create("PinterestURL", 'Pinterest URL'),
	 			TextField::create("YouTubeURL", 'YouTube URL'),
	 			TextField::create("InstagramURL", 'Instagram URL'),
	 			TextField::create("TumblrURL", 'Tumblr URL')
	 		)
	 	);
	 	
	 	$fields->addFieldToTab("Root.Main", $socialField);
	 	
	 	//Defaults
	 	$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("InterestRate", "Interest Rate")->setDescription('Used to calculate Monthly Payments'));
	 	$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("DownPayment", "Down Payment")->setDescription('Used to calculate Monthly Payments'));
	 	$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("LandTrasfer", "Land Transfer Tax Rate")->setDescription('Only needed if Have a Land Tranfer Tax Caluclator'));
	 	$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("DefaultProvince", "Default Province for All Listings"));
	 	
	 	$cityList = MunicipalityPage::get();
		if($cityList->count() > 1) {
			$fields->addFieldToTab( 
				"Root.DefaultSettings",
				DropdownField::create("DefaultCityID", "Default City", $cityList->sort('Title')->map('ID', 'Title'))
					->setEmptyString('(Select one)')
					->setDescription('Set for your Primary Selling Location to save time when adding listings')
			);
		}
		
		$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("MLSMin", "Minimum Price for MLS download"));
		$fields->addFieldToTab("Root.DefaultSettings", Textfield::create("MLSMax", "Maximum Price for MLS download"));
	 	
	}
}