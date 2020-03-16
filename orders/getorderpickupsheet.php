<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

$final_data = array();
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$status=false;
	$msg = '';
	
	if(isset($details['orders'])){
		$orders = "";
		$order_details = json_decode($details['orders']);
		foreach($order_details as $k=>$v){
			$orders .= "<order>".$v."</order>";
		}
		$request = "<getordersforpickupsheetrequest>
								<usertoken>".$usertoken."</usertoken>
								<dbcode>".$dbcode."</dbcode>
								<responsetype>json</responsetype>
								<usercode>".$usercode."</usercode>
								<pagenumber>1</pagenumber>
								<numberofrecords>50</numberofrecords>
								<shippingservicecode>0</shippingservicecode>
								<workflowcode>0</workflowcode>
								<marketplacecode>0</marketplacecode>
								<accountcode>0</accountcode>
								<countrycode>0</countrycode>
								<ordertype>0</ordertype>
								<orders>".$orders."</orders>
							</getordersforpickupsheetrequest>";	
		//echo $request;exit;
		$URL = LABEL_SETTINGS."Pickupsheet/GetOrdersforPickupsheet";
		$res = get_xml_response($URL,$request);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$final_data['data'] = $response;
				}
			}
		}
				
	}
	
}
echo json_encode($final_data,true);exit;

?>