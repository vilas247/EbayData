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

// for type
if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$sql = "select * from ebay_violations_data WHERE ebay_id='".$seller_ebay_id."' AND type='".$_REQUEST['type']."' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response<br/>";exit;
		}else{
			if(json_last_error() === 0){
				$sql = "INSERT INTO ebay_violations_data(ebay_id,type,api_request,api_response) values('".$seller_ebay_id."','".$_REQUEST['type']."','".$req."','".mysqli_real_escape_string($conn, $res)."')";
				mysqli_query($conn,$sql);
				print_r($res);exit;
			}else{
				echo "";exit;
			}
		}
	}
}
//for no value
else{
	$url = VIOLATION_API_URL.'?seller_ebay_id='.$seller_ebay_id;
	$sql = "select * from ebay_violations_data WHERE ebay_id='".$seller_ebay_id."' AND type='all' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response<br/>";exit;
		}else{
			if(json_last_error() === 0){
				$sql = "INSERT INTO ebay_violations_data(ebay_id,type,api_request,api_response) values('".$seller_ebay_id."','all','".$req."','".mysqli_real_escape_string($conn, $res)."')";
				mysqli_query($conn,$sql);
				print_r($res);exit;
			}else{
				echo "";exit;
			}
		}
	}
}

?>