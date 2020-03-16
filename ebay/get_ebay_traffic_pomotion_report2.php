<?php include("../common/header.php"); 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
$name_size = 60;
$currency = '£';
$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='TRAFFIC_PROMOTION'";
$res_cols = mysqli_query($conn,$sql_cols);
$res_cols = $res_cols->fetch_assoc();
//print_r($res_cols);exit;
if(!empty($res_cols)){
	$db_columns = json_decode($res_cols['tabcols'],true);
}
//print_r($db_columns);
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
	.display_flex{
		display:flex;
	}
	.selectize-control {
		min-width: 200px;
	}

	.selectize-dropdown {
		width: 200px !important;
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
					Analytics Promotion Report
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
					<button id="apply_changes" class="btn btn-primary" style="font-weight: bold;">Apply Changes(0)</button>
				</div>				
			</div>
			<div class="col-lg-6 form-group">
				<!-- <label class="col-md-2 pad-left-0 font-normal mar-top-5" style="text-align: right;">Search</label>  -->
				<div class="col-md-10">
					<ul class="list-inline">
						<li class="mar-right-5 col-md-9">
							<input type="text" id="search_data" placeholder="Search" class="form-control srch-filed">
						</li>
						<li><a href="#" id="aSearchOrder"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>
						<li><a href="#" onClick='clear_and_submit();' >Clear Search</a></li>
					</ul>					
				</div>
			</div>
		</div>
		<div class="row mar-top-0">
			<div class="col-lg-6 form-group">
				<label class="col-md-2 font-normal pad-left-0 mar-top-5">eBay Recommended:</label> 
				<div class="col-md-5">
					<select class="form-control" id="recommended_filter" >
						<option value="" >Show all</option>
						<option value="Recommended">Recommended</option>
						<option value="Eligible Best Offer" data-offer="offer" >Eligible Best Offers</option>
					</select>					
				</div>
				<div class="col-md-4" style="float: right;">
					<button id="apply_changes" class="btn btn-primary" style="display: none; font-weight: bold;">Apply Changes</button>
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
				<form role="form" method="post" action="#" class="form-inline">
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
$response = "";
$last_updated_date = "";
$get_campaings_api = array();
if(isset($_REQUEST['seller_ebay_id'])){
	$get_campaings = file_get_contents(GET_CAMPAIGN_API_URL."?seller_ebay_id=".$seller_ebay_id); 
	$get_campaings = json_decode($get_campaings,true);
	$options = "";
	if(isset($get_campaings['campaigns'])){
		foreach($get_campaings['campaigns'] as $k=>$v){
			$bid_perc = 0;
			$get_campaings_api[$v['campaignId']] = 0;
			if(isset($v['fundingStrategy']['bidPercentage'])){
				$bid_perc = $v['fundingStrategy']['bidPercentage'];
				$get_campaings_api[$v['campaignId']] = $bid_perc;
			}
			$options .="<option data-bidPercentage='".$bid_perc."' value='".$v['campaignId']."' >".$v['campaignName']."</option>";
		}
	}
	$get_campaings_api = json_encode($get_campaings_api);
	//print_r(json_encode($get_campaings_api));exit;
	
	if(!empty($db_columns) ){
		$response .= '<table id="traffic_promotion" class="dataTable no-footer table table-bordered table-striped" style="display:none">';
		$response .= '<thead>';
		$response .= '<tr role="row" class="suceess">';
		$response .= '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
		foreach($db_columns as $dbk=>$dbv){
			if(isset($dbv['data-title'])){
				$response .= '<th>'.$dbv['view_column'].'<span title=title="'.$dbv['data-title'].'"></span></th>';
			}else{
				$response .= '<th>'.$dbv['view_column'].'</th>';
			}
		}
		//$response .= '<th >Eligible Best Offer</th>';
		$response .= '</thead>';
		$response .= '<tbody>';
		
		$response .= '</tbody>';
		$response .= '</table>';
		echo $response;
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

function replace_text_trim($size,$text){
	if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}
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
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'item_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Buy it Now<br>Price','value'=>'item_bin_price','data-title'=>'');
	$columns[] = array('view_column'=>'Transaction<br>count','value'=>'transaction','data-title'=>$transaction);
	$columns[] = array('view_column'=>'eBay Suggested<br>Ad rate','value'=>'trending_rate_value','data-title'=>'');
	$columns[] = array('view_column'=>'Set your<br>Ad Rate','value'=>'select_ebay_value','data-title'=>'');
	$columns[] = array('view_column'=>'Select Campaign','value'=>'select_campain','data-title'=>'');
	$columns[] = array('view_column'=>'Selected Campaign','value'=>'selected_campaign','data-title'=>'');
	//$columns[] = array('view_column'=>'Fees','value'=>'final_fees','data-title'=>'');
	//$columns[] = array('view_column'=>'eBay Recommend','value'=>'promotion_with_ad','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 2','value'=>'multi_buy_2','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 3','value'=>'multi_buy_3','data-title'=>'');
	$columns[] = array('view_column'=>'Multi Buy 4','value'=>'multi_buy_4','data-title'=>'');
	$columns[] = array('view_column'=>'Total listing impressions','value'=>'listing_impression_total','data-title'=>$listing_impression_total);
	$columns[] = array('view_column'=>'Click through rate','value'=>'click_through_rate','data-title'=>$click_through_rate);
	$columns[] = array('view_column'=>'Total views','value'=>'listing_views_total','data-title'=>$listing_views_total);
	$columns[] = array('view_column'=>'Sales conversion rate','value'=>'sales_conversion_rate','data-title'=>$sales_conversion_rate);
	
	$columns[] = array('view_column'=>'Listing Impressions<br>Search Page','value'=>'listing_impression_search_results_page','data-title'=>$listing_impression_search_results_page);
	$columns[] = array('view_column'=>'Listing Impressions<br>Store','value'=>'listing_impression_store','data-title'=>$listing_impression_store);
	$columns[] = array('view_column'=>'Views from<br>search results page','value'=>'listing_views_source_direct','data-title'=>$listing_views_source_direct);
	$columns[] = array('view_column'=>'Off eBay views','value'=>'listing_views_source_off_ebay','data-title'=>$listing_views_source_off_ebay);
	$columns[] = array('view_column'=>'Other eBay views','value'=>'listing_views_source_other_ebay','data-title'=>$listing_views_source_other_ebay);
	$columns[] = array('view_column'=>'Views from the search results page','value'=>'listing_views_source_search_results_page','data-title'=>$listing_views_source_search_results_page);
	$columns[] = array('view_column'=>'Views from<br>your Store','value'=>'listing_views_source_store','data-title'=>$listing_views_source_store);
	
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

function get_multi_buy2(){
	$return = "<option value=''>-Select-</option>";
	for($i=1;$i<=80;$i++){
		$return .= "<option value='".$i."'>".$i."</option>";
	}
	return $return;
}

?>
				</form>
				</div>              
            </div>
        </div>
    </div>
</div>
<div id="offerPercentage" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Offer Percentage</h4>
					</div>
					<div class="col-md-8">
					 <div class="form-group">
						<label for="email">Offer Percentage:</label>
						<input class="form-control" type="number" name="offer_percentage" />
					  </div>					  
					</div>
					<div class="col-md-4" style="padding-top: 40px;">
					 <div class="form-group">
						<button class="btn bg-green" >Apply</button>
					 </div>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
							<button class="btn btn-theme mar-left-15" data-type="TRAFFIC_PROMOTION" id="setting_apply"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
    <!-- Content Ends --> 
<?php include("../common/footer.php"); ?>
<style>
.download_button, .send_offer, .view_campaign,.ebay_adrate{
	text-align:center;
	width:200px;
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
$('#lat_updated_date').append('Report Last Updated: <?= $last_updated_date ?>');
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
var table_html="";
var selected_skus = [];
table_html = $('.traffic-table').html();
var view_campaign = '<a type="button" class="btn bg-green col-md-4 inv-btn view_campaign" href="<?= BASE_URL ?>ebay/ebay_campaign_report.php?seller_ebay_id=<?= $seller_ebay_id?>" style="background: #3F51B5"><span class="fa fa-list-ul fa-lg"></span> View Campaign</a>';

var download_button = '<a type="button" class="btn bg-green col-md-4 inv-btn download_button" href="<?= BASE_URL ?>ebay/csvdownload/download_ebay_traffic_promotion_report.php?seller_ebay_id=<?= $seller_ebay_id?>" style="background: #1289A7"><span class="fa fa-download fa-lg"></span> Download</a>';
var send_offer = '<a type="button" class="btn bg-green col-md-4 inv-btn send_offer" style="display:none" data-toggle="modal" data-target="#offerPercentage" href="#" style="background: #B53471"><span class="fa fa-share-square"></span> Send Offer</a>';
var eBay_suggested_ad_rate = '<a type="button" href="#" class="btn bg-green col-md-4 inv-btn ebay_adrate" onClick="eBay_addrate()" href="#" style="background: #B53471"><span class="fa fa-share-square"></span> Apply Suggested Ad Rate</a>';
var campaigns_data = '<?= $get_campaings_api ?>';
var campaigns_data = $.parseJSON(campaigns_data);

function clear_and_submit() {
    jQuery(function($){
		$('#search_data').val('');
        var table = $('#traffic_promotion').DataTable();
        table.search( '' );
        table.draw();
    });
}
function calculate_fees(item_id){
	var _select_your_ebay_value = parseFloat(($('#'+item_id+'_select_your_ebay_value').val()).replace('£',''));
	var ebay_item_bin_price_ = parseFloat(($('#ebay_item_bin_price_'+item_id).text()).replace('£',''));
	if($.isNumeric(_select_your_ebay_value) && $.isNumeric(ebay_item_bin_price_)){
		var fin_price = (_select_your_ebay_value * ebay_item_bin_price_)/100;
		$('#'+item_id+"_final_fees").text("Cost :<?= $currency ?>"+parseFloat(fin_price).toFixed(2));
	}else{
		$('#'+item_id+"_final_fees").text("Cost :<?= $currency ?>"+0);
	}
	
}
function change_limit(value){
	var limit_array = [25,50,100,200];
	var final_html = '<div class="dataTables_paginate paging_simple_numbers" id="aspect_adoptions_paginate" ><span>';
	for(var i=0;i<limit_array.length;i++){
		var selected = '';
		if(limit_array[i] == value){
			selected = 'current';
		}
		final_html += '<a class="paginate_button limit_change '+selected+'" onClick="change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="traffic_promotion">'+limit_array[i]+'</a>';
	}
	final_html += '</span></div>';
	return final_html;
}

function change_limit_data(limit){
	$('.traditional').addClass('whirl');
	/*$('#traffic_promotion').DataTable({
		destroy: true,
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		//"bSort" : false,
		"pageLength": limit,
		info:false,
		"language":{
			"lengthMenu": change_limit(limit),
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		}
	});*/
	$('#traffic_promotion').DataTable({
		destroy: true,
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		info:false,
		"pageLength": limit,
		"language":{
			"lengthMenu": change_limit(limit)
		},
		"processing": true,
        "serverSide": true,
        "ajax": "scripts/traffic_report_processing.php?seller_ebay_id=<?= $seller_ebay_id ?>"
	});
	$('#traffic_promotion').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#traffic_promotion_paginate').after(download_button);
	$('.download_button').after(send_offer);
	$('.download_button').after(view_campaign);
	$('.view_campaign').after(eBay_suggested_ad_rate);
	$('.traditional').removeClass('whirl');
}
function get_multi_buy(buy){
	var data = "<option value=''>-Select-</option>";
	if(parseInt(buy) < 80){
		buy = parseInt(buy) + 1;
		for(var i=parseInt(buy);i<=80;i++){
			data += "<option value='"+i+"'>"+i+"</option>";
		}
	}
	return data;
}
function eBay_addrate(){
	$(".ebay_suggested_addrate").each(function() {
		var id = $(this).attr('id');
		var item_id = id.replace("ebay_value_","");
		var _select_your_ebay_value = parseFloat(($('#'+id).text()).replace('£',''));
		var selected_ebay_id = item_id+"_select_your_ebay_value";
		var selected_ebay_value = parseFloat($('#'+selected_ebay_id).val());
		if(parseFloat(selected_ebay_value) > 0){
			
		}else{
			if(parseFloat(_select_your_ebay_value) > 0){
				$('#'+selected_ebay_id).val(_select_your_ebay_value);
				calculate_fees(item_id);
			}
		}
		
	});
}
$(document).ready(function(){
	$('.select-aspect,.select_ebay_value,.multi_buy2,.multi_buy3,.multi_buy4').on('change',function(){
		var sku_data = $(this).attr('name');
		var array = (sku_data).split('_');
		if($(this).hasClass('multi_buy2')){
			$('select[name="'+array[0]+'_multi_buy_3"]').html(get_multi_buy($(this).val()));
			var bidP = $(this).val();
			var ebay_item_bin_price_ = parseFloat(($('#ebay_item_bin_price_'+array[0]).text()).replace('£',''));
			if($.isNumeric(bidP) && $.isNumeric(ebay_item_bin_price_)){
				//var fin_price = (bidP * (ebay_item_bin_price_*2))/100;
				var fin_price = (bidP * (ebay_item_bin_price_))/100;
				$('#'+array[0]+"_multibuy_2_fees").text("Cost :<?= $currency ?>"+parseFloat(fin_price).toFixed(2));
			}else{
				$('#'+array[0]+"_multibuy_2_fees").text("Cost :<?= $currency ?>"+0);
			}
		}
		if($(this).hasClass('multi_buy3')){
			$('select[name="'+array[0]+'_multi_buy_4"]').html(get_multi_buy($(this).val()));
			var bidP = $(this).val();
			var ebay_item_bin_price_ = parseFloat(($('#ebay_item_bin_price_'+array[0]).text()).replace('£',''));
			if($.isNumeric(bidP) && $.isNumeric(ebay_item_bin_price_)){
				//var fin_price = (bidP * (ebay_item_bin_price_*3))/100;
				var fin_price = (bidP * (ebay_item_bin_price_))/100;
				$('#'+array[0]+"_multibuy_3_fees").text("Cost :<?= $currency ?>"+parseFloat(fin_price).toFixed(2));
			}else{
				$('#'+array[0]+"_multibuy_3_fees").text("Cost :<?= $currency ?>"+0);
			}
		}
		if($(this).hasClass('multi_buy4')){
			var bidP = $(this).val();
			var ebay_item_bin_price_ = parseFloat(($('#ebay_item_bin_price_'+array[0]).text()).replace('£',''));
			if($.isNumeric(bidP) && $.isNumeric(ebay_item_bin_price_)){
				//var fin_price = (bidP * (ebay_item_bin_price_*4))/100;
				var fin_price = (bidP * (ebay_item_bin_price_))/100;
				$('#'+array[0]+"_multibuy_4_fees").text("Cost :<?= $currency ?>"+parseFloat(fin_price).toFixed(2));
			}else{
				$('#'+array[0]+"_multibuy_4_fees").text("Cost :<?= $currency ?>"+0);
			}
		}
		if($(this).hasClass('select-aspect')){
			var c_id = $(this).val();
			var bidP = parseFloat(campaigns_data[c_id]);
			$('input[name="'+array[0]+'_select_your_ebay_value"]').val(bidP);
			$('input[name="'+array[0]+'_select_your_ebay_value"]').prop('disabled', false);
			var ebay_item_bin_price_ = parseFloat(($('#ebay_item_bin_price_'+array[0]).text()).replace('£',''));
			if($.isNumeric(bidP) && $.isNumeric(ebay_item_bin_price_)){
				$('input[name="'+array[0]+'_select_your_ebay_value"]').prop('disabled', true);
				var fin_price = (bidP * ebay_item_bin_price_)/100;
				$('#'+array[0]+"_final_fees").text("Cost :<?= $currency ?>"+parseFloat(fin_price).toFixed(2));
			}else{
				$('#'+array[0]+"_final_fees").text("Cost :<?= $currency ?>"+0);
			}
		}
		if($.inArray(array[0], selected_skus) == -1){
			selected_skus.push(array[0]);
			var checkbox_value = "ebay_item_"+array[0];
			$('input[type=checkbox][value='+checkbox_value+']').prop('checked', true);
		}
		if(selected_skus.length > 0){
			var text = "Apply Changes("+selected_skus.length+")";
			$('#apply_changes').text(text);
		}
	});
	$('body').on('click', '#ckbCheckAll', function () {  
		$('#traffic_promotion input:checkbox').not(this).prop('checked', this.checked);	
		if($('input[name="myCheckboxes[]"]:checked').length > 0) {
			//$('#apply_changes').show();
			var len = $('input[name="myCheckboxes[]"]:checked').length;
			var text = "Apply Changes("+len+")";
			$('#apply_changes').text(text);
			if($('#recommended_filter').find(':selected').data('offer') == "offer"){
				//$('.send_offer').show();
			}
		}
		else {
			selected_skus = [];
			var text = "Apply Changes(0)";
			$('#apply_changes').text(text);
			//$('.send_offer').hide();
		}
	});
	$('body').on('click', 'input[name="myCheckboxes[]"]', function () { 
  		if($('input[name="myCheckboxes[]"]:checked').length > 0) {
	  		//$('#apply_changes').show();
			var len = $('input[name="myCheckboxes[]"]:checked').length;
			var text = "Apply Changes ("+len+")";
			$('#apply_changes').text(text);
			if($('#recommended_filter').find(':selected').data('offer') == "offer"){
				//$('.send_offer').show();
			}
	  	}
	  	else {
			selected_skus = [];
	  		//$('#apply_changes').hide();
			var text = "Apply Changes(0)";
			$('#apply_changes').text(text);
			//$('.send_offer').hide();
	  	}
	});
  $('.select-aspect').selectize({
						create:true,
						allowEmptyOption: false,
						closeAfterSelect:true
	});
  /*$('#traffic_promotion').DataTable({
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
	});*/
	$('#traffic_promotion').DataTable({
	  columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		info:false,
		"pageLength": 100,
		"language":{
			"lengthMenu": change_limit(100)
		},
		"processing": true,
        "serverSide": true,
        "ajax": "scripts/traffic_report_processing.php?seller_ebay_id=<?= $seller_ebay_id ?>"
	});
	$('#traffic_promotion').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#traffic_promotion_paginate').after(download_button);
	$('.download_button').after(send_offer);
	$('.download_button').after(view_campaign);
	$('.view_campaign').after(eBay_suggested_ad_rate);
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#traffic_promotion').DataTable();
	$('#search_data, #recommended_filter').on( 'keyup change', function () {
		table.search( this.value ).draw();
		if($('#recommended_filter').find(':selected').data('offer') == "offer"){
			$('.send_offer').show();
		}else{
			$('.send_offer').hide();
		}
	});
	$('body').on('click', '#apply_changes', function () { 
		$('.traditional').addClass('whirl');
		var count_checked = 0;
		var selected_item_id = [];
		$('input[name="myCheckboxes[]"]:checked').each(function() {
			selected_item_id.push($(this).val());
			count_checked++;
			console.log(count_checked);
		});
		var post_data1 = [];
		if(count_checked > 0){
			$.each(selected_item_id,function(i,v){
				var item = v;
				var item_id = v.replace("ebay_item_","");
				//var sku = $('#'+item).attr('data-sku');
				var sku = $('input[value="'+item+'"]').attr('data-sku');
				var _select_your_ebay_value = $('#'+item_id+"_select_your_ebay_value").val();
				var _select_campaign = $('#'+item_id+"_select_campaign").val();
				var _multi_buy_2 = $('#'+item_id+"_multi_buy_2").val();
				var _multi_buy_3 = $('#'+item_id+"_multi_buy_3").val();
				var _multi_buy_4 = $('#'+item_id+"_multi_buy_4").val();
				var push_array = {};
				var promoted_listing = {};
				var multi_buy = {};
				promoted_listing = {'your_ad_rate':_select_your_ebay_value,'campaign_id':_select_campaign};
				multi_buy = {'multibuy2': _multi_buy_2,'multibuy3':_multi_buy_3,'multibuy4':_multi_buy_4};
				var final_data = {};
				final_data = {'ebay_item_id':item_id,'SKU':sku,'promoted_listing':promoted_listing,'multi_buy':multi_buy};
				post_data1.push(final_data);
			});
			console.log(post_data1);
			$.ajax({
				type: 'POST',
				url: app_base_url + 'ebay/get_ebay_traffic_pomotion_report_applied.php',
				async: true,
				cache: true,
				data: {'post_data':post_data1},
				//dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res.status){
						alert("success");
						//location.reload();
					}else{
						//alert(res.msg);
					}
				}
			});
		}else{
			alert("No Sku selected");
		}
		
	});
});
</script>