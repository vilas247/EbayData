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
	$url = INVENTORY_API.'Repricing/UpdatePriceQuantity';
	
	$marketplacecode = isset($_REQUEST['marketplacecode'])?$_REQUEST['marketplacecode']:'0';
	
	$items = "";
	foreach($post_data as $k=>$v){
		$r_url = INVENTORY_API.'RepricingProfile/GetRepriceProfileCode';
		$r_req = "<getrepriceprofilecoderequest>
					<usertoken>".$usertoken."</usertoken>
					<dbcode>".$dbcode."</dbcode>
					<responsetype>json</responsetype>
					<sku>".$v['sku']."</sku>
					<accountcode>".$v['accountcode']."</accountcode>
				</getrepriceprofilecoderequest>";
		//echo $r_req;exit;
		$r_res = get_xml_response($r_url,$r_req);
		//print_r($r_res);exit;
		$check_errors = json_decode($r_res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($r_res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$repriceprofilecode = $response['repricingprofilecode'][0]['repricingprofilecode'];
					$items .= "<item>
									<sku>".$v['sku']."</sku>
									<marketplacecode>".$v['marketplacecode']."</marketplacecode>
									<price>
										<accountcode>".$v['accountcode']."</accountcode>
										<amazonminprice></amazonminprice>
										<amazonmaxprice></amazonmaxprice>
										<amazonfixedprice></amazonfixedprice>
										<RRP></RRP>
										<ebaybinprice></ebaybinprice>
										<ebayauctionprice></ebayauctionprice>
										<repriceprofilecode>".$repriceprofilecode."</repriceprofilecode>
										<rakutenstandardprice></rakutenstandardprice>
										<rakutensaleprice></rakutensaleprice>
										<trademebuynowprice></trademebuynowprice>
										<cdiscountprice>".$v['cdiscountprice']."</cdiscountprice>
										<cdiscountrrp>".$v['cdiscountrrp']."</cdiscountrrp>
										<fnacprice></fnacprice>
									</price>
									<quantity>
										<masterquantity>".$v['quantity']."</masterquantity>
									</quantity>
								</item>";
				}
			}
		}
	}
	if(!empty($items)){
		$request = "<updatepricequantityrequest>
					<dbcode>".$dbcode."</dbcode>
					<usertoken>".$usertoken."</usertoken>
					<responsetype>json</responsetype>
					<usercode>".$usercode."</usercode>
					<ipaddress>106.51.64.100</ipaddress>
					<source>CDiscount Inventory Edit</source>
					<items>
						".$items."
					</items>
				</updatepricequantityrequest>";
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