<?php

// Expand memory being used by PHP
ini_set('memory_limit','400M');
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();
$now = time();
// echo "discard after: $now<br>";
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}
// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 3600;
// echo "<pre>top of script\n"; print_r($_SESSION);

// Configuration

date_default_timezone_set('America/New_York'); 

if (!file_exists('credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}

// Include libraries added with composer
require 'vendor/autoload.php';
// Include credentials
require 'credentials.inc.php';
// Include parse library
require ('vendor/parse.com-php-library/parse.php');
// Include application functions
require 'functions.inc.php';


update_db("org_hq_country", "blank");
update_db("org_hq_country", "undefined");
update_db("org_hq_country_region_code", "blank");
update_db("org_hq_country_region_code", "undefined");
update_db("org_hq_country_region", "blank");
update_db("org_hq_country_region", "undefined");
update_db("org_hq_country_income_code", "blank");
update_db("org_hq_country_income_code", "undefined");
update_db("org_hq_country_income", "blank");
update_db("org_hq_country_income", "undefined");


function update_db($missing_column, $condition){

  $query = new ParseQuery("org_profile");
  $query->setLimit(1000);

  //$query->whereEqualTo("org_hq_country_income_code", "null");
  if ($condition == "undefined"){
    echo $missing_column . " for undefined." . "<br>";
    $query->whereEqualTo($missing_column, "");
  } elseif ($condition == "blank") {
    echo $missing_column . " for undefined." . "<br>";
    $query->whereDoesNotExist($missing_column);
  }

  $results = $query->find();


  $element = array();
  $i=0;
  foreach ($results as $object){
    foreach($object as $obj){  	
      $wb_region = addWbRegions($obj->org_hq_country_locode);
      
      $element[$obj->objectId] = array(
        "org_hq_country" => $wb_region['org_hq_country_name'],
        "org_hq_country_locode" => $obj->org_hq_country_locode,
        'org_hq_country_region' => $wb_region['org_hq_country_region'],
        'org_hq_country_region_code' => $wb_region['org_hq_country_region_code'],
        'org_hq_country_income' => $wb_region['org_hq_country_income'],
        'org_hq_country_income_code' => $wb_region['org_hq_country_income_code'],
      );

      echo $obj->objectId;    
      echo '<br>';
    }
    $i++;
    if ($i == 1000) break;
  }
  echo '<br>';

  if (sizeof($element)==0){
    echo "No data to update <br>";    
  }

  $count = 0;

  foreach ($element as $key=>$value){

    $parse = new ParseObject('org_profile');
    $parse->__set('objectId', $key);
    $parse->__set('org_hq_country', $value["org_hq_country"]);
    $parse->__set('org_hq_country_locode', $value["org_hq_country_locode"]);
    $parse->__set('org_hq_country_region', $value["org_hq_country_region"]);
    $parse->__set('org_hq_country_region_code', $value["org_hq_country_region_code"]);
    $parse->__set('org_hq_country_income', $value["org_hq_country_income"]);
    $parse->__set('org_hq_country_income_code', $value["org_hq_country_income_code"]);
    $request = $parse->update($key);
    $count++;
  }


  echo $missing_column . ": " . strval($count) . " complete<br>";
  echo '<br>';
}


?>