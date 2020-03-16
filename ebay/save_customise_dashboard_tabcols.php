<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");

$page_types = array('TRAFFIC_PROMOTION','ASPECT_ADOPTION','LISTING_VIOLATIONS','RECOMMENDED_ENHANCEMENT','CAMPAIGN_REPORT');
//print_r($_REQUEST);exit;
if(isset($_REQUEST['tabcols']) && !empty($_REQUEST['tabcols']) && isset($_REQUEST['page_type']) && in_array($_REQUEST['page_type'],$page_types)){
	$tab_cols = $_REQUEST['tabcols'];
	$page_type = $_REQUEST['page_type'];
	$exists_sql = "select * from customise_dashboard_columns where page_type='".$page_type."'";
	$exists_res = mysqli_query($conn,$exists_sql);
	if(!empty($exists_res) && mysqli_num_rows($exists_res) > 0){
		$values = $exists_res->fetch_assoc();
		$sql = "update customise_dashboard_columns set tabcols='".$tab_cols."' where id='".$values['id']."'";
		if ($conn->query($sql) === TRUE) {
			echo true;
		} else {
			echo false;
		}
	}else{
		$sql = "insert into customise_dashboard_columns(page_type,tabcols) values('".$page_type."','".$tab_cols."')";
		//mysqli_query($conn,$sql_cols);
		if ($conn->query($sql) === TRUE) {
			echo true;
		} else {
			echo false;
		}
	}
}


?>