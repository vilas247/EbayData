<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$sql = "select * from ebay_seller_profile_data WHERE ebay_id='".$seller_ebay_id."' ORDER BY id DESC LIMIT 1";
$res = mysqli_query($conn, $sql);

if(!empty($res) && mysqli_num_rows($res) > 0){
	$response = $res->fetch_assoc();
	print_r($response['api_response']);exit;
}else{
	$header=array(
			'Content-Type: application/json',
		);

	$res = get_json_response($header, array(), SELLER_PROFILES_API_URL.'?seller_ebay_id='.$seller_ebay_id);

	$req = SELLER_PROFILES_API_URL.'?seller_ebay_id='.$seller_ebay_id;
	$api_response = $res;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0) {
			$sql = "INSERT INTO ebay_seller_profile_data(ebay_id,api_request,api_response) values('".$seller_ebay_id."', '".$req."','".mysqli_real_escape_string($conn, $api_response)."')";
			mysqli_query($conn,$sql);
			print_r($api_response);exit;
		}else{
			echo "Error Response<br/>";
		}
	}
}
?>