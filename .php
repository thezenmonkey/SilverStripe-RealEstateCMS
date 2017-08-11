<?php

use SilverStripe\Core\Config\Config;
//Object::add_extension("ListingsPage", "ExcludeChildren");
Config::inst()->update("ListingsPage", "excluded_children", array("Listing"));

//Object::add_extension("SiteConfig", "RealEstateSiteConfig");

