<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once("helper.php");

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}
$download_array = array();
if(isset($_REQUEST['type'])){
	$response = array();
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

		$sql_count_missing = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NULL GROUP BY ebay_item_id ) AS counts";
		$res_count_missing = mysqli_query($conn,$sql_count_missing);
		if(!empty($res_count_missing) && mysqli_num_rows($res_count_missing) > 0){
			$count_missing = $res_count_missing->fetch_assoc();
			$max_value_missing = $count_missing['max_value'];
		}
		$sql_count = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NOT NULL GROUP BY ebay_item_id ) AS counts";
		$res_count = mysqli_query($conn,$sql_count);
		if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
			$count = $res_count->fetch_assoc();
			$max_value = $count['max_value'];
		}
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' group by ebay_item_id";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		$even_odd = 1;
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$item_array = array();
			while($values = $res_val->fetch_assoc()){
				$item_array['SKU'] = $values['item_sku'];
				$item_array['Product Name'] = $values['product_name'];
				$item_array['Item ID'] = $values['ebay_item_id'];
				
				$count_check_missing = 0;
				$count_check = 0;
				$i=1;
				$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
				$res_inner_val = mysqli_query($conn,$sql_inner_val);
				if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
					$missing_aspect_name = "";
					$ebay_aspect_name = "";
					while($values_inner = $res_inner_val->fetch_assoc()){
						if(!empty($values_inner['aspect_value_corrective'])){
							$item_array['Aspect Name'.$i] = $values_inner['aspect_name'];
							$item_array['Aspect Value'.$i] = $values_inner['aspect_value_corrective'];
							$count_check++;
						}else{
							$item_array['Aspect Name'.$i] = $values_inner['aspect_name'];
							$item_array['Aspect Value'.$i] = $values_inner['aspect_value_corrective'];
							$count_check_missing++;
						}
						$i++;
						
					}
					for($k=0;$k<($max_value_missing-$count_check_missing);$k++){
						$item_array['Aspect Name'.$i] = "";
						$item_array['Aspect Value'.$i] = "";
						$i++;
					}
					for($j=0;$j<($max_value-$count_check);$j++){
						$item_array['Aspect Name'.$i] = "";
						$item_array['Aspect Value'.$i] = "";
						$i++;
					}
				}
				$download_array[] = $item_array;
			}
			//print_r($download_array);exit;
			download_send_headers("Aspect_Recommendation_Report_as_of_report_download_" . date("Y-m-d") . ".csv");
			echo array2csv($download_array);
			die();
		}
	}
}

?>