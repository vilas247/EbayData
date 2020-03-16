<?php
error_reporting(0);

ini_set('max_execution_time', 0);
require_once("login/sha256.inc.php"); 
	function removeSpecialCharsNew($text)
	{
		$arrsplcharacter =array("Â ","Â¡","Â¢","Â£","Â¥","Â§","Â¨","Â©","Â«","Â¬","Â®","Â±","Â´","Âµ","Â¶","Â·","Â¸","Â»","Â¿","Ã€","Ã�","Ã‚","Ãƒ","Ã„","Ã…","Ã†Ã‡","Ãˆ","Ã‰","ÃŠ","Ã‹","ÃŒ","Ã�","ÃŽ","Ã�","Ã‘","Ã’","Ã“","Ã”","Ã•","Ã–","Ã˜","Ã™","Ãš","Ã›","Ãœ","ÃŸ","Ã ","Ã¡","Ã¢","Ã£","Ã¤","Ã¥","Ã¦","Ã§","Ã¨","Ã©","Ãª","Ã«","Ã¬","Ã­","Ã®","Ã¯","Ã±","Ã²","Ã³","Ã´","Ãµ","Ã¶","Ã¶","Ã·","Ã¸","Ã¹","Ãº","Ã»","Ã¼","Ã¿","â€š","Æ’","â€ž","â€¦","â€ ","â€¡","Ë†","â€°","â€¹","Å’","â€˜","â€™","â€œ","â€�","â€¢","â€“","â€”","Ëœ","â„¢","â€º","Å“","Å¸","Âº");
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
			//echo $requestURL;//exit;
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
						/*$respArray['prodBrand'] = $parsed_xml->Items->Item->ItemAttributes->Brand;
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
						}*/
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
					
					//echo json_encode(array('data'=>$respArray));
					return $respArray;
					//$callback = 'myfun';
					//echo $callback."(".json_encode(array('events'=>$respArray)).")";
	}

	$dataArray = array();
	
	

 	 $myfile = fopen("asinslist.txt", "r") or die("Unable to open file!");
	 $ASINSARRAY = array();
	 while(!feof($myfile)) 
	 {
		$AsinArray[] = fgets($myfile);
	 }
	 echo "<pre><table border='1'>";
	 echo "<tr><td>ASIN</td><td>EAN</td></tr>";
 foreach($AsinArray as  $asin)
 {
	 //echo "".$asin;
	 $dataArray['searchKeywordType'] = "ASIN";
	 $dataArray['searchKeyword'] = trim($asin);
	// print_r($dataArray);
	sleep(1);
	//echo "<br/>SLEEPING".date("H:i:s");
	 $responseArr = getAmazonProductInfo($dataArray);
	// print_r($responseArr);
	 echo "<tr><td>".$asin."</td><td>".$responseArr['prodEAN']."</td></tr>";
 }
 echo "</table>";
 echo "Completed";
?>
