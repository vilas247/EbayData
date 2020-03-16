<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

$header=array(
		'Content-Type: application/json',
	);

$seller_ebay_id = $_GET['seller_ebay_id'];

$ebay_listing_violations_report = "select * from ebay_listing_violations WHERE ebay_id='".$seller_ebay_id."' AND type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
$ebay_listing_violations_fetch_query = mysqli_query($conn, $ebay_listing_violations_report);
$ebay_listing_violations_fetch_res = $ebay_listing_violations_fetch_query->fetch_assoc();

if($ebay_listing_violations_fetch_res['ebay_id'] == ""){
	echo "eBay user id is not present for this seller. Please update eBay user id in DB table.";
}
else if(isset($_REQUEST['type'])){
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
			$random_number = strtotime("now");
				
			$sql = "insert into ebay_listing_violations(random_number,api_type,type,ebay_id,is_active) values ('".$random_number."','headers','".$_REQUEST['type']."','".$seller_ebay_id."',1)";
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
							}
							$violation_data = $viov['violationData'];
							foreach($violation_data as $vdk=>$vdv){
								if(!empty($listing_id)){
									//echo $listing_id.'-->'.$vdk;echo "<br/>";
									$sql = "insert into ebay_listing_violations(random_number,api_type,type,ebay_id,listing_id,compliance_type,reason_code,missing_value,is_active) values
											('".$random_number."','values','".$_REQUEST['type']."','".$seller_ebay_id."','".$listing_id."','".$compliance_type."','".$reason_code."','".$vdv['value']."',1)";
									mysqli_query($conn,$sql);
								}
							}
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