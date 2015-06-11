<?php
	
class HomePageAdmin extends SinglePageAdmin {
    private static $menu_title = "Home Page";
    private static $tree_class = 'HomePage';
    private static $url_segment = "home-page";

}

class ContactUsAdmin extends SinglePageAdmin {
    private static $menu_title = "Contact";
    private static $tree_class = 'Page';
    private static $url_segment = "contact";

}

class AboutUsAdmin extends SinglePageAdmin {
    private static $menu_title = "About Us";
    private static $tree_class = 'Page';
    private static $url_segment = "about-us";

}

class ListingsAdmin extends SinglePageAdmin {
    private static $menu_title = "Listings";
    private static $tree_class = 'ListingsPage';
    private static $url_segment = "listings-page";
    static $menu_icon = 'realestate/images/home.png';

}