<?php

	function execute_ebay_api_request($header,$post_details,$url){

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		if(count($post_details) > 0){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_details);
		}

		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$res = curl_exec($ch);
		////echo curl_error($ch);
		curl_close($ch);
		return $res;
	
	}

	$header=array(
		'Content-Type: application/json',
	);

	$api_base_url = 'https://showcase.247cloudhub.co.uk/ebayapis/ebay_data/cron/';

	//for seller profile api	
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-seller-profiles.php');
	echo "1==> ".$res."<br />";
	
	//for seller profile api
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-seller-dashboard.php');
	echo "2==> ".$res."<br />";

	//for recommendation summary
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php');
	echo "3==> ".$res."<br />";

	//for listing recommendation by type
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=eTRS');
	echo "4==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=ItemSpecifics');
	echo "5==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=ProductIdentifier');
	echo "6==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Picture');
	echo "7==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Price');
	echo "8==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Title');
	echo "9==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=FnF');
	echo "10==> ".$res."<br />";

	//**** for recommendation by type & itemid not required, will be on the fly api call
	
	//for listing violations all
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php');
	echo "11==> ".$res."<br />";

	//for listing violations by type
	execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=HTTPS');
	echo "12==> ".$res."<br />";

	execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=OUTSIDE_EBAY_BUYING_AND_SELLING');
	echo "13==> ".$res."<br />";

	execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=PRODUCT_ADOPTION');
	echo "14==> ".$res."<br />";

	execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=RETURNS_POLICY');
	echo "15==> ".$res."<br />";

	execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=PRODUCT_ADOPTION_CONFORMANCE');
	echo "16==> ".$res."<br />";
?>