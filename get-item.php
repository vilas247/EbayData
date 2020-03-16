<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

/*$sql = "select * from ebay_seller_dashboard_data ORDER BY id DESC LIMIT 1";
$res = mysqli_query($conn,$sql);
if(!empty($res) && mysqli_num_rows($res) > 0){
	$response = $res->fetch_assoc();
	print_r($response['api_response']);exit;
}else{
	$header=array(
			'Content-Type: application/json',
		);

	$res = get_xml_response($header,array(),SELLER_DASHBOARD_API_URL);
	$req = SELLER_DASHBOARD_API_URL;
	$api_response = $res;

	libxml_use_internal_errors(true);
	$a = simplexml_load_string($api_response); //check response is valid XML or Not

	if($a === false){
		echo "Error response<br/>";
	}else{
		$sql = "INSERT INTO ebay_seller_dashboard_data(api_request,api_response) values('".$req."','".$api_response."')";
		mysqli_query($conn,$sql);
		print_r($api_response);exit;
	}
}*/


$sql = "SELECT `FldItemID` FROM `tbl_myebaysellingdetails` WHERE `FldItemID`!=''";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)) {

}

$header=array(
			'Content-Type: application/json',
		);

$res = get_xml_response($header,array(),'https://showcase.247cloudhub.co.uk/ebayapis/trading/get-item.php?ItemID=303079107562');

libxml_use_internal_errors(true);
$api_response = simplexml_load_string($res);
echo $api_response->Item->PayPalEmailAddress;exit;
print '<pre />';
print_r($api_response);exit;
?>