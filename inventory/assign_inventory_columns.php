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
	$marketplacecode = $details['marketplacecode'];
	if($marketplacecode == 0){
		$marketplacecode_m = "all";
	}else if($marketplacecode == "1"){
		$marketplacecode_m = "ebay";
	}else if($marketplacecode == "2"){
		$marketplacecode_m = "amzon";
	}else if($marketplacecode == "101"){
		$marketplacecode_m = "game_new";
	}else if($marketplacecode == "10"){
		$marketplacecode_m = "game";
	}else if($marketplacecode == "9"){
		$marketplacecode_m = "cdiscount";
	}else if($marketplacecode == "3"){
		$marketplacecode_m = "webstore";
	}else if($marketplacecode == "7"){
		$marketplacecode_m = "rakuten";
	}else if($marketplacecode == "8"){
		$marketplacecode_m = "tradme";
	}else if($marketplacecode == "10"){
		$marketplacecode_m = "fnac";
	}else if($marketplacecode == "16"){
		$marketplacecode_m = "fba";
	}else if($marketplacecode == "13"){
		$marketplacecode_m = "Abebooks";
	}else if($marketplacecode == "17"){
		$marketplacecode_m = "Allegro";
	}else if($marketplacecode == "21"){
		$marketplacecode_m = "SKUCloud";
	}else if($marketplacecode == "20"){
		$marketplacecode_m = "ONBuy";
	}else if($marketplacecode == "22"){
		$marketplacecode_m = "Fruugo";
	}else if($marketplacecode == "15"){
		$marketplacecode_m = "Shopify";
	}else{
		$marketplacecode_m = "all";
	}
	$output['request'] = $details;
	$url = ORDER_SETTINGS."AssignCols";
	$request = "<assigncolsrequest>
			<dbcode>".$dbcode."</dbcode>
			<responsetype>json</responsetype>
			<usercode>".$usercode."</usercode>
			<marketplacecode>".$marketplacecode_m."</marketplacecode>
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