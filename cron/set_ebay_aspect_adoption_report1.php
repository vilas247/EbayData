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


?>