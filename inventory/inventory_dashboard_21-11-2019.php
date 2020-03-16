<?php include("../common/header.php"); 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
?>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional" style="margin-top:55px;min-height:1000px">
		<div class="container-fluid" style="min-height: 0;display:none">
			<div class="row">
				<div class="singleNav" style="padding-bottom:7px;">
					<p>
						<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
						<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
						Inventory 
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12" id="user-settings-table" style="min-height: 70px;">
					<div>
						<ul class="nav nav-tabs inventory_tabs"></ul>
					</div>
				</div>
			</div>
			<div class="row mar-top-0">
				<div class="btn-inventory-dashboard" id="alltab_buttons" style="margin: 0 15px;display:none;">
					<div class="row">
						<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" style="background: #1665D8"><span class="fa fa-edit fa-lg"></span> Add a Product </a> </div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="#/app/inventory-status" style="background: #1289A7"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a> </div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);" style="background: #833471"><span class="fa fa-check fa-lg"></span> Apply Changes (0)</a> </div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item</a> </div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success col-md-4 inv-btn" href="javascript:void(0);" ng-click="unblockanItem()" style="background: #673AB7"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger col-md-4 inv-btn" href="#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="#/app/inventory-import" style="background: #242424"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green col-md-4 inv-btn" href="javascript:void(0);" style="background: #B53471"><span class="fa fa-share-square"></span> Export Inventory</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="#/app/product-export-import-status" style="background: #EE5A24"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" style="background: #607D8B"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="#/app/inventory-delete-logs" style="background: #3F51B5"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="#/app/stock-movement-log" style="background: #FE4C4C"><span class="fa fa-list-ul fa-lg"></span> Stock Movement Log</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="javascript:void(0);" ng-click="listFlagOptions()" style="background: #1B1464"><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger col-md-4 inv-btn" href="javascript:void(0);" ng-click="UNFlagOptions()" style="background: #795548"><span class="fa fa-flag"></span> UNFlag</a></div>
						<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple col-md-4 inv-btn" href="#/app/inventory-manageflags" style="background: #673AB7"><span><span class="fa fa-flag"></span> Manage Flags</span></a></div>
					</div>
				</div>
				<div class="btn-inventory-dashboard" id="amazon_buttons" style="margin: 0 15px;display:none;">
					<div class="row">
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="#" style="background: #1665D8"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="#/app/inventory-status" style="background: #1289A7"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);" style="background: #833471"><span class="fa fa-check fa-lg"></span> Apply Changes (0)</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" style="background: #673AB7"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#/app/inventory-import" style="background: #242424"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" style="background: #B53471"><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#/app/product-export-import-status" style="background: #EE5A24"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" style="background: #607D8B"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn bg-danger-dark inv-btn" href="#/app/inventory-delete-logs" style="background: #3F51B5"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-primary inv-btn" href="#/app/stock-movement-log" style="background: #FE4C4C"><span class="fa fa-list-ul fa-lg"></span> Stock Movement Log</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-primary inv-btn" href="#/app/listing-monitor" style="background: #1B1464"><span class="fa fa-list-ul fa-lg"></span> Lisiting Monitor</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" style="background: #795548"><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
					   <div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #673AB7"><span class="fa fa-flag"></span> UNFlag</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple col-md-4 inv-btn" href="#/app/inventory-manageflags" style="background: #673AB7"><span class="fa fa-flag"></span> Manage Flags</a></div>
					</div>
				</div>
				<div class="btn-inventory-dashboard" id="ebay_buttons" style="margin: 0 15px;display:none;">
					<div class="row">
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="#" ng-click="openCustomPopup('inventory-product-popup.html')" style="background: #E91E63"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="#/app/inventory-status" style="background: #833471"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);" ng-click="updateQtyAndPrices()" style="background: #1289A7"><span class="fa fa-check fa-lg"></span> Apply Changes (0)</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" ng-click="blockanItem()" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item </a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" ng-click="unblockanItem()" style="background: #B53471"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#/app/inventory-import" style="background: #673AB7"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" ng-click="openCustomExport()" style="background: #EE5A24"><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#/app/product-export-import-status" style="background: #B53471"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-warning inv-btn" href="#" ng-click="openCustomPopup('inventory-missing-products.html')" style="background: #EE5A24"><span class="fa fa-file-text-o fa-lg"></span> Missing Products</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="#/app/ebaylisteditems" style="background: #607D8B"><span class="fa fa-list-ul fa-lg"></span> eBayListed items</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#" ng-click="listtoebayskus()" style="background: #3F51B5"><span class="fa fa-angle-double-up fa-lg"></span> List/Revise to eBay</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" ng-click="listDeleteOptions()" style="background: #FE4C4C"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="#/app/inventory-delete-logs" style="background: #1B1464"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" ng-click="listFlagOptions()" style="background: #673AB7"><span class="fa fa-flag"></span> Flag</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" ng-click="UNFlagOptions()" style="background: #1665D8"><span class="fa fa-flag"></span>UNFlag</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="#/app/inventory-manageflags" style="background: #795548"><span class="fa fa-flag"></span> Manage Flags</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="https://showcase.247cloudhub.co.uk/ebay/get_ebay_traffic_pomotion_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" ng-click="vieweBayTrafficReport()" style="background: #1289A7"><span class="fa fa-check fa-lg"></span> Analytics and Promotions</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="https://showcase.247cloudhub.co.uk/ebay/get_ebay_aspect_adoption_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK&amp;type=ASPECTS_ADOPTION" ng-click="viewComplianceStatus()" style="background: #3F51B5"><span class="fa fa-angle-double-up fa-lg"></span> Aspect Recommendations </a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="https://showcase.247cloudhub.co.uk/ebay/ebay_recommendation_enhancement_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" ng-click="catalogueEnhancements()" style="background: #607D8B"><span class="fa fa-list-ul fa-lg"></span> Catalogue Enhancements</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="#/app/ebaydashboard" ng-click="eBayAccountStatus()" style="background: #B53471"><span class="fa fa-check-square-o fa-lg"></span> eBay Account Health</a></div>
					   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="https://showcase.247cloudhub.co.uk/ebay/ebay_listing_violations_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" ng-click="eBayListingViolations()" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Listing Violations</a></div>
					</div>
				</div>
			</div>
			<div class="row mar-top-0">
				<div class="col-md-12">
					<div class="row">
						<div class="col-lg-4 form-group">
							<label class="font-normal mar-top-5">Select Search Filter Profile</label> 
							<select name="account" id="searchProfileCode" class="form-control">
									<option value="" class="" selected="selected">Select</option>
							</select>
							<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
							<p class="pad-bottom-0 mar-bottom-0">
								<!-- ngIf: cmnInvetory.profileCode!='0' --> 
							</p>
						</div>
						<div class="col-lg-4 form-group">
							<label class="font-normal mar-top-5">Select Search Flag Filter</label> 
							<select name="account" id="searchFlagCode" class="form-control" >
								<option value="" class="" selected="selected">Select</option>
							</select>
						</div>
						<div class="col-lg-4 form-group">
							<label class="font-normal mar-top-5">Search For</label> 
								<div class="input-group"><input id="txtSearch" type="text" placeholder="" class="form-control"> <span class="input-group-btn"> <button class="btn btn-default" id="aSearch" type="button" ><em class="fa fa-search"></em></button> </span> </div>
									<a href="#" ng-click="clearSearchFields()">Clear Search</a> 
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							<div style="padding: 0px 15px;display:flex;">
								<strong>Total Products :</strong>
								<div id="total_Count">0 (Parent Products: 0, Child Products: 0, Non Relationship Products: 0)</div>
								&nbsp;No.of Selected SKU's: <p id="seleted_skus">0</p>
							</div>
						</div>
						<div class="col-lg-2 pull-right text-right">
							<a href="#" class="mar-right-30" data-toggle="modal" data-target="#settingModal" placeholder="Columns Settings">
								<img src="<?= BASE_URL?>common/images/settings-icon.682ad8cc.png">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-bordered traffic-table">
								<table id="inventory_dashboard" class="dataTable no-footer table table-bordered table-striped">
									<thead>
										<tr role="row" class="suceess" id="table_columns">
											
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
					<div class="col-md-9 return-manage-pop-check pad-right-10" id="settings_inputboxes">
						<h4 style="margin-left: 0px; font-weight: normal; margin-bottom: 20px">Pick the columns you want to view</h4>
						<label class="checkbox-inline c-checkbox col-xs-3">
							<input type="checkbox" id="check_all" onchange="checkAllSortable(this)" > <span class="fa fa-check"></span>Select All
						</label>
					</div>
					<div class="col-md-3">
						<h4 style="margin-left: -20px;  font-weight: normal">Arrange Columns</h4>
						<div class="add-product-ul-li">
							<ul style="height: 245px; margin-bottom: 20px" class="ui-sortable" id="sortable1">
							</ul>
							<div class="arrow-return-alignment" style="float: right; width: 30px">
								<em class="fa fa-arrow-up fa-lg"></em> <em class="fa fa-arrow-down fa-lg"></em>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-3 pull-right mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15" id="inventory_settings"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("../common/footer.php"); ?>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/inventory/common-inventory.js"></script>
<style>
.no-sort{
	background:none !important;	
}
.modal-backdrop.fade.in{
	z-index:-1;
}
</style>
<!--<script>
var cols_data = '';
var tab_columns = '';
var total_columns = '';
function change_limit(value){
	var limit_array = [10,25,50,100];
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
	$('#inventory_dashboard').DataTable({
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
		"ajax": {
			"url": "scripts/alltabs_table_data.php",
			"type": "POST",
			"data":{cols_data:JSON.stringify(cols_data)}
		},
	});
	var table = $('#inventory_dashboard').DataTable();
	$('#aSearch').on( 'click', function () {
		table.search($('#txtSearch').val()).draw();
	});
	$('.dataTables_filter').hide();
	$('.container-fluid').show();
	$('.traditional').removeClass('whirl');
}
function settings_columns(original_columns,new_columns){
	
}
function check_val_exist(arr,val){
	var status = false;
	$.each(arr,function(k,v){
		if(v.name == val){
			status = true;
			return true;
		}
	});
	return status;
}
function main_data(main_url){
	$.ajax({
		type: 'GET',
		url: app_base_url + main_url,
		//dataType: 'json',
		success: function (res) {
			response = JSON.parse(res);
			total_columns = response.total_columns;
			if(typeof(response.column_details.data.colsdata) != "undefined"){
				cols_data = JSON.parse(response.column_details.data.colsdata);
				var table_columns = '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
				$.each(cols_data,function(k,v){
					table_columns += '<th>'+v.name+'</th>';
				});
				$('#table_columns').append(table_columns);
			}
			var settings_inputboxes = "";
			var sortable1 = "";
			
			if(cols_data == ""){
				cols_data = total_columns;
			}
			if(cols_data.length == total_columns.length){
				$('#check_all').prop('checked',true);
			}
			//console.log(cols_data);
			//console.log(total_columns);
			$.each(total_columns,function(i,v){
					var checked = check_val_exist(cols_data,v.name);
					if(checked){
						var checked = "checked";
						sortable1 += '<li class="ui-state-default" name="'+v.name+'" id="'+v.val+'">'+v.name+'</li>';
					}else{
						var checked = "";
					}
					if(v.name == "SKU"){
						var disabled = "disabled checked";
					}else{
						var disabled = "";
					}
							
					settings_inputboxes += '<label class="checkbox-inline c-checkbox col-xs-3" style="">';
					settings_inputboxes +=	'<input name="selectedCols[]" '+disabled+' '+checked+' value="'+v.name+'" onchange="checkAllSortableSingle(this)" type="checkbox" id="'+v.val+'"> <span class="fa fa-check"></span>'+v.name;
					settings_inputboxes +=	'</label>';
			});
			$('#settings_inputboxes').append(settings_inputboxes);
			$('#sortable1').append(sortable1);
			
			if(typeof(response.search_profile_details.profiles) != "undefined"){
				var search_profile = response.search_profile_details.profiles;
				var searchProfileCode = "";
				$.each(search_profile,function(k,v){
					searchProfileCode += '<option value='+v.profilecode+' >'+v.profilename+'</option>';
				});
				$('#searchProfileCode').append(searchProfileCode);
			}
			if(typeof(response.flag_details.flags) != "undefined"){
				var flag_details = response.flag_details.flags;
				var searchFlagCode = "";
				$.each(flag_details,function(k,v){
					searchFlagCode += '<option value='+v.flagid+' >'+v.flagname+'</option>';
				});
				$('#searchFlagCode').append(searchFlagCode);
			}
			$('#inventory_dashboard').DataTable({
				columnDefs: [
				  { targets: 'no-sort', orderable: false }
				],
				"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
				info:false,
				"pageLength": 10,
				"language":{
					"lengthMenu": change_limit(10)
				},
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "scripts/alltabs_table_data.php",
					"type": "POST",
					"data":{cols_data:JSON.stringify(cols_data)},
					dataFilter: function(data){
						var json = $.parseJSON( data );
						var text = json.recordsTotal+" (Parent Products: "+json.parentproducts+", Child Products: "+json.childproducts+", Non Relationship Products: "+json.nonrelationshipproducts+")";
						$('#total_Count').text(text);
						return data;
					},
				}
			});
			var table = $('#inventory_dashboard').DataTable();
			$('#aSearch').on( 'click', function () {
				table.search($('#txtSearch').val()).draw();
			});
			$('.dataTables_filter').hide();
			$('.container-fluid').show();
			$('.traditional').removeClass('whirl');
		}
	});
}
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
$(document).ready(function(){
	$('.traditional').addClass('whirl');
	var inventory_tabs = '';
	$('li').click(function() {
		$('li').removeClass();
		$(this).addClass('active');
	});
	//var active_tab_val = $('ul.inventory_tabs').find('li.active').data('val');
	$.ajax({
		type: 'GET',
		url: app_base_url + 'inventory/inventory_tabs/get_inventory_tabs.php',
		//dataType: 'json',
		success: function (res) {
			inventory_tabs = res;
			var response = JSON.parse(res);
			tab_columns = response.tab_columns;
			var li_tabs = "";
			for(var i=0;i<tab_columns.length;i++){
				var active = "";
				if(tab_columns[i]['active']){
					active = "active";
				}
				li_tabs += "<li class='"+active+"' data-val="+tab_columns[i]['iid']+" ><a href='#' >"+tab_columns[i]['heading']+"</a></li>";
			}
			$('.inventory_tabs').append(li_tabs);
			$('#alltab_buttons').show();
			main_data('inventory/alltabs.php');
		}
	});
	
	$('body').on("click", "#inventory_settings", function( e) {
		jsonObj = [];
		check = 1;
		$('#settingModal').modal('hide');
		$('.traditional').addClass('whirl');
		var marketplacecode = $('ul.inventory_tabs').find('li.active').data('val');
		$('#sortable1 li').each(function(i){
			item = {}
			item ["name"] = $(this).attr('name');
			item ["val"] = $(this).attr('id');
			item ["pos"] = check;
			check++;
			jsonObj.push(item);
		});
		$.ajax({
			type: 'POST',
			url: app_base_url + 'inventory/assign_inventory_columns.php',
			async: true,
			cache: true,
			data: {'tabcols':JSON.stringify(jsonObj),marketplacecode:marketplacecode},
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if(res.status){
					location.reload(true);
				}else{
					console.log(res);
				}
			}
		});
		
	});
});
</script>-->