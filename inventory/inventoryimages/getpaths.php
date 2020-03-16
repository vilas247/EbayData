<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	
}