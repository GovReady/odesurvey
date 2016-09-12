<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// for profit query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
			where org_loc_id = org_locations_info.object_id
			and org_locations_info.country_id = org_country_info.country_id
			and org_hq_country_region = "Middle East & North Africa"
			and org_type = "For-profit"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_type = "For Profit";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'Middle East & North Africa'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

// nonprofit query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
			where org_loc_id = org_locations_info.object_id
			and org_locations_info.country_id = org_country_info.country_id
			and org_hq_country_region = "Middle East & North Africa"
			and org_type = "Nonprofit"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_type = "Nonprofit";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'Middle East & North Africa'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

	// developer group query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
			where org_loc_id = org_locations_info.object_id
			and org_locations_info.country_id = org_country_info.country_id
			and org_hq_country_region = "Middle East & North Africa"
			and org_type = "Developer group"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_type = "Developer Group";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'Middle East & North Africa'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

	// other query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
			where org_loc_id = org_locations_info.object_id
			and org_locations_info.country_id = org_country_info.country_id
			and org_hq_country_region = "Middle East & North Africa"
			and org_type = "Other"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_type = "Other";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'Middle East & North Africa'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

	echo json_encode($data);
?>