<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
include("../common/header.php");
?>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional" style="margin-top:55px;min-height:1300px">
		<div class="container-fluid" style="min-height: 0;display:none">
			<div class="row">
				<div class="singleNav" style="padding-bottom:7px;">
					<p>
						<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
						<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
						Inventory columns
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
			<div class="row mar-top-0" id="inventory_buttons">
				
			</div>
			<div class="row mar-top-0">
				<div class="col-md-12">
					<div class="row" id="inventory_search">
						
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
									<tbody id="table_data_rows">
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
			<div class=" " style="">
				<div class="row pad-left-right-15 " id="inventorycustomiseview">
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
<div id="allbinLocations" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class=" " style="">
				<div class="row pad-left-right-15 " id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Category View SKU's</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:400px">
						<div class="table-bordered traffic-table">
							<table id="inventory_dashboard" class="dataTable no-footer table table-bordered table-striped">
								<thead>
									<tr role="row" class="suceess">
										<th>SKU</th>
										<th>BinLocation Code</th>
										<th>Quantity</th>
										<th>EAN</th>
										<th>Item Condition</th>
									</tr>
								</thead>
								<tbody id="allbinLocations_tbody">
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right">Save changed Products</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="deleteInventory" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Delete Inventory</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:200px">
						<div class="form-group mar-left-0">
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" checked name="delete_option" value="selectedItems" style=""> <span class="fa fa-circle"></span>Delete Selected Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="delete_option" value="displayedItems" style=""> <span class="fa fa-circle"></span>Delete Displayed Items </label> </div>
							<div class="radio c-radio mar-bottom-5 inventory-export-radio">
								<label> <input type="radio" name="delete_option" value="profileItems" style=""> <span class="fa fa-circle"></span>Delete Items form Profile </label> 
								<select name="account" id="delete_option_selected" class="form-control" style="width: 180px">
								   <option value="Option 1">SKU with Zero Quantity</option>
								   <option value="Option 2">Option 1</option>
								   <option value="Option 3">Option 2</option>
								   <option value="Option 4">Option 3</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="delete_inventory" >Select</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="inventoryFlag" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Set Colour Flag</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:100px">
						<div class="form-group mar-left-0">
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" checked name="flag_option" value="selectedItems" style=""> <span class="fa fa-circle"></span>Flag Selected Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="flag_option" value="displayedItems" style=""> <span class="fa fa-circle"></span>Flag Displayed Items </label> </div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="flag_inventory" >Select</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="inventoryFlagSelection" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Colour Flag Selection Pannel</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:100px">
						<div class="radio c-radio mar-bottom-5" id="flag_select_option" style="">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="flag_inventory_select" >Select</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="finalFlagSelection" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Flag Products</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:100px">
						<div class="radio c-radio mar-bottom-5" id="flag_select_final" style="">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="flag_inventory_select_final" >Ok</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="inventoryUnFlag" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Set UnFlag</b></h4>
					</div>
					<div class="col-md-12 return-manage-pop-check pad-right-10" id="allbinLocations_table" style="min-height:100px">
						<div class="form-group mar-left-0">
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" checked name="unflag_option" value="selectedItems" style=""> <span class="fa fa-circle"></span>Flag Selected Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="unflag_option" value="displayedItems" style=""> <span class="fa fa-circle"></span>Flag Displayed Items </label> </div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="unflag_inventory_final" >Select</button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="exportInventory" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-bg" style="width: 410px;">
		<div class="modal-content">
			<div class="" style="">
				<div class="row pad-left-right-15">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title"><b>Export Inventory</b></h3>
					</div>
					<div class="col-md-11 mar-left-10" style="min-height:100px">
						<div class="row">
							<li class="col-md-6 litab licolor exportli" style=""> 
								<h4>STEP 1</h4> <small>Select Products For Export</small>
							</li>
							<li class="col-md-6 litab exportli1">
								<h4>STEP 2</h4> <small>Select Export Format</small>
							</li>
						</div>
						<div class="form-group mar-left-0 exporttab">
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" checked name="export_option" value="1" style=""> <span class="fa fa-circle"></span>Export Selected Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="export_option" value="2" style=""> <span class="fa fa-circle"></span>Export Displayed Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="export_option" value="3" style=""> <span class="fa fa-circle"></span>Export All Items </label> </div>
							<div class="radio c-radio mar-bottom-5"> <label> <input type="radio" name="export_option" value="4" style=""> <span class="fa fa-circle"></span>Export items from Search Profile </label> </div>
							<select name="account" id="searchProfileCodeExport" class="form-control mar-top-10 mar-left-25" style="width:70%">
								<option value="0">--Select Search Profile--</option>
							</select>
						</div>
						<br/>
						<div class="form-group mar-left-0 exporttab1 hide">
							<div class="row">
								<div class="form-group">
									<label class="col-md-4 text-center">Email Address</label>
									<div class="col-md-8">
										<input type="email" required id="email_address" required="" class="form-control" name="email_address" multiple-emails="">
										<span>Separate e-mail addresses with commas(';').</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 text-center"> Please choose Profile </label>
									<div class="col-md-8">
										<select class="chosen-select form-control" id="export_selected_profile" name="export_selected_profile" required="required" style="">
											<option value=''>---Select---</option>
										</select>
										<span>To create an Export profile, please <a href="<?= BASE_URL ?>#/app/inventory-export">click here</a>.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-12 mar-top-10 exporttab">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="export_inventory_next" >Next</button> 
						</div>
						<div class="form-group col-lg-12 mar-top-10 exporttab1 hide">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15 pull-right" id="export_inventory_final" >Export Inventory</button> 
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
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/inventory/common-inventory.js?v=2.1"></script>
<style>
.no-sort{
	background:none !important;	
}
.modal-backdrop.fade.in{
	z-index:-1;
}
.licolor {
    background-color: #5d9cec;
    color: #FFF;
}
.litab {
    display: block;
}
</style>
<script>
$(document).ready(function(){
	$('.traditional').addClass('whirl');
	//make elements sortable for settings model by passing id
	X247Inventory.sortable_s('sortable1');
	
	//Load the tabs for columns first time and send tabs class and table table data class
	//url1==> get tabs data from api url1
	//url2==> get market place li data from api
	//url3==>table data for respective template
	X247Inventory.tab_columns_data('inventory/alltabs.php','inventory/inventory_tabs/get_inventory_tabs.php','inventory/scripts/alltabs_table_data.php','inventory_dashboard');
	
	//settings apply click send save data file also
	$('body').on("click", "#inventory_settings", function( e) {
		X247Inventory.inventory_settings('settingModal','inventory/assign_inventory_columns.php');
	});
	// on change li class load the data from api
	$('body').on('click','.inventory_tabs li',function() {
		$('.inventory_tabs li').removeClass();
		$(this).addClass('active');
		X247Inventory.load_main_data('inventory_dashboard',$(this).data('val'));
	});
	jQuery('body').on('change keyup','.amzMinPriceClass',function(){
		var sku = jQuery(this).data('sku');
		var marketplace = jQuery(this).data('marketplace');
		var checkbox_value = sku+"_"+marketplace;
		jQuery('input[type=checkbox][value='+checkbox_value+']').prop('checked', true);
		if(jQuery.inArray( checkbox_value, X247Inventory.selected_skus ) == -1){
			X247Inventory.selected_skus.push(checkbox_value);
		}
		var text = "Apply Changes("+X247Inventory.selected_skus.length+")";
		jQuery('#apply_changes').text(text);
		jQuery('#seleted_skus').text(X247Inventory.selected_skus.length);
		console.log(X247Inventory.selected_skus);
	});
});
</script>