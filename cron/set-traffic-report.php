<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$seller_ebay_id = $_GET['seller_ebay_id'];

$ebay_traffic_report = "select * from ebay_traffic_report WHERE ebay_id='".$seller_ebay_id."' AND type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
$ebay_traffic_report_fetch_query = mysqli_query($conn, $ebay_traffic_report);
$ebay_traffic_report_fetch_res = $ebay_traffic_report_fetch_query->fetch_assoc();

if($ebay_traffic_report_fetch_res['ebay_id'] == ""){
	echo "eBay user id is not present for this seller. Please update eBay user id in DB table.";
}
else{
	$url = TRAFFIC_REPORT."?seller_ebay_id=".$seller_ebay_id;
	$req = $url;
	$res = get_json_response($header,array(),$url);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			$random_number = strtotime("now");
			if(isset($response['header'])){
				$sql = "insert into ebay_traffic_report(random_number,type,ebay_id,response,is_active) values ('".$random_number."','headers','".$seller_ebay_id."','".mysqli_real_escape_string($conn, json_encode($response['header'],true))."',1)";
				mysqli_query($conn,$sql);
			}
			if(isset($response['records'])){
				$records = $response['records'];
				foreach($response['records'] as $k=>$v){
					$listing_id = '';
					$listing_impression_search = '';
					$listing_impression_ebay = '';
					$sales_conversion_rate = '';
					
					if(isset($v['dimensionValues'][0]['value'])){
						$listing_id = $v['dimensionValues'][0]['value'];
					}
					if(isset($v['metricValues'][0]['value'])){
						$listing_impression_search = $v['metricValues'][0]['value'];
					}
					if(isset($v['metricValues'][1]['value'])){
						$listing_impression_ebay = $v['metricValues'][1]['value'];
					}
					if(isset($v['metricValues'][2]['value'])){
						$sales_conversion_rate = $v['metricValues'][2]['value'];
					}
					
					if($listing_id > 0){
						$sql = "insert into ebay_traffic_report(random_number,type,ebay_id,listing_id,listing_impression_search,listing_impression_ebay,sales_conversion_rate,is_active) values ('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$listing_impression_search."','".$listing_impression_ebay."','".$sales_conversion_rate."',1)";
						mysqli_query($conn,$sql);
					}
				}
				
			}
			else{
				echo "Error Response<br/><br/>";exit;
			}
		}else{
			echo "Error Response<br/><br/>";exit;
		}
	}
}

?>