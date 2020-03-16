<?php
/**
 * Copyright 2016 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Include the SDK by using the autoloader from Composer.
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require __DIR__.'/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
/**
 * Create the service object.
 */
$eBayOAuthToken = $config['production']['oauthUserToken'];
$siteId = 'EBAY_GB';


define('TIMEOUT',1000000); 

if(isset($_REQUEST['campaignId'])){
	$url_T = "https://api.ebay.com/sell/marketing/v1/ad_campaign/".$_REQUEST['campaignId']."/resume"; 
}else{
	echo "CampaignId missing";exit;
}

$post_fields = "";

$httpheaders_T[]="Authorization:Bearer ".$eBayOAuthToken;
$httpheaders_T[]="X-EBAY-C-MARKETPLACE-ID:$siteId";
$httpheaders_T[]="Content-Type:application/json";
$httpheaders_T[]="Content-Language:en-GB";


print '<pre />';
print_r($httpheaders_T);
////exit;

$ch_T = curl_init($url_T);
curl_setopt($ch_T, CURLOPT_HTTPHEADER, $httpheaders_T); // send my headers
curl_setopt($ch_T, CURLOPT_RETURNTRANSFER, true); // return result in a variable
curl_setopt($ch_T, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch_T, CURLOPT_VERBOSE, 1);
curl_setopt($ch_T, CURLOPT_HEADER, 1);
////curl_setopt($ch_T, CURLOPT_SSLVERSION, 3);     
curl_setopt($ch_T, CURLOPT_POST, true); 
curl_setopt($ch_T, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch_T, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($ch_T, CURLOPT_TIMEOUT, TIMEOUT);                    

if(!($data = curl_exec($ch_T))) {  
    echo "Create Offer Request Curl Error: ".curl_error($ch_T);                       
}       
else { 
    print '<pre />';
	print_r($data);
}  

curl_close($ch_T);