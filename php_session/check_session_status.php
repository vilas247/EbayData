<?php
include('../common/inventory_config.php');
include('../ebayapis/ebay_data/curl.php');
session_start();
$output = array();
$output['status'] = false;
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$url = CHECK_SESSION_STATUS;
	$request = "<getsessionstatusrequest>
				<usertoken>".$_SESSION['usertoken']."</usertoken>
				<responsetype>json</responsetype>
			</getsessionstatusrequest>";
	$res = get_xml_response($url,$request);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$_SESSION['is247staff'] = $response['is247staff'];
					$output['status'] = true;
					$output['is247staff'] = $response['is247staff'];
				}
			}
	}
}
echo json_encode($output,true);exit;
?>