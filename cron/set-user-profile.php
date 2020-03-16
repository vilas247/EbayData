<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$seller_ebay_id = $_GET['seller_ebay_id'];

$ebay_user_profile_query_text = "select * from ebay_token_data where ebay_id='".$seller_ebay_id."'";
$ebay_user_profile_fetch_query = mysqli_query($conn, $ebay_user_profile_query_text);
$ebay_user_profile_fetch_res = $ebay_user_profile_fetch_query->fetch_assoc();

if($ebay_user_profile_fetch_res['ebay_user_id'] == ""){
	echo "eBay user id is not present for this seller. Please update eBay user id in DB table.";
}
else {
	$eBayUserID = $ebay_user_profile_fetch_res['ebay_user_id'];
	$res = get_xml_response($header,array(), USER_PROFILE_API_URL.'?seller_ebay_id='.$seller_ebay_id.'&eBayUserID='.$eBayUserID);
	$req = USER_PROFILE_API_URL.'?seller_ebay_id='.$seller_ebay_id.'&eBayUserID='.$eBayUserID;
	$api_response = $res;
	
	libxml_use_internal_errors(true);
	$a = simplexml_load_string($api_response); //check response is valid XML or Not

	if($a === false){
		echo "Error response<br/>";
	}else{
		$sql = "INSERT INTO ebay_api_user_profile(ebay_id,api_request,api_response) values('".$seller_ebay_id."', '".$req."','".mysqli_real_escape_string($conn, $api_response)."')";
		mysqli_query($conn,$sql);
		print_r($api_response);exit;
	}
}

?>