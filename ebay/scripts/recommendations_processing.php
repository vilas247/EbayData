<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
$name_size = 60;
$currency = '£';

if(isset($_REQUEST['seller_ebay_id']) && $_REQUEST['seller_ebay_id'] != '') {
	$seller_ebay_id = $_REQUEST['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}
//print_r(json_encode($_REQUEST));exit;
$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='RECOMMENDED_ENHANCEMENT'";
$res_cols = mysqli_query($conn,$sql_cols);
$res_cols = $res_cols->fetch_assoc();
//print_r($res_cols);exit;
if(!empty($res_cols)){
	$db_columns = json_decode($res_cols['tabcols'],true);
}

$header=array(
			'Content-Type: application/json',
		);
	
$offset = 0;
$limit = 100;
$sorting = '';
$sorting_val = '';
$draw = 1;
$last_updated_date = "";
if(isset($_REQUEST['draw'])){
	$draw = $_REQUEST['draw'];
}
if(isset($_REQUEST['length']) && $_REQUEST['length'] != '' && intval($_REQUEST['length']) > 0) {
	$limit = $_REQUEST['length'];
}
if(isset($_REQUEST['start']) && $_REQUEST['start'] != '' && intval($_REQUEST['start']) > 0) {
	//$offset = ($_REQUEST['start'] - 1) * $limit;
	$offset = $_REQUEST['start'];
}
if(isset($_REQUEST['order']) && count($_REQUEST['order']) > 0) {
	$order = $_REQUEST['order'];
	//print_r($db_columns);exit;
	if(!empty($order)){
		$column = $_REQUEST['order'][0]['column'];
		$order = $_REQUEST['order'][0]['dir'];
		if($column > 0){
			$id = (intval($column)-1);
			$column = $db_columns[$id];
			$sorting = $order;
			$sorting_val = $column['value'];
		}else{
			$id = (intval($column));
			$column = $db_columns[$id];
			$sorting = $order;
			$sorting_val = $column['value'];
		}
	}
}

if(isset($_REQUEST['compliance_type']) && $_REQUEST['compliance_type'] != '') {
	$compliance_type = $_REQUEST['compliance_type'];
}
else {
	$compliance_type = "HTTPS";
}
$search_query = "";
if(isset($_REQUEST['search']['value']) && !empty($_REQUEST['search']['value'])){
	$search_val = $_REQUEST['search']['value'];
	if($search_val == "Recommended"){
		$search_query = "AND promotion_with_ad_text='$search_val'";
	}else if($search_val == "Eligible Best Offer"){
		$search_query = "AND is_eligible_offer='Y'";
	}else{
		
		$search_query = "AND item_sku LIKE '%$search_val%'
					OR product_name LIKE '%$search_val%'
					OR ebay_item_id LIKE '%$search_val%'";
	}
}
//echo $search_query;exit;

$outer_array = array();
$last_updated_date = "";
if(isset($_REQUEST['seller_ebay_id'])){
	
	if(!empty($sorting_val)){
		$orderby = "ORDER BY ".$sorting_val;
		if(!empty($sorting)){
			$orderby .= " ".$sorting;
		}
	}
	
	$sql_count = "select count(*) as total from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."' AND ((picture !='') OR (fnf !='') OR (expedited_shipping !='') OR (free_shipping !='')) ".$search_query;
	$res_count = mysqli_query($conn,$sql_count);
	$recordsTotal = 0;
	$recordsFiltered = 0;
	if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
		$count_data = $res_count->fetch_assoc();
		$recordsTotal = $count_data['total'];
	}
	$sql_val_filtered = "select count(*) as total from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."' AND ((picture !='') OR (fnf !='') OR (expedited_shipping !='') OR (free_shipping !='')) ".$search_query;
	$res_count_filtered = mysqli_query($conn,$sql_val_filtered);
	if(!empty($res_count_filtered) && mysqli_num_rows($res_count_filtered) > 0){
		$count_data = $res_count_filtered->fetch_assoc();
		$recordsFiltered = $count_data['total'];
	}
	
	//$sql_val = "select * from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."'";
	$sql_val = "select * from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."' AND ((picture !='') OR (fnf !='') OR (expedited_shipping !='') OR (free_shipping !='')) ".$search_query." ".$orderby." LIMIT ".$offset.','.$limit;

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		$i=1;
		while($values = $res_val->fetch_assoc()){
			$inner_array = array();
			//print_r(json_encode($values));exit;
			if(!empty($values['ebay_item_id'])){
				$even_odd++;
				foreach($db_columns as $dbk=>$dbv){
					if(isset($values[$dbv['value']])){
						if($dbv['value'] == "id"){
							$inner_array[] = ($even_odd-1);
						}else if($dbv['value'] == "ebay_item_id"){
							$inner_array[] = "<a target='_blank' href='https://www.ebay.co.uk/itm/".$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
						}else if($dbv['value'] == "item_name"){
							$inner_array[] = replace_text_trim($name_size,$values[$dbv['value']]);
						}else if($dbv['value'] == "item_sku"){
							$inner_array[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
						}
						else if(($dbv['value'] == "picture") || ($dbv['value'] == "fnf") || ($dbv['value'] == "expedited_shipping") || ($dbv['value'] == "free_shipping")){
							$inner_array[] = '<p class="show-read-more" >'.$values[$dbv['value']].'</p>';
						}else if($dbv['value'] == "item_bin_price"){
							if(intval($values[$dbv['value']]) > 0){
								$inner_array[] = $currency.$values[$dbv['value']];
							}else{
								$inner_array[] = 'Variation Parent';
							}
							
						}else{
							$inner_array[] = $values[$dbv['value']];
						}
					}else{
						$inner_array[] = '&nbsp;';
					}
				}
			}
			if(!empty($inner_array)){
				$outer_array[] = $inner_array;
			}
			
		}
	}
	
	$final_array = array();
	$final_array['draw'] = $draw;
	$final_array['recordsTotal'] = $recordsTotal;
	$final_array['recordsFiltered'] = $recordsFiltered;
	$final_array['lastUpdatedDate'] = $last_updated_date;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
	
}

function replace_text_trim($size,$text){
	return $text;
	/*if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}*/
}

function check_val_exist($arr,$val){
	$status = false;
	foreach($arr as $k=>$v){
		if($v['value'] == $val){
			$status = true;
			break;
		}
	}
	return $status;
}

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SL No','value'=>'id','data-title'=>'');
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Buy it Now<br>Price ','value'=>'item_bin_price','data-title'=>'');
	$columns[] = array('view_column'=>'Picture Recommendations','value'=>'picture','data-title'=>'');
	//$columns[] = array('view_column'=>'URL','value'=>'picture_url','data-title'=>'');
	$columns[] = array('view_column'=>'Fast and Free Badge Feedback','value'=>'fnf','data-title'=>'');
	$columns[] = array('view_column'=>'Expedited Shipping Recommendation','value'=>'expedited_shipping','data-title'=>'');
	$columns[] = array('view_column'=>'Free Shipping Recommendation','value'=>'free_shipping','data-title'=>'');
	//$columns[] = array('view_column'=>'Item Returns','value'=>'item_returns','data-title'=>'');
	//$columns[] = array('view_column'=>'Trackable Service Provider','value'=>'trackable_service_provided','data-title'=>'');
	//$columns[] = array('view_column'=>'Fast and Free','value'=>'price_listing_details','data-title'=>'');
	return $columns;
}

?>
				