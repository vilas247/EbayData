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
		
		$truncateQuery = mysqli_query($conn, "TRUNCATE TABLE ebay_traffic_pomotion_report");
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
				
				$sql = "insert into ebay_traffic_pomotion_report(ebay_seller_id,item_sku,item_name,ebay_item_id,item_bin_price) 
						values('".$seller_ebay_id."','".$item_sku."','".mysqli_real_escape_string($conn, $eBayProductTitle)."','".$ebay_item_id."','".$item_bin_price."')";
				$res = mysqli_query($conn,$sql);
			}
			echo "Records Updated";
		}
	}
}

exit; */

/*$sql = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' AND is_updated_promotion='N'";
$res_val = mysqli_query($conn,$sql);

if(isset($_REQUEST['seller_ebay_id'])) {

	while($values = $res_val->fetch_assoc()){

		echo $url = "https://showcase.247cloudhub.co.uk/ebayapis/analytics/get_traffic_report_by_id.php?seller_ebay_id=".$seller_ebay_id."&item_id=".$values['ebay_item_id'];

		$req = $url;
		$res = get_json_response($header,array(),$url);
		////print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response 0<br/>";exit;
		}else{
			if(json_last_error() === 0) {

				$response = json_decode($res,true);			
				echo '<pre>';
				if(isset($response['records'])){
					$records = $response['records'];
					$metrics = $response['header']['metrics'];
					////print_r($records);
					$updateColumns = array("is_updated_promotion='Y'");
					foreach($records as $k=>$v){
						////print_r($v);
						// print_r($metrics);
						
						foreach($metrics as $mk=>$mv) {	
							$updateColumns[] = strtolower($mv['key'])."='".$v['metricValues'][$mk]['value']."'";
						}
						
					}

					////print_r($updateColumns);
					if(count($updateColumns) > 0) {
						$updateQuery = "UPDATE ebay_traffic_pomotion_report SET ".implode(",", $updateColumns)." WHERE id=".$values['id'];
						mysqli_query($conn,$updateQuery);

						echo "Records Updated Successfully <br />";
					}

					
					
				}
			}else{
				echo "Error Response1<br/><br/>"; ////exit;
			}
		}

	} //end of while($values = $res_val->fetch_assoc())
}
exit;*/


$sql = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' AND is_updated_trending='N'";
$res_val = mysqli_query($conn,$sql);

if(isset($_REQUEST['seller_ebay_id'])) {

	while($values = $res_val->fetch_assoc()) {

		echo $url = "https://showcase.247cloudhub.co.uk/ebayapis/listing-recommendation/listing-recommendation-by-itemid.php?seller_ebay_id=".$seller_ebay_id."&itemID=".$values['ebay_item_id'];
		$req = $url;
		$res = get_json_response($header,array(),$url);
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response 00<br/>";exit;
		}
		else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				/*print '<pre>';
				print_r($response);*/
				if(isset($response['listingRecommendations'])){
					$listingRecommendations = $response['listingRecommendations'];
					
					////print_r($listingRecommendations);
					foreach($listingRecommendations as $k=>$v){
						$listing_id = '';
						$promotion_with_ad = '';
						$ebay_value = '';
						$ebay_basis = '';
						
						if(isset($v['listingId'])){
							$listing_id = $v['listingId'];
						}
						if(isset($v['marketing']['ad']['promoteWithAd'])){
							$promotion_with_ad = $v['marketing']['ad']['promoteWithAd'];
						}
						if(isset($v['marketing']['ad']['bidPercentages'])){
							$bidPrecentages = $v['marketing']['ad']['bidPercentages'];
							foreach($bidPrecentages as $bpk=>$bpv){	

								$updateQuery = "UPDATE ebay_traffic_pomotion_report SET promotion_with_ad_text='".$promotion_with_ad."',trending_rate_value='".$bpv['value']."',ebay_basis='".$bpv['basis']."', is_updated_trending='Y' WHERE id=".$values['id'];
								mysqli_query($conn,$updateQuery);

								echo "Data updated successfully <br />";

							}
						}
						else {
							
							$updateQuery = "UPDATE ebay_traffic_pomotion_report SET is_updated_trending='Y' WHERE id=".$values['id'];
							mysqli_query($conn,$updateQuery);

							echo "Flag updated successfully <br />";

						}
						
					}
					
				}
				else{
					echo "Error Response 2 <br/><br/>"; ////exit;
				}
			}else{
				echo "Error Response 3<br/><br/>"; ////exit;
			}
		}

	} //end of 
}

?>