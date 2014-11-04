<?php
/**
 * 	
 * @package Realestate Listing System - Property Listings Page 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */


class ListingsPage extends DataObjectAsPageHolder 
{
	/**
	 * Static vars
	 * ----------------------------------*/
	
	private static $singular_name = 'Listings';
    private static $plural_name = 'Listing Pages';
    private static $description = 'Displays Listing (if under main Listings page it can be configured to show only one City or Neighbouthod)';
    private static $icon = 'realestate/images/listings.png'; //Attribute as Martha Ormiston, from The Noun Project
	 
	private static $db = array(
		"City" =>  "Varchar",
	);
	
	private static $allowed_children = array("Listing", "ListingsPage");
	

	
	/**
	 * Object vars
	 * ----------------------------------*/



	/**
	 * Static methods
	 * ----------------------------------*/
	


	/**
	 * Data model
	 * ----------------------------------*/

	/**
	 * Get All Avaibalbe Listings (Status = Available)
	 *
	 * @return DataList
	 */
	
	public function AvailableListings() {
		 $listings = Listing::get()->filter(array("Status" => "Available"))->sort(array("Feature" => "DESC", "ID" => "DESC"));
		 
		 return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Marked as Sold but Not Closed
	 *
	 * @return DatList
	 */
	public function SoldListings() {
		$listings = Listing::get()->filter(array("Status" => "Sold"))->sort(array("ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Marked as Closed
	 *
	 * @return DatList
	 */
	public function ClosedListings() {
		$listings = Listing::get()->filter(array("Status" => "Closed"))->sort(array("ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Get All Listings Available AND Sold
	 *
	 * @return DataList
	 */
	public function AllListings() {
		$listings = Listing::get()->filter(array("Status" => array("Available","Sold")))->sort(array("Status" => "ASC", "ID" => "DESC"));
		
		return $listings->count() ? $listings : false;
	}
	
	
	/**
	 * Retun ALLlistings in the system regardless of Status
	 *
	 * @return DataList
	 */
	public function MasterListings() {
		$listings = Listing::get();
		
		return $listings->count() ? $listings : false;
	}
	
	/**
	 * Retun MLS Listings 
	 *
	 * @param $count number of listings to return
	 * @return DataList
	 */
	public function MLSListings($count = 10) {
		
		$listings = MLSListing::get()->limit($count);
		
		return $listings->count() ? $listings : false;
	}
	
	/**
	 * Retun Only Featured MLS Listings 
	 *
	 * @param $count number of listings to return
	 * @return DataList
	 */
	public function FeaturedMLSListings($count = null) {
		
		if($count) {
			$listings = MLSListing::get()->filter(array("IsFeatured" => 1))->limit($count);
		} else {
			$listings = MLSListing::get()->filter(array("IsFeatured" => 1));
		}
		
		return $listings->count() ? $listings : false;
	}

	/**
	 * Common methods
	 * ----------------------------------*/
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('City');
		
		$cityField = new DropdownField('City', 'City', MunicipalityPage::get()->map('ID', 'Title'));
        $cityField->setEmptyString('(Select one)');
		
		if($this->ParentID != 0) {
			$fields->insertBefore($cityField, 'Content');
		}
		
		return $fields;
	} 
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
		
		if($this->ParentID == 0){
			$this->City = "All";
			$this->ItemsPerPage = 40;
		}
			
	}


	/**
	 * Accessor methods
	 * ----------------------------------*/



	/**
	 * Controller actions
	 * ----------------------------------*/
	 

	function requireDefaultRecords() {
		
		
			if(!SiteTree::get_by_link("listings")){
				$listingPage = new ListingsPage();
				$listingPage->Title = "Listings";
				$listingPage->URLSegment = "listings";
				$listingPage->Sort = 1;
				$listingPage->write();
				$listingPage->publish('Stage', 'Live');
				$listingPage->flushCache();
				DB::alteration_message('Listings page created', 'created');
			}
		
		parent::requireDefaultRecords();
	}

	 
	 
	 
	 
	 



	/**
	 * Template accessors
	 * ----------------------------------*/

	 /*
public function GetMLSNumber($number) {
		 
		 if($number == "all") {
			 return MLSListing::get()->sort("Municipality");
			 
		 } else {
		 	$number = (int) $number;
		 	$set = new ArrayList();
		 	foreach(MLSListing::get()->where("IsFeatured = 1") as $obj) $set->push($obj);
		 	if($set->count() && $set->count() <= $number) {
			 	$limit = $number - $set->count();
			 	foreach(MLSListing::get()->where("IsFeatured = 0")->limit($limit) as $obj) $set->push($obj); 
		 	} elseif (!$set->count()){
			 	foreach(MLSListing::get()->where("IsFeatured = 0")->limit($number) as $obj) $set->push($obj);
		 	}
		 	
			return  $set;
		 }
	 }
*/

	 public function GetCities() {
		 return MunicipalityPage::get();
	 }
	 
	 public function GetCity() {
		 return $this->City ? $this->City : false;
	 }
	 /*
public function ThisCity($City) {
		 return MunicipalityPage::get()->byID($City);
	 }
*/
	 
	 public function TownListings() {
		$sqlQuery = new SQLQuery();
		$sqlQuery->setFrom('Listing');
		$sqlQuery->setWhere('CityID = 0');
		$sqlQuery->selectField('Town');
		$sqlQuery->setDistinct(true);
		$result = $sqlQuery->execute();
		
		$townList = array();
		foreach($result as $row){
			array_push($townList, $row['Town']);
		}
		 
		$filterList = (array_filter($townList));
		
		if($filterList) {
			
			$listings = Listing::get()->filter(array("Town" => $filterList));
			return $listings->count() ? $listings : false;
			
		} else {
			return false;
		}
	 }
	 
	 
	 //Client Specific
	 public function OverAMillion() {
		 $set = new ArrayList();
		
		foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->sort(array("Feature"=>"DESC")) as $obj) $set->push($obj);
		foreach(Listing::get()->filter(array("Sold" => '1', "Price:GreaterThan" => "1000000"))->sort("LastEdited", "DESC")->limit(4) as $obj) $set->push($obj);
		
		//foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->where("Sold = 0")->sort(array("Feature"=>"DESC","SaleOrRent"=>"ASC")) as $obj) $set->push($obj);
		
		return $set->count() ? $set : false;
	 }
	 	
	 //Client Specific
	 public function UnderAMillion() {
		 $set = new ArrayList();
		
		foreach(Listing::get()->filter(array("Sold" => '0', "Price:LessThan" => "1000000"))->sort(array("Feature"=>"DESC")) as $obj) $set->push($obj);
		foreach(Listing::get()->filter(array("Sold" => '1', "Price:LessThan" => "1000000"))->sort("LastEdited", "DESC")->limit(4) as $obj) $set->push($obj);
		
		//foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->where("Sold = 0")->sort(array("Feature"=>"DESC","SaleOrRent"=>"ASC")) as $obj) $set->push($obj);
		
		return $set->count() ? $set : false;
	 }
	 
	 public function getShowCities() {
		return $this->config()->ShowCities;
	 }

	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}



class ListingsPage_Controller extends DataObjectAsPageHolder_Controller 
{
	//This needs to know be the Class of the DataObject you want this page to list
	static $item_class = 'MLSListing';
	//Set the sort for the items (defaults to Created DESC)
	static $item_sort = 'Created DESC';
	
	public static $allowed_actions = array("ContactForm", "show");
	
	public function show()
	{
		if($item = $this->getCurrentItem())
		{
			if ($item->canView())
			{
				$data = array(
					'Item' => $item,
					'Breadcrumbs' => $item->Breadcrumbs(),
					'MetaTags' => $item->MetaTags(),
					'BackLink' => base64_decode($this->request->getVar('backlink'))
				);
				
				return $this->customise(new ArrayData($data));
			}
			else
			{
				return Security::permissionFailure($this);
			}
		}
		else
		{
			//return $this->httpError(404);
			$redirect = SiteTree::get_by_link("listing-unavailable");
			$this->redirect($redirect->Link(), 301);
			return;
		}
	}
	
	public function getAddress() {
		if($item = $this->getCurrentItem()) {
			return $item->Address;
		} else {
			return false;
		}
	}
	
	public function getMLS() {
		if($item = $this->getCurrentItem()) {
			return $item->MLS;
		} else {
			return false;
		}
	}
	
	
	function showgallery() {
	
		if(($item = $this->getCurrentItem())) {
			if ($this->getCurrentItem()->canView()) {
				$data = array(
				'Item' => $item,
				'Breadcrumbs' => $this->ItemBreadcrumbs($item),
				'MetaTitle' => $item->MetaTitle,
				'MetaTags' => $this->ItemMetaTags($item),
				'BackLink' => base64_decode($this->request->getVar('backlink'))
				);
				
				if($this->isAjax) {
					$this->customise(new ArrayData($data));
					return $this->renderWith(array('AjaxGallery'));
				} else {
					return $this->customise(new ArrayData($data));
				} 
				
			} else {
				return Security::permissionFailure($this);
			}
		} else {
			return $this->httpError(404);
		}
	}
	
	public function ContactForm() {
		$form = new ListingRequestForm($this, 'ContactForm');
		
		if($form->hasExtension('FormSpamProtectionExtension')) {
		    $form->enableSpamProtection();
		}
		
		return $form;
	}
	
	
}