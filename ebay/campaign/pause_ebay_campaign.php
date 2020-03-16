<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");

$header=array(
			'Content-Type: application/json',
		);
		
//print_r($_REQUEST);exit;
if(count($_REQUEST)>0){
	if(isset($_REQUEST['campaign_id'])){
		$campaign_id = $_REQUEST['campaign_id'];
		$seller_ebay_id = $_REQUEST['ebay_seller_id'];
		$user_id = 0;
		
		//API request
		$url = PAUSE_CAMPAIGN_API_URL."?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK";
		//echo $url;exit;
		$postData = array(
	            "campaignId" => $campaign_id,
        );
		$postData = http_build_query($postData);
		$url = $url.'&'.$postData;
		$res = get_json_response($header,array(),$url);
		//print_r($res);exit;
		$api_request_data = json_encode($postData);
		$api_response_header = $res;
		$sql_ebay_campaign_api_request = "insert into ebay_campaign_api_request(user_id,seller_ebay_id,api_request_data,api_response_header) 
									values('".$user_id."','".$seller_ebay_id."','".$api_request_data."','".$api_response_header."')";
			
		/*$sql = "insert into ebay_campaign_report(campaign_name,funding_model,bid_percentage,start_date,end_date,market_place_id,ebay_seller_id) 
				values('".$campaign_name."','".$funding_model."','".$bid_percentage."','".$start_date."','".$end_date."','".$market_place_id."','".$ebay_seller_id."')";*/
		if ($conn->query($sql_ebay_campaign_api_request) === TRUE) {
			$last_id = $conn->insert_id;
			$action_log = $campaign_name." is paused by user:".$user_id;
			$sql_log = "insert into ebay_campaign_activity_log(ebay_seller_id,user_id,campaign_id,action_log) values('".$seller_ebay_id."','".$user_id."','".$last_id."','".$action_log."')";
			$conn->query($sql_log);
			echo true;
		} else {
			echo false;
		}
	}
}
?>