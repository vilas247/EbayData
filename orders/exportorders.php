<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$status=false;
	$msg = '';
	
	if(isset($details['orderstagecode'])){
		$request = "<exportordersrequest>
							<usertoken>".$usertoken."</usertoken>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<orderstagecode>".$details['orderstagecode']."</orderstagecode>
							<fromdate>".$details['fromdate']."</fromdate>
							<todate>".$details['todate']."</todate>
							<emailaddress>".$details['email_address']."</emailaddress>
							<iscustomexport>False</iscustomexport>
						</exportordersrequest>";
							
		echo $request;exit;
		$URL = ORDER_API."Export/ExportOrders";
		$res = get_xml_response($URL,$request);
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$status = true;
				}
			}
		}
				
	}else{
		$status = false;
		$msg = "Empty Details Provided";
	}
	
	$data = array('status'=>$status,'msg'=>$msg);
	
	echo json_encode($data);exit;
	
}

?>