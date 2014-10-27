<?php

session_start();

define ('API_VER', '1.0.0');
define ('API_BASE_URL', 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/api/');

require_once ('inc/secure.inc.php');
require_once ('inc/functions.inc.php');

$request = pathinfo ($_SERVER['PATH_INFO']);

if (!isset($request['extension'])) {
	$request['extension'] = 'json';
}

define ('FILE_EXT', $request['extension']);

setContentType (FILE_EXT);

$request['library'] = 'library' . $request['dirname'] . $request['filename'];

if (!empty($request['filename']) && file_exists($request['library'].'.php')) {

	include ($request['library'] . '.php');

} elseif (!empty($request['filename']) && file_exists('library/' . API_VER . $request['dirname'] . $request['filename'] . '.php')) {

	include ('library/' . API_VER . $request['dirname'] . $request['filename'] . '.php');

} else {

	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	
	$result = array (
		'status' => 404,
		'error' => array (
			'comment' => 'not found'
		)
	);
	
	outputResponse($result);
	
	exit();

}

?>