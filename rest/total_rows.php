<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('api/Rest.php');
$api = new Rest();
switch($requestMethod) {
	case 'GET':
	$mahaQ = '';
	if(isset($_GET['q'])) {
			$mahaQ = $_GET['q'];
		}
			$api->getMaha_total_rows($mahaQ);
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
		break;
}
?>