<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);
	
	
$request = '<?xml version="1.0" encoding="utf-8"?>
<getebayitemIdandcategorydetailsrequest>
<dbcode>77</dbcode>
<responsetype>
<![CDATA[json]]>
</responsetype>
<accountcode>
<![CDATA[1]]>
</accountcode>
</getebayitemIdandcategorydetailsrequest>';

$res = get_xml_response_get($header, $request, ITEM_SKU_CLODHUB_API_URL);
print_r($res);exit;
$api_response = $res;
$check_errors = json_decode($res);
if(isset($check_errors->errors)){
	echo "Error Response<br/>";exit;
}else{
	if(json_last_error() === 0) {
		
		$truncateQuery = mysqli_query($conn, "TRUNCATE TABLE ebay_item_sku_details_temp");
		mysqli_query($conn,$truncateQuery);
		
		$response = json_decode($api_response,true);
		if(isset($response['EbayItemIdAndCategoryDetails'])){
			$EbayItemIdAndCategoryDetails = $response['EbayItemIdAndCategoryDetails'];
			foreach($EbayItemIdAndCategoryDetails as $eik=>$eiv){
				$item_sku = "";
				$ebay_item_id = "";
				$eBayProductTitle = "";
				$ebay_category_id = "";
				$item_bin_price = "";
				
				if(isset($eiv['SKU'])){
					$item_sku = $eiv['SKU'];
				}
				if(isset($eiv['ItemId'])){
					$ebay_item_id = $eiv['ItemId'];
				}
				if(isset($eiv['eBayProductTitle'])){
					$eBayProductTitle = $eiv['eBayProductTitle'];
				}
				if(isset($eiv['eBayCategory'])){
					$ebay_category_id = $eiv['eBayCategory'];
				}
				if(isset($eiv['BinPrice'])){
					$item_bin_price = $eiv['BinPrice'];
				}
				
				$sql = 'insert into ebay_item_sku_details_temp(item_sku,ebay_item_id,eBayProductTitle,ebay_category_id,item_bin_price) 
						values("'.$item_sku.'","'.$ebay_item_id.'","'.$eBayProductTitle.'","'.$ebay_category_id.'","'.$item_bin_price.'")';
				$res = mysqli_query($conn,$sql);
			}
			echo "Records Updated";
		}
	}
}


?>