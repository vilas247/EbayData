<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$seller_ebay_id = $_GET['seller_ebay_id'];

$res = get_json_response($header, array(), SELLER_PROFILES_API_URL.'?seller_ebay_id='.$seller_ebay_id);

$req = SELLER_PROFILES_API_URL.'?seller_ebay_id='.$seller_ebay_id;
$api_response = $res;
$check_errors = json_decode($res);
if(isset($check_errors->errors)){
	echo "Error Response<br/>";exit;
}else{
	if(json_last_error() === 0) {
		$sql = "INSERT INTO ebay_seller_profile_data(ebay_id, api_request,api_response) values('".$seller_ebay_id."', '".$req."','".mysqli_real_escape_string($conn, $api_response)."')";
		mysqli_query($conn,$sql);
		print_r($api_response);exit;
	}
}

?>