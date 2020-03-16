<?php 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='CAMPAIGN_REPORT'";
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
	<div class="portlets-wrapper traditional whirl" style="margin-top:70px">
      <div class="container-fluid" style="min-height: 0;">
		<div class="row">
			<div class="singleNav" style="padding-bottom:7px;">
				<p>
					<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
					<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
					<a href="<?= BASE_URL ?>#/app/inventory-dashboard">eBay Inventory</a> &gt;
					<a href="<?= BASE_URL ?>ebay/get_ebay_traffic_pomotion_report.php?seller_ebay_id=<?php echo $seller_ebay_id; ?>">Analytics Promotion Report</a> &gt;
					eBay Campaign Report
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
		<div class="row mar-top-0" id="total_records_display">
			<div class="col-lg-6 hide">
				<p style="padding: 0 15px" >
						<strong  class="total_records" ></strong> 
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
	$response .= '<table id="campaign_report" class="dataTable no-footer table table-bordered table-striped" style="display:none">';
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

	$sql_val = "select * from ebay_campaign_report WHERE ebay_seller_id='".$seller_ebay_id."'";

	//echo $sql_val;exit;
	$res_val = mysqli_query($conn,$sql_val);
	if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
		$even_odd = 1;
		$ii = 1;
		while($values = $res_val->fetch_assoc()){
			//print_r(json_encode($values));exit;
			if(!empty($values['campaign_name'])){
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
						else if($dbv['value'] == "start_date" || $dbv['value'] == "end_date" || $dbv['value'] == "created_date"){
							$response .= '<td>'.date("Y-m-d h:i A",strtotime($values[$dbv['value']])).'</td>';
						}
						else if($dbv['value'] == "bid_percentage"){
							$response .= '<td>'.$values[$dbv['value']].'%</td>';
						}
						else{
							$response .= '<td>'.$values[$dbv['value']].'</td>';
						}
					}else{
						if($dbv['value'] == "action"){
							$button = "";
							if($values['status'] == "RUNNING"){
								$button .= '<a type="button" class="btn bg-green col-md-4 inv-btn add_button pause_campaign" data-id="'.$values['campaign_id'].'" href="#" style="width:80px;float:left;">PAUSE</a>';
								$button .= '<a type="button" class="btn btn-danger inv-btn add_button end_campaign" data-id="'.$values['campaign_id'].'" href="#" style="width:80px;float:left;">END</a>';
							}
							if($values['status'] == "PAUSED"){
								$button .= '<a type="button" class="btn bg-green col-md-4 inv-btn add_button resume_campaign" data-id="'.$values['campaign_id'].'" href="#" style="width:80px;float:left;">RESUME</a>';
								$button .= '<a type="button" class="btn btn-danger inv-btn add_button end_campaign" data-id="'.$values['campaign_id'].'" href="#" style="width:80px;float:left;">END</a>';
							}
							$response .= '<td><a type="button" class="btn btn-info inv-btn add_button edit_campaign" data-id="'.base64_encode(json_encode($values['id'],true)).'" href="#" style="width:80px;float:left;">EDIT</a>'.$button.'</td>';
						}else{
							$response .= '<td>&nbsp;</td>';
						}
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
	$columns[] = array('view_column'=>'Campaign Name','value'=>'campaign_name','data-title'=>'sku');
	$columns[] = array('view_column'=>'Funding Model','value'=>'funding_model','data-title'=>'Listing attached');
	$columns[] = array('view_column'=>'Bid Percentage','value'=>'bid_percentage','data-title'=>'Listing attached');
	$columns[] = array('view_column'=>'Start date','value'=>'start_date','data-title'=>'');
	$columns[] = array('view_column'=>'End date','value'=>'end_date','data-title'=>'');
	$columns[] = array('view_column'=>'Status','value'=>'status','data-title'=>'Status');
	$columns[] = array('view_column'=>'Created By','value'=>'created_by','data-title'=>'');
	$columns[] = array('view_column'=>'Created Date','value'=>'created_date','data-title'=>'');
	$columns[] = array('view_column'=>'Action','value'=>'action','data-title'=>'');
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
						<h4 class="modal-title"><b>Customise Dashboard View<b></h4>
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
									<li class="ui-state-default" name="<?= $v['view_column'] ?>" id="<?= $v['value'] ?>"> <?= $v['view_column'] ?> </li>
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
							<button class="btn btn-theme mar-left-15" data-type="CAMPAIGN_REPORT" id="setting_apply"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="addCampaign" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-mg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Add New Campaign<b></h4>
					</div>
					<div class="col-md-12">
						<form action="<?= BASE_URL ?>ebay/save_ebay_campaign_report.php" id="campaign_form"  method="POST">
							<input type="hidden" name="ebay_seller_id" value="<?= $seller_ebay_id ?>"/>
							<div class="form-group row">
								<label for="campaignName" class="col-sm-4 col-form-label">eBay Marketplace :</label>
								<div class="col-sm-8">
								  <select class="form-control" name="market_place_id" id="market_place_id" >
									<option value="EBAY_GB" selected="">eBay GB</option>
									<option value="EBAY_US">eBay US</option>
									<option value="EBAY_DE">eBay Germany</option>
								  </select>
								</div>
							</div>
							<div class="form-group row">
								<label for="campaignName" class="col-sm-4 col-form-label">Campaign Name :</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="campaign_name" id="campaign_name" >
								</div>
							</div>
							<div class="form-group row">
								<label for="fundingModel" class="col-sm-4 col-form-label">Funding Model :</label>
								<div class="col-sm-8">
									<select name="funding_model" class="form-control">
										<option value="COST_PER_SALE">Cost Per Sale</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="bidPercentage" class="col-sm-4 col-form-label">Bid Percentage :</label>
								<div class="col-sm-8">
								  <input type="number" class="form-control" name="bid_percentage" id="bid_percentage" >
								</div>
							</div>
							<div class="form-group row">
								<label for="startDate" class="col-sm-4 col-form-label">Start Date :</label>
								<div class="col-sm-8">
								  <input type="date" class="form-control" name="start_date" id="start_date" >
								</div>
							</div>
							<div class="form-group row">
								<label for="startDate" class="col-sm-4 col-form-label">Start Time :</label>
								<div class="col-sm-8">
								  <input type="time" class="form-control" name="start_time" id="start_time" value="00:00"  >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label">End Date :</label>
								<div class="col-sm-8">
								  <input type="date" class="form-control" name="end_date" id="end_date" >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label">End Time :</label>
								<div class="col-sm-8">
								  <input type="time" class="form-control" name="end_time" id="end_time" value="00:00" >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
							<div class="clear"></div>
						</form>					
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div id="editCampaign" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-mg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Edit Campaign<b></h4>
					</div>
					<div class="col-md-12">
						<form action="" id="update_campaign_form"  method="POST">
							<input type="hidden" name="ebay_seller_id" value="<?= $seller_ebay_id ?>"/>
							<input type="hidden" class="form-control" name="campaign_id" id="campaign_id_edit" >
							<div class="form-group row">
								<label for="campaignName" class="col-sm-4 col-form-label">Campaign Name :</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="campaign_name" id="campaign_name_edit" >
								</div>
							</div>
							<div class="form-group row">
								<label for="startDate" class="col-sm-4 col-form-label">Start Date :</label>
								<div class="col-sm-8">
								  <input type="date" class="form-control" name="start_date" id="start_date_edit" >
								</div>
							</div>
							<div class="form-group row">
								<label for="startDate" class="col-sm-4 col-form-label">Start Time :</label>
								<div class="col-sm-8">
								  <input type="time" class="form-control" name="start_time" id="start_time_edit" >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label">End Date :</label>
								<div class="col-sm-8">
								  <input type="date" class="form-control" name="end_date" id="end_date_edit" >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label">End Time :</label>
								<div class="col-sm-8">
								  <input type="time" class="form-control" name="end_time" id="end_time_edit" >
								</div>
							</div>
							<div class="form-group row">
								<label for="endDate" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
							<div class="clear"></div>
						</form>					
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.add_button{
	text-align:center;
	width:140px;
	float:right;
	margin-right:10px;
	margin-top:3px;
}
.modal-backdrop.fade.in{
	z-index:-1;
}
select,
input {
	font-weight: 400 !important;
}
</style>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script>
var table_html="";
table_html = $('.traffic-table').html();
var add_button = '<a type="button" class="btn bg-green col-md-4 inv-btn add_button" data-toggle="modal" data-target="#addCampaign" href="#" style="background: #B53471"><span class="fa fa-plus"></span> Add Campaign</a>';
function clear_and_submit() {
	jQuery(function($){
		$('#search_data').val('');
        var table = $('#campaign_report').DataTable();
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
		final_html += '<a class="paginate_button limit_change '+selected+'" onClick="change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="campaign_report">'+limit_array[i]+'</a>';
	}
	final_html += '</span></div>';
	return final_html;
}

function change_limit_data(limit){
	$('.traditional').addClass('whirl');
	$('.traffic-table').html('');
	$('.traffic-table').html(table_html);
	$('#campaign_report').DataTable({
		//destroy: true,
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		"pageLength": limit,
		info:false,
		"language":{
			"lengthMenu": change_limit(limit)
		}
	});
	$('#campaign_report').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#campaign_report_paginate').after(add_button);
	$('.traditional').removeClass('whirl');
}

$(document).ready(function(){
	$('.close_settings').click(function(){
		$('#settingModal').modal('hide');
	})
	$('.edit_campaign').click(function(e){
		$('.traditional').addClass('whirl');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/get_ebay_campaign_data.php',
			async: true,
			cache: true,
			data: {id:$(this).attr('data-id')},
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res.status) {
					var data = res.data;
					$('#campaign_id_edit').val(data.campaign_id);
					$('#campaign_name_edit').val(data.campaign_name);
					$('#start_date_edit').val(data.startDate);
					$('#start_time_edit').val(data.startTime);
					$('#end_date_edit').val(data.endDate);
					$('#end_time_edit').val(data.endTime);
					$('#editCampaign').modal('show');
				} else {
					$('#campaign_id_edit').val('');
					$('#campaign_name_edit').val('');
					$('#start_date_edit').val('');
					$('#start_time_edit').val('');
					$('#end_date_edit').val('');
					$('#end_time_edit').val('');
					alert("Some error occured");
				}
			}
		});
	});
	$('#update_campaign_form').submit(function(e){
		$('.traditional').addClass('whirl');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/update_ebay_campaign.php',
			async: true,
			cache: true,
			data: $('#update_campaign_form').serialize(),
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res) {
					location.reload(true);
				} else {
					alert("Some error occured");
				}
			}
		});
	});
	$('.resume_campaign').click(function(e){
		$('.traditional').addClass('whirl');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/resume_ebay_campaign.php',
			async: true,
			cache: true,
			data: {campaign_id:$(this).attr('data-id')},
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res) {
					location.reload(true);
				} else {
					alert("Some error occured");
				}
			}
		});
	});
	$('.pause_campaign').click(function(e){
		$('.traditional').addClass('whirl');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/pause_ebay_campaign.php',
			async: true,
			cache: true,
			data: {campaign_id:$(this).attr('data-id')},
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res) {
					location.reload(true);
				} else {
					alert("Some error occured");
				}
			}
		});
	});
	$('.end_campaign').click(function(e){
		$('.traditional').addClass('whirl');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/_ebay_campaign.php',
			async: true,
			cache: true,
			data: {campaign_id:$(this).attr('data-id')},
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res) {
					location.reload(true);
				} else {
					alert("Some error occured");
				}
			}
		});
	});
  $('#campaign_report').DataTable({
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
	$('#campaign_report').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#campaign_report_paginate').after(add_button);
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#campaign_report').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
	
	$('#campaign_form').on("submit", function( e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: app_base_url + 'ebay/campaign/save_ebay_campaign_data.php',
			async: true,
			cache: true,
			data: $('#campaign_form').serialize(),
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if (res) {
					location.reload(true);
				} else {
					alert("Some error occured");
				}
			}
		});
		
	});
});
</script>