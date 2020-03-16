<?php 
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
			'Content-Type: application/json',
		);
if(isset($_REQUEST['type'])){
	$url = RECOMMENDATION_TYPE_API_URL."?type=".$_REQUEST['type'];	
	$req = $url;
	$res = get_json_response($header,array(),$url);
	json_decode($res);
	if(json_last_error() === 0){
		$sql = "INSERT INTO ebay_recommendations_data(type,api_request,api_response) values('".$_REQUEST['type']."','".$req."','".$res."')";
		mysqli_query($conn,$sql);
		print_r($res);exit;
	}else{
		echo "Error response<br/>";exit;
	}
}
//for no value
else{
	$url = RECOMMENDATION_API_URL;	
	$req = $url;
	$res = get_json_response($header,array(),$url);
	json_decode($res);
	if(json_last_error() === 0){
		$sql = "INSERT INTO ebay_recommendations_data(type,api_request,api_response) values('all','".$req."','".$res."')";
		mysqli_query($conn,$sql);
		print_r($res);exit;
	}else{
		echo "Error response<br/>";exit;
	}
}

?>