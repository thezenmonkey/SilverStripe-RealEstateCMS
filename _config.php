<?php

Director::addRules(50, array('rets' => 'RETS_Controller', 'maintenance' => 'RMSMaintenance'));
LeftAndMain::require_css('RealEstate/css/realestatecms.css');
LeftAndMain::require_css('RealEstate/css/jquery.mobile.flatui.css');
LeftAndMain::require_css('http://fonts.googleapis.com/css?family=Lato:300,700,100italic');

Config::inst()->update("ListingsPage", "excluded_children", array("Listing"));