<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

	function get_compressed_output($data)
	{
		ini_set('memory_limit', '-1');
		$search = array(
		'/\>[^\S ]+/s',
		'/[^\S ]+\</s',
	  '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s' //leave CDATA alone
		);
		$replace = array(
		 '>',
		 '<',
	  "//&lt;![CDATA[\n".'\1'."\n//]]>"
	  );

	  return  preg_replace($search, $replace, $data);
	}
$final_data = array();
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$status=false;
	$msg = '';
	$api_data = array();
	$response = array();
	$response['status'] = false;
	
	if(isset($details['request'])){
		if(!empty($details)){
			$request = json_encode($details['request'],true);
			
			echo $request;exit;
			$URL = PRINT_LABEL_API;
			$res = get_xml_response($URL,$request);
			print_r($res);exit;
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
			}else{
				if(json_last_error() === 0){
					$api_data = json_decode($res,true);
					if(isset($api_data['statuscode']) && $api_data['statuscode'] == 0) {
						$response['status'] = true;
						$response['data'] = $api_data['response'];
						$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/display-invoice-label-urls.php?labelMergePdf='.$api_data['labelMergePdf']);
						$response['data']['view'] = get_compressed_output($page_view_data);
					}
				}
			}

		}	
				
	}
	
}
echo json_encode($response,true);exit;

?>