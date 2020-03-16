<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
require_once('../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	
	$details = $_REQUEST;
	
	$status=false;
	$msg = '';
	
	if(isset($details['orders'])){
		$orders = "";
		$order_details = json_decode($details['orders']);
		foreach($order_details as $k=>$v){
			$orders .= "<order>
							<ordernumber>".$v->ordernumber."</ordernumber>
							<accountcode>".$v->accountcode."</accountcode>
							<marketplacecode>22</marketplacecode>";
							$items = "<items>";
							$items_temp = array();
							if(isset($v->items)){
								$items_temp = $v->items;
								if(is_array($items_temp)){
									foreach($items_temp as $ik=>$iv){
										$items .= "<item>
													<sku>".$iv->Sku."</sku>
													<qtydispatched>".$iv->Quantity."</qtydispatched>
													<orderlineitemid>".$iv->OrderLineItemId."</orderlineitemid>
													<invoiceid></invoiceid>
												</item>";
									}
								}
							}else{
								$items .= "<item>
											<sku>".$v->sku."</sku>
											<qtydispatched>".$v->qtydispatched."</qtydispatched>
											<orderlineitemid>".$v->orderlineitemid."</orderlineitemid>
											<invoiceid></invoiceid>
										</item>";
							}
							$items .= "</items>";
							$orders .= $items;
							$orders .= "</order>";
		}

		$request = "<changeorderstagerequest>
						<usertoken>".$usertoken."</usertoken>
						<dbcode>".$dbcode."</dbcode>
						<responsetype>json</responsetype>
						<orderstagecode>".$details['orderstagecode']."</orderstagecode>
						<usercode>".$usercode."</usercode>
						<ipaddress>106.51.64.100</ipaddress>
						<orders>".$orders."</orders>
					</changeorderstagerequest>";	
		echo $request;exit;
		$URL = LABEL_SETTINGS."OrderStage/ChangeOrderStageInBulk";
		$res = get_xml_response($URL,$request);
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$status = true;
				}
			}
		}
				
	}else{
		$status = false;
		$msg = "Empty orders Provided";
	}
	
	$data = array('status'=>$status,'msg'=>$msg);
	
	
	
}

?>