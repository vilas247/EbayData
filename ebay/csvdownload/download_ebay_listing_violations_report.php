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
	$sql_val = "select ebay_item_id as 'Item Id',item_sku as SKU,product_name as 'Product Name',compliance_type as 'Compliance Type',message as 'Non Secure HTTP Link In Listing'
		from ebay_listing_violations_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values'";

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		while($values = $res_val->fetch_assoc()){
			$download_array[] = $values;
		}
		//print_r($download_array);exit;
		download_send_headers("Listing_Violations_Report_as_of_report_download_" . date("Y-m-d") . ".csv");
		echo array2csv($download_array);
		die();
	}
}

?>