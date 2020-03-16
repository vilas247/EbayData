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
//require __DIR__.'/../vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
//$config = require __DIR__.'/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
//use \DTS\eBaySDK\Constants;
/**
 * Create the service object.
 */
//$eBayOAuthToken = $config['production']['oauthUserToken'];
//$siteId = 'EBAY_GB';

/*
{
    "name": "Volume Pricing promotion",
    "startDate": "2019-05-20T01:00:00.000Z",
    "endDate": "2019-07-30T08:00:00.000Z",
    "marketplaceId": "EBAY_US",
    "promotionStatus": "SCHEDULED",
    "promotionType": "VOLUME_DISCOUNT",
    "applyDiscountToSingleItemOnly": false,
    "inventoryCriterion": {
        "inventoryCriterionType": "INVENTORY_ANY"
    },
    "discountRules": [
        {
            "discountSpecification": {
                "minQuantity": 1
            },
            "discountBenefit": {
                "percentageOffOrder": "0"
            },
            "ruleOrder": 1
        },
        {
            "discountSpecification": {
                "minQuantity": 2
            },
            "discountBenefit": {
                "percentageOffOrder": "5"
            },
            "ruleOrder": 2
        },
        {
            "discountSpecification": {
                "minQuantity": 3
            },
            "discountBenefit": {
                "percentageOffOrder": "15"
            },
            "ruleOrder": 3
        },
        {
            "discountSpecification": {
                "minQuantity": 4
            },
            "discountBenefit": {
                "percentageOffOrder": "20"
            },
            "ruleOrder": 4
        }
    ]
}
*/
$postData = array(
				"name" => "Buy 1 and get 2nd one 5% off -part 2",
				"description" => "Buy 1 and get 2nd one 5% off -part 2",
				"startDate" => "2017-02-11T19:58:18.918Z",
				"endDate" => "2017-03-11T19:58:18.918Z",
	            "marketplaceId" => "EBAY_GB",
				"promotionStatus" => "DRAFT",
				"applyDiscountToSingleItemOnly" => false,
	            "inventoryCriterion" => array(
											"inventoryCriterionType"=> "INVENTORY_ANY"
										),
				"discountRules" => array(
										array(
											"discountSpecification" => array(
																			"minQuantity" => 1
																		),
											"discountBenefit" => array(
																	"percentageOffOrder" => "0"
																),
											"ruleOrder" => 1,
										),
										array(
											"discountSpecification" => array(
																			"minQuantity" => 2
																		),
											"discountBenefit" => array(
																	"percentageOffOrder" => "5"
																),
											"ruleOrder" => 2,
										),
										array(
											"discountSpecification" => array(
																			"minQuantity" => 3
																		),
											"discountBenefit" => array(
																	"percentageOffOrder" => "7"
																),
											"ruleOrder" => 3,
										),
										array(
											"discountSpecification" => array(
																			"minQuantity" => 4
																		),
											"discountBenefit" => array(
																	"percentageOffOrder" => "10"
																),
											"ruleOrder" => 4,
										)
									)
            );

echo $post_fields = json_encode($postData);exit;

define('TIMEOUT',1000000); 

$url_T = "https://api.ebay.com/sell/marketing/v1/item_promotion";


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