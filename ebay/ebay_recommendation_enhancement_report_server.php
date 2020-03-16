<?php 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='RECOMMENDED_ENHANCEMENT'";
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
$currency = '£';
$name_size = 60;
$total_cols = get_columns();


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
.download_button{
	text-align:center;
	width:145px;
	float:right;
	margin-right:10px;
	margin-top:3px;
}
.show-read-more .more-text{
    display: none;
}
.modal-backdrop.fade.in{
	z-index:-1;
}
</style>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional whirl" style="margin-top:55px">
		<div class="container-fluid" style="min-height: 0;">
			<div class="row">
				<div class="singleNav" style="padding-bottom:7px;">
					<p>
						<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
						<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
						<a href="<?= BASE_URL ?>#/app/inventory-dashboard">eBay Inventory</a> &gt;
						<!--<a href="<?= BASE_URL ?>#/">eBay Report</a> &gt;-->
						Catalogue Enhancement Report 
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
$total_records = 0;
if(isset($_REQUEST['seller_ebay_id'])){
	$response .= '<table id="recomedation_enhancement" class="dataTable no-footer table table-bordered table-striped" style="display:none">';
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
	
	$response .= '</tbody>';
	$response .= '</table>';
	echo $response;
}

function replace_text_trim($size,$text){
	return $text;
	/*if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}*/
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

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SL No','value'=>'id','data-title'=>'');
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Buy it Now<br>Price ','value'=>'item_bin_price','data-title'=>'');
	$columns[] = array('view_column'=>'Picture Recommendations','value'=>'picture','data-title'=>'');
	//$columns[] = array('view_column'=>'URL','value'=>'picture_url','data-title'=>'');
	$columns[] = array('view_column'=>'Fast and Free Badge Feedback','value'=>'fnf','data-title'=>'');
	$columns[] = array('view_column'=>'Expedited Shipping Recommendation','value'=>'expedited_shipping','data-title'=>'');
	$columns[] = array('view_column'=>'Free Shipping Recommendation','value'=>'free_shipping','data-title'=>'');
	//$columns[] = array('view_column'=>'Item Returns','value'=>'item_returns','data-title'=>'');
	//$columns[] = array('view_column'=>'Trackable Service Provider','value'=>'trackable_service_provided','data-title'=>'');
	//$columns[] = array('view_column'=>'Fast and Free','value'=>'price_listing_details','data-title'=>'');
	return $columns;
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
							<button class="btn btn-danger mar-left-15"> Cancel </button>
							<button class="btn btn-theme mar-left-15" data-type="RECOMMENDED_ENHANCEMENT" id="setting_apply"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script>
$(function () {
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
var table_html="";
table_html = $('.traffic-table').html();
var download_button = '<a type="button" class="btn bg-green col-md-4 inv-btn download_button" href="<?= BASE_URL ?>ebay/csvdownload/download_ebay_recommendation_enhancement_report.php?seller_ebay_id=<?= $seller_ebay_id?>" style="background: #1289A7"><span class="fa fa-download fa-lg"></span> Download</a>';
$('#lat_updated_date').append('Report Last Updated: <?= $last_updated_date ?>');
function clear_and_submit() {
	jQuery(function($){
		$('#search_data').val('');
        var table = $('#recomedation_enhancement').DataTable();
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
		final_html += '<a class="paginate_button limit_change '+selected+'" onClick="change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="recomedation_enhancement">'+limit_array[i]+'</a>';
	}
	final_html += '</span></div>';
	return final_html;
}

function change_limit_data(limit){
	$('.traditional').addClass('whirl');
	$('.traffic-table').html('');
	$('.traffic-table').html(table_html);
	$('#recomedation_enhancement').DataTable({
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
		},
		"processing": true,
        "serverSide": true,
        "ajax": {
			"url": app_base_url+"ebay/scripts/recommendations_processing.php?seller_ebay_id=<?= $seller_ebay_id ?>",
			dataFilter: function(data){
				var json = jQuery.parseJSON( data );
				return data;
			},
		},
		initComplete: function() {
			read_more_f(60);
		}
	});
	$('#recomedation_enhancement').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#recomedation_enhancement_paginate').after(download_button);
	$('.traditional').removeClass('whirl');
}
function read_more_f(maxLength){
	$(".show-read-more").each(function(){
		var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr+"<br>");
			var removedStr1 = "";
			for(var i=0;i<removedStr.length;i=i+maxLength){
				removedStr1 += removedStr.substring(i, i+maxLength);
				removedStr1 += "<br>";
			}
			$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
			$(this).append('<span class="more-text">' + removedStr1 + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});
}

$(document).ready(function(){
	$('#recomedation_enhancement').DataTable({
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
		},
		"processing": true,
        "serverSide": true,
        "ajax": {
			"url": app_base_url+"ebay/scripts/recommendations_processing.php?seller_ebay_id=<?= $seller_ebay_id ?>",
			dataFilter: function(data){
				var json = jQuery.parseJSON( data );
				return data;
			},
		},
		initComplete: function() {
			read_more_f(60);
		}
	});
	$('#recomedation_enhancement').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#recomedation_enhancement_paginate').after(download_button);
	//$('.total_records').text('Total Records :<?= $total_records ?>');
	//$('#total_records_display').removeClass('hide');
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#recomedation_enhancement').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
});
</script>