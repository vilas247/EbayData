<?php
require_once("db-config.php");
require_once("ebay_api_end_points.php");
require_once("curl.php");

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$header=array(
			'Content-Type: application/json',
		);
	
$offset = 0;
$limit = 50;
$sorting = '';
$sorting_col = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sorting_col']) && $_GET['sorting_col'] != '') {
	$sorting_col = $_GET['sorting_col'];
}

if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
	if(!empty($res)){
		print_r(json_encode($res));exit;
		
	}else{
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
				$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
				if(!empty($res)){
					print_r(json_encode($res));exit;
				}
				else{
					echo "Error Response<br/><br/>";exit;
				}
			}else{
				echo "Error Response<br/><br/>";exit;
			}
		}
	}
}

function get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col){
	$sql = "select * from ebay_listing_violations WHERE type='".$_REQUEST['type']."' AND ebay_id='".$seller_ebay_id."' AND api_type='headers' AND is_active=1 ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = array();
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$response['total'] = 0;
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		//$response['header'] = json_decode($headers['response'],true);
		$orderby = "";
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_val = "select * from ebay_listing_violations WHERE type='".$_REQUEST['type']."' AND ebay_id='".$seller_ebay_id."' AND api_type='values' AND random_number ='".$random_number."' AND is_active=1 ".$orderby." LIMIT ".$offset.','.$limit;
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$format_values = array();
			while($values = $res_val->fetch_assoc()){
				$key = '';
				$key = return_value_exists($values['listing_id'],$format_values);
				if($key >= 0){
					$violation_values = $format_values[$key]['violations'];
					$val_key = return_violation_exists($values['reason_code'],$violation_values);
					if($val_key >= 0){
						$format_values[$key]['violations'][$val_key]['reasonCode'] = $values['reason_code'];
						$format_values[$key]['violations'][$val_key]['violationData'][] = array('value' => $values['missing_value']);
					}else{
						$violations = array();
						$violations['reasonCode'] = $values['reason_code'];
						$violations['violationData'][] = array('value' => $values['missing_value']);
						$format_values[$key]['violations'][] = $violations;
					}
					
				}else{
					$format_values[] = format_records_data($values);
				}
			}
			$response['listingViolations'] = $format_values;
			$sql_count = "select count(*) as total from ebay_listing_violations WHERE type='".$_REQUEST['type']."' AND ebay_id='".$seller_ebay_id."' AND api_type='values' AND random_number ='".$random_number."' AND is_active=1";
			//echo $sql_count;exit;
			$res_count = mysqli_query($conn,$sql_count);
			$total = $res_count->fetch_assoc();
			$response['total'] = $total['total'];
		}
	}
	return $response;
}

function format_records_data($data=array()){
	$format_data = array();
	if(!empty($data)){
		$format_data['complianceType'] = $data['compliance_type'];
		$format_data['listingId'] = $data['listing_id'];
		$violations = array();
		$violations['reasonCode'] = $data['reason_code'];
		$violations['violationData'][] = array('value' => $data['missing_value']);
		$format_data['violations'][] = $violations;
	}
	return $format_data;
}

function return_value_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['listingId'])){
			if($search_id == $v['listingId']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}
function return_violation_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['reasonCode'])){
			if($search_id == $v['reasonCode']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}

?>