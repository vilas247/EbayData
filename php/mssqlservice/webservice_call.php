<?php
error_reporting(E_ALL);
if(!isset($_SESSION)){
	session_start();
}
$result = array();
$result1 = array();

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	//$url = "https://showcase.247cloudhub.co.uk/php/mssqlservice/webservice.php";
	$url = "https://showcase.247cloudhub.co.uk/php/mssqlservice/product_catalogue.php";

	//$data = array("callFunction" => "getServiceTopLinks", "usertoken" => "A176E18E-0690-4090-AC93-E963CCD10777","dbcode" => "45","usercode" => "493");                                                           leData"}
	$data = array("callFunction" => "getReportsTableData","dbcode" => "25");          
	//{"marketplacecode":2,"dbcode":1,"usercode":493,"callFunction":"getAmzPrdsDownloadData"}
	$data = array("callFunction" => "getAmzPrdsDownloadData","dbcode" => "45","marketplacecode"=>"2","usercode"=>"289");   
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