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

	if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
		$seller_ebay_id = $_GET['seller_ebay_id'];
	}
	else {
		echo "ebay seller id is missing"; exit;
	}

	$header=array(
		'Content-Type: application/json',
	);

	$api_base_url = 'https://showcase.247cloudhub.co.uk/ebayapis/ebay_data/cron/';

	//for user profile api	
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-user-profile.php?seller_ebay_id='.$seller_ebay_id);
	echo "1==> ".$res."<br />";

	//for seller profile api	
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-seller-profiles.php?seller_ebay_id='.$seller_ebay_id);
	echo "1==> ".$res."<br />";
	
	//for seller dashboard api
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-seller-dashboard.php?seller_ebay_id='.$seller_ebay_id);
	echo "2==> ".$res."<br />";

	//for recommendation summary
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?seller_ebay_id='.$seller_ebay_id);
	echo "3==> ".$res."<br />";

	//for listing recommendation by type
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=eTRS&seller_ebay_id='.$seller_ebay_id);
	echo "4==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=ItemSpecifics&seller_ebay_id='.$seller_ebay_id);
	echo "5==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=ProductIdentifier&seller_ebay_id='.$seller_ebay_id);
	echo "6==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Picture&seller_ebay_id='.$seller_ebay_id);
	echo "7==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Price&seller_ebay_id='.$seller_ebay_id);
	echo "8==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=Title&seller_ebay_id='.$seller_ebay_id);
	echo "9==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-recommendations-summary.php?type=FnF&seller_ebay_id='.$seller_ebay_id);
	echo "10==> ".$res."<br />";

	//**** for recommendation by type & itemid not required, will be on the fly api call
	
	//for listing violations all
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?seller_ebay_id='.$seller_ebay_id);
	echo "11==> ".$res."<br />";

	//for listing violations by type
	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=HTTPS&seller_ebay_id='.$seller_ebay_id);
	echo "12==> ".$res."<br />";

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=OUTSIDE_EBAY_BUYING_AND_SELLING&seller_ebay_id='.$seller_ebay_id);
	echo "13==> ".$res."<br />";

	/*$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=PRODUCT_ADOPTION&seller_ebay_id='.$seller_ebay_id);
	echo "14==> ".$res."<br />";*/

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=RETURNS_POLICY&seller_ebay_id='.$seller_ebay_id);
	echo "14==> ".$res."<br />";

	/*$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=PRODUCT_ADOPTION_CONFORMANCE&seller_ebay_id='.$seller_ebay_id);*/

	$res = execute_ebay_api_request($header, array(), $api_base_url.'set-listing-violations.php?type=ASPECTS_ADOPTION&seller_ebay_id='.$seller_ebay_id);

	echo "15==> ".$res."<br />";
?>