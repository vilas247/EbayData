<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

//print_r($_REQUEST);exit;
$offset = 1;
$limit = 100;
$sorting = '';
$sorting_val = '';
$draw = 1;
$cols_data = array();
$outer_array = array();
$recordsTotal = 0;
$parentproducts = 0;
$childproducts = 0;
$nonrelationshipproducts = 0;
$sku_details = array();
$multiple_items = array();
$all_orders_data = array();
$primeOrders = array();
$currency = '£';

if(isset($_REQUEST['cols_data'])){
	$cols_data = json_decode($_REQUEST['cols_data'],true);
}
//print_r($cols_data);exit;
if(isset($_REQUEST['draw'])){
	$draw = $_REQUEST['draw'];
}
if(isset($_REQUEST['length']) && $_REQUEST['length'] != '' && intval($_REQUEST['length']) > 0) {
	$limit = $_REQUEST['length'];
}
if(isset($_REQUEST['start']) && $_REQUEST['start'] != '' && intval($_REQUEST['start']) > 0) {
	//$offset = ($_REQUEST['start'] - 1) * $limit;
	//$offset = $_REQUEST['start'];
	$offset = ($_REQUEST['start']/$limit)+1;
}
if(isset($_REQUEST['order']) && count($_REQUEST['order']) > 0){
	$column = $_REQUEST['order'][0]['column'];
	$order = $_REQUEST['order'][0]['dir'];
	if($column > 0){
		$id = (intval($column)-1);
		$column = $cols_data[$id]['val'];
		$sorting_val = '<columnname>'.$column.'</columnname><sortorder>'.strtoupper($order).'</sortorder>';
	}
}
$search_query = "";
$search_name = "";
$search_val = "";
$search_full = "";
if(isset($_REQUEST['searchData']) && !empty($_REQUEST['searchData'])){
	$search_data = @$_REQUEST['searchData'];
	$search_data = explode("|||||",$search_data);
	$search_name = $search_data[0];
	$search_val = $search_data[1];
	$search_full = $search_data[2];
	$search_query = "Yes";
}

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	if($search_query = "Yes" && $search_full == "on"){
		$orderstages = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,18,20,22,23";
	}else if(isset($_REQUEST['orderstages']) && !empty($_REQUEST['orderstages'])){
		$orderstages = implode(",",$_REQUEST['orderstages']);
	}else{
		$orderstages = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,18,20,22,23";
	}
	//$fromdate = "2019-12-10";
	$fromdate = "";
	//$todate = "2019-12-19";
	$todate = "";
	$numberofdays = "All";
	if(isset($_REQUEST['numberofdays']) && !empty($_REQUEST['numberofdays'])){
		$days = $_REQUEST['numberofdays'];
		if($days == "CDate"){
			$numberofdays = "";
			if(isset($_REQUEST['fromDate']) && !empty($_REQUEST['fromDate'])){
				$fromdate = date("Y-m-d",strtotime($_REQUEST['fromDate']));
			}
			if(isset($_REQUEST['toDate']) && !empty($_REQUEST['toDate'])){
				$todate = date("Y-m-d",strtotime($_REQUEST['toDate']));
			}
		}else{
			$numberofdays = $days;
		}
	}
	if(isset($_REQUEST['shippingservicecodes']) && !empty($_REQUEST['shippingservicecodes'])){
		$shippingservicecodes = implode(",",$_REQUEST['shippingservicecodes']);
	}else{
		$shippingservicecodes = "";
	}
	if(isset($_REQUEST['shippingcountrycodes']) && !empty($_REQUEST['shippingcountrycodes'])){
		$shippingcountrycodes = implode(",",$_REQUEST['shippingcountrycodes']);
	}else{
		$shippingcountrycodes = "";
	}
	if(isset($_REQUEST['accountcodes']) && !empty($_REQUEST['accountcodes'])){
		$accountcodes = implode(",",$_REQUEST['accountcodes']);
	}else{
		$accountcodes = "";
	}
	if(isset($_REQUEST['itemtype']) && !empty($_REQUEST['itemtype'])){
		$itemtype = $_REQUEST['itemtype'];
	}else{
		$itemtype = "0";
	}
	$supplier = "";
	
		
	$order_details = array();
	$order_count_details = array();
	if(!empty($cols_data)){
		if($search_query == "Yes"){
			$url = COMPETE_API_URL."OrderAPI2/API/OrderAPI/GetOrdersUsingSearch";
			$request = "<getordersusingsearch>
								<dbcode>".$dbcode."</dbcode>
								<usertoken>".$usertoken."</usertoken>
								<responsetype>json</responsetype>
								<searchparam>
									<parameter>
										<name>".$search_name."</name>
										<value>".$search_val."</value>
									</parameter>
								</searchparam>
								<pagenumber>".$offset."</pagenumber>
								<numberofrecords>".$limit."</numberofrecords>
							</getordersusingsearch>";
			//echo $request;exit;
			$res = get_xml_response($url,$request);
			//print_r($res);exit;
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
			}else{
				if(json_last_error() === 0){
					$response = json_decode($res,true);
					if(isset($response['statuscode']) && $response['statuscode'] == 0) {
						$order_details = $response;
					}
				}
			}
			
			$order_details = array_change_key_case($order_details,CASE_LOWER);
			if(!empty($order_details)){
				$recordsTotal = $order_details['totalnumberofrecords'];
				$i=0;
				foreach($order_details['invoices'] as $sk=>$sv){
					$sv = array_change_key_case($sv,CASE_LOWER);
					$address_details = $sv['shippingaddresses'][0];
					$inner_array = array();
					
					$multiple_orders = array();
					$sku = '';
					$orderlineitemid = '';
					$TotalPrice = "";
					$ShippingPrice = "";
					$CostPrice = "";
					$all_orders_data[$sv['orderid']] = $sv;
					if($sv['isprime'] == "true"){
						$primeOrders[] = $sv['orderid'];
					}
					if(isset($sv['orderitems']) && count($sv['orderitems'])>1){
						$sku = "Multiple Item Order";
						$sv['orderitems'][0]['source'] = $sv['accountname'];
						$multiple_items[$sv['orderid']] = $sv['orderitems'];
					}else{
						$order_item = $sv['orderitems'][0];
						$sku = $order_item['Sku'];
						$TotalPrice = $order_item['TotalPrice'];
						$ShippingPrice = $order_item['ShippingPrice'];
						$CostPrice = $order_item['UnitPrice'];
						$orderlineitemid = $order_item['OrderLineItemId'];
					}
					
					$inner_array[] = '<input class="order_checkbox" type="checkbox" style="display:block;margin:5px auto;" name="myCheckboxes[]" type="checkbox" value="'.$sv['orderid'].'" data-multiple-orders="'.(($sku=="Multiple Item Order")?"Yes":"No").'" data-account-code="'.$sv['accountcode'].'" data-market-place="'.$sv['accountname'].'" data-order-line-item-id="'.$orderlineitemid.'" data-sku="'.$sku.'" data-qty-dispatched="'.$sv['orderquantity'].'" >';
					
					$productTitle = $sv['orderitems'][0]['ProductTitle'];
					$ShippingService = $sv['orderitems'][0]['ShippingService'];
					if($sku == "Multiple Item Order"){
						$inner_array[] = "<span class='fa fa-plus expand_tr' data-order-id='".$sv['orderid']."' ></span>";
						$i++;
					}else{
						$inner_array[] = '&nbsp;';
					}
					foreach($cols_data as $k=>$v){
						if(isset($sv[$v['val']])){
							$inner_array[] = $sv[$v['val']];
						} else{	
							if($v['val'] == "sku"){
								$inner_array[] = $sku;
							}else if($v['val'] == "ordernumber"){
								$inner_array[] = $sv['orderid'];
							}else if($v['val'] == "producttitle"){
								$inner_array[] = $productTitle;
							}else if($v['val'] == "shippingservice"){
								$inner_array[] = $ShippingService;
							}else if($v['val'] == "postcode"){
								$inner_array[] = $address_details['PostCode'];
							}else if($v['val'] == "ototal"){
								$inner_array[] = $currency." ".$sv['totalprice'];
							}else if($v['val'] == "ptotal"){
								$inner_array[] = $currency." ".$TotalPrice;
							}else if($v['val'] == "stotal"){
								if(!empty($ShippingPrice)){
									$inner_array[] = $currency." ".$ShippingPrice;
								}else{
									$inner_array[] = $currency." 0.0";
								}
							}else if($v['val'] == "unitprice"){
								$inner_array[] = $currency." ".$CostPrice;
							}else{
								$inner_array[] = '&nbsp;';	
							}
						}
					}
					$outer_array[] = $inner_array;
				}
			}
		}else{
			$ordercount_URL = COMPETE_API_URL."OrderAPI2/API/OrderAPI/GetOrderDetailsCount";
			$request_count = "<getorderdetailsrequest>
								<usertoken>".$usertoken."</usertoken>
								<dbcode>".$dbcode."</dbcode>
								<responsetype>json</responsetype>
								<orderstages>".$orderstages."</orderstages>
								<period>
									<numberofdays>".$numberofdays."</numberofdays>
									<fromdate>".$fromdate."</fromdate>
									<toodate>".$todate."</toodate>
								</period>
								<shippingservicecodes>".$shippingservicecodes."</shippingservicecodes>
								<shippingcountrycodes>".$shippingcountrycodes."</shippingcountrycodes>
								<accountcodes>".$accountcodes."</accountcodes>
								<itemtype>".$itemtype."</itemtype>
								<supplier>".$supplier."</supplier>
								<pagenumber>".$offset."</pagenumber>
								<numberofrecords>".$limit."</numberofrecords>
							</getorderdetailsrequest>";
			
			//echo $request_count;exit;
			$res = get_xml_response($ordercount_URL,$request_count);
			//print_r($res);exit;
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
			}else{
				if(json_last_error() === 0){
					$response = json_decode($res,true);
					if(isset($response['statuscode']) && $response['statuscode'] == 0) {
						$order_count_details = $response;
					}
				}
			}
			$orderdashboard_URL = COMPETE_API_URL."OrderAPI2/API/OrderAPI/GetOrderDetails";
			$request = "<getorderdetailsrequest>
								<usertoken>".$usertoken."</usertoken>
								<dbcode>".$dbcode."</dbcode>
								<responsetype>json</responsetype>
								<orderstages>".$orderstages."</orderstages>
								<period>
									<numberofdays>".$numberofdays."</numberofdays>
									<fromdate>".$fromdate."</fromdate>
									<toodate>".$todate."</toodate>
								</period>
								<shippingservicecodes>".$shippingservicecodes."</shippingservicecodes>
								<shippingcountrycodes>".$shippingcountrycodes."</shippingcountrycodes>
								<accountcodes>".$accountcodes."</accountcodes>
								<itemtype>".$itemtype."</itemtype>
								<supplier>".$supplier."</supplier>
								<pagenumber>".$offset."</pagenumber>
								<numberofrecords>".$limit."</numberofrecords>
							</getorderdetailsrequest>";
			
			//echo $request;exit;
			$res = get_xml_response($orderdashboard_URL,$request);
			//print_r($res);exit;
			$check_errors = json_decode($res);
			if(isset($check_errors->errors)){
			}else{
				if(json_last_error() === 0){
					$response = json_decode($res,true);
					if(isset($response['statuscode']) && $response['statuscode'] == 0) {
						$order_details = $response;
					}
				}
			}
			$order_details = array_change_key_case($order_details,CASE_LOWER);
			if(!empty($order_details)){
				$i=0;
				foreach($order_details['invoices'] as $sk=>$sv){
					$sv = array_change_key_case($sv,CASE_LOWER);
					$address_details = $sv['shippingaddresses'][0];
					$inner_array = array();
					
					$multiple_orders = array();
					$sku = '';
					$orderlineitemid = '';
					$TotalPrice = "";
					$ShippingPrice = "";
					$CostPrice = "";
					$all_orders_data[$sv['orderid']] = $sv;
					if(isset($sv['orderitems']) && count($sv['orderitems'])>1){
						$mergeordercheck = $sv['orderid'][0].$sv['orderid'][1];
						if($mergeordercheck == "M-"){
							$sku = "Merge Item Order";
						}else{
							$sku = "Multiple Item Order";
						}
						$sv['orderitems'][0]['source'] = $sv['accountname'];
						$multiple_items[$sv['orderid']] = $sv['orderitems'];
					}else{
						$order_item = $sv['orderitems'][0];
						$sku = $order_item['Sku'];
						$TotalPrice = $order_item['TotalPrice'];
						$ShippingPrice = $order_item['ShippingPrice'];
						$CostPrice = $order_item['UnitPrice'];
						$orderlineitemid = $order_item['OrderLineItemId'];
					}
					
					$inner_array[] = '<input class="order_checkbox" type="checkbox" style="display:block;margin:5px auto;" name="myCheckboxes[]" type="checkbox" value="'.$sv['orderid'].'" data-multiple-orders="'.(($sku=="Multiple Item Order")?"Yes":"No").'" data-account-code="'.$sv['accountcode'].'" data-market-place="'.$sv['accountname'].'" data-order-line-item-id="'.$orderlineitemid.'" data-sku="'.$sku.'" data-qty-dispatched="'.$sv['orderquantity'].'" >';
					
					$productTitle = $sv['orderitems'][0]['ProductTitle'];
					$ShippingService = $sv['orderitems'][0]['ShippingService'];
					if($sku == "Multiple Item Order" || $sku == "Merge Item Order"){
						$inner_array[] = "<span class='fa fa-plus expand_tr' data-order-id='".$sv['orderid']."' ></span>";
						$i++;
					}else{
						$inner_array[] = '&nbsp;';
					}
					foreach($cols_data as $k=>$v){
						if(isset($sv[$v['val']])){
							$inner_array[] = $sv[$v['val']];
						} else{	
							if($v['val'] == "sku"){
								$inner_array[] = $sku;
							}else if($v['val'] == "ordernumber"){
								$inner_array[] = $sv['orderid'];
							}else if($v['val'] == "producttitle"){
								$inner_array[] = $productTitle;
							}else if($v['val'] == "shippingservice"){
								$inner_array[] = $ShippingService;
							}else if($v['val'] == "postcode"){
								$inner_array[] = $address_details['PostCode'];
							}else if($v['val'] == "ototal"){
								$inner_array[] = $currency." ".$sv['totalprice'];
							}else if($v['val'] == "ptotal"){
								$inner_array[] = $currency." ".$TotalPrice;
							}else if($v['val'] == "stotal"){
								if(!empty($ShippingPrice)){
									$inner_array[] = $currency." ".$ShippingPrice;
								}else{
									$inner_array[] = $currency." 0.0";
								}
							}else if($v['val'] == "unitprice"){
								$inner_array[] = $currency." ".$CostPrice;
							}else{
								$inner_array[] = '&nbsp;';	
							}
						}
					}
					$outer_array[] = $inner_array;
				}
			}
		}
	}
	
	$final_array = array();
	$final_array['draw'] = $draw;
	if($search_query == "Yes"){
		$final_array['recordsTotal'] = $recordsTotal;
		$final_array['recordsFiltered'] = $recordsTotal;
	}else{
		if($itemtype == "1"){
			$final_array['recordsTotal'] = @$order_count_details['singleordercount'];
			$final_array['recordsFiltered'] = @$order_count_details['singleordercount'];
		}
		if($itemtype == "2"){
			$final_array['recordsTotal'] = @$order_count_details['multipleordercount'];
			$final_array['recordsFiltered'] = @$order_count_details['multipleordercount'];
		}else{
			$final_array['recordsTotal'] = @$order_count_details['totalorderscount'];
			$final_array['recordsFiltered'] = @$order_count_details['totalorderscount'];
		}
	}
	$final_array['singleordercount'] = @$order_count_details['singleordercount'];
	$final_array['multipleordercount'] = @$order_count_details['multipleordercount'];
	$final_array['totalitem'] = @$order_count_details['totalitem'];
	$final_array['totalitemquantity'] = @$order_count_details['totalitemquantity'];
	$final_array['multipleItems'] = @$multiple_items;
	$final_array['allOrdersData'] = @$all_orders_data;
	$final_array['primeOrders'] = @$primeOrders;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
	
}

?>
				