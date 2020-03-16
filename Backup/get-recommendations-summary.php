<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

$header = array(
			'Content-Type: application/json',
			);

/*// for type and item
if(isset($_REQUEST['type']) && isset($_REQUEST['itemID'])) {

	$url = RECOMMENDATION_ITEM_API_URL."?itemID=".$_REQUEST['itemID']."&type=".$_REQUEST['type'];
	$sql = "select * from ebay_recommendations_data where type='".$_REQUEST['type']."' and item_id='".$_REQUEST['itemID']."' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']); exit;
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		json_decode($res);
		if(json_last_error() === 0){
			$sql = "INSERT INTO ebay_recommendations_data(type,item_id,api_request,api_response) values('".$_REQUEST['type']."','".$_REQUEST['itemID']."','".$req."','".$res."')";
			mysqli_query($conn,$sql);
			print_r($res);exit;
		}
		else{
			echo "Error response<br/>";exit;
		}
	}
}
// for type
else */if(isset($_REQUEST['type'])){
	$url = RECOMMENDATION_TYPE_API_URL."?type=".$_REQUEST['type'];
	$sql = "select * from ebay_recommendations_data where type='".$_REQUEST['type']."' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
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
}
//for no value
else{
	$url = RECOMMENDATION_API_URL;
	$sql = "select * from ebay_recommendations_data where type='all' ORDER BY id DESC LIMIT 1";
	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response = $res->fetch_assoc();
		print_r($response['api_response']);exit;
	}else{
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
}

?>