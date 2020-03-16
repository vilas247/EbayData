<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
$select_size = 10;
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
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='ASPECT_ADOPTION'";
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
$search_query = "";
if(isset($_REQUEST['search']['value']) && !empty($_REQUEST['search']['value'])){
	$search_val = $_REQUEST['search']['value'];
	$search_query = "AND item_sku LIKE '%$search_val%'
					OR ebay_item_id LIKE '%$search_val%'
					OR aspect_name LIKE '%$search_val%'
					OR aspect_values LIKE '%$search_val%'";
}
//echo $search_query;exit;
$outer_array = array();
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
		
		$sql_count = "select count(DISTINCT ebay_item_id) as total from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."'";
		//echo $sql_count;exit;
		$res_count = mysqli_query($conn,$sql_count);
		$recordsTotal = 0;
		$recordsFiltered = 0;
		if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
			$count_data = $res_count->fetch_assoc();
			$recordsTotal = $count_data['total'];
		}
		$sql_val_filtered = "select count(DISTINCT ebay_item_id) as total from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' ".$search_query;
		$res_count_filtered = mysqli_query($conn,$sql_val_filtered);
		if(!empty($res_count_filtered) && mysqli_num_rows($res_count_filtered) > 0){
			$count_data = $res_count_filtered->fetch_assoc();
			$recordsFiltered = $count_data['total'];
		}
		
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' ".$search_query." group by ebay_item_id ".$orderby." LIMIT ".$offset.','.$limit;
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				$inner_array = array();
				$count_check_missing = 0;
				$count_check = 0;
				$inner_array_t = array();
				
				$inner_array_t[] = "<input type='checkbox' style='display:block;margin:5px auto;' data-sku='".$values['item_sku']."' name='myCheckboxes[]' value='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' >";
				if(check_val_exist($db_columns,'item_sku')){
					$inner_array_t[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values['item_sku']."'>".$values['item_sku']."</a>";
				}
				if(check_val_exist($db_columns,'ebay_item_id')){
					$inner_array_t[] = "<a target='_blank' href='https://www.ebay.co.uk/itm/".$values['ebay_item_id']."'>".$values['ebay_item_id']."</a>";
				}
				if(check_val_exist($db_columns,'product_name')){
					$inner_array_t[] = "".replace_text_trim($name_size,$values['product_name'])."";
				}
				$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
				//echo $sql_inner_val;exit;
				$res_inner_val = mysqli_query($conn,$sql_inner_val);
				if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
					$inner_array1 = array();
					$inner_array2 = array();
					while($values_inner = $res_inner_val->fetch_assoc()){
						$missing_aspect_name = "";
						$ebay_aspect_name = "";
						if(!empty($values_inner['aspect_value_corrective'])){
							$inner_array1[] = $values_inner['aspect_name'];
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$ebay_aspect_name .= "<select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$ebay_aspect_name .= "<option value='".$avv."' ".$selected." >".replace_text_trim($select_size,$avv)."</option>";
									}
									$ebay_aspect_name .= "</select>";
								}else{
									$ebay_aspect_name .= "<select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select>";
								}
							}else{
								$ebay_aspect_name .= "<select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select>";
							}
							$inner_array1[] = $ebay_aspect_name;
							
							$count_check++;
						}else{
							$inner_array2[] = $values_inner['aspect_name'];
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$missing_aspect_name .= "<select id='select-aspect' class='select-aspect ebay_item_".$values['ebay_item_id']."' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$missing_aspect_name .= "<option value='".$avv."' ".$selected." >".replace_text_trim($select_size,$avv)."</option>";
									}
									$missing_aspect_name .= "</select>";
								}else{
									$missing_aspect_name .= "<select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select>";
								}
							}else{
								$missing_aspect_name .= "<select id='select-aspect' class='select-aspect ebay_item_".$values['ebay_item_id']."' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select>";
							}
							$inner_array2[] = $missing_aspect_name;
							$count_check_missing++;
						}
						
					}
					for($k=0;$k<($max_value_missing-$count_check_missing);$k++){
						$inner_array2[] = "&nbsp;";
						$inner_array2[]= "&nbsp;";
					}
					for($j=0;$j<($max_value-$count_check);$j++){
						$inner_array1[] = "&nbsp;";
						$inner_array1[] = "&nbsp;";
					}
					
					$inner_array = array_merge($inner_array_t,$inner_array1,$inner_array2);
				}
				if(!empty($inner_array)){
					$outer_array[] = $inner_array;
				}
			}
		}
	}
	
	$final_array = array();
	$final_array['draw'] = $draw;
	$final_array['recordsTotal'] = $recordsTotal;
	$final_array['recordsFiltered'] = $recordsFiltered;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
}

function replace_text_trim($size,$text){
	/*if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}*/

	return $text;
}

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Aspect Name','value'=>'aspect_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Aspect Value','value'=>'aspect_value','data-title'=>'');
	//$columns[] = array('view_column'=>'Aspect Values','value'=>'aspect_values','data-title'=>'');
	$columns[] = array('view_column'=>'Aspect Suggested Value','value'=>'aspect_value_corrective','data-title'=>'');
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
				