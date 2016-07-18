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
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
define("ERROR_LOG_FILE", "/tmp/php-error.log");
ini_set("error_log", ERROR_LOG_FILE);
date_default_timezone_set('America/New_York'); 

if (!file_exists('credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}

// make sure log directory exists and is owned by apache
define("ODESURVEY_LOG", "/var/log/odesurvey/odesurvey.log");

if (!file_exists(ODESURVEY_LOG)) {
	echo "My log file directory ".ODESURVEY_LOG." is missing!";
	exit;
}
$fileinfo = posix_getpwuid(fileowner(ODESURVEY_LOG));
if ($fileinfo['name'] != "apache") {
	echo "My log file ".ODESURVEY_LOG." is is not owned by Apache!";
	exit;
} 

// Set if sending email is on
define("SEND_MAIL", false);

// Include libraries added with composer
require 'vendor/autoload.php';
// Include credentials
require 'credentials.inc.php';
// Include parse library
require ('vendor/parse.com-php-library_v1/parse.php');
// Include application functions
require 'functions.inc.php';
// Use Mailgun
use Mailgun\Mailgun;

# Use Amazon Web Services Ec2 SDK to interact with EC2 instances
# use Aws\Ec2\Ec2Client;
 
// Functions
//-------------------------------
function TempLogger($message) {
	error_log( "Logger $message" );
}

// Set up basic logging using slim built in logger
// NOTE: Makes sure /var/log/odesurvey/ directory exists and owned by apache:apache
$logWriter = new \Slim\LogWriter(fopen(ODESURVEY_LOG, 'a'));

// Start Slim instance
//-------------------------------
$app = new \Slim\Slim(array('log.writer' => $logWriter));

// Handle not found
$app->notFound(function () use ($app) {

	// Temporarily route /map, /map/viz to /map.html
	$actual_link = "$_SERVER[REQUEST_URI]";
	if ("/map/index.html" == "$actual_link" || "/map/viz/index.html" == "$actual_link") {
		$app->redirect("/map.html");
	}

	// Let's make sure we remove a trailing "/" on any not found paths
        $actual_link = rtrim($actual_link, '/');
        
	// Any change to below array must also be made to identical array in route "/" around line 210
	if (in_array($actual_link, array("/about", "/contact", "/convene", "/implement", "/map", "/open-data-roundtables" ))) {
		echo "in array";
		$app->redirect($actual_link.".html");
	}

    $app->redirect('/404.html');
});


// ************
$app->get('/map/', function () use ($app) {
// echo "route '/'";exit;
    $app->redirect("http://www.opendataenterprise.org/map.html");

});


//-----------------------------------------------------
// display placeholder landing page
$app->get('/info', function () use ($app) {

    $paramValue = $app->request->get('param');
    
    $content['title'] = "ODE Survery Studies";
    $content['intro'] = <<<HTML
		<p>Home ODE Survey Studies</p>
HTML;

	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_start.php');

});

// ************
$app->get('/admin/login/', function () use ($app) {
	
    $content['title'] = "Open Data Impact Map Admin";
    $content['intro'] = <<<HTML
		<p>Open Data Impact Map Admin</p>
HTML;

	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	$app->render('admin/tp_login.php');
    
});

// ************
$app->post('/admin/login/', function () use ($app) {

	echo "route to login";
	return true;
    
});

// ************
$app->get('/admin/protected/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) {
		// echo "<br> no username";
		$app->redirect("/map/survey/admin/login/");
	}

    $paramValue = $app->request->get('param');
    
    $content['title'] = "ODE Survery Studies";
    $content['intro'] = <<<HTML
		<p>Home ODE Survey Studies</p>
HTML;

	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	$app->render('admin/tp_admin_home.php');

});

// ************
$app->get('/admin/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) {
		// echo "<br> no username";
		$app->redirect("/map/survey/admin/login/");
	}

	echo "<br><br>This is a protected route/path/page";
	return true;
});

// ************
$app->get('/admin/logout/', function () use ($app) {

	session_unset();
	session_destroy();
	$app->redirect("/map/survey/admin/login/");

});

// ************
$app->get('/index.html', function () use ($app) {
	// Route /map/survey/index.html to /start/
    $app->redirect("/map/survey/start/");

});

// ************
$app->get('/', function () use ($app) {
	
	$actual_link = "$_SERVER[REQUEST_URI]";
	
	// Let's make sure we remove a trailing "/" on any not found paths
        $actual_link = rtrim($actual_link, '/');

	// Any change to below array must also be made to identical array in route "/" around line 91
	if (in_array($actual_link, array("/about", "/contact", "/convene", "/implement", "/map", "/open-data-roundtables" ))) {
		echo "in array";
		$app->redirect($actual_link.".html");
	}

    $app->redirect("index.html");

});

// ************
$app->get('', function () use ($app) {
// echo "route ''";exit;
    $app->redirect("index.html");

});

// ************
$app->get('/admin/delete/test/confirmed', function () use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	echo "THIS DELETES DATA";

	$parse_params = array(
		'className' => 'org_profile',
		'object' => array(),
		'query' => array(
        	'org_profile_status' => 'test'
    	)
    );

	$request = $parse->delete($parse_params);
    $response = json_decode($request, true);

    print_r($response);
    exit;

});

// ************
$app->get('/oops/', function () use ($app) {

	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Oops";
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	
	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_oops.php');
});
// ************
$app->get('/start/', function () use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	
	$survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");

	# store new information as new record 
    $parse_params = array(
		'className' => 'survey',
		'object' => $survey_object
    );
	
	// Create Parse object and save
    try {
    	$request = $parse->create($parse_params);
    	$response = json_decode($request, true);
    } catch (Exception $e) {
    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
    	 $app->redirect("/map/survey/oops/");
    }

    if(isset($response['objectId'])) {
    	// Success
    	$app->redirect("/map/survey/".$response['objectId']."/form");
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }
});

// ************
$app->get('/start/internal/add/', function () use ($app) {
	
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	
	$survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");

	# store new information as new record 
    $parse_params = array(
		'className' => 'survey',
		'object' => $survey_object
    );
	
	// Create Parse object and save
    try {
    	$request = $parse->create($parse_params);
    	$response = json_decode($request, true);
    } catch (Exception $e) {
    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
    	 $app->redirect("/map/survey/oops/");
    }

    if(isset($response['objectId'])) {
    	// Success
    	$app->redirect("/map/survey/".$response['objectId']."/form/internal/add/");
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }
});

// ************
$app->get('/start/:lang/', function ($lang) use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	
	$survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");

	# store new information as new record 
    $parse_params = array(
		'className' => 'survey',
		'object' => $survey_object
    );
	
	// Create Parse object and save
    try {
    	$request = $parse->create($parse_params);
    	$response = json_decode($request, true);
    } catch (Exception $e) {
    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
    	 $app->redirect("/map/survey/oops/");
    }

    if(isset($response['objectId'])) {
    	// Success
		$app->redirect("/map/survey/".$response['objectId']."/form/$lang/");
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }
});

// ************
$app->get('/:surveyId/form', function ($surveyId) use ($app) {

	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new survey created, ...");
	
	/*$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));*/

	// bring up new blank survey
	$content['surveyId'] = $surveyId;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey";
	$content['language'] = "en_US";
	print "db connection working successfully.";
    
    $sql="select * from org_surveys";
    $db = connect_db();
	$stmt = $db->query($sql); 
	$users = $stmt->fetchAll(PDO::FETCH_OBJ);
	$db = null;
	echo json_encode($users);

	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_survey.php');

});

// ************
$app->get('/:surveyId/form/:lang/', function ($surveyId, $lang) use ($app) {

	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new survey created, ...");
	
	/*$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));*/

	// bring up new blank survey
	$content['surveyId'] = $surveyId;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey";
	$content['language'] = "$lang";
	print "db connection working successfully.";
    
    $sql="select * from org_surveys";
    $db = connect_db();
	$stmt = $db->query($sql); 
	$users = $stmt->fetchAll(PDO::FETCH_OBJ);
	$db = null;
	echo json_encode($users);

	$app->view()->setData(array('content' => $content ));
	// $app->render('survey/tp_survey_es.php');
	$app->render('survey/tp_survey_gettext.php');

});

// ************
$app->get('/:surveyId/form/internal/add/', function ($surveyId) use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new internal survey created, ...");
	
	/*$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));*/

	// bring up new blank survey
	$content['surveyId'] = $surveyId;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey (Internal)";
	$content['language'] = "en_US";
	print "db connection working successfully.";
    
    $sql="select * from org_surveys";
    $db = connect_db();
	$stmt = $db->query($sql); 
	$users = $stmt->fetchAll(PDO::FETCH_OBJ);
	$db = null;
	echo json_encode($users);

	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_survey_less_req.php');

});

// du new post here
// ************
$app->post('/2du/:surveyId/', function ($surveyId) use ($app) {

	/*$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));*/
     $db = connect_db();
	// Access post variables from submitted survey form
	$allPostVars = $app->request->post();
	// echo "<pre>"; print_r($allPostVars); echo "</pre>";

	// writeDataLog($allPostVars);
	$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; INFO; ". str_replace("\n", "||", print_r($allPostVars, true)) );

    // Set string values to numeric values
    $allPostVars["org_profile_year"] = intval($allPostVars["org_profile_year"]);
    $allPostVars["org_year_founded"] = intval($allPostVars["org_year_founded"]);
    $allPostVars["latitude"] = floatval($allPostVars["latitude"]);
    $allPostVars["longitude"] = floatval($allPostVars["longitude"]);




    // org_country_info
	$params = array("org_hq_country","org_hq_country_locode");
	$org_country_info = array();
	
	foreach ($params as $param) {

    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$org_country_info[$param] = $allPostVars[$param];
    }
    $country_locade = $org_country_info['org_hq_country_locode'];
    echo "......";
    echo $country_locade;
    try{
    	$db = connect_db();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }

	$wb_region = addWbRegions($org_country_info['org_hq_country_locode']);
    $org_country_info['org_hq_country_region'] = $wb_region['org_hq_country_region'];
    $attr1 = $org_country_info['org_hq_country_region'];
    $org_country_info['org_hq_country_region_code'] = $wb_region['org_hq_country_region_code'];
    $attr2	= $org_country_info['org_hq_country_region_code'];
    $org_country_info['org_hq_country_income'] = $wb_region['org_hq_country_income'];
    $attr3	= $org_country_info['org_hq_country_income'];
    $org_country_info['org_hq_country_income_code'] = $wb_region['org_hq_country_income_code'];
    $attr4	= $org_country_info['org_hq_country_region'];
    $attr5 = $org_country_info['org_hq_country_locode'];
    $attr6 = $org_country_info['org_hq_country'];
    echo "the hq country";
    echo $attr6;
   
    $check_country_query = "SELECT * FROM org_country_info where org_hq_country=?";
    try {
    	$stmt = $db->prepare($check_country_query);
    	$stmt->bindParam(1, $attr6);
    	$stmt->execute();
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    	if(! $row){
    		echo "not found----------->1";
    }else{
    		echo "found-------------->1";
    		$newCountryId = $row['country_id'];
    	}
    }catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }

  	$locationInfoQuery = "INSERT INTO org_locations_info(`org_hq_city`, `org_hq_city_locode`,`org_hq_st_prov`,`country_id`) VALUES 
 (:org_hq_city, :org_hq_city_locode, :org_hq_st_prov, :country_id)";

    	/**/
       //org_locations_info
    	//error was the name of the variable was $param and in the below foreach loop, $params as param so array name is $params.
    $params =  array("org_hq_city", "org_hq_city_locode", "org_hq_st_prov");
    $org_locations_info = array();
    
    foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) {
    	 $allPostVars[$param] = null; 
    	}
    //ar_dump($org_locations_info);
    	$org_locations_info[$param] = $allPostVars[$param];
    }
   /* echo "hey........//..//..";
    var_dump($org_locations_info);
//getting user inserted data into variables. */
  $hq_city = $org_locations_info["org_hq_city"];
   $hq_city_locode = $org_locations_info["org_hq_city_locode"];
   $hq_st_prov = $org_locations_info["org_hq_st_prov"];

    /*$loc_obj_id	=	$org_locations_info['object_id'];
    $org_locations_info['country_id'] = $country_id;*/ //primary key

    /*print $country_id;*/
//puting PDO statements inside try catch block. Using the same $db connection throughout the function. 
 try {
 	$stmt1 = $db->prepare($locationInfoQuery);
 $stmt1->bindParam("country_id",$newCountryId);
 $stmt1->bindParam("org_hq_city", $hq_city);
 $stmt1->bindParam("org_hq_city_locode", $hq_city_locode);
 $stmt1->bindParam("org_hq_st_prov", $hq_st_prov);
 $stmt1->execute();
$lastObjectId = $db->lastInsertId();

echo $lastObjectId;
    
 }catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
//values inserted successfully into two tables: country info and location info tables with foreign key constraint. 

// similarly do for other tables. lastCountryId indicates id of the last inserted value for country which will be used as
// foreign key. lastObjectId is last object id. $locationInfoQuery indicates query to insert into location info table. 
// Following the same pattern to insert into all tables. 
   $survey_name = "opendata";

    $survey_query="INSERT INTO org_surveys(`object_id`,
    `survey_name`)VALUES (:object_id,:survey_name)";
     $Org_prof_query =	"INSERT INTO org_profiles(`industry_id`,
	`industry_other`,
	`latitude`,
	`longitude`,
	`no_org_url`,
	`org_additional`,
	`org_description`,
	`org_greatest_impact`,
	`org_greatest_impact_detail`,
	`org_name`,
	`org_open_corporates_id`,
	`org_profile_category`,
	`org_profile_src`,
	`org_profile_status`,
	`org_profile_year`,
	`org_size_id`,
	`org_type`,
	`org_type_other`,
	`org_url`,
	`org_year_founded`,
	`profile_id`,
	`org_loc_id`

	)	values(
	:industry_id,
	:industry_other,
	:latitude,
	:longitude,
	:no_org_url,
	:org_additional,
	:org_description,
	:org_greatest_impact,
	:org_greatest_impact_detail,
	:org_name,
	:org_open_corporates_id,
	:org_profile_category,
	:org_profile_src,
	:org_profile_status,
	:org_profile_year,
	:org_size_id,
	:org_type,
	:org_type_other,
	:org_url,
	:org_year_founded,
	:profile_id,
	:org_loc_id
)";
try {
        $db = connect_db();
        $stmt = $db->prepare($survey_query);
        $stmt->bindParam("object_id",$surveyId);
        $stmt->bindParam("survey_name",$survey_name);
        $stmt->execute();
    	$lastsurvey_id=$db->lastInsertId();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }   

     $params = array("industry_id",
	"industry_other",
	"latitude",
	"longitude",
	"no_org_url",
	"org_additional",
	"org_description",
	"org_greatest_impact",
	"org_greatest_impact_detail",
	"org_name",
	"org_open_corporates_id",
	"org_profile_category",
	"org_profile_src",
	"org_profile_status",
	"org_profile_year",
	"org_size_id",
	"org_type",
	"org_type_other",
	"org_url",
	"org_year_founded","data_use_type");
    $org_obj_prof = array();
	foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$org_obj_prof[$param] = $allPostVars[$param];
    }

    /*$org_obj_prof['profile_id'] = $surveyId;
    $profileid = $org_obj_prof['profile_id'];
    print $profileid;*/
    $industry_id = $org_obj_prof['industry_id'];
    print $industry_id;
    $industry_other = $org_obj_prof['industry_other'];
    $latitude = $org_obj_prof['latitude'];
    $longitude = $org_obj_prof['longitude'];
    $no_org_url = $org_obj_prof['no_org_url'];
    $org_additional = $org_obj_prof['org_additional'];
    $org_description = $org_obj_prof['org_description'];
    $org_greatest_impact = $org_obj_prof['org_greatest_impact'];
    $org_greatest_impact_detail = $org_obj_prof['org_greatest_impact_detail'];
    $org_name = $org_obj_prof['org_name'];
    $org_open_corporates_id = $org_obj_prof['org_open_corporates_id'];
    $org_profile_category = $org_obj_prof['org_profile_category'];
    $org_profile_src = $org_obj_prof['org_profile_src'];
    $org_profile_status = $org_obj_prof['org_profile_status'];
    $org_profile_year = $org_obj_prof['org_profile_year'];
    $org_size_id = $org_obj_prof['org_size_id'];
    $org_type = $org_obj_prof['org_type'];
    $org_type_other = $org_obj_prof['org_type_other'];
    $org_url = $org_obj_prof['org_url'];
    $org_year_founded = $org_obj_prof['org_year_founded'];
    $data_use_type = $org_obj_prof['data_use_type'];

 try {
        $db = connect_db();
        $stmt2 = $db->prepare($Org_prof_query);
        $stmt2->bindParam("industry_id", $industry_id);
		$stmt2->bindParam("industry_other", $industry_other);
		$stmt2->bindParam("latitude", $latitude);
		$stmt2->bindParam("longitude", $longitude);
		$stmt2->bindParam("no_org_url", $no_org_url);
		$stmt2->bindParam("org_additional", $org_additional);
		$stmt2->bindParam("org_description", $org_description);
		$stmt2->bindParam("org_greatest_impact", $org_greatest_impact);
		$stmt2->bindParam("org_greatest_impact_detail", $org_greatest_impact_detail);
		$stmt2->bindParam("org_name", $org_name);
		$stmt2->bindParam("org_open_corporates_id", $org_open_corporates_id);
		$stmt2->bindParam("org_profile_category", $org_profile_category);
		$stmt2->bindParam("org_profile_src", $org_profile_src);
		$stmt2->bindParam("org_profile_status", $org_profile_status);
		$stmt2->bindParam("org_profile_year", $org_profile_year);
		$stmt2->bindParam("org_size_id", $org_size_id);
		$stmt2->bindParam("org_type", $org_type);
		$stmt2->bindParam("org_type_other", $org_type_other);
		$stmt2->bindParam("org_url", $org_url);
		$stmt2->bindParam("org_year_founded", $org_year_founded);
		/*$stmt2->bindParam("data_use_type", $data_use_type);*/
		$stmt2->bindParam("profile_id", $surveyId);
		$stmt2->bindParam("org_loc_id",$lastObjectId);
        $stmt2->execute();
   /*//echo $user;
        $last_id = mysql_insert_id();
    //$db = null;
      //echo json_encode($user); */
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }   
    
   /* $get_profile_id = "*/
   /*$fetch_prof_val = "SELECT profile_id from org_profiles";
   $sth = $dbh->prepare($fetch_prof_val);
	$sth->execute();

	$result = $sth->fetchAll(PDO::FETCH_OBJ);
	/*var_dump($result);*/

    /*$org_obj_prof['org_loc_id'] = $loc_obj_id;*/

    //org_contacts
    echo "details";
    $params = array("survey_contact_first", "survey_contact_last", "survey_contact_title", "survey_contact_email", "survey_contact_phone");
    $contact_details = array();
    var_dump($contact_details);
    // Set all parameters to received value or null
    foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$contact_object[$param] = $allPostVars[$param];
    }
    $survey_contact_first = $contact_object["survey_contact_first"];
    print "woho";
    print $survey_contact_first;
    $survey_contact_last = $contact_object["survey_contact_last"];
    print $survey_contact_last;
    $survey_contact_title = $contact_object["survey_contact_title"];
    print $survey_contact_title;
    $survey_contact_email = $contact_object["survey_contact_email"];
    print $survey_contact_email;
    $survey_contact_phone = $contact_object["survey_contact_phone"];
    print $survey_contact_phone;

    $contact_info_query = "INSERT INTO org_contacts
	(`survey_contact_first`
	,`survey_contact_last`,
	`survey_contact_title`
	,`survey_contact_email`
	,`survey_contact_phone`,
	`profile_id`
	) VALUES 
	(:survey_contact_first,
	:survey_contact_last,
	:survey_contact_title,
	:survey_contact_email,
	:survey_contact_phone,
	:profile_id
	)";
    try {
        $db = connect_db();
        $stmt = $db->prepare($contact_info_query);
        $stmt->bindParam("survey_contact_first",$survey_contact_first);
		 $stmt->bindParam("survey_contact_last",$survey_contact_last); 
		 $stmt->bindParam("survey_contact_title",$survey_contact_title);
		  $stmt->bindParam("survey_contact_email",$survey_contact_email);
		   $stmt->bindParam("survey_contact_phone",$survey_contact_phone);
		   $stmt->bindParam("profile_id",$surveyId);
        $stmt->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }   



    //data_app_use
    $params = array("use_advocacy", "use_advocacy_desc", "use_org_opt", "use_org_opt_desc", "use_other", "use_other_desc", "use_prod_srvc", "use_prod_srvc_desc","use_research","use_research_des");
	$data_app_info = array();
	foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$data_app_info[$param] = $allPostVars[$param];
    }
  //  var_dump($data_app_info);
    $advocacy_desc = $data_app_info["use_advocacy_desc"];
   // print "woho";
   // print "   ";
   // print $advocacy_desc;
    $org_opt_desc = $data_app_info["use_org_opt_desc"];
   // print $org_opt_desc;
    $other_desc = $data_app_info["use_other_desc"];
   // print $other_desc;
    $prod_srvc_desc = $data_app_info["use_prod_srvc_desc"];
   // print $prod_srvc_desc;
    $research_des = $data_app_info["use_research_des"];
   // print $research_des;


   // var_dump($data_app_info);
   	$params = array("use_advocacy", "use_prod_srvc", "use_org_opt", "use_research", "use_other");
	foreach ($params as $param) {
		if(empty($data_app_info[$param])){
			//echo "null it is";
			$data_app_info[$param] = "false";
		}else {
			//echo "not null";
			$data_app_info[$param] = "true";
		}
		/*if (is_null($data_app_info[$param])) {
			$data_app_info[$param] = false;
		} else {
			$data_app_info[$param] = true;
		}*/
	}
	//var_dump($data_app_info);
	$advocacy = $data_app_info["use_advocacy"];
	$prod_srvc = $data_app_info["use_prod_srvc"];
	$org_opt = $data_app_info["use_org_opt"];
	$research = $data_app_info["use_research"];
	$other = $data_app_info["use_other"];
	//echo "hey ";
	//echo $advocacy;
	//var_dump($data_app_info);
	/*$data_app_info['profile_id'] = $profileid;*/

     
       $data_info_query ="INSERT INTO data_app_info(`advocacy`, `advocacy_desc`, `org_opt`, `org_opt_desc`, `other`, `other_desc`, `prod_srvc`, `prod_srvc_desc`,`research`,`research_desc`,`profile_id`)
    values(
	:use_advocacy, :use_advocacy_desc, :use_org_opt, :use_org_opt_desc, :use_other, :use_other_desc, :use_prod_srvc, :use_prod_srvc_desc,:use_research,:use_research_desc,:profile_id)";
try {
        $db = connect_db();
        $stmt = $db->prepare($data_info_query);
        $stmt->bindParam("use_advocacy",$advocacy);
		$stmt->bindParam("use_advocacy_desc",$advocacy_desc);
		$stmt->bindParam("use_org_opt",$org_opt);
		$stmt->bindParam("use_org_opt_desc",$org_opt_desc);
		$stmt->bindParam("use_other",$other);
		$stmt->bindParam("use_other_desc",$other_desc);
		$stmt->bindParam("use_prod_srvc",$prod_srvc);
		$stmt->bindParam("use_prod_srvc_desc",$prod_srvc_desc);
		$stmt->bindParam("use_research",$research);
		$stmt->bindParam("use_research_desc",$research_desc);
		$stmt->bindParam("profile_id",$surveyId);
        $stmt->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }   

    $idSuffixNum = 1;
    echo "heyyy";
    //var_dump($allPostVars);
	while (array_key_exists('dataUseData-'.$idSuffixNum, $allPostVars)) {
		//echo "while loop with index".$idSuffixNum;

		// skip row and continue if user did not select country
		if (is_null($allPostVars['dataUseData-'.$idSuffixNum])) {
		 continue; 
		}
		$data_use_types = $allPostVars['data_use_type'];
		$org_data_sources = array();

		  $params = array ("data_country_count", "data_use_type", "dataUseData-2");
		    $org_data_sources = array();
		foreach ($params as $param) {
		    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
		    	$org_data_sources[$param] = $allPostVars[$param];
		    }
		    var_dump($org_data_sources);
		foreach ($allPostVars['dataUseData-'.$idSuffixNum] as $row) {
			$src_country = $row['src_country_locode'];
			if (!array_key_exists('type', $row)) { 
				$data_country_count = $org_data_sources["data_country_count"];
				$org_data_sources['profile_id'] = $surveyId;
				//	$wb_region = addWbRegions($org_country_info['org_hq_country_locode']);

				$org_data_sources['data_src_country_locode'] = $src_country;
				
				$data_use_wb_region = addWbRegions($src_country);
				$country_name = $data_use_wb_region['org_hq_country_name'];	
			    $country_region = $data_use_wb_region['org_hq_country_region'];
			    $country_region_code = $data_use_wb_region['org_hq_country_region_code'];
			    $country_income = $data_use_wb_region['org_hq_country_income'];
			    $country_income_code = $data_use_wb_region['org_hq_country_income_code'];
			    
				//check if country info is already available in org_country_info , if not insert new country info.
				  $check_country_query = "SELECT * FROM org_country_info where org_hq_country=?";
				    try {
				    	$stmt = $db->prepare($check_country_query);
				    	$stmt->bindParam(1, $country_name);
				    	$stmt->execute();
				    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
				    	if(! $row){
				    		echo "not found----------> first condition";  
					    }else{
					    	echo "country id---------->first condition";
					    	$newCountryId = $row['country_id'];
					    }
					}catch(PDOException $e) {
					    
				    }  
				$org_data_sources['row_type'] = 'data_use';
				echo "if loop";
				// //var_dump($data_use_object);
				/* Create a record for each type even though the national is blank */
				foreach ($data_use_types as $type){
					echo "data use types loop";
					$org_data_sources['data_type'] = $type;
					$data_type = $org_data_sources['data_type'];
					$row_type = $org_data_sources['row_type'];
					$org_data_sources_query="INSERT INTO org_data_sources(`data_country_count`,`data_type`, `row_type`,`profile_id`,`country_id`)
					values(:data_country_count,:data_type, :row_type,:profile_id,:country_id)";

						try {
					        $db = connect_db();
					        $stmt = $db->prepare($org_data_sources_query);
					        $stmt->bindParam("data_country_count",$data_country_count);
							$stmt->bindParam("data_type",$data_type);
							$stmt->bindParam("row_type",$row_type);
							$stmt->bindParam("profile_id",$surveyId);
							$stmt->bindParam("country_id",$newCountryId);
					        $stmt->execute();
					    } catch(PDOException $e) {
					        
					    }   
				}

			}

			 else {
				echo "else loop";
				$existing_types = array();
				foreach ($row['type'] as $type => $details) {
					$existing_types[] = $type;
					foreach ($details['src_gov_level'] as $gov_level) {
						$org_data_sources['data_src_country_locode'] = $src_country;
						$data_use_wb_region = addWbRegions($src_country);
						$country_name = $data_use_wb_region['org_hq_country_name'];	
					    $country_region = $data_use_wb_region['org_hq_country_region'];
					    $country_region_code = $data_use_wb_region['org_hq_country_region_code'];
					    $country_income = $data_use_wb_region['org_hq_country_income'];
					    $country_income_code = $data_use_wb_region['org_hq_country_income_code'];
						
						//check if country info is already available in org_country_info , if not insert new country info.
					 	$check_country_query = "SELECT * FROM org_country_info where org_hq_country=?";
					    try {
					    	$stmt = $db->prepare($check_country_query);
					    	$stmt->bindParam(1, $country_name);
					    	$stmt->execute();
					    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
					    	if(! $row){
					    		echo "not found----------> second condition";
						    }else{
						    	echo "country id---------->second condition";
						    	$newCountryId = $row['country_id'];
						    }
						}catch(PDOException $e) {
						    
					    }  

						$org_data_sources['data_type'] = $type;
						$data_type = $org_data_sources['data_type'];
						$org_data_sources['data_src_gov_level'] = $gov_level;
						$data_src_gov_level = $org_data_sources['data_src_gov_level'];
						// set profile_id
						$org_data_sources['profile_id'] = $surveyId;
						// identify row as data use row for flattened file for ARC GIS
						$org_data_sources['row_type'] = 'data_use';
						$row_type = $org_data_sources['row_type'];
						$data_country_count = $org_data_sources['data_country_count'];
						print "printing data_country_count";
				        echo $data_country_count;
						// echo "<pre>";print_r($data_use_object);echo "</pre>";
						//var_dump($org_data_sources);
						$org_data_sources_query="INSERT INTO org_data_sources(`data_country_count`,`data_type`, `row_type`,`data_src_gov_level`,`profile_id`,`country_id`)values(:data_country_count,:data_type, :row_type,:data_src_gov_level,:profile_id,:country_id)";
						try {
						        //$db = connect_db();
						        $stmt = $db->prepare($org_data_sources_query);
						        $stmt->bindParam("data_country_count",$data_country_count);
								$stmt->bindParam("data_type",$data_type);
								$stmt->bindParam("row_type",$row_type);
								$stmt->bindParam("data_src_gov_level",$data_src_gov_level);
								$stmt->bindParam("profile_id",$surveyId);
								$stmt->bindParam("country_id",$newCountryId);
						        $stmt->execute();
						    } catch(PDOException $e) {
						       
						    }   
					}
				}
				
				/* Creating records for empty-national/local value records */
				foreach ($data_use_types as $type){
					if (!in_array($type, $existing_types)){
						$org_data_sources['data_src_country_locode'] = $src_country;
						$data_use_wb_region = addWbRegions($src_country);
						$country_name = $data_use_wb_region['org_hq_country_name'];	
					    $country_region = $data_use_wb_region['org_hq_country_region'];
					    $country_region_code = $data_use_wb_region['org_hq_country_region_code'];
					    $country_income = $data_use_wb_region['org_hq_country_income'];
					    $country_income_code = $data_use_wb_region['org_hq_country_income_code'];
						//$org_data_sources['data_src_country_name'] = $data_use_wb_region['org_hq_country_name'];
						
						//check if country info is already available in org_country_info , if not insert new country info.
					 	$check_country_query = "SELECT * FROM org_country_info where org_hq_country=?";
					    try {
					    	$stmt = $db->prepare($check_country_query);
					    	$stmt->bindParam(1, $country_name);
					    	$stmt->execute();
					    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
					    	if(! $row){
					    		echo "not found----------> second condition";
						    }else{
						    	echo "country id---------->second condition";
						    	$newCountryId = $row['country_id'];
						    }
						}catch(PDOException $e) {
						   
					    }  

						$org_data_sources['data_type'] = $type;
						$data_type = $org_data_sources['data_type'];
						$org_data_sources['data_src_gov_level'] = $gov_level;
						$data_src_gov_level = $org_data_sources['data_src_gov_level'];
						// set profile_id
						$org_data_sources['profile_id'] = $surveyId;
						// identify row as data use row for flattened file for ARC GIS
						$org_data_sources['row_type'] = 'data_use';
						$row_type = $org_data_sources['row_type'];
						// echo "<pre>";print_r($data_use_object);echo "</pre>";
						//var_dump($org_data_sources);
						$org_data_sources_query="INSERT INTO org_data_sources(`data_country_count`,`data_type`, `row_type`,`data_src_gov_level`,`profile_id`,`country_id`)values(:data_country_count,:data_type, :row_type,:data_src_gov_level,:profile_id,:country_id)";
						try {
						        //$db = connect_db();
						        $stmt = $db->prepare($org_data_sources_query);
						        $stmt->bindParam("data_country_count",$data_country_count);
								$stmt->bindParam("data_type",$data_type);
								$stmt->bindParam("row_type",$row_type);
								$stmt->bindParam("data_src_gov_level",$data_src_gov_level);
								$stmt->bindParam("profile_id",$surveyId);
								$stmt->bindParam("country_id",$newCountryId);
						        $stmt->execute();
						    } catch(PDOException $e) {
						         
						    }   
						
					}
				}
			}
		}
		$idSuffixNum++;
	}
	echo "after while loop";

   
   // var_dump($org_data_sources);
    /*$data_country_count = $org_data_sources["data_country_count"];
    print "woho";
    print $data_country_count;*/
    /*$data_type = $org_data_sources["data_type"];
    print $data_type;*/
    /*$data_src_gov_level = $org_data_sources["data_src_gov_level"];
    print $data_src_gov_level;*/



    /*$data_app_info['profile_id'] = $profileid;
    $data_app_info['country_id'] = $country_id;*/

    //org_contacts
   

    /*$data_app_info['profile_id'] = $profileid;
*/

    // Copy country abbreviation to loc code
    // $allPostVars["org_hq_country_locode"] = $allPostVars["org_hq_country"];

	// echo "<pre>";print_r($allPostVars);echo "</pre>"; 
	// exit;

	// ============================
	// Prepare and save org_object
	// ============================
	/* Saves once per survey submission */




    $params = array("org_name", "org_open_corporates_id", "org_type", "org_type_other", "org_url", "no_org_url", "org_year_founded", "org_description", "org_size_id", "industry_id", "industry_other", "org_greatest_impact", "org_greatest_impact_detail", "use_advocacy", "use_advocacy_desc", "use_prod_srvc", "use_prod_srvc_desc", "use_org_opt", "use_org_opt_desc", "use_research", "use_research_desc", "use_other", "use_other_desc", "org_hq_city", "org_hq_st_prov", "org_hq_country", "latitude", "longitude", "org_hq_city_locode", "org_hq_country_locode", "org_profile_year", "org_additional", "org_profile_status", "org_profile_src", "org_profile_category", "data_use_type", "data_country_count", "data_use_type_other");
    $org_object = array();
    // Set all parameters to received value or null
    foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$org_object[$param] = $allPostVars[$param];
    }
	// Set string values to boolean values
	$params = array("no_org_url", "use_advocacy", "use_prod_srvc", "use_org_opt", "use_research", "use_other");
	foreach ($params as $param) {
		if (is_null($org_object[$param])) {
			$org_object[$param] = false;
		} else {
			$org_object[$param] = true;
		}
	}

	// Add Worldbank Region and Economic code data
	echo "org_hq_country_locode: ".$org_object['org_hq_country_locode'] . "<br>";
    $wb_region = addWbRegions($org_object['org_hq_country_locode']);
    $org_object['org_hq_country_region'] = $wb_region['org_hq_country_region'];
    $org_object['org_hq_country_region_code'] = $wb_region['org_hq_country_region_code'];
    $org_object['org_hq_country_income'] = $wb_region['org_hq_country_income'];
    $org_object['org_hq_country_income_code'] = $wb_region['org_hq_country_income_code'];

	// set profile_id
	$org_object['profile_id'] = $surveyId;

	// echo "<br>****** PARAMS ********* <pre>\n";print_r($allPostVars);echo "</pre>"; 
	// exit;

	// save org_object to Parse
	//$parse_params = array(
	//	'className' => 'org_profile',
	//	'object' => $org_object
	//);
	//$request = $parse->create($parse_params);
	//$response = json_decode($request, true);
	// echo "<pre>"; print_r($response); echo "</pre>";
	// exit;

	// ============================================================================
	// Prepare and save org_object into arcgis_flatfile as row_type = org_profile
	// ============================================================================
	/* Saves once per survey submission */
	// remove certain fields from org_profile
	// fields "use_prod_srvc_desc", "use_org_opt_desc", "use_research_desc", "use_other_desc" should be copied to arcgis_flatfield (by Myeong)
	// $remove_keys = array ("org_additional", "data_country_count", "data_use_type", "data_country_count");
	// foreach ( $remove_keys as $key) {
	// 	if (array_key_exists($key, $org_object)) {
	// 		unset($org_object[$key]);
	// 	}
	// }
	// // Identify row as org profile in flattened file for ARC GIS
	// $org_object['row_type'] = 'org_profile';
	// // Prepare parse.com params
	// $parse_params = array(
	// 	'className' => 'arcgis_flatfile',
	// 	'object' => $org_object
	// );
	// $request = $parse->create($parse_params);
	// $response = json_decode($request, true);
	// if(!isset($response['createdAt'])) {
	// 	echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 	// log error and generate email to admins
	// 	exit;
	// }

	// // ================================
	// // Prepare and save contact_object
	// // ================================
	// /* Saves once per survey submission */
 //    $params = array("org_name", "org_profile_src", "survey_contact_first", "survey_contact_last", "survey_contact_title", "survey_contact_email", "survey_contact_phone");
 //    $contact_object = array();
 //    // Set all parameters to received value or null
 //    foreach ($params as $param) {
 //    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
 //    	$contact_object[$param] = $allPostVars[$param];
 //    }
 //    // set profile_id
	// $contact_object['profile_id'] = $surveyId;
	// // save contact_object to Parse
	// $parse_params = array(
	// 	'className' => 'org_contact',
	// 	'object' => $contact_object
	// );
	// $request = $parse->create($parse_params);
	// $response = json_decode($request, true);
	// if(!isset($response['createdAt'])) {
	// 	echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 	// log error and generate email to admins
	// 	exit;
	// }
	echo "here";
	// ============================================================================================
	// Prepare and save data_use_object and arcgis_object combining data_use_object and org_object
	// ============================================================================================
	/* Saves multiple times per survey submission, once for each data use into two tables */
	//$idSuffixNum = 1;
	//include_once("wb_country.php");

	// dataUseData-2]
	// while (array_key_exists('dataUseData-'.$idSuffixNum, $allPostVars)) {
	// 	// skip row and continue if user did not select country
	// 	if (is_null($allPostVars['dataUseData-'.$idSuffixNum])) { continue; }
	// 	// echo "<pre>";
	// 	// print_r ($allPostVars);
	// 	// echo "</pre>";
	// 	// exit;
	// 	$data_use_types = $allPostVars['data_use_type'];
	// 	$data_use_object = array();

	// 	foreach ($allPostVars['dataUseData-'.$idSuffixNum] as $row) {
			
	// 		$src_country = $row['src_country_locode'];

	// 		// old implemntation: skip row and continue if user did not select types for country
	// 		// March 2016 (Myeong): need to store the row even if there's no selection for the type of country
	// 		if (!array_key_exists('type', $row)) { 
	// 			// echo "<pre>";print_r($row);echo "</pre>";
	// 			$data_use_object['data_src_country_locode'] = $src_country;
	// 			$data_use_wb_region = addWbRegions($src_country);
	// 			$data_use_object['data_src_country_name'] = $data_use_wb_region['org_hq_country_name'];
	// 			$data_use_object['profile_id'] = $surveyId;
	// 			$data_use_object['row_type'] = 'data_use';

	// 			/* Create a record for each type even though the national is blank */
	// 			foreach ($data_use_types as $type){
	// 				$data_use_object['data_type'] = $type;
	// 									// save data_use_object to Parse
	// 				$parse_params = array(
	// 					'className' => 'org_data_use',
	// 					'object' => $data_use_object 	// contains data for org_data_use row
	// 				);
	// 				$request = $parse->create($parse_params);
	// 				$response = json_decode($request, true);
	// 				// print_r($response); echo "<br />";
	// 				if(!isset($response['createdAt'])) {
	// 					echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 					// log error and generate email to admins
	// 					exit;
	// 				}

	// 				// merge org_profile and data_use objects and save to parse for arcgis
	// 				$arcgis_object = array_merge($org_object, $data_use_object);
	// 				$parse_params = array(
	// 					'className' => 'arcgis_flatfile',
	// 					'object' => $arcgis_object 	// contains data for org_data_use row
	// 				);
	// 				$request = $parse->create($parse_params);
	// 				$response = json_decode($request, true);
	// 				// print_r($response); echo "<br />";
	// 				if(!isset($response['createdAt'])) {
	// 					echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 					// log error and generate email to admins
	// 					exit;
	// 				}
	// 				// continue;
	// 			}
	// 		} else {
	// 			$existing_types = array();
	// 			foreach ($row['type'] as $type => $details) {
	// 				/* store a type that exists in the data */
	// 				$existing_types[] = $type;
	// 				foreach ($details['src_gov_level'] as $gov_level) {
	// 					// echo "<br>$src_country|$type|$gov_level";
	// 					$data_use_object['data_src_country_locode'] = $src_country;
	// 					$data_use_wb_region = addWbRegions($src_country);
	// 					$data_use_object['data_src_country_name'] = $data_use_wb_region['org_hq_country_name'];
	// 					$data_use_object['data_type'] = $type;
						
	// 					$data_use_object['data_src_gov_level'] = $gov_level;
	// 					// set profile_id
	// 					$data_use_object['profile_id'] = $surveyId;
	// 					// identify row as data use row for flattened file for ARC GIS
	// 					$data_use_object['row_type'] = 'data_use';
	// 					// echo "<pre>";print_r($data_use_object);echo "</pre>";

	// 					// save data_use_object to Parse
	// 					$parse_params = array(
	// 						'className' => 'org_data_use',
	// 						'object' => $data_use_object 	// contains data for org_data_use row
	// 					);
	// 					$request = $parse->create($parse_params);
	// 					$response = json_decode($request, true);
	// 					// print_r($response); echo "<br />";
	// 					if(!isset($response['createdAt'])) {
	// 						echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 						// log error and generate email to admins
	// 						exit;
	// 					}

	// 					// merge org_profile and data_use objects and save to parse for arcgis
	// 					$arcgis_object = array_merge($org_object, $data_use_object);
	// 					$parse_params = array(
	// 						'className' => 'arcgis_flatfile',
	// 						'object' => $arcgis_object 	// contains data for org_data_use row
	// 					);
	// 					$request = $parse->create($parse_params);
	// 					$response = json_decode($request, true);
	// 					// print_r($response); echo "<br />";
	// 					if(!isset($response['createdAt'])) {
	// 						echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 						// log error and generate email to admins
	// 						exit;
	// 					}
	// 				}
	// 			}
	// 			/* Creating records for empty-national/local value records */
	// 			foreach ($data_use_types as $type){
	// 				if (!in_array($type, $existing_types)){
	// 					$data_use_object['data_src_country_locode'] = $src_country;
	// 					$data_use_wb_region = addWbRegions($src_country);
	// 					$data_use_object['data_src_country_name'] = $data_use_wb_region['org_hq_country_name'];
	// 					$data_use_object['profile_id'] = $surveyId;
	// 					$data_use_object['row_type'] = 'data_use';
	// 					$data_use_object['data_type'] = $type;
	// 					unset($data_use_object['data_src_gov_level']);
	// 										// save data_use_object to Parse
	// 					$parse_params = array(
	// 						'className' => 'org_data_use',
	// 						'object' => $data_use_object 	// contains data for org_data_use row
	// 					);
	// 					$request = $parse->create($parse_params);
	// 					$response = json_decode($request, true);
	// 					// print_r($response); echo "<br />";
	// 					if(!isset($response['createdAt'])) {
	// 						echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 						// log error and generate email to admins
	// 						exit;
	// 					}

	// 					// merge org_profile and data_use objects and save to parse for arcgis
	// 					$arcgis_object = array_merge($org_object, $data_use_object);
	// 					$parse_params = array(
	// 						'className' => 'arcgis_flatfile',
	// 						'object' => $arcgis_object 	// contains data for org_data_use row
	// 					);
	// 					$request = $parse->create($parse_params);
	// 					$response = json_decode($request, true);
	// 					// print_r($response); echo "<br />";
	// 					if(!isset($response['createdAt'])) {
	// 						echo "<br>Problem. Problem saving how data is used create not yet handled.";
	// 						// log error and generate email to admins
	// 						exit;
	// 					}
	// 					// continue;
						
	// 				}
	// 			}
	// 		}
	// 	}
	// 	$idSuffixNum++;
	// }

	echo "it reached here";
	// If we made it here, everything saved.

	// ==========================================
	// All data saved, send a confirmation email
	// ==========================================
	/* Send one per survey submission */
	// Instantiate the client.

	if ($allPostVars['org_profile_status'] == "edit"){
			// Instantiate the client.
		$mgClient = new Mailgun(MAILGUN_APIKEY);
		$domain = MAILGUN_SERVER;
		$objectid = $allPostVars['objectId'];
		$org_name = $allPostVars['org_name'];
		$old_id = $allPostVars['oldId'];
		$new_id = $allPostVars['profile_id'];

		$emailtext = <<<EOL
An EDIT was filled out for Org Profile.

The organization name in the new survey: ${org_name}
The old profile ID is: ${old_id} 
The new profile ID is: ${new_id}
The old objectID in Parse.com's org_profile: ${objectid} 

View the new profile here: http://${_SERVER['HTTP_HOST']}/map/survey/edit/${surveyId}

EOL;

		// Send email with mailgun
		$result = $mgClient->sendMessage($domain, array(
			'from'    => 'Center for Open Data Enterprise <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>',
			'to'      => '<'.'audrey@odenterprise.org'.'>',
			'subject' => "Open Data Impact Map: EDIT FOR PROFILE ${surveyId}",
			'text'    => $emailtext
		));

	} else {

		$mgClient = new Mailgun(MAILGUN_APIKEY);
		$domain = MAILGUN_SERVER;

		$emailtext = <<<EOL
Thank you for participating in the Open Data Impact Map. Your contribution helps make the Map a truly global view of open data’s impact. You can view your submission here: http://${_SERVER['HTTP_HOST']}/map/survey/${surveyId}

Please help us spread the word by sharing the survey http://www.opendataenterprise.org/map/survey

If you know of any other organizations using open data, are interested in becoming a regional supporter, or have any questions, please email us at map@odenterprise.org.

Many thanks, 
The Center for Open Data Enterprise

EOL;

	    if ( strlen($allPostVars['survey_contact_email']) > 0 && SEND_MAIL) {
			// Send email with mailgun
			$result = $mgClient->sendMessage($domain, array(
				'from'    => 'Center for Open Data Enterprise <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>',
				'to'      => '<'.$allPostVars['survey_contact_email'].'>',
				'subject' => "Open Data Impact Map: SUBMISSION RECEIVED",
				'text'    => $emailtext
			));
			// echo "<pre>";print_r($result); echo "</pre>";exit;
	    }
	}

	$app->redirect("/map/survey/".$surveyId."/thankyou/");
});
// end du new post here

// ************
$app->get('/:surveyId/thankyou/', function ($surveyId) use ($app) {
	
	// $parse = new parseRestClient(array(
	// 	'appid' => PARSE_APPLICATION_ID,
	// 	'restkey' => PARSE_API_KEY
	// ));
	// // Retrieve org_profile
	// $params = array(
	//     'className' => 'org_profile',
	//     'query' => array(
	//         'profile_id' => $surveyId
	//     )
	// );

	// $request = $parse->query($params);
	// $request_decoded = json_decode($request, true);
	//$org_profile = $request_decoded['results'][0];
		$db = connect_db();
		$org_profile_query="select * from org_profiles where profile_id=?";
		$stmt = $db->prepare($org_profile_query); 
		$stmt->bindParam(1, $surveyId);
		$stmt->execute();
		$query_result = $stmt->fetchAll();
		
         
	//$org_profile = "organizational details";
/*	echo "org_profiles";
	var_dump($org_profile);*/

	$content['surveyId'] = $surveyId;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Thank You";
	$content['language'] = "en_US";
	
	//$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile ));
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_thankyou.php');

});

// ************
$app->get('/:surveyId/submitted/', function ($surveyId) use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $surveyId
	    	)
	);
  
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_profile = $request_decoded['results'][0];


	/*$db = connect_db();
		$org_profile_query="select * from org_profiles where object_id=?";
		$stmt = $db->prepare($org_profile_query); 
		$stmt->bindParam(1, $surveyId);
		$stmt->execute();
		$query_result = $stmt->fetchAll();
		*/

	// Retrieve org_data_use
	$params = array(
		'className' => 'org_data_use',
		'query' => array(
	        'profile_id' => $surveyId
			)
	);

	/*$db = connect_db();
		$org_data_use_query="select * from org_data_sources where object_id=?";
		$stmt = $db->prepare($org_data_use_query); 
		$stmt->bindParam(1, $surveyId);
		$stmt->execute();
		$query_result = $stmt->fetchAll();
		*/


	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_data_use = $request_decoded['results'];

	$content['surveyId'] = $surveyId;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Submitted";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use ));
	$app->render('survey/tp_submitted.php');

});


// ************
$app->get('/map/company/:profile_id/edit', function ($profile_id) use ($app) {

	$app->redirect("/map/survey/edit/".$profile_id);

});

// ************
$app->get('/:profile_id/edit', function ($profile_id) use ($app) {

	$app->redirect("/map/survey/edit/".$profile_id);

});

// ************
$app->get('/edit/:profile_id', function ($profile_id) use ($app) {

	// $parse = new parseRestClient(array(
	// 	'appid' => PARSE_APPLICATION_ID,
	// 	'restkey' => PARSE_API_KEY
	// ));
	// // Retrieve org_profile
	// $params = array(
	//     'className' => 'org_profile',
	//     'query' => array(
	//         'profile_id' => $profile_id
	//     	)
	// );

	//$request = $parse->query($params);
	//$request_decoded = json_decode($request, true);
	$db = connect_db();
		$org_profile_query="select * from org_profiles where profile_id=?";
		$stmt = $db->prepare($org_profile_query); 
		$stmt->bindParam(1, $profile_id);
		$stmt->execute();
		$query_result = $stmt->fetchAll();

	if (count($query_result) > 0) {
		// No result redirect to error
		//$org_profile = $request_decoded['results'][0];
		// echo "<pre>"; print_r($request_decoded); 
	} else {
		$app->redirect("/map/org/".$profile_id."/notfound/");
	}
	
	$content['surveyId'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit Message";
	$content['language'] = "en_US";
	
	//$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile ));
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_profile_edit_msg.php');

});

// ************
$app->get('/edit/:profile_id/form', function ($profile_id) use ($app) {

	// $parse = new parseRestClient(array(
	// 	'appid' => PARSE_APPLICATION_ID,
	// 	'restkey' => PARSE_API_KEY
	// ));
	// // Retrieve org_profile
	// $params = array(
	//     'className' => 'org_profile',
	//     'query' => array(
	//         'profile_id' => $profile_id
	//     	)
	// );

	// $request = $parse->query($params);
	// $request_decoded = json_decode($request, true);
	$db = connect_db();
		$org_profile_query="select * from org_profiles where profile_id=?";
		$stmt = $db->prepare($org_profile_query); 
		$stmt->bindParam(1, $profile_id);
		$stmt->execute();
		$query_result = $stmt->fetchAll();
	if (count($query_result) > 0) {
		// No result redirect to error
		//$org_profile = $request_decoded['results'][0];
		// echo "<pre>"; print_r($request_decoded); 
	} else {
		$app->redirect("/map/survey/".$profile_id."/notfound/");
	}

	$org_profile_query="select * from org_surveys where object_id=?";
	$stmt = $db->prepare($org_profile_query); 
	$stmt->bindParam(1, $profile_id);
	$stmt->execute();
	$query_result = $stmt->fetchAll();
	// Retrieve org_data_use
	// $params = array(
	// 	'className' => 'org_data_use',
	// 	'query' => array(
	//         'profile_id' => $profile_id
	// 		)
	// );

	//$request = $parse->query($params);
//	$request_decoded = json_decode($request, true);
	//$org_data_use = $request_decoded['results'];

	// When editing, it creates a new survey instead of using the old survey fields
	$survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");

	# store new information as new record 
    $parse_params = array(
		'className' => 'survey',
		'object' => $survey_object
    );

    try {
    	$request = $parse->create($parse_params);
    	$response = json_decode($request, true);
    } catch (Exception $e) {
    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
    	 $app->redirect("/map/survey/oops/");
    }

	if(isset($response['objectId'])) {
    	// Success
    	$content['old_survey_id'] = $profile_id;
    	$profile_id = $response['objectId'];
    	$org_profile['profile_id'] = $profile_id;
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }

	$content['surveyId'] = $profile_id;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use ));
	$app->render('survey/tp_profile_edit.php');

});

// ************
$app->post('/:surveyId/editform', function ($surveyId) use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// Access post variables from submitted survey form
	$allPostVars = $app->request->post();
	// echo "edit form submission $surveyId";
	// echo "<pre>"; print_r($allPostVars); echo "</pre>";

	$edits = print_r($allPostVars, true);

	// Instantiate the client.
	$mgClient = new Mailgun(MAILGUN_APIKEY);
	$domain = MAILGUN_SERVER;

	$emailtext = <<<EOL
An EDIT was filled out for Org Profile: ${surveyId} 

View the current profile here: http://${_SERVER['HTTP_HOST']}/map/survey/${surveyId}

The submitted changes are below:

$edits

EOL;

	// Send email with mailgun
	$result = $mgClient->sendMessage($domain, array(
		'from'    => 'Center for Open Data Enterprise <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>',
		'to'      => '<'.'audrey@odenterprise.org'.'>',
		'cc'      => '<'.'greg@odenterprise.org'.'>',
		'subject' => "Open Data Impact Map: EDIT FOR PROFILE ${surveyId}",
		'text'    => $emailtext
	));

	// exit;

	// writeDataLog($allPostVars);
	$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; INFO; ". str_replace("\n", "||", print_r($allPostVars, true)) );
	//capture edits
	$time = time();
    $sql = "INSERT INTO org_surveys(updatedAt) Values ('$time')";
    mysql_query($sql);




	// echo "<br>"."/map/survey/".$surveyId."/thankyou/";

// exit;
	$app->redirect("/map/survey/".$surveyId."/thankyou/");
	
});

// ************
$app->get('/:profile_id/notfound/', function ($profile_id) use ($app) {

	$content['profile_id'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['title'] = "Open Data Enterprise Survey - Problem";
	$content['error_msg_title'] = "Organization not found.";
	$content['error_msg_details'] = "We did not find any organization for profile: $profile_id.";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_problem.php');

});

// **************
$app->get('/admin/survey/submitted/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'org_profile',
		'query' => array(
	        'org_profile_status' => "submitted"
			)
	);

	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];

	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid_map.php');

});

// **************
$app->get('/survey/opendata/list/new/2/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'org_profile'
	);

	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];

	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid_map.php');

});

// **************
$app->get('/survey/opendata/list/map/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'org_profile'
	);

	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];

	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_grid_map.php');

});

// **************
$app->get('/admin/survey/grid/', function () use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// Initialize variables for loop
	$org_profiles = array();
	$skip = 0;
	$retrieved = 0;

	// Retrieve all records from parse.com, 1000 records at a time b/c 1000 records is the max allowed
	// Build up a single array of all retrieved records
	while ( $skip == 0 OR $retrieved > 0 ) {

		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
			'limit' => '1000',
			'skip' => $skip
		);

		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		// $org_profiles = $request_array['results'];
		$retrieved = count($request_array['results']);
		if ($retrieved > 0) {
			// Use array_merge_recursive to keep merged array flat
			$org_profiles = array_merge_recursive($org_profiles,$request_array['results']);
		}
		// echo "$retrieved ";
		// increment skip
		$skip = $skip + 1000;
	}
	// We now have all records in one big array in $org_profiles

	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid.php');

});

$app->get('/admin/survey/duplicate/', function () use ($app) {
	
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// Initialize variables for loop
	$org_profiles = array();
	$skip = 0;
	$retrieved = 0;

	// Retrieve all records from parse.com, 1000 records at a time b/c 1000 records is the max allowed
	// Build up a single array of all retrieved records
	while ( $skip == 0 OR $retrieved > 0 ) {

		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
		    'query' => array(
				        'org_profile_status' => 'publish'
					    ),
			'limit' => '1000',
			'skip' => $skip
		);

		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		// $org_profiles = $request_array['results'];
		$retrieved = count($request_array['results']);
		if ($retrieved > 0) {
			// Use array_merge_recursive to keep merged array flat
			$org_profiles = array_merge_recursive($org_profiles,$request_array['results']);
		}
		// echo "$retrieved ";
		// increment skip
		$skip = $skip + 1000;
	}
	$duplicate_list = array();

	foreach ($org_profiles as $profile){

		foreach($org_profiles as $iter){
			if ($iter['objectId'] != $profile['objectId'] &&
					$iter['org_name'] == $profile['org_name']){
				// if (array_key_exists(strval($profile['org_name']), $duplicate_list)) {
				// 	if ($duplicate_list[strval($profile['org_name'])] != strval($iter['profile_id']))
				// 		$duplicate_list[strval($profile['org_name'])] .=  ', ' . strval($iter['profile_id']);
				// }
				// else {
				// 	$duplicate_list[strval($profile['org_name'])] =  strval($iter['profile_id']);
				// }
				$duplicate_list[] = strval($iter['profile_id']);
			}
		}
	}
	$duplicate_list = array_unique($duplicate_list);

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles, 'duplicate_list' => $duplicate_list));

	$app->render('admin/tp_grid.php');

});

// **************
$app->post('/admin/survey/updatefield/:profile_id', function ($profile_id) use ($app) {

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// Loop through post vars and set string values to numeric values where needed
	$allPostVars = $app->request->post();
	// print_r($allPostVars); exit;
	foreach ($allPostVars as $key => $val) {
		$field_name = $key;
		// echo "field_name: $field_name";
		switch ($field_name) {
			case "org_year_founded":
				$value = intval($val);
				break;
			case "org_profile_year":
				$value = intval($val);
				break;
			case "latitude":
				$value = floatval($val);
				break;
			case "longitude":
				$value = floatval($val);
				break;
			case "use_advocacy":
				$value = (bool)$val;
				break;
			case "use_org_opt":
				$value = (bool)$val;
				break;
			case "use_prod_srvc":
				$value = (bool)$val;
				break;
			case "use_research":
				$value = (bool)$val;
				break;
			case "use_other":
				$value = (bool)$val;
				break;
			default:
				$value = $val;
		}
	}
	// TODO: data checks here
	// echo "(type of field_name: ".gettype($value);
	// Assume one field and it is clean

	// query database for object_id
		// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];
	// echo $objectId;
	// echo " field_name: $field_name ";
	// echo " value: $value ";

	// Update parse using query - does this work?
	$params = array(
		'className' => 'org_profile',
		'objectId' => $objectId,
		'object' => array(
			$field_name => $value
		)
	);

	$request = $parse->update($params);
	$request_array = json_decode($request, true);
	// print_r($request);

	$org_profile[$field_name] = $value;

	// Update all arcgis_flatfile records
	// find arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id,
	        'row_type' => 'org_profile'
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	// print_r($request_decoded);
	if ( count($request_decoded['results']) == 0 ) {
		$content['flatfile_msg'] = "no match in arcgis_flatfile for ${profile_id}";
		// Note in log
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "No matching profile_id ${profile_id} in arcgis_flatfile" );
		exit;
	} else {
		$content['flatfile_msg'] = "Updating ".count($request_decoded['results'])." matches in arcgis_flatfile";
	}

	$arcgis_org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];

	// find all objectIds we need to update in arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$arcgis_flatfile_objects = $request_decoded['results'];

	// update all objects in arcgis_flatfile
	foreach($arcgis_flatfile_objects as $object) {

		$params = array(
			'className' => 'arcgis_flatfile',
			'objectId' => $object['objectId'],
			'object' => array(
				$field_name => $value
			)
		);

		$request = $parse->update($params);
		$request_array = json_decode($request, true);
		$msg = "Updated arcgis_flatfile orbjectId ${object['objectId']}";
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );
	}

	echo "All records updated for profile_id '${profile_id}'. ";

	// Prepare and send template result
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$content['updatedAt'] = $request_array['updatedAt'];
	$content['field_name'] = $field_name;
	$content['value'] = $value;
	$content['profile_id'] =  $profile_id;

	$app->view()->setData(array('content' => $content));
	$app->render('admin/tp_udpatefield_result.php');

});

// **************
$app->get('/admin/survey/syncflatfile/changedfiles', function () use ($app) {

	// This route syncs ALL arcgis_flatfile data with any updates to org_profile data, field by field, record by record.

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	echo "Synching all org_profile data to arcgis_flatfile</br>";
	// $response->status($isPartialContent ? 206 : 200);

	flush();

	$app->redirect("/map/survey/admin/survey/syncflatfile/all_records"); 

});

// **************
$app->get('/admin/survey/syncflatfile/all', function () use ($app) {

	// This route syncs ALL arcgis_flatfile data with any updates to org_profile data, field by field, record by record.

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	echo "Synching all org_profile data to arcgis_flatfile</br>";
	// $response->status($isPartialContent ? 206 : 200);

	flush();

	$app->redirect("/map/survey/admin/survey/syncflatfile/all_records"); 

});

// **************
$app->get('/admin/survey/syncflatfile/:profile_id', function ($profile_id) use ($app) {

	// This route syncs the arcgis_flatfile data with any updates to org_profile data, field by field, record by record.

	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/map/survey/admin/login/"); }

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));


	// Are we synching all records or just one?
	if ( "all_records" == $profile_id ) {
		echo "Get ready to sync all records.<br />";
		$profile_ids = array('478', '479', '480', '481', '484', '511');

		// TODO: This query needs to loop to get all records past 1000 once the list grows that large
		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
			'limit' => '1000'
		);

		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		$org_profiles = $request_array['results'];
		// print_r($org_profiles);

		foreach ($org_profiles as $org_profile) {
			array_push($profile_ids, $org_profile['profile_id']);
			// echo $org_profile['profile_id']."-";
		}

	} else {
		$profile_ids = array($profile_id);
	}

foreach ($profile_ids as $profile_id) {
	# code...

	// query database for object_id
	// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];

	// find arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id,
	        'row_type' => 'org_profile'
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	// print_r($request_decoded);
	if ( count($request_decoded['results']) == 0 ) {
		echo "<br> log no match in arcgis_flatfile for ${profile_id}";
		// Note in log
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "No matching profile_id ${profile_id} in arcgis_flatfile" );
		exit;
	}
	$arcgis_org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];

	// find all objectIds we need to update in arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$arcgis_flatfile_objects = $request_decoded['results'];

	// Loop through fields in org_profile. Where a field is different in org_profile, update arcgis_flatfile field value
	foreach (array_keys($org_profile) as $key) {
		// ignore a few select fields
		if (in_array($key, array('objectId', 'profile_id', 'updatedAt', 'createdAt', 'date_created', 'date_modified'))) { continue; }

		// make sure undefined values don't stop us
		if (!isset($arcgis_org_profile[$key])) { $arcgis_org_profile[$key] = null; }
		
		// compare field values for updates
		if ( $org_profile[$key] != $arcgis_org_profile[$key] ) {
			$msg =  "$key<br>&nbsp; ${org_profile[$key]} | ${arcgis_org_profile[$key]} ";
			echo "<br/>$msg";
			$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );

			// Update all arcgis_profile records parse using query by looping through the related objectIds
			foreach($arcgis_flatfile_objects as $object) {
				echo "--${object['objectId']}--";
				
				$params = array(
					'className' => 'arcgis_flatfile',
					'objectId' => $object['objectId'],
					'object' => array(
						$key => $org_profile[$key]
					)
				);

				$request = $parse->update($params);
				$request_array = json_decode($request, true);
				$msg = "Updated arcgis_flatfile orbjectId ${object['objectId']}";
				$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );
				// print_r($request);
			}
		}
	}


	echo "<br><br>All records updated for profile_id '${profile_id}'.";
	flush(); // send info to screen

} // end loop of profile ids being updated

	exit;

});

// **************
$app->get('/opendata/submitted/csv', function () use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'org_profile',
		'query' => array(
	        'org_profile_status' => "submitted"
			)
	);

	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];

	// echo "<pre>"; print_r($org_profiles); echo "</pre>";

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_csv.php');

});

// **************
$app->get('/survey/opendata/data/org/:profile_id', function ($profile_id) use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// Retrieve org_data_use
	$params = array(
		'className' => 'org_profile',
		'query' => array(
	        'profile_id' => $profile_id
			)
	);

	$request = $parse->query($params);

	// Return results via json
	header('Content-Type: application/json');
	echo $request;
	exit;

});

// **************
$app->get('/data/flatfile.json', function () use ($app) {

	$db = connect_db();
	$sql="select * from org_surveys";
    
	$stmt = $db->query($sql); 
	$query_result1 = $stmt->fetchAll();

	//var_dump($users);
	//fetch all object id first																		
	$object_id = array();
	foreach ($query_result1 as $row ) {
		array_push($object_id, $row['object_id'] );
	}
	//echo "hey";
    $createdAt = array();
	$data_use_type = array();	
	$data_use_type_other = array();
	$industry_id = array();
	$industry_other = array();
	$latitude = array();
	$longitude = array();
	$no_org_url = array();
	$org_additional = array();
	$org_description = array();
	$org_greatest_impact = array();
	$org_greatest_impact_detail = array();
	$org_name = array();
	$org_open_corporates_id = array();
	$org_profile_category = array();
	$org_profile_src = array();
	$org_profile_status = array();
	$org_profile_year = array();
	$org_size_id = array();
	$org_type = array();
	$org_type_other = array();
	$org_url = array();
	$org_year_founded = array();
	$profile_id = array();
	$updatedAt = array();

	$org_hq_city = array();
	$org_hq_city_locode = array();
	$org_hq_st_prov = array();

	$org_hq_country = array();
	$org_hq_country_income = array();
	$org_hq_country_income_code = array();
	$org_hq_country_locode = array();
	$org_hq_country_region = array();
	$org_hq_country_region_code = array();

	$advocacy = array();
	$advocacy_desc = array();
	$org_opt = array();
	$org_opt_desc = array();
	$other = array();
	$other_desc = array();
	$prod_srvc = array();
	$prod_srvc_desc = array();
    $research = array();
    $research_desc = array();

    $data_country_count = array();
	//calculate total number of objects, this will total number of objects in json as well.
	$totalObjects = count($object_id);
	//echo $totalObjects;
	//run for loop those many times.
	for($i = 0;$i < $totalObjects;$i++){
		//echo $object_id[$i];
		$sql="select * from org_profiles where profile_id=?";
    
		$stmt = $db->prepare($sql); 
		$stmt->bindParam(1, $object_id[$i]);
		$stmt->execute();
		$query_result1 = $stmt->fetchAll();

	 	foreach ($query_result1 as $row ) {
	 		//echo $row['object_id'];
	 		array_push($createdAt, $row['createdAt'] );
			array_push($data_use_type, $row['data_use_type']);
			array_push($object_id, $row['object_id'] );
			array_push($data_use_type_other, $row['data_use_type_other'] );
			array_push($industry_id, $row['industry_id'] );
			array_push($industry_other, $row['industry_other'] );
			array_push($latitude, $row['latitude'] );
			array_push($longitude, $row['longitude'] );
			array_push($no_org_url, $row['no_org_url'] );
			array_push($org_additional, $row['org_additional'] );
			array_push($org_description, $row['org_description'] );
			array_push($org_greatest_impact, $row['org_greatest_impact'] );
			array_push($org_greatest_impact_detail, $row['org_greatest_impact_detail'] );
			array_push($org_name, $row['org_name'] );
			array_push($org_open_corporates_id , $row['org_open_corporates_id'] );
			array_push($org_profile_category, $row['org_profile_category'] );
			array_push($org_profile_src , $row['org_profile_src'] );
            array_push($org_profile_status , $row['org_profile_status'] );
            array_push($org_profile_year, $row['org_profile_year'] );
            array_push($org_size_id , $row['org_size_id'] );
            array_push($org_type , $row['org_type'] );
            array_push($org_type_other , $row['org_type_other'] );
            array_push($org_url , $row['org_url'] );
            array_push($org_year_founded, $row['org_year_founded'] );
            array_push($profile_id, $row['profile_id'] );
            array_push($updatedAt, $row['updatedAt'] );
			//write all columns in similar way.
		}
         
        $loc_id = $row['org_loc_id']; 
		$sql1="select * from org_locations_info where object_id=?";
		$stmt = $db->prepare($sql1);
		$stmt->bindParam(1, $loc_id);
		$stmt->execute();

		$query_result2 = $stmt->fetchAll();
		//var_dump($users);
		
		foreach ($query_result2 as $row ) {
			array_push($org_hq_city, $row['org_hq_city']);
			array_push($org_hq_city_locode, $row['org_hq_city_locode'] );
			array_push($org_hq_st_prov, $row['org_hq_st_prov'] );
		}
		$countryId = $row['country_id'];
		//echo $countryId;

		$sql2="select * from org_country_info where country_id=?";
		$stmt = $db->prepare($sql2); 
		$stmt->bindParam(1, $countryId);
		$stmt->execute();

		$query_result3 = $stmt->fetchAll();
		//var_dump($users);

		foreach ($query_result3 as $row ) {
			array_push($org_hq_country, $row['org_hq_country']);
			array_push($org_hq_country_income, $row['org_hq_country_income'] );
			array_push($org_hq_country_income_code, $row['org_hq_country_income_code'] );
			array_push($org_hq_country_locode, $row['org_hq_country_locode'] );
			array_push($org_hq_country_region, $row['org_hq_country_region'] );
			array_push($org_hq_country_region_code, $row['org_hq_country_region_code'] );
		}

		$sql3="select * from data_app_info where profile_id=?";
		$stmt = $db->prepare($sql3); 
		$stmt->bindParam(1, $object_id[$i]);
		$stmt->execute();

		$query_result4 = $stmt->fetchAll();
		//var_dump($users);
		//echo "hey";
		foreach ($query_result4 as $row ) {
			array_push($advocacy, $row['advocacy']);
			array_push($advocacy_desc, $row['advocacy_desc'] );
			array_push($org_opt, $row['org_opt'] );
			array_push($org_opt_desc, $row['org_opt_desc'] );
			array_push($other, $row['other'] );
			array_push($other_desc, $row['other_desc'] );
			array_push($prod_srvc, $row['prod_srvc'] );
			array_push($prod_srvc_desc, $row['prod_srvc_desc'] );
			array_push($research, $row['research'] );
			array_push($research_desc, $row['research_desc'] );
		}

		$sql4="select * from org_data_sources where profile_id=? limit 1";
		$stmt = $db->prepare($sql4); 
		$stmt->bindParam(1, $object_id[$i]);
		$stmt->execute();

		$query_result5 = $stmt->fetchAll();
		//var_dump($users);

		foreach ($query_result5 as $row ) {
			array_push($data_country_count, $row['data_country_count']);
		}
	}
	//var_dump($advocacy);
	// //echo $org_hq_city_locode[0];
	// //echo $object_id[0];

	$allArrays = array();
	$finalArray = array();

	for ($i = 0; $i < $totalObjects; $i++) {

		$allArrays['createdAt'] = $createdAt[$i];
		$allArrays['data_country_count'] = $data_country_count[$i];
		$allArrays['data_use_type'] = $data_use_type[$i];
		$allArrays['data_use_type_other'] = $data_use_type_other[$i];
		$allArrays['industry_id']= $industry_id[$i];
		$allArrays['industry_other'] = $industry_other[$i];
		$allArrays['latitude'] = $latitude[$i];
		$allArrays['longitude'] = $longitude[$i];
		$allArrays['no_org_url']= $no_org_url[$i];
		$allArrays['object_id']= $object_id[$i];
		$allArrays['org_additional'] = $org_additional[$i];
		$allArrays['org_description'] = $org_description[$i];
		$allArrays['org_greatest_impact'] = $org_greatest_impact[$i];
		$allArrays['org_greatest_impact_detail'] = $org_greatest_impact_detail[$i];
		$allArrays['org_hq_city'] = $org_hq_city[$i];
		$allArrays['org_hq_city_locode'] = $org_hq_city_locode[$i];
		$allArrays['org_hq_country'] = $org_hq_country[$i];
		$allArrays['org_hq_country_income'] = $org_hq_country_income[$i];
		$allArrays['org_hq_country_income_code'] = $org_hq_country_income_code[$i];
		$allArrays['org_hq_country_locode'] = $org_hq_country_locode[$i];
		$allArrays['org_hq_country_region'] = $org_hq_country_region[$i];
		$allArrays['org_hq_country_region_code'] = $org_hq_country_region_code[$i];
		$allArrays['org_hq_st_prov'] = $org_hq_st_prov[$i];
		$allArrays['org_name'] = $org_name[$i];
		$allArrays['org_open_corporates_id'] = $org_open_corporates_id[$i];
		$allArrays['org_profile_category'] = $org_profile_category[$i];
		$allArrays['org_profile_src'] = $org_profile_src[$i];
		$allArrays['org_profile_status'] = $org_profile_status[$i];
		$allArrays['org_profile_year'] = $org_profile_year[$i];
		$allArrays['org_size_id'] = $org_size_id[$i];
		$allArrays['org_type'] = $org_type[$i];
		$allArrays['org_type_other'] = $org_type_other[$i];
		$allArrays['org_url'] = $org_url[$i];
		$allArrays['org_year_founded'] = $org_year_founded[$i];
		$allArrays['profile_id'] = $profile_id[$i];
		$allArrays['updatedAt'] = $updatedAt[$i];
		$allArrays['advocacy'] = $advocacy[$i];
		$allArrays['advocacy_desc'] = $advocacy_desc[$i];
		$allArrays['org_opt'] = $org_opt[$i];
		$allArrays['org_opt_desc'] = $org_opt_desc[$i];
		$allArrays['other'] = $other[$i];
		$allArrays['other_desc'] = $other_desc[$i];
		$allArrays['prod_srvc'] = $prod_srvc[$i];
		$allArrays['prod_srvc_desc'] = $prod_srvc_desc[$i];
		$allArrays['research'] = $research[$i];
		$allArrays['research_desc'] = $research_desc[$i];
		array_push($finalArray, $allArrays);
	}
	//var_dump($finalArray);
	$jsonArray = array("results" => $finalArray);
	echo json_encode($jsonArray);
	// //echo $users['object_id'];
	// //echo json_encode($users);
	// // $parse = new parseRestClient(array(
	// 	'appid' => PARSE_APPLICATION_ID,
	// 	'restkey' => PARSE_API_KEY
	// ));

	// // Initialize variables for loop
	// $arcgis_rows = array();
	// $skip = 0;
	// $retrieved = 0;

	// // Retrieve all records from parse.com, 1000 records at a time b/c 1000 records is the max allowed
	// // Build up a single array of all retrieved records
	// while ( $skip == 0 OR $retrieved > 0 ) {

	// 	$params = array(
	// 		'className' => 'arcgis_flatfile',
	// 		'query' => array(
	// 			'org_profile_status' => 'publish'
	// 		),
	// 		'limit' => '1000',
	// 		'skip' => $skip
	// 	);

	// 	$request = $parse->query($params);
	// 	$request_array = json_decode($request, true);

	// 	foreach ($request_array['results'] as &$item){
	// 		unset($item['objectId']);
	// 	}
		
	// 	$retrieved = count($request_array['results']);
	// 	if ($retrieved > 0) {
	// 		// Use array_merge_recursive to keep merged array flat
	// 		$arcgis_rows = array_merge_recursive($arcgis_rows,$request_array['results']);
	// 	}
	// 	// echo "$retrieved ";
	// 	// increment skip
	// 	$skip = $skip + 1000;
	// }
	// // We now have all records in one big array in $arcgis_rows

	// array_walk($arcgis_rows, 'fixFlatfileValues');


	// // Let's convert to json and send using expected format with 'results' key
	// $arcgis_flatfile = array("results" => $arcgis_rows);
	// // $arcgis_flatfile = array("results" => array_slice($arcgis_rows,1,2));
	// header('Content-Type: application/json');
	// echo json_pretty(json_encode($arcgis_flatfile));

	return true;
});

/*
 * ArcGIS Online routes
 */

// **************
$app->get('/data/agol/addFeatures/json/:profile_id', function ($profile_id) use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// retrieve the record from parse
	// Retrieve org_data_use
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);

	$request = $parse->query($params);
	// print_r($request);
	$request_array = json_decode($request, true);

	$arcgis_rows = array( $request_array['results'][0] );

	array_walk($arcgis_rows, 'addFeaturesFormatting');

	// Let's convert to json and send using expected format with 'results' key
	$arcgis_flatfile = array( array("attributes" => $arcgis_rows[0]) ) ;
	// // $arcgis_flatfile = array("results" => array_slice($arcgis_rows,1,2));
	header('Content-Type: application/json');
	echo json_pretty(json_encode($arcgis_flatfile));

	return true;
});

// *****************
$app->get('/argis/auth/', function () use ($app) {

	$params = array(
	    'client_id' => ArcGIS_CLIENT_ID,
	    'client_secret' => ArcGIS_CLIENT_SECRET,
	    'grant_type' => 'client_credentials',
	    'f' => 'json'
	);

	try {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    $response = curl_exec($ch);
	} catch (Exception $e) {
	    error_log($e->getMessage(), 0);
	}

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$body = substr($response, $header_size);
	$json = json_decode($body, true);
	$token = $json['access_token'];
	echo $token;

});

// *****************
$app->get('/argis/geoservice/', function () use ($app) {

	$params = array(
	    'client_id' => ArcGIS_CLIENT_ID,
	    'client_secret' => ArcGIS_CLIENT_SECRET,
	    'grant_type' => 'client_credentials',
	    'f' => 'json'
	);

	try {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    $response = curl_exec($ch);
	} catch (Exception $e) {
	    error_log($e->getMessage(), 0);
	}

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$body = substr($response, $header_size);
	$json = json_decode($body, true);
	$token = $json['access_token'];
	echo $token;

});

/*
 * Development routes
 */
// ************


// ************
$app->run();

?>
