# prprtes Listings Page (listing holder)

## Introduction
The Listings Page is the main holder for the listing system, it is used as an index of all [Listings](listing) and as the show page for [MLS Listings](mls-listing)
*source:* ListingsPage.php
*extends:* DataObjectAsPageHolder

## Default Record
On dev/build a ListingsPage with the $Title "Listings" and the $URLSegment "listings'. The title can be changed but the URL Segment needs to remain the same.

## Model
__$Title__: Page Title

__$Content__: HTML Content

## Template Functions
__$GetCities__: Returns a loop-able of array of all MunicipalityPages in the system. This allows the grouping of listings by City on the page. Listing should then be called from their City Relation.

__$AvailableListings__: Returns all Available Listings (Status = Available). Featured listings show first in descending creation order, followed by the remaining listings in descending order.

__$SoldListings__: Returns all Sold Listings (Status = Sold) in descending order.

__$ClosedListings__: Returns all Closed Listings (Status = Closed) in descending order.

__$AllListings__: Returns all Listings marked Available or Sold (Status = Available || Sold), see $AvailableListings for sort order.

__$MLSListings__: Returns the specified number of MLS Listings. (Default = 10). A $count can be passed using $MLSListings($count).

__$FeaturedMLSListings__: Returns a loop-able array of MLS Listings marked as Featured. Also takes and optional $count variable: $FeaturedMLSListings($count).