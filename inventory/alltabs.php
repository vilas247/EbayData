<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('columns_helper.php');
require_once('../common/inventory_config.php');

if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$marketplacecode = isset($_REQUEST['marketplacecode'])?$_REQUEST['marketplacecode']:'0';
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
	$column_details = array();
	$search_profile_details = array();
	$flag_details = array();
	
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$inventory_api = INVENTORY_API;
	$order_settings = ORDER_SETTINGS;
	
	//get columns
	$marketplacecolumns_URL = $order_settings."GetMarketplaceColumns";
	$request = "<getmarketplacecolumnsrequest>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<usercode>".$usercode."</usercode>
							<marketplace>".$marketplacecode_m."</marketplace>
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
				$column_details = $response;
			}
		}
	}
						
	//search profile
	$inventorysearchprofile_URL = $inventory_api."InventoryProfile/GetInventorySearchProfile";
	$request = "<getinventorysearchprofilerequest>
							<usertoken>".$usertoken."</usertoken>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<profilecode>0</profilecode>
							<marketplacecode>".$marketplacecode."</marketplacecode>
						</getinventorysearchprofilerequest>";
	$res = get_xml_response($inventorysearchprofile_URL,$request);
	//print_r($res);exit;
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$search_profile_details = $response;
			}
		}
	}
	
	//get Flag
	$flag_URL = $inventory_api."FlagComment/GetFlag";
	$request = "<getflagrequest>
							<usertoken>".$usertoken."</usertoken>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<flagid>0</flagid>
						</getflagrequest>";
	$res = get_xml_response($flag_URL,$request);
	//print_r($res);exit;
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$flag_details = $response;
			}
		}
	}
	
	$output = array();
	$output['column_details'] = $column_details;
	$output['search_profile_details'] = $search_profile_details;
	$output['flag_details'] = $flag_details;
	$output['total_columns'] = market_columns($marketplacecode);
	echo json_encode($output,true);exit;
} ?>