# prptes MLS Listing
## Introduction
Listings downloaded from MLS are stored in a DataObject separate from the main site tree. Since versioning is not required by the synced data, and the data set can get large and highly changeable we do not want to pollute the site tree with data we don't control. This also helps keep this information out of the site tree.
*source:* MLSListing.php
*requires:* DataObjectAsPage Module

## Model
Basic data is kept in-line with listing and the model in general is kept in line with the TREB MLS Data;
### Basic Sale Data
* __IsFeatured__: Flag set to show a listing as Featured Listing. Used in themes to help the agent better control which MLS listings show up in their feed.
* __ListingType__
* __Shares__
* __Acreage__
* __AddlMonthlyFees__
* __Address__
* __AirConditioning__
* __AllInclusiveRental__
* __ApproxAge__
* __ApproxSquareFootage__
* __AptUnit__
* __Area__
* __Assessment__
* __AssessmentYear__
* __Balcony__
* __Basement__
* __Bedrooms__
* __BedroomsPlus__
* __BuildingAmenities__
* __BuildingInsuranceIncluded__
* __CableTVIncluded__
* __CACIncluded__
* __CentralVac__
* __CommonElementsIncluded__
* __Community__
* __CommunityCode__
* __CondoCorpNum__
* __CondoRegistryOffice__
* __CondoTaxesIncluded__
* __DirectionsCrossStreets__
* __Drive__
* __Elevator__
* __Exterior__
* __EnsuiteLaundry__
* __Exposure__
* __Extras__
* __FarmAgriculture__
* __FireplaceStove__
* __Fronting__
* __Furnished__
* __GarageSpaces__
* __GarageType__
* __HeatIncluded__
* __HeatSource__
* __HeatType__
* __HydroIncluded__
* __IDXUpdatedDate__
* __Kitchens__
* __KitchensPlus__
* __LaundryAccess__
* __LaundryLevel__
* __LeaseTerm__
* __LegalDescription__
* __ListBrokerage__
* __Price__
* __Locker__
* __LockerNum__
* __LotDepth__
* __LotFront__
* __LotIrregularities__
* __LotSizeCode__
* __Maintenance__
* __MapNum__
* __MapColumnnNum__
* __MapRow__
* __MLS__
* __Municipality__
* __MunicipalityDistrict__
* __MunicpCode__
* __OtherStructures__
* __OutofAreaMunicipality__
* __ParkCostMo__
* __ParkingIncluded__
* __ParkingLegalDescription__
* __ParkingSpaces__
* __ParkingSpot1__
* __ParkingSpot2__
* __ParkingType__
* __ParkingType2__
* __ParkingDrive__
* __PetsPermitted__
* __PIN__
* __PixUpdatedDate__
* __Pool__
* __PostalCode__
* __PrivateEntrance__
* __PropertyFeatures1__
* __Province__
* __RemarksForClients__
* __Retirement__
* __TotalRooms__
* __RoomsPlus__
* __SaleLease__
* __SellerPropertyInfoStatement__
* __Sewers__
* __SpecialDesignation1__
* __MLSStatus__
* __StreetNum__
* __StreetAbbreviation__
* __StreetDirection__
* __StreetName__
* __Style__
* __TaxYear__
* __Taxes__
* __Type__
* __UFFI__
* __UnitNum__
* __UpdatedTimestamp__
* __UtilitiesCable__
* __UtilitiesGas__
* __UtilitiesHydro__
* __UtilitiesTelephone__
* __Washrooms__
* __Water__
* __WaterIncluded__
* __WaterSupplyTypes__
* __Waterfront__
* __Zoning__
* __Lat__
* __Lon__

### Media
See [Media Functions](#Media-Functions) for complete list of functions available

__$Images__: Loop-able list of related images: See [Media Functions](#Media-Functions). Please see the [SilverStripe Image Documentation](http://doc.silverstripe.org/framework/en/reference/image) for all other image references.

### Other Relations

## Template Functions
### Property Info Functions
Most of the these functions are intended to bring Listing and MLS Listing templates in-line with each other

__$NumberBed__: Returns $Bedrooms and $BedroomsPlus as one entry.

__$NumberBath__: Returns $Washrooms.

__$LotLength__: Returns $LotDepth as an integer

__$LotWidth__: Returns $LotFront	 as an integer

__$LotAcreage__: Returns $Acreage

__$ShowBroker__: Returns $ListBrokerage set in Title Case since many MLS Systems save the data in Uppercase.	

__$Town__: Returns the City Title (if available) or $Municipality

__$Summary__: Returns the fist 20 words of $Content (used in ListingItem.ss)

### Financial
Since all financial data is stored in the system as raw numbers there are few template functions to help render and calculate financial data correctly.

__$FormattedPrice__: returns $Price with dollar symbol and thousand separators.

__$FormattedTax__: returns $Tax with dollar symbol and thousand separators.

__$MonthlyPrice__: Calculates and returns the a formatted monthly prices based on the default down payment percentage ($DefaultDown) and interest rate ($InterestRate) it use default term of 360 months (30 years).

### Relation Functions

__$Rooms__: The room columns from the data provided by MLS is converted into a relation with [Room](room). You can loop through rooms and display all Room data. 

### Media Functions

__$CoverImage__: returns the First Image. Please see the [SilverStripe Image Documentation](http://doc.silverstripe.org/framework/en/reference/image). **TODO** Add a cover image flag to the Image relation to allow the images other than the first to be used as cover.

### Listing Functions
__$RelatedProperties__: Returns own listings in the same city as the current listing. Defaults to 4, but can be overiden
	<% if $RelatedProperties %>
		<% loop $RelatedProperties(6) %>
			_your code_
		<% end_loop %>
	<% end_if %>
**TODO** Abstract so that MLS listings can be optionally included.

## TODO
* Move functions shared with Listing to a separate class to share the code base

