<?php

/**
 *
 * @package RETS System
 * @requires  MLSListing.php phrets.php
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */

class CheckMLSListing  extends BuildTask {
    protected $title = 'Check MLS Listings';

    protected $description = 'Compare MLS Listings on site with MLS';

    protected $enabled = true;

    function run($request) {

        $bridge = Config::inst()->get('RETSUtils', 'Bridge');
        $retLimit = Config::inst()->get('RETSUtils', 'Limit');
        $mlsField = Config::inst()->get('RETSUtils', 'MLSField');

        echo "Using ".$bridge."<br>\n";
        echo "Limit ".$retLimit."<br>\n";
        echo "Key ".$mlsField."<br>\n";

        $clean = array();
        $retsparams[] = '';
        if (Config::inst()->get('RETSUtils', 'UseDDF') == 1) {
            $property_classes = array("Property");
            $useDDF = true;
            $retsparams['Count'] = 1;
        } else {
            $property_classes = array("ResidentialProperty","CondoProperty");
            $useDDF = false;
        }

        $previous_start_time = date("Y-m-d", time() - 60 * 60 * 24)."T00:00:00";
        $query = RETSUtils::BuildRetsQuery('check', $previous_start_time);

        if(!$query) {
            return "FAIL: No Query";
        }

        echo "Query: ".$query."<br>\n";

        $rets = RETSUtils::RetsConnectCheck();

        if(!$rets) {
            return "FAIL: No RETS Connection";
        }


        foreach ($property_classes as $class) {
            echo "+ Property:{$class}<br>\n";

            $search = $rets->SearchQuery("Property", $class, $query, $retsparams);

            if ($rets->NumRows($search) > 0) {
                //$log->Events()->add(RMSLogging::createEvent("RETS returns", $rets->NumRows($search)));
                echo "   + RETS returns". $rets->NumRows($search);
                // print filename headers as first line
                $fields_order = $rets->SearchGetFields($search);

                //Debug::show($fields_order);

                // process results
                while ($record = $rets->FetchRow($search)) {
                    $this_record = array();
                    foreach ($fields_order as $fo) {

                        $this_record[$fo] = $record[$fo];

                    }

                    if($useDDF) {
                        array_push($clean, $record[$retsConfig['retskey']]);
                    } else {
                        array_push($clean, $record[$mlsField]);
                    }
                }

            } else {

                //$log->Events()->add(RMSLogging::createEvent("RETS Fail", implode(" ",$rets->Error()) ));
                print_r($rets->Error());
            }

            echo "    + Total found: {$rets->TotalRecordsFound($search)}<br>\n";



            $rets->FreeResult($search);


            $sqlQuery = new SQLQuery();
            $sqlQuery->setFrom('MLSListing');
            $sqlQuery->setSelect('ID');
            $sqlQuery->addSelect('MLS');
            $sqlQuery->addSelect('SourceKey');

            // Get the raw SQL (optional)
            $rawSQL = $sqlQuery->sql();

            // Execute and return a Query object
            $result = $sqlQuery->execute();
            $deleteList = array();

            $counter = $result->numRecords();
            $i = 0;
            while ($counter > 0) {
                set_time_limit ( 30 );
                $row = $result->nextRecord();


                if($useDDF) {
                            if(!in_array($row['SourceKey'],$clean)) {
                        echo $row['MLS']." Not in list<br>\n";
                        $listing = MLSListing::get()->byID($row['ID']);
                        if ($listing) {
                            echo "listing found<br>\n";
                            $listing->delete();
                            echo "listing deleted<br>\n";
                        }

                    } else {
                        echo $row['MLS']." IS in list<br>\n";
                    }

                } else {

                    if(!in_array($row['MLS'],$clean)) {
                        echo $row['MLS']." Not in list<br>\n";
                        $listing = MLSListing::get()->byID($row['ID']);
                        if ($listing) {
                            echo "listing found<br>\n";
                            $listing->delete();
                            echo "listing deleted<br>\n";
                        } else {
                            echo "Not In System<br>\n";
                        }

                    } else {
                        echo $row['MLS']." IS in list<br>\n";
                    }

                }


                $counter--;
                $i++;
            }

            return "Cleaned ".$i;



        }

    }
}
