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
/**
========================
Step1
=====================**/

if(isset($_REQUEST['type'])) {
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;

	$req = $url;
	$res = get_json_response($header,array(),$url);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0){
			
			//delete the data from table first and insert again as the aspects data are dynamic in nature...we will only insert current data into the table and display in dashboard
			$truncateQuery = mysqli_query($conn, "TRUNCATE TABLE ebay_aspect_adoption_report");
			mysqli_query($conn,$truncateQuery);
			
			$response = json_decode($res,true);
			$random_number = strtotime("now");
				
			$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id) values ('".$random_number."','headers','".$seller_ebay_id."')";
				mysqli_query($conn,$sql);
				if(isset($response['listingViolations'])){
					$listingViolations = $response['listingViolations'];
					foreach($listingViolations as $k=>$v){
						$listing_id = '';
						$compliance_type = '';
						$reason_code = '';
						$missing_value = '';
						if(isset($v['listingId'])){
							$listing_id = $v['listingId'];
						}
						if(isset($v['complianceType'])){
							$compliance_type = $v['complianceType'];
						}
						if(isset($v['violations'])){
							foreach($v['violations'] as $viok=>$viov){
								if(isset($viov['reasonCode'])){
									$reason_code = $viov['reasonCode'];
								}
								$violation_data = $viov['violationData'];
								foreach($violation_data as $vdk=>$vdv){
									if(!empty($listing_id)){
										//echo $listing_id.'-->'.$vdk;echo "<br/>";
										$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id,ebay_item_id,reason_code,aspect_name) values
											('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$reason_code."','".addslashes($vdv['value'])."')";
										mysqli_query($conn,$sql);
									}
								}
								if(isset($viov['correctiveRecommendations']['aspectRecommendations'])){
									$violation_recomm = $viov['correctiveRecommendations']['aspectRecommendations'];
									foreach($violation_recomm as $vrk=>$vrv){
										$sql1 = "select id from ebay_aspect_adoption_report where random_number='".$random_number."' and aspect_name='".addslashes($vrv['localizedAspectName'])."' and ebay_item_id='".$listing_id."'";
										$res_val = mysqli_query($conn,$sql1);
										if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
											$data = $res_val->fetch_assoc();
											$sql_u = "update ebay_aspect_adoption_report set aspect_value_corrective='".addslashes($vrv['suggestedValues'][0])."' where id=".$data['id'];
											mysqli_query($conn,$sql_u);
										}
									}
								}
							}
						}
					}
					
				}
		}else{
			echo "Error Response<br/><br/>";exit;
		}
	}
}


/**
========================
Step2
=====================**/
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
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."'";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				if(!empty($values['ebay_item_id'])){
					$sql_val_sku = "select * from ebay_item_sku_details_temp WHERE ebay_item_id='".$values['ebay_item_id']."'";
					$res_val_sku = mysqli_query($conn,$sql_val_sku);
					if(!empty($res_val_sku) && mysqli_num_rows($res_val_sku) > 0){
						$data = $res_val_sku->fetch_assoc();
						$item_sku = "";
						$ebay_item_id = "";
						$eBayProductTitle = "";
						$ebay_category_id = "";
						$item_bin_price = "";
						
						if(isset($data['item_sku'])){
							$item_sku = $data['item_sku'];
						}
						if(isset($data['ebay_item_id'])){
							$ebay_item_id = $data['ebay_item_id'];
						}
						if(isset($data['eBayProductTitle'])){
							$eBayProductTitle = $data['eBayProductTitle'];
						}
						if(isset($data['ebay_category_id'])){
							$ebay_category_id = $data['ebay_category_id'];
						}
						
						$u_sql = 'update ebay_aspect_adoption_report set item_sku="'.$item_sku.'",product_name="'.$eBayProductTitle.'",ebay_category_id="'.$ebay_category_id.'" WHERE id="'.$values['id'].'"';
						mysqli_query($conn,$u_sql);
					}
				}
			}
			echo "Records Updated";
		}else{
			echo "Error Response3";exit;
		}
	}else{
		echo "Error Response4";exit;
	}
}


/**
========================
Step3
=====================**/
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
								echo "Error Response2<br/><br/>";
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