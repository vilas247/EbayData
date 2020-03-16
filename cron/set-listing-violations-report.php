<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
$header=array(
		'Content-Type: application/json',
	);

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;

	$req = $url;
	$res = get_json_response($header,array(),$url);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response<br/>";exit;
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);

			//if response available delete the data from table first and insert again as the violation data are dynamic in nature...we will only insert current data into the table and display in dashboard
			if(is_array($response) && count($response['listingViolations']) > 0) {
				$truncateQuery = mysqli_query($conn, "DELETE FROM  ebay_listing_violations_report WHERE ");
			}	


			$random_number = strtotime("now");
				
			$sql = "insert into ebay_listing_violations_report(ebay_seller_id,random_number,data_type,compliance_type) values ('".$seller_ebay_id."','".$random_number."','headers','".$_REQUEST['type']."')";
			mysqli_query($conn,$sql);
			if(isset($response['listingViolations'])){
				$listingViolations = $response['listingViolations'];
				foreach($listingViolations as $k=>$v){
					$listing_id = '';
					$compliance_type = '';
					$reason_code = '';
					$missing_value = '';
					if(isset($v['listingId'])){
						$listing_id = $v['listingId'];
					}
					if(isset($v['complianceType'])){
						$compliance_type = $v['complianceType'];
					}
					if(isset($v['violations'])){
						foreach($v['violations'] as $viok=>$viov){
							if(isset($viov['reasonCode'])){
								$reason_code = $viov['reasonCode'];
								$message = $viov['message'];
							}							
							$sql = "insert into ebay_listing_violations_report(ebay_seller_id,random_number,data_type,ebay_item_id,compliance_type,reason_code,message) values
									('".$seller_ebay_id."','".$random_number."','values','".$listing_id."','".$compliance_type."','".$reason_code."','".$message."')";
							mysqli_query($conn,$sql);
						}
					}
				}	
			}
		}else{
			echo "Error Response<br/><br/>";exit;
		}
	}
}

?>