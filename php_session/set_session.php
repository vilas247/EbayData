<?php
session_start();
//print_r($_REQUEST);exit;
if(isset($_REQUEST['usercode']) && isset($_REQUEST['dbcode']) && isset($_REQUEST['usertoken'])){
	$_SESSION['usercode'] = $_REQUEST['usercode'];
	$_SESSION['dbcode'] = $_REQUEST['dbcode'];
	$_SESSION['usertoken'] = $_REQUEST['usertoken'];
	echo 1;
}else{
	echo 0;
}
?>