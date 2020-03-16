<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
require_once("../common/db-config-ci.php");
if(!isset($_SESSION)){
	session_start();
}
$result = array();
$result1 = array();

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$url = "localhost/EbayData/php/webservice.php";

	$data = array("callFunction" => "getServiceTopLinks", "usertoken" => "A176E18E-0690-4090-AC93-E963CCD10777","dbcode" => "77","usercode" => "493");                                                                    
	$data_string = json_encode($data);
	
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);
	
	$result = curl_exec($ch);
	
	print_r($result);exit;
	
	
}

?>