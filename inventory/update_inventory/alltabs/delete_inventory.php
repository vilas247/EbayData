<?php
require_once("../../../common/db-config.php");
require_once("../../../common/ebay_api_end_points.php");
require_once("../../../common/curl.php");
require_once('../../../common/inventory_config.php');
require_once('../../columns_helper.php');
if(!isset($_SESSION)){
	session_start();
}

$output = array();
$output['status'] = false;
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken']) && isset($_REQUEST['post_data'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];

	$post_data = json_decode($_REQUEST['post_data'],true);
	$marketplacecode = $_REQUEST['marketplacecode']?$_REQUEST['marketplacecode']:0;
	$accountcode = $_REQUEST['accountcode']?$_REQUEST['accountcode']:0;
	$url = INVENTORY_API.'Product/DeleteInventorySku';
	
	$sku_array = "";
	if(count($post_data)>0){
		$sku_array = implode("~",$post_data);;
	}
	//echo $sku_array;exit;
	if(!empty($post_data) && !empty($sku_array)){
			$request = "<deleteinventory>
							<usertoken>".$usertoken."</usertoken>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<accounts>
								<delete>
									<sku>".$sku_array."</sku>
									<accountcode>".$accountcode."</accountcode>
									<marketplacecode>".$marketplacecode."</marketplacecode>
								</delete>
							</accounts>
							<usercode>".$usercode."</usercode>
						</deleteinventory>";
			echo $request;exit;
			$res = get_xml_response($url,$request);
			//print_r($res);exit;
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
			}else{
				if(json_last_error() === 0){
					$response = json_decode($res,true);
					if(isset($response['statuscode']) && $response['statuscode'] == 0) {
						$output['status'] = true;
					}
				}
			}
	}
}
echo json_encode($output);true;
	
?>