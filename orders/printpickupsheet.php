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
	
	if(isset($details['orders'])){
		$order_details = json_decode($details['orders']);
		$sku = "<sku>".implode(",",$order_details)."</sku>";
		$request = "<requesttoprintpickupsheet>
								<usertoken>".$usertoken."</usertoken>
								<usercode>".$usercode."</usercode>
								<dbcode>".$dbcode."</dbcode>
								<responsetype>json</responsetype>
								<printall>false</printall>
								<printspecific>
									<products>".$sku."</products>
								</printspecific>
								<pickupsheetprofileid>".$details['pickupsheetprofileid']."</pickupsheetprofileid>
								<filtrate>
									<shippingservicecode>0</shippingservicecode>
									<workflowcode>0</workflowcode>
									<countrycode>0</countrycode>
									<marketplacecode>0</marketplacecode>
									<accountcode>0</accountcode>
								</filtrate>
							</requesttoprintpickupsheet>";
							
		echo $request;exit;
		$URL = LABEL_SETTINGS."OrderStage/ChangeOrderStageInBulk";
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
		$msg = "Empty orders Provided";
	}
	
	$data = array('status'=>$status,'msg'=>$msg);
	
	
	
}

?>