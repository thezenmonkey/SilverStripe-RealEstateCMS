<?php

namespace SilverStripeRMS\Controller;

use SilverStripe\ORM\FieldType\DBDate;
use PageController;

class HomePageController extends PageController
{
    public function init() {

        parent::init();
    }

    public function FeaturedPost(){
        return $post = BlogEntry::get()->filter(array("IsFeatured" => 1))->sort(DBDate::class, "ASC")->First() ? $post : false;
    }


    public function LatestPosts($count = 6){
        $post = BlogEntry::get()->sort(DBDate::class, "DESC");

        if(is_null($count)) {
            return $post->count() ? $post : false;
        }  else {
            return $post->count() ? $post->limit($count) : false;
        }
    }

    public function GetTestimonial() {
        return $testimonial = Testimonial::get()->sort("Created", "DESC")->First() ? $testimonial : false;
    }

    public function FeaturedHomes($count = null) {

        $listings = Listing::get()->filter(array("Status" => "Available", "Feature" => 1));

        if(is_null($count)) {
            return $listings->count() ? $listings : false;
        }  else {
            return $listings->count() ? $listings->limit($count) : false;
        }
    }



}