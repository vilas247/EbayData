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
	
	if(!empty($cols_data)){

		$inventorydashboard_URL = substr(COMPETE_API_URL, 0, -1).":8080/FruugoInventoryAPI/api/FruugoInventory/GetFruugoInventory";
		$inventorydashboard_URL .= "?AccountCode=".$accountcode."&RecordsPerPage=".$limit."&PageNumber=".$offset;
		if(!empty($search_query)){
			$inventorydashboard_URL .= "&SearchText=".$search_query;
		}
		//echo $request;exit;
		$header=array(
			'AuthToken: '.$usertoken,
            'VendorDetailsCode: '.$dbcode,
            'ApiCall: AddFruugoAccount',
			'Content-Type: application/json',
		);
		
		$res = get_json_response($header,array(),$inventorydashboard_URL);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				if(isset($response['statusCode']) && $response['statusCode'] == 0) {
					$sku_details = $response;
				}
			}
		}
		if(!empty($sku_details)){
			$recordsTotal = $sku_details['totalRecords'];
			if(!empty($search_query)){
				$i=0;
				foreach($sku_details as $k=>$v){
					if(is_array($v) && count($v)>0){
						foreach($v as $sk=>$sv){
							if(isset($sv['flagid']) && $sv['flagid'] != "" && $sv['flagid'] != ""){
								$flag_sku[$sv['sku']] = $sv['flagid'];
							}
							$inner_array = array();
							$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='".$sv['sku']."_22' data-sku='".$sv['sku']."' data-accountcode='".$sv['accountCode']."' data-marketplace='13' name='sku_checkbox[]' value='sku_".$sv['sku']."' >";
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
									}elseif($v['val'] == 'quantitylimit'){
										$inner_array[] = '<label style="display:flex"><input id="'.$sv['sku'].'_22" type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" data-marketplace="22" data-sku="'.$sv['sku'].'" ></label>';
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
				foreach($sku_details['inventories'] as $sk=>$sv){
					if(isset($sv['flagid']) && $sv['flagid'] != "" && $sv['flagid'] != ""){
						$flag_sku[$sv['sku']] = $sv['flagid'];
					}
					$inner_array = array();
					$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='".$sv['sku']."_22' data-sku='".$sv['sku']."' data-accountcode='".$sv['accountCode']."' data-marketplace='22' name='sku_checkbox[]' value='sku_".$sv['sku']."' >";
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
							}elseif($v['val'] == 'quantitylimit'){
								$inner_array[] = '<label style="display:flex"><input id="'.$sv['sku'].'_22" type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" data-marketplace="13" data-sku="'.$sv['sku'].'" ></label>';
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
				