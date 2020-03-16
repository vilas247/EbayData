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
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='TRAFFIC_PROMOTION'";
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
	if($search_val == "Recommended"){
		$search_query = "AND promotion_with_ad_text='$search_val'";
	}else if($search_val == "Eligible Best Offer"){
		$search_query = "AND is_eligible_offer='Y'";
	}else{
		
		$search_query = "AND item_sku LIKE '%$search_val%'
					OR ebay_item_id LIKE '%$search_val%'
					OR item_name LIKE '%$search_val%'
					OR item_bin_price LIKE '%$search_val%'
					OR transaction LIKE '%$search_val%'
					OR trending_rate_value LIKE '%$search_val%'
					OR listing_impression_total LIKE '%$search_val%'
					OR click_through_rate LIKE '%$search_val%'
					OR listing_views_total LIKE '%$search_val%'
					OR sales_conversion_rate LIKE '%$search_val%'
					OR listing_impression_search_results_page LIKE '%$search_val%'
					OR listing_impression_store LIKE '%$search_val%'
					OR listing_views_source_direct LIKE '%$search_val%'
					OR listing_views_source_off_ebay LIKE '%$search_val%'
					OR listing_views_source_other_ebay LIKE '%$search_val%'
					OR listing_views_source_search_results_page LIKE '%$search_val%'
					OR listing_views_source_store LIKE '%$search_val%'";
	}
}
//echo $search_query;exit;

$outer_array = array();
if(isset($_REQUEST['seller_ebay_id'])){
	$get_campaings = file_get_contents(GET_CAMPAIGN_API_URL."?seller_ebay_id=".$seller_ebay_id); 
	$get_campaings = json_decode($get_campaings,true);
	$options = "";

	$get_campaings_api = array();

	if(isset($get_campaings['campaigns'])){
		foreach($get_campaings['campaigns'] as $k=>$v){
			$bid_perc = 0;
			$get_campaings_api[$v['campaignId']] = 0;
			if(isset($v['fundingStrategy']['bidPercentage'])){
				$bid_perc = $v['fundingStrategy']['bidPercentage'];
				$get_campaings_api[$v['campaignId']] = $bid_perc;
			}
			$options .="<option data-bidPercentage='".$bid_perc."' value='".$v['campaignId']."' >".$v['campaignName']."</option>";
		}
	}
	$get_campaings_api = json_encode($get_campaings_api);
	//print_r(json_encode($get_campaings_api));exit;
	
	$sql_count = "select count(*) as total from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."'";
	$res_count = mysqli_query($conn,$sql_count);
	$recordsTotal = 0;
	$recordsFiltered = 0;
	if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
		$count_data = $res_count->fetch_assoc();
		$recordsTotal = $count_data['total'];
	}
	$sql_val_filtered = "select count(*) as total from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' ".$search_query;
	$res_count_filtered = mysqli_query($conn,$sql_val_filtered);
	if(!empty($res_count_filtered) && mysqli_num_rows($res_count_filtered) > 0){
		$count_data = $res_count_filtered->fetch_assoc();
		$recordsFiltered = $count_data['total'];
	}
	if(!empty($db_columns) ){
		if(!empty($sorting_val)){
			$orderby = "ORDER BY ".$sorting_val;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_val = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' ".$search_query." ".$orderby." LIMIT ".$offset.','.$limit;

		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$even_odd = 1;
			$span_text = '<span style="margin-top:6px;">%</span>';
			while($values = $res_val->fetch_assoc()){
				$inner_array = array();
				if(!empty($values['ebay_item_id'])){
					$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' >";
					foreach($db_columns as $dbk=>$dbv){
						if(isset($values[$dbv['value']])){
							if($dbv['value'] == "item_name"){
								$eBay_recomend = "";
								if(isset($values['promotion_with_ad_text'])){
									$eBay_recomend = '<div class="label label-success">Recommended</div><div style="clear:both;margin-bottom: 10px;"></div>';
								}
								$inner_array[] = $eBay_recomend.'<font style="float:left" >'.replace_text_trim($name_size,$values[$dbv['value']]).'</font>';
							}else if($dbv['value'] == "item_sku"){
								$inner_array[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
							}else if($dbv['value'] == "ebay_item_id"){
								$inner_array[] = "<a target='_blank' href='https://www.ebay.co.uk/itm/".$values[$dbv['value']]."'>".$values[$dbv['value']]."</a>";
								//$inner_array[] = replace_text_trim($name_size,$values[$dbv['value']]).'';
							}
							else if($dbv['value'] == "trending_rate_value"){
								if(is_null($values[$dbv['value']]) || $values[$dbv['value']] === NULL) {
									$inner_array[] = '<div id="ebay_value_'.$values['ebay_item_id'].'" >0%</div>';
								}
								else {
									$inner_array[] = '<div class="ebay_suggested_addrate" id="ebay_value_'.$values['ebay_item_id'].'" >'.$values[$dbv['value']].'%</div>';
								}
								
							}
							else if($dbv['value'] == "click_through_rate" || $dbv['value'] == "sales_conversion_rate"){
								$inner_array[] = '<div >'.$values[$dbv['value']].'%</div>';
							}
							else if($dbv['value'] == "item_bin_price"){
								$inner_array[] = '<div class="ebay_bin_price" id="ebay_item_bin_price_'.$values['ebay_item_id'].'" >'.$currency.$values[$dbv['value']].'</div>';
							}else{
								$inner_array[] = $values[$dbv['value']].'';
							}
						}else{
							if($dbv['value'] == "select_ebay_value"){
								$inner_array[] = '<div class="display_flex">
													<input class="form-control select_ebay_value" type="number" min="0" step="0.1" name="'.$values['ebay_item_id'].'_select_your_ebay_value" id="'.$values['ebay_item_id'].'_select_your_ebay_value" onchange="calculate_fees('.$values['ebay_item_id'].')" onkeyup="calculate_fees('.$values['ebay_item_id'].')" placeholder="0" />
													'.$span_text.'
													</div>
													<div id="'.$values['ebay_item_id'].'_final_fees" ></div>
												';
							}else if($dbv['value'] == "select_campain"){
								$inner_array[] = '<select class="select-aspect" id="'.$values['ebay_item_id'].'_select_campaign" name="'.$values['ebay_item_id'].'_select_campaign"  class="form-control" ><option value"" >Select</option>'.$options.'</select>';
							}/*else if($dbv['value'] == "final_fees"){
								$inner_array[] = '<div id="'.$values['ebay_item_id'].'_final_fees" ></div>';
							}*/else if($dbv['value'] == "multi_buy_2"){
								$inner_array[] = '<div class="display_flex">
													<select class="multi_buy2 form-control" id="'.$values['ebay_item_id'].'_multi_buy_2" name="'.$values['ebay_item_id'].'_multi_buy_2" >'.get_multi_buy2().'</select>
													'.$span_text.'
													</div>
													<div id="'.$values['ebay_item_id'].'_multibuy_2_fees" ></div>
													';
							}else if($dbv['value'] == "multi_buy_3"){
								$inner_array[] = '<div class="display_flex">
													<select class="multi_buy3 form-control" id="'.$values['ebay_item_id'].'_multi_buy_3" name="'.$values['ebay_item_id'].'_multi_buy_3" >'.get_multi_buy2(1).'</select>
													'.$span_text.'
													</div>
													<div id="'.$values['ebay_item_id'].'_multibuy_3_fees" ></div>
												';
							}else if($dbv['value'] == "multi_buy_4"){
								$inner_array[] = '<div class="display_flex">
													<select class="multi_buy4 form-control" id="'.$values['ebay_item_id'].'_multi_buy_4" name="'.$values['ebay_item_id'].'_multi_buy_4" >'.get_multi_buy2(1).'</select>
													'.$span_text.'
													</div>
													<div id="'.$values['ebay_item_id'].'_multibuy_4_fees" ></div>
												';
							}else{
								$inner_array[] = '&nbsp;';
							}
						}
					}
				}
				if(!empty($inner_array)){
					$outer_array[] = $inner_array;
				}
			}
			
		}
	}
	$sql = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' order by id DESC LIMIT 1";
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$values = $res_val->fetch_assoc();
		if(isset($values['created_date'])){
			$last_updated_date = date("jS F Y h:i A",strtotime($values['created_date']));
		}
	}
	$final_array = array();
	$final_array['draw'] = $draw;
	$final_array['recordsTotal'] = $recordsTotal;
	$final_array['recordsFiltered'] = $recordsFiltered;
	//$final_array['recordsFiltered'] = $recordsTotal;
	$final_array['lastUpdatedDate'] = $last_updated_date;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
	
}

function return_value_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['key'])){
			if($search_id == $v['key']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}

function return_header_exists($search_id='',$data=array()){
	$key = $search_id;
	$data = $data['metrics'];
	foreach($data as $k=>$v){
		if(isset($v['key'])){
			if($search_id == $v['key']){
				$key = $v['localizedName'];
				return $key;
			}
		}
	}
	
	return $key;
}

function replace_text_trim($size,$text){
	if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}
}

function get_columns(){
	$listing_impression_total = "The total number of times the seller's listings displayed on the search results page OR in the seller's store. The item is counted each time it displays on either page, however, the listing might not have been visible ";
	$click_through_rate = "The number of times an item displays on the search results page divided by the number of times buyers clicked through to its View Item page.";
	$listing_views_total = "Total number of listings viewed. This number sums LISTING_VIEWS_SOURCE_DIRECT, LISTING_VIEWS_SOURCE_OFF_EBAY, LISTING_VIEWS_SOURCE_OTHER_EBAY, LISTING_VIEWS_SOURCE_SEARCH_RESULTS_PAGE, and LISTING_VIEWS_SOURCE_STORE.";
	$sales_conversion_rate = "The number of completed transactions divided by the number of View Item page views. (TRANSACTION / LISTING_VIEWS_TOTAL)";
	$transaction = "The total number of completed transactions.";
	$listing_impression_search_results_page = "The number of times the seller's listings displayed on the search results page. Note, the listing might not have been visible to the buyer due to its position on the page.";
	$listing_impression_store = "The number of times the seller's listings displayed on the seller's store. Note, the listing might not have been visible to the buyer due to its position on the page.";
	$listing_views_source_direct = "The number of times a View Item page was directly accessed, such as when a buyer navigates to the page using a bookmark.";
	$listing_views_source_off_ebay = "The number of times a View Item page was accessed via a site other than eBay, such as when a buyer clicks on a link to the listing from a search engine page.";
	$listing_views_source_other_ebay = "The number of times a View Item page was accessed from an eBay page that is not either the search results page or the seller's store.";
	$listing_views_source_search_results_page = "The number of times the item displayed on the search results page.";
	$listing_views_source_store = "The number of times a View Item page was accessed via the seller's store.";
	
	
	$columns = array();
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'item_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Buy it Now<br>Price','value'=>'item_bin_price','data-title'=>'');
	$columns[] = array('view_column'=>'Transaction<br>count','value'=>'transaction','data-title'=>$transaction);
	$columns[] = array('view_column'=>'eBay Suggested<br>Ad rate','value'=>'trending_rate_value','data-title'=>'');
	$columns[] = array('view_column'=>'Set your<br>Ad Rate','value'=>'select_ebay_value','data-title'=>'');
	$columns[] = array('view_column'=>'Select Campaign','value'=>'select_campain','data-title'=>'');
	$columns[] = array('view_column'=>'Selected Campaign','value'=>'selected_campaign','data-title'=>'');
	//$columns[] = array('view_column'=>'Fees','value'=>'final_fees','data-title'=>'');
	//$columns[] = array('view_column'=>'eBay Recommend','value'=>'promotion_with_ad','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 2','value'=>'multi_buy_2','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 3','value'=>'multi_buy_3','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 4','value'=>'multi_buy_4','data-title'=>'');
	$columns[] = array('view_column'=>'Total listing impressions','value'=>'listing_impression_total','data-title'=>$listing_impression_total);
	$columns[] = array('view_column'=>'Click through rate','value'=>'click_through_rate','data-title'=>$click_through_rate);
	$columns[] = array('view_column'=>'Total views','value'=>'listing_views_total','data-title'=>$listing_views_total);
	$columns[] = array('view_column'=>'Sales conversion rate','value'=>'sales_conversion_rate','data-title'=>$sales_conversion_rate);
	
	$columns[] = array('view_column'=>'Listing Impressions<br>Search Page','value'=>'listing_impression_search_results_page','data-title'=>$listing_impression_search_results_page);
	$columns[] = array('view_column'=>'Listing Impressions<br>Store','value'=>'listing_impression_store','data-title'=>$listing_impression_store);
	$columns[] = array('view_column'=>'Views from<br>search results page','value'=>'listing_views_source_direct','data-title'=>$listing_views_source_direct);
	$columns[] = array('view_column'=>'Off eBay views','value'=>'listing_views_source_off_ebay','data-title'=>$listing_views_source_off_ebay);
	$columns[] = array('view_column'=>'Other eBay views','value'=>'listing_views_source_other_ebay','data-title'=>$listing_views_source_other_ebay);
	$columns[] = array('view_column'=>'Views from the search results page','value'=>'listing_views_source_search_results_page','data-title'=>$listing_views_source_search_results_page);
	$columns[] = array('view_column'=>'Views from<br>your Store','value'=>'listing_views_source_store','data-title'=>$listing_views_source_store);
	
	return $columns;
}

function get_multi_buy2(){
	$return = "<option value=''>-Select-</option>";
	for($i=1;$i<=80;$i++){
		$return .= "<option value='".$i."'>".$i."</option>";
	}
	return $return;
}

?>
				