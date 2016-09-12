<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1-10 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Agriculture"
			and org_size_id ="1-10";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "1-10";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	


// 11-50 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Agriculture"
			and org_size_id ="11-50";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "11-50";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// 51-200 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Agriculture"
			and org_size_id ="51-200";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "51-200";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// 201-1000 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Agriculture"
			and org_size_id ="201-1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "201-1000";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// 1000 query
	// $sql = 'SELECT count(distinct(org_name)) as "East Asia & Pacific" from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "East Asia & Pacific"
	// 		and org_size_id = "1000"
	// 		and org_profile_status = "publish";';

	// if(!$result = $db->query($sql)){
	//     die('There was an error running the query [' . $db->error . ']');
	// }

	// while($row = $result->fetch_assoc()){
	// 	// $string = (int)$row["count(distinct(org_name))"];
	// 	$data[] = $row;
	// }

	// echo $string;

// 1000+ query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Agriculture"
			and org_size_id ="1000+";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "1000+";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	echo json_encode($data);
?>	