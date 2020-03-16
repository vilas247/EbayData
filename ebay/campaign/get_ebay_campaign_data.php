<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");

$header=array(
			'Content-Type: application/json',
		);
$response = array();
$response['status'] = false;
$response['data'] = array();
if(isset($_REQUEST['id'])){
	$id = json_decode(base64_decode($_REQUEST['id']));
	$sql = "select * from ebay_campaign_report where id='".$id."'";
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res)>0){
		$res = $res->fetch_assoc();
		$response['status'] = true;
		$start_date = date("Y-m-d",strtotime($res['start_date']));
		$start_time = date("h:i:s",strtotime($res['start_date']));
		$end_date = date("Y-m-d",strtotime($res['end_date']));
		$end_time = date("h:i:s",strtotime($res['end_date']));
		$res['startDate'] = $start_date;
		$res['startTime'] = $start_time;
		$res['endDate'] = $end_date;
		$res['endTime'] = $end_time;
		$response['data'] = $res;
	}
}
echo json_encode($response);exit;
?>