<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

$final_data = array();
$final_data['status'] = false;
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$status=false;
	$msg = '';
	
	//if(isset($details['orders'])){
		$request = "<getallvendorsrequest>
								<usertoken>".$usertoken."</usertoken>
								<usercode>".$usercode."</usercode>
								<responsetype>json</responsetype>
							</getallvendorsrequest>";
		//echo $request;exit;
		$URL = VENDOR_API."GetAllVendors";
		$res = get_xml_response($URL,$request);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$final_data['data'] = $response;
					$final_data['status'] = true;
				}
			}
		}
				
	//}
	
}
echo json_encode($final_data,true);exit;

?>