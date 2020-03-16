<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$seller_ebay_id = $_GET['seller_ebay_id'];

$ebay_listing_recommendations = "select * from ebay_listing_recommendations WHERE ebay_id='".$seller_ebay_id."' AND type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
$ebay_listing_recommendations_fetch_query = mysqli_query($conn, $ebay_listing_recommendations);
$ebay_listing_recommendations_fetch_res = $ebay_listing_recommendations_fetch_query->fetch_assoc();

if($ebay_listing_recommendations_fetch_res['ebay_id'] == ""){
	echo "eBay user id is not present for this seller. Please update eBay user id in DB table.";
}
else{
	$url = LISTING_RECOMMENDATIONS_API_URL."?seller_ebay_id=".$seller_ebay_id."&offset=0&limit=500";
	$req = $url;
	$res = get_json_response($header,array(),$url);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			$random_number = strtotime("now");
			$sql = "insert into ebay_listing_recommendations(random_number,type,ebay_id,response,is_active) values ('".$random_number."','headers','".$seller_ebay_id."','',1)";
			mysqli_query($conn,$sql);
			if(isset($response['listingRecommendations'])){
				$listingRecommendations = $response['listingRecommendations'];
				foreach($listingRecommendations as $k=>$v){
					$listing_id = '';
					$promotion_with_ad = '';
					$ebay_value = '';
					$ebay_basis = '';
					
					if(isset($v['listingId'])){
						$listing_id = $v['listingId'];
					}
					if(isset($v['marketing']['ad']['promoteWithAd'])){
						$promotion_with_ad = $v['marketing']['ad']['promoteWithAd'];
					}
					if(isset($v['marketing']['ad']['bidPercentages'])){
						$bidPrecentages = $v['marketing']['ad']['bidPercentages'];
						foreach($bidPrecentages as $bpk=>$bpv){
							if($listing_id > 0){
								$sql = "insert into ebay_listing_recommendations(random_number,type,ebay_id,listing_id,promotion_with_ad,ebay_value,ebay_basis,is_active) values 
									('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$promotion_with_ad."','".$bpv['value']."','".$bpv['basis']."',1)";
								mysqli_query($conn,$sql);
							}
						}
					}
					
				}
				echo "Listingrecommendations updated successfully";
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