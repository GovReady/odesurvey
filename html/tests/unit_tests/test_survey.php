<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');
require_once('utilities.php');

// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('America/New_York'); 

class TestOfSurvey extends WebTestCase {

    function testSurveyStarts() {
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/survey/opendata/start');
        $this->assertResponse(200);
        $this->assertTitle('Open Data Enterprise Survey');
        // $this->assertText('as publicly available Data');
        echo $this->getUrl();
    }

    function testSurveySubmitComplete() {


    	$this->get('http://'.$_SERVER['HTTP_HOST'].'/survey/opendata/start');
        $this->assertResponse(200);
        
        $this->setField("org_name", "SimpleTestCo");
    	$this->setField("org_url", "http://www.simpletestco.com");
    	$this->setField("org_year_founded", "2004");
    	$this->setField("org_description", "This is a test description.");
    	$this->setField("org_additional", "This organization has a big impact...");
    	$this->setField("survey_contact_first", "Greg");
    	$this->setField("survey_contact_last", "Elin");
    	$this->setField("survey_contact_title", "Director of Surveys");
    	$this->setField("survey_contact_email", "greg@odesurvey.org");
    	$this->setField("survey_contact_phone", "505-555-1212");

		$this->setField("org_hq_city_all", "Chicago, IL, USA");
		$this->setField("org_hq_city", "Chicago");
		$this->setField("org_hq_st_prov", "Illinois");
		$this->setField("org_hq_country", "US");
		$this->setField("latitude", "41.8781136");
		$this->setField("longitude", "-87.62979819999998");

    	// test a field
    	$this->assertField('survey_contact_first', 'Greg');
    	
    	// NOTE Form will submit without Javascript validation !!
    	$this->clickSubmitById("btnSubmit");
    	$this->assertResponse(200);
    	// $this->assertText('Additional information');
    	$this->assertTitle('Open Data Enterprise Survey - Thank You');


    }

    // function testSurveyRawSubmit() {
    // 	$this->post(
    //             $this->get('http://'.$_SERVER['HTTP_HOST'].'/survey/opendata/2du/0000000000'),
    //             array('type' => 'superuser'));
    //     $this->assertNoText('user created');
    // }

}
?>
