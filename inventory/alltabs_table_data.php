<?php
require_once("../../ebayapis/ebay_data/db-config.php");
require_once("../../ebayapis/ebay_data/ebay_api_end_points.php");
require_once("../../ebayapis/ebay_data/curl.php");
require_once('../../common/inventory_config.php');
session_start();

//print_r($_REQUEST);exit;
$offset = 0;
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
	$search_query = "<searchtext>".$search_val."</searchtext><columnname></columnname><sortorder></sortorder>";
}
//echo $search_query;exit;

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
		
	$marketplacecode = isset($_REQUEST['marketplacecode'])?$_REQUEST['marketplacecode']:'0';
	$accountcode = ($marketplacecode>0)?'1':0;
	
	if(!empty($cols_data)){
		$inventory_api = INVENTORY_API;
		//sku details
		if(!empty($search_query)){
			$inventorydashboard_URL = $inventory_api."Product/GetInventorySearchParentDetails";
			$request = "<getinventorysearchdetailsrequest>
									<usertoken>".$usertoken."</usertoken>
									<dbcode>".$dbcode."</dbcode>
									<responsetype>json</responsetype>
									<profilecode>0</profilecode>
									<marketplacecode>".$marketplacecode."</marketplacecode>
									<numberofrecords>".$limit."</numberofrecords>
									<pagenumber>".$offset."</pagenumber>
									<accountcode>0</accountcode>
									".$sorting_val."
									".$search_query."
									<flagid>0</flagid>
								</getinventorysearchdetailsrequest>";
		}else{
			$inventorydashboard_URL = $inventory_api."Product/GetParentProductInventory";
			$request = "<getinventoryrequest>
									<dbcode>".$dbcode."</dbcode>
									<usertoken>".$usertoken."</usertoken>
									<responsetype>json</responsetype>
									<marketplacecode>".$marketplacecode."</marketplacecode>
									<numberofrecords>".$limit."</numberofrecords>
									<pagenumbers>".$offset."</pagenumbers>
									<allaccounts>".$accountcode."</allaccounts>
									".$sorting_val."
									<flagid>0</flagid>
									<filteration>
										<fkaccountcode>0</fkaccountcode>
									</filteration>
								</getinventoryrequest>";
		}
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
			$recordsTotal = $sku_details['numberofrecords'];
			$parentproducts = $sku_details['parentproducts'];
			$childproducts = $sku_details['childproducts'];
			$nonrelationshipproducts = $sku_details['nonrelationshipproducts'];
			if(!empty($search_query)){
				foreach($sku_details as $k=>$v){
					if(is_array($v) && count($v)>0){
						foreach($v as $sk=>$sv){
							$inner_array = array();
							$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='sku_".$sv['sku']."' name='sku_checkbox[]' >";
							foreach($cols_data as $k=>$v){ 
								if(isset($sv[$v['val']])){
									if($v['val'] == 'active'){
										if($sv[$v['val']] == "True"){
											$inner_array[] = 'Active';
										}else{
											$inner_array[] = 'Inactive';
										}
									}elseif($v['val'] == 'totalquantity'){
										$inner_array[] = '<label style="display:flex"><input type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" ><em class="fa fa-lg fa-location-arrow" style="color:#087cc3;"></em></label>';
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
				foreach($sku_details['inventorys'] as $sk=>$sv){
					$inner_array = array();
					$inner_array[] = "<input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='sku_".$sv['sku']."' name='sku_checkbox[]' >";
					foreach($cols_data as $k=>$v){ 
						if(isset($sv[$v['val']])){ 
							if($v['val'] == 'active'){
								if($sv[$v['val']] == "True"){
									$inner_array[] = 'Active';
								}else{
									$inner_array[] = 'Inactive';
								}
							}elseif($v['val'] == 'totalquantity'){
								$inner_array[] = '<label style="display:flex"><input type="text" value="'.$sv[$v['val']].'" class="form-control cmnTotQtyClass" ><em class="fa fa-lg fa-location-arrow" style="color:#087cc3;"></em></label>';
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
	$final_array['parentproducts'] = $parentproducts;
	$final_array['childproducts'] = $childproducts;
	$final_array['nonrelationshipproducts'] = $nonrelationshipproducts;
	$final_array['recordsFiltered'] = $recordsTotal;
	$final_array['data'] = $outer_array;
	echo json_encode($final_array,true);exit;
	
}

?>
				