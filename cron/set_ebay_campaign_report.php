<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
	'Content-Type: application/json',
);

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$url = GET_CAMPAIGN_API_URL."?&seller_ebay_id=".$seller_ebay_id;
$res = get_json_response($header,array(),$url);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['campaigns'])){
				foreach($response['campaigns'] as $k=>$v){
					if(isset($v['fundingStrategy']['bidPercentage'])){
						$bidPercentage = $v['fundingStrategy']['bidPercentage'];
						$fundingModel = $v['fundingStrategy']['fundingModel'];
					}else{
						$bidPercentage = 0;
						$fundingModel = "COST_PER_SALE";
					}
					$campaignName = $v['campaignName'];
					$campaignId = $v['campaignId'];
					$startDate = date("Y-m-d h:i:s",strtotime(str_replace("Z","",str_replace("T","",$v['startDate']))));
					$endDate = date("Y-m-d h:i:s",strtotime(str_replace("Z","",str_replace("T","",$v['endDate']))));
					$marketplaceId = $v['marketplaceId'];
					$campaignStatus = $v['campaignStatus'];
					$sql = "select id from ebay_campaign_report where campaign_id='".$campaignId."' AND market_place_id ='".$marketplaceId."' AND ebay_seller_id='".$seller_ebay_id."'";
					$res = mysqli_query($conn,$sql);
					if(!empty($res) && mysqli_num_rows($res) > 0){
						$values = $res->fetch_assoc();
						$id = $values['id'];
						$sql_update = "update ebay_campaign_report set status='".$campaignStatus."',campaign_name='".$campaignName."',start_date='".$startDate."',end_date='".$endDate."',funding_model='".$fundingModel."',bid_percentage='".$bidPercentage."'
										WHERE id='".$id."'";
						mysqli_query($conn,$sql_update);
					}else{
						$sql_insert = "insert into ebay_campaign_report(campaign_id,campaign_name,funding_model,bid_percentage,start_date,end_date,market_place_id,ebay_seller_id,status) 
						values('".$campaignId."','".$campaignName."','".$fundingModel."','".$bidPercentage."','".$startDate."','".$endDate."','".$marketplaceId."','".$seller_ebay_id."','".$campaignStatus."')";
						mysqli_query($conn,$sql_insert);
					}
				}
				echo "Records Updated Successfully";
			}else{
				echo "Error Response<br/><br/>";exit;
			}
		}
		else{
			echo "Error Response<br/><br/>";exit;
		}
	}


?>