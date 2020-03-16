<?php
require_once("../../common/db-config.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
require_once("../../common/ebay_api_end_points.php");
if(!isset($_SESSION)){
	session_start();
}

//print_r($_REQUEST);exit;
$offset = 1;
$limit = 10;
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
$flag_sku = array();

if(isset($_REQUEST['cols_data'])){
	$cols_data = json_decode($_REQUEST['cols_data'],true);
}
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
$search_query = "";
if(isset($_REQUEST['search']['value']) && !empty($_REQUEST['search']['value'])){
	$search_val = $_REQUEST['search']['value'];
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
if(isset($_REQUEST['search']['value']) && !empty($_REQUEST['search']['value'])){
	$search_val = $_REQUEST['search']['value'];
	$search_query = $search_val;
}
//echo $search_query;exit;

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
		
	$marketplacecode = isset($_REQUEST['marketplacecode'])?$_REQUEST['marketplacecode']:'0';
	$accountcode = isset($_REQUEST['fkaccountcode'])?$_REQUEST['fkaccountcode']:'0';
	//$accountcode = isset($_REQUEST['accountcode'])?$_REQUEST['accountcode']:'0';
	
	if(!empty($cols_data)){

		$inventorydashboard_URL = INVENTORY_API."Shipment/GetFbaSearchDetails";
		$request = "<getfbasearchdetailsrequest>
									<dbcode>".$dbcode."</dbcode>
									<usertoken>".$usertoken."</usertoken>
									<responsetype>json</responsetype>
									<accountcode>".$accountcode."</accountcode>
									<searchtext>".$search_query."</searchtext>
									<pagenumber>".$offset."</pagenumber>
									<noofrecords>".$limit."</noofrecords>
								</getfbasearchdetailsrequest>";
		//echo $request;exit;
		$res = get_xml_response($inventorydashboard_URL,$request);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statuscode']) && $response['statuscode'] == 0) {
					$sku_details = $response;
				}
			}
		}
		if(!empty($sku_details)){
			$recordsTotal = $sku_details['totalrecords'];
			if(!empty($search_query)){
				$i=0;
				foreach($sku_details as $k=>$v){
					if(is_array($v) && count($v)>0){
						foreach($v as $sk=>$sv){
							if(isset($sv['flagid']) && $sv['flagid'] != "" && $sv['flagid'] != ""){
								$flag_sku[$sv['sku']] = $sv['flagid'];
							}
							$inner_array = array();
							$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='".$sv['sku']."_16' data-sku='".$sv['sku']."' data-accountcode='".$sv['accountcode']."' data-marketplace='16' name='sku_checkbox[]' value='sku_".$sv['sku']."' >";
							if(isset($sv['childitemcount']) && intval($sv['childitemcount']) > 0){
								$inner_array[] = '<span class="fa fa-plus ng-scope expand_tr" data-sku="'.$sv['sku'].'" ></span>';
								$i++;
							}else{
								$inner_array[] = '&nbsp;';
							}
							$inner_array[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$sv['sku']."'>Edit</a>";
							foreach($cols_data as $k=>$v){ 
								if(isset($sv[$v['val']])){
									if($v['val'] == 'active'){
										if($sv[$v['val']] == "True"){
											$inner_array[] = 'Active';
										}else{
											$inner_array[] = 'Inactive';
										}
									}elseif($v['val'] == 'totalquantity'){
										$inner_array[] = '<label style="display:flex"><input type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" data-sku="'.$sv['sku'].'" ><em data-sku="'.$sv['sku'].'" class="fa fa-lg fa-location-arrow" style="color:#087cc3;"></em></label>';
									}else{
										$inner_array[] = $sv[$v['val']];
									}
								} else{
									$inner_array[] = '&nbsp;';
								}
							}
							$outer_array[] = $inner_array;
						}
					}
				}
			}else{
				$i=0;
				foreach($sku_details['items'] as $sk=>$sv){
					if(isset($sv['flagid']) && $sv['flagid'] != "" && $sv['flagid'] != ""){
						$flag_sku[$sv['sku']] = $sv['flagid'];
					}
					$inner_array = array();
					$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='".$sv['sku']."_16' data-sku='".$sv['sku']."' data-accountcode='".$sv['accountcode']."' data-marketplace='16' name='sku_checkbox[]' value='sku_".$sv['sku']."' >";
					if(isset($sv['childitemcount']) && intval($sv['childitemcount']) > 0){
						$inner_array[] = '<span class="fa fa-plus ng-scope expand_tr" data-sku="'.$sv['sku'].'" ></span>';
						$i++;
					}else{
								$inner_array[] = '&nbsp;';
					}
					$inner_array[] = "<a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$sv['sku']."'>Edit</a>";
					foreach($cols_data as $k=>$v){ 
						if(isset($sv[$v['val']])){ 
							if($v['val'] == 'active'){
								if($sv[$v['val']] == "True"){
									$inner_array[] = 'Active';
								}else{
									$inner_array[] = 'Inactive';
								}
							}elseif($v['val'] == 'totalquantity'){
								$inner_array[] = '<label style="display:flex"><input type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" data-sku="'.$sv['sku'].'" ><em data-sku="'.$sv['sku'].'" class="fa fa-lg fa-location-arrow" style="color:#087cc3;"></em></label>';
							}else{
								$inner_array[] = $sv[$v['val']];
							}
						} else{
							$inner_array[] = '&nbsp;';
						}
					}
					$outer_array[] = $inner_array;
				}
			}
		}
	}
	
	$final_array = array();
	$final_array['draw'] = $draw;
	$final_array['recordsTotal'] = $recordsTotal;
	$final_array['recordsFiltered'] = $recordsTotal;
	$final_array['flagSKUS'] = $flag_sku;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
	
}

?>
				