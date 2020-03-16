<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}
$inventory_tabs = array();
if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken']; 
	
	$api_url = API_URL;
	
	//Amazonaccount
	$amazon_url = $api_url."AmazonApi/api/AmazonAccounts/GetAmazonAccounts";
	$getamzaccountsrequest = '<getamzaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkamzaccountcode>0</pkamzaccountcode>
					  </getamzaccountsrequest>';
	$res = get_xml_response($amazon_url,$getamzaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['amazonAccounts'] = $response;
			}
		}
	}
	
	//eBayaccount
	$eBay_url = $api_url."eBayAPI/api/eBayAccounts/GeteBayAccounts";
	$getebayaccountsrequest = '<getebayaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<ebayaccountcode>0</ebayaccountcode>
					  </getebayaccountsrequest>';
	$res = get_xml_response($eBay_url,$getebayaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['ebayAccounts'] = $response;
			}
		}
	}
	
	//Rakutenaccount
	$rakuten_url = $api_url."RakutenAPI/api/RakutenAccounts/GetRakutenAccounts";
	$getrakutenaccountsrequest = '<getrakutenaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkrakutenaccountcode>0</pkrakutenaccountcode>
					  </getrakutenaccountsrequest>';
	$res = get_xml_response($rakuten_url,$getrakutenaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['rakutenAccounts'] = $response;
			}
		}
	}
	
	//TradeMeaccount
	$trademe_url = $api_url."TradeMeAPI/api/TradeMeAccount/GetTradeMeAccount";
	$gettrademeaccountsrequest = '<gettrademeaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pktrademeaccountcode>0</pktrademeaccountcode>
					  </gettrademeaccountsrequest>';
	$res = get_xml_response($trademe_url,$gettrademeaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['trademeAccounts'] = $response;
			}
		}
	}
	
	//Gameaccount
	$game_url = $api_url."GameApi/api/GameAccounts/GetGameAccounts";
	$getgameaccountsrequest = '<getgameaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<gameaccountcode>0</gameaccountcode>
					  </getgameaccountsrequest>';
	$res = get_xml_response($game_url,$getgameaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['gameAccounts'] = $response;
			}
		}
	}
	
	//CDiscountaccount
	$cdiscount_url = $api_url."CDiscountAPI/Api/CDiscountAccount/GetCDiscountAccounts";
	$getcdiscountaccountsrequest = '<getcdiscountaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkcdiscountaccountcode>0</pkcdiscountaccountcode>
					  </getcdiscountaccountsrequest>';
	$res = get_xml_response($cdiscount_url,$getcdiscountaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['cdiscountAccounts'] = $response;
			}
		}
	}
	
	//FNACaccount
	$fnac_url = $api_url."FNACAPI/api/FNACAccounts/GetFNACAccount";
	$getfnacaccountsrequest = '<getfnacaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkfnacaccountcode>0</pkfnacaccountcode>
					  </getfnacaccountsrequest>';
	$res = get_xml_response($fnac_url,$getfnacaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['fnacAccounts'] = $response;
			}
		}
	}
	
	//Webstoreaccount
	$webstore_url = $api_url."WebStoreAPI/api/WebStoreAccounts/GetWebStoreAccounts";
	$getwebstoreaccoutrequest = '<getwebstoreaccoutrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<webstoreaccountcode>0</webstoreaccountcode>
					  </getwebstoreaccoutrequest>';
	$res = get_xml_response($webstore_url,$getwebstoreaccoutrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['webstoreAccounts'] = $response;
			}
		}
	}
	
	//abebooksaccount
	$abebooks_url = $api_url."AbebooksAPI/api/AbeBooksAccounts/GetAbeBooksAccounts";
	$getabebooksaccounts = '<getabebooksaccounts>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkabebooksaccountcode>0</pkabebooksaccountcode>
					  </getabebooksaccounts>';
	$res = get_xml_response($abebooks_url,$getabebooksaccounts);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['abeAccounts'] = $response;
			}
		}
	}
	
	//Allegroaccount
	$allegro_url = $api_url."AllegroAPI/api/AllegroAccounts/GetAllegroAccount";
	$getallegroaccountrequest = '<getallegroaccountrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<allegroaccountcode>0</allegroaccountcode>
					  </getallegroaccountrequest>';
	$res = get_xml_response($allegro_url,$getallegroaccountrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['allegroAccounts'] = $response;
			}
		}
	}
	
	//SKUcloudaccount
	$skucloud_url = $api_url."SKUCloudAPI/api/Accounts/GetSKUCloudAccounts";
	$getskucloudaccountrequest = '<getskucloudaccountrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkaccountcode>0</pkaccountcode>
						<accountcode>0</accountcode>
					  </getskucloudaccountrequest>';
	$res = get_xml_response($skucloud_url,$getskucloudaccountrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['skucloudAccounts'] = $response;
			}
		}
	}
	
	//ONBuyaccount
	$ONBuy_url = $api_url."OnBuyAPI/api/Accounts/GetOnBuyAccounts";
	$getonbuyaccountsrequest = '<getonbuyaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkaccountcode>0</pkaccountcode>
						<accountcode>0</accountcode>
					  </getonbuyaccountsrequest>';
	$res = get_xml_response($ONBuy_url,$getonbuyaccountsrequest);
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['onbuyAccounts'] = $response;
			}
		}
	}
	
	//ShopifyAccount
	$Shopify_url = $api_url."ShopifyAccountsAPI/api/Accounts/GetShopifyAccounts";
	$getshopifyaccountsrequest = '<getshopifyaccountsrequest>
						<usertoken>'.$usertoken.'</usertoken>
						<dbcode>'.$dbcode.'</dbcode>
						<responsetype>json</responsetype>
						<pkaccountcode>0</pkaccountcode>
						<accountcode>0</accountcode>
					  </getshopifyaccountsrequest>';
	$res = get_xml_response($Shopify_url,$getshopifyaccountsrequest);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statuscode']) && $response['statuscode'] == 0) {
				$inventory_tabs['shopifyAccounts'] = $response;
			}
		}
	}
	
	//frugoaccount
	$frugo_url = substr(COMPETE_API_URL, 0, -1).":8080/FruugoAccounts/api/FruugoAccount/GetFruugoAccounts?PKAccountCode=0&AccountCode=0";
	//echo $frugo_url;exit;
	$request_data = array();
	$request_data['AuthToken'] = $usertoken;
	$request_data['VendorDetailsCode'] = $dbcode;
	$request_data['ApiCall'] = 'GetFruugoAccounts';
	
	$header=array(
			'AuthToken: '.$usertoken,
            'VendorDetailsCode: '.$dbcode,
            'ApiCall: AddFruugoAccount',
			'Content-Type: application/json',
		);
	$res = get_json_response($header,array(),$frugo_url);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			if(isset($response['statusCode']) && $response['statusCode'] == 0) {
				$inventory_tabs['fruugoAccounts'] = $response;
			}
		}
	}
}
//print_r($inventory_tabs);exit;
function get_tabcolumns($get_tabcolumns){
	$response = array();
	$response[] = array('iid'=>0,'heading'=>'ALL','active'=>true,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/alltabs_table_data.php');
	foreach($get_tabcolumns as $k=>$v){
		if($k == "amazonAccounts" && isset($v['accounts']) && count($v['accounts']) > 0){
			$response[] = array('iid'=>2,'heading'=>'Amazon','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/amazon_table_data.php');
		}
		if($k == "ebayAccounts" && isset($v['ebayaccounts']) && count($v['ebayaccounts']) > 0){
			$response[] = array('iid'=>1,'heading'=>'eBay','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/eBay_table_data.php');
		}
		if($k == "rakutenAccounts"){
			$response[] = array('iid'=>7,'heading'=>'Rakuten','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/rakuten_table_data.php');
		}
		if($k == "trademeAccounts"){
			$response[] = array('iid'=>8,'heading'=>'Trademe','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/trademe_table_data.php');
		}
		if($k == "gameAccounts"){
			$response[] = array('iid'=>101,'heading'=>'Game','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/Game_table_data.php');
		}
		if($k == "cdiscountAccounts"){
			$response[] = array('iid'=>9,'heading'=>'CDiscount','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/cdiscount_table_data.php');
		}
		if($k == "fnacAccounts"){
			$response[] = array('iid'=>10,'heading'=>'FNAC','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/fnac_table_data.php');
		}
		if($k == "webstoreAccounts"){
			$response[] = array('iid'=>3,'heading'=>'Webstore','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/webstore_table_data.php');
		}
		if($k == "abeAccounts"){
			$response[] = array('iid'=>13,'heading'=>'Abebooks','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/abebooks_table_data.php');
		}
		if($k == "allegroAccounts"){
			$response[] = array('iid'=>17,'heading'=>'Allegro','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/allegro_table_data.php');
		}
		if($k == "skucloudAccounts" && isset($v['accounts']) && count($v['accounts']) > 0){
			$response[] = array('iid'=>21,'heading'=>'SKUCloud','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/skucloud_table_data.php');
		}
		if($k == "fruugoAccounts" && isset($v['accounts']) && count($v['accounts']) > 0){
			$response[] = array('iid'=>22,'heading'=>'Fruugo','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/frugo_table_data.php');
		}
		if($k == "onbuyAccounts" && isset($v['accounts']) && count($v['accounts']) > 0){
			$response[] = array('iid'=>20,'heading'=>'ONBuy','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/onbuy_table_data.php');
		}
		if($k == "shopifyAccounts" && isset($v['accounts']) && count($v['accounts']) > 0){
			$response[] = array('iid'=>15,'heading'=>'Shopify','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/shopify_table_data.php');
		}
	}
	$response[] = array('iid'=>16,'heading'=>'FBA Inventory','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/fba_table_data.php');
	$response[] = array('iid'=>18,'heading'=>'Inventory Images','active'=>false,'template'=>'inventory/alltabs.php','table_template'=>'inventory/scripts/inventory_images_table_data.php');
	return $response;
}
$_SESSION['inventory_tabs'] = $inventory_tabs;
$inventory_tabs['tab_columns'] = get_tabcolumns($inventory_tabs);
echo json_encode($inventory_tabs);exit;
?>