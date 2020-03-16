<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Turn off all error reporting
error_reporting(0);
ini_set('max_execution_time', 0);
header('content-type: application/json;');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');
//require_once("login/session_handler.php");
require_once("login/utils.php");
require_once("login/sha256.inc.php"); 
require_once('marketplace/ebay/keys.php');
require_once('marketplace/ebay/eBaySession.php');
require_once("marketplace/amazon/amazonAuthTokenNew.php");
require_once("invoice/FPDF/fpdf.php");
require_once("scanandship/PDFMergerNew.php");
require_once("marketplaceinvoice/imageResize.php");
require_once("marketplaceinvoice/pdfGeneratorNew.php");

//$sessionObj = new Session();

	try{
		$params = json_decode(file_get_contents('php://input'),true);
		//echo json_encode(array('posts'=>$params));exit;
			if(isset($params) && isset($params['callFunction']))
			{
				if(isset($params['callFunction']) && $params['callFunction']!="")
				{   
					$funName = $params['callFunction'];
					$funName($params);
				}
			}			
			//echo build_json_success($result);

	}catch(Exception $ex){
			//echo build_json_error($ex);
	}
	
	
	function getASINRepriceInventory($requestData)
	{
		$xml = new SimpleXMLExtended('<getasin/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(stripslashes($requestData['usertoken']));
		$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
		$xml->dbcode = $requestData['dbcode'];
	
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->asin = NULL;
		$xml->asin =  $requestData['asin'];//10;//$requestData['asin'];//"B00K54N1MU";
		$xml->accountcode = NULL;
		$xml->accountcode = $requestData['accountcode'];//21;//$requestData['accountcode'];//1;
		
		$requestXml = $xml->saveXML();   //http://winserver2012/InventoryAPI/api/Repricing/GetRepriceInventory
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".COMPETEAPIURL."/InventoryAPI/api/Repricing/GetAsin");
	
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
	
		$respArray = json_decode($result,true);
		$simpleXml = simplexml_load_string(stripslashes($respArray['asininformation']));
		$respArray = stripslashes(json_encode($simpleXml));
		$respArray = json_decode($respArray,true);
				
				
		if($respArray['NotificationPayload']['AnyOfferChangedNotification']['OfferChangeTrigger']['ASIN']!="")
		{
				$message = file_get_contents($requestData['prefixurl'].'/dp/'.$respArray['NotificationPayload']['AnyOfferChangedNotification']['OfferChangeTrigger']['ASIN']);
				
				$images = array();
				
				// Instantiate a new object of class DOMDocument
				$doc = new DOMDocument();
				
				libxml_use_internal_errors(true);
				// Load the HTML doc into the object
				$doc->loadHTML($message);
				libxml_use_internal_errors(false);
				
				// Get all the IMG tags in the document
				$elements = $doc->getElementsByTagName('img');
				
				// If we get at least one result
				if($elements->length > 0)
				{
					// Loop on all of the IMG tags
					foreach($elements as $element)
					{
						if($element->getAttribute('id') == 'landingImage'){
							$src = $element->getAttribute('src');
							
							if (strlen($src) > 0) {
								// Add the link to the array containing all the links
								array_push($images, $src);
							}
						}
					}
					$respArray['productImage'] = $images;
				
				} 
				$respArray['productasin'] = $respArray['NotificationPayload']['AnyOfferChangedNotification']['OfferChangeTrigger']['ASIN'];
				if (preg_match('/<span id="productTitle" class="a-size-large">([^<]*)<\/span>/', $message, $matches) > 0) {
					$respArray['productName'] = $matches[1]; 
				}
				$respArray['statuscode'] = 0;
		}else{
			$respArray['statuscode'] = 404;
			$respArray['statusmessage'] = 'ASIN information not foound';
		}	
		//return $respArray;
		echo json_encode(array('data'=>$respArray));
	}
	
	function removeSpecialCharsNew($text)
	{
		$arrsplcharacter =array("Ã‚Â ","Ã‚Â¡","Ã‚Â¢","Ã‚Â£","Ã‚Â¥","Ã‚Â§","Ã‚Â¨","Ã‚Â©","Ã‚Â«","Ã‚Â¬","Ã‚Â®","Ã‚Â±","Ã‚Â´","Ã‚Âµ","Ã‚Â¶","Ã‚Â·","Ã‚Â¸","Ã‚Â»","Ã‚Â¿","Ãƒâ‚¬","Ãƒï¿½","Ãƒâ€š","ÃƒÆ’","Ãƒâ€ž","Ãƒâ€¦","Ãƒâ€ Ãƒâ€¡","ÃƒË†","Ãƒâ€°","ÃƒÅ ","Ãƒâ€¹","ÃƒÅ’","Ãƒï¿½","ÃƒÅ½","Ãƒï¿½","Ãƒâ€˜","Ãƒâ€™","Ãƒâ€œ","Ãƒâ€","Ãƒâ€¢","Ãƒâ€“","ÃƒËœ","Ãƒâ„¢","ÃƒÅ¡","Ãƒâ€º","ÃƒÅ“","ÃƒÅ¸","ÃƒÂ ","ÃƒÂ¡","ÃƒÂ¢","ÃƒÂ£","ÃƒÂ¤","ÃƒÂ¥","ÃƒÂ¦","ÃƒÂ§","ÃƒÂ¨","ÃƒÂ©","ÃƒÂª","ÃƒÂ«","ÃƒÂ¬","ÃƒÂ­","ÃƒÂ®","ÃƒÂ¯","ÃƒÂ±","ÃƒÂ²","ÃƒÂ³","ÃƒÂ´","ÃƒÂµ","ÃƒÂ¶","ÃƒÂ¶","ÃƒÂ·","ÃƒÂ¸","ÃƒÂ¹","ÃƒÂº","ÃƒÂ»","ÃƒÂ¼","ÃƒÂ¿","Ã¢â‚¬Å¡","Ã†â€™","Ã¢â‚¬Å¾","Ã¢â‚¬Â¦","Ã¢â‚¬Â ","Ã¢â‚¬Â¡","Ã‹â€ ","Ã¢â‚¬Â°","Ã¢â‚¬Â¹","Ã…â€™","Ã¢â‚¬Ëœ","Ã¢â‚¬â„¢","Ã¢â‚¬Å“","Ã¢â‚¬ï¿½","Ã¢â‚¬Â¢","Ã¢â‚¬â€œ","Ã¢â‚¬â€","Ã‹Å“","Ã¢â€žÂ¢","Ã¢â‚¬Âº","Ã…â€œ","Ã…Â¸","Ã‚Âº");
		$arrcode = array("&nbsp;","&iexcl;","&cent;","&pound;","&yen;","&sect;","&uml;","&copy;","&laquo;","&not;","&reg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&raquo;","&iquest;","&Agrave;","&Aacute;","","&Atilde;","&Auml;","&Aring;","&AElig;&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yuml;","&#8218;","&#402;","&#8222;","&#8230;","&#8224;","&#8225;","&#710;","&#8240;","&#8249;","&#338;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8211;","&#8212;","&#732;","&#8482;","&#8250;","&#339;","&#376;","&deg;");
		return str_replace($arrsplcharacter, $arrcode, $text);
	}

   function hmacNew($key, $data, $hashfunc='sha256') 
    {
		 $blocksize=64;
		 if (strlen($key) > $blocksize) $key=pack('H*', $hashfunc($key)); 
		 $key=str_pad($key, $blocksize, chr(0x00));
		 $ipad=str_repeat(chr(0x36), $blocksize);
		 $opad=str_repeat(chr(0x5c), $blocksize);
		 $hmac = pack('H*', $hashfunc(($key^$opad) . pack('H*', $hashfunc(($key^$ipad) . $data))));
		 return $hmac;
	} /**/
	
	function getRequestNew($secretKey, $request, $accessKeyID="", $version="2009-03-01")
	{
		   // Get host and url
		   $url = parse_url($request);
		
		   // Get Parameters of request
		   $request = $url['query'];
		   $parameters = array();
		   parse_str($request, $parameters);
		   $parameters["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z"); 
		   $parameters["Version"] = $version;
		   if ($accessKeyID != '') $parameters["AWSAccessKeyId"] = $accessKeyID;
		
		   // Sort paramters
		   ksort($parameters);
		   
		   // re-build the request 
		   $request = array(); 
			foreach ($parameters as $parameter=>$value) 
			 { 
			  $parameter = str_replace("_", ".", $parameter); 
			  $parameter = str_replace("%7E", "~", rawurlencode($parameter)); 
			  $value = str_replace("%7E", "~", rawurlencode($value)); 
			  $request[] = $parameter . "=" . $value; 
			 } 
		   $request = implode("&", $request);
		//debugbreak();
		   $signatureString = "GET" . chr(10) . $url['host'] . chr(10) . $url['path'] . chr(10) . $request;
		  
		   $signature = urlencode(base64_encode(hmacNew($secretKey, $signatureString)));   
		 
		   $request = "http://" . $url['host'] . $url['path'] . "?" . $request . "&Signature=" . $signature; 
		
		   return $request;
	}
	/**/
	
	function getAmazonProductInfo($dataArray)
	{
 		$searchVal = $dataArray['searchKeyword'];
		$searchIdType = $dataArray['searchKeywordType'];
		
		/*Below are default parameters*/
		$countryShortName = "UK";
		$Arg_WebServicePrefix = "webservices.amazon.co.uk";
		$str_AccessKey = "AKIAJJS6QYCY5GVQGEXQ";
		$str_SecretKey = "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";
		/*Above are default parameters*/
		$webURL = "http://www.amazon.co.uk/";
		
		if(isset($dataArray['countryShortName'])){
			$countryShortName = $dataArray['countryShortName'];
		}
		
		if($countryShortName == 'FR'){
			$Arg_WebServicePrefix = "webservices.amazon.fr";
			$webURL = "http://www.amazon.fr/dp/";
		}else if($countryShortName == 'DE'){
			$Arg_WebServicePrefix = "webservices.amazon.de";
			$webURL = "http://www.amazon.de/dp/";
		}else if($countryShortName == 'ES'){
			$Arg_WebServicePrefix = "webservices.amazon.es";
			$webURL = "http://www.amazon.co.uk/dp/";
		}else if($countryShortName == 'IT'){
			$Arg_WebServicePrefix = "webservices.amazon.it";
			$webURL = "http://www.amazon.it/dp/";
		}else if($countryShortName == 'CA'){
			$Arg_WebServicePrefix = "webservices.amazon.ca";
			$webURL = "http://www.amazon.ca/dp/";
			$str_SecretKey = "RHXOpVpZGY6cw9/0hNYnmgkmHYfR+jMa1nGF51RI";
			$str_AccessKey = "AKIAJRXAB627VSMWAZQA";
		}else if($countryShortName == 'US'){
			$Arg_WebServicePrefix = "webservices.amazon.com";
			$webURL = "http://www.amazon.com/dp/";
			$str_SecretKey = "RHXOpVpZGY6cw9/0hNYnmgkmHYfR+jMa1nGF51RI";
			$str_AccessKey = "AKIAJRXAB627VSMWAZQA";		
		}else if($countryShortName == 'IN'){
			$webURL = "http://www.amazon.in/dp/";
			$Arg_WebServicePrefix = "webservices.amazon.in";
		}else if($countryShortName == 'JP'){
			$webURL = "http://www.amazon.co.jp/dp/";
			$Arg_WebServicePrefix = "webservices.amazon.co.jp";
			$str_SecretKey = "qb29SxQM5+13NKi3jGRPjCnlbIaL6+QnI6y1oKDb";
			$str_AccessKey = "AKIAIKN2UOK34NTGAUIQ";			
		}else if($countryShortName == 'CN'){
			$webURL = "http://www.amazon.cn/dp/";
			$Arg_WebServicePrefix = "webservices.amazon.cn";
			$str_SecretKey = "qb29SxQM5+13NKi3jGRPjCnlbIaL6+QnI6y1oKDb";
			$str_AccessKey = "AKIAIKN2UOK34NTGAUIQ";			
		}else{
			$webURL = "http://www.amazon.co.uk/dp/";
			$Arg_WebServicePrefix = "webservices.amazon.co.uk";
		}
		
		$parameters = array();
		
		$Arg_SearchCondition = "New";
		$str_RequestBarcode = $searchVal;//"B009R123BC";//ASIN NO
		$AssocTag = '247tops-20';
		$Arg_SearchCategory = "All";	  
				
		/*$params = array ( 
					'Service' 			=> 'AWSECommerceService',
					'AWSAccessKeyId' 	=> $str_AccessKey,
					'AssociateTag' 		=> $AssocTag,
					'Version' 			=> '2006-09-11',
					'Operation'  		=> 'ItemLookup',
					'ResponseGroup'  	=> 'Medium,OfferFull',
					'MerchantId' 		=> 'All',
					'IdType'			=> $searchIdType,
					//'SearchIndex' 		=> 'Books',           
					'Condition' 		=> $Arg_SearchCondition,
					'ItemId'	   		=> $str_RequestBarcode,				
			);*/
			
			if ($searchIdType == "ISBN") {
			
			 $params = array ( 
                'Service' 			=> 'AWSECommerceService',
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'AssociateTag' 		=> $AssocTag,
				'Version' 			=> '2006-09-11',
                'Operation'  		=> 'ItemLookup',
				'ResponseGroup'  	=> 'Medium,OfferFull',
                'MerchantId' 		=> 'All',
				'IdType'			=> 'ISBN',
				'SearchIndex' 		=> 'Books',           
                'Condition' 		=> $Arg_SearchCondition,
				'ItemId'	   		=> $str_RequestBarcode,				
            );
			
		}
        elseif ($searchIdType == "ASIN") {
			
			$params = array ( 
                'Service' 			=> 'AWSECommerceService',
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'AssociateTag' 		=> $AssocTag,
				'Version' 			=> '2006-09-11',
                'Operation'  		=> 'ItemLookup',
				'ResponseGroup'  	=> 'Medium,OfferFull',
                'MerchantId' 		=> 'All',
				'IdType'			=> 'ASIN',
				//'SearchIndex' 		=> 'Books',           
                'Condition' 		=> $Arg_SearchCondition,
				'ItemId'	   		=> $str_RequestBarcode,				
            );
			
			   }
        elseif ($searchIdType == "EAN") {
		
			$params = array ( 
                'Service' 			=> 'AWSECommerceService',
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'AssociateTag' 		=> $AssocTag,
				'Version' 			=> '2006-09-11',
                'Operation'  		=> 'ItemLookup',
				'ResponseGroup'  	=> 'Medium',
                'MerchantId' 		=> 'All',
				'IdType'			=> 'EAN',
				'SearchIndex' 		=> $Arg_SearchCategory,           
                'Condition' 		=> $Arg_SearchCondition,
				'ItemId'	   		=> $str_RequestBarcode,				
            );
			
		}
        elseif ($searchIdType == "UPC") {
			
			$params = array ( 
                'Service' 			=> 'AWSECommerceService',
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'AssociateTag' 		=> $AssocTag,
				'Version' 			=> '2006-09-11',
                'Operation'  		=> 'ItemLookup',
				'ResponseGroup'  	=> 'Medium,OfferFull',
                'MerchantId' 		=> 'All',
				'IdType'			=> 'UPC',
				'SearchIndex' 		=> $Arg_SearchCategory,           
                'Condition' 		=> $Arg_SearchCondition,
				'ItemId'	   		=> $str_RequestBarcode,				
            );
		}
        elseif ($searchIdType == "KEYWORD") {
			
			$params = array ( 
                'Service' 			=> 'AWSECommerceService',
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'AssociateTag' 		=> $AssocTag,
				'Version' 			=> '2006-09-11',
                'Operation'  		=> 'ItemSearch',
				'ResponseGroup'  	=> 'Medium,OfferFull',
                'MerchantId' 		=> 'All',
				//'IdType'			=> 'UPC',
				'SearchIndex' 		=> $Arg_SearchCategory,           
                //'Condition' 		=> $Arg_SearchCondition,
				'Keywords'	   		=> $str_RequestBarcode,				
            );
		}
		
			$BaseAmazonUrl 	= "http://".$Arg_WebServicePrefix."/onca/xml";
			$secretKey 	= $str_SecretKey;
			$query_string = '';
			
			foreach ($params as $key => $value) 
			{ 
				$query_string .= "$key=" . urlencode($value) . "&";
			}        
			
			$AmazonUrlResponseInXml = "$BaseAmazonUrl?$query_string";
			$requestURL = getRequestNew($secretKey, $AmazonUrlResponseInXml, $str_AccessKey, "2011-08-01"); 
			//echo $requestURL;exit;
			//$requestURL = "http://webservices.amazon.co.uk/onca/xml?AWSAccessKeyId=AKIAJJS6QYCY5GVQGEXQ&AssociateTag=247tops-20&Condition=New&IdType=ASIN&ItemId=B00IGL9PSS&MerchantId=All&Operation=ItemLookup&ResponseGroup=Medium%2COfferFull&Service=AWSECommerceService&Timestamp=2014-12-12T15%3A25%3A06Z&Version=2011-08-01&Signature=qmpzBvwboQ5YvtztTYywaL%2FVdo58dIScAzTSNl8820k%3D";
			//$requestURL = "http://webservices.amazon.co.uk/onca/xml?AWSAccessKeyId=AKIAJJS6QYCY5GVQGEXQ&AssociateTag=247tops-20&Condition=New&IdType=ASIN&ItemId=B009R123BC&MerchantId=All&Operation=ItemLookup&ResponseGroup=Medium%2COfferFull&Service=AWSECommerceService&Timestamp=2014-12-15T08%3A33%3A00Z&Version=2011-08-01&Signature=OlbYhkXkcsLA%2BN9amdc6EyEkOcdcRv0rSG7%2FeHW8fFg%3D";

			$session = curl_init($requestURL);
			//print_r($requestURL);exit;
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
					
			if(isset($response) && $response!=='' && !empty($response))
			{
					$parsed_xml = simplexml_load_string($response);
					$a = $parsed_xml->Items;
					//echo "IMAgE".$parsed_xml->Items->Item->SmallImage->URL;
				
					/*$productName = $parsed_xml->Items->Item->ItemAttributes->Title;
					$productName = removeSpecialCharsNew($productName);
			
					foreach($parsed_xml->Items->Item->ImageSets->ImageSet as $imageSet)
					{
						$largeImgURL = $imageSet->LargeImage->URL;
					}*/

					$respArray = array();
					if(!isset($parsed_xml->Items->Request->Errors))
					{
						$respArray['prodTitle'] = $parsed_xml->Items->Item->ItemAttributes->Title; 
						
						$respArray['prodUrl'] = $parsed_xml->Items->Item->MediumImage->URL; 
						$respArray['prodCategory'] = $parsed_xml->Items->Item->ItemAttributes->Binding;
						$respArray['prodEAN'] = $parsed_xml->Items->Item->ItemAttributes->EAN;
						$respArray['prodASIN'] = $parsed_xml->Items->Item->ASIN;
						$respArray['prodBrand'] = $parsed_xml->Items->Item->ItemAttributes->Brand;
						$respArray['prodFeatures'] = $parsed_xml->Items->Item->ItemAttributes->Feature;
						$respArray['prodSalesRank'] = $parsed_xml->Items->Item->SalesRank;
						$tempCurCode = (isset($parsed_xml->Items->Item->Offers->Offer->OfferListing->Price->CurrencyCode)) ? ($parsed_xml->Items->Item->Offers->Offer->OfferListing->Price->CurrencyCode) : '' ;
						$tempformattedPrice = (isset($parsed_xml->Items->Item->Offers->Offer->OfferListing->Price->FormattedPrice)) ? ($parsed_xml->Items->Item->Offers->Offer->OfferListing->Price->FormattedPrice) : ''; 
						$respArray['prodListPrice'] = $tempCurCode."--".removeSpecialCharsNew($tempformattedPrice);
						$respArray['prodLowestUsedPrice'] = $parsed_xml->Items->Item->OfferSummary->LowestUsedPrice->CurrencyCode."--".removeSpecialCharsNew($parsed_xml->Items->Item->OfferSummary->LowestUsedPrice->FormattedPrice);
						$respArray['prodLowestNewPrice'] = $parsed_xml->Items->Item->OfferSummary->LowestNewPrice->CurrencyCode."--".removeSpecialCharsNew($parsed_xml->Items->Item->OfferSummary->LowestNewPrice->FormattedPrice);
						$respArray['prodMPN'] = $parsed_xml->Items->Item->ItemAttributes->MPN;
						$respArray['prodCondition'] = (isset($parsed_xml->Items->Item->Offers->Offer->OfferAttributes->Condition))? $parsed_xml->Items->Item->Offers->Offer->OfferAttributes->Condition: '';
						if(isset($parsed_xml->Items->Item->EditorialReviews)){
							$respArray['prodDescription'] = $parsed_xml->Items->Item->EditorialReviews->EditorialReview->Content;
						}else{
							$respArray['prodDescription'] = '';
						}
						
						
						$imageAdditional = $parsed_xml->Items->Item->ImageSets->ImageSet;
						//print_r($imageAdditional);
						//echo sizeof($imageAdditional);
						$additionalImage = [];
						$swatchImage = '';
						for($i=0;$i<count($imageAdditional);$i++){
							$additionalImage[]= $imageAdditional[$i]->MediumImage->URL;
							$swatchImage= $imageAdditional[$i]->SwatchImage->URL;
						}
						
						$respArray['prodSwatchImage'] = $swatchImage;
						$respArray['prodAdditionalImgs'] = $additionalImage;
						
						$pageContent = @file_get_contents($webURL.trim($searchVal));
				
						$images = array();
						if($pageContent === FALSE){}
						else{
								// Instantiate a new object of class DOMDocument
								$doc = new DOMDocument();
								
								libxml_use_internal_errors(true);
								// Load the HTML doc into the object
								$doc->loadHTML($pageContent);
								libxml_use_internal_errors(false);
								
								$elements = $doc->getElementsByTagName('img');

								if($elements->length > 0)
								{
									foreach($elements as $element)
									{
											$src = $element->getAttribute('data-old-hires');
											
											if (strlen($src) > 0) {
												// Add the link to the array containing all the links
												array_push($images, $src);
											}
									}	
								}
						}
						$respArray['mainImageToSave'] = "";

						if(count($images)>0){
							$respArray['mainImageToSave'] = $images[0];
						}else{
							$tempImg = '';
							$tempImg = isset($additionalImage[0][0]) ? $additionalImage[0][0] : '';
							$respArray['mainImageToSave'] = (string)$tempImg;
						}
						$respArray['statuscode'] = 0;
						$respArray['statusmessage'] = "success";
					}else{
						$respArray['statuscode'] = 404;
						$respArray['statusmessage'] = $parsed_xml->Items->Request->Errors->Error->Message;
					}
			}else 
			{
					$respArray['statuscode'] = 404;
					$respArray['statusmessage'] = 'Product Information Not Found!!';
			}
					//header('Content-type: application/json');
					echo json_encode(array('data'=>$respArray));
					//$callback = 'myfun';
					//echo $callback."(".json_encode(array('events'=>$respArray)).")";
					
	}
	
	
	
	
	
	function getCompetitorName($requestData)
	{
		$sellersArray = array();
		foreach($requestData['competitorIDsArr'] as $competitorID)
		{
			$message = @file_get_contents($requestData['prefixURL'].'/shops/'.$competitorID);
			if($message === FALSE) {
				//echo "content false";
			}else{
				// Instantiate a new object of class DOMDocument
				$doc = new DOMDocument();
				
				libxml_use_internal_errors(true);
				// Load the HTML doc into the object
				$doc->loadHTML($message);
				libxml_use_internal_errors(false);
				
				// Get all the IMG tags in the document
				$elements = $doc->getElementsByTagName('title');
				
				// If we get at least one result
				if($elements->length > 0)
				{
					$explodeTitle = '';
					// Loop on all of the IMG tags
					foreach($elements as $element)
					{
						$explodeTitle = '';
						if(strlen($element->textContent)>0){
							$explodeTitle = explode("@", $element->textContent);
							//$sellersArray[$competitorID] = trim($explodeTitle[0]); 
							if(count($explodeTitle)>0)
								$sellersArray[$competitorID] = trim($explodeTitle[0]); 
							else
								$sellersArray[$competitorID] = trim($element->textContent);
						}
					}
				}
			}	
		}	

			$respArray = array();
			$respArray['statuscode'] = 0;
			$respArray['sellerNamesArr'] = $sellersArray;
			//return $respArray;
			echo json_encode(array('data'=>$respArray));
	}
	
	function getCompetitorNameForRepricing($requestData)
	{
		$sellersArray = array();
		$i = 0;
		foreach($requestData['competitorIDsArr'] as $competitorID)
		{
			//echo '\n\r'.$competitorID['prefixurl'].'/shops/'.$competitorID['competitorID'];exit;
			$message = @file_get_contents($competitorID['prefixurl'].'/shops/'.$competitorID['competitorID']);
			if($message === FALSE) {
				//echo "content false";
			}else{
				// Instantiate a new object of class DOMDocument
				$doc = new DOMDocument();
				
				libxml_use_internal_errors(true);
				// Load the HTML doc into the object
				$doc->loadHTML($message);
				libxml_use_internal_errors(false);
				
				// Get all the IMG tags in the document
				$elements = $doc->getElementsByTagName('title');
				
				// If we get at least one result
				if($elements->length > 0)
				{
					$explodeTitle = '';
					// Loop on all of the IMG tags
					foreach($elements as $element)
					{
						$explodeTitle = '';
						if(strlen($element->textContent)>0){
							$explodeTitle = explode("@", $element->textContent);
							if(count($explodeTitle)>0)
								$sellersArray[$competitorID['competitorID']] = trim($explodeTitle[0]); 
							else
								$sellersArray[$competitorID['competitorID']] = trim($element->textContent); 
						}
					}
				}
			}	
			$i++;
		}	

			$respArray = array();
			$respArray['statuscode'] = 0;
			$respArray['sellerNamesArr'] = $sellersArray;
			//return $respArray;
			echo json_encode(array('data'=>$respArray));
	}
	
	function getHtmlContent($requestData)
	{
		$fullurl = '';
		$fullurl = $requestData['url'];
		$message = @file_get_contents($fullurl);
		if($message===FALSE){ return '';}else{
				// Instantiate a new object of class DOMDocument
				$doc = new DOMDocument();
				
				libxml_use_internal_errors(true);
				// Load the HTML doc into the object
				$doc->loadHTML($message);
				libxml_use_internal_errors(false);

				if(isset($doc->textContent) && $doc->textContent!==''){
					$saveHTML = $doc->saveHTML();//$doc->textContent;
					$saveHTML = str_replace(",","\n<br/>", $saveHTML);
					//return $saveHTML;
					echo json_encode(array('data'=>$saveHTML));
				}else { 
					echo '';
					//return ''; 
				}
				//print_r($doc->textContent);
		}
	}
	
	
	function GetRepriceItemFromMySql($requestData)
	{
		$xml = new SimpleXMLExtended('<getrepriceitemfrommysqlrequest/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(stripslashes($requestData['usertoken']));
		$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
		$xml->dbcode = $requestData['dbcode'];	
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->asin = NULL;
		$xml->asin->addCData($requestData['asincode']);
		$xml->accountcode= NULL;
		$xml->accountcode->addCData($requestData['fkaccountcode']);

		$requestXml = $xml->saveXML();  

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".COMPETEAPIURL."/InventoryAPI/api/Repricing/GetRepriceItemFromMySql");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		
		$respArray = json_decode($result,true);
		//echo count($respArray['repriceitems']);
		$modifiedDatesArr = array();
		$datesArr = array();
		foreach($respArray['repriceitems'] as $item)
		{
			$splitDate = '';
			$tempSplitDate = '';
			$avgminPrice = '';
			$avgmaxPrice = '';
			$avgfinalPrice = '';
			$avgbuyboxPrice = '';
			
			if(isset($item['createdon']) && $item['createdon']!==''){
				$tempSplitDate = explode(" ",$item['createdon']);	
			}
			$splitDate = $tempSplitDate[0];
			$modifiedDatesArr[$splitDate]['createdon'][] =  $item['createdon'];
			$modifiedDatesArr[$splitDate]['minprice'][] =  $item['minprice'];
			$modifiedDatesArr[$splitDate]['maxprice'][] =  $item['maxprice'];
			$modifiedDatesArr[$splitDate]['finalprice'][] =  ($item['finalprice']+$item['shippingprice']);
			$modifiedDatesArr[$splitDate]['buyboxprice'][] =  $item['buyboxprice'];
				$avgminPrice = (array_sum($modifiedDatesArr[$splitDate]['minprice'])/count($modifiedDatesArr[$splitDate]['minprice']));
			$modifiedDatesArr[$splitDate]['avgminPrice'] =  number_format((float)$avgminPrice, 2, '.', '');
				$avgmaxPrice = (array_sum($modifiedDatesArr[$splitDate]['maxprice'])/count($modifiedDatesArr[$splitDate]['maxprice']));
			$modifiedDatesArr[$splitDate]['avgmaxPrice'] = number_format((float)$avgmaxPrice, 2, '.', ''); 
				$avgfinalPrice = (array_sum($modifiedDatesArr[$splitDate]['finalprice'])/count($modifiedDatesArr[$splitDate]['finalprice']));
			$modifiedDatesArr[$splitDate]['avgfinalPrice'] =   number_format((float)$avgfinalPrice, 2, '.', '');
				$avgbuyboxPrice = (array_sum($modifiedDatesArr[$splitDate]['buyboxprice'])/count($modifiedDatesArr[$splitDate]['buyboxprice']));
			$modifiedDatesArr[$splitDate]['avgbuyboxPrice'] =    number_format((float)$avgbuyboxPrice, 2, '.', ''); 
			$datesArr[] = $splitDate;
		}
		$datesArr = array_unique($datesArr);
			$monthsArr = array();
			//print_r($datesArr);
			foreach($datesArr as $uniqDates){
				$splitDate = '';
				
				$splitDate = explode("/",$uniqDates);
				//print_r($splitDate);
				$monthsArr['months'][] = $splitDate[0];
				$monthsArr['years'][] = $splitDate[2];
			}
			//print_r($monthsArr);
			if(count($monthsArr)>0){
				if(count($monthsArr['months'])>0)
				$monthsModifiedArr = array_unique($monthsArr['months']);
			}
				
		//print_r($modifiedDatesArr);//exit;
		//print_r($respArray);
		$responseArr = array();
		if(count($modifiedDatesArr)<10){ //Days
		$responseArr['statuscode']=0;
		//echo "inside";
			
			foreach($modifiedDatesArr as $innerInd=>$dateDetails){
						$loopDate = date('m/d/Y',strtotime($innerInd));
						//print_r($innerInd);
						//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
						
						//if(strtotime($fromDate)<=strtotime($loopDate) && strtotime($toDate)>=strtotime($loopDate)){
							//echo "<br/>Inside--".$loopDate;
							$responseArr['type'] = 'days';
							$responseArr['mainData'][$loopDate]['minprice'][] = $dateDetails['avgminPrice'];
							$responseArr['mainData'][$loopDate]['maxprice'][] = $dateDetails['avgmaxPrice'];
							$responseArr['mainData'][$loopDate]['finalprice'][] = $dateDetails['avgfinalPrice'];
							$responseArr['mainData'][$loopDate]['buyboxprice'][] = $dateDetails['avgbuyboxPrice'];
									$avgminPrice = (array_sum($responseArr['mainData'][$loopDate]['minprice'])/count($responseArr['mainData'][$loopDate]['minprice']));
							$responseArr['mainData'][$loopDate]['avgminPrice'] = number_format((float)$avgminPrice, 2, '.', '');
									$avgmaxPrice = (array_sum($responseArr['mainData'][$loopDate]['maxprice'])/count($responseArr['mainData'][$loopDate]['maxprice']));
							$responseArr['mainData'][$loopDate]['avgmaxPrice'] =  number_format((float)$avgmaxPrice, 2, '.', '');
									$avgfinalPrice = (array_sum($responseArr['mainData'][$loopDate]['finalprice'])/count($responseArr['mainData'][$loopDate]['finalprice']));
							$responseArr['mainData'][$loopDate]['avgfinalPrice'] =  number_format((float)$avgfinalPrice, 2, '.', '');
									$avgbuyboxPrice = (array_sum($responseArr['mainData'][$loopDate]['buyboxprice'])/count($responseArr['mainData'][$loopDate]['buyboxprice']));
							$responseArr['mainData'][$loopDate]['avgbuyboxPrice'] =  number_format((float)$avgbuyboxPrice, 2, '.', '');
						//}
					}

		}else if(count($modifiedDatesArr)>10 && count($modifiedDatesArr)<30){ //Weeks
			$responseArr['statuscode']=0;
			foreach($monthsModifiedArr as $index=>$month)
			{
				for($i=0;$i<4;$i++)
				{ 
					$j = ($i==0)? 1 : (($i*7)+1);
					
					$strDate = '';
					
					$strDate = $month.'/'.$j.'/'.$monthsArr['years'][$index];
					$fromDate = date('m/d/Y',strtotime($strDate));
					//echo "\n\r".$fromDate;
					$date = strtotime($fromDate);
					//echo 
					if($i==3)
						$toDate = date('m/t/Y', strtotime($month.'/30/'.$monthsArr['years'][$index]));
					else
						$toDate = date('m/d/Y', strtotime("+7 day", $date));
					
					//echo "--".$toDate;// = date('m/d/Y', $toDate);

					//echo date('m/d/Y', strtotime("+1 week"));
					
					foreach($modifiedDatesArr as $innerInd=>$dateDetails){
						$loopDate = date('m/d/Y',strtotime($innerInd));
						//print_r($innerInd);
						//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
						
						if(strtotime($fromDate)<=strtotime($loopDate) && strtotime($toDate)>=strtotime($loopDate)){
							//echo "<br/>Inside--".$loopDate;
							$responseArr['type'] = 'week';
							$responseArr['mainData'][$fromDate.'-'.$toDate]['minprice'][] = $dateDetails['avgminPrice'];
							$responseArr['mainData'][$fromDate.'-'.$toDate]['maxprice'][] = $dateDetails['avgmaxPrice'];
							$responseArr['mainData'][$fromDate.'-'.$toDate]['finalprice'][] = $dateDetails['avgfinalPrice'];
							$responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxprice'][] = $dateDetails['avgbuyboxPrice'];
									$avgminPrice = (array_sum($responseArr['mainData'][$fromDate.'-'.$toDate]['minprice'])/count($responseArr['mainData'][$fromDate.'-'.$toDate]['minprice']));
							$responseArr['mainData'][$fromDate.'-'.$toDate]['avgminPrice'] = number_format((float)$avgminPrice, 2, '.', '');
									$avgmaxPrice = (array_sum($responseArr['mainData'][$fromDate.'-'.$toDate]['maxprice'])/count($responseArr['mainData'][$fromDate.'-'.$toDate]['maxprice']));
							$responseArr['mainData'][$fromDate.'-'.$toDate]['avgmaxPrice'] =  number_format((float)$avgmaxPrice, 2, '.', '');
									$avgfinalPrice = (array_sum($responseArr['mainData'][$fromDate.'-'.$toDate]['finalprice'])/count($responseArr['mainData'][$fromDate.'-'.$toDate]['finalprice']));
							$responseArr['mainData'][$fromDate.'-'.$toDate]['avgfinalPrice'] =  number_format((float)$avgfinalPrice, 2, '.', '');
									$avgbuyboxPrice = (array_sum($responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxprice'])/count($responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxprice']));
							$responseArr['mainData'][$fromDate.'-'.$toDate]['avgbuyboxPrice'] =  number_format((float)$avgbuyboxPrice, 2, '.', '');
						}
					}
				}
			}
			
		}else { //Months
			$responseArr['statuscode']=0;
			foreach($monthsModifiedArr as $index=>$month)
			{
				//print_r($month);
				$fromDate = date('m/d/Y', strtotime($month.'/1/'.$monthsArr['years'][$index]));
				$toDate = date('m/t/Y', strtotime($month.'/30/'.$monthsArr['years'][$index]));
				$indexStr = date('F Y', strtotime($month.'/1/'.$monthsArr['years'][$index]));
				
				foreach($modifiedDatesArr as $innerInd=>$dateDetails){
					$loopDate = date('m/d/Y',strtotime($innerInd));
					//print_r($innerInd);
					//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
					
					if(strtotime($fromDate)<=strtotime($loopDate) && strtotime($toDate)>=strtotime($loopDate)){
						//echo "<br/>Inside--".$loopDate;
						$responseArr['type'] = 'month';
						$responseArr['mainData'][$indexStr]['minprice'][] = $dateDetails['avgminPrice'];
						$responseArr['mainData'][$indexStr]['maxprice'][] = $dateDetails['avgmaxPrice'];
						$responseArr['mainData'][$indexStr]['finalprice'][] = $dateDetails['avgfinalPrice'];
						$responseArr['mainData'][$indexStr]['buyboxprice'][] = $dateDetails['avgbuyboxPrice'];
								$avgminPrice = (array_sum($responseArr['mainData'][$indexStr]['minprice'])/count($responseArr['mainData'][$indexStr]['minprice']));
						$responseArr['mainData'][$indexStr]['avgminPrice'] = number_format((float)$avgminPrice, 2, '.', '');
								$avgmaxPrice = (array_sum($responseArr['mainData'][$indexStr]['maxprice'])/count($responseArr['mainData'][$indexStr]['maxprice']));
						$responseArr['mainData'][$indexStr]['avgmaxPrice'] =  number_format((float)$avgmaxPrice, 2, '.', '');
								$avgfinalPrice = (array_sum($responseArr['mainData'][$indexStr]['finalprice'])/count($responseArr['mainData'][$indexStr]['finalprice']));
						$responseArr['mainData'][$indexStr]['avgfinalPrice'] =  number_format((float)$avgfinalPrice, 2, '.', '');
								$avgbuyboxPrice = (array_sum($responseArr['mainData'][$indexStr]['buyboxprice'])/count($responseArr['mainData'][$indexStr]['buyboxprice']));
						$responseArr['mainData'][$indexStr]['avgbuyboxPrice'] =  number_format((float)$avgbuyboxPrice, 2, '.', '');
					}
				}
			}
		}
		//return $responseArr;
		echo json_encode(array('data'=>$responseArr));
	}
	
	function GetBuyBoxComputeDetails($requestData)
	{
		$fromDate = $toDate = "";
		$fromDate = ($requestData['fromdate']!=='')? date("Y-m-d", strtotime($requestData['fromdate'])) : '';
		$toDate = ($requestData['todate']!=='')? date("Y-m-d", strtotime($requestData['todate'])) : '';
		
		$xml = new SimpleXMLExtended('<getinventorybuyboxcomputeddetailsrequest/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(stripslashes($requestData['usertoken']));
		$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
		$xml->dbcode = $requestData['dbcode'];	
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->accountcode= NULL;
		$xml->accountcode->addCData($requestData['fkaccountcode']);
		$xml->asin = NULL;
		$xml->asin->addCData($requestData['asincode']);		
		$daterange = $xml->addChild("daterange");
		$daterange->fromdate = NULL; 
		$daterange->fromdate->addCData($fromDate);
		$daterange->todate = NULL; 
		$daterange->todate->addCData($toDate);

		$requestXml = $xml->saveXML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".COMPETEAPIURL."/InventoryAPI/api/Repricing/GetInventoryBuyBoxComputedDetails");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		
		$respArray = json_decode($result,true);
		//echo "<pre>";
		//print_r($respArray);
		//echo count($respArray['asindetails']);
		$modifiedDatesArr = array();
		$datesArr = array();
		if(isset($respArray['statuscode']) && $respArray['statuscode']==0)
		{
				foreach($respArray['asindetails'] as $item)
				{
					$splitDate = '';
					$tempSplitDate = '';
					$avgbuyboxPer = '';
					
					if(isset($item['datetime']) && $item['datetime']!==''){
						$tempSplitDate = explode(" ",$item['datetime']);	
					}
					$splitDate = $tempSplitDate[0];
					//echo "<pre>";
					//print_r($item);
					//print_r($modifiedDatesArr[$splitDate]['buyboxpercentage']);
					$modifiedDatesArr[$splitDate]['datetime'][] =  $item['datetime'];
					$modifiedDatesArr[$splitDate]['buyboxper'][] = $item['buyboxpercentage'];

					$avgbuyboxPer = (array_sum($modifiedDatesArr[$splitDate]['buyboxper'])/count($modifiedDatesArr[$splitDate]['buyboxper']));
					$modifiedDatesArr[$splitDate]['buyboxpercentage'] =  number_format((float)$avgbuyboxPer, 2, '.', '');
					
					$datesArr[] = $splitDate;
				}
				$datesArr = array_unique($datesArr);
					$monthsArr = array();
					//print_r($datesArr);
					foreach($datesArr as $uniqDates){
						$splitDate = '';
						
						$splitDate = explode("-",$uniqDates);
						if(count($splitDate)>1){
						//print_r($splitDate);
							$monthsArr['months'][] = $splitDate[0];
							$monthsArr['years'][] = $splitDate[2];
						}
					}
					//print_r($monthsArr);
					if(count($monthsArr)>0){
						if(count($monthsArr['months'])>0)
						$monthsModifiedArr = array_unique($monthsArr['months']);
					}
						
				//print_r($modifiedDatesArr);//exit;
				//print_r($respArray);
				$responseArr = array();
				if(count($modifiedDatesArr)<10){ //Days
				$responseArr['statuscode']=0;
				//echo "inside";
					foreach($modifiedDatesArr as $innerInd=>$dateDetails){
								$loopDate = date('m/d/Y', strtotime($innerInd));
								//print_r($dateDetails['buyboxpercentage']);
								//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
								
									$responseArr['type'] = 'days';
									$responseArr['mainData'][$loopDate]['buyboxper'][] = $dateDetails['buyboxpercentage'];
											$avgbuyboxPer = (array_sum($responseArr['mainData'][$loopDate]['buyboxper'])/count($responseArr['mainData'][$loopDate]['buyboxper']));
									$responseArr['mainData'][$loopDate]['buyboxpercentage'] =  number_format((float)$avgbuyboxPer, 2, '.', '');
							}

				}else if(count($modifiedDatesArr)>10 && count($modifiedDatesArr)<30){ //Weeks
					$responseArr['statuscode']=0;
					foreach($monthsModifiedArr as $index=>$month)
					{
						for($i=0;$i<4;$i++)
						{ 
							$j = ($i==0)? 1 : (($i*7)+1);
							
							$strDate = '';
							
							$strDate = $month.'/'.$j.'/'.$monthsArr['years'][$index];
							$fromDate = date('m/d/Y',strtotime($strDate));
							//echo "\n\r".$fromDate;
							$date = strtotime($fromDate);
							//echo 
							if($i==3)
								$toDate = date('m/t/Y', strtotime($month.'/30/'.$monthsArr['years'][$index]));
							else
								$toDate = date('m/d/Y', strtotime("+7 day", $date));
							//echo "--".$toDate;// = date('m/d/Y', $toDate);
							//echo date('m/d/Y', strtotime("+1 week"));
			
							foreach($modifiedDatesArr as $innerInd=>$dateDetails){
								$loopDate = date('m/d/Y',strtotime($innerInd));
								//print_r($innerInd);
								//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
								
								if(strtotime($fromDate)<=strtotime($loopDate) && strtotime($toDate)>=strtotime($loopDate)){
									//echo "<br/>Inside--".$loopDate;
									$responseArr['type'] = 'week';
									$responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxper'][] = $dateDetails['buyboxpercentage'];
											$avgbuyboxPer = (array_sum($responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxper'])/count($responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxper']));
									$responseArr['mainData'][$fromDate.'-'.$toDate]['buyboxpercentage'] =  number_format((float)$avgbuyboxPer, 2, '.', '');
								}
							}
						}
					}
				}else { //Months
					$responseArr['statuscode']=0;
					foreach($monthsModifiedArr as $index=>$month)
					{
						//print_r($month);
						$fromDate = date('m/d/Y', strtotime($month.'/1/'.$monthsArr['years'][$index]));
						$toDate = date('m/t/Y', strtotime($month.'/30/'.$monthsArr['years'][$index]));
						$indexStr = date('F Y', strtotime($month.'/1/'.$monthsArr['years'][$index]));
						
						foreach($modifiedDatesArr as $innerInd=>$dateDetails){
							$loopDate = date('m/d/Y',strtotime($innerInd));
							//print_r($innerInd);
							//echo strtotime($fromDate)."----".strtotime($toDate)."-----".strtotime($loopDate);
							
							if(strtotime($fromDate)<=strtotime($loopDate) && strtotime($toDate)>=strtotime($loopDate)){
								//echo "<br/>Inside--".$loopDate;
								$responseArr['type'] = 'month';
								$responseArr['mainData'][$indexStr]['buyboxper'][] = $dateDetails['buyboxpercentage'];
										$avgbuyboxPer = (array_sum($responseArr['mainData'][$indexStr]['buyboxper'])/count($responseArr['mainData'][$indexStr]['buyboxper']));
								$responseArr['mainData'][$indexStr]['buyboxpercentage'] =  number_format((float)$avgbuyboxPer, 2, '.', '');
							}
						}
					}
				}
		}
		//return $responseArr;
		echo json_encode(array('data'=>$responseArr));
	}
	
	function getSuggestedCategories($dataArray)
	{
		$prodTitle = $dataArray['prodTitle'];
		$selAcctID = $dataArray['selAcctID'];
		$arrsplcharacter = array("Â ","Â¡","Â¢","Â£","Â¥","Â§","Â¨","Â©","Â«","Â¬","Â®","Â°","Â±","Â´","Âµ","Â¶","Â·","Â¸","Â»","Â¿","Ã€","Ã","Ã‚","Ãƒ","Ã„","Ã…","Ã†Ã‡","Ãˆ","Ã‰","ÃŠ","Ã‹","ÃŒ","Ã","ÃŽ","Ã","Ã‘","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã™","Ãš","Ã›","Ãœ","ÃŸ","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã¦","Ã§","Ã¨","Ã©","Ãª","Ã«","Ã¬","Ã­","Ã®","Ã¯","Ã±","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¶","Ã·","Ã¸","Ã¹","Ãº","Ã»","Ã¼","Ã¿","â€š","Æ’","â€ž","â€¦","â€ ","â€¡","Ë†","â€°","â€¹","Å’","â€˜","â€™","â€œ","â€","â€¢","â€“","â€”","Ëœ","â„¢","â€º","Å“","Å¸","?");
		$arrcode = array("&nbsp;","&iexcl;","&cent;","&pound;","&yen;","&sect;","&uml;","&copy;","&laquo;","&not;","&reg;","&deg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&raquo;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yuml;","&#8218;","&#402;","&#8222;","&#8230;","&#8224;","&#8225;","&#710;","&#8240;","&#8249;","&#338;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8211;","&#8212;","&#732;","&#8482;","&#8250;","&#339;","&#376;","&#322;");
		
		$siteID = 3;

		$verb = "GetSuggestedCategories";
		$devID = "cefa7552-3427-41d3-9cd0-c6ff7f82659e";
		$certID = "cda174f4-9bc1-428e-94a4-4115789aaffe";
		$appID = "247Topse-e9af-4f05-84c8-66acd9493b2b";
		$compatLevel = 445;
		
		$userToken = "AgAAAA**AQAAAA**aAAAAA**MPbTWA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkYOkDpSGpAydj6x9nY+seQ**QvsAAA**AAMAAA**ne5u+EW52URwDhQZXM3Ck6NpP3Nq9pJDJ9oYgX2TySrzrFPYtaCnNFauauTTVZ7UuyZ6Wh3WuP6fl3oyg2tXobQlVgWCqKdTZ2RSMVSaU2I79ScXky3PiJTdQGNspslUTvQ+P/3xjF5T4XnaRkgunvw9IIL3Hc4hG+EY3/7kfHEVBjnJE3AmJsBspbjL9oQOY7Vr2G6VskKrw1rf8KNKQktNjRafd3ef24ReqRsgQ/47YHyv9zzuDK6Drt4m4LY3neaeeQQ1qEFFWQV6uF4jQhABy08SELfdAfCTVzt4e+JbWC/kIXYnvEVbzIpoYNNx107Nkc79YTdHowRm8fkHWN+6n4UPM/mzNSAvuTlkWQNqonE8EXav/qHdCDFefUpEzKvCAXTIRm5/+kLw9hU5XiBKDiUBaJRNTWlWIDeSsArT5JRF+gnYTIANdJvZaeWITdzZticWUVdv+lIksqPf424STSAZHDbM7IXYAWVjKUrKZxiTlx8blIapkpJp5CNst1XJWHpV20dDF62WqMmEaBpzHb49RdY/+tBXSsTr5dDFKjZFCu8iMzvIVYkF3fT/SWuhMwq7Jitq3z+qKQHmYnKsd9fqd6HXRV2HWqSUGXh/HNxNUgtSaxbwfIru5j67U4aYzG9aLLAROhqVJtqMMOM5f85Bzn8XhVUxanR+XBoVnTtttshfXHJAkrwN5fkGGE4Q3lBOxvFmouOEk6Hdc5NMHvvUsRKaRj+zJRkF1J8KLqgmjK4E20vuS1frSG25";		
		$query = $prodTitle;
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatLevel,
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devID,
			'X-EBAY-API-APP-NAME: ' . $appID,
			'X-EBAY-API-CERT-NAME: ' . $certID,
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $verb,			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $siteID,
		);
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken><![CDATA[$userToken]]></eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= "<Query><![CDATA[$query]]></Query>";
		$requestXmlBody .= '</GetSuggestedCategoriesRequest>';
		
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		//Send the Request
		$response = curl_exec($connection);
		
		$respXML = simplexml_load_string($response); 
	
		$responseArray = array();

		try
        {    
           if($respXML->Ack == "Success")
           {
				$suggestedCategories = $respXML->SuggestedCategoryArray->SuggestedCategory;
				$i=0;
				if($respXML->CategoryCount>0){
						foreach($suggestedCategories as $category){
							$leafCategory       = $category->Category->CategoryName;
							$leafCategoryID     = $category->Category->CategoryID;
							$parentCategories   = $category->Category->CategoryParentName;
							$percentageFound = $category->PercentItemFound;
							if(is_array($parentCategories))
								$categoryBreadCrumb = implode(' >> ', $parentCategories).' >> '.$leafCategory;
							else
								$categoryBreadCrumb = $parentCategories.' >> '.$leafCategory;
			
							$categoryBreadCrumb = str_replace($arrsplcharacter,$arrcode, $categoryBreadCrumb);
							
							$responseArray['statuscode'] = 0;
							$responseArray['categories'][$i]['categoryName'] = $categoryBreadCrumb;
							$responseArray['categories'][$i]['categoryID'] = (string)$leafCategoryID;
							$responseArray['categories'][$i]['percentageFound'] = (string)$percentageFound;
							$i++;
						}
				}else {
					 $responseArray['statuscode'] = 404;
					 $responseArray['statusmessage'] = "Category Not Found!!!";
				}

		   } else
           {
			  // echo '<pre>';print_r((array)$respXML->Errors->LongMessage);
			   if(isset($respXML->Errors)){
					 if(isset($respXML->Errors->LongMessage)){
						 $tmpLongmsg = (array)$respXML->Errors->LongMessage;
						 $responseArray['statusmessage'] = $tmpLongmsg[0];
					 }else 
						 $responseArray['statusmessage'] = "Category Not Found Error!!!";
			   }else
					$responseArray['statusmessage'] = "Category Not Found Error!!!";
			
			   $responseArray['statuscode'] = 404;
			   //$responseArray['statusmessage'] = $respXML->Errors[1]->LongMessage;
           }
       }
       catch (Exception $ex)
       {
            $responseArray['statuscode'] = 404;
		    $responseArray['statusmessage'] = "Something went wrong!!!";
       }

		//close the connection
		curl_close($connection);
		
		//return the response
		//return $responseArray;
		echo json_encode(array('data'=>$responseArray));
	}
	
	
	function getItemSpecifics($dataArray)
	{
		$selAcctID = $dataArray['selAcctID'];
		$eBayCategory1 = $dataArray['eBayCategory1'];
		$arrsplcharacter = array("Â ","Â¡","Â¢","Â£","Â¥","Â§","Â¨","Â©","Â«","Â¬","Â®","Â°","Â±","Â´","Âµ","Â¶","Â·","Â¸","Â»","Â¿","Ã€","Ã","Ã‚","Ãƒ","Ã„","Ã…","Ã†Ã‡","Ãˆ","Ã‰","ÃŠ","Ã‹","ÃŒ","Ã","ÃŽ","Ã","Ã‘","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã™","Ãš","Ã›","Ãœ","ÃŸ","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã¦","Ã§","Ã¨","Ã©","Ãª","Ã«","Ã¬","Ã­","Ã®","Ã¯","Ã±","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¶","Ã·","Ã¸","Ã¹","Ãº","Ã»","Ã¼","Ã¿","â€š","Æ’","â€ž","â€¦","â€ ","â€¡","Ë†","â€°","â€¹","Å’","â€˜","â€™","â€œ","â€","â€¢","â€“","â€”","Ëœ","â„¢","â€º","Å“","Å¸","?");
		$arrcode = array("&nbsp;","&iexcl;","&cent;","&pound;","&yen;","&sect;","&uml;","&copy;","&laquo;","&not;","&reg;","&deg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&raquo;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yuml;","&#8218;","&#402;","&#8222;","&#8230;","&#8224;","&#8225;","&#710;","&#8240;","&#8249;","&#338;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8211;","&#8212;","&#732;","&#8482;","&#8250;","&#339;","&#376;","&#322;");
		
		$siteID = 3;
		$verb = "GetCategorySpecifics";
		$devID = "cefa7552-3427-41d3-9cd0-c6ff7f82659e";
		$certID = "cda174f4-9bc1-428e-94a4-4115789aaffe";
		$appID = "247Topse-e9af-4f05-84c8-66acd9493b2b";
		$compatLevel = 793;
		$userToken = "AgAAAA**AQAAAA**aAAAAA**MPbTWA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkYOkDpSGpAydj6x9nY+seQ**QvsAAA**AAMAAA**ne5u+EW52URwDhQZXM3Ck6NpP3Nq9pJDJ9oYgX2TySrzrFPYtaCnNFauauTTVZ7UuyZ6Wh3WuP6fl3oyg2tXobQlVgWCqKdTZ2RSMVSaU2I79ScXky3PiJTdQGNspslUTvQ+P/3xjF5T4XnaRkgunvw9IIL3Hc4hG+EY3/7kfHEVBjnJE3AmJsBspbjL9oQOY7Vr2G6VskKrw1rf8KNKQktNjRafd3ef24ReqRsgQ/47YHyv9zzuDK6Drt4m4LY3neaeeQQ1qEFFWQV6uF4jQhABy08SELfdAfCTVzt4e+JbWC/kIXYnvEVbzIpoYNNx107Nkc79YTdHowRm8fkHWN+6n4UPM/mzNSAvuTlkWQNqonE8EXav/qHdCDFefUpEzKvCAXTIRm5/+kLw9hU5XiBKDiUBaJRNTWlWIDeSsArT5JRF+gnYTIANdJvZaeWITdzZticWUVdv+lIksqPf424STSAZHDbM7IXYAWVjKUrKZxiTlx8blIapkpJp5CNst1XJWHpV20dDF62WqMmEaBpzHb49RdY/+tBXSsTr5dDFKjZFCu8iMzvIVYkF3fT/SWuhMwq7Jitq3z+qKQHmYnKsd9fqd6HXRV2HWqSUGXh/HNxNUgtSaxbwfIru5j67U4aYzG9aLLAROhqVJtqMMOM5f85Bzn8XhVUxanR+XBoVnTtttshfXHJAkrwN5fkGGE4Q3lBOxvFmouOEk6Hdc5NMHvvUsRKaRj+zJRkF1J8KLqgmjK4E20vuS1frSG25";
		//$query = $prodTitle;
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatLevel,
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devID,
			'X-EBAY-API-APP-NAME: ' . $appID,
			'X-EBAY-API-CERT-NAME: ' . $certID,
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $verb,			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $siteID,
		);
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
		$requestXmlBody .= "<CategorySpecific><CategoryID><![CDATA[".$eBayCategory1."]]></CategoryID></CategorySpecific>";
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken><![CDATA[".$userToken."]]></eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= '</GetCategorySpecificsRequest>';
		//echo $requestXmlBody;exit;
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		//Send the Request
		$response = curl_exec($connection);
		
		//$rawAttributeXml 	= preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		
		$xmlToArray = simplexml_load_string($response); 

		$responseArray = array();

		try
        {    
			if(is_object($xmlToArray))
			{
				   if($xmlToArray->Ack == "Success")
				   {
					   if($xmlToArray->Recommendations!=='')
						{   
							$responseArray['statuscode'] = 0;
							$responseArray['itemspecifics'] = $xmlToArray->Recommendations;
							/*foreach($xmlToArray->Recommendations->NameRecommendation as $itemKey=>$itemArray)
							{
								$responseArray['itemspecifics'][]['Name'] = $itemArray->Name;
								$recommendValsArr = array();
								echo "<br/><br/>".$itemKey;
								$valRecommendations = '';
								$valRecommendations = $itemArray->ValueRecommendation;
								print_r($valRecommendations);
								if(is_array($valRecommendations))
								{
									foreach($valRecommendations as $valueRecommend);
									{
										print_r($valueRecommend);
										//$recommendValsArr[] = $valueRecommend->Value;	
										//$valueRecommend;
										//echo "dddd";
									}exit;
								}
								$responseArray['itemspecifics'][]['RecommendVals'] = $recommendValsArr;
							}*/
						}else {
							 $responseArray['statuscode'] = 404;
							 $responseArray['statusmessage'] = "Category Not Found!!!";
						}

				   } else
				   {
					   //echo '<pre>'; print_r($respXML->Errors[1]->LongMessage); 
					   $responseArray['statuscode'] = 404;
					   $responseArray['statusmessage'] = $xmlToArray->Errors[0]->LongMessage;
				   }
			}else{
					$responseArray['statuscode'] = 404;
					$responseArray['statusmessage'] = "Error";
			}
         
       }
       catch (Exception $ex)
       {
            $responseArray['statuscode'] = 404;
		    $responseArray['statusmessage'] = "Something went wrong!!!";
       }

		//close the connection
		curl_close($connection);
		//return the response
		//return $responseArray;
		echo json_encode(array('data'=>$responseArray));
	}
	
	function getEbayCustomCategories($requestData)
	{
		$levelLimit = $requestData['limitLevel'];
		$siteID = 0;
		$apiCallName = "GetStore";
		$devID = "cefa7552-3427-41d3-9cd0-c6ff7f82659e";
		$certID = "cda174f4-9bc1-428e-94a4-4115789aaffe";
		$appID = "247Topse-e9af-4f05-84c8-66acd9493b2b";
		$compatLevel = 793;
		$ebayAuthToken = $requestData['livetoken'];//"AgAAAA**AQAAAA**aAAAAA**vV8eVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJl4ekD5mCpgWdj6x9nY+seQ**QvsAAA**AAMAAA**l1LoBa5pSYX1p1yVoRQqDcc6oW06uaRsvLnb8fJOsgsxi7iV15XtoQ3LR4eHsaSKbTKNsbLjcL6WrukxKjplI0LtL1GtkmDemO9y90Qi0fpWL2tOTOICA7vB0IO1bzmPDtwRzgqiSKXkAo98qjOZgAMsRqFHBuT86wCujQoWxS5XvE8ZQn4FJtDKNEe6/wPiSZmPzRE/6omdF15+6Ak+VhG42XxIaNpT1J3DSBtQURnDw+0+bgl4xNaEOF+FiJUS+cjU7gqfYD9q9Xpa5hrFJJHPl7NqdBeb02ZwAD/cwKM8oNCTveAoDgwXaAXI9XJqFLvZ/kHKzvX3uuZjM5TGHIJ3w66e9d18qAidSDlye8rvMgY69aimUGnk7iVjaqzm7+nDZMCh3ENUeJQunrJ6ZrrXlNyZQgHjNrUSvz2d2CfrSzjgKz6CeKz0YjkdMNnng1VrS8SueUSCJjbj6KXQ+u/Qq6BAra9EHntZl1IEE3ZrJ4rmH4IqIT1qN6kWXT0Utdni0pJcS64dqyhKOftdUJFAuwbsPalxgE3TctFLzW2dOSfzdn/fOZsVW08YRMYkJDRp0PnuVUXDYXOuzd4e4aPGT0P6F2mGsXXmEcHZXkTwv/BbASmMmae34jKqB1VujZWO0GG5Rg2vz9VCbCeBSXQaXUBj0HBEHjr9K5k845wAyoYB2pGLMhTwpcjqxdzHeV7ye4fq3d4u0cTZUCEr/hFQwdvlBiBn50ZP8T2jFAsFu+xUoF32axluxWJCEdbT";		
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatLevel,
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devID,
			'X-EBAY-API-APP-NAME: ' . $appID,
			'X-EBAY-API-CERT-NAME: ' . $certID,
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $apiCallName,			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $siteID,
		);
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '<RequesterCredentials>';
		$requestXmlBody .= "<eBayAuthToken><![CDATA[".$ebayAuthToken."]]></eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= "<LevelLimit><![CDATA[".$levelLimit."]]></LevelLimit>";
		$requestXmlBody .= '</GetStoreRequest>';
		//echo $requestXmlBody;exit;
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		//Send the Request
		$response = curl_exec($connection);
		
		//$rawAttributeXml 	= preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		
		$response = str_replace("Name","name",$response);
		$response = str_replace("CategoryID","id",$response);
		$response = str_replace("ChildCategory","childrens",$response);
		
		$xmlToArray = simplexml_load_string($response); 
		
		$responseArray = array();

		try
        {    
           if($xmlToArray->Ack == "Success")
           {
			   if(isset($xmlToArray->Store->CustomCategories)){
					//print_r($xmlToArray->Store->CustomCategories);
					
					/*//Below is the code to change the xml tag names
					// Load XML from file data.xml
					$xml = $response;//file_get_contents('data.xml');
					$xml = renameTags($xml, 'Name', 'name');
					$xml = renameTags($xml, 'CategoryID', 'id');
					$xml = renameTags($xml, 'ChildCategory', 'childrens');
					$newXMLString = simplexml_load_string($xml); 
					echo '<pre>';
					print_r($xmlToArray->Store->CustomCategories);exit;*/
					
					 $responseArray['statuscode'] = 0;
					 $responseArray['statusmessage'] = 'Success';
					 $responseArray['customCategories'] = $xmlToArray->Store->CustomCategories;
			   }else{
					$responseArray['statuscode'] = 404;
					$responseArray['statusmessage'] = 'Custom Categories tag missing';
			   }
		   } else
           {
			   $responseArray['statuscode'] = 404;
			   $responseArray['statusmessage'] = $xmlToArray->Errors->LongMessage;
           }
         
       }
       catch (Exception $ex)
       {
            $responseArray['statuscode'] = 404;
		    $responseArray['statusmessage'] = "Something went wrong!!!";
       }

		//close the connection
		curl_close($connection);
		
		//return the response
		//return $responseArray;
		echo json_encode(array($responseArray));
	}
	
	
	//START- SCAN PACK AND SHIP
	
	function printPickupSheet($dataArray)
	{
		  $xml = new SimpleXMLExtended('<requesttoprintpickupsheet/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($dataArray['usertoken']));
		  $xml->usercode = NULL;
		  $xml->usercode = $dataArray["usercode"];
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $dataArray["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");	

		  if(count($dataArray['selSKUArray'])>0){
				$xml->printall = NULL;
				$xml->printall = 'false';		
		  }else{
				$xml->printall = NULL;
				$xml->printall = 'true';		
		  }
		  
		  $printSpecific = $xml->addChild("printspecific");
		  foreach($dataArray['selSKUArray'] as $skuVal)
		  {
				$products = $printSpecific->addChild("products");
				$products->addChild("sku", $skuVal);
		  }
		  
		  $xml->pickupsheetprofileid = NULL;
		  $xml->pickupsheetprofileid= $dataArray['selPickupsheetProfileID'];
		  $dataArray['selShippingOption'] = 0;
		  $dataArray['selWorkflowOption'] = 0;
		  $dataArray['selCountryOption'] = 0;
		  $dataArray['selMarketplaceOption'] = 0;
		  $filtrate = $xml->addChild("filtrate");
		  $filtrate->addChild("shippingservicecode", $dataArray['selShippingOption']);
		  $filtrate->addChild("workflowcode",  $dataArray['selWorkflowOption']);
		  $filtrate->addChild("countrycode",  $dataArray['selCountryOption']);
		  $filtrate->addChild("marketplacecode",  $dataArray['selMarketplaceOption']);
		  $filtrate->addChild("accountcode",0);
		  
		  $requestXml = $xml->saveXML();
	  
	   //Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
		$headers = array( 
          		 "Content-type: text/xml;charset=\"utf-8\"", 
           		 "Accept: text/xml"
       		); 
				 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Pickupsheet/PrintPickupSheet");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
			
		$responseArray = json_decode($result,true);

		if(isset($responseArray['filepath']) && $responseArray['filepath']!="")	{
			$imageData = base64_encode(file_get_contents($responseArray['filepath']));
			$mime_type = 'application/pdf';
			$responseArray['pickupsheetFilePath'] = 'data: '.$mime_type.';base64,'.$imageData;
		}
		//return $responseArray;	
		echo json_encode(array('data'=>$responseArray));
	}

	function previewPickupSheet($dataArray)
	{
		  $xml = new SimpleXMLExtended('<requesttopreviewpickupsheet/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($dataArray['usertoken']));
		  $xml->usercode = NULL;
		  $xml->usercode = $dataArray["usercode"];
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $dataArray["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");		
		  $xml->printall = NULL;
		  $xml->printall = 'true';		
		  
		  $printSpecific = $xml->addChild("printspecific");
		  foreach($dataArray['selSKUArray'] as $skuVal)
		  {
				$products = $printSpecific->addChild("products");
				$products->addChild("sku", $skuVal);
		  }
		  
		  $xml->pickupsheetprofileid = NULL;
		  $xml->pickupsheetprofileid= $dataArray['selPickupsheetProfileID'];
		  $dataArray['selShippingOption'] = 0;
		  $dataArray['selWorkflowOption'] = 0;
		  $dataArray['selCountryOption'] = 0;
		  $dataArray['selMarketplaceOption'] = 0;
		  $filtrate = $xml->addChild("filtrate");
		  $filtrate->addChild("shippingservicecode", $dataArray['selShippingOption']);
		  $filtrate->addChild("workflowcode",  $dataArray['selWorkflowOption']);
		  $filtrate->addChild("countrycode",  $dataArray['selCountryOption']);
		  $filtrate->addChild("marketplacecode",  $dataArray['selMarketplaceOption']);
		  $filtrate->addChild("accountcode",0);
		  
		  $requestXml = $xml->saveXML();
		  
		   //Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
					 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Pickupsheet/PreviewPickupSheet");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			
			//return $responseArray = json_decode($result,true);
			echo json_encode(array('data'=>$responseArray));
	}

	function printDocumentsOneByOne($dataArray)
	{
		  $xml = new SimpleXMLExtended('<requesttoprintdocumentsonebyone/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($dataArray['usertoken']));
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $dataArray["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");		
		  $xml->orderid = NULL;
		  $xml->orderid->addCData($dataArray['orderid']);
		  $xml->accountid = NULL;
		  $xml->accountid->addCData($dataArray['accountcode']);
		  $xml->workflowid = NULL;
		  $xml->workflowid->addCData($dataArray['workflowid']);

			  $products = $xml->addChild("products");
			  //print_r($dataArray['skuShipnowArray']);
			  foreach($dataArray['skuShipnowArray'] as $skuShipnowVals)
			  {
					$product = $products->addChild("product");	
					$product->addChild("sku", $skuShipnowVals['sku']);
					$product->addChild("qtydispatching", $skuShipnowVals['shippingnow']);
			  }
		  $xml->ipaddress = NULL;
		  $xml->ipaddress = get_client_ip_utils(); 
		  $xml->orderaction = NULL;
		  $xml->orderaction = 1;
		  $xml->couriercode = NULL;
		  $xml->couriercode = $dataArray['selectedCourier'];
		  $xml->courierservicecode = NULL;
		  $xml->courierservicecode = $dataArray['selectedServices'];
		  $xml->courierservicename = NULL;
		  $xml->courierservicename = $dataArray['courierservicename'];	  
		  $xml->numberoflabels = NULL;
		  $xml->numberoflabels = $dataArray['numberoflabels'];		  
		  $xml->invoicetype = NULL;
		  $xml->invoicetype = $dataArray['invoicetype'];
				
		  $requestXml = $xml->saveXML();
		
			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Documents/PrintDocument");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			
			$responseArray = json_decode($result,true);
			$responseArray['dateTimeFormat'] =  '';
			$responseArray['invoiceChangedURL'] = '';
				if(isset($responseArray['invoicefilepath'])){
					$imageData = base64_encode(file_get_contents($responseArray['invoicefilepath']));
					$mime_type = 'application/pdf';
					$responseArray['invoiceChangedURL'] = 'data: '.$mime_type.';base64,'.$imageData;
				}	
				
				//echo "<pre>";
				$labelFilePath = array();
				if(isset($responseArray['label']['labelfiles'])  && count($responseArray['label']['labelfiles'])>=1){
						foreach($responseArray['label']['labelfiles'] as $labelInfo){
							$imageData = base64_encode(file_get_contents($labelInfo['labelfilepath']));
							$mime_type = 'application/pdf';
							$labelFilePath[] = 'data: '.$mime_type.';base64,'.$imageData;
						}
				}
			 $responseArray['labelFilePathsArray'] = $labelFilePath;
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));
	}

	function printDocumentsBulk($dataArray)
	{	
		  $xml = new SimpleXMLExtended('<scheduleprintprocessrequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(isset($dataArray['usertoken']) ? stripslashes($dataArray['usertoken']): NULL);
		  $xml->dbcode = NULL; 
		  $xml->dbcode = isset($dataArray["dbcode"]) ? $dataArray["dbcode"] :NULL;
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");	
		  $xml->orderaction = NULL;
		  $xml->orderaction = 1;
		  $xml->uniquereference = NULL;
		  $xml->uniquereference->addCData(isset($dataArray['uniquereference']) ? $dataArray['uniquereference'] :NULL);
		  $xml->couriercode = NULL;
		  $xml->couriercode = isset($dataArray['selectedCourier']) ? $dataArray['selectedCourier'] : NULL ;
		  $xml->courierservicecode = NULL;
		  $xml->courierservicecode = isset($dataArray['selectedServices']) ? $dataArray['selectedServices'] : NULL;
		  $xml->courierservicename = NULL;
		  $xml->courierservicename = isset($dataArray['courierservicename']) ? $dataArray['courierservicename'] : NULL;
		  $xml->numberoflabels = NULL;
		  $xml->numberoflabels =isset($dataArray['numberoflabels']) ? $dataArray['numberoflabels'] : NULL;
		  
		  $filtrate = $xml->addChild("filtrate");

		  $topfilter = $filtrate->addChild("topfilter");
				$topfilter->shippingservicecode = NULL;
				$topfilter->shippingservicecode->addCData(isset($dataArray['shippingservicecode']) ? $dataArray['shippingservicecode']: NULL);
				$topfilter->accountcode = NULL;
				$topfilter->accountcode = isset($dataArray['accountcode']) ? $dataArray['accountcode'] :NULL;
				$topfilter->shippingcountrycode = NULL;
				$topfilter->shippingcountrycode->addCData(isset($dataArray['shippingcountrycode'])? $dataArray['shippingcountrycode'] :NULL);	

		  $orders = $filtrate->addChild("orders");
				$orders->singleitem = NULL;
				$orders->singleitem->addCData("");
				$orders->multipleitems = NULL;
				$orders->multipleitems->addCData("");	
				$orders->all = NULL;
				$orders->all->addCData("");	
				
			$orderNumbers = $filtrate->addChild("ordernumbers");

			foreach($dataArray['skuArray'] as $skuShipnowVals)
			  {
					$orderNumber = $orderNumbers->addChild("ordernumber");
					$orderNumber->addChild("orderno", $skuShipnowVals['orderid']);
					$orderNumber->addChild("accountid", $skuShipnowVals['accountcode']);
			  }
				
				$xml->invoicetype = NULL;
				$xml->invoicetype = $dataArray['invoicetype'];
				$xml->packagingtype = $dataArray['packagingtype'];
			    // $xml->royalmailservicetype = $dataArray['royalmailservicetype'];
		  
			$requestXml = $xml->saveXML();
		 
			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Documents/SchedulePrintProcess");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			
			$responseArray = json_decode($result,true);
		
			$returnVal = 0;
			if($responseArray['statuscode']==0 && $responseArray['processcode']!=""){
				$processcodeArr = array();
				$processcodeArr['processcode'] = $responseArray['processcode'];
				$processcodeArr['usertoken'] = $dataArray['usertoken'];
				$processcodeArr['dbcode'] = $dataArray['dbcode'];
				$returnVal = getPrintProcessStatus($processcodeArr);
			}
			
			if($returnVal == 'success')
			{	
				$processcodeArr = array();
				$processcodeArr['processcode'] = $responseArray['processcode'];
				$processcodeArr['usertoken'] = $dataArray['usertoken'];
				$processcodeArr['dbcode'] = $dataArray['dbcode'];
				$processcodeArr['usercode'] = $dataArray['usercode'];
				$finalResult = getPrintProcessedFileUrls($processcodeArr);
				echo json_encode(array('data'=>$finalResult));
				return $finalResult;
				exit;
			}else{
				return '';exit;	
			}
			
	}

	function getPrintProcessStatus($processcode)
	{
		$resultArray = array();
		do{
		  $xml = new SimpleXMLExtended('<getprintprocessstatusrequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($processcode['usertoken']));
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $processcode["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");		
		  $xml->processcode = NULL;
		  $xml->processcode->addCData($processcode['processcode']);
	  
		  $requestXml = $xml->saveXML();
		 
		 //Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Documents/GetPrintProcessStatus");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$resultArray = json_decode($result,true);
			//$resultArray['processstatus'] = 1;
				sleep(1);
			}while($resultArray['processstatus'] < 1);
			//echo "<br/><br/>-->".$resultArray['statuscode'];
				if(isset($resultArray['statuscode']) && $resultArray['statuscode']=='-1' && $resultArray['processstatus']==1)
				{
					//echo "COMING INTO LOOP";
					//print_r($resultArray);
						 $processcodeArr = array();
						 $processcodeArr['statuscode'] = $resultArray['statuscode'];
						 $processcodeArr['statusmessage'] = $resultArray['statusmessage'];
						 echo json_encode(array('data'=>$processcodeArr));
						//return $resultArray;
						 exit;
				}else 
					return 'success';	
	}

	function getPrintProcessedFileUrls($processcode)
	{
		  $xml = new SimpleXMLExtended('<getprintprocessedfilesrequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($processcode['usertoken']));
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $processcode["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");		
		  $xml->processcode = NULL;
		  $xml->processcode->addCData($processcode['processcode']);
	  
		  $requestXml = $xml->saveXML();
		 
			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Documents/GetPrintProcessedFiles");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$resultArray = json_decode($result,true);
			
			
			if(APIURL=="winserver2012") $wwwRoot = "http://localhost/247commerce";  // for localhost
			else $wwwRoot = "http://www.247cloudhub.co.uk:8082";
		    // $wwwRoot = "https://www.247cloudhub.co.uk:444";
			//"http://service.247commerce.com:8081"; // for server
			//$wwwRoot = "http://localhost/247commerce";
			
			
			$invlblFilePath = array();
			$j=0;
			$pdf = new PDFMerger;
			$commonFolder = $_SERVER["DOCUMENT_ROOT"]."/php/scanandship/"."mergepdfs";
			if(!file_exists($commonFolder)){
				mkdir($commonFolder); //Creating main folder if it is not existing
			}
						
			$mainFolder = $commonFolder."/".$processcode["usercode"]."_".$processcode["dbcode"];
			//mkdir($mainFolder);//Main folder for that user
			$invoiceCnt = 0;
			$invFileStr = "";
			$invoiceMergePdfFileName = "";
			if(isset($resultArray['invoicefiles']) && count($resultArray['invoicefiles'])>=1){
				foreach($resultArray['invoicefiles'] as $invoiceInfo){
					$j++;
						$file="";
						$file= $invoiceInfo['invoicefilepath'];
						$fileName = "invoice".$j.".pdf";
						$invoiceFolderName = $mainFolder."/invoicepdfs";
						if(file_exists($mainFolder)){
							//mkdir($invoiceFolderName); //folder for invoices
						}else{ 
							mkdir($mainFolder); //Creating main folder if it is not existing
							//mkdir($invoiceFolderName); //folder for invoices
						}
						if(file_exists($invoiceFolderName))
						{
							file_put_contents($invoiceFolderName."/".$fileName, fopen($file, 'r'));
							$varFileName = '';
							$varFileName = $invoiceFolderName."/".$fileName;
							$pdf->addPDF($varFileName, 'all');
						}
						else{
							mkdir($invoiceFolderName);
							file_put_contents($invoiceFolderName."/".$fileName, fopen($file, 'r'));
							$varFileName = '';
							$varFileName = $invoiceFolderName."/".$fileName;
							$pdf->addPDF($varFileName, 'all');
						}
				}
				$invoiceCnt = $j;
				$invoiceMergePdfFileName = "invoiceMergePdf".date('ymdHis').".pdf";
				$pdf->merge('file', $invoiceFolderName."/".$invoiceMergePdfFileName);
				$invoiceFolderName."/".$invoiceMergePdfFileName;
				$resultArray['invoiceMergePdf'] = $wwwRoot."/php/scanandship/".str_replace($_SERVER["DOCUMENT_ROOT"]."/php/scanandship/", '',$invoiceFolderName)."/".$invoiceMergePdfFileName;
			}	
			
			
			// $resultArray['invoiceFilePathsArray'] = $inoviceFilePath;
			
			$pdf = new PDFMerger;
			 $i=0;
			 $labelCnt = 0;
			 $lblFileStr = "";
			 $labelMergePdfFileName = "";
			 if(isset($resultArray['labelfiles']) && count($resultArray['labelfiles'])>=1){
				foreach($resultArray['labelfiles'] as $labelInfo){
					$i++;
						/*$labelImgData = base64_encode(file_get_contents($labelInfo['labelfilepath']));
						$mime_type = 'application/pdf';
						$invlblFilePath[$i]['labelEncodedURL'] = 'data: '.$mime_type.';base64,'.$labelImgData;
						$invlblFilePath[$i]['labelOriginalURL'] = $labelInfo['labelfilepath'];*/
						
						$file="";
						$file= $labelInfo['labelfilepath'];
						$fileName = "label".$i.".pdf";
						$labelFolderName = $mainFolder."/labelpdfs";
						if(file_exists($mainFolder)){
							//mkdir($labelFolderName); //folder for invoices
						}else{ 
							mkdir($mainFolder); //Creating main folder if it is not existing
							//mkdir($labelFolderName); //folder for invoices
						}
						$explode_pdfss = explode("/",$file);
						$filenames = $explode_pdfss[count($explode_pdfss)-1];
						$explode_extension = explode(".",$filenames);
						
						if(file_exists($labelFolderName)){
							if(strtolower($explode_extension[1]) == 'png'){
								$pdfs = new FPDF('P','mm',array(101.6,152.4));
								$pdfs->AddPage();
								$pdfs->Image($file,0,10,90,140);
								$pdfs->Output($labelFolderName."/".$fileName,'F');
							}else{
								file_put_contents($labelFolderName."/".$fileName, fopen($file, 'r'));
							}
							$varFileName= '';
							$varFileName = $labelFolderName."/".$fileName;
							$pdf->addPDF($varFileName, 'all');
						}
						else{
							mkdir($labelFolderName);
							if(strtolower($explode_extension[1]) == 'png'){
								$pdfl = new FPDF('P','mm',array(101.6,152.4));
								$pdfl->AddPage();
								$pdfl->Image($file,0,10,90,140);
								$pdfl->Output($labelFolderName."/".$fileName,'F');
							}else{
								file_put_contents($labelFolderName."/".$fileName, fopen($file, 'r'));
							}
							$varFileName = '';
							$varFileName = $labelFolderName."/".$fileName;
							$pdf->addPDF($varFileName, 'all');
						}
				}
				$labelCnt = $i;
				$labelMergePdfFileName = "labelMergePdf".date('ymdHis').".pdf";		 
				$pdf->merge('file', $labelFolderName."/".$labelMergePdfFileName);
				$resultArray['labelMergePdf'] = $wwwRoot."/php/scanandship/".str_replace($_SERVER["DOCUMENT_ROOT"]."/php/scanandship/", '',$labelFolderName)."/".$labelMergePdfFileName;
			 }
			 
			 

			$resultArray['invoiceLabelUrlsArray'] = $invlblFilePath;
			 
			// echo "<pre>";
			// print_r($resultArray);exit;
			return $resultArray;
			//echo json_encode(array('data'=>$resultArray));
	}

	//function generatePickSheetOrders($pageNumber,$pageCount)
	function generatePickSheetOrders($dataArray)
	{
	//echo "<pre>";
	//print_r($dataArray);
	/*	$shippingservicecode = 0;
		$workflowcode = 0;
		$marketplacecode = 0;
		$accountcode = 0;*/
		  $ordertype = ($dataArray['ordertype']>0)?$dataArray['ordertype'] : 0;//1-Single, 2-Multiple, 0-All  
		  $shippingservicecode = ($dataArray['shippingservicecode']=="")? 0 : $dataArray['shippingservicecode'];
		  $workflowcode = ($dataArray['workflowcode']=="")? 0 : $dataArray['workflowcode'];
		  $marketplacecode = ($dataArray['marketplacecode']=="")? 0 : $dataArray['marketplacecode'];
		  $accountcode = (!isset($dataArray['accountcode']) || $dataArray['accountcode']=="")? 0 : $dataArray['accountcode'];
		  $countrycode = ($dataArray['countrycode']=="")? 0 : $dataArray['countrycode'];
			
		  $xml = new SimpleXMLExtended('<getordersforpickupsheetrequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($dataArray['usertoken']));
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $dataArray["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");	
		  $xml->usercode = NULL;
		  $xml->usercode = $dataArray["usercode"];
		  $xml->pagenumber = NULL; 
		  $xml->pagenumber = $dataArray['pageNumber'];
		  $xml->numberofrecords = NULL;
		  $xml->numberofrecords = $dataArray['pageCount'];
		  $xml->shippingservicecode = NULL;
		  $xml->shippingservicecode = $shippingservicecode;
		  $xml->workflowcode = NULL;
		  $xml->workflowcode = $workflowcode;
		  $xml->marketplacecode = NULL;
		  $xml->marketplacecode = $marketplacecode;
		  $xml->accountcode = NULL;
		  $xml->accountcode = $accountcode;  
		  $xml->countrycode = NULL;
		  $xml->countrycode = $countrycode; 
		  $xml->ordertype = NULL;
		  $xml->ordertype = $ordertype; //1-Single, 2-Multiple, 0-All 	
		  
		  $requestXml = $xml->saveXML();
		
			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
					 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/Pickupsheet/GetOrdersforPickupsheet");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			//echo "<pre>";

			$responseArray = json_decode($result,true);
			$responseArray['dateTimeFormat'] =  '';
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));
	}

	function getSingleOrderDetails($dataArray)
	{
		  $xml = new SimpleXMLExtended('<getsingleorderrequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(isset($dataArray['usertoken'])? stripslashes($dataArray['usertoken']):NULL);
		  $xml->dbcode = NULL; 
		  $xml->dbcode = isset($dataArray["dbcode"]) ? $dataArray["dbcode"]:NULL;
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");	
		  $xml->usercode = NULL;
		  $xml->usercode = isset($dataArray["usercode"])?$dataArray["usercode"]:NULL;
		  $xml->marketplacecode = NULL;
		  $xml->marketplacecode->addCData(isset($dataArray['marketplacecode'])? $dataArray['marketplacecode']:NULL);
		  $xml->accountcode = NULL;
		  $xml->accountcode->addCData(isset($dataArray['accountcode'])?$dataArray['accountcode']:NULL);
		  $xml->orderid = NULL;
		  $xml->orderid->addCData(isset($dataArray['orderid'])? $dataArray['orderid'] :NULL);
		
		  $requestXml = $xml->saveXML();
		
			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
					 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/orderapi/api/OrderAPI/GetSingleOrder");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$responseArray = json_decode($result,true);

			//Below code is to do the VAT calculations.
			/*$i=0;
			$vatPer = 0.20; //Venkat asked me to give vat percentage as 20%(20/100) on 19/03/2015
			$totalVat = 0;
			$modifiedSubtotal = 0;
			foreach($responseArray['orders'][0]['orderitems'] as $orderInfo)
			{
				$vatCalc = ($orderInfo['unitprice']*$vatPer);
				$totalVat +=($vatCalc*$orderInfo['quantity']); 
				$modifiedUnitPrice = ($orderInfo['unitprice']-$vatCalc);
				$responseArray['orders'][0]['orderitems'][$i]['modifiedUnitPrice'] = number_format(round($modifiedUnitPrice, 2), 2, '.','');
				$modifiedSubtotal += number_format(round(($modifiedUnitPrice*$orderInfo['quantity']),2), 2,'.','');
				$responseArray['orders'][0]['orderitems'][$i]['modifiedTotalPrice'] = number_format(round(($modifiedUnitPrice*$orderInfo['quantity']),2), 2,'.','');
				$i++;
			}
			
			$responseArray['orders'][0]['modifiedTotalVat'] = number_format(round($totalVat, 2), 2, '.', '');
			$responseArray['orders'][0]['modifiedSubtotal'] = number_format(round($modifiedSubtotal, 2), 2, '.', '');
			$responseArray['orders'][0]['modifiedTotalPrice'] = ($responseArray['orders'][0]['modifiedTotalVat']+$responseArray['orders'][0]['modifiedSubtotal']);
			*/
			/* The above code for VAT calc. Commented by murali as per susant suggestion - 24-04-2015 */
			$i=0;
			$modifiedSubtotal = 0;
			$grandTotal = 0;
			$shippingTotal = 0;
			if(isset($responseArray['statuscode']) && $responseArray['statuscode']==0)  
			{
				foreach($responseArray['orders'][0]['orderitems'] as $orderInfo)
				{
					$grandTotal += ($orderInfo['unitprice']*$orderInfo['quantity'])+$orderInfo['shippingprice'];
					$shippingTotal += $orderInfo['shippingprice'];
					$responseArray['orders'][0]['orderitems'][$i]['modifiedUnitPrice'] = number_format(round($orderInfo['unitprice'], 2), 2, '.','');
					$responseArray['orders'][0]['orderitems'][$i]['modifiedTotalPrice'] = number_format(round(((($orderInfo['unitprice']*$orderInfo['quantity'])+$orderInfo['shippingprice'])),2), 2,'.','');
					$i++;
				}
				
				$responseArray['orders'][0]['modifiedTotalVat'] = '';
				$responseArray['orders'][0]['modifiedSubtotal'] = '';
				$responseArray['orders'][0]['shippingTotalPrice'] = (number_format(round(($shippingTotal),2), 2,'.',''));
				$responseArray['orders'][0]['modifiedTotalPrice'] = (number_format(round(($grandTotal),2), 2,'.',''));
				$responseArray['dateTimeFormat'] =  '';
			}
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));

	}
				
	function changeOrderStage($usertoken, $dbcode, $usercode, $sCode,$orderNumber,$accCode)
	{
		  /*$xml = new SimpleXMLExtended('<changeorderstagerequest/>');
		  $xml->usertoken = NULL;
		  $xml->usertoken->addCData(stripslashes($_SESSION['usertoken']));
		  $xml->dbcode = NULL; 
		  $xml->dbcode = $_SESSION["dbcode"];
		  $xml->responsetype = NULL;
		  $xml->responsetype->addCData("json");	
		  $xml->ordernumber = NULL;
		  $xml->ordernumber->addCData($orderNumber);
		  $xml->accountcode = NULL;
		  $xml->accountcode = $accCode;
		  $xml->orderstagecode = NULL;
		  $xml->orderstagecode = $sCode;
		  $xml->usercode = NULL;
		  $xml->usercode = $_SESSION["usercode"];
		  $xml->ipaddress = NULL;
		  $xml->ipaddress->addCData(get_client_ip_utils());
		  $requestXml = $xml->saveXML();

			//Below headers to accept the reponse in xml format. If xml format is not required we can remove these headers.
			$headers = array( 
					 "Content-type: text/xml;charset=\"utf-8\"", 
					 "Accept: text/xml"
				); 
					 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".DELIVERYAPIURL."/PrintConsoleAPI/api/OrderStage/ChangeOrderStage");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$responseArray = json_decode($result,true);	*/
			return true;

			//return $responseArray;
	}

	
	function uploadXMLToFTP($requestData)
	{
		$dbconnection = getdbconnection();
		$selSql = "SELECT max(trackID) as curTrackID FROM createorderstrack";
		$selQuery = $dbconnection->query($selSql);
		$row = $selQuery->fetch_assoc();
		$curTrackID = $row['curTrackID'];
		$nextTrackID = ($curTrackID+1);
		$dateforxml = date("Y-m-d");
		$returnArray  = '';
		
		$ordersinfo = (isset($requestData['ordersInfo']) && $requestData['ordersInfo']!=='')? $requestData['ordersInfo'] : '';
		$xmlData = '';
		$xmlData .= '<Order><ShopId>WARB</ShopId><OrderNumber>'. $nextTrackID .'</OrderNumber><OrderDate>'. $dateforxml .'</OrderDate>';
		$xmlData .= '<Currency>GBP</Currency><Customer LastUpdated="'.$dateforxml.'"><Name1 /><Name2 />';
		$xmlData .= '<BillToAddress><Name /><Street /><Block /><ZipCode /><City /><State /><Country /></BillToAddress>';
		$xmlData .= '<ShipToAddress><Name>Warby 4 Software and Gifts</Name><Street>10 Montgomeri Drive</Street>';
		$xmlData .= '<Block>West Sussex </Block><ZipCode>BN16 3TY</ZipCode><City>Rustington</City>';
		$xmlData .= '<State /><Country>GB</Country></ShipToAddress>';
		$xmlData .= '<Phone1 /><Email /><UserFields><WebKundeNummer /><TdcPid /><Cpr /><YearSalary /></UserFields></Customer>';
		$xmlData .= '<OrderLines>'.$ordersinfo.'</OrderLines>';
		$xmlData .= '<ShipmentType>PD</ShipmentType><Comments>---</Comments><UserFields><BetalingsTransaktionId />';
		$xmlData .= '<BetalingsType /><BetalingsKort /><ClientIP /></UserFields></Order>';
		
		
		$doc = new DOMDocument();
		$doc->loadXML($xmlData);
		//echo $doc->saveXML(); exit;
		$doc->saveXML();
		//$fileName = "WARB_".date("Y_m_d_h_i")."_Order".$nextTrackID.".xml";
		$fileName = $nextTrackID.".xml";
		$doc->save(__DIR__."/".$fileName) or die("Error");

		$server = "77.243.48.79";
		$ftp_user_name = "warburton";
		$ftp_user_pass = "GotJavouk7";
		$src_file = __DIR__."/".$fileName;
		
		$dest_file = "Orders/".$fileName;
		$mode = "FTP_ASCII";

		// set up basic connection
		$connection = ftp_connect($server);

		// login with username and password
		$login = ftp_login($connection, $ftp_user_name, $ftp_user_pass);

		if (!$connection || !$login) { die('Connection attempt failed!'); }

		// turn passive mode on
		ftp_pasv($connection, true);

		// upload a file
		if (ftp_put($connection, $dest_file, $src_file, FTP_ASCII)) {
			// echo "successfully uploaded $src_file\n";
			$returnArray['statuscode'] = 0;
			//$returnArray['statusmessage'] = "successfully uploaded $src_file";
			$returnArray['statusmessage'] = "successfully uploaded $fileName";
			
			 //Insert only after successfully uploading the file.
 			 $curDateTime = date("Y-m-d H:i:s");
  			 $insertsql = "INSERT INTO createorderstrack (fileName,	createDateTime) VALUES ('".$fileName."','".$curDateTime."')";
			 $dbconnection->query($insertsql);
			// try to chmod $file to 644
			if (ftp_chmod($connection, 0777, $dest_file) !== false) {
			// echo "$dest_file chmoded successfully to 644\n";
			} else {
			// echo "could not chmod $dest_file\n";
			}

			if(isset($src_file)){
				unlink($src_file);
			}
			
			 
			 //If file successfully upload, then change the order stage
			 foreach($requestData['ftpOrderDetails'] as $orderdetails)
			 {
				changeOrderStage($requestData['usertoken'], $requestData['dbcode'], $requestData['usercode'], 17, $orderdetails['orderNumber'],$orderdetails['accountID']); //17 - Sent file to FTP
		   	 }
	  
		} else {
			// echo "There was a problem while uploading $src_file\n";
			$returnArray['statuscode'] = 404;
			$returnArray['statusmessage'] = "There was a problem while uploading $src_file";
		}
		// close the connection
		ftp_close($connection);
		$dbconnection->close();
		//return $returnArray;
		echo json_encode(array('data'=>$returnArray));
	}

	//END - SCAN PACK SHIP

	function getReportsTableData($dataArray)
	{
		$data='';
		$posts = array();
		$dbconnection = getdbconnection();
		$finalsql = "SELECT * FROM reportstable WHERE fkdbcode='".$dataArray['dbcode']."' LIMIT 1";
		//$finalsql = "SELECT * FROM reportstable";
		$finalresult = $dbconnection->query($finalsql);
		if(mysqli_num_rows($finalresult)>0)
		{ 
			/*while($post = mysqli_fetch_assoc($finalresult)) 
			{
				$posts[] = array('post'=>$post);
			}*/
			$data = $finalresult->fetch_assoc();
		}
		$dbconnection->close();
		echo json_encode($data);
	}
	
	//START - Marketplaces
	
	//START - eBay Marketplace
	function getExistingEbaySessData()
	{
		$respArray = array();
		
		if(isset($_SESSION['ebayAccName']) && $_SESSION['ebayAccName']!=""){
			$respArray['statuscode'] = 0;
			$respArray['ebayAccName'] = (isset($_SESSION['ebayAccName']) && $_SESSION['ebayAccName']!="") ? $_SESSION['ebayAccName']: "";
			$respArray['ebaySelCountry'] = (isset($_SESSION['ebaySelCountry']) && $_SESSION['ebaySelCountry']!="") ? $_SESSION['ebaySelCountry']: "";
		}
		//return $respArray;
		echo json_encode(array('data'=>$respArray));
	}
	
	function getEbaySessID()
	{ 
			/* Below code to get the sessionID*/
			$verb1 = 'GetSessionID';
		  	global  $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $runame; // defined in keys.php
			
			///Build the request Xml string
			$requestBody1 = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestBody1 .= '<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestBody1 .= "<Version>$compatabilityLevel</Version>";
			$requestBody1 .= "<RuName>$runame</RuName>";
			$requestBody1 .= '</GetSessionIDRequest>';
		
			//Create a new eBay session with all details pulled in from included keys.php
			$sessN = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb1);
			//send the request and get response
			$responseBody1 = $sessN->sendHttpRequest($requestBody1);
			$respArray = array();
			if(stristr($responseBody1, 'HTTP 404') || $responseBody1 == ''){
				$respArray['statuscode'] = '404';
				$respArray['statusmessage'] = 'Error sending request';
				//return $respArray;
				echo json_encode(array('data'=>$respArray));
			}
		
				$resp1 = simplexml_load_string($responseBody1);
			//print_r($resp1);exit;
				if((string)$resp1->Ack == "Success")
				{
					$_SESSION['ebSession']  = (string)$resp1->SessionID;
					$respArray['statuscode'] = '0';
					$respArray['statusmessage'] = 'Success';
					$respArray['ebSession'] = (string)$resp1->SessionID;
 					//return $respArray;
					echo json_encode(array('data'=>$respArray));
				}
				else
				{
					$respArray['statuscode'] = '404';
					$respArray['statusmessage'] = 'No sesssion ID. ACK FAILURE';
					//return $respArray;	
					echo json_encode(array('data'=>$respArray));
				}
	}
	
	function addEbayAccount($ebayDetails)
	{
		$removeeBayStoreName = explode("eBay - ", $ebayDetails['accountName']);
		if(count($removeeBayStoreName)>1)
			$accountName = $ebayDetails['accountName'];
		else 
			$accountName = "eBay - ".$ebayDetails['accountName'];
		
		if($ebayDetails['pkebayacctcode']>0){
				$xml = new SimpleXMLExtended('<udpateebayaccountsrequest/>'); //update condition
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($ebayDetails['usertoken']));
				$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
				$xml->dbcode = $ebayDetails['dbcode'];
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$xml->pkebayaccountcode = NULL;
				$xml->pkebayaccountcode->addCData($ebayDetails['pkebayacctcode']);
				$xml->ebayaccountcode = NULL;
				$xml->ebayaccountcode->addCData($ebayDetails['ebayaccountcode']);
				$xml->ebayaccountname = NULL;
				$xml->ebayaccountname->addCData($accountName);
				$xml->isorderdowload = NULL;
				$xml->isorderdowload = 1;
				$xml->countrycode = NULL;
				$xml->countrycode = $ebayDetails['selCountry'];
				$xml->livetoken = NULL;
				$xml->livetoken->addCData($ebayDetails['eBayAuthToken']);
				$xml->expirydate = NULL;
				$xml->expirydate->addCData($ebayDetails['expirationTime']);						
				$xml->ebayuserid = NULL;
				$xml->ebayuserid->addCData($ebayDetails['ebayUserID']);
				$xml->modifiedby = NULL;
				$xml->modifiedby = $ebayDetails['usercode'];
				$xml->isbestofferenabled = NULL;
				$xml->isbestofferenabled = $ebayDetails['isbestoffer'];
				$xml->isvatenabled = NULL;
				$xml->isvatenabled = $ebayDetails['isvat'];
				$xml->isbusinessseller = NULL;
				$xml->isbusinessseller = $ebayDetails['isbuss'];
				$xml->isrestrictedtobusiness = NULL;
				$xml->isrestrictedtobusiness = $ebayDetails['isrest'];
				$xml->vatpercent = NULL;
				$xml->vatpercent = $ebayDetails['vatper'];
				$xml->ischarityenabled = NULL;
				$xml->ischarityenabled = $ebayDetails['ischart'];
				$xml->charityid = NULL;
				$xml->charityid = $ebayDetails['chartID'];
				$xml->charitynumber = NULL;
				$xml->charitynumber = $ebayDetails['chartName'];
				$xml->donationpercent = NULL;
				$xml->donationpercent = $ebayDetails['chartPer'];
				
				$requestXml = $xml->saveXML();
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/eBayAPI/api/eBayAccounts/UpdateeBayAccounts");
			
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				
		}else{
				$xml = new SimpleXMLExtended('<addebayaccountsrequest/>'); //update condition
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($ebayDetails['usertoken']));
				$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
				$xml->dbcode = $ebayDetails['dbcode'];
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$xml->ebayaccountcode = NULL;
				$xml->ebayaccountcode = 0;
				$xml->ebayaccountname = NULL;
				$xml->ebayaccountname->addCData($accountName);
				$xml->isorderdowload = NULL;
				$xml->isorderdowload = 1;
				$xml->countrycode = NULL;
				$xml->countrycode = $ebayDetails['selCountry'];
				$xml->livetoken = NULL;
				$xml->livetoken->addCData($ebayDetails['eBayAuthToken']);
				$xml->expirydate = NULL;
				$xml->expirydate->addCData($ebayDetails['expirationTime']);						
				$xml->ebayuserid = NULL;
				$xml->ebayuserid->addCData($ebayDetails['ebayUserID']);
				$xml->createdby = NULL;
				$xml->createdby = $ebayDetails['usercode'];
				$xml->isbestofferenabled = NULL;
				$xml->isbestofferenabled = $ebayDetails['isbestoffer'];
				$xml->isvatenabled = NULL;
				$xml->isvatenabled = $ebayDetails['isvat'];
				$xml->isbusinessseller = NULL;
				$xml->isbusinessseller = $ebayDetails['isbuss'];
				$xml->isrestrictedtobusiness = NULL;
				$xml->isrestrictedtobusiness = $ebayDetails['isrest'];
				$xml->vatpercent = NULL;
				$xml->vatpercent = $ebayDetails['vatper'];
				$xml->ischarityenabled = NULL;
				$xml->ischarityenabled = $ebayDetails['ischart'];
				$xml->charityid = NULL;
				$xml->charityid = $ebayDetails['chartID'];
				$xml->charitynumber = NULL;
				$xml->charitynumber = $ebayDetails['chartName'];
				$xml->donationpercent = NULL;
				$xml->donationpercent = $ebayDetails['chartPer'];
												
				$requestXml = $xml->saveXML();
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/eBayAPI/api/eBayAccounts/AddeBayAccounts");
			
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				
		}
				curl_close($ch);
				$respArray = json_decode($result,true);
				return $respArray;//exit;
	}
	
	
	function getEbayVerifyToken($ebay)
	{
		    $ebayDetails = array();
			$ebayDetails['selCountry'] = $ebay['selCountry'];
			$ebayDetails['accountName'] = $ebay['accountName'];
			$ebayDetails['ebayUserID'] = $ebay['userID'];
		  	$ebayDetails['eBayAuthToken'] = isset($ebay['eBayAuthToken'])? $ebay['eBayAuthToken']: '';
			$ebayDetails['expirationTime'] = isset($ebay['HardExpirationTime'])? $ebay['HardExpirationTime'] : '';
			$ebayDetails['pkebayacctcode'] = $ebay['pkebayacctcode']; 
			$ebayDetails['ebayaccountcode'] = $ebay['ebayaccountcode']; 

			$ebayDetails['isbestoffer'] = (isset($ebay['isbestoffer']) && $ebay['isbestoffer']==true)? 1 : 0;
			$ebayDetails['isvat'] = (isset($ebay['isvat']) && $ebay['isvat']==true)? 1 : 0;
			if($ebayDetails['isvat']==1)
			{
				$ebayDetails['vatper'] = (isset($ebay['vatper']))? $ebay['vatper'] : '';
				$ebayDetails['isbuss'] = (isset($ebay['isbuss']) && $ebay['isbuss']==true)? 1 : 0;
				$ebayDetails['isrest'] = (isset($ebay['isrest']) && $ebay['isrest']==true)? 1 : 0;	
			}else {
				//$ebayDetails['vatper'] = '';
				$ebayDetails['vatper'] = 0;
				$ebayDetails['isbuss'] = 0;
				$ebayDetails['isrest'] = 0;	
			}

			$ebayDetails['ischart'] = (isset($ebay['ischart']) && $ebay['ischart']==true)? 1 : 0;
			if($ebayDetails['ischart']==1)
			{
				$ebayDetails['chartID'] = (isset($ebay['chartID']))? $ebay['chartID'] : '';
				$ebayDetails['chartName'] = (isset($ebay['chartName']))? $ebay['chartName'] : '';
				$ebayDetails['chartPer'] = (isset($ebay['chartPer']))? $ebay['chartPer'] : '';

			}else {
				$ebayDetails['chartID'] = '';
				$ebayDetails['chartName'] = 0;
				// $ebayDetails['chartPer'] = '';	
				$ebayDetails['chartPer'] = 0;	
			}
			

			
			$ebayDetails['dbcode'] = $ebay['dbcode']; 
			$ebayDetails['usercode'] = $ebay['usercode']; 
			$ebayDetails['usertoken'] = $ebay['usertoken']; 
		
			$ebayAuthToken = isset($ebay['eBayAuthToken'])? $ebay['eBayAuthToken']: '';
			/* Below code is to get the Ebay Verification Token*/
			global  $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID; // defined in keys.php
			$verb = 'GetTokenStatus';
			///Build the request Xml string
			$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBody .= '<GetTokenStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$ebayAuthToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBody .= '</GetTokenStatusRequest>';
			//Create a new eBay session with all details pulled in from included keys.php
			$session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBody);
	
			if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
				die('<P>Error sending request');
	
			$resp = simplexml_load_string($responseXml);
	
			$respArray=array();
			if((string)$resp->Ack == "Success")
			{
				$addResult = addEbayAccount($ebayDetails);
				//return $addResult;exit;
				echo json_encode(array('data'=>$addResult));exit;
			}else{
				$respArray['statuscode'] = 404;
				$respArray['statusmessage'] = "Error sending request";
				//return $respArray;exit;	
				echo json_encode(array('data'=>$respArray));exit;
			}
	}
	
	
	function getEbayAuthToken($reqArray)
	{
		//print_r($reqArray);exit;
		if(isset($reqArray['ebaySession']) && $reqArray['ebaySession']!="")
		{
			    $ebayDetails = array();
				//$ebayDetails['selCountry'] = $ebay['selCountry'];
				//$ebayDetails['accountName'] = $ebay['accountName'];
												
				global $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID; // defined in keys.php
				$verb = 'FetchToken';
				$theID = $reqArray['ebaySession'];
				///Build the request Xml string
				$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
				$requestXmlBody .= '<FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			   // $requestXmlBody .= "<RequesterCredentials><Username>$username</Username></RequesterCredentials>";
				$requestXmlBody .= "<SessionID>$theID</SessionID><Version>$compatabilityLevel</Version>";
				$requestXmlBody .= '</FetchTokenRequest>';
				//Create a new eBay session with all details pulled in from included keys.php
				$session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				//send the request and get response
				$responseXml = $session->sendHttpRequest($requestXmlBody);
				$respArray = array();
				
				if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
				{
					 $respArray['statuscode'] = 404;
					 $respArray['statusmessage'] = "Error sending request";
					 //return $respArray;exit;		
					 echo json_encode(array('data'=>$respArray));exit;
				}
		
				$resp = simplexml_load_string($responseXml);
				//print_r($resp);exit;

				if((string)$resp->Ack == "Success" && strlen((string)$resp->eBayAuthToken) > 500)
				{
				   $ebayAuthToken = (string)$resp->eBayAuthToken;  // need to cast to string (not SimpleXML element) to persist in SESSION
				   $expirationTime = (string)$resp->HardExpirationTime;
				   $respArray['statuscode'] = 0;
				   $respArray['eBayAuthToken'] = $ebayAuthToken;
				   $_SESSION['eBayAuthToken'] = $ebayAuthToken;
				   $respArray['HardExpirationTime'] = $expirationTime;
				   $_SESSION['HardExpirationTime'] = $expirationTime;
				  
				   //return $respArray;exit;
				   echo json_encode(array('data'=>$respArray));exit;
				} else {
				   $respArray['statuscode'] = 404;
				   $respArray['statusmessage'] = "ERROR - We did not get a token";
				   //return $respArray;exit;
				   echo json_encode(array('data'=>$respArray));exit;
				}
		}else{
				   $respArray['statusmessage'] = "ERROR - eBay sessionid expired";
				   //return $respArray;exit;
				   echo json_encode(array('data'=>$respArray));exit;
		}
	}
	
	function isAuthTokenExpireTimeExists($reqArray)
	{
		$respArray = array();
		if(isset($reqArray['eBayAuthToken']) && $reqArray['eBayAuthToken'] !="" && isset($reqArray['HardExpirationTime']) && $reqArray['HardExpirationTime']!="")
		{
			 $respArray['statuscode'] = 0;
			 $respArray['statusmessage'] = "Success";
		}else{
			 $respArray['statuscode'] = 404;
			 $respArray['statusmessage'] = "Failure";
		}
		//return $respArray; exit;
		echo json_encode(array('data'=>$respArray));exit;
	}
	
	function registerebayNotification($accountCode)
	{
		$xml = new SimpleXMLExtended('<registerebaynotificationsrequest/>');
		$xml->dbcode = NULL; 
		$xml->dbcode = $accountCode['dbcode'];	
		$xml->accountcode = NULL;
		$xml->accountcode = $accountCode;
		$xml->notificationurl = NULL;
		$xml->notificationurl->addCData("http://ebaynotifications.247commerce.com/ReceiveeBayNotifications/api/ReceiveeBayNotifications/ReceiveeBayNotifications");
		$notifications = $xml->addChild("notifications");
		$notifications->notificationcode = NULL;
		$notifications->notificationcode->addCData("AuctionCheckoutComplete");
		$notifications->notificationcode->addCData("FixedPriceTransaction");
		$requestXml = $xml->saveXML();
		$ch = curl_init();								 
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/RegisteeBayNotifications/Api/SubscribeeBayNotifications/SubscribeeBayNotifications");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		
		$respArray = json_decode($result,true);
		//echo "<pre>";
		//print_r($respArray);exit;
		$respString = str_replace("<![CDATA[","",$respArray);
		$respString = str_replace("]]>","",$respString);
		$respXML = simplexml_load_string($respString); 
		
		$responseArray = array();
		//if(isset($respXML) && $respXML!=""){
				if($respXML->ack=="Success"){
					$responseArray['statuscode'] = 0;
					$responseArray['ack'] = $respXML->ack;
					$responseArray['timestamp'] = $respXML->timestamp;
				}else{
					$responseArray['statuscode'] = 404;
					$responseArray['ack'] = $respXML->ack;
					$responseArray['timestamp'] = $respXML->timestamp;
				}
		/*}else{
				$responseArray['statuscode'] = 400;
				$responseArray['ack'] = "Empty Result!!!";
		}*/
		
		//return $responseArray;
		echo json_encode(array('data'=>$responseArray));
	}
	//END - eBay Marketplace
	
	//START - Amazon Marketplace
	function getSelAmazonCountry($countryCode)
	{
		$xml  = new SimpleXMLExtended('<getamzcountriesrequest/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(stripslashes($countryCode['usertoken']));
		$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
		$xml->dbcode =  $countryCode['dbcode'];
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->countrycode = NULL;
		$xml->countrycode = $countryCode['code'];
			
		$requestXml = $xml->saveXML();
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/AmazonApi/api/AmazonCountries/GetAmazonCountry");
	
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$responseArray = json_decode($result,true);
		return $responseArray;
	}
		
	function verifyMWSAccountStatus($amazon)
	{
		$failureMsgArray =  array();
		$removeAmzStoreName = explode("Amazon - ", $amazon['storeName']);
		
		if(count($removeAmzStoreName)>1)
			$storeName = $amazon['storeName'];
		else 
			$storeName = "Amazon - ".$amazon['storeName'];
		
		$sellerID = $amazon['merchantAccID'];//"A2USPEVVEBMPM4";
		$selCountryCode = $countrycode['code'] = $amazon['selCountry'];
		$countrycode['usertoken'] = $amazon['usertoken'];
		$countrycode['dbcode'] = $amazon['dbcode'];
		
		//$countryname = $amazon['selCountry']['countryname'];
		$pkamzaccountcode = $amazon['pkamzaccountcode']; //if it is greater than zero edit condition
		$countryDetails = getSelAmazonCountry($countrycode);
		//echo "<pre>";print_r($countryDetails);exit;
		if($countryDetails['statuscode']==0)
		{
			$serviceurl = $countryDetails['countries'][0]['serviceurl'];
			$str_AccessKey = $countryDetails['countries'][0]['accesskey'];
			$str_SecretKey = $countryDetails['countries'][0]['secretkey'];		
			//$serviceurl = "https://mws.amazonservices.co.uk";//$serviceurl
		}else {
					$failureMsgArray['statusmessage'] = "Couldn't get Access key and Secret key. Technical Error.";
					//return $failureMsgArray; exit;
					echo json_encode(array('data'=>$failureMsgArray));exit;
			}
		
		$parameters = array();
		//$str_AccessKey =  $amazon['amaccessKey'];//"AKIAIPQLZK3ZJCOK7BAA"; //Comment these
		//$str_SecretKey =  $amazon['amsecretKey'];//"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";
			
		
		$params = array ( 
                'AWSAccessKeyId' 	=> $str_AccessKey,
				'Action'			=> 'GetAuthToken',
				'SellerId'          => $sellerID, 
				'SignatureMethod' 	=> 'HmacSHA256',
				'SignatureVersion'	=> 2,
				'Version' 			=> '2011-07-01',
            );
			
			//$Arg_WebServicePrefix = "mws.amazonservices.co.uk";
			$BaseAmazonUrl 	= $serviceurl."/Sellers/2011-07-01";
			$query_string = '';
			
			foreach ($params as $key => $value) 
			{ 
				$query_string .= "$key=" . urlencode($value) . "&";
			}        
			
			$AmazonUrlResponseInXml = "$BaseAmazonUrl?$query_string";
			$requestURL = getRequest($str_SecretKey, $AmazonUrlResponseInXml, $str_AccessKey, "2011-07-01"); 
			
			//echo $requestURL;
			$session = curl_init($requestURL);
			//print_r($requestURL);exit;
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($session);
			
			$curlerror = curl_errno($session);
			//echo "<br/><br/>".$curlerror;
			curl_close($session);
			$parsed_xml = simplexml_load_string($response);
			//echo "<pre>";print_r($parsed_xml);exit;
			$MWSAuthToken = $parsed_xml->GetAuthTokenResult->MWSAuthToken;
			if($MWSAuthToken!=""){
				
				if($pkamzaccountcode>0)//Update
				{
						$xml  = new SimpleXMLExtended('<updateamzaccountsrequest/>'); //update condition
						$xml->usertoken = NULL;
						$xml->usertoken->addCData(stripslashes($amazon['usertoken']));
						$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
						$xml->dbcode = $amazon['dbcode'];
						$xml->responsetype = NULL;
						$xml->responsetype->addCData("json");
						$xml->modifiedby = NULL;
						$xml->modifiedby = $amazon["usercode"];
						$accounts = $xml->addChild("accounts");
						$account = $accounts->addChild("account");
						$account->pkamzaccountcode = NULL;
						$account->pkamzaccountcode = $pkamzaccountcode;
						$account->sellerid = NULL;
						$account->sellerid->addCData($sellerID);
						$account->amzaccountcode = NULL;
						$account->amzaccountcode = 123;
						$account->amzaccountname = NULL;
						$account->amzaccountname->addCData($storeName);
						$account->countrycode = NULL;
						$account->countrycode = $selCountryCode;
						$account->isorderdownload = NULL;
						$account->isorderdownload = 1;
						$account->mwsauthtoken = NULL;
						$account->mwsauthtoken->addCData($MWSAuthToken);
						
						$requestXml = $xml->saveXML();
					
					
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/AmazonApi/api/AmazonAccounts/UpdateAmazonAccount");
					
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec($ch);
						
				}else{ //add
					
						$xml  = new SimpleXMLExtended('<addamzaccountsrequest/>');  //add condition
						$xml->usertoken = NULL;
						$xml->usertoken->addCData(stripslashes($amazon['usertoken']));
						$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
						$xml->dbcode = $amazon['dbcode'];
						$xml->responsetype = NULL;
						$xml->responsetype->addCData("json");
						$xml->sellerid = NULL;
						$xml->sellerid->addCData($sellerID);
						$xml->countrycode = NULL;
						$xml->countrycode = $selCountryCode;
						$xml->amzaccountcode = NULL;
						$xml->amzaccountcode = 123;
						$xml->amzaccountname = NULL;
						$xml->amzaccountname->addCData($storeName);
						$xml->isorderdowload = NULL;
						$xml->isorderdowload = 1;
						$xml->mwsauthtoken = NULL;
						$xml->mwsauthtoken->addCData($MWSAuthToken);
						$xml->createdby = NULL;
						$xml->createdby = $amazon["usercode"];
							
						$requestXml = $xml->saveXML();
					
					
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/AmazonApi/api/AmazonAccounts/AddAmazonAccount");
					
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec($ch);
				}
				curl_close($ch);
				$responseArray = json_decode($result,true);
				//return $responseArray;exit;
				echo json_encode(array('data'=>$responseArray));exit;
				
			}else { 
				$failureMsgArray['statusmessage'] = $parsed_xml->Error->Message;//'Verification failure. Please check the inputs provided.';
				//return $failureMsgArray; exit;
				echo json_encode(array('data'=>$failureMsgArray));exit;
			}
			
		
	}
	//END - Amazon Marketplace
	//START - FNAC Marketplace
	function checkForFNACAuthentication($requestData)
	{
			$partner_id = $requestData['partner_id'];//"CF8DA713-BB3B-5E0B-36F5-7F6A4CD5CFF9";
			$shop_id = $requestData['shop_id'];//"0F19733B-F9AD-72DC-770D-2E2A35702CC7";
			$key = $requestData['key'];//"6974399F-D850-A229-2733-A1C14233d89FF";
			$requestXml = "<?xml version='1.0' encoding='utf-8'?>
							<auth xmlns='http://www.fnac.com/schemas/mp-dialog.xsd'>
								<partner_id>".$partner_id."</partner_id>
								<shop_id>".$shop_id."</shop_id>
								<key>".$key."</key>
							</auth>";

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://vendeur.fnac.com/api.php/auth");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

				$response = curl_exec($ch);
				/*if(curl_errno($ch))
				{
					echo 'Curl error: ' . curl_error($ch);
				}*/
				
				curl_close($ch);
			
			$xmlResponse = simplexml_load_string(trim($response));
			//echo "<pre>";
			//print_r($response);
			//print_r($xmlResponse);exit;
			$responseArray = array();
			$flag = 0;
			foreach($xmlResponse->attributes() as $a => $b) 
			{
				
				if($a=='status' && strtolower(trim($b))=='ok')
				{
					$responseArray['statuscode'] = 0;
					$responseArray['statusmessage'] = 'success';
					$flag = 1;
					$msg = 'success';
				}else if($a=='status' && strtolower(trim($b))=='error')
				{
					$responseArray['statuscode'] = 404;
					$responseArray['statusmessage'] = 'Authentication failed : one of the parameters (Partner ID, Shop ID, Key) is invalid'; //$xmlResponse->error;
					$flag = 0;		
				}
			}
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));
	}
	
	function checkForCDiscountAuthentication($requestData)
	{
			$partner_id = $requestData['partner_id'];//"CF8DA713-BB3B-5E0B-36F5-7F6A4CD5CFF9";
			$shop_id = $requestData['shop_id'];//"0F19733B-F9AD-72DC-770D-2E2A35702CC7";
			$key = $requestData['key'];//"6974399F-D850-A229-2733-A1C14233d89FF";
			$requestXml = "<?xml version='1.0' encoding='utf-8'?>
							<auth xmlns='http://www.fnac.com/schemas/mp-dialog.xsd'>
								<partner_id>".$partner_id."</partner_id>
								<shop_id>".$shop_id."</shop_id>
								<key>".$key."</key>
							</auth>";

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://vendeur.fnac.com/api.php/auth");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

				$response = curl_exec($ch);
				/*if(curl_errno($ch))
				{
					echo 'Curl error: ' . curl_error($ch);
				}*/
				
				curl_close($ch);
			
			$xmlResponse = simplexml_load_string(trim($response));
			//echo "<pre>";
			//print_r($response);
			//print_r($xmlResponse);exit;
			$responseArray = array();
			$flag = 0;
			foreach($xmlResponse->attributes() as $a => $b) 
			{
				
				if($a=='status' && strtolower(trim($b))=='ok')
				{
					$responseArray['statuscode'] = 0;
					$responseArray['statusmessage'] = 'success';
					$flag = 1;
					$msg = 'success';
				}else if($a=='status' && strtolower(trim($b))=='error')
				{
					$responseArray['statuscode'] = 404;
					$responseArray['statusmessage'] = 'Authentication failed : one of the parameters (Partner ID, Shop ID, Key) is invalid'; //$xmlResponse->error;
					$flag = 0;		
				}
			}
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));
	}
	
	//END - FNAC Marketplace
	//START - TRADEME Marketplace
	function AddTrademeAccount($accountData)
	{
		$respArray = array();
		if(isset($_SESSION['oauth_token'])&& $_SESSION['oauth_token']!=='')
		{
				$removeTrmePrefix = explode("TradeMe - ", $accountData['trademeaccountname']);
				if(count($removeTrmePrefix)>1)
					$storeName = $accountData['trademeaccountname'];
				else 
					$storeName = "TradeMe - ".$accountData['trademeaccountname'];
				
				$xml  = new SimpleXMLExtended('<addtrademeaccountrequest/>');
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($accountData['usertoken']));
				$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
				$xml->dbcode = $accountData['dbcode'];
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$account = $xml->addChild('account');
				$account->trademeaccountcode = NULL;
				$account->trademeaccountcode->addCData('1234');
				$account->trademeaccountname = NULL;
				$account->trademeaccountname->addCData($storeName);
				$account->isorderdowload = NULL;
				$account->isorderdowload = 1;
				$account->countrycode = NULL;
				$account->countrycode=$accountData['selCountry'];
				$account->trademeusername = NULL;
				$account->trademeusername = '';
				$account->trademecustomerkey = NULL;
				$account->trademecustomerkey->addCData($_SESSION['oauth_consumer_key']);
				$account->trademecustomersecretkey = NULL;
				$account->trademecustomersecretkey->addCData($_SESSION['oauth_consumer_secret']);
				$account->authtoken = NULL;
				$account->authtoken->addCData($_SESSION['oauth_token']);
				$account->authtokensecretkey = NULL;
				$account->authtokensecretkey->addCData($_SESSION['oauth_token_secret']);
				$account->status = NULL;
				$account->status = 1;
				$account->createdby = NULL;
				$account->createdby = $accountData["usercode"];
				
				$requestXml = $xml->saveXML();
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/TradeMeAPI/api/TradeMeAccount/AddTradeMeAccount");
			
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$respArray = json_decode($result,true);
				$_SESSION['oauth_token'] = '';
				$_SESSION['oauth_token_secret'] = '';
				//return $respArray;
				echo json_encode(array('data'=>$respArray));
		}else {
				$respArray['statuscode'] = 404; 
				$respArray['statusmessage'] = 'authtokenempty'; 
				//return $respArray;
				echo json_encode(array('data'=>$respArray));
		}
		
	
	}
	
	function EditTrademeAccount($accountData)
	{
		$respArray = array();
		if(isset($_SESSION['oauth_token'])&& $_SESSION['oauth_token']!=='')
		{
				$removeTrmePrefix = explode("TradeMe - ", $accountData['trademeaccountname']);
				if(count($removeTrmePrefix)>1)
					$storeName = $accountData['trademeaccountname'];
				else 
					$storeName = "TradeMe - ".$accountData['trademeaccountname'];
						
				$xml  = new SimpleXMLExtended('<updatetrademeaccountrequest/>');
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($accountData['usertoken']));
				$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
				$xml->dbcode = $accountData['dbcode'];
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$account = $xml->addChild('account');
				$account->pktrademeaccountcode = NULL;
				$account->pktrademeaccountcode=$accountData['pktrademeaccountcode'];
				$account->trademeaccountcode = NULL;
				$account->trademeaccountcode->addCData($accountData['trademeaccountcode']);
				$account->trademeaccountname = NULL;
				$account->trademeaccountname->addCData($storeName);
				$account->isorderdowload = NULL;
				$account->isorderdowload = 1;
				$account->countrycode = NULL;
				$account->countrycode=$accountData['selCountry'];
				$account->trademeusername = NULL;
				$account->trademeusername = '';
				$account->trademecustomerkey = NULL;
				$account->trademecustomerkey->addCData($_SESSION['oauth_consumer_key']);
				$account->trademecustomersecretkey = NULL;
				$account->trademecustomersecretkey->addCData($_SESSION['oauth_consumer_secret']);
				$account->authtoken = NULL;
				$account->authtoken->addCData($_SESSION['oauth_token']);
				$account->authtokensecretkey = NULL;
				$account->authtokensecretkey->addCData($_SESSION['oauth_token_secret']);
				$account->status = NULL;
				$account->status=1;
				$account->modifiedby = NULL;
				$account->modifiedby=$accountData["usercode"];
				
				$requestXml = $xml->saveXML();
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/TradeMeAPI/api/TradeMeAccount/UpdateTradeMeAccount");
			
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$_SESSION['oauth_token'] = '';
				$_SESSION['oauth_token_secret'] = '';
				
				$respArray = json_decode($result,true);
			
				//return $respArray;
				echo json_encode(array('data'=>$respArray));
		}else {
				$respArray['statuscode'] = 404; 
				$respArray['statusmessage'] = 'authtokenempty'; 
				//return $respArray;
				echo json_encode(array('data'=>$respArray));
		}
	
	}
	//END - TRADEME Marketplace
	//END - Marketplaces
	
	//START - LOGIN
	function sendFileRequest($requestData)
	{
		 $respArray = array();
		 $tmpExcelFile = $_SERVER["DOCUMENT_ROOT"]."/php/customer/customersupport/". $requestData['name']; 
		 move_uploaded_file($requestData["tmp_name"], $tmpExcelFile);
		 $respArray['uploadedUrl'] =$tmpExcelFile;
		 //return $respArray['uploadedUrl'];
		 echo json_encode(array($respArray['uploadedUrl']));
	}
	
	function sendCustomerSupportRequest($reqData)
	{
			require 'login/PHPMailer/PHPMailerAutoload.php';
			if(isset($reqData['attachedFile'])){
				$filename = $reqData['attachedFile'];
			}
			
			$email = $reqData['email'];
			$subject = $reqData['subject'];
			$Cmb_severityLevel = $reqData['Cmb_severityLevel'];
			$Cmb_marketaffected = $reqData['Cmb_marketaffected'];
			$description = $reqData['description'];
			$featureAffected = array();
			$rows = count($reqData['chkvalues']);
			foreach($reqData['chkvalues'] as $index=>$value){
				$feratureaffted = $value['actName'];
				$featureAffected[] = $feratureaffted;
			}
			$Cmb_feratureaffted =  implode(", ", $featureAffected);
			$mail = new PHPMailer;
			
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'auth.smtp.1and1.co.uk';                       // Specify main and backup server
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'notifications@247cloudhub.co.uk';                   // SMTP username
			$mail->Password = 'notifications247*';               // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			$mail->Port = 587; 
			$mail->From = $reqData['email'];
			$mail->FromName = $reqData['email'];                                   //Set the SMTP port number - 587 for authenticated TLS
				//Set who the message is to be sent from
			$mail->addAddress('support@247cloudhub.co.uk', 'Customer Support');  // Add a recipient
			if(isset($reqData['attachedFile'])){
				$mail->addAttachment($reqData['attachedFile']);  
			}       // Add attachments
			
			
			$mail->Subject = 'Customer Support Email';
			$mail->Body    = $subject;
			$mail->msgHTML('<style>
				.Pnl_customersupport {
					height:auto;
					width:650px; 
					border-radius:10px; 
					background-color: bottom #FFF; 
					border:solid 2px #2B72C0; 
					color:#000000;
					padding:15px;
				}
				.Pnl_customersupport td{
					white-space:normal;
				}
				.Cmbo_cssuport {
				  border: 1px solid #CCCCCC;
				  color: #000000;
				  font: 12px/20px Arial,Helvetica,sans-serif;
				  height: 20px;
				  background:#fff;
				  padding:2px;
				  width:200px;
				}
				</style>
				<div class="Pnl_customersupport"style="border:solid 2px #2B72C0;">
					<table width="100%" border="0" cellspacing="5" cellpadding="0">
					  <tr>
						<td colspan="3">
							
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td align="left"><span style="font-weight:bold; color:#000; font-size:14px; line-height:23px; padding-left:20px;">Contact Customer Support</span></td>
										<td align="right">&nbsp;</td>
									</tr>
								</tbody>
						   </table>
						</td>
					  </tr>
					  <td colspan="3" class="drawLine">&nbsp;</td>
					  <tr>
						<td width="25%">Email ID</td>
						<td width="1%">:</td>
						<td width="73%">'.$email.'</td>
					  </tr>
					  <tr>
						<td>Subject</td>
						<td>:</td>
						<td>'.$subject.'</td>
					  </tr>
					  <tr>
						<td valign="top">Severity Level</td>
						<td  valign="top">:</td>
						<td>['.$Cmb_severityLevel.']</td>
					  </tr>
					  <tr>
						<td>Marketplaces affected</td>
						<td>:</td>
						<td>'.$Cmb_marketaffected.'</td>
					  </tr>
					  <tr>
						<td>Features affected</td>
						<td>:</td>
						<td>'.$Cmb_feratureaffted.'</td>
					  </tr>
					  <tr>
						<td colspan="3">Description of the Problem</td>
					  </tr>
					  <tr>
						<td colspan="3" style="border:solid 1px #ccc; padding:10px 4px;">'.$description.'</td>
					  </tr>
					</table>
				</div>');
			if(!$mail->send()) {
				if(isset($reqData['attachedFile'])){
					unlink($reqData['attachedFile']);
				}
				$succStatus = 0;
				//return $succStatus = 0;
				echo json_encode(array($succStatus));
			}else{
				if(isset($reqData['attachedFile'])){
					unlink($reqData['attachedFile']);
				}
				//return $succStatus = 1;
				$succStatus = 1;
				echo json_encode(array($succStatus));
			}
	}
	
	function recoverPassword($input)
	{	
		$ipAddress = get_client_ip_utils();//"61.12.38.126";//get_client_ip(); // get_client_ip();
		$message = new stdClass();

		$xml  = new SimpleXMLExtended('<forgotpasswordrequest/>');
		$xml->username = NULL;
		$xml->username = $input["resetEmail"];
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->ipaddress = NULL;
		$xml->ipaddress = $ipAddress;
		$requestXml = $xml->saveXML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/UserAPIs/api/UserSettings/ForgotPassword");
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$responseArray= json_decode($result,true); 
		
		if($responseArray['statuscode']== 0 ){ 
			require 'login/PHPMailer/PHPMailerAutoload.php';
			
			$mail = new PHPMailer;
				
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'auth.smtp.1and1.co.uk';                       // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'notifications@247cloudhub.co.uk';                   // SMTP username
				$mail->Password = 'notifications247*';               // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
				$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
				$mail->setFrom('notifications@247cloudhub.co.uk', '247Cloudhub');     //Set who the message is to be sent from
				$mail->addAddress($input["resetEmail"],$input["resetEmail"]);  // Add a recipient
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = '247Cloudhub Account New Password';
				$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				$mail->msgHTML('<html>
								<head>
								<title>247Cloudhub Account Reset Password </title>
								</head>
								<body>
								<div class="mailCreateUser">
									<p>Your New Password is:&nbsp;'.$responseArray['newpassword'].' </p><br />
									</div>
									
								</div>	
								
								</body>
								</html>');
				$mail->send();
		}
					
		unset($responseArray['newpassword']);		
		
		//return $responseArray;
		echo json_encode($responseArray);
		
	}

	
		function updateCompanyDetails($formData)
		{
				if( isset($formData['imageurl'])  && ($formData['imageurl']!=""))
				{
					$imgName = generate_imageUrlName().'_'.$formData['companycode'];
					$filePath = $formData['imageurl'];
					$userimageurl = imageResize($filePath,$imgName,'250','250',$formData['existingImageUrl']);
				}else{
					$userimageurl = '';
				}	
			
				$message = new stdClass();
				$xml = new SimpleXMLExtended('<updatecompanydetailsrequest  />');
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($formData['usertoken']));
				$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
				$xml->dbcode = $formData['dbcode'];
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$company = $xml->addChild("companydetails");
				$company->companycode = NULL;
				$company->companycode=$formData['companycode'];
				$company->companyname = NULL;
				$company->companyname->addCData($formData['companyname']);
				$company->addressline1 = NULL;
				$company->addressline1->addCData($formData['addressline1']);
				$company->adderssline2 = NULL;
				$company->adderssline2->addCData($formData['addressline2']);
				$company->city = NULL;
				$company->city=$formData['city'];
				$company->postalcode = NULL;
				$company->postalcode=$formData['postalcode'];
				$company->countrycode = NULL;
				$company->countrycode=$formData['countrycode'];
				$company->emailaddress = NULL;
				$company->emailaddress->addCData($formData['emailaddress']);
				$company->timezonecode = NULL;
				$company->timezonecode=$formData['timezonecode'];
				$company->imageurl = NULL;
				$company->imageurl=$userimageurl;
				$company->timeformatcode = NULL;
				$company->timeformatcode=$formData['timeformatcode'];
				
				$requestXml = $xml->saveXML();


				//$requestXml = $xml;//->saveXML();
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/UserApis/Api/Company/UpdateCompanyDetails");

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$respArray= json_decode($result,true);

				//return $respArray;
				echo json_encode(array('data'=>$respArray));

		}
	//END-LOGIN APIS
	
	//START -  UserAPIs
	function saveServiceTopLinks($sortedData)
	{
		$dbconnection = getdbconnection();
		$deletesql = "DELETE FROM quick_link_service where user_id='".$sortedData['usercode']."' and db_code='".$sortedData['dbcode']."'";
		$dbconnection->query($deletesql);
		//print_r($sortedData);
		foreach($sortedData as $key=>$values)
		{
			if($key !='callFunction' && is_array($values)){ //echo count($values)."---".sizeof($values);
				if(count($values) > 0){
					//print_r($values);
					foreach($values as $innerKey=>$innerValues){
						$sql = "SELECT menuId FROM quick_link_service where menuId='".$innerValues['menuId']."' and user_id='".$sortedData['usercode']."' and db_code='".$sortedData['dbcode']."'";
						$result = $dbconnection->query($sql);
						$row = $result->fetch_assoc();
						
						if($row['menuId'] == ''){
							 $insertsql = "INSERT INTO quick_link_service 
						(user_id,db_code, item_type, menuId,mTitle,linkUrl,isShow) VALUES 
						(".$sortedData['usercode'].",".$sortedData['dbcode'].", '".$key."', '".$innerValues['menuId']."','".$innerValues['mTitle']."','".$innerValues['linkUrl']."','".$innerValues['isShow']."')";
						$dbconnection->query($insertsql);
						}
					   
					}
				}
				
			}
		}
		
		$dbconnection->close();
		//return "Success";
		echo json_encode(array('data'=>'Success'));
	}
	
	function getServiceTopLinks($requestData)
	{
		$dbconnection = getdbconnection();
		$finalsql = "SELECT * FROM quick_link_service where user_id='".$requestData['usercode']."' and db_code='".$requestData['dbcode']."'";
		$finalresult = $dbconnection->query($finalsql);
		$quicklinks_array = array();
		$quicklinks_array['quickArray'] = array();
		$quicklinks_array['itemsArray'] = array();
		$quicklinks_array['divArray'] = array();
		while($rows = mysqli_fetch_assoc($finalresult)) {
			if($rows['item_type'] == 'itemsArray'){
				$quicklinks_array['itemsArray'][] = array('menuId'=>$rows['menuId'],'mTitle'=>$rows['mTitle'],'linkUrl'=>$rows['linkUrl'],'isShow'=>$rows['isShow']);
			}else if($rows['item_type'] == 'divArray'){
				$quicklinks_array['divArray'][] = array('menuId'=>$rows['menuId'],'mTitle'=>$rows['mTitle'],'linkUrl'=>$rows['linkUrl'],'isShow'=>$rows['isShow']);
			}
			
		}
		$dbconnection->close();
		
		//return $quicklinks_array;
		echo json_encode(array('data'=>$quicklinks_array));
	}
	
	
	function addUser($userData)
	{
		$userName = (isset($userData['username'])&& $userData['username'] !="")? $userData['username']: '';
		$password = (isset($userData['password']) && $userData['password']!="")? $userData['password']: generate_password() ;
		$firstName = (isset($userData['firstname']) && $userData['firstname']!="" )? $userData['firstname']: '';
		$lastName = (isset($userData['lastname']) && $userData['lastname']!= "")? $userData['lastname']: '';
		$addressline1 = (isset($userData['address1']) && $userData['address1']!="")? $userData['address1']: '';
		$adderssline2 = (isset($userData['address2']) && $userData['address2']!="")? $userData['address2']: '';
		$city = (isset($userData['city']) && $userData['city']!="")? $userData['city']: '';
		$postcode = (isset($userData['postcode']) && ($userData['postcode']!=""))? $userData['postcode']: '';
		$countrycode = (isset($userData['countrycode']) && ($userData['countrycode']!=""))? $userData['countrycode']: '';
		$notifiyMail = (isset($userData['notifiyMail']) && ($userData['notifiyMail']!=""))? $userData['notifiyMail']: '';
		$userimageurl =  '';
		$designationcode = (isset($userData['designation']) && ($userData['designation']!=""))? $userData['designation']: '';
		$rolecode = (isset($userData['rolecode']) && ($userData['rolecode']!=""))? $userData['rolecode']: '';

	
			$xml  = new SimpleXMLExtended('<adduserrequest/>');
			$xml->usertoken = NULL;
			$xml->usertoken->addCData(stripslashes($userData['usertoken']));
			$xml->dbcode = NULL; // VERY IMPORTANT! We need a node where to append
			$xml->dbcode = $userData['dbcode'];	
			$xml->responsetype = NULL;
			$xml->responsetype->addCData("json");
			$user = $xml->addChild("user");
			$user->username = NULL;
			$user->username->addCData(stripslashes($userName));
			$user->password = NULL;
			$user->password->addCData(stripslashes($password));
			$user->firstname = NULL;
			$user->firstname->addCData(stripslashes($firstName));
			$user->lastname = NULL;
			$user->lastname->addCData(stripslashes($lastName));
			$user->addressline1 = NULL;
			$user->addressline1->addCData(stripslashes($addressline1));
			$user->adderssline2 = NULL;
			$user->adderssline2->addCData(stripslashes($adderssline2));
			$user->city = NULL;
			$user->city->addCData(stripslashes($city));
			
			$user->postcode = NULL;
			$user->postcode->addCData(stripslashes($postcode));
			$user->countrycode = NULL;
			$user->countrycode->addCData(stripslashes(str_replace("string:","",$countrycode)));
			$user->userimageurl = NULL;
			$user->userimageurl->addCData(stripslashes($userimageurl));
			$user->designationcode = NULL;
			$user->designationcode->addCData(stripslashes($designationcode));
			$user->rolecode = NULL;
			$user->rolecode = $rolecode;
		  	$requestXml = $xml->saveXML();   

	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/UserAPIs/api/UserSettings/AddUsers");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		$responseArray = json_decode($result,true);
		if($responseArray['statuscode']== 0 && $notifiyMail !=''){
				// mail();	
			require 'login/PHPMailer/PHPMailerAutoload.php';
			
			$mail = new PHPMailer;
			
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'auth.smtp.1and1.co.uk';                       // Specify main and backup server
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'notifications@247cloudhub.co.uk';                   // SMTP username
			$mail->Password = 'notifications247*';               // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
			$mail->setFrom('notifications@247cloudhub.co.uk', '247Cloudhub');     //Set who the message is to be sent from
			$mail->addAddress($userName,$userName);  // Add a recipient
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = '247Cloudhub Account Created';
			$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			$mail->msgHTML('<html>
							<head>
							<title>247Cloudhub Account Created</title>
							</head>
							<body>
							<div class="mailCreateUser">
								<p>'.$userData["fullname"].'  created for you a 247Cloudhub account </p><br />
								<p>Username : '.$userName.'</p>
								<p>Password : '.$password.'</p>
								<p>Full Name : '.$firstName.'</p>
								<p>Get started by clicking the below link:</p>
								<div>
								<p><a href="http://www.247cloudhub.co.uk">http://www.247cloudhub.co.uk</a></p>
								<p>
									You can set your account details from below link:  <br />
									<a href="http://247cloudhub.co.uk/#/app/edit-user/'.$responseArray['usercode'].'">Edit Profile</a>
								<p>	
								</div>
							</div>	
							</body>
							</html>');
			$mail->send();
				
		}
		
	    //return $responseArray = json_decode($result,true);
	    $responseArray = json_decode($result,true);
		echo json_encode(array('data'=>$responseArray));
	}

	function updateUser($userData)
	{    
		$userCode = (isset($userData['usercode'])&& $userData['usercode'] !="")? $userData['usercode']: '';
		$userName = (isset($userData['username'])&& $userData['username'] !="")? $userData['username']: '';
		$firstName = (isset($userData['firstname']) && $userData['firstname']!="" )? $userData['firstname']: '';
		$lastName = (isset($userData['lastname']) && $userData['lastname']!= "")? $userData['lastname']: '';
		$addressline1 = (isset($userData['address1']) && $userData['address1']!="")? $userData['address1']: '';
		$adderssline2 = (isset($userData['address2']) && $userData['address2']!="")? $userData['address2']: '';
		$city = (isset($userData['city']) && $userData['city']!="")? $userData['city']: '';
		$postcode = (isset($userData['postcode']) && ($userData['postcode']!=""))? $userData['postcode']: '';
		$countrycodes = (isset($userData['countryCodes']) && ($userData['countryCodes']!=""))? $userData['countryCodes']: '';
		$designationcode = (isset($userData['designationCode']) && ($userData['designationCode']!=""))? $userData['designationCode']: '';
		
		$countryArr = explode(",",$countrycodes);
	
		if( isset($userData['fileFullPath'])  && ($userData['fileFullPath']!="") && isset($userData['enableUpload']) && ($userData['enableUpload'] ==1))
		{ 
			$imgName = generate_imageUrlName().'_'.$userCode; 
			$filePath = $userData['fileFullPath'];
			$s3ImgUploadedData = uploadImgToS3('cloudhub-europe',$filePath,$imgName,$userData['existingUrl']); 
			
			$s3ImgUploadedData1 = $s3ImgUploadedData->toArray();
			$userimageurl = $s3ImgUploadedData1['ObjectURL']; 
			if($userimageurl){
				unlink($filePath);
			}
		}else if( isset($userData['fileFullPath'])  && ($userData['fileFullPath']!="")){ 
			$userimageurl = $userData['fileFullPath'];
		}else{
			$userimageurl = '';
		}

	
		$active = 1;
		if(isset($userData['active']) && $userData['active']=="inactive"){ $active = 0; } 

			$xml  = new SimpleXMLExtended('<updateuserrequest/>');
			$xml->usertoken = NULL;
			$xml->usertoken->addCData(stripslashes($userData['usertoken']));
			$xml->dbcode = NULL; 				// VERY IMPORTANT! We need a node where to append
			$xml->dbcode = $userData['dbcode'];	
			$xml->responsetype = NULL;
			$xml->responsetype->addCData("json");
			$user = $xml->addChild("user");
			$user->usercode = NULL;
			$user->usercode = $userCode;
			$user->username = NULL;
			$user->username->addCData(stripslashes($userName));
			$user->firstname = NULL;
			$user->firstname->addCData(stripslashes($firstName));
			$user->lastname = NULL;
			$user->lastname->addCData(stripslashes($lastName));
			$user->addressline1 = NULL;
			$user->addressline1->addCData(stripslashes($addressline1));
			$user->adderssline2 = NULL;
			$user->adderssline2->addCData(stripslashes($adderssline2));
			$user->city = NULL;
			$user->city->addCData(stripslashes($city));
			$user->postalcode = NULL;
			$user->postalcode->addCData(stripslashes($postcode));
			
			$countrycodes = $user->addChild("countrycodes");
			
			for($i=0;$i<count($countryArr);$i++)
			{
				$countrycodes->addChild("countrycode", str_replace("string:","",$countryArr[$i]));
			}
				
			$user->userimageurl = NULL;
			$user->userimageurl->addCData(stripslashes($userimageurl));
			$user->designationcode = NULL;
			$user->designationcode = $designationcode;
			$user->active = NULL;
			$user->active = $active;
			$requestXml = $xml->saveXML();  

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/UserAPIs/api/UserSettings/UpdateUser");

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$responseArray = json_decode($result,true);
			
			//return $responseArray;
			echo json_encode(array('data'=>$responseArray));
	}
	
	//END - USER APIS
	
	//START - Marketplace Invoices
	function uploadMarketplaceLogoImg($imgDetails)
	{
		$selectedInvoiceID = $imgDetails['curID'];
		if( isset($imgDetails['curImgURL'])  && ($imgDetails['curImgURL']!="")){
			$imgName = generate_imageUrlName();
			$filePath = $imgDetails['curImgURL'];
			$s3ImgUploadedUrl = "";
			$s3ImgUploadedUrl = imageResizeAndUploadToS3($filePath,$imgName,'400','400');
		}else{
			$s3ImgUploadedUrl = '';
		}	
		
		if($s3ImgUploadedUrl!="")
		{
			
			if($selectedInvoiceID==0){
					//$invoiceDetails = getMarketplaceInvoices($selectedInvoiceID);
					$logourl = $s3ImgUploadedUrl;
					$marketplacecode = $imgDetails['marketplaceCode'];
					$accountcode = $imgDetails['accountCode'];
					$couriercode = 1;
					
					//API to Update Logo Information
					$xml = new SimpleXMLExtended('<adddespatchnotelogoinformationrequest/>');
					$xml->usertoken = NULL;
					$xml->usertoken->addCData(stripslashes($imgDetails['usertoken']));
					$xml->dbcode = NULL; 
					$xml->dbcode = $imgDetails['dbcode'];	
					$xml->responsetype = NULL;
					$xml->responsetype->addCData("json");
					$despatchnotelogoChild = $xml->addChild("despatchnotelogo");
					$despatchnotelogoChild->couriercode = NULL;
					$despatchnotelogoChild->couriercode = $couriercode;					
					$despatchnotelogoChild->logourl = NULL;
					$despatchnotelogoChild->logourl->addCData(stripslashes($logourl));
					$despatchnotelogoChild->marketplacecode = NULL;
					$despatchnotelogoChild->marketplacecode = $marketplacecode;		
					$despatchnotelogoChild->accountcode = NULL;
					$despatchnotelogoChild->accountcode = $accountcode;	
					$despatchnotelogoChild->createdby = NULL;
					$despatchnotelogoChild->createdby = $imgDetails['usercode'];	

				    $requestXml = $xml->saveXML();
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/DespatchNoteLogoInformation/AddDespatchNoteLogoInformation");

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
					
					$respArray = json_decode($result,true);
					
					//return $respArray;exit;
					echo json_encode(array('data'=>$respArray));exit;

			}else{
			
					$invoiceDetails = getMarketplaceInvoices($selectedInvoiceID);
					$logourl = $s3ImgUploadedUrl;
					$pkinvoicelogoinformationcode = $invoiceDetails['despatchnotelogos'][0]['pkdespatchnotelogoinformationcode'];
					$marketplacecode = $invoiceDetails['despatchnotelogos'][0]['marketplacecode'];
					$accountcode = $invoiceDetails['despatchnotelogos'][0]['accountcode'];
					$active = ($invoiceDetails['despatchnotelogos'][0]['active'] == "True")? 1:0;
					$couriercode = 1;//$invoiceDetails['invoicelogos'][0]['couriercode'];
					
					
					
					//API to Update Logo Information
					$xml = new SimpleXMLExtended('<updatedespatchnotelogoinformationrequest/>');
					$xml->usertoken = NULL;
					$xml->usertoken->addCData(stripslashes($imgDetails['usertoken']));
					$xml->dbcode = NULL; 
					$xml->dbcode = $imgDetails['dbcode'];	
					$xml->responsetype = NULL;
					$xml->responsetype->addCData("json");
					$despatchnotelogoChild = $xml->addChild("despatchnotelogo");
					$despatchnotelogoChild->pkdespatchnotelogoinformationcode = NULL;
					$despatchnotelogoChild->pkdespatchnotelogoinformationcode = $pkinvoicelogoinformationcode;
					$despatchnotelogoChild->couriercode = NULL;
					$despatchnotelogoChild->couriercode = $couriercode;
					$despatchnotelogoChild->logourl = NULL;
					$despatchnotelogoChild->logourl->addCData(stripslashes($logourl));
					$despatchnotelogoChild->marketplacecode = NULL;
					$despatchnotelogoChild->marketplacecode = $marketplacecode;		
					$despatchnotelogoChild->accountcode = NULL;
					$despatchnotelogoChild->accountcode = $accountcode;	
					$despatchnotelogoChild->modifiedby = NULL;
					$despatchnotelogoChild->modifiedby = $imgDetails['usercode'];	
					$despatchnotelogoChild->active = NULL;
					$despatchnotelogoChild->active = $active;	

					$requestXml = $xml->saveXML();
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/DespatchNoteLogoInformation/UpdateDespatchNoteLogoInformation");

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
					
					$respArray = json_decode($result,true);
					
					//return $respArray;exit;
					echo json_encode(array('data'=>$respArray));exit;
			}

		}
		$failureMsgArray['statusmessage'] = 'Failed to update marketplace invoice logo';
		//return $failureMsgArray; exit;
		echo json_encode(array('data'=>$failureMsgArray));exit;
		
	}
	
	function getAllInvoice($reqArray)
	{ 
		$xml = new SimpleXMLExtended('<getinvoicelogoinformationrequest/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(stripslashes($reqArray['usertoken']));
		$xml->dbcode = NULL; 
		$xml->dbcode = $reqArray['dbcode'];	
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->pkinvoicelogoinformationcode = NULL;
		$xml->pkinvoicelogoinformationcode = $reqArray['selectedInvoiceID'];

		$requestXml = $xml->saveXML();
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/InvoiceLogoInformation/GetInvoiceLogoInformation");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		
		$respArray = json_decode($result,true);
		
		//return $respArray;
		echo json_encode(array('data'=>$respArray));
	}
	
	
	
	function uploadLogoImg($imgDetails)
	{
		$selectedInvoiceID = $imgDetails['curID'];
		
		//Below block is for Logo
		if( isset($imgDetails['logoImgURL'])  && ($imgDetails['logoImgURL']!="")){
			$imgName = generate_imageUrlName();
			$filePath = $imgDetails['logoImgURL'];
			$s3ImgLogoUrl = "";
			$s3ImgLogoUrl = PpiImgResizeAndUploadToS3($filePath,$imgName,'300','150', 'logo');
		}else{
			$s3ImgLogoUrl = '';
		}	
		
		//Below block is for PPI image
		if( isset($imgDetails['ppiImgURL'])  && ($imgDetails['ppiImgURL']!="")){
			$imgName = generate_imageUrlName();
			$filePath = $imgDetails['ppiImgURL'];
			$s3ImgPPIUrl = "";
			$s3ImgPPIUrl = PpiImgResizeAndUploadToS3($filePath,$imgName,'300','100', 'ppi');
		}else{
			$s3ImgPPIUrl = '';
		}	
		
		if($s3ImgLogoUrl!="")
		{
			if($selectedInvoiceID==0){
					//$invoiceDetails = getMarketplaceInvoices($selectedInvoiceID);
					$logourl = $s3ImgLogoUrl;
					$marketplacecode = $imgDetails['marketplaceCode'];
					$accountcode = $imgDetails['accountCode'];
					$couriercode = 1;
					
					//API to Update Logo Information
					$xml = new SimpleXMLExtended('<addinvoicelogoinformationrequest/>');
					$xml->usertoken = NULL;
					$xml->usertoken->addCData(stripslashes($imgDetails['usertoken']));
					$xml->dbcode = NULL; 
					$xml->dbcode = $imgDetails['dbcode'];	
					$xml->responsetype = NULL;
					$xml->responsetype->addCData("json");
					$invoicelogoChild = $xml->addChild("invoicelogo");
					$invoicelogoChild->couriercode = NULL;
					$invoicelogoChild->couriercode = $couriercode;					
					$invoicelogoChild->logourl = NULL;
					$invoicelogoChild->logourl->addCData(stripslashes($logourl));
					$invoicelogoChild->marketplacecode = NULL;
					$invoicelogoChild->marketplacecode = $marketplacecode;		
					$invoicelogoChild->accountcode = NULL;
					$invoicelogoChild->accountcode = $accountcode;	
					$invoicelogoChild->createdby = NULL;
					$invoicelogoChild->createdby = $imgDetails['usercode'];	
					$invoicelogoChild->ppistampurl = NULL;
					$invoicelogoChild->ppistampurl->addCData(stripslashes($s3ImgPPIUrl));
					
					$requestXml = $xml->saveXML();
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/InvoiceLogoInformation/AddInvoiceLogoInformation");

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
					
					$respArray = json_decode($result,true);
					
					//return $respArray;exit;
					echo json_encode(array('data'=>$respArray));exit;

			}else{
					$reqArray = array();
					$reqArray['selectedInvoiceID'] = $selectedInvoiceID;
					$reqArray['usertoken'] = $imgDetails['usertoken'];
					$reqArray['dbcode'] = $imgDetails['dbcode'];
					
					$invoiceDetails = getAllInvoice($reqArray);
					$logourl = $s3ImgLogoUrl;
					$pkinvoicelogoinformationcode = $invoiceDetails['invoicelogos'][0]['pkinvoicelogoinformationcode'];
					$couriercode = 1;//$invoiceDetails['invoicelogos'][0]['couriercode'];
					$marketplacecode = $invoiceDetails['invoicelogos'][0]['marketplacecode'];
					$accountcode = $invoiceDetails['invoicelogos'][0]['accountcode'];
					$active = ($invoiceDetails['invoicelogos'][0]['active'] == "True")? 1:0;
					
					//API to Update Logo Information
					$xml = new SimpleXMLExtended('<updateinvoicelogoinformationrequest/>');
					$xml->usertoken = NULL;
					$xml->usertoken->addCData(stripslashes($imgDetails['usertoken']));
					$xml->dbcode = NULL; 
					$xml->dbcode = $imgDetails['dbcode'];	
					$xml->responsetype = NULL;
					$xml->responsetype->addCData("json");
					$invoiceChild = $xml->addChild("invoicelogo");
					$invoiceChild->pkinvoicelogoinformationcode = NULL;
					$invoiceChild->pkinvoicelogoinformationcode = $pkinvoicelogoinformationcode;
					$invoiceChild->couriercode = NULL;
					$invoiceChild->couriercode = $couriercode;
					$invoiceChild->logourl = NULL;
					$invoiceChild->logourl->addCData(stripslashes($logourl));
					$invoiceChild->marketplacecode = NULL;
					$invoiceChild->marketplacecode = $marketplacecode;		
					$invoiceChild->accountcode = NULL;
					$invoiceChild->accountcode = $accountcode;	
					$invoiceChild->modifiedby = NULL;
					$invoiceChild->modifiedby = $imgDetails['usercode'];	
					$invoiceChild->active = NULL;
					$invoiceChild->active = $active;
					$invoiceChild->ppistampurl = NULL;
					$invoiceChild->ppistampurl->addCData(stripslashes($s3ImgPPIUrl));					

					$requestXml = $xml->saveXML();

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/InvoiceLogoInformation/UpdateInvoiceLogoInformation");

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
					
					$respArray = json_decode($result,true);
					
					//return $respArray;exit;
					echo json_encode(array('data'=>$respArray));exit;
			}
			
		}

		$failureMsgArray['statusmessage'] = 'Failed to update invoice template logo';
		//return $failureMsgArray; exit;
		echo json_encode(array('data'=>$failureMsgArray));exit;
		
	}
	
	
	
	function imageResizeAndUploadToS3($filePath,$imgName,$newwidth,$newwidth1)
	{
		$data =$filePath;
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$target_dir =  $_SERVER["DOCUMENT_ROOT"]."/php/customer/";
		file_put_contents($target_dir.$imgName.".jpeg", $data);
		$filePath = $target_dir.$imgName.".jpeg";
		
		$binary_data = file_get_contents($filePath);
		$src = imagecreatefromstring($binary_data);
		$width = imagesx($src);
		$height = imagesy($src);
		$newheight=$newwidth1;
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		$newheight1=$newwidth;
		$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
		
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
		imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
		
		$filename = $target_dir. $imgName.".jpeg";
		
		imagejpeg($tmp,$filename,100);
		imagedestroy($src);
		imagedestroy($tmp);
		imagedestroy($tmp1);
		
		if($filename!="")
		{
					#####################################
					/*** PRINT LABEL SECTION ***/
					//Instanciation of inherited class
					$pdf=new PDF();
					$pdf->AliasNbPages();
					
					$pdf->AddPage();
					$pdf->CreateLabels(208,295);//210,297
					$image = stripcslashes($filename);
					$pdf->AddHeaderInfo($image);
					$pdf->AddCustomerInvoiceAddress();
					$pdf->AddCustomerShipToAddress();
					$pdf->MarketplaceAccountDetails();
					$pdf->AddDescriptionDetails();
					$pdf->AddReturnAddress();
					
					$pdfFileName = "invoice".date("His").".pdf"; 
					$pdfFile = $pdf->Output($target_dir.$pdfFileName, 'F'); // To save the file
					
					$pdfImgName = $pdfFileName; 
					$pdfFilePath = $target_dir.$pdfFileName;
					$s3ImgUploadedData = uploadImgToS3('4m-valuecom-india',$pdfFilePath,$pdfImgName); 
					
					$s3ImgUploadedData1 = $s3ImgUploadedData->toArray();
					if($s3ImgUploadedData1['ObjectURL']!="")
					{
							unlink($filename);//delete logo image from local system
							unlink($pdfFilePath);//delete invoice pdf from local system
							return $userimageurl = $s3ImgUploadedData1['ObjectURL']; 									
					}

		}
	}
	
	function PpiImgResizeAndUploadToS3($filePath,$imgName,$newwidth,$newwidth1, $imgtype='logo')
	{
			$data = $filePath;
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			$target_dir =  $_SERVER["DOCUMENT_ROOT"]."/php/customer/";
			file_put_contents($target_dir.$imgName.".jpeg", $data);
			$filePath = $target_dir.$imgName.".jpeg";
			
			$filename = $target_dir. $imgName.".jpeg";
			
	
			if($filename!=""){
							
							#####################################
							/*** PRINT LABEL SECTION ***/
							//Instanciation of inherited class
							$image = stripcslashes($filename);//"D:\/Work\/htdocs\/247commerce\/customer\/20150130_212658.jpg";
														
							$pdfFileName = "invoice".$imgtype.date("His").".jpeg"; 
							//$pdfFile = $pdf->Output($target_dir.$pdfFileName, 'F'); // To save the file
							

							$s3ImgUploadedData = uploadImgToS3('4m-valuecom-india',$image,$pdfFileName); 
							$s3ImgUploadedData1 = $s3ImgUploadedData->toArray();
							if($s3ImgUploadedData1['ObjectURL']!="")
							{
									unlink($filename);//delete logo image from local system
									//unlink($pdfFilePath);//delete invoice pdf from local system
									return $userimageurl = $s3ImgUploadedData1['ObjectURL']; 									
							}
	
			}
	}
	
	function searchArrayVals($arraytoSearch, $marketplace, $account)
	{
		if(count($arraytoSearch)>0)
		{
			$returnArr = array();
			//echo "\n\n\n--Outside".$marketplace."---".$account['accountcode'];
			foreach($arraytoSearch as $innerVal)
			{
				if($innerVal['marketplacecode']==$marketplace && $innerVal['accountcode']==$account['accountcode'])
				{
					//echo "\n\nInside--".$innerVal['marketplacecode']."--".$innerVal['accountcode'];
					$returnArr[] = $innerVal;
					break;
				}
			}
			
			if(count($returnArr)==0)
			{
				$default_img_url = $_SERVER["DOCUMENT_ROOT"]."/php/img/put-your-log-here.png";
				$tempArr = array();
				$tempArr['pkinvoicelogoinformationcode'] = 0;
				$tempArr['logourl'] = $default_img_url;
				$tempArr['stampurl'] = $default_img_url;
				$tempArr['countrycode'] = $account['countrycode'];
				$tempArr['countryname'] = $account['countryname'];
				$tempArr['marketplacecode'] = $marketplace;
				$tempArr['marketplacename'] = $account['marketplacename'];
				$tempArr['accountcode'] = $account['accountcode'];
				$tempArr['accountname'] = $account['accountname'];
				$tempArr['createdby'] = '';
				$tempArr['createdon'] = '';
				$tempArr['modifiedby'] = '';
				$tempArr['modifiedon'] = '';
				$tempArr['active'] = 1;
				$returnArr[] = $tempArr;
			}
			return $returnArr;
		}
	}
	
	
	function getAllInvoiceWithPDFUrls($requestData)
	{ 
		$invoiceID = 0; //to get all invoices
		$xml = new SimpleXMLExtended('<getinvoicelogoinformationrequest/>');
		$xml->usertoken = NULL;
		$xml->usertoken->addCData(isset($requestData['usertoken']) ? stripslashes($requestData['usertoken']): NULL);
		$xml->dbcode = NULL; 
		$xml->dbcode = $requestData['dbcode'];	
		$xml->responsetype = NULL;
		$xml->responsetype->addCData("json");
		$xml->pkinvoicelogoinformationcode = NULL;
		$xml->pkinvoicelogoinformationcode = $invoiceID;

		$requestXml = $xml->saveXML();
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/ShippingCouriersConfiguration/api/InvoiceLogoInformation/GetInvoiceLogoInformation");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		$respArray = json_decode($result,true);
		//echo $_SERVER["DOCUMENT_ROOT"];exit;
		$default_img_url = $_SERVER["DOCUMENT_ROOT"]."/php/img/put-your-log-here.png";
		//echo "<pre>";
		$invoiceLogosRespArr = array();
		if(isset($respArray['statuscode']) && $respArray['statuscode']==0)  
		{
			//get Amazon Accounts
			$amazonAcctsResp = isset($requestData['amazonAccounts']['accounts']) ? $requestData['amazonAccounts']['accounts']: array();
			if(count($amazonAcctsResp)>0)
			{
				foreach($amazonAcctsResp as $amzAcct)
				{
					//print_r($amzAcct);exit;
					$accountArr = array();
					$accountArr['accountcode'] = $amzAcct['pkamzaccountcode']; 
					$accountArr['accountname'] = $amzAcct['amzaccountname']; 
					$accountArr['countrycode'] = $amzAcct['countrycode']; 
					$accountArr['countryname'] = $amzAcct['countryname']; 
					$accountArr['marketplacename'] = 'Amazon'; 
					$searchedAmzVal = array();
					$searchedAmzVal = searchArrayVals($respArray['invoicelogos'], 2, $accountArr);
					$invoiceLogosRespArr['invoices'][] = $searchedAmzVal[0];
				}
			}
		
			//get eBay Accounts
			$ebayAcctsRes= array();
			$ebayAcctsResp  = isset($requestData['ebayAccounts']['ebayaccounts']) ? $requestData['ebayAccounts']['ebayaccounts'] : array();
			if(count($ebayAcctsResp)>0)
			{
				foreach($ebayAcctsResp as $ebayAcct)
				{
					$accountArr = array();
					$accountArr['accountcode'] = $ebayAcct['pkebayaccountcode']; 
					$accountArr['accountname'] = $ebayAcct['ebayaccountname']; 
					$accountArr['countrycode'] = $ebayAcct['countrycode']; 
					$accountArr['countryname'] = $ebayAcct['countryname']; 
					$accountArr['marketplacename'] = 'eBay'; 
					$searchedeBayVal = array();
					$searchedeBayVal = searchArrayVals($respArray['invoicelogos'], 1, $accountArr);
					$invoiceLogosRespArr['invoices'][] = $searchedeBayVal[0];
				}
			}

			//print_r($invoiceLogosRespArr);
			if(isset($invoiceLogosRespArr['invoices']) && count($invoiceLogosRespArr['invoices'])>0)
			{
				foreach($invoiceLogosRespArr['invoices'] as $key=>$logoDetails)
				{
					$logourl = (isset($logoDetails['logourl']) && $logoDetails['logourl']!=='') ? $logoDetails['logourl']: $default_img_url;
					//$serverFullPath = $_SERVER['SERVER_NAME'];
					$target_dir = $_SERVER["DOCUMENT_ROOT"]."/php/customer/invoicelabels/";	
					$pdfFileName = "invoicelabel_".$requestData['dbcode']."_".$logoDetails['marketplacecode']."_".$logoDetails['accountcode'].".pdf"; 					
					//createInvoicePDF($logourl, $target_dir.$pdfFileName);
					$pdf=new PDF();
					$pdf->AliasNbPages();
					
					$pdf->AddPage();
					$pdf->CreateLabels(208,295);//210,297
					$image = stripcslashes($logourl);
					$pdf->AddHeaderInfo($image);
					$pdf->AddCustomerInvoiceAddress();
					$pdf->AddCustomerShipToAddress();
					$pdf->MarketplaceAccountDetails();
					$pdf->AddDescriptionDetails();
					$pdf->AddReturnAddress();
					
					$pdfFile = $pdf->Output($target_dir.$pdfFileName, 'F'); // To save the file
					//$serverFullPath = $_SERVER['SERVER_NAME'];
					$target_dir = "/customer/invoicelabels/";	
					$invoiceLogosRespArr['invoices'][$key]['invoicepdfurl'] = $target_dir.$pdfFileName;
				}
				$invoiceLogosRespArr['statuscode'] = 0;
				$invoiceLogosRespArr['statusmessage'] = 'success';
			}
		}else if(isset($respArray['statuscode']) == '-1' || count(isset($ebayAcctsResp))==0 || count(isset($amazonAcctsResp)) ==0)
		// else if(response.data.statuscode == '-1' || count($ebayAcctsResp)==0 || count($amazonAcctsResp) ==0)
		{
				$invoiceLogosRespArr['statuscode'] = 404;
				$invoiceLogosRespArr['statusmessage'] = 'No Marketplace Account found. Please add a Marketplace Account to Apply Invoice Design Changes.';
		}else{
				$invoiceLogosRespArr['statuscode'] = $respArray['statuscode'];
				$invoiceLogosRespArr['statusmessage'] = $respArray['statusmessage'];
		}
	//	print_r($invoiceLogosRespArr);exit;
	
		//return $invoiceLogosRespArr;
		echo json_encode(array('data'=>$invoiceLogosRespArr));
		
		/*if($respArray['statuscode']==0)
		{
			if(count($respArray['invoicelogos'])>0)
				echo "<br/><br/><br/>".count($respArray['invoicelogos']);
		}
		exit;
		return $respArray;*/
	}
	//END - Marketplace Invoices
	
	function sendEmailReport($reqArray)
	{	
		$marketplace = "Amazon";
		if(isset($reqArray['marketplace'])) $marketplace = $reqArray['marketplace'];
		$emails = explode(";", $reqArray['emails']);

				require_once('login/PHPMailer/PHPMailerAutoload.php');
				
				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'auth.smtp.1and1.co.uk';                       // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'notifications@247cloudhub.co.uk';                   // SMTP username
				$mail->Password = 'notifications247*';               // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
				$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
				$mail->setFrom('notifications@247cloudhub.co.uk', '247Cloudhub');     //Set who the message is to be sent from
				
				if(count($emails)==1)
					$mail->addAddress(trim($emails[0]));  // Add a recipient
				else{
					foreach($emails as $email)
					{
						$mail->addAddress(trim($email));  // Add a recipient
					}
				}
			
				
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = '247Cloudhub '.$marketplace.' Tools Product Data Report';
				$mail->Body    = $marketplace .'Tools Product Data Report';
				$mail->AltBody = $marketplace .'Tools Product Data Report';
				$mail->msgHTML('<html>
								<head>
								<title>247Cloudhub $marketplace Tools Product Data Report</title>
								</head>
								<body>
								<div class="mailCreateUser">
									'.$marketplace.' Tools Product Data Report can be download from the below link: <br/><br/><a href="'.$reqArray["hiddenurl"].'">Download Product Data</a></a>
									<br />
									</div>
								</div>	
								</body>
								</html>');
				$mail->send();
		
		$responseArray = array();
		$responseArray['statusmessage']='success';
		$responseArray['statuscode']=0;
		echo json_encode($responseArray);
		
	}
	
	function sendAmazonSubmitFeedInfo($requestData)
	{
		//print_r($requestData);
		
		$curLocation = getcwd();
		$filename = $curLocation."/amzcataloguedata".date("YmdHis").".txt";
		/*if (file_exists($filename)) {
			unlink($filename);
		}*/
		
		$myfile = @fopen($filename, "w") or die("Unable to open file!");
		fwrite($myfile, $requestData['content']);
		//fwrite($myfile, "some message");
		
		chmod($filename, 0777);
		
		$s3ImgUploadedData = uploadAmzCatalogueToS3('',$filename, 'amzcataloguedata'.date("YmdHis").'.txt'); 

		//print_r($s3ImgUploadedData['ObjectURL']);//exit;
		if(isset($s3ImgUploadedData['ObjectURL']) && $s3ImgUploadedData['ObjectURL']!='')
		{
				/*if (file_exists($filename)) {
							unlink($filename);
				}*/

				$xml = new SimpleXMLExtended('<submitamazoncataloguerequest/>');
				$xml->dbcode = NULL;
				$xml->dbcode = $requestData['dbcode'];
				$xml->usertoken = NULL;
				$xml->usertoken->addCData(stripslashes($requestData['usertoken']));
				$xml->responsetype = NULL;
				$xml->responsetype->addCData("json");
				$xml->accountcode = NULL;
				$xml->accountcode->addCData($requestData['accountcode']);
				$xml->accesskey = NULL;
				$xml->accesskey->addCData($requestData['accesskey']);
				$xml->secretkey = NULL;
				$xml->secretkey->addCData($requestData['secretkey']);
				$xml->sellerid = NULL;
				$xml->sellerid->addCData($requestData['sellerid']);
				$xml->marketplaceid = NULL;
				$xml->marketplaceid->addCData($requestData['marketplaceid']);
				$xml->serviceurl = NULL;
				$xml->serviceurl->addCData($requestData['serviceurl']);
				$xml->mwsauthtoken = NULL;
				$xml->mwsauthtoken->addCData($requestData['mwsauthtoken']);
				$xml->s3fileurl = NULL;
				$xml->s3fileurl->addCData($s3ImgUploadedData['ObjectURL']);
				
				$requestXml = $xml->saveXML();// exit;
				

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://".COMPETEAPIURL."/InventoryApi/api/Amazon/SubmitAmazonCatalogueDetails");

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$responseArray= json_decode($result,true);

				echo json_encode($responseArray);
		}
		fclose($myfile);
	}
	
	function changeStatus()
	{ 
		$xml = new SimpleXMLExtended('<RegistereBayNotifications/>');
		$xml->NotificationUrl = NULL;
		$xml->NotificationUrl->addCData(stripslashes("http://ebaynotifications.247commerce.com/ReceiveeBayNotifications/api/ReceiveeBayNotifications/ReceiveeBayNotifications"));
		
		$notificationcode = $xml->addChild("Notificationcode");
		$notificationcode->Notificationcode = 'FixedPriceTransaction';
		$notificationcode->Notificationcode = 'ItemClosed';
		$notificationcode->Notificationcode = 'ItemListed';
		$notificationcode->Notificationcode = 'ItemSold';
		$notificationcode->Notificationcode = 'ItemRevised';
		$notificationcode->Notificationcode = 'TokenRevocation';
		$notificationcode->Notificationcode = 'AccountSuspended';
		
		
		$requestXml = $xml->saveXML();   //http://winserver2012/RegistereBayNotifications/SubscribeeBayNotifications

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".APIURL."/RegistereBayNotifications/SubscribeeBayNotifications");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
		
		$respArray = json_decode($result,true);
		//return $respArray;
		echo json_encode($respArray);
	}
	
	/*
	function getSellerDBConnection(){
			$hostname = 'sellerdb.co13c6zl8ys8.eu-west-1.rds.amazonaws.com';
			$username = 'backend';
			$passwd = '24jA(kBauer587%^';
			$vendorDBName = '247C1040';
	
			//START - Connection details for vendor DB
			$vendorConInfo = array( "Database"=>$vendorDBName, "UID"=>$username, "PWD"=>$passwd);
			$vendorConn = sqlsrv_connect( $hostname, $vendorConInfo);
			if( $vendorConn === false ) {
				die( print_r( sqlsrv_errors(), true ));
			}

			// Begin the transaction. 
			if ( sqlsrv_begin_transaction( $vendorConn ) === false ) {
				 die( print_r( sqlsrv_errors(), true ));
			}else  return $vendorConn;
			//END - Connection details for vendor DB
	}
	
	function getQtyOnBinLocations($requestArray)
	{
			$fromPage = (isset($requestArray['fromPage']) && $requestArray['fromPage']>0) ? $requestArray['fromPage'] : 0;
			$toCnt = (isset($requestArray['toCnt']) && $requestArray['toCnt']>0) ? $requestArray['toCnt'] : 10;
			$shelfCode = (isset($requestArray['shelfCode']) && $requestArray['shelfCode']>0) ? $requestArray['shelfCode'] : 0;
			
			$vendorConn = getSellerDBConnection();
			//print_r($vendorConn);exit;
			//$getQtyBinlocationsQry = "SELECT COUNT(1) as totalCnt FROM quantityonbinlocation; SELECT qtybin.PKBinLocationQtyCode, qtybin.FKBinLocationCode, qtybin.SKU, qtybin.EAN,qtybin.Quantity, inv.ProductName FROM quantityonbinlocation qtybin, Inventory inv WHERE inv.SKU  COLLATE Latin1_General_CS_AS=qtybin.SKU ORDER BY SKU DESC OFFSET $fromPage ROWS FETCH NEXT $toCnt ROWS ONLY";//exit;
			$getQtyBinlocationsQry = "SELECT  COUNT(QB.PKBinLocationQtyCode) as totalCnt from quantityonbinlocation QB inner JOIN BinLocation B ON B.PKBinLocationCode=QB.FKBinLocationCode WHERE B.FKShelfCode=$shelfCode;";
			$getQtyBinlocationsQry .= "SELECT  QB.PKBinLocationQtyCode, QB.FKBinLocationCode, QB.SKU, QB.EAN,QB.Quantity,I.productname FROM quantityonbinlocation QB INNER JOIN BinLocation B ON B.PKBinLocationCode=QB.FKBinLocationCode LEFT JOIN inventory I on I.SKU COLLATE Latin1_General_CS_AS=QB.SKU WHERE B.FKShelfCode=$shelfCode ORDER BY SKU DESC OFFSET $fromPage ROWS FETCH NEXT $toCnt ROWS ONLY";//exit;
			
			//echo $getQtyBinlocationsQry;
			$stmtQtyBinLocs = sqlsrv_query( $vendorConn, $getQtyBinlocationsQry );
			if( $stmtQtyBinLocs === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$responseArray = array();
			
					// Set up the proc params array - be sure to pass the param by reference
					// /*$procedure_params = array(
						// array(&$fromPage, SQLSRV_PARAM_IN),
						// array(&$toCnt, SQLSRV_PARAM_IN)
					// );
						
						// echo $sql = "EXEC sp_getBinlocationStockDetails 0,10";

						// $stmt = sqlsrv_query($vendorConn, $sql);

						// if( !$stmt ) {
								// die( print_r( sqlsrv_errors(), true));
						// }
//echo "<pre>";
						//if(sqlsrv_execute($stmt)){
						 
						  
						  do {
							   while ($row = sqlsrv_fetch_array($stmtQtyBinLocs, SQLSRV_FETCH_ASSOC)) {
								   // Loop through each result set and add to result array
								  // $result[] = $row;
								  // print_r($row);
								   if(isset($row['totalCnt']) && $row['totalCnt']>0) $responseArray['totalRecords'] = $row['totalCnt'];
								   elseif(!isset($row['totalCnt']))
									   $responseArray['bindetails'][] = $row;
							   }
							} while (sqlsrv_next_result($stmtQtyBinLocs));


						  //exit;
						  // Output params are now set,
						 // print_r($params);
						 // print_r($myparams);
						



			// /*while($row = sqlsrv_fetch_array( $stmtQtyBinLocs, SQLSRV_FETCH_ASSOC)) 
			// {
				// $responseArray['bindetails'][] = $row;
			// }
			
			sqlsrv_close($vendorConn);
			
			if(!isset($responseArray['bindetails']) || count($responseArray['bindetails'])<=0) 
			{
				$responseArray['statusmessage'] = 'Bin locations Not Found'; 
				$responseArray['statuscode'] = 404; 
			}elseif(isset($responseArray['bindetails'])){
				$responseArray['statusmessage'] = 'Success'; 
				$responseArray['statuscode'] = 0; 
			}
			
			//print_r($responseArray);exit;
			header('Content-type: application/json');
			echo json_encode($responseArray); 
		
	}*/

	function geteBaySuggestedCategories($dataArray)
	{
		$prodTitle = $dataArray['prodTitle'];
		$selAcctID = $dataArray['selAcctID'];
		$arrsplcharacter = array("Â ","Â¡","Â¢","Â£","Â¥","Â§","Â¨","Â©","Â«","Â¬","Â®","Â°","Â±","Â´","Âµ","Â¶","Â·","Â¸","Â»","Â¿","Ã€","Ã","Ã‚","Ãƒ","Ã„","Ã…","Ã†Ã‡","Ãˆ","Ã‰","ÃŠ","Ã‹","ÃŒ","Ã","ÃŽ","Ã","Ã‘","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã™","Ãš","Ã›","Ãœ","ÃŸ","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã¦","Ã§","Ã¨","Ã©","Ãª","Ã«","Ã¬","Ã­","Ã®","Ã¯","Ã±","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¶","Ã·","Ã¸","Ã¹","Ãº","Ã»","Ã¼","Ã¿","â€š","Æ’","â€ž","â€¦","â€ ","â€¡","Ë†","â€°","â€¹","Å’","â€˜","â€™","â€œ","â€","â€¢","â€“","â€”","Ëœ","â„¢","â€º","Å“","Å¸","?");
		$arrcode = array("&nbsp;","&iexcl;","&cent;","&pound;","&yen;","&sect;","&uml;","&copy;","&laquo;","&not;","&reg;","&deg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&raquo;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yuml;","&#8218;","&#402;","&#8222;","&#8230;","&#8224;","&#8225;","&#710;","&#8240;","&#8249;","&#338;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8211;","&#8212;","&#732;","&#8482;","&#8250;","&#339;","&#376;","&#322;");
		
		// $siteID = 3;

		$siteID='';
		if(isset( $dataArray['selSiteID']) &&  $dataArray['selSiteID']!=''){
			$siteID = $dataArray['selSiteID'];
		}else{
			$siteID = 3;
		}

		$ebayLiveToken='';
		if(isset( $dataArray['selLiveToken']) &&  $dataArray['selLiveToken']!=''){
			$ebayLiveToken = $dataArray['selLiveToken'];
		}else{
			$ebayLiveToken = '';
		}

		

		$verb = "GetSuggestedCategories";
		$devID = "cefa7552-3427-41d3-9cd0-c6ff7f82659e";
		$certID = "cda174f4-9bc1-428e-94a4-4115789aaffe";
		$appID = "247Topse-e9af-4f05-84c8-66acd9493b2b";
		$compatLevel = 445;
		
		$userToken = $ebayLiveToken;
		//"AgAAAA**AQAAAA**aAAAAA**KeULVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkYOkDpSGpAydj6x9nY+seQ**QvsAAA**AAMAAA**WPX8In+kMR3Gxh7rFbp+vAcKCuBhcbNLfAea7pOlNCGFGIGfG8DGjVY1QD82lYGH0y0Iq3p5G4Aa4WhIP0pNdZkqiYTLLPBrcv1lf1wYPbqLS88W5RJJaVi2quTPxMWu9VU46doEC764248GKNckWFmoUG16YhZrkL63gXLEaQqEiRzLNzYrWvD+7Sc/nKQjXDmh9wm7qoauElyJ1wBDQ0w5WSIWICyvsgdvbMQxJf8mQZRAbVPSnSRpByp+qqeqLkowVbWVO9ues/FltE3GwpI3V0b2CaRytIQ7SvsOyT5o6zyBDo0N1Xo3kYoUQIlxnocJtr6BijoTbw1zpHH04r4GoJ7BTkIlB80DWZugYPC8LSZgDnt0D0zVFngpZ4S4l8qn11aOlGCxRUMWQ5KMM+nzY99+7feWCeuzq0tMxv9IkxmAV3v6eMX1hAC7RDOm2/OG3A36AbhRfPY04HjXLdZdEmBvG2VJW37KFIwO6Hfxqsmw6P3BF6B8trsYqpEh3+4lxWxfPKeDoMeu91ruU/+MjrKUPPrfuJfhjHWtTS5LCLn83vLBOspe4qWpFkriKPS6KWMuWsbrRGlLpimkPn3FhvHXOJtd+ovvM+/f3cullWMTr7DnzG3pqXjMGCyh7LybaADyMcWsJhjVl7B1BNiqfjqs42wb8IL7xyfRT6b96ItOzvQUvObplSXlPqQJ9f4Hnz/20beE23QycjGGvMoWj3pQGbz9SDM5+U5bvAsfojW6+7Tu9zTv+SWHX9GA";		
		$query = $prodTitle;
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatLevel,
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devID,
			'X-EBAY-API-APP-NAME: ' . $appID,
			'X-EBAY-API-CERT-NAME: ' . $certID,
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $verb,			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $siteID,
		);
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken><![CDATA[$userToken]]></eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= "<Query><![CDATA[$query]]></Query>";
		$requestXmlBody .= '</GetSuggestedCategoriesRequest>';
		
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		//Send the Request
		$response = curl_exec($connection);
		
		$respXML = simplexml_load_string($response); 
	
		$responseArray = array();

		try
        {    
           if($respXML->Ack == "Success")
           {
				$suggestedCategories = $respXML->SuggestedCategoryArray->SuggestedCategory;
				$i=0;
				if($respXML->CategoryCount>0){
						foreach($suggestedCategories as $category){
							$leafCategory       = $category->Category->CategoryName;
							$leafCategoryID     = $category->Category->CategoryID;
							$parentCategories   = $category->Category->CategoryParentName;
							$percentageFound = $category->PercentItemFound;
							if(is_array($parentCategories))
								$categoryBreadCrumb = implode(' >> ', $parentCategories).' >> '.$leafCategory;
							else
								$categoryBreadCrumb = $parentCategories.' >> '.$leafCategory;
			
							$categoryBreadCrumb = str_replace($arrsplcharacter,$arrcode, $categoryBreadCrumb);
							
							$responseArray['statuscode'] = 0;
							$responseArray['categories'][$i]['categoryName'] = $categoryBreadCrumb;
							$responseArray['categories'][$i]['categoryID'] = (string)$leafCategoryID;
							$responseArray['categories'][$i]['percentageFound'] = (string)$percentageFound;
							$i++;
						}
				}else {
					 $responseArray['statuscode'] = 404;
					 $responseArray['statusmessage'] = "Category Not Found!!!";
				}

		   } else
           {
			  // echo '<pre>';print_r((array)$respXML->Errors->LongMessage);
			   if(isset($respXML->Errors)){
					 if(isset($respXML->Errors->LongMessage)){
						 $tmpLongmsg = (array)$respXML->Errors->LongMessage;
						 $responseArray['statusmessage'] = $tmpLongmsg[0];
					 }else 
						 $responseArray['statusmessage'] = "Category Not Found Error!!!";
			   }else
					$responseArray['statusmessage'] = "Category Not Found Error!!!";
			
			   $responseArray['statuscode'] = 404;
			   //$responseArray['statusmessage'] = $respXML->Errors[1]->LongMessage;
           }
       }
       catch (Exception $ex)
       {
            $responseArray['statuscode'] = 404;
		    $responseArray['statusmessage'] = "Something went wrong!!!";
       }

		//close the connection
		curl_close($connection);
		
		//return the response
		//return $responseArray;
		echo json_encode(array('data'=>$responseArray));
	}

	function geteBayItemSpecifics($dataArray)
	{
		$selAcctID = $dataArray['selAcctID'];
		$eBayCategory1 = $dataArray['eBayCategory1'];
		$arrsplcharacter = array("Â ","Â¡","Â¢","Â£","Â¥","Â§","Â¨","Â©","Â«","Â¬","Â®","Â°","Â±","Â´","Âµ","Â¶","Â·","Â¸","Â»","Â¿","Ã€","Ã","Ã‚","Ãƒ","Ã„","Ã…","Ã†Ã‡","Ãˆ","Ã‰","ÃŠ","Ã‹","ÃŒ","Ã","ÃŽ","Ã","Ã‘","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã™","Ãš","Ã›","Ãœ","ÃŸ","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã¦","Ã§","Ã¨","Ã©","Ãª","Ã«","Ã¬","Ã­","Ã®","Ã¯","Ã±","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¶","Ã·","Ã¸","Ã¹","Ãº","Ã»","Ã¼","Ã¿","â€š","Æ’","â€ž","â€¦","â€ ","â€¡","Ë†","â€°","â€¹","Å’","â€˜","â€™","â€œ","â€","â€¢","â€“","â€”","Ëœ","â„¢","â€º","Å“","Å¸","?");
		$arrcode = array("&nbsp;","&iexcl;","&cent;","&pound;","&yen;","&sect;","&uml;","&copy;","&laquo;","&not;","&reg;","&deg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&raquo;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yuml;","&#8218;","&#402;","&#8222;","&#8230;","&#8224;","&#8225;","&#710;","&#8240;","&#8249;","&#338;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8211;","&#8212;","&#732;","&#8482;","&#8250;","&#339;","&#376;","&#322;");
		
		// $siteID = 3;
		$siteID='';
		if(isset( $dataArray['selSiteID']) &&  $dataArray['selSiteID']!=''){
			$siteID = $dataArray['selSiteID'];
		}else{
			$siteID = 3;
		}

		$ebayLiveToken='';
		if(isset( $dataArray['selLiveToken']) &&  $dataArray['selLiveToken']!=''){
			$ebayLiveToken = $dataArray['selLiveToken'];
		}else{
			$ebayLiveToken = '';
		}
		
		$verb = "GetCategorySpecifics";
		$devID = "cefa7552-3427-41d3-9cd0-c6ff7f82659e";
		$certID = "cda174f4-9bc1-428e-94a4-4115789aaffe";
		$appID = "247Topse-e9af-4f05-84c8-66acd9493b2b";
		$compatLevel = 793;
		$userToken = $ebayLiveToken;
		//"AgAAAA**AQAAAA**aAAAAA**KeULVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkYOkDpSGpAydj6x9nY+seQ**QvsAAA**AAMAAA**WPX8In+kMR3Gxh7rFbp+vAcKCuBhcbNLfAea7pOlNCGFGIGfG8DGjVY1QD82lYGH0y0Iq3p5G4Aa4WhIP0pNdZkqiYTLLPBrcv1lf1wYPbqLS88W5RJJaVi2quTPxMWu9VU46doEC764248GKNckWFmoUG16YhZrkL63gXLEaQqEiRzLNzYrWvD+7Sc/nKQjXDmh9wm7qoauElyJ1wBDQ0w5WSIWICyvsgdvbMQxJf8mQZRAbVPSnSRpByp+qqeqLkowVbWVO9ues/FltE3GwpI3V0b2CaRytIQ7SvsOyT5o6zyBDo0N1Xo3kYoUQIlxnocJtr6BijoTbw1zpHH04r4GoJ7BTkIlB80DWZugYPC8LSZgDnt0D0zVFngpZ4S4l8qn11aOlGCxRUMWQ5KMM+nzY99+7feWCeuzq0tMxv9IkxmAV3v6eMX1hAC7RDOm2/OG3A36AbhRfPY04HjXLdZdEmBvG2VJW37KFIwO6Hfxqsmw6P3BF6B8trsYqpEh3+4lxWxfPKeDoMeu91ruU/+MjrKUPPrfuJfhjHWtTS5LCLn83vLBOspe4qWpFkriKPS6KWMuWsbrRGlLpimkPn3FhvHXOJtd+ovvM+/f3cullWMTr7DnzG3pqXjMGCyh7LybaADyMcWsJhjVl7B1BNiqfjqs42wb8IL7xyfRT6b96ItOzvQUvObplSXlPqQJ9f4Hnz/20beE23QycjGGvMoWj3pQGbz9SDM5+U5bvAsfojW6+7Tu9zTv+SWHX9GA";
		//$query = $prodTitle;
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compatLevel,
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devID,
			'X-EBAY-API-APP-NAME: ' . $appID,
			'X-EBAY-API-CERT-NAME: ' . $certID,
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $verb,			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $siteID,
		);
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
		$requestXmlBody .= "<CategorySpecific><CategoryID><![CDATA[".$eBayCategory1."]]></CategoryID></CategorySpecific>";
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken><![CDATA[".$userToken."]]></eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= '</GetCategorySpecificsRequest>';
		//echo $requestXmlBody;exit;
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		//Send the Request
		$response = curl_exec($connection);
		
		//$rawAttributeXml 	= preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		
		$xmlToArray = simplexml_load_string($response); 

		$responseArray = array();

		try
        {    
			if(is_object($xmlToArray))
			{
				   if($xmlToArray->Ack == "Success")
				   {
					   if($xmlToArray->Recommendations!=='')
						{   
							$responseArray['statuscode'] = 0;
							$responseArray['itemspecifics'] = $xmlToArray->Recommendations;
							/*foreach($xmlToArray->Recommendations->NameRecommendation as $itemKey=>$itemArray)
							{
								$responseArray['itemspecifics'][]['Name'] = $itemArray->Name;
								$recommendValsArr = array();
								echo "<br/><br/>".$itemKey;
								$valRecommendations = '';
								$valRecommendations = $itemArray->ValueRecommendation;
								print_r($valRecommendations);
								if(is_array($valRecommendations))
								{
									foreach($valRecommendations as $valueRecommend);
									{
										print_r($valueRecommend);
										//$recommendValsArr[] = $valueRecommend->Value;	
										//$valueRecommend;
										//echo "dddd";
									}exit;
								}
								$responseArray['itemspecifics'][]['RecommendVals'] = $recommendValsArr;
							}*/
						}else {
							 $responseArray['statuscode'] = 404;
							 $responseArray['statusmessage'] = "Category Not Found!!!";
						}

				   } else
				   {
					   //echo '<pre>'; print_r($respXML->Errors[1]->LongMessage); 
					   $responseArray['statuscode'] = 404;
					   $responseArray['statusmessage'] = $xmlToArray->Errors[0]->LongMessage;
				   }
			}else{
					$responseArray['statuscode'] = 404;
					$responseArray['statusmessage'] = "Error";
			}
         
       }
       catch (Exception $ex)
       {
            $responseArray['statuscode'] = 404;
		    $responseArray['statusmessage'] = "Something went wrong!!!";
       }

		//close the connection
		curl_close($connection);
		//return the response
		//return $responseArray;
		echo json_encode(array('data'=>$responseArray));
	}
	
	
?>