<?php 
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
			'Content-Type: text/xml',
		);

$seller_ebay_id = $_GET['seller_ebay_id'];

$res = get_xml_response($header,array(),SELLER_DASHBOARD_API_URL.'?seller_ebay_id='.$seller_ebay_id);
$req = SELLER_DASHBOARD_API_URL.'?seller_ebay_id='.$seller_ebay_id;
$api_response = $res;

libxml_use_internal_errors(true);
$a = simplexml_load_string($api_response); //check response is valid XML or Not

if($a === false){
	echo "Error response<br/>";
}else{
	$sql = "INSERT INTO ebay_seller_dashboard_data(ebay_id,api_request,api_response) values('".$seller_ebay_id."', '".$req."','".mysqli_real_escape_string($conn, $api_response)."')";
	mysqli_query($conn,$sql);
	print_r($api_response);exit;
}

?>