<?php
	require_once("../common/ebay_api_end_points.php");
	printInvoiceLabel();
	/* PrintInvoice/Label */
	function printInvoiceLabel(){
		$request = $_REQUEST;
		if(isset($request['orders'][0])){
			$request = $request['orders'][0];
		}else{
			$request = '';
		}
		$response = array();
		$response['data'] = '';
		$response['view'] = '';
        $response['msg'] = '';
        $response['status'] = false;
		
		$templatelabel = '';
		$courierChkboxLabel = '';
		
		$templatelabel = isset($request['templatelabel'])?$request['templatelabel']:'';
		$courierChkboxLabel = isset($request['courierChkboxLabel'])?$request['courierChkboxLabel']:'';
		if(!empty($templatelabel) || !empty($courierChkboxLabel)){
			$page_view_data = '';
			if(!empty($templatelabel)){
				$page_data = array();
				if($templatelabel == "1" || $templatelabel == "0"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/invoice_withoutppi.php');
				}
				else if($templatelabel == "2"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/invoice_withppi.php');
				}
				else if($templatelabel == "3"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/amazon_invoice.php');
				}
				else if($templatelabel == "4"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/ebay_invoice.php');
				}
				else if($templatelabel == "5"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/invoice_withvat.php');
				}
				else if($templatelabel == "6" || $templatelabel == "7" || $templatelabel == "8" || $templatelabel == "10" || $templatelabel == "15"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/TrimmingshopRoyalmailInvoice.php');
				}
				else if($templatelabel == "9"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/TrimmingshopRoyammailPackingInvoice.php');
				}
				else if($templatelabel == "16" || $templatelabel == "39"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/FairwayImportersInvoice.php');
				}
				else if($templatelabel == "17"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/ClothingDirectInvoice.php');
				}
				else if($templatelabel == "18"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/StMichaelHospiceInvoice.php');
				}
				else if($templatelabel == "19"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/AlexthefatdawgInvoice.php');
				}
				//not done
				else if($templatelabel == "20"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/AlexthefatdawgInvoice.php');
				}
				else if($templatelabel == "21" || $templatelabel == "22" || $templatelabel == "23"|| $templatelabel == "27"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/TrimmingshopRoyalmailInvoice.php');
				}
				else if($templatelabel == "24" || $templatelabel == "25"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/StartatpageoneInvoice.php');
				}
				else if($templatelabel == "26"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/FDXSportsInvoice.php');
				}
				else if($templatelabel == "28" || $templatelabel == "29" || $templatelabel == "30" || $templatelabel == "31"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/EESMusicInvoice.php');
				}
				else if($templatelabel == "32" || $templatelabel == "33" || $templatelabel == "34" || $templatelabel == "35"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/BeautyNestInvoice.php');
				}
				else if($templatelabel == "36"){
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/ToysNTuckInvoice.php');
				}
				else if($templatelabel == "37" || $templatelabel == "38" || $templatelabel == "40") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/HabercraftsInvoice.php');
				}
				else if($templatelabel == "41" || $templatelabel == "42" || $templatelabel == "43" || $templatelabel == "44") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/KitMeOutInvoice.php');
				}
				else if($templatelabel == "45" || $templatelabel == "53") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/ChampionDreamsInvoice.php');
				}
				else if($templatelabel == "46") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/PannuFurniture.php');
				}
				else if($templatelabel == "47" || $templatelabel == "59" || $templatelabel == "60" || $templatelabel == "61" || $templatelabel == "62" || $templatelabel == "63") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/UrbanTradingInvoice.php');
				}
				else if($templatelabel == "48" || $templatelabel == "50" || $templatelabel == "51" || $templatelabel == "52") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/FredrickThomasTies.php');
				}
				else if($templatelabel == "49") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/GizmozNGadgetz.php');
				}
				else if($templatelabel == "54" || $templatelabel == "55") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/DirectProductsInvoice.php');
				}
				else if($templatelabel == "56" || $templatelabel == "57" || $templatelabel == "58") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/ProKladerAmazonInvoice.php');
				}
				else if($templatelabel == "64") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/BorisDorisInvocie.php');
				}
				else if($templatelabel == "65") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/84CharingCrossInvoice.php');
				}
				else if($templatelabel == "66" || $templatelabel == "67") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/StartingFootkitInvoice.php');
				}
				else if($templatelabel == "68") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/RejelAutomotiveInvoice.php');
				}else if($templatelabel == "69" || $templatelabel == "70") {
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/MonogramInvoice.php');
				}else{
					$page_view_data=file_get_contents (BASE_URL.'orders/scanpackship/invoices/invoice_withoutppi.php');
				}
			}
			if(!empty($courierChkboxLabel)){
				
			}
			$response['view'] = get_compressed_output($page_view_data);
			$response['status'] = true;
		}else{
			$response['msg'] = "Please select any lable or Invoice";
		}
		echo json_encode($response);exit;
	}
	
	function get_compressed_output($data)
	{
		ini_set('memory_limit', '-1');
		$search = array(
		'/\>[^\S ]+/s',
		'/[^\S ]+\</s',
	  '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s' //leave CDATA alone
		);
		$replace = array(
		 '>',
		 '<',
	  "//&lt;![CDATA[\n".'\1'."\n//]]>"
	  );

	  return  preg_replace($search, $replace, $data);
	}