<?php
ini_set('max_execution_time',500000000000);
ini_set('max_input_time',500000000000);
$host_name = "m2devoutsidevpc.co13c6zl8ys8.eu-west-1.rds.amazonaws.com";
$user_name = "m2devoutsidevpc";
$password = "247Commerce*123";
$db_name = "ch_ebay_apis_data";
try{
	$conn = mysqli_connect($host_name,$user_name,$password,$db_name);
	if(!$conn){
		echo "Database Not Connected"; exit;
	}
}catch(Exception $e){
	echo "DB ERROR:".$e->getMessage();
}