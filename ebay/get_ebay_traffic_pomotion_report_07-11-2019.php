<?php 
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");
include("../common/inventory_config.php");
include("../common/header.php");
?>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional whirl" style="margin-top:70px">
	  <div class="row">
			<div class="singleNav">
				<p>
					<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
					<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
					<a href="<?= BASE_URL ?>#/app/inventory-dashboard">Inventory</a> &gt;
					<a href="<?= BASE_URL ?>#/">eBay Report</a> &gt;
					Traffic Promotion Report 
				</p>
			</div>
		</div>
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <ul class="list-inline">
                    <li>
                        <div class="" style="">
                            <form role="form" class="form-inline">
                                <div class="form-group text-left mar-top-5 mar-right-5">
                                    <ul class="list-inline">
                                        <li class="mar-right-5">
                                            <label>Search</label>
                                                <input type="text" id="search_data" placeholder="Search" class="form-control srch-filed">
                                        </li>
                                        <li><a href="#" id="aSearchOrder"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>
                                        <li><a href="#" onClick='clear_and_submit();' >Clear Search</a></li>
                                    </ul>
                                </div>
                            </form>     
                        </div>
                    </li>
                </ul>
            </div> 
            <div class="col-sm-6 col-md-6">
                <ul class="list-inline">
                    <!--<li><button class="btn btn-primary">Download Report</button></li>-->
                    <li>
						<span>Ebay Account ID :
						</span>
					</li>
					<li>
							<select class="form-control" >
								<option value="1212121212" >1212121212</option>
								<option value="3333" >3333</option>
							</select>
					</li>
                    <li><button class="btn btn-primary">Apply Changes</button></li>
                </ul>                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive table-bordered scroll-table traffic-table">
<?php

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$header=array(
			'Content-Type: application/json',
		);
	
$offset = 0;
$limit = 50;
$sorting = '';
$sorting_val = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sorting_val']) && $_GET['sorting_val'] != '') {
	$sorting_val = $_GET['sorting_val'];
}

// traffic report
$url = TRAFFIC_REPORT."?seller_ebay_id=".$seller_ebay_id;
$res = get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val);
if(!empty($res)){
	echo $res;
}else{
	$req = $url;
	$res = get_json_response($header,array(),$url);
	//print_r($res);exit;
	$check_errors = json_decode($res);
	if(isset($check_errors->errors)){
		echo "Error Response1<br/>";exit;
	}else{
		if(json_last_error() === 0){
			$response = json_decode($res,true);
			$random_number = strtotime("now");
			$header_array = array();
			if(isset($response['header'])){
				$sql = "insert into ebay_traffic_pomotion_report(random_number,data_type,ebay_seller_id,header_response) values ('".$random_number."','headers','".$seller_ebay_id."','".mysqli_real_escape_string($conn, json_encode($response['header'],true))."')";
				mysqli_query($conn,$sql);
			}
			if(isset($response['records'])){
				$records = $response['records'];
				$metrics = $response['header']['metrics'];
				foreach($records as $k=>$v){
					foreach($metrics as $mk=>$mv){
						$key = return_value_exists($mv['key'],$metrics);
						$header_array[strtolower($mv['key'])] = $v['metricValues'][$key]['value'];
					}
					$header_array['random_number'] = $random_number;
					$header_array['data_type'] = 'values';
					$header_array['ebay_seller_id'] = $seller_ebay_id;
					$header_array['ebay_item_id'] = $v['dimensionValues'][0]['value'];
					$ii=0;
					$columns = array();
					$values = "";
					foreach($header_array as $hak=>$hav){
						if($ii>0){
							$values .= ",";
						}
						$columns[] = $hak;
						$values .= "'".$hav."'";
						$ii++;
					}
					$db_columns = implode(",",$columns);
					$sql = "insert into ebay_traffic_pomotion_report(".$db_columns.") values(".$values.")";
					mysqli_query($conn,$sql);
				}
				
			}
			$res = get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val);
			if(!empty($res)){
				echo $res;
			}else{
				echo "Error Response2<br/><br/>";exit;
			}
		}else{
			echo "Error Response3<br/><br/>";exit;
		}
	}
}

function get_traffic_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_val){
	$sql = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";	
	$header_array = array();	
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		$header_array = json_decode($headers['header_response'],true);
		$db_columns = get_columns();
		$response .= '<table id="traffic_promotion" class="dataTable no-footer table table-bordered table-striped" >';
		$response .= '<thead>';
		$response .= '<tr role="row" class="suceess">';
		$response .= '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
		foreach($db_columns as $dbk=>$dbv){
			
			$view_column = return_header_exists($dbv['view_column'],$header_array);
			$response .= '<th title="'.$dbv['data-title'].'">'.$view_column.'</th>';
		}
		$response .= '</thead>';
		$response .= '<tbody>';
		$sql_val = "select * from ebay_traffic_pomotion_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."'";
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			$even_odd = 1;
			while($values = $res_val->fetch_assoc()){
				if(($even_odd%2) == 0){
					$even = "even";
				}else{
					$even = "odd";
				}
				$even_odd++;
				$response .= '<tr role="row" class="'.$even.'">';
				$response .= "<td><input type='checkbox' id='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				foreach($db_columns as $dbk=>$dbv){
					if(isset($values[$dbv['value']])){
						$response .= '<td>'.$values[$dbv['value']].'</td>';
					}else{
						$response .= '<td>&nbsp;</td>';
					}
				}
				$response .= "</tr>";
			}
			
		}else{
			return "";
		}
		$response .= '</tbody>';
		$response .= '</table>';
		return $response;
	}else{
		return "";
	}
}

function return_value_exists($search_id='',$data=array()){
	$key = -1;
	foreach($data as $k=>$v){
		if(isset($v['key'])){
			if($search_id == $v['key']){
				$key = $k;
				return $key;
			}
		}
	}
	return $key;
}

function return_header_exists($search_id='',$data=array()){
	$key = $search_id;
	$data = $data['metrics'];
	foreach($data as $k=>$v){
		if(isset($v['key'])){
			if($search_id == $v['key']){
				$key = $v['localizedName'];
				return $key;
			}
		}
	}
	
	return $key;
}

function get_columns(){
	$listing_impression_total = "The total number of times the seller's listings displayed on the search results page OR in the seller's store. The item is counted each time it displays on either page, however, the listing might not have been visible ";
	$click_through_rate = "The number of times an item displays on the search results page divided by the number of times buyers clicked through to its View Item page.";
	$listing_views_total = "Total number of listings viewed. This number sums LISTING_VIEWS_SOURCE_DIRECT, LISTING_VIEWS_SOURCE_OFF_EBAY, LISTING_VIEWS_SOURCE_OTHER_EBAY, LISTING_VIEWS_SOURCE_SEARCH_RESULTS_PAGE, and LISTING_VIEWS_SOURCE_STORE.";
	$sales_conversion_rate = "The number of completed transactions divided by the number of View Item page views. (TRANSACTION / LISTING_VIEWS_TOTAL)";
	$transaction = "The total number of completed transactions.";
	$listing_impression_search_results_page = "The number of times the seller's listings displayed on the search results page. Note, the listing might not have been visible to the buyer due to its position on the page.";
	$listing_impression_store = "The number of times the seller's listings displayed on the seller's store. Note, the listing might not have been visible to the buyer due to its position on the page.";
	$listing_views_source_direct = "The number of times a View Item page was directly accessed, such as when a buyer navigates to the page using a bookmark.";
	$listing_views_source_off_ebay = "The number of times a View Item page was accessed via a site other than eBay, such as when a buyer clicks on a link to the listing from a search engine page.";
	$listing_views_source_other_ebay = "The number of times a View Item page was accessed from an eBay page that is not either the search results page or the seller's store.";
	$listing_views_source_search_results_page = "The number of times the item displayed on the search results page.";
	$listing_views_source_store = "The number of times a View Item page was accessed via the seller's store.";
	
	
	$columns = array();
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'Item Id','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Name','value'=>'item_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'LISTING_IMPRESSION_TOTAL','value'=>'listing_impression_total','data-title'=>$listing_impression_total);
	$columns[] = array('view_column'=>'CLICK_THROUGH_RATE','value'=>'click_through_rate','data-title'=>$click_through_rate);
	$columns[] = array('view_column'=>'LISTING_VIEWS_TOTAL','value'=>'listing_views_total','data-title'=>$listing_views_total);
	$columns[] = array('view_column'=>'SALES_CONVERSION_RATE','value'=>'sales_conversion_rate','data-title'=>$sales_conversion_rate);
	$columns[] = array('view_column'=>'TRANSACTION','value'=>'transaction','data-title'=>$transaction);
	$columns[] = array('view_column'=>'eBay Suggested Ad rate','value'=>'eBay Suggested Ad rate','data-title'=>'');
	$columns[] = array('view_column'=>'Set your Ad Rate','value'=>'Set your Ad Rate','data-title'=>'');
	$columns[] = array('view_column'=>'Select Campaign','value'=>'Select Campaign','data-title'=>'');
	$columns[] = array('view_column'=>'Selected Campaign','value'=>'Selected Campaign','data-title'=>'');
	$columns[] = array('view_column'=>'Fees','value'=>'Fees','data-title'=>'');
	$columns[] = array('view_column'=>'BIN PRICE','value'=>'BIN PRICE','data-title'=>'');
	$columns[] = array('view_column'=>'eBay Recommend','value'=>'eBay Recommend','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 2','value'=>'Multi Buy 2','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 3','value'=>'Multi Buy 3','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 4','value'=>'Multi Buy 4','data-title'=>'');
	$columns[] = array('view_column'=>'LISTING_IMPRESSION_SEARCH_RESULTS_PAGE','value'=>'listing_impression_search_results_page','data-title'=>$listing_impression_search_results_page);
	$columns[] = array('view_column'=>'LISTING_IMPRESSION_STORE','value'=>'listing_impression_store','data-title'=>$listing_impression_store);
	$columns[] = array('view_column'=>'LISTING_VIEWS_SOURCE_DIRECT','value'=>'listing_views_source_direct','data-title'=>$listing_views_source_direct);
	$columns[] = array('view_column'=>'LISTING_VIEWS_SOURCE_OFF_EBAY','value'=>'listing_views_source_off_ebay','data-title'=>$listing_views_source_off_ebay);
	$columns[] = array('view_column'=>'LISTING_VIEWS_SOURCE_OTHER_EBAY','value'=>'listing_views_source_other_ebay','data-title'=>$listing_views_source_other_ebay);
	$columns[] = array('view_column'=>'LISTING_VIEWS_SOURCE_SEARCH_RESULTS_PAGE','value'=>'listing_views_source_search_results_page','data-title'=>$listing_views_source_search_results_page);
	$columns[] = array('view_column'=>'LISTING_VIEWS_SOURCE_STORE','value'=>'listing_views_source_store','data-title'=>$listing_views_source_store);
	
	return $columns;
}

?>
				</div>              
            </div>
        </div>
    </div>
</div>
<style type="text/css">
        .traffic-table table>tbody>tr>td,
        .traffic-table table>tbody>tr>th {
            white-space: nowrap;   
            border-top: 1px solid #efeded !important;
            border: 1px solid #efeded !important;
            border-color: #efeded !important;
        }
		.wrapper>footer {
			position:relative;
		}
      </style>
    <!-- Content Ends --> 
<?php include("../common/footer.php"); ?>
<script>
function clear_and_submit() {
    jQuery(function($){
		$('#search_data').val('');
        var table = $('#traffic_promotion').DataTable();
        table.search( '' );
        table.draw();
    });
}
$(document).ready(function(){
	
  $('.select-aspect').selectize({create:true,allowEmptyOption: false,closeAfterSelect:true});
  $("#ckbCheckAll").click(function(){
	  $('input:checkbox').not(this).prop('checked', this.checked);
  });
  $('#traffic_promotion').DataTable({
	  columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
	  //"sDom": '<"top"i>rt<"bottom"flp><"clear">'
	  "sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">'
	  //"dom": '<"top"flp<"clear">>rt<"bottom"ifp<"clear">>'
	//"bSort" : false,
	//"scrollX": true,
	//"scrollY": 350,
	});
	$('#traffic_promotion').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#traffic_promotion').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
	/*$('#apply_changes').click(function(){
		var selected = [];
		var post_data = [];
		$('.checkboxes input:checked').each(function() {
			selected.push($(this).val());
		});
		console.log(selected);
		var form_data = $('form').serializeArray();
		form_data = $.grep(form_data, function(value) {
			if((value.name != "traffic_promotion_length") && (value.name != "myCheckboxes[]")){
				var array = (value.name).split('_');
				var item = "ebay_item_"+array[0];
				console.log(item);
				console.log($.inArray( item, selected )>= 0);
				if($.inArray( item, selected ) >= 0){
					return value;
				}
			}
		});
	});*/
});
</script>