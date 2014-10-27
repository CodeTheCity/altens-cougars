<?php

$query = mysql_query("SELECT building_id, building_name FROM buildings");
while ( $row = mysql_fetch_assoc($query) ) {

	$row['floors'] = API_BASE_URL . 'floors/?building=' . $row['building_id'];
	$row['rooms'] = API_BASE_URL . 'rooms/?building=' . $row['building_id'];
	
	$data[] = $row;

}

outputResponse($data);

?>