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
	$sql_val = "select ebay_item_id as 'Item Id',item_sku as SKU,product_name as 'Product Name',item_bin_price as 'BIN PRICE',picture as Picture,
		picture_url as 'Picture Url',fnf as 'Fast and Free',expedited_shipping as 'Expedited Shipping',free_shipping as 'Free Shipping',
		item_returns as 'Item Returns',trackable_service_provided as 'Trackable Service Provided',price_listing_details as 'Price Listing Details'
		from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."'";

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		while($values = $res_val->fetch_assoc()){
			$download_array[] = $values;
		}
		//print_r($download_array);exit;
		download_send_headers("Catalogue_Enhancement_Report_as_of_report_download_" . date("Y-m-d") . ".csv");
		echo array2csv($download_array);
		die();
	}
}

?>