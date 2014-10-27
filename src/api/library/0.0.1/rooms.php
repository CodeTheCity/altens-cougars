<?php

if ( isset ( $_GET['building'] ) && !isset ( $_GET['floor'] ) ) {

	//
	//
	//
	
	$query = mysql_query("SELECT a.building_id, a.floor_id, a.room_id, a.room_name, b.floor_name, b.floor_plan, c.booking_id, c.booking_from, c.booking_to FROM rooms as a INNER JOIN floors as b ON a.floor_id = b.floor_id LEFT JOIN bookings as c ON a.room_id = c.room_id WHERE a.building_id = '" . intval($_GET['building']) . "'");

} elseif ( !isset ( $_GET['building'] ) && isset ( $_GET['floor'] ) ) {

	$query = mysql_query("SELECT a.building_id, a.floor_id, a.room_id, a.room_name, b.floor_name, b.floor_plan, c.booking_id, c.booking_from, c.booking_to FROM rooms as a INNER JOIN floors as b ON a.floor_id = b.floor_id LEFT JOIN bookings as c ON a.room_id = c.room_id WHERE a.floor_id = '" . intval($_GET['floor']) . "'");

} else {

	//
	// Thing
	//
	
	$query = mysql_query("SELECT a.building_id, a.floor_id, a.room_id, a.room_name, b.floor_name, b.floor_plan, c.booking_id, c.booking_from, c.booking_to FROM rooms as a INNER JOIN floors as b ON a.floor_id = b.floor_id LEFT JOIN bookings as c ON a.room_id = c.room_id");

}

while ( $row = mysql_fetch_assoc($query) ) {

	$temp = array(
		'building' => array (
			'id' => $row['building_id'],
		),
		'floor' => array (
			'id' => $row['floor_id'],
			'name' => $row['floor_name'],
			'plan' => $row['floor_plan'],
		),
		'id' => $row['room_id'],
		'name' => $row['room_name'],
	);
	
	if ( $row['booking_from'] ) {
	
		$temp['available'] = false;
		$temp['booking'] = array (
			'id' => $row['booking_id'],
			'from' => $row['booking_from'],
			'to' => $row['booking_to'],
			'from_timestamp' => strtotime($row['booking_from']),
			'to_timestamp' => strtotime($row['booking_to']),
		);
	
	} else {
	
		$temp['available'] = true;
		$temp['booking'] = array ();
	
	}
	
	$coords = array();
	
	$query2 = mysql_query("SELECT coord_x as x, coord_y as y FROM coords WHERE coord_room = '" . $row['room_id'] . "'");
	while ($row2 = mysql_fetch_assoc($query2)) {
	
		$coords[] = $row2;
	
	}
	
	$temp['coords'] = $coords;
	
	$data[] = $temp;

}

outputResponse($data);

?>