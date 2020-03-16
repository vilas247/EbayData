<?php
ini_set('max_execution_time',500000000000);
ini_set('max_input_time',500000000000);
define("CODEIGNITER_EXTERNAL_ACCESS", true);

//ob_start();
if(isset($_SERVER["DOCUMENT_ROOT"]) && $_SERVER["DOCUMENT_ROOT"] != "") {
	define('DOC_ROOT_PATH', $_SERVER["DOCUMENT_ROOT"]."/EbayData");
}
else {
	define('DOC_ROOT_PATH', "/var/www/html/cloudhub");
}

require_once DOC_ROOT_PATH.'/vendor/ci/external.php';

