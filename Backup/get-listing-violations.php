<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

$header=array(
			'Content-Type: application/json',
		);

// for type
if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'];
	$sql = "select * from ebay_violations_data where type='".$_REQUEST['type']."' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		json_decode($res);
		if(json_last_error() === 0){
			$sql = "INSERT INTO ebay_violations_data(type,api_request,api_response) values('".$_REQUEST['type']."','".$req."','".$res."')";
			mysqli_query($conn,$sql);
			print_r($res);exit;
		}else{
			echo "";exit;
		}
	}
}
//for no value
else{
	$url = VIOLATION_API_URL;
	$sql = "select * from ebay_violations_data where type='all' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		json_decode($res);
		if(json_last_error() === 0){
			$sql = "INSERT INTO ebay_violations_data(type,api_request,api_response) values('all','".$req."','".$res."')";
			mysqli_query($conn,$sql);
			print_r($res);exit;
		}else{
			echo "";exit;
		}
	}
}

?>