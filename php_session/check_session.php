<?php 
require_once("../ebayapis/ebay_data/ebay_api_end_points.php");
session_start();
print '<pre>';
print_r($_SESSION);
exit;
if(!isset($_SESSION['usertoken'])){
	$login_url = BASE_URL."#/login";
	header("Location: ".BASE_URL);exit(0);
}
?>