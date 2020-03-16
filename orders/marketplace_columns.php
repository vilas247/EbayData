<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
require_once('columns_helper.php');

if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$column_details = array();
	
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];

	//get columns
	$marketplacecolumns_URL = ORDER_SETTINGS."GetMarketplaceColumns";
	//echo $marketplacecolumns_URL;exit;
	$request = "<getmarketplacecolumnsrequest>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<usercode>".$usercode."</usercode>
							<marketplace>selcolarray</marketplace>
						</getmarketplacecolumnsrequest>";
	//echo $request;exit;
	$res = get_xml_response($marketplacecolumns_URL,$request);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$column_details = json_decode($response['data']['colsdata'],true);
			}
		}
	}
	
	$output = array();
	$output['column_details'] = $column_details;
	$output['total_columns'] = market_columns();
	echo json_encode($output,true);exit;
} ?>