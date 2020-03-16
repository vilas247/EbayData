<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");

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
$limit = 500;
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
if(isset($_GET['sort_col']) && $_GET['sort_col'] != '') {
	$sorting_col = $_GET['sort_col'];
}

if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
	if(!empty($res)){
		echo $res;		
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
				
				$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id) values ('".$random_number."','headers','".$seller_ebay_id."')";
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
										$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id,ebay_item_id,reason_code,aspect_name) values
											('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$reason_code."','".addslashes($vdv['value'])."')";
										mysqli_query($conn,$sql);
									}
								}
								if(isset($viov['correctiveRecommendations']['aspectRecommendations'])){
									$violation_recomm = $viov['correctiveRecommendations']['aspectRecommendations'];
									foreach($violation_recomm as $vrk=>$vrv){
										$sql1 = "select * from ebay_aspect_adoption_report where random_number='".$random_number."' and aspect_name='".addslashes($vrv['localizedAspectName'])."' and ebay_item_id='".$listing_id."'";
										$res_val = mysqli_query($conn,$sql1);
										if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
											$data = $res_val->fetch_assoc();
											$sql_u = "update ebay_aspect_adoption_report set aspect_value_corrective='".addslashes($vrv['suggestedValues'][0])."' where id=".$data['id'];
											mysqli_query($conn,$sql_u);
										}
									}
								}
							}
						}
					}
					
				}
				$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
				if(!empty($res)){
					echo $res;
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
	$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";
	$max_value_missing = 1;
	$max_value = 1;
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		//$response['header'] = json_decode($headers['response'],true);
		$orderby = '';
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_count_missing = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NULL GROUP BY ebay_item_id ) AS counts";
		$res_count_missing = mysqli_query($conn,$sql_count_missing);
		if(!empty($res_count_missing) && mysqli_num_rows($res_count_missing) > 0){
			$count_missing = $res_count_missing->fetch_assoc();
			$max_value_missing = $count_missing['max_value'];
		}
		$sql_count = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NOT NULL GROUP BY ebay_item_id ) AS counts";
		$res_count = mysqli_query($conn,$sql_count);
		if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
			$count = $res_count->fetch_assoc();
			$max_value = $count['max_value'];
		}
		
		$response .= '<table border=1 id=aspect_adoptions >';
		$response .= '<thead>';
		$response .= '<tr>';
		$response .= '<th><input type="checkbox" id="ckbCheckAll" />Select</th>';
		$response .= '<th>Item Id</th>';
		$response .= '<th>Product Title</th>';
		//$response .= '<th>Reason Code</th>';
		for($i=0;$i<$max_value;$i++){
			$response .= '<th>eBay Recommended Aspect Name</th>';
			$response .= '<th>eBay Recommended Aspect Value</th>';
		}
		for($i=0;$i<$max_value_missing;$i++){
			$response .= '<th>Missing Aspect Name</th>';
			$response .= '<th>Missing Aspect Value</th>';
		}
		$response .= '</tr>';
		$response .= '</thead>';
		$response .= '<tbody>';
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' group by ebay_item_id";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				$count_check_missing = 0;
				$count_check = 0;
				
				$response .= '<tr>';
				$response .= "<td><input type='checkbox' id='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				$response .= "<td>".$values['ebay_item_id']."</td>";
				$response .= "<td>".$values['product_name']."</td>";
				$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
				$res_inner_val = mysqli_query($conn,$sql_inner_val);
				if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
					$missing_aspect_name = "";
					$ebay_aspect_name = "";
					while($values_inner = $res_inner_val->fetch_assoc()){
						if(!empty($values_inner['aspect_value_corrective'])){
							$ebay_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							$ebay_aspect_name .= "<td>".$values_inner['aspect_value_corrective']."</td>";
							$count_check++;
						}else{
							$missing_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							$missing_aspect_name .= "<td>".$values_inner['aspect_value_corrective']."</td>";
							$count_check_missing++;
						}
						
					}
					for($k=0;$k<($max_value_missing-$count_check_missing);$k++){
						$missing_aspect_name .= "<td>&nbsp;</td>";
						$missing_aspect_name .= "<td>&nbsp;</td>";
					}
					for($j=0;$j<($max_value-$count_check);$j++){
						$ebay_aspect_name .= "<td>&nbsp;</td>";
						$ebay_aspect_name .= "<td>&nbsp;</td>";
					}
					
					$response .= $ebay_aspect_name.$missing_aspect_name;
				}
				$response .= "</tr>";
			}
		}else{
			return array();
		}
		
		$response .= '</tbody>';
		$response .= '</table>';
		return $response;
	}else{
		return array();
	}
}


?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function(){
  //$('#aspect_adoptions').DataTable();
  $("#ckbCheckAll").click(function(){
	  $('input:checkbox').not(this).prop('checked', this.checked);
  });
});
</script>