<?php

function setContentType($type) {

	switch ($type) {
		case 'xml': // XML
			define ('CONTENT_TYPE', 'application/xml');
		break;
		default: // JSON
			define ('CONTENT_TYPE', 'application/json');
		break;
	}
	header ('Content-type: ' . CONTENT_TYPE);

}

function outputResponse($result) {

	switch ($request['extension']) {
		case 'xml': // XML
			//
		break;
		default: // JSON
			echo json_encode ($result);
		break;
	}
	exit();

}

?>