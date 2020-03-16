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
$sorting_col = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sort_col']) && $_GET['sort_col'] != '') {
	$sorting_col = $_GET['sort_col'];
}

// listing recommendations report
$url = LISTING_RECOMMENDATIONS_API_URL."?seller_ebay_id=".$seller_ebay_id."&offset=0&limit=500";
$res = get_listing_recommendations($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
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
				
			}
			$res = get_listing_recommendations($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
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

function get_listing_recommendations($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col){
	$sql = "select * from ebay_listing_recommendations WHERE ebay_id='".$seller_ebay_id."' AND type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = array();	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		$orderby = "";
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_val = "select * from ebay_listing_recommendations WHERE ebay_id='".$seller_ebay_id."' AND type='values' AND random_number ='".$random_number."' AND is_active=1 ".$orderby." LIMIT ".$offset.','.$limit;
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$response['total'] = 0;
			$format_values = array();
			while($values = $res_val->fetch_assoc()){
				$data = array();
				$data['listing_id'] = $values['listing_id'];
				$data['promotion_with_ad'] = $values['promotion_with_ad'];
				$data['ebay_value'] = $values['ebay_value'];
				$data['ebay_basis'] = $values['ebay_basis'];
				$format_values[] = $data;
			}
			$response['listingRecommendations'] = $format_values;
			$sql_count = "select count(*) as total from ebay_listing_recommendations WHERE ebay_id='".$seller_ebay_id."' AND type='values' AND random_number ='".$random_number."' AND is_active=1";
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
		$format_data['listingId'] = $data['listing_id'];
		$format_data['marketing']['ad']['promoteWithAd'] = $data['promotion_with_ad'];
		$percentages = array('value'=>$data['ebay_value'],'basis'=>$data['ebay_basis']);
		$format_data['marketing']['ad']['bidPercentages'][] = $percentages;
	}
	return $format_data;
}

function return_value_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['listingId'])){
			if($search_id == $v['listingId']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}

?>