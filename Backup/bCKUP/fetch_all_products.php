<?php
/**
 * API call to fetch all products from iZettle
 */
require '../iz_config.php';

define('TIMEOUT',1000000); 

print_r($iz_config_data);exit;
$url_T = "https://products.izettle.com/organizations/".$iz_config_data["organizationUuid"]."/products"; 

$httpheaders_T[]="Authorization:Bearer ".$iz_oauth_access_token;
$httpheaders_T[]="Content-Type:application/json";

$ch_T = curl_init($url_T);
curl_setopt($ch_T, CURLOPT_HTTPHEADER, $httpheaders_T); // send my headers
curl_setopt($ch_T, CURLOPT_RETURNTRANSFER, true); // return result in a variable
curl_setopt($ch_T, CURLOPT_SSL_VERIFYPEER, false);
////curl_setopt($ch_T, CURLOPT_SSLVERSION, 3);     
///curl_setopt($ch_T, CURLOPT_POST, true); 
curl_setopt($ch_T, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($ch_T, CURLOPT_TIMEOUT, TIMEOUT);                    

$result_T = curl_exec($ch_T);

echo $err = curl_error($ch_T);
print '<pre />';
print_r($result_T);