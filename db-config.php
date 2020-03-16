<?php
ini_set('max_execution_time',500000000000);
ini_set('max_input_time',500000000000);
$host_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "ebay_data";
try{
	$conn = mysqli_connect($host_name,$user_name,$password,$db_name);
	if(!$conn){
		echo "Database Not Connected"; exit;
	}
}catch(Exception $e){
	echo "DB ERROR:".$e->getMessage();
}