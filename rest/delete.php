<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('api/Rest.php');
$api = new Rest();
switch($requestMethod) {
	 case 'GET':
		  $mahaId = '';
		  if(isset($_GET['id'])) {
			   $mahaId = $_GET['id'];
		  }
		  $api->deleteMaha($mahaId);
		  break;
	 default:
		  header("HTTP/1.0 405 Method Not Allowed");
	 break;
}
?>