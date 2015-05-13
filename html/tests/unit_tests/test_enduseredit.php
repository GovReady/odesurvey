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

    function testEndUserEditStarts() {
        echo "<p>Todo: Need a way to create and test an existing record.</p>";
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/org/rKemc0O5G9/edit/');
        $this->assertResponse(200);
        $this->assertTitle('Open Data Enterprise Survey - Edit');
        // $this->assertText('as publicly available Data');
        // echo $this->getUrl();
    }

    function testErrorPage() {
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/org/:0009000/notfound/');
        $this->assertResponse(200);
        // make sure problem page appears
        $this->assertTitle('Open Data Enterprise Survey - Problem');
        // $this->assertText('as publicly available Data');
        // echo $this->getUrl();
    }

    function testErrorOrgNotFound() {
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/org/:0009000/edit/');
        $this->assertResponse(200);
        // make sure problem page appears
        $this->assertTitle('Open Data Enterprise Survey - Problem');
        // $this->assertText('as publicly available Data');
        // echo $this->getUrl();
    }
}
?>
