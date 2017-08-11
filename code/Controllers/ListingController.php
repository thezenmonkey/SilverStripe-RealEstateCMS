<?php
/**
 * Created by PhpStorm.
 * User: richardrudy
 * Date: 2017-08-11
 * Time: 6:49 PM
 */

namespace SilverStripeRMS\Controller;

use SilverStripe\Control\Session;
use PageController;

class ListingController extends PageController {

    private static $allowed_actions = array("ContactForm");

    public function init() {
        parent::init();

        if($this->Status == "Unavailable" || $this->Status == "Closed") {
            Session::set("UnavailListing", array("Price" => $this->Price, "Lat" => $this->Lat, "Lon" => $this->Lon, "City" => $this->City, "Town" => $this->Town));
            $redirect = SiteTree::get_by_link("listing-unavailable");
            $this->redirect($redirect->Link(), 301);
            return;
        }
    }

    public function index() {
        if ($this->Status == "Sold") {
            return $this->renderWith(array('SoldListing', 'Listing', 'Page'));
        }
        else return $this->renderWith(array('Listing','Page'));
    }

    public function ContactForm() {
        $form = new ListingRequestForm($this, 'ContactForm');

        if($form->hasExtension('FormSpamProtectionExtension')) {
            $form->enableSpamProtection();
        }

        return $form;
    }

    function RelatedProperties($count = 4) {
        $siteConfig = SiteConfig::current_site_config();

        if($siteConfig->RelatedPriceRange != 0) {
            $varience = $siteConfig->RelatedPriceRange;
        } else {
            $varience = 50000;
        }

        $items = new ArrayList();

        $ownItems = Listing::get()->filter(array(
            "CityID" => $this->CityID,
            "Status" => "Available",
            "Price:LessThan" => $this->Price + 50000,
            "Price:GreaterThan" => $this->Price - 50000
        ))->exclude("ID", $this->ID)->limit($count);

        if($ownItems && $ownItems->count()) {
            $items->merge($ownItems);
        }

        $mlsItems = MLSListing::get()->filter(array(
            "CityID" => $this->CityID,
            "Price:LessThan" => $this->Price + 50000,
            "Price:GreaterThan" => $this->Price - 50000
        ))->limit($count);

        if($mlsItems && $mlsItems->count()) {
            $items->merge($mlsItems);
        }

        if($items->count()) {
            return $items->limit($count);
        } else {
            return false;
        }

    }

}