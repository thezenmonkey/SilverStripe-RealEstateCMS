<?php
/**
 * 	
 * @package Realestate Listing System - Property Listings Page 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */


class ListingsPage extends Page 
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
	 * Common methods
	 * ----------------------------------*/
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('City');
		
		$cityField = new DropdownField('City', 'City', City::get()->map('ID', 'Title'));
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

	 public function GetMLS($number) {
		 
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

	 public function GetCities() {
		 return City::get()->sort("ID");
	 }
	 
	 public function ThisCity($City) {
		 return City::get()->byID($City);
	 }
	 
	 public function TownTest() {
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
	 }
	 
	 public function OverAMillion() {
		 $set = new ArrayList();
		
		foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->sort(array("Feature"=>"DESC")) as $obj) $set->push($obj);
		foreach(Listing::get()->filter(array("Sold" => '1', "Price:GreaterThan" => "1000000"))->sort("LastEdited", "DESC")->limit(4) as $obj) $set->push($obj);
		
		//foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->where("Sold = 0")->sort(array("Feature"=>"DESC","SaleOrRent"=>"ASC")) as $obj) $set->push($obj);
		
		return $set->count() ? $set : false;
	 }
	 
	 public function UnderAMillion() {
		 $set = new ArrayList();
		
		foreach(Listing::get()->filter(array("Sold" => '0', "Price:LessThan" => "1000000"))->sort(array("Feature"=>"DESC")) as $obj) $set->push($obj);
		foreach(Listing::get()->filter(array("Sold" => '1', "Price:LessThan" => "1000000"))->sort("LastEdited", "DESC")->limit(4) as $obj) $set->push($obj);
		
		//foreach(Listing::get()->filter(array("Sold" => '0', "Price:GreaterThan" => "1000000"))->where("Sold = 0")->sort(array("Feature"=>"DESC","SaleOrRent"=>"ASC")) as $obj) $set->push($obj);
		
		return $set->count() ? $set : false;
	 }

	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}



class ListingsPage_Controller extends Page_Controller 
{
	
	
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
	
	
}