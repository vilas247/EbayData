<?php
ini_set('max_execution_time',500000000000);
ini_set('max_input_time',500000000000);
define("CODEIGNITER_EXTERNAL_ACCESS", true);
//ob_start();
if(isset($_SERVER["DOCUMENT_ROOT"]) && $_SERVER["DOCUMENT_ROOT"] != "") {
	define('DOC_ROOT_PATH', $_SERVER["DOCUMENT_ROOT"]);
}
else {
	define('DOC_ROOT_PATH', "/var/www/html/cloudhub");
}

require_once DOC_ROOT_PATH.'/vendor/ci/external.php';

$databaseSQL = ""; //this is needed for DB connection for individual seller
$dbCode = ""; //this is needed for exceuting CH API call to pass DB code in request XML
if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
    $seller_ebay_id = trim($_GET['seller_ebay_id']);
    if($seller_ebay_id == '64_Rejel_Automotive_Ltd_eBay__uk') {
		$databaseSQL = "247C1041";
		$dbCode = 64;
	}
	else if($seller_ebay_id == '78_Revital_Ltd_eBay__Revital_UK') {
		$databaseSQL = "247C1052";
		$dbCode = 78;
	}
	else if($seller_ebay_id == '77_Champion_Dreams_Limited_eBay__eBay_UK') {
		$databaseSQL = "247C1051";
		$dbCode = 77;
	}
	else if($seller_ebay_id == '46_WeatherTech_Europe_SRL_eBay__IT') {
		$databaseSQL = "247C1024";
		$dbCode = 46;
	}
	else if($seller_ebay_id == '30_The_Monogram_Group_Limited_eBay__eBayUK') {
		$databaseSQL = "247C1007";
		$dbCode = 30;
	}
}
else if(isset($_REQUEST['dbcode']) && $_REQUEST['dbcode'] != '') {
    $dbcode = trim($_REQUEST['dbcode']);
    if($dbcode == '45') {
		$databaseSQL = "247C1023";
		$dbCode = 45;
	}
	else if($dbcode == '77') {
		$databaseSQL = "247C1023";
		$dbCode = 77;
	}
}
else {
    echo "ebay seller id is missing in URL query string. DB connection is not created."; exit;
}

$dbConfig = array(
	'dsn'	=> 'sqlsrv:server=ec2-34-243-88-188.eu-west-1.compute.amazonaws.com;Database='.$databaseSQL,
	'hostname' => 'ec2-34-243-88-188.eu-west-1.compute.amazonaws.com',
	'username' => 'backend',
	'password' => '24jA(kBauer587%^',
	'database' => $databaseSQL,
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$dbCI247 = $CI->load->database($dbConfig, true);

/**
* if we use $CI->load->database($dbConfig);
* we need to execute query like $CI->db->query('select * from ebay_token_data');
* ----------------------------------------
* if we use $dbCI247 = $CI->load->database($dbConfig, true);
* we need to execute query like $dbCI247->query('select * from ebay_token_data');
*/