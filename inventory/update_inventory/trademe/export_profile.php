<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('columns_helper.php');
require_once('../common/inventory_config.php');
$output = array();
$output['status'] = false;
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
    $usertoken = $_SESSION['usertoken'];
	//get columns
	$url = INVENTORY_API."ExportInventory/GetExportProfile";
    $request = "<getexportprofilerequest>
                    <usertoken>".$usertoken."</usertoken>
                    <dbcode>".$dbcode."</dbcode>
                    <responsetype>json</responsetype>
                    <profileid>0</profileid>
                    <mappingtype>2</mappingtype>
                </getexportprofilerequest>";
	//echo $request;exit;
	$res = get_xml_response($url,$request);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
                $output['status'] = true;
                $output['export_profile_details'] = $response;
			}
		}
	}
} 
echo json_encode($output,true);exit;
?>