# prprtes Listing System
## Introduction
The listing is system is built up of a number of key Page Types, Data Objects, Data Extension and Controllers.

### Page Types
* [Listing](1-Page-Types/listing): Contains the bulk of the information for the Agent's own listings
* [Listings Page](1-Page-Types/listings-page): Holder page for Listings and MLSListings
* [Unavailable Listing](1-Page-Types/unavailable-listing): Subclass of [Listing](1-Page-Types/listing) used after listing is no longer available (deal closed or taken off market)
* [Unavailable Listing Page](1-Page-Types/unavailable-listing-page): Page type that [Unavailable Listings](1-Page-Types/unavailable-listing) redirect to. Old listings are kept in the site tree for SEO purposes.
* [Map Page](1-Page-Types/map-page): displays a customizable map of listings in the system.

### Data Objects
* [MLS Listing](mls-listing): Listing downloaded form MLS are kept outside of the site tree. Mostley because of the high turn over, we don't want to index them in the site tree.
* [Room](room): used by both [Listing](1-Page-Types/listing) and [MLS Listing](mls-listing) to store measurements of rooms. The added bonus is that an agent can match rooms with pictures for added metadata.
* [Open House Date](open-house-date): Subclass of [Extra Data](../misc/etxra-data). Stores open house data so that open houses can be easier searched and filtered in the system.
### Controllers
* [RMS Controller](rms-controller): Utility controller that stores various shared functions for the listing system.
* [RETS Controller](refs-controller): Main controller used to download [MLS Listings](mls-listing) from and IDX Feed. It implements [phRETS](https://github.com/troydavisson/PHRETS), and open source RETS/IDX interface.
### Utilities
* [Geocoder](geocoded): Used to geocode properties using the Google Maps API
* [Listing Utilities](listing-utils): Shared listing system functions that don't need to be exposed to the front end via a controller. Mostly used to store search and filter functions.
### Model Admin
* [Listing Admin](listing-admin): Custom Admin to manage listing outside of the standard site tree
### Bridges
The RETS controller is abstracted to allow for easy swapping of bridges to interface with different Real Estate Boards. Currently configured bridges:
* [TREB](treb-convert): Toronto Real Estate Board IDX feed