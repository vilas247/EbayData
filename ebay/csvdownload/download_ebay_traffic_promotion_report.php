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
if(isset($_REQUEST['seller_ebay_id'])){

		
	/*$sql_val = "select item_sku as SKU,item_name as 'Product Name',ebay_item_id as 'Item Id',	listing_impression_total as 'Total listing impressions',click_through_rate as 'Click through rate',
		listing_views_total as 'Total views',sales_conversion_rate as 'Sales conversion rate',transaction as 'Transaction count',
		listing_impression_search_results_page as 'Listing impressions from the search results page',listing_impression_store as 'Listing impressions from your Store',
		listing_views_source_direct as 'Direct views',listing_views_source_off_ebay as 'Off eBay views',listing_views_source_other_ebay as 'Other eBay views',
		listing_views_source_search_results_page as 'Views from the search results page',listing_views_source_store as 'Views from your Store' from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."'";*/
	$sql_val = "select item_sku as SKU,item_name as 'Product Name',ebay_item_id as 'eBay Item Id',	listing_impression_total as 'Total listing impressions',click_through_rate as 'Click through rate',
		listing_views_total as 'Total views',sales_conversion_rate as 'Sales conversion rate',transaction as 'Transaction count',
		listing_impression_search_results_page as 'Listing impressions from the search results page',listing_impression_store as 'Listing impressions from your Store',
		listing_views_source_direct as 'Direct views',listing_views_source_off_ebay as 'Off eBay views',listing_views_source_other_ebay as 'Other eBay views',
		listing_views_source_search_results_page as 'Views from the search results page',listing_views_source_store as 'Views from your Store' from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."'";
		
	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		while($values = $res_val->fetch_assoc()){
			$download_array[] = $values;
		}
			
	}
	//print_r($download_array);exit;
	download_send_headers("Analytics_Promotion_Report_as_of_report_download_" . date("Y-m-d") . ".csv");
	echo array2csv($download_array);
	die();
}



?>