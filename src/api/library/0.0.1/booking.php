<?php

switch ( $_SERVER['REQUEST_METHOD'] ) {

	case 'GET':
	
		if ( isset ( $_GET['id'] ) ) {
		
			$query = mysql_query ("SELECT booking_id as id, room_id as room, booking_from as `from`, booking_to as `to` FROM bookings WHERE booking_id = '" . intval( $_GET['id'] ) . "'");
			$booking = mysql_fetch_assoc ( $query );
			
			outputResponse($booking);
		
		}
	
	break;
	case 'POST':
	
		if ( !isset ( $_POST['room'] ) ) {
			$errors[] = 'The room ID must be provided as `room`';
		}
		if ( !isset ( $_POST['from'] ) ) {
			$errors[] = 'The start date and time of the booking must be provided as `from`';
		}
		if ( !isset ( $_POST['to'] ) ) {
			$errors[] = 'The end date and time of the booking must be provided as `to`';
		}
		
		if ( isset ( $errors ) && is_array ( $errors ) ) {
		
			header( $_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden' );
			
			$result = array (
				'status' => 403,
				'error' => array (
					$errors
				)
			);
			
			outputResponse($result);
		
		}
		
		mysql_query ("INSERT INTO bookings SET room_id, booking_from, booking_to VALUES ('" . $_POST['room'] . "', '" . date("Y-m-d H:i:s", strtotime( $_POST['from'] ) ) . "', '" . date("Y-m-d H:i:s", strtotime( $_POST['to'] ) ) . "')");
	
	break;
	case 'DELETE':
	
		
	
	break;

}

?>