<?php
	
class HomePageAdmin extends SinglePageAdmin {
    private static $menu_title = "Home Page";
    private static $tree_class = 'HomePage';
    private static $url_segment = "home-page";

}

/*
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
*/

class ListingsPageAdmin extends SinglePageAdmin {
    private static $menu_title = "Listings Page";
    private static $tree_class = 'ListingsPage';
    private static $url_segment = "listings-page";
    static $menu_icon = 'realestate/images/home.png';
}

class CommunitiesAdmin extends SinglePageAdmin {
    private static $menu_title = "Communities";
    private static $tree_class = 'CommunitiesHolder';
    private static $url_segment = "communities-page";
    //static $menu_icon = 'realestate/images/home.png';
}

class BlogAdmin extends SinglePageAdmin {
    private static $menu_title = "Blog";
    private static $tree_class = 'Blog';
    private static $url_segment = "blog-admin";
    //static $menu_icon = 'realestate/images/home.png';
}