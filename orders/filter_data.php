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
	$response_output = array();
	
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	if(isset($_REQUEST['orderstages']) && !empty($_REQUEST['orderstages'])){
		$orderstagecode = implode(",",$_REQUEST['orderstages']);
	}else{
		$orderstagecode = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,18,20,22,23";
	}
	//$fromdate = "2019-12-10";
	$orderdatefrom = "";
	//$todate = "2019-12-19";
	$orderdateto = "";
	$numberofdays = "All";
	if(isset($_REQUEST['numberofdays']) && !empty($_REQUEST['numberofdays'])){
		$days = $_REQUEST['numberofdays'];
		if($days == "CDate"){
			$numberofdays = "";
			if(isset($_REQUEST['fromDate']) && !empty($_REQUEST['fromDate'])){
				$orderdatefrom = data("Y-m-d",strtotime($_REQUEST['fromDate']));
			}
			if(isset($_REQUEST['toDate']) && !empty($_REQUEST['toDate'])){
				$orderdateto = data("Y-m-d",strtotime($_REQUEST['toDate']));
			}
		}else{
			$numberofdays = $days;
		}
	}

	//get columns
	$marketplacecolumns_URL = ORDER_API."OrderAPI/GetOrdersCountInBulk";
	//echo $marketplacecolumns_URL;exit;
	$request = "<getorderscountinbulkrequest>
					<dbcode>".$dbcode."</dbcode>
					<usertoken>".$usertoken."</usertoken>
					<responsetype>json</responsetype>
					<orderstagecode>".$orderstagecode."</orderstagecode>
					<marketplacecode></marketplacecode>
					<accountcode></accountcode>
					<countrycode></countrycode>
					<shippingservicecode></shippingservicecode>
					<numberofdays>".$numberofdays."</numberofdays>
					<orderdatefrom>".$orderdatefrom."</orderdatefrom>
					<orderdateto>".$orderdateto."</orderdateto>
				</getorderscountinbulkrequest>";
	//echo $request;exit;
	
	$res = get_xml_response($marketplacecolumns_URL,$request);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$response_output = $response;
			}
		}
	}
	
	$output = array();
	$output['data'] = $response_output;
	echo json_encode($output,true);exit;
} ?>