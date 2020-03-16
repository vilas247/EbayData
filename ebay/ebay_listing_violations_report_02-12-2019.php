<?php 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='LISTING_VIOLATIONS'";
$res_cols = mysqli_query($conn,$sql_cols);
$res_cols = $res_cols->fetch_assoc();
//print_r($res_cols);exit;
if(!empty($res_cols)){
	$db_columns = json_decode($res_cols['tabcols'],true);
}

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

if(isset($_REQUEST['compliance_type']) && $_REQUEST['compliance_type'] != '') {
	$compliance_type = $_REQUEST['compliance_type'];
}
else {
	$compliance_type = "HTTPS";
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

$name_size = 60;

include("../common/header.php"); 
?>
<style>
	.wrapper {
		overflow: visible;
	}

	.portlets-wrapper {
		overflow: visible;
	}

	.table-responsive {
		overflow: visible;
	}

</style>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional whirl" style="margin-top:55px">
		<div id="download_button" class="hide">
			<div class="btn-inventory-dashboard" style="margin: 0 15px">
				<div class="row ">
					<div class="col-lg-2 col-md-4 hide">
						<a type="button" class="btn btn-info inv-btn btn btn-primary" href="javascript:void(0);" id="apply_changes" style="background: #1665D8">
							<span class="fa fa-edit fa-lg"></span> Apply Changes
						</a>
					</div>
					<div class="col-lg-2 col-md-4">
						<a type="button" class="btn bg-green col-md-4 inv-btn" style="text-align:center" href="<?= BASE_URL ?>ebay/csvdownload/download_ebay_recommendation_enhancement_report.php?seller_ebay_id=<?= $seller_ebay_id?>" style="background: #B53471">
							<span class="fa fa-share-square"></span> Download
						</a>
					</div>
				</div>
			</div>
		</div>
      <div class="container-fluid" style="min-height: 0;">
		<div class="row">
			<div class="singleNav" style="padding-bottom:7px;">
				<p>
					<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
					<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
					<a href="<?= BASE_URL ?>#/app/inventory-dashboard">eBay Inventory</a> &gt;
					<!--<a href="<?= BASE_URL ?>#/">eBay Report</a> &gt;-->
					Listing Violations Report
				</p>
			</div>
		</div>
		<div class="row mar-top-0">
			<div class="col-lg-6 form-group">
				<label class="col-md-2 font-normal pad-left-0 mar-top-5">eBay Account:</label> 
				<div class="col-md-5">
					<select class="form-control" >
						<option value="" >Select</option>
						<option value="eBay UK" selected>eBay - eBay UK</option>
					</select>					
				</div>
				<div class="col-md-4" style="float: right;">
					<button id="apply_changes" class="btn btn-primary" style="display: none; font-weight: bold;">Apply Changes</button>
				</div>				
			</div>
			<div class="col-lg-6 form-group">
				<!-- <label class="col-md-2 pad-left-0 font-normal mar-top-5" style="text-align: right;">Search</label>  -->
				<div class="col-md-10">
					<ul class="list-inline">
						<li class="mar-right-5 col-md-9">
							<input type="text" id="search_data" placeholder="Search" class="form-control srch-filed">
						</li>
						<!--<li><a href="#" id="aSearchOrder"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>-->
						<li><a href="#" onClick='clear_and_submit();' >Clear Search</a></li>
					</ul>					
				</div>
			</div>
		</div>
		<div class="row mar-top-0">
			<div class="col-lg-6 form-group">
				<label class="col-md-2 font-normal pad-left-0 mar-top-5">ComplianceType:</label> 
				<form action="<?= BASE_URL ?>ebay/ebay_listing_violations_report.php?seller_ebay_id=<?= $seller_ebay_id ?>" method="POST" >
				<div class="col-md-5">
					<select class="form-control"name="compliance_type" >
						<option value="" >Select</option>
						<option value="HTTPS" <?= ($compliance_type == "HTTPS")?'selected':'' ?> >Non HTTPS Listing Content </option>
						<option value="RETURNS_POLICY" <?= ($compliance_type == "RETURNS_POLICY")?'selected':'' ?> >Missing Returns Policy</option>
						<option value="OUTSIDE_EBAY_BUYING_AND_SELLING" <?= ($compliance_type == "OUTSIDE_EBAY_BUYING_AND_SELLING")?'selected':'' ?> >Outside eBay Buying/Selling References</option>
					</select>					
				</div>
				<div class="col-md-4" style="float: left;">
					<button type="submit" id="apply_changes" class="btn btn-primary" style="font-weight: bold;">Submit</button>
				</div>	
				</form>
			</div>
			<div class="col-lg-6 form-group hide">
				<!-- <label class="col-md-2 pad-left-0 font-normal mar-top-5" style="text-align: right;">Search</label>  -->
				<div class="col-md-10">
					<ul class="list-inline">
						<li class="mar-right-5 col-md-9">
							<input type="text" id="search_data" placeholder="Search" class="form-control srch-filed">
						</li>
						<!--<li><a href="#" id="aSearchOrder"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>-->
						<li><a href="#" onClick='clear_and_submit();' >Clear Search</a></li>
					</ul>					
				</div>
			</div>
		</div>
		<div class="row mar-top-0" id="total_records_display">
			<div class="col-lg-6">
				<p style="padding: 0 15px" >
					<p  id="lat_updated_date" ></p> 
				</p>
			</div>
			<div class="col-lg-6 pull-right text-right">
				<a href="#" class="mar-right-30" data-toggle="modal" data-target="#settingModal" placeholder="Columns Settings">
					<img src="<?= BASE_URL?>common/images/settings-icon.682ad8cc.png">
				</a>
			</div>
		</div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive table-bordered scroll-table traffic-table">
<?php

$response = "";
$last_updated_date = "";

if(isset($_REQUEST['seller_ebay_id'])){
	$response .= '<table id="violations_report" class="dataTable no-footer table table-bordered table-striped" style="display:none">';
	$response .= '<thead>';
	$response .= '<tr role="row" class="suceess">';
	//$response .= '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
	foreach($db_columns as $dbk=>$dbv){
		if(isset($dbv['data-title'])){
			$response .= '<th>'.$dbv['view_column'].'<span title=title="'.$dbv['data-title'].'"></span></th>';
		}else{
			$response .= '<th>'.$dbv['view_column'].'</th>';
		}
	}
	$response .= '</thead>';
	$response .= '<tbody>';

	$sql_val = "select * from ebay_listing_violations_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND compliance_type='".$compliance_type."'";

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		$ii = 1;
		while($values = $res_val->fetch_assoc()){
			if(empty($last_updated_date)){
				if(isset($values['created_date'])){
					$last_updated_date = date("jS F Y h:i A",strtotime($values['created_date']));
				}
			}
			//print_r(json_encode($values));exit;
			if(!empty($values['ebay_item_id'])){
				if(($even_odd%2) == 0){
					$even = "even";
				}else{
					$even = "odd";
				}
				$even_odd++;
				$response .= '<tr role="row" class="'.$even.'">';
				//$response .= "<td><input type='checkbox' style='display:block;margin:5px auto;' id='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				foreach($db_columns as $dbk=>$dbv){
					if(isset($values[$dbv['value']])){
						if($dbv['value'] == "id"){
							$response .= '<td>'.($even_odd-1).'</td>';
						}
						else if($dbv['value'] == "ebay_item_id"){
							$response .= "<td><a target='_blank' href='https://www.ebay.co.uk/itm/".$values[$dbv['value']]."'>".$values[$dbv['value']]."</a></td>";
						}else if($dbv['value'] == "item_name"){
							$response .= '<td>'.replace_text_trim($name_size,$values[$dbv['value']]).'</td>';
						}else if($dbv['value'] == "item_sku"){
							$response .= "<td><a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values[$dbv['value']]."'>".$values[$dbv['value']]."</a></td>";
						}
						else if($dbv['value'] == "message"){
							$read_more = '';
							if(strlen($values[$dbv['value']]) > $name_size){
								$read_more = '<span data-toggle="collapse" data-target="#deno_'.$even_odd.'" >Read More..</span><div class="collapse" id="deno_'.$even_odd.'">'.$values[$dbv['value']].'</div>';
							}
							//$response .= '<td style="width:450px;word-wrap: break-word"><p data-title="'.$values[$dbv['value']].'">'.replace_text_trim($name_size,$values[$dbv['value']]).'</p></td>';
							$response .= '<td style="width:450px;word-wrap: break-word"><p data-title="'.$values[$dbv['value']].'">'.replace_text_trim($name_size,$values[$dbv['value']]).'</p>'.$read_more.'</td>';
						}else if($dbv['value'] == "created_date"){
							$response .= '<td>'.date("Y-m-d h:i A",strtotime($values[$dbv['value']])).'</td>';
						}else{
							$response .= '<td>'.$values[$dbv['value']].'</td>';
						}
					}else{
						$response .= '<td>&nbsp;</td>';
					}
				}
				$response .= "</tr>";
			}
			
		}
	}
	$response .= '</tbody>';
	$response .= '</table>';
	echo $response;
}

function replace_text_trim($size,$text){
	if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}
}

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SL No','value'=>'id','data-title'=>'');
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Compliance Type','value'=>'compliance_type','data-title'=>'Name');
	$columns[] = array('view_column'=>'Action to take','value'=>'message','data-title'=>'');
	//$columns[] = array('view_column'=>'Report last updated ','value'=>'created_date','data-title'=>'');
	return $columns;
}

function check_val_exist($arr,$val){
	$status = false;
	foreach($arr as $k=>$v){
		if($v['value'] == $val){
			$status = true;
			break;
		}
	}
	return $status;
}

?>
				</div>              
            </div>
        </div>
    </div>
</div>
    <!-- Content Ends --> 
<?php include("../common/footer.php"); ?>
<div id="settingModal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Customise Dashboard View</b></h4>
					</div>
					<div class="col-md-9 return-manage-pop-check pad-right-10">
						<h4 style="margin-left: 0px; font-weight: normal; margin-bottom: 20px">Pick the columns you want to view</h4>
						<label class="checkbox-inline c-checkbox col-xs-3">
							<input type="checkbox" id="check_all" onchange="checkAllSortable(this)" <?= (count($db_columns) == count($total_cols)) ? "checked": "" ?> > <span class="fa fa-check"></span>Select All
						</label>
						<?php foreach($total_cols as $sk=>$sv){ 
							$checked = check_val_exist($db_columns,$sv['value']);
							if($checked){
								$checked = "checked";
							}else{
								$checked = "";
							}
							if($sv['view_column'] == "SKU"){
								$disabled = "disabled checked";
							}else{
								$disabled = "";
							}
						?>
							<label class="checkbox-inline c-checkbox col-xs-3" style="">
							<input name="selectedCols[]" <?= $checked ?> <?= $disabled ?> value="<?= $sv['view_column'] ?>" onchange="checkAllSortableSingle(this)" type="checkbox" id="<?= $sv['value'] ?>"> <span class="fa fa-check"></span><?= $sv['view_column'] ?>
						</label>
						<?php } ?>
					</div>
					<div class="col-md-3">
						<h4 style="margin-left: -20px;  font-weight: normal">Arrange Columns</h4>
						<div class="add-product-ul-li">
							<ul style="height: 245px; margin-bottom: 20px" id="sortable1" class="ui-sortable">
								<?php foreach($db_columns as $k=>$v){ ?>
									<li class="ui-state-default" name="<?= $v['view_column'] ?>" id="<?= $v['value'] ?>"> <?= str_replace("<br>"," ",$v['view_column']) ?> </li>
								<?php } ?>
							</ul>
							<div class="arrow-return-alignment" style="float: right; width: 30px">
								<em class="fa fa-arrow-up fa-lg"></em> <em class="fa fa-arrow-down fa-lg"></em>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-3 pull-right mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15" data-type="LISTING_VIOLATIONS" id="setting_apply"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.download_button{
	text-align:center;
	width:145px;
	float:right;
	margin-right:10px;
	margin-top:3px;
}
.modal-backdrop.fade.in{
	z-index:-1;
}
</style>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script>
var table_html="";
table_html = $('.traffic-table').html();
var download_button = '<a type="button" class="btn bg-green col-md-4 inv-btn download_button" href="<?= BASE_URL ?>ebay/csvdownload/download_ebay_listing_violations_report.php?seller_ebay_id=<?= $seller_ebay_id?>" style="background: #1289A7"><span class="fa fa-download fa-lg"></span> Download</a>';
$('#lat_updated_date').append('Report Last Updated: <?= $last_updated_date ?>');
function clear_and_submit() {
	jQuery(function($){
		$('#search_data').val('');
        var table = $('#violations_report').DataTable();
        table.search( '' );
        table.draw();
    });
}
function change_limit(value){
	var limit_array = [25,50,100,200];
	var final_html = '<div class="dataTables_paginate paging_simple_numbers" id="aspect_adoptions_paginate" ><span>';
	for(var i=0;i<limit_array.length;i++){
		var selected = '';
		if(limit_array[i] == value){
			selected = 'current';
		}
		final_html += '<a class="paginate_button limit_change '+selected+'" onClick="change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="violations_report">'+limit_array[i]+'</a>';
	}
	final_html += '</span></div>';
	return final_html;
}

function change_limit_data(limit){
	$('.traditional').addClass('whirl');
	$('.traffic-table').html('');
	$('.traffic-table').html(table_html);
	$('#violations_report').DataTable({
		//destroy: true,
		fixedHeader: {
						header: true
					},
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		"pageLength": limit,
		info:false,
		"language":{
			"lengthMenu": change_limit(limit),
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		}
	});
	$('#violations_report').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#violations_report_paginate').after(download_button);
	$('.traditional').removeClass('whirl');
}

$(document).ready(function(){
$(function () {
	$('.close_settings').click(function(){
		$('#settingModal').modal('hide');
	});
   $("#sortable1").sortable();
   $("#sortable1").disableSelection();
   var selected = 0;

   var itemlist = $('#sortable1');
   var len = $(itemlist).children().length;

   $("#sortable1 li").click(function () {
      selected = $(this).index();
      if ($("#sortable1 li").hasClass('select')) {
          $("#sortable1 li").removeClass('select');
          $(this).addClass("select");
      } else {
          $(this).addClass("select");
      }
      //alert("Selected item is " + $(this).text());

   });
});
  $('.select-aspect').selectize({create:true,allowEmptyOption: false,closeAfterSelect:true});
  $("#ckbCheckAll").click(function(){
	  $('input:checkbox').not(this).prop('checked', this.checked);
  });
  $('#violations_report').DataTable({
		fixedHeader: {
						header: true
					},
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		info:false,
		"pageLength": 100,
		"language":{
			"lengthMenu": change_limit(100),
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		 }
	});
	$('#violations_report').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#violations_report_paginate').after(download_button);
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#violations_report').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
	$('#search_data').val('');
});
</script>