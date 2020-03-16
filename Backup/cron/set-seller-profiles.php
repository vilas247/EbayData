<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$res = get_json_response($header, array(), SELLER_PROFILES_API_URL);

$req = "";
$api_response = $res;
json_decode($res);
if(json_last_error() === 0) {
	$sql = "INSERT INTO ebay_seller_profile_data(api_request,api_response) values('".$req."','".$api_response."')";
	mysqli_query($conn,$sql);
	print_r($api_response);exit;
}

?>