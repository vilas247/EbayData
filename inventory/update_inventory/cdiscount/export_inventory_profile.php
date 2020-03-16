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
//print_r($_REQUEST);exit;
$output['status'] = false;
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken']) && isset($_REQUEST['sku_data'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$exportprofileid = isset($_REQUEST['exportprofileid'])?$_REQUEST['exportprofileid']:'';
	$emailaddress = isset($_REQUEST['email_address'])?$_REQUEST['email_address']:'';
	$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
	$searchprofileid = isset($_REQUEST['searchprofileid'])?$_REQUEST['searchprofileid']:'';

	$sku_data = json_decode($_REQUEST['sku_data'],true);
	$url = INVENTORY_API.'ExportInventory/ExportInventoryBasedOnProfile';
	$final_sku_data = "";
	foreach($sku_data as $k=>$v){
		$final_sku_data .= "[".str_replace("'", "¶",$v['sku'])."~".$v['marketplacecode']."~".$v['accountcode']."],";
	}
	//print_r($sku_data);exit;
	if(!empty($exportprofileid) && !empty($emailaddress) && !empty($type)){
		$request = "";
		if($type == 3){
			$request = "<getexportinforequest>
						<usertoken>".$usertoken."</usertoken>
						<dbcode>".$dbcode."</dbcode>
						<responsetype>json</responsetype>
						<type>".$type."</type>
						<exportprofileid>".$exportprofileid."</exportprofileid>
						<emailaddress>".$emailaddress."</emailaddress>
					</getexportinforequest>";
		}else if($type == 4){
			$request = "<getexportinforequest>
						<usertoken>".$usertoken."</usertoken>
						<dbcode>".$dbcode."</dbcode>
						<responsetype>json</responsetype>
						<type>".$type."</type>
						<exportprofileid>".$exportprofileid."</exportprofileid>
						<emailaddress>".$emailaddress."</emailaddress>
					</getexportinforequest>";
		}else{
			if(!empty($final_sku_data)){
				$request = "<exportinventorybasedonprofilerequest>
							<usertoken>".$usertoken."</usertoken>
							<dbcode>".$dbcode."</dbcode>
							<responsetype>json</responsetype>
							<exportprofileid>".$exportprofileid."</exportprofileid>
							<skudata>".$final_sku_data."</skudata>
							<emailaddress>".$emailaddress."</emailaddress>
							<type>".$type."</type>
						</exportinventorybasedonprofilerequest>";
			}
		}
		if(!empty($request)){
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
					}
				}
			}
		}
	}
}
echo json_encode($output);true;
	
?>