<?php
/**
 * 	
 * @package Realestate Listing System - Neighbourhood Listings Page 
 * @requires DataObjectAsPage, Mappable
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */


class CommunitiesPage extends DataObjectAsPageHolder 
{
	/**
	 * Static vars
	 * ----------------------------------*/
		

	/**
	 * Object vars
	 * ----------------------------------*/



	/**
	 * Static methods
	 * ----------------------------------*/



	/**
	 * Data model
	 * ----------------------------------*/
	 
	 private static $db = array(
	 	"List" => "Varchar"
	 );


	/**
	 * Common methods
	 * ----------------------------------*/

	 public function getCMSFields() {
	 	$fields = parent::getCMSFIelds();
	 	
	 	$ListArray = array(
		 	"Community" => "All",
		 	"City" => "Cities Only",
		 	"Neighbourhood" => "Neighbourhoods Only"
		 );
	 	
	 	$fields->insertBefore(DropdownField::create("List", "List", $ListArray), "Content");
	 	
	 	return $fields;
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



	/**
	 * Object methods
	 * ----------------------------------*/
	 
	 

}

class CommunitiesPage_Controller extends DataObjectAsPageHolder_Controller 
{
	//This needs to know be the Class of the DataObject you want this page to list
	private static $item_class = "Community";
	//Set the sort for the items (defaults to Created DESC)
	private static $item_sort = 'Created ASC';
	
	
	
	
	/*
	 * Returns the items to list on this page pagintated or Limited
	 */
	public function Items($limit = null)
	{
		//Set custom filter
		$where = ($this->hasMethod('getItemsWhere')) ? $this->getItemsWhere() : Null;
		//Set custom sort		
		$sort = ($this->hasMethod('getItemsSort')) ? $this->getItemsSort() : $this->stat('item_sort');
		//Set custom join	
		$join = ($this->hasMethod('getItemsJoin')) ? $this->getItemsJoin() : Null;
		
		//QUERY
		$items = $this->FetchItems($this->List, $where, $sort, $join, $limit);

		//Paginate the list
		if(!$limit && $this->Paginate)
		{
			$items = new PaginatedList($items, $this->request);
			$items->setPageLength($this->ItemsPerPage);
		}

		return $items;
	}
	
	
	
	
}