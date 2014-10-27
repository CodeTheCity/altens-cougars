<?php

switch ( $_SERVER['REQUEST_METHOD'] ) {

	case 'GET':
	
		if ( !isset ( $_GET['from'] ) ) {
			$_GET['from'] = date("Y-m-d H:i:s");
		}
		
		if ( isset ( $_GET['room'] ) ) {
			$_GET['room'] = ' room_id = \'' . intval ( $_GET['room'] ) . '\' AND ';
		} else {
			$_GET['room'] = '';
		}
		
		$query = mysql_query ("SELECT * FROM bookings WHERE" . $_GET['room'] . " booking_to >= '" . date("Y-m-d H:i:s", strtotime ( $_GET['from'] ) ) . "'");
		header ('X-foo: ' . "SELECT * FROM bookings WHERE" . $_GET['room'] . " booking_to >= '" . date("Y-m-d H:i:s", strtotime ( $_GET['from'] ) ) . "'" );
		while ( $row = mysql_fetch_assoc ( $query ) ) {
		
			$data['rooms'][$row['room_id']] = array (
				'id' => $row['booking_id'],
				'from' => $row['booking_from'],
				'to' => $row['booking_to'],
				'from_timestamp' => strtotime($row['booking_from']),
				'to_timestamp' => strtotime($row['booking_to']),
			);
		
		}
		
		outputResponse($data);
	
	break;
	case 'POST':
	
		
	
	break;
	case 'DELETE':
	
		
	
	break;

}

?>