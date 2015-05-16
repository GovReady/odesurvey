<?php

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
define(ODESURVEY_LOG, "/var/log/odesurvey/odesurvey.log");

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
$logWriter = new \Slim\LogWriter(fopen('/var/log/odesurvey/odesurvey.log', 'a'));

// Start Slim instance
//-------------------------------
$app = new \Slim\Slim(array('log.writer' => $logWriter));

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
	
//     $content['title'] = "Open Data Impact Map Admin";
//     $content['intro'] = <<<HTML
// 		<p>Open Data Impact Map Admin</p>
// HTML;

// 	// return $app->response->setBody($response);
// 	// Render content with simple bespoke templates
// 	$app->view()->setData(array('content' => $content));
// 	$app->render('admin/tp_login.php');
    
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
$app->get('/', function () use ($app) {
	
    $app->redirect("/map/survey/start");

});

// ************
$app->get('/admin/delete/test/confirmed', function () use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

// 	$params = array(
//     'className' => 'gameScore',
//     'object' => array(),
//     'query' => array(
//         'score' => array(
//             '$gt' => 500
//         )
//     ),
//     'order' => '-score',
//     'limit' => '2',
//     'skip' => '2'
// );
	

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

	// $survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");

	// # store new information as new record 
 //    $parse_params = array(
	// 	'className' => 'survey',
	// 	'object' => $survey_object
 //    );
	// // Create Parse object and save
 //    $request = $parse->create($parse_params);
 //    $response = json_decode($request, true);

 //    if(isset($response['objectId'])) {
 //    	// Success
 //    	$app->redirect("/survey/opendata/".$response['objectId']);
 //    } else {
 //    	// Failure
 //    	echo "Problem. Promlem with record creation not yet handled.";
 //    	exit;
 //    	$app->redirect("/error".$response['objectId']);
 //    }
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
    $request = $parse->create($parse_params);
    $response = json_decode($request, true);

    if(isset($response['objectId'])) {
    	// Success
    	$app->redirect("/map/survey/".$response['objectId']);
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }
});

// ************
$app->get('/:surveyId', function ($surveyId) use ($app) {
	
	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new survey created, ...");
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	// If survey submitted, handle differently
	$params = array(
	    'className' => 'org_profile',
	    'object' => array(),
	    'query' => array(
	        'profile_id' => $surveyId
	    ),
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);

	// here is where we test
	if (0 < sizeof($request_decoded['results'])) {
		echo "This survey has already been started or submitted.";
		print_r($request_decoded);
		echo "len ". sizeof($request_decoded['results']);
		$org_profile = $request_decoded['results'][0];
			// $app->redirect("/survey/opendata/".$surveyId."/thankyou/");
			//$app->get('/survey/opendata/:surveyId/submitted/', function ($surveyId) use ($app) {
		$app->redirect("/map/survey/".$surveyId."/submitted/");
	}

	//HTylD69YaB
	// bring up new blank survey
	$content['surveyId'] = $surveyId;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey";

	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_survey_duprofile.php');

});

// du new post here
// ************
$app->post('/2du/:surveyId/', function ($surveyId) use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

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

    // Copy country abbreviation to loc code
    $allPostVars["org_hq_country_locode"] = $allPostVars["org_hq_country"];

	// echo "<pre>";print_r($allPostVars);echo "</pre>"; 
	// exit;

	// ============================
	// Prepare and save org_object
	// ============================
	/* Saves once per survey submission */
    $params = array("org_name", "org_open_corporates_id", "org_type", "org_type_other", "org_url", "no_org_url", "org_year_founded", "org_description", "org_size_id", "industry_id", "industry_other", "org_greatest_impact", "org_greatest_impact_detail", "use_advocacy", "use_advocacy_desc", "use_prod_srvc", "use_prod_srvc_desc", "use_org_opt", "use_org_opt_desc", "use_research", "use_research_desc", "use_other", "use_other_desc", "org_hq_city", "org_hq_st_prov", "org_hq_country", "latitude", "longitude", "org_hq_city_locode", "org_hq_country_locode", "org_profile_year", "org_additional", "org_profile_status", "org_profile_src", "org_profile_category");
    $org_object = array();
    // Set all parameters to received value or null
    foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$org_object[$param] = $allPostVars[$param];
    }
	// Set string values to boolean values
	$params = array("no_org_url", "use_prod_srvc", "use_org_opt", "use_research", "use_other");
	foreach ($params as $param) {
		if (is_null($org_object[$param])) {
			$org_object[$param] = false;
		} else {
			$org_object[$param] = true;
		}
	}

	// Add Worldbank Region and Economic code data
	echo "org_hq_country_locode".$org_object['org_hq_country_locode'];
    $wb_region = addWbRegions($org_object['org_hq_country_locode']);
    $org_object['org_hq_country_region'] = $wb_region['org_hq_country_region'];
    $org_object['org_hq_country_region_code'] = $wb_region['org_hq_country_region_code'];
    $org_object['org_hq_country_income'] = $wb_region['org_hq_country_income'];
    $org_object['org_hq_country_income_code'] = $wb_region['org_hq_country_income_code'];

	// set profile_id
	$org_object['profile_id'] = $surveyId;

	// save org_object to Parse
	$parse_params = array(
		'className' => 'org_profile',
		'object' => $org_object
	);
	$request = $parse->create($parse_params);
	$response = json_decode($request, true);
	// echo "<pre>"; print_r($response); echo "</pre>";

	// ============================================================================
	// Prepare and save org_object into arcgis_flatfile as row_type = org_profile
	// ============================================================================
	/* Saves once per survey submission */
	// remove certain fields from org_profile
	$remove_keys = array ("use_prod_srvc_desc", "use_org_opt_desc", "use_research_desc", "use_other_desc", "org_additional");
	foreach ( $remove_keys as $key) {
		if (array_key_exists($key, $org_object)) {
			unset($org_object[$key]);
		}
	}
	// Identify row as org profile in flattened file for ARC GIS
	$org_object['row_type'] = 'org_profile';
	// Prepare parse.com params
	$parse_params = array(
		'className' => 'arcgis_flatfile',
		'object' => $org_object
	);
	$request = $parse->create($parse_params);
	$response = json_decode($request, true);
	if(!isset($response['createdAt'])) {
		echo "<br>Problem. Problem saving how data is used create not yet handled.";
		// log error and generate email to admins
		exit;
	}

	// ================================
	// Prepare and save contact_object
	// ================================
	/* Saves once per survey submission */
    $params = array("org_name", "org_profile_src", "survey_contact_first", "survey_contact_last", "survey_contact_title", "survey_contact_email", "survey_contact_phone");
    $contact_object = array();
    // Set all parameters to received value or null
    foreach ($params as $param) {
    	if (!isset($allPostVars[$param])) { $allPostVars[$param] = null; }
    	$contact_object[$param] = $allPostVars[$param];
    }
    // set profile_id
	$contact_object['profile_id'] = $surveyId;
	// save contact_object to Parse
	$parse_params = array(
		'className' => 'org_contact',
		'object' => $contact_object
	);
	$request = $parse->create($parse_params);
	$response = json_decode($request, true);
	if(!isset($response['createdAt'])) {
		echo "<br>Problem. Problem saving how data is used create not yet handled.";
		// log error and generate email to admins
		exit;
	}

	// ============================================================================================
	// Prepare and save data_use_object and arcgis_object combining data_use_object and org_object
	// ============================================================================================
	/* Saves multiple times per survey submission, once for each data use into two tables */
	$idSuffixNum = 1;

	// dataUseData-2]
	while (array_key_exists('dataUseData-'.$idSuffixNum, $allPostVars)) {
		if (is_null($allPostVars['dataUseData-'.$idSuffixNum])) { continue; }

		// echo "<br>$idSuffixNum";
		// echo "============\n<br>";
		$data_use_object = array();
		foreach ($allPostVars['dataUseData-'.$idSuffixNum] as $row) {
			// echo "<pre>";print_r($row);echo "</pre>";
			$src_country = $row['src_country_locode'];

			foreach ($row['type'] as $type => $details) {
				foreach ($details['src_gov_level'] as $gov_level) {
					// echo "<br>$src_country|$type|$gov_level";
					$data_use_object['data_src_country_locode'] = $src_country;
					$data_use_object['data_type'] = $type;
					$data_use_object['data_src_gov_level'] = $gov_level;
					// set profile_id
					$data_use_object['profile_id'] = $surveyId;
					// identify row as data use row for flattened file for ARC GIS
					$data_use_object['row_type'] = 'data_use';
					// echo "<pre>";print_r($data_use_object);echo "</pre>";

					// save data_use_object to Parse
					$parse_params = array(
						'className' => 'org_data_use',
						'object' => $data_use_object 	// contains data for org_data_use row
					);
					$request = $parse->create($parse_params);
					$response = json_decode($request, true);
					// print_r($response); echo "<br />";
					if(!isset($response['createdAt'])) {
						echo "<br>Problem. Problem saving how data is used create not yet handled.";
						// log error and generate email to admins
						exit;
					}

					// merge org_profile and data_use objects and save to parse for arcgis
					$arcgis_object = array_merge($org_object, $data_use_object);
					$parse_params = array(
						'className' => 'arcgis_flatfile',
						'object' => $arcgis_object 	// contains data for org_data_use row
					);
					$request = $parse->create($parse_params);
					$response = json_decode($request, true);
					// print_r($response); echo "<br />";
					if(!isset($response['createdAt'])) {
						echo "<br>Problem. Problem saving how data is used create not yet handled.";
						// log error and generate email to admins
						exit;
					}
				}
			}
		}
		$idSuffixNum++;
	}

	// If we made it here, everything saved.

	// ==========================================
	// All data saved, send a confirmation email
	// ==========================================
	/* Send one per survey submission */
	// Instantiate the client.
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

	$app->redirect("/map/survey/".$surveyId."/thankyou/");
});
// end du new post here

// ************
$app->get('/:surveyId/thankyou/', function ($surveyId) use ($app) {
	
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

	$content['surveyId'] = $surveyId;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Thank You";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile ));
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

	// Retrieve org_data_use
	$params = array(
		'className' => 'org_data_use',
		'query' => array(
	        'profile_id' => $surveyId
			)
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_data_use = $request_decoded['results'];

	$content['surveyId'] = $surveyId;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Submitted";
	
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

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    	)
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	if (count($request_decoded['results']) > 0) {
		// No result redirect to error
		$org_profile = $request_decoded['results'][0];
		// echo "<pre>"; print_r($request_decoded); 
	} else {
		$app->redirect("/map/org/".$profile_id."/notfound/");
	}
	
	$content['surveyId'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit Message";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile ));
	$app->render('survey/tp_profile_edit_msg.php');

});

// ************
$app->get('/edit/:profile_id/form', function ($profile_id) use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    	)
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	if (count($request_decoded['results']) > 0) {
		// No result redirect to error
		$org_profile = $request_decoded['results'][0];
		// echo "<pre>"; print_r($request_decoded); 
	} else {
		$app->redirect("/map/survey/".$profile_id."/notfound/");
	}
	
	// Retrieve org_data_use
	$params = array(
		'className' => 'org_data_use',
		'query' => array(
	        'profile_id' => $profile_id
			)
	);

	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_data_use = $request_decoded['results'];

	$content['surveyId'] = $profile_id;

	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use ));
	$app->render('survey/tp_profile_edit.php');

});

// ************
$app->get('/:profile_id/notfound/', function ($profile_id) use ($app) {

	$content['profile_id'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['title'] = "Open Data Enterprise Survey - Problem";
	$content['error_msg_title'] = "Organization not found.";
	$content['error_msg_details'] = "We did not find any organization for profile: $profile_id.";
	
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_problem.php');

});

// **************
$app->get('/survey/opendata/list/new/', function () use ($app) {

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

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_grid_map.php');

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

	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_grid_map.php');

});

// **************
$app->get('/survey/opendata/list/new/csv', function () use ($app) {

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

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'arcgis_flatfile',
		'limit' => '1000'
	);

	$request = $parse->query($params);
	// Return results via json
	header('Content-Type: application/json');
	echo $request;
	exit;

	$request_array = json_decode($request, true);
	$org_combined = $request_array['results'];

	echo "<pre>"; print_r($org_combined); echo "</pre>"; 

});

// **************
$app->get('/survey/opendata/data/flatfile.json', function () use ($app) {

	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));

	$params = array(
		'className' => 'arcgis_flatfile',
		'limit' => '1000'
	);

	$request = $parse->query($params);
	// Return results via json
	header('Content-Type: application/json');
	echo $request;
	exit;

	$request_array = json_decode($request, true);
	$org_combined = $request_array['results'];

	echo "<pre>"; print_r($org_combined); echo "</pre>"; 

});

/*
 * ArcGIS Online routes
 */
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
$app->get('/gettext/', function () use ($app) {

	$content['title'] = "Open Data Enterprise Survey"; 
	
	$app->view()->setData(array('content' => $content));
	$app->render('gettext/tp_home.php');
});

// ************
$app->run();

?>