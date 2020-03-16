<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

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
$limit = 500;
$sorting = '';
$sorting_col = '';
$aspect_values_api = array();
$cloudhub_response = array();
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

if(isset($_REQUEST['type'])){
	$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";
	$max_value_missing = 1;
	$max_value = 1;
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		//$response['header'] = json_decode($headers['response'],true);
		$orderby = '';
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' group by ebay_item_id";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				if(!empty($values['ebay_category_id'])){
					if(isset($cloudhub_response[$values['ebay_category_id']])){
						$response = json_decode($cloudhub_response[$values['ebay_category_id']],true);
						$aspect_values_api = $response;
					}else{
						$url = CATEGORY_ASPECTS_API_URL."?category_tree_id=0&category_id=".$values['ebay_category_id']."&seller_ebay_id=".$seller_ebay_id;
						$res = get_json_response($header,array(),$url);
						$check_errors = json_decode($res);
						if(isset($check_errors->errors)){
							echo "Error Response1<br/>";
						}else{
							if(json_last_error() === 0){
								$cloudhub_response[$values['ebay_category_id']] = $res;
								$response = json_decode($res,true);
								$aspect_values_api = $response;
							}else{
								echo "Error Response2:".$values['ebay_category_id']."<br/><br/>";
							}
						}
					}
				}
				if(!empty($aspect_values_api) && isset($aspect_values_api['aspects'])){
					$aspect_values_api = $aspect_values_api['aspects'];
					$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
					$res_inner_val = mysqli_query($conn,$sql_inner_val);
					if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
						while($values_inner = $res_inner_val->fetch_assoc()){
							$assert_values_format = array();
							$key = return_value_exists($values_inner['aspect_name'],$aspect_values_api);
							if($key >= 0){
								foreach($aspect_values_api[$key]['aspectValues'] as $avpk=>$avpv){
									$assert_values_format[] = $avpv['localizedValue'];
								}
								$update_aspect_values = implode("|||",$assert_values_format);
								$sql_u = "update ebay_aspect_adoption_report set aspect_values='".addslashes($update_aspect_values)."' where id=".$values_inner['id']." and random_number='".$random_number."'" ;
								mysqli_query($conn,$sql_u);
							}
							
						}
						
					}
				}
			}
		}else{
			echo "Error Response3";exit;
		}
	}else{
		echo "Error Response4";exit;
	}
}

function return_value_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['localizedAspectName'])){
			if($search_id == $v['localizedAspectName']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}



?>