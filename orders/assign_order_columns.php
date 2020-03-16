<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

$output = array();
$output['status'] = false;
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$output['request'] = $details;
	$url = ORDER_SETTINGS."AssignCols";
	$request = "<assigncolsrequest>
			<dbcode>".$dbcode."</dbcode>
			<responsetype>json</responsetype>
			<usercode>".$usercode."</usercode>
			<marketplacecode>selcolarray</marketplacecode>
			<tabcols>".$details['tabcols']."</tabcols>
			</assigncolsrequest>";
	//print_r($request);exit;
	$res = get_xml_response($url,$request);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$output['status'] = true;
				$output['data'] = $response;
			}
		}
	}
}
echo json_encode($output,true);exit;
?>