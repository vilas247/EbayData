<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$header=array(
			'Content-Type: application/json',
		);
	
$offset = 0;
$limit = 50;
$sorting = '';
$sorting_val = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sorting_val']) && $_GET['sorting_val'] != '') {
	$sorting_val = $_GET['sorting_val'];
}

// traffic report
$url = TRAFFIC_REPORT."?seller_ebay_id=".$seller_ebay_id;
$res = get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val);
if(!empty($res)){
	print_r(json_encode($res));exit;
	
}else{
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
			$res = get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val);
			if(!empty($res)){
				print_r(json_encode($res));exit;
			}
			else{
				echo "Error Response<br/><br/>";exit;
			}
		}else{
			echo "Error Response<br/><br/>";exit;
		}
	}
}

function get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val){
	$sql = "select * from ebay_traffic_report WHERE ebay_id='".$seller_ebay_id."' AND type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = array();	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		$response['header'] = json_decode($headers['response'],true);
		$orderby = "";
		$sort = '';
		if(!empty($sorting_val)){
			$orderby = "ORDER BY ".$sorting_val;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_val = "select * from ebay_traffic_report WHERE ebay_id='".$seller_ebay_id."' AND type='values' AND random_number ='".$random_number."' AND is_active=1 ".$orderby." LIMIT ".$offset.','.$limit;
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$format_values = array();
			while($values = $res_val->fetch_assoc()){
				$format_values[] = format_records_data($values);
			}
			$response['records'] = $format_values;
			$sql_count = "select count(*) as total from ebay_traffic_report WHERE ebay_id='".$seller_ebay_id."' AND type='values' AND random_number ='".$random_number."' AND is_active=1";
			//echo $sql_count;exit;
			$res_count = mysqli_query($conn,$sql_count);
			$total = $res_count->fetch_assoc();
			$response['total'] = $total['total'];
		}
	}
	return $response;
}

function format_records_data($data=array()){
	$format_data = array();
	if(!empty($data)){
		$format_data['dimensionValues'][0]['value'] = $data['listing_id'];
		$format_data['metricValues'][0]['value'] = $data['listing_impression_search'];
		$format_data['metricValues'][1]['value'] = $data['listing_impression_ebay'];
		$format_data['metricValues'][2]['value'] = $data['sales_conversion_rate'];
	}
	return $format_data;
}

?>