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

// update_db("org_hq_country", "blank", 0);
// update_db("org_hq_country", "undefined", 0);
// update_db("org_hq_country_region_code", "blank", 0);
// update_db("org_hq_country_region_code", "undefined", 0);
// update_db("org_hq_country_region", "blank", 0);
// update_db("org_hq_country_region", "undefined", 0);
// update_db("org_hq_country_income_code", "blank", 0);
// update_db("org_hq_country_income_code", "undefined", 0);
// update_db("org_hq_country_income", "blank", 0);
// update_db("org_hq_country_income", "undefined", 0);
// update_db("org_hq_country_locode", "defined", 0);
// update_db("org_hq_country_locode", "defined", 1);
// update_db("org_hq_country_locode", "defined", 2);
// update_db("org_hq_country_locode", "defined", 3);

// flatfile_update_db("org_hq_country", "blank", 0);
// flatfile_update_db("org_hq_country", "undefined", 0);
// flatfile_update_db("org_hq_country_region_code", "blank", 0);
// flatfile_update_db("org_hq_country_region_code", "undefined", 0);
// flatfile_update_db("org_hq_country_region", "blank", 0);
// flatfile_update_db("org_hq_country_region", "undefined", 0);
// flatfile_update_db("org_hq_country_income_code", "blank", 0);
// flatfile_update_db("org_hq_country_income_code", "undefined", 0);
//flatfile_update_db("org_hq_country_income", "blank", 0);
// flatfile_update_db("org_hq_country_income", "undefined", 0);
flatfile_update_db("org_hq_country_locode", "defined", 0);
flatfile_update_db("org_hq_country_locode", "defined", 1);
flatfile_update_db("org_hq_country_locode", "defined", 2);
flatfile_update_db("org_hq_country_locode", "defined", 3);


function flatfile_update_db($missing_column, $condition, $loop){

  $query = new ParseQuery("arcgis_flatfile");
  $query->setLimit(500);
  $query->setSkip($loop * 500);

 
  if ($condition == "undefined"){
    echo $missing_column . " for undefined." . "<br>";
    $query->whereEqualTo($missing_column, "");
  } elseif ($condition == "blank") {
    echo $missing_column . " for not exist." . "<br>";
    $query->whereDoesNotExist($missing_column);
  } elseif ($condition == "defined") {
    echo $missing_column . " for defined." . "<br>";
    $query->whereExists($missing_column);
  }

  $results = $query->find();

  $need_update = FALSE;
  $element = array();
  $i=0;

  foreach ($results as $object){
    foreach($object as $obj){   
      $wb_region = addWbRegions($obj->org_hq_country_locode);
      
      if (!isset($obj->org_hq_country_locode) or $obj->org_hq_country_locode=="") continue;      

      if ((!isset($obj->org_hq_country) || $obj->org_hq_country=="") or (!isset($obj->org_hq_country_region) || $org_hq_country_region=="") or
        (!isset($obj->org_hq_country_region_code) || $org_hq_country_region_code=="") or (!isset($obj->org_hq_country_income) || $obj->org_hq_country_income=="") or
        (!isset($obj->org_hq_country_income_code) || $obj->org_hq_country_income_code=="") ){
        
        $element[$obj->objectId] = array(        
          "org_hq_country_locode" => $obj->org_hq_country_locode,
        );
      
        $element[$obj->objectId]["org_hq_country"] = $wb_region['org_hq_country_name'];
        $element[$obj->objectId]["org_hq_country_region"] = $wb_region['org_hq_country_region'];    
        $element[$obj->objectId]["org_hq_country_region_code"] = $wb_region['org_hq_country_region_code'];  
        $element[$obj->objectId]["org_hq_country_income"] = $wb_region['org_hq_country_income'];  
        $element[$obj->objectId]["org_hq_country_income_code"] = $wb_region['org_hq_country_income_code'];   
        $need_update = TRUE;             
      }

      if ($need_update){
        echo $obj->objectId;    
        echo '<br>';
      }
      $i++;
      if ($i == 500) break;
    }
    print("hello");
  }
  echo '<br>';

  if (sizeof($element)==0){
    echo "No data to update <br>";    
  }

  if ($need_update){
    $count = 0;

    foreach ($element as $key=>$value){

      $parse = new ParseObject('arcgis_flatfile');
      $parse->__set('objectId', $key);
      $parse->__set('org_hq_country', $value["org_hq_country"]);
      $parse->__set('org_hq_country_locode', $value["org_hq_country_locode"]);
      $parse->__set('org_hq_country_region', $value["org_hq_country_region"]);
      $parse->__set('org_hq_country_region_code', $value["org_hq_country_region_code"]);
      $parse->__set('org_hq_country_income', $value["org_hq_country_income"]);
      $parse->__set('org_hq_country_income_code', $value["org_hq_country_income_code"]);
      $request = $parse->update($key);
      $count++;
      usleep(500);
    }


    echo $missing_column . ": " . strval($count) . " completed<br>";
    echo '<br>';
  }
}

/* For "org_profile" table */
function update_db($missing_column, $condition, $loop){

  $query = new ParseQuery("org_profile");
  $query->setLimit(500);
  $query->setSkip($loop * 500);

 
  if ($condition == "undefined"){
    echo $missing_column . " for undefined." . "<br>";
    $query->whereEqualTo($missing_column, "");
  } elseif ($condition == "blank") {
    echo $missing_column . " for undefined." . "<br>";
    $query->whereDoesNotExist($missing_column);
  } elseif ($condition == "defined") {
    echo $missing_column . " for defined." . "<br>";
    $query->whereExists($missing_column);
  }

  $results = $query->find();

  $need_update = FALSE;
  $element = array();
  $i=0;

  foreach ($results as $object){
    foreach($object as $obj){  	
      $wb_region = addWbRegions($obj->org_hq_country_locode);
      
      if (!isset($obj->org_hq_country_locode) or $obj->org_hq_country_locode=="") continue;

      if (!isset($obj->org_hq_country) && !isset($obj->org_hq_country_region) && !isset($obj->org_hq_country_region_code) &&
        !isset($obj->org_hq_country_income) && !isset($obj->org_hq_country_income_code)) {
        $element[$obj->objectId] = array(        
          "org_hq_country_locode" => $obj->org_hq_country_locode,
        );
        $element[$obj->objectId]["org_hq_country"] = $wb_region['org_hq_country_name'];          
        $element[$obj->objectId]["org_hq_country_region"] = $wb_region['org_hq_country_region'];                   
        $element[$obj->objectId]["org_hq_country_region_code"] = $wb_region['org_hq_country_region_code'];          
        $element[$obj->objectId]["org_hq_country_income"] = $wb_region['org_hq_country_income'];               
        $element[$obj->objectId]["org_hq_country_income_code"] = $wb_region['org_hq_country_income_code'];   
        $need_update = TRUE;       
      }

      if ($need_update){
        echo $obj->objectId;    
        echo '<br>';
      }
      $i++;
      if ($i == 500) break;
    }
    
  }
  echo '<br>';

  if (sizeof($element)==0){
    echo "No data to update <br>";    
  }

  if ($need_update){
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
      usleep(500);
    }


    echo $missing_column . ": " . strval($count) . " completed<br>";
    echo '<br>';
  }
}


?>