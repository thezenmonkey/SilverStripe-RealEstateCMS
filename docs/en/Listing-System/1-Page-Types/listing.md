# prptes Listing
## Introduction
The listing page is the key page type for the RMS. It's used to render listing data to the visitor.
*source:* listing.php

## Model
### Basic Sale Data
__$Status__: Listing Availability Option Set ('Available, Sold, Closed, Unavailable'). See [onBeforeWrite](#onBeforeWrite)

__$Feature__: Flag to define if the listing is considered a "Feature Listing"

__$IsNew__: Flag to define if a listing is considered New

__$MLS__: MLS number for primary board. If the agent submits to multiple boards they can use _$AdditionalMLS_ to store those MLS numbers  *Required*
 
__$ListingType__: Option Set (Residential, Condo, Commercial) Type of property based of TREB IDX classification

__$SaleOrRent__: Option Set (Sale, Lease)

### Basic Address Data
__$Address__: Street Address *Required*

__$Unit__: Optional Unit Number

__$City__: Relation to [Municipality Page](municipality-page), in templets use *$Town* instead of $City.Title

__$Neighbourhood__: Relation to [Neighbourhood Page](neighbourhood-page)

__$Town__: Stores City/Town for properties outside of key market. In templates use $Town as it will return the City Name.  *City OR Town is Required*

__$Province__: Not actually stored on the listing but as Default  Province on SiteConfig.

__$PostalCode__: Zip or Postal Code

__$Street__: Generated Value strips building number off address (used for sorting)

### Basic Home Details
__$TotalArea__: Square footage/meters of home

__$NumberBed__: Number of Bedrooms

__$NumberBath__: Number of Bathrooms

__$NumberRooms__: Total Number of Rooms

### Basic Financial Data
__$Price__: Listing Price

__$Taxes__: Assessed Property Tax

__$TaxYear__: Year of Property Tax Assessment

__$CondoFee__: Fee for Condo Buildings

__$HideMonthly__: Flag to hide Calculated Mortgage Payment 

### Lot Size
__$LotLength__: Length of Lot

__$LotWidth__: width of Lot

__$LotAcreage__: Total Acreage

__$Irregular__: Flag if lot is irregular

### Write Up
__$Headline__: Teaser headline for template (Listing Item or Listing Page)

__$Summary__: Short HTML Summary Text which can be used on Listing Item or Listing Page

__$KeyPoints__ Key Selling features of Home (HTMLText)

__$Content__: Write-up for listing

### Mapping Data
Mapping data is either generated by [Geocoder](../4-Utilities/geocoder) or through the mapping interface.

__$Lat__: Generated Geocoded Latitude (see onBeforeWrite)

__$Lon__: Generated Geocoded Longitude (see onBeforeWrite)

__$SVHeading__: Street View Heading

__$SVPitch__: Street View Pitch

__$SVZoom__: Street View Zoom Level

### Feature Sheet Data
Most of these fields correspond to standard feature sheet info. **TODO** optionally sync with MLS.

* __$AdditionalMLS__: Used to store MLS numbers for additional boards (useful for MLSListing Duplicate checks)
* __$Vendors__ 
* __$Possession__ 
* __$Lockbox__ 
* __$Fireplaces__ 
* __$Garage__ 
* __$Driveway__ 
* __$District__ 
* __$Occupied__ 
* __$AC__ 
* __$Heat__ 
* __$Basement__ 
* __$Construction__ 
* __$Topography__ 
* __$Age__ 
* __$Water__ 
* __$Sewer__ 
* __$Restrictions__ 
* __$Zoning__ 
* __$LegalDesc__ 
* __$Deposit__ 
* __$SideOfRoad__ 
* __$ListingDate__ 
* __$Mortgage__

### Media
See [Media Functions](#Media-Functions) for complete list of functions available
 
__$VideoURL__: YouTube/Vimeo oEmbed URL **Note:** In templates use __$EmbedVideo__ to render the embedded video tag.

__$Images__: Loop-able list of related images: See [Media Functions](#Media-Functions). Please see the [SilverStripe Image Documentation](http://doc.silverstripe.org/framework/en/reference/image) for all other image references.

__$FeatureSheet__: 1 Feature Sheet. Please see [SilverStripe File Documentation](http://api.silverstripe.org/3.1/class-File.html) for available properties and functions

__$Floorplans__: Loop-able Floor-plans file relation. Please see [SilverStripe File Documentation](http://api.silverstripe.org/3.1/class-File.html) for available properties and functions

### Other Relations

__$OpenHouseDates__: Open House dates see [Open House System](#Open-House-System)

__$Agent__: Relation to Agent (member) if the firm wants to tie the info

__$Folder__: File system relation to help keep all files associated with listing together. Please see [SilverStripe File Documentation](http://api.silverstripe.org/3.1/class-File.html) for available properties and functions

## Template Functions
### Financial
Since all financial data is stored in the system as raw numbers there are few template functions to help render and calculate financial data correctly.

__$FormattedPrice__: returns $Price with dollar symbol and thousand separators.

__$FormattedTax__: returns $Tax with dollar symbol and thousand separators.

__$MonthlyPrice__: Calculates and returns the a formatted monthly prices based on the default down payment percentage ($DefaultDown) and interest rate ($InterestRate) it use default term of 360 months (30 years).

The following functions are used for the Javascript Mortgage Calculator

__$InterestRate__: returns the default interest rate as defined int the Site Config.

__$DefaultDown__: returns the default down-payment percentage from the Site Config. If none is set it returns 20

__$DownPayment__: calculates and returns the unformated downpayment based on the price and $DefaultDown.

### Open House System
__$UpcomingOpenHouse__ check to see if there are any future open houses set for this listing and returns either false or all future [OpenHouseDates](../2-Data-Objects/open-house-date)

__$GetOpenHouseThisWeekend__ check if upcoming open house falls on the upcoming weekend and returns a new list of only those dates *TODO* Clean up function or delete. Built for a client that wanted to distinguish between Weekend Open Houses and Agent Open Houses

### Media Functions
__$EmbedVideo__ returns to the oEmbed html for the video specified in $VideoURL. _Recommended block:_
	<% if $VideoURL %>
		$EmbedVideo
	<% end_if %>

__$CoverImage__: returns the First Image. Please see the [SilverStripe Image Documentation](http://doc.silverstripe.org/framework/en/reference/image). **TODO** Add a cover image flag to the Image relation to allow the images other than the first to be used as cover.

### Listing Functions
__$RelatedProperties__: Returns own listings in the same city as the current listing. Defaults to 4, but can be overiden
	<% if $RelatedProperties %>
		<% loop $RelatedProperties(6) %>
			_your code_
		<% end_loop %>
	<% end_if %>
**TODO** Abstract so that MLS listings can be optionally included.

## Cache Functions
__$ListingCacheKey__: Calculates cache key based on Last Edited Times of related City, Neighbourhood, FeatureSheet, Rooms, OpenHouseDates, Floorplans, Schools, Images and the Listing Itself

## TODO
* Abstract RelatedProperties so that MLS listings can be optionally included.
* Add CoverImage flag to related images
* Sync Feature Sheet data with MLS
* Evaluate GetOpenHouseThisWeekend
* Document School Relation
* Clean up Depreciated functions purpose built for specific clients (Move to DataExtension on those projects)
