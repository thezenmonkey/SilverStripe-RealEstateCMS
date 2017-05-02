<?php

class RETSUtils extends Object {

//    public static function getRetsConfig() {
//        $config = array (
//            "loginURL"		=> self::config()->LoginURL,
//            "bridge"		=> self::config()->RETSBridge,
//            "limit"			=> self::config()->MLSLimit,
//            "retskey"		=> self::config()->KeyField,
//            "mlsfield"		=> self::config()->MLSField,
//            "photosize"		=> self::config()->PhotoSize,
//            "useDDF"		=> self::config()->UseDDF,
//            "loginall"		=> self::config()->LoginAll,
//            "loginupdate"	=> self::config()->LoginUpdate,
//            "password" 		=> self::config()->Password
//        );
//
//        return $config;
//    }

    public static function RetsConnectUpdate() {
        $rets_username = Config::inst()->get('RETSUtils', 'LoginUpdate');

        $rets = self::getRetsConnection($rets_username);;

        Debug::show($rets);
        return $rets;
    }

    public static function RetsConnectAll() {
        $rets_username = Config::inst()->get('RETSUtils', 'LoginUpdate');
        $previous_start_time = date("Y-m-d", time() - 60 * 60 * 24 * 356 * 2)."T00:00:00";

        return self::getRetsConnection($rets_username);
    }

    public static function RetsConnectCheck() {
        $rets_username = Config::inst()->get('RETSUtils', 'LoginAll');

        return self::getRetsConnection($rets_username);
    }

    public static function RetsConnectQuick() {
        $rets_username = Config::inst()->get('RETSUtils', 'LoginAll');
        $previous_start_time = date("Y-m-d")."T".date("H:i:s", time() - 60 * 60 * 3);

        return self::getRetsConnection($rets_username);
    }


    public static function getRetsConnection($rets_username) {



        $rets_password = Config::inst()->get('RETSUtils', 'Password');

        $retsparams = null;


        // start rets connection
        $rets = new phRETS;

        // only enable this if you know the server supports the optional RETS feature called 'Offset'
        $rets->SetParam("offset_support", true);

        $loginURL = Config::inst()->get('RETSUtils', 'LoginURL');

        echo "+ Connecting to {$loginURL} as {$rets_username}<br>\n";
        $connect = $rets->Connect($loginURL, $rets_username, $rets_password);

        if ($connect) {
            echo "  + Connected<br>\n";
        } else {
            echo "  + Not connected:<br>\n";
            print_r($rets->Error());
            exit;
        }

        return $rets;

    }

    public static function BuildRetsQuery($query_type = null, $previous_start_time) {

        if(!$query_type) {
            return false;
        }

        echo "+ Yesterday {$previous_start_time}<br>\n";

        if (Config::inst()->get('RETSUtils', 'UseDDF') == 1) {
            $useDDF = true;
        } else {
            $useDDF = false;
        }

        $config = SiteConfig::current_site_config();
        if(!$useDDF) {
            if($config->MLSMax != 0) {
                $minVal = $config->MLSMin;
                $maxVal = $config->MLSMax;
            } else {
                echo "Please configure MLS Defaults in Site Settings";
                return false;
            }
        }


        if($query_type == "all") {

            //$query = "(status = A),(lp_dol = $minVal-$maxVal),(s_r = Sale)";
            //$query = array("Limit" => 1, "Format" => "STANDARD-XML", "Count" => 1);
            if($useDDF) {
                $query = "(LastUpdated=" . date('Y-m-d', strtotime("-1 year")) . ")";
            } else {
                $query = "(Status = A)";
            }


        } elseif ($query_type == "check") {

            if($useDDF) {
                $query = "(ID=*)";
            } else {
                $query = "(Status = A)";
            }


        } else {

            if($useDDF) {
                $query = "(LastUpdated=" . date('Y-m-d', strtotime("yesterday")) . ")";
            } else {
                $query = "(timestamp_sql = {$previous_start_time}+),(lp_dol = $minVal-$maxVal),(s_r = Sale)";
            }


        }

        return $query;


    }


    /**
     * Create new MLS Listing Object
     *
     * @param $MLSRecord array - should contain the RETS record from the board
     * @param $class string - RETS property class for the record
     * @param $board string - Realeste Board Name (included just incase the system needs to handle multiple board confiurations)
     * @param $mlsField string - Key Listing ID feild for the Database (MLS Number)
     * @return array(MLSListing ID => MLISLISTING MLS Number)
     *
     * @todo clean up unused fields from Property classes and fix concacted values to check source feild isn't blank before adding to target
     *
     *
     *
     */


    public static function createMLSListing($MLSRecord, $class, $board, $mlsField) {

        echo "+ MLS  = ".$MLSRecord[$mlsField].Listing::get()->filter(array("MLS:PartialMatch" => $MLSRecord[$mlsField]))->count()." ".Listing::get()->filter(array("AdditionalMLS:PartialMatch" => $MLSRecord[$mlsField]))->count()."<br>\n";

        //check if own listing exists
        if(!Listing::get()->where("MLS = '".$MLSRecord[$mlsField]."'")->count() && !Listing::get()->filter(array("AdditionalMLS:PartialMatch" => $MLSRecord[$mlsField]))->count()) {
            if (!MLSListing::get()->filter("MLS", $MLSRecord[$mlsField])->count()) {
                echo "+ New MLSListing <br>\n";
                $MLSListing = new MLSListing();
                $listState = "new";
            } else {
                $stageMLSListing = MLSListing::get()->filter("MLS", $MLSRecord[$mlsField])->First();

                if($stageMLSListing->isVersioned) {
                    $MLSListing = Versioned::get_by_stage('MLSListing', 'Live')->byID($stageMLSListing->ID);
                } else {
                    $MLSListing = $stageMLSListing;
                }

                echo "+ Found MLSListing ".$MLSListing->ID." <br>\n";
                $listState = "old";
            }
        } else {
            echo "+ Own Listing <br>\n";
            return false;
        }


        $MLSlisting = $board::Convert($MLSListing, $class, $MLSRecord);
        $roomArray = $board::generateRoomArray($MLSRecord);

        $listingCity = Convert::raw2sql($MLSListing->Municipality);
        $listingHood = Convert::raw2sql($MLSListing->Community);
        $listingStatus = $MLSListing->MLSStatus;


        // Link MLS Listing to Existing Cities and Neighbourhoods

        $city = DataObject::get_one('MunicipalityPage', "Title = '".$listingCity."'");

        if($city) {
            $MLSListing->CityID = $city->ID;
        } else {
            $sqlQuery = new SQLQuery();
            $sqlQuery->setFrom('Listing');
            $sqlQuery->selectField('Town');
            $sqlQuery->setDistinct(true);
            $result = $sqlQuery->execute();
            $townList = array();
            foreach($result as $row){
                array_push($townList, $row['Town']);
            }

            $filterList = (array_filter($townList));
            $city = MunicipalityPage::get()->where("Title = 'Rural Communities'")->First();
            if($city){
                in_array($listingCity, $filterList) ? $MLSListing->CityID = $city->ID : false;
            }
        }
        if($MLSListing->CityID != 0){
            $hood = NeighbourhoodPage::get()->where("Title = '".$listingHood."'")->First();
            if($hood){
                $MLSlisting->NeighbourhoodID = $hood->ID;
            }
        }

        // check that the listing is avaialble
        if ($MLSListing->MLSStatus == "U") {
            echo "+ Now Unavailable <br>\n";
            if($listState == "new") {
                return false;
            } else {
                echo "+ Deleting Listing <br>\n";
                $MLSListing->delete();
                return false;
            }
        }

        // write listing (added destroy)
        if($MLSListing->isVersioned) {
            if($listState == "new") {
                echo "+ Writing MLSListing <br>\n";
                $MLSListing->Status = "Published";

                $MLSListing->write();
                $mlsID = $MLSListing->ID;
                $MLSListing->destroy();
            } else {
                echo "+ Writing Without Version MLSListing <br>\n";
                $MLSListing->write();
                $mlsID = $stageMLSListing->ID;
                $MLSListing->destroy();
            }
        } else {
            echo "+ Writing Unversioned MLSListing <br>\n";
            $MLSListing->write();
            $mlsID = $MLSListing->ID;
            $MLSListing->destroy();
        }


        //create Room() for new listings
        if($listState == "new") {
            self::createRooms($roomArray, $mlsID);
        }


        if($listState == "new" && $MLSListing->isVersioned) {
            $MLSListing->publish('Stage', 'Live');
        }

        // if its a new listing pass back MLS number for ImageUpdate function
        if($listState =="new") {
            return array($mlsID, $MLSListing->SourceKey, $MLSListing->PixUpdatedDate);
        } else {
            return false;
        }

    }


    /**
     * Create Rooms for New Listing
     *
     * @param $roomArray List of Rooms from the MLS Object
     * @param $mlsID ID of MLSListing Object
     */

    public static function createRooms($roomArray = null, $mlsID = null) {
        if($roomArray) {
            foreach($roomArray as $room) {
                //$listingRoom = new Room();

                $roomName = key($room);

                if (!Room::get()->filter(
                    array(
                        "MLSListingID" => $mlsID,
                        "Name" => $roomName,
                        "Level" => $room[$roomName]['level'],
                        "Width" => $room[$roomName]['width'],
                        "Length" => $room[$roomName]['length']
                    )
                )->count()) {
                    $listingRoom = new Room();
                } else {
                    $listingRoom = Room::get()->filter(
                        array(
                            "MLSListingID" => $mlsID,
                            "Name" => $roomName,
                            "Level" => $room[$roomName]['level'],
                            "Width" => $room[$roomName]['width'],
                            "Length" => $room[$roomName]['length']
                        )
                    )->First();
                }


                $listingRoom->Name = $roomName;
                $listingRoom->Level = $room[$roomName]['level'];
                $listingRoom->Width = $room[$roomName]['width'];
                $listingRoom->Length = $room[$roomName]['length'];
                $listingRoom->Note = $room[$roomName]['desc'];

                $listingRoom->MLSListingID = $mlsID;
                echo "Writing ".$roomName."<br>\n";
                $listingRoom->write();
                $listingRoom->destroy();

            }


        }

    }


    public static function ImageUpdate() {
        global $_RETS_SERVER_INFO;
        $rets_login_url = self::config()->LoginURL;
        $params = Controller::getURLParams();
        if($params['ID'] == "all"){
            $rets_username = self::config()->LoginAll;
            $previous_start_time = date("Y-m-d", time() - 60 * 60 * 24 * 356 * 2)."T00:00:00";
        } elseif ($params['ID'] == "update"){
            $rets_username = self::config()->LoginUpdate;
            $previous_start_time = date("Y-m-d", time() - 60 * 60 * 24)."T00:00:00";
            //$previous_start_time = "2012-10-10T00:00:00";
        } else {
            return "Invalid Parameter";
        }
        $rets_password = $_RETS_SERVER_INFO['PASSWORD'];

        echo "+ Yesterday {$previous_start_time}<br>\n";

        //$previous_start_time = "2012-09-31T00:00:00";

        // use http://retsmd.com to help determine the SystemName of the DateTime field which
        // designates when a record was last modified
        $rets_modtimestamp_field = "timestamp_sql";

        // use http://retsmd.com to help determine the names of the classes you want to pull.
        // these might be something like RE_1, RES, RESI, 1, etc.
        $property_classes = array("ResidentialProperty","CondoProperty");


        //////////////////////////////

        $rets = new phRETS;
        // only enable this if you know the server supports the optional RETS feature called 'Offset'
        $rets->SetParam("offset_support", true);

        echo "+ Connecting to {$rets_login_url} as {$rets_username}<br>\n";
        $connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);

        if ($connect) {
            echo "  + Connected<br>\n";
        }
        else {
            echo "  + Not connected:<br>\n";
            print_r($rets->Error());
            exit;
        }

        $MLSListings = MLSListing::get();

        echo " + ".$MLSListings->count()." Listings<br>\n";


        foreach ($MLSListings as $MLSlisting) {
            if($MLSlisting->PixUpdateDate >= $previous_start_time) {
                echo "<br>\n  +Photos Updated:<br>\n";
            }

            if(!$MLSlisting->Images()->count()) {
                echo "<br>\n  +No Images:<br>\n";
            }


            if(!$MLSlisting->Images()->count() || $MLSlisting->PixUpdateDate >= $previous_start_time) {
                echo "  + MLS: ".$MLSlisting->MLS."<br>\n";
                $photos = $rets->GetObject("Property", "Photo", $MLSlisting->MLS, "*", 0);


                if(count($photos) > 0) {
                    foreach ($photos as $photo) {

                        if(
                            (!isset($photo['Content-ID']) || !isset($photo['Object-ID']))
                            ||
                            (is_null($photo['Content-ID']) || is_null($photo['Object-ID']))
                            ||
                            ($photo['Content-ID'] == 'null' || $photo['Object-ID'] == 'null')
                        ) {
                            continue;
                        }


                        $listing = $photo['Content-ID'];
                        $number = $photo['Object-ID'];
                        echo "  + Photo ". $photo['Object-ID'].":<br>\n";
                        if ($photo['Success'] == true) {
                            file_put_contents("../assets/Homes/MLS/image-{$listing}-{$number}.jpg", $photo['Data']);
                            echo "  + writing image-{$listing}-{$number}.jpg:<br>\n";
                            if(!Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->count()){
                                $image = new Image();
                                $image->Filename = "assets/Homes/MLS/image-{$listing}-{$number}.jpg";
                                $image->Title = "{$listing}-{$number}";
                                $image->MLSListingID = $MLSlisting->ID;
                                $folder = Folder::get()->filter("Filename","assets/Homes/MLS/")->First();
                                $image->ParentID = $folder->ID;
                                echo "  + Creating image-{$listing}-{$number} Listing Image:<br>\n";
                                if($number == 1) {
                                    $image->Cover = 1;
                                }
                                $image->write();
                                $image->destroy();
                            } elseif (Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->First()->MLSListingID != $MLSlisting->ID) {
                                echo "+ getting image object <br>/n";
                                $image = Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->First();
                                echo "+ ID set to".$MLSlisting->ID." <br>/n";
                                $image->MLSListingID = $MLSlisting->ID;
                                if($number == 1) {
                                    $image->Cover = 1;
                                }
                                $image->write();
                                $image->destroy();
                            }
                        }
                        else {
                            echo "({$listing}-{$number}): {$photo['ReplyCode']} = {$photo['ReplyText']}\n";
                        }
                    }

                }
            }


        }



        echo "+ Disconnecting<br>\n";
        $rets->Disconnect();

    }


    public static function MLSImageUpdate($listingArray, $rets, $photoSize) {
        echo "  - Getting Images<br>\n";
        //Debug::show($listingArray);
        foreach($listingArray as $listingItem) {
            if(is_array($listingItem)) {

                if( strtotime($listingItem[2])  >= date("Y-m-d", time() - 60 * 60 * 24)) {
                    // Debug::show($listingItem);
                    $photos = $rets->GetObject("Property", $photoSize, $listingItem[1], "*", 0);
                    // Debug::show($photos);

                    foreach ($photos as $photo) {
                        set_time_limit ( 0 );
                        $listing = $photo['Content-ID'];
                        $number = $photo['Object-ID'];
                        echo "  + Photo ". $photo['Object-ID'].":<br>\n";
                        if ($photo['Success'] == true) {
                            file_put_contents("../assets/Homes/MLS/image-{$listing}-{$number}.jpg", $photo['Data']);
                            echo "  + writing image-{$listing}-{$number}.jpg:<br>\n";
                            if(!Image::get()->filter("Filename", "assets/Homes/MLS/image-{$listing}-{$number}.jpg")->count()){
                                $image = new Image();
                                $image->Filename = "assets/Homes/MLS/image-{$listing}-{$number}.jpg";
                                $image->Title = "{$listing}-{$number}";
                                $image->MLSListingID = $listingItem[0];
                                $folder = Folder::get()->filter("Filename","assets/Homes/MLS/")->First();
                                $image->ParentID = $folder->ID;
                                if($number == 1) {
                                    $image->Cover = 1;
                                }
                                $image->write();
                                $image->destroy();
                            }

                        }
                        else {
                            echo "({$listing}-{$number}): {$photo['ReplyCode']} = {$photo['ReplyText']}\n";
                        }
                    }

                }

            }
        }

    }

    public static function FixNeighbourhoods($option) {
        echo "  + Fixing Neighbourhoods:<br>\n";
        $listings = MLSListing::get()->filter(array("CityID:GreaterThan" => 0, "NeighbourhoodID" => 0));

        foreach($listings as $listing) {
            echo "  + MLS ". $listing->MLS.":<br>\n";
            echo "  + City ". $listing->City()->Title.":<br>\n";
            echo "  + Hood ". $listing->Community.":<br>\n";
            $hoodTitle = $listing->City()->Title." - ".$listing->Community;
            $hood = Neighbourhood::get()->where("MetaTitle = '$hoodTitle'")->First();
            if($hood){
                echo " + Found ". $hood->Title;
                $listing->NeighbourhoodID = $hood->ID;
                $listing->write();
            }

        }

    }


    public static function FixStreets() {
        $listings = Listing::get();

        foreach($listings as $listing) {
            if ( is_null($listing->Street) ) {
                echo "  + needs street<br>\n";
                $listing->Street = trim(str_replace(range(0,9),'',$listing->Address));
                echo "  + ".$listing->Street."<br><br>\n";
                $listing->write();
            } else {
                echo "  + has street<br>\n";
            }


        }
    }




}