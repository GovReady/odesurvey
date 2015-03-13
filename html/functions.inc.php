<?php

/*
 * file: functions.inc.php
 * version: 0.0.2
 */

function getSystemFromSystemName($systemName, $parse) {
	// Get system Id
	$params = array(
	    'className' => 'System',
	    'query' => array(
        	'systemName' => $systemName
    	),
	);

	$request = $parse->query($params);
	$response = json_decode($request, true);
	$systems = $response['results'];
	// Temporarily assume there is only system matching name...
	$system = $systems[0];

	return $system;
}


?>