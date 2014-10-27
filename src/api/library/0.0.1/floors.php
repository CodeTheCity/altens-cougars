<?php

if ( !isset ( $_GET['building'] ) ) {

	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	
	$result = array (
		'status' => 404,
		'error' => array (
			'comment' => 'You must enter a valid building ID. i.e. ' . API_BASE_URL . 'buildings?id=1'
		)
	);
	
	outputResponse($result);

}

$query = mysql_query("SELECT * FROM floors WHERE building_id = '" . intval($_GET['building']) . "'");
while ( $row = mysql_fetch_assoc($query) ) {

	$row['floors'] = API_BASE_URL . 'floors/?building=' . $row['building_id'];
	
	$data[] = $row;

}

outputResponse($data);

?>