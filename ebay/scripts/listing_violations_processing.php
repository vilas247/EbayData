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
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='LISTING_VIOLATIONS'";
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
if(isset($_REQUEST['order'])) {
	$order = $_REQUEST['order'];
	//print_r($db_columns);exit;
	if(!empty($order)){
		$column_det = $db_columns[$order[0]['column']];
		$sorting = $order[0]['dir'];
		$sorting_val = $column_det['value'];
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

		
	$search_query = "AND item_sku LIKE '%$search_val%'
					OR product_name LIKE '%$search_val%'
					OR ebay_item_id LIKE '%$search_val%'
					OR message LIKE '%$search_val%'";
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
	
	$sql_count = "select count(*) as total from ebay_listing_violations_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND compliance_type='".$compliance_type."'";
	$res_count = mysqli_query($conn,$sql_count);
	$recordsTotal = 0;
	$recordsFiltered = 0;
	if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
		$count_data = $res_count->fetch_assoc();
		$recordsTotal = $count_data['total'];
	}
	$sql_val_filtered = "select count(*) as total from ebay_listing_violations_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND compliance_type='".$compliance_type."' ".$search_query;
	$res_count_filtered = mysqli_query($conn,$sql_val_filtered);
	if(!empty($res_count_filtered) && mysqli_num_rows($res_count_filtered) > 0){
		$count_data = $res_count_filtered->fetch_assoc();
		$recordsFiltered = $count_data['total'];
	}
	
	$sql_val = "select * from ebay_listing_violations_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND compliance_type='".$compliance_type."' ".$search_query." ".$orderby." LIMIT ".$offset.','.$limit;

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		$ii = 1;
		while($values = $res_val->fetch_assoc()){
			$inner_array = array();
			if(empty($last_updated_date)){
				if(isset($values['created_date'])){
					$last_updated_date = date("jS F Y h:i A",strtotime($values['created_date']));
				}
			}
			//print_r(json_encode($values));exit;
			if(!empty($values['ebay_item_id'])){
				$even_odd++;
				foreach($db_columns as $dbk=>$dbv){
					if(isset($values[$dbv['value']])){
						if($dbv['value'] == "id"){
							$inner_array[] = ($even_odd-1);
						}
						else if($dbv['value'] == "ebay_item_id"){
							$inner_array[] = "<a target='_blank' href='https://www.ebay.co.uk/itm/".$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
						}else if($dbv['value'] == "item_name"){
							$inner_array[] = replace_text_trim($name_size,$values[$dbv['value']]);
						}else if($dbv['value'] == "item_sku"){
							$inner_array[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
						}
						else if($dbv['value'] == "message"){
							$read_more = '';
							if(strlen($values[$dbv['value']]) > $name_size){
								$read_more = '<span data-toggle="collapse" data-target="#deno_'.$even_odd.'" >Read More..</span><div class="collapse" id="deno_'.$even_odd.'">'.$values[$dbv['value']].'</div>';
							}
							//$inner_array[] = '<td style="width:450px;word-wrap: break-word"><p data-title="'.$values[$dbv['value']].'">'.replace_text_trim($name_size,$values[$dbv['value']]).'</p>';
							$inner_array[] = '<td style="width:450px;word-wrap: break-word"><p data-title="'.$values[$dbv['value']].'">'.replace_text_trim($name_size,$values[$dbv['value']]).'</p>'.$read_more;
						}else if($dbv['value'] == "created_date"){
							$inner_array[] = date("Y-m-d h:i A",strtotime($values[$dbv['value']]));
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
	if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}
}

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SL No','value'=>'id','data-title'=>'');
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Compliance Type','value'=>'compliance_type','data-title'=>'Name');
	$columns[] = array('view_column'=>'Action to take','value'=>'message','data-title'=>'');
	//$columns[] = array('view_column'=>'Report last updated ','value'=>'created_date','data-title'=>'');
	return $columns;
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

?>
				