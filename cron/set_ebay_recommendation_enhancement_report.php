<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

	
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

/*$res = get_xml_response_get($header, $request, ITEM_SKU_CLODHUB_API_URL);
$api_response = $res;
$check_errors = json_decode($res);
if(isset($check_errors->errors)){
	echo "Error Response<br/>";exit;
}else{
	if(json_last_error() === 0) {
		
		$truncateQuery = mysqli_query($conn, "TRUNCATE TABLE ebay_recommendation_enhancement_report");
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
				
				$sql = "insert into ebay_recommendation_enhancement_report(ebay_seller_id,item_sku,product_name,ebay_item_id,item_bin_price) 
						values('".$seller_ebay_id."','".$item_sku."','".mysqli_real_escape_string($conn, $eBayProductTitle)."','".$ebay_item_id."','".$item_bin_price."')";
				$res = mysqli_query($conn,$sql);
			}
			echo "Records Updated";
		}
	}
}*/


echo $sql = "select * from ebay_recommendation_enhancement_report WHERE ebay_seller_id='".$seller_ebay_id."' AND fnf IS NULL";
$res_val = mysqli_query($conn,$sql);

if(!empty($res_val) && mysqli_num_rows($res_val) > 0) {

	while($values = $res_val->fetch_assoc()){

		if(!empty($values['ebay_item_id'])){			
			
			echo $url = "https://showcase.247cloudhub.co.uk/ebayapis/listing-recommendation/get-recommendations-by-itemid.php?seller_ebay_id=".$seller_ebay_id."&type=All&itemID=".$values['ebay_item_id'];
			$res = get_json_response($header,array(),$url);
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
				echo "API Error Response1<br/>";
			}else{
				if(json_last_error() === 0){
					$response = json_decode($res,true);
					
					$recommendationList = $response['Recommendation'];
					
					$picture = '';
					$picture_url = '';
					$fnf = '';
					$expedited_shipping = '';
					$free_shipping = '';
					$item_returns = '';
					$trackable_service_provided = '';
					$price_listing_details = '';
					echo '<pre />';
					foreach($recommendationList as $k=>$v) {
						print_r($v);
						if($v['type'] == 'Picture') {
							$picture = $v['message'];
							$picture_url = $v['fieldName'];
						}

						if($v['type'] == 'FnF') {
							$fnf = $v['message'];
						}

						if($v['type'] == 'eTRS' && $v['fieldName'] == 'expeditedShippingMaxCost') {
							$expedited_shipping = $v['message'];
						}

						if($v['type'] == 'eTRS' && $v['fieldName'] == 'freeShippingMaxDays') {
							$free_shipping = $v['message'];
						}

						if($v['type'] == 'eTRS' && $v['fieldName'] == 'itemReturnedWithin') {
							$item_returns = $v['message'];
						}

						if($v['type'] == 'eTRS' && $v['fieldName'] == 'trackableServiceProvided') {
							$trackable_service_provided = $v['message'];
						}


					}

					echo $updateQuery = "UPDATE ebay_recommendation_enhancement_report SET picture='".mysqli_real_escape_string($conn, $picture)."', picture_url='".mysqli_real_escape_string($conn, $picture_url)."', fnf='".mysqli_real_escape_string($conn, $fnf)."', expedited_shipping='".mysqli_real_escape_string($conn, $expedited_shipping)."', free_shipping='".mysqli_real_escape_string($conn, $free_shipping)."', item_returns='".mysqli_real_escape_string($conn, $item_returns)."', trackable_service_provided='".mysqli_real_escape_string($conn, $trackable_service_provided)."' WHERE ebay_item_id='".$values['ebay_item_id']."'";
					mysqli_query($conn,$updateQuery);
				}else{
					echo "no need to process for this item id=".$values['ebay_item_id']."<br />";
				}
			}
		}
	}
}


?>