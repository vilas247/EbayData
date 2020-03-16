<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");

$header=array(
			'Content-Type: application/json',
		);
		
//print_r($_REQUEST);exit;
if(count($_REQUEST)>0){
	if(isset($_REQUEST['campaign_name']) && isset($_REQUEST['funding_model']) && isset($_REQUEST['bid_percentage']) && isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
		$campaign_name = $_REQUEST['campaign_name'];
		$funding_model = $_REQUEST['funding_model'];
		$bid_percentage = $_REQUEST['bid_percentage'];
		$start_date = date("Y-m-d",strtotime(str_replace('-', '/', $_REQUEST['start_date'])));
		$start_time = $_REQUEST['start_time'];
		$end_date = date("Y-m-d",strtotime(str_replace('-', '/', $_REQUEST['end_date'])));
		$end_time = $_REQUEST['end_time'];
		$market_place_id = $_REQUEST['market_place_id'];
		$seller_ebay_id = $_REQUEST['ebay_seller_id'];
		$user_id = 0;
		
		$startDate = date("Y-m-d",strtotime($start_date))."T".date("h:i:s",strtotime($start_time))."Z";
		$endDate = date("Y-m-d",strtotime($end_date))."T".date("h:i:s",strtotime($end_time))."Z";
		
		//API request
		$url = CREATE_CAMPAIGN_API_URL."?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK";
		$postData = array(
	            "campaignName" => $campaign_name,
	            "startDate"  => $startDate,
	            "endDate" => $endDate,  
			        "fundingStrategy"  => array(
    			        "bidPercentage" => $bid_percentage,
    			        "fundingModel" => "COST_PER_SALE"
			        ),
			        "marketplaceId" => $market_place_id
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
			$action_log = $campaign_name." is created by user:".$user_id;
			$sql_log = "insert into ebay_campaign_activity_log(ebay_seller_id,user_id,campaign_id,action_log) values('".$seller_ebay_id."','".$user_id."','".$last_id."','".$action_log."')";
			$conn->query($sql_log);
			echo true;
		} else {
			echo false;
		}
	}
}
?>