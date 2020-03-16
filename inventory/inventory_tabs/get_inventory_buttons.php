<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
if(!isset($_SESSION)){
	session_start();
}

$marketplacecode = isset($_REQUEST['marketplacecode'])?$_REQUEST['marketplacecode']:'0';

?>
<?php
	if($marketplacecode == 0){
?>
	<div class="btn-inventory-dashboard" id="inv_button_0" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #1665D8"><span class="fa fa-edit fa-lg"></span> Add a Product </a> </div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-status" style="background: #1289A7"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a> </div>
			<div class="col-lg-2 col-md-4" ><a type="button" class="btn btn-purple inv-btn" href="javascript:void(0);" style="background: #833471"><span class="fa fa-check fa-lg"></span><span id="apply_changes">Apply Changes (0)</span></a> </div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" id="block_item" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item</a> </div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success col-md-4 inv-btn" href="javascript:void(0);" id="unblock_item" style="background: #673AB7"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #242424"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green col-md-4 inv-btn" href="javascript:void(0);" id="export_inventory" style="background: #B53471"><span class="fa fa-share-square"></span> Export Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #EE5A24"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" style="background: #607D8B"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-delete-logs" style="background: #3F51B5"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/stock-movement-log" style="background: #FE4C4C"><span class="fa fa-list-ul fa-lg"></span> Stock Movement Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="javascript:void(0);" id="flag_item" style="background: #1B1464"><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger col-md-4 inv-btn" href="javascript:void(0);" style="background: #795548" id="unflag_inventory" ><span class="fa fa-flag"></span> UNFlag</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #673AB7"><span><span class="fa fa-flag"></span> Manage Flags</span></a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 2){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_2" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #1665D8"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-status" style="background: #1289A7"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-purple inv-btn" href="javascript:void(0);" style="background: #833471"><span class="fa fa-check fa-lg" ></span><span id="apply_changes">Apply Changes (0)</span></a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" id="block_item" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" id="unblock_item" style="background: #673AB7"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="<?= BASE_URL ?>#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #242424"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" id="export_inventory" style="background: #B53471"><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #EE5A24"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" id="delete_item" style="background: #607D8B"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn bg-danger-dark inv-btn" href="<?= BASE_URL ?>#/app/inventory-delete-logs" style="background: #3F51B5"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/stock-movement-log" style="background: #FE4C4C"><span class="fa fa-list-ul fa-lg"></span> Stock Movement Log</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/listing-monitor" style="background: #1B1464"><span class="fa fa-list-ul fa-lg"></span> Lisiting Monitor</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" id="flag_item" style="background: #795548"><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
			<div class="col-lg-2 col-md-4"> <a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #673AB7" id="unflag_inventory" ><span class="fa fa-flag"></span> UNFlag</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #673AB7"><span class="fa fa-flag"></span> Manage Flags</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 1){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_1" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #E91E63"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-status" style="background: #833471"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="javascript:void(0);" style="background: #1289A7"><span class="fa fa-check fa-lg" ></span><span id="apply_changes">Apply Changes (0)</span></a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" id="block_item" style="background: #E91E63"><span class="fa fa-ban fa-lg"></span> Block an Item </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" id="unblock_item" style="background: #B53471"><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="<?= BASE_URL ?>#/app/inventory-block-unblock-logs" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #673AB7"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" id="export_inventory" style="background: #EE5A24"><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #B53471"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-warning inv-btn" href="#" style="background: #EE5A24"><span class="fa fa-file-text-o fa-lg"></span> Missing Products</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="<?= BASE_URL ?>#/app/ebaylisteditems" style="background: #607D8B"><span class="fa fa-list-ul fa-lg"></span> eBayListed items</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="#" style="background: #3F51B5"><span class="fa fa-angle-double-up fa-lg"></span> List/Revise to eBay</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" id="delete_item" style="background: #FE4C4C"><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="<?= BASE_URL ?>#/app/inventory-delete-logs" style="background: #1B1464"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" id="flag_item" style="background: #673AB7"><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #1665D8" id="unflag_inventory" ><span class="fa fa-flag"></span>UNFlag</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #795548"><span class="fa fa-flag"></span> Manage Flags</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>ebay/get_ebay_traffic_pomotion_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" style="background: #1289A7"><span class="fa fa-check fa-lg"></span> Analytics and Promotions</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>ebay/get_ebay_aspect_adoption_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK&amp;type=ASPECTS_ADOPTION" style="background: #3F51B5"><span class="fa fa-angle-double-up fa-lg"></span> Aspect Recommendations </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="<?= BASE_URL ?>ebay/ebay_recommendation_enhancement_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" style="background: #607D8B"><span class="fa fa-list-ul fa-lg"></span> Catalogue Enhancements</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="<?= BASE_URL ?>#/app/ebaydashboard" ng-click="eBayAccountStatus()" style="background: #B53471"><span class="fa fa-check-square-o fa-lg"></span> eBay Account Health</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="<?= BASE_URL ?>ebay/ebay_listing_violations_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" style="background: #F79F1F"><span class="fa fa-list-ul fa-lg"></span> Listing Violations</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 101){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_101" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4">
				<a type="button" class="btn btn-info col-md-4 inv-btn" href="#" ><span class="fa fa-edit fa-lg"></span> Add a Product </a>
			</div>
		</div>
	</div>
<?php }else if($marketplacecode == 9){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_9" style="margin: 0 15px">
		<div class="row">
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #1289A7"><span class="fa fa-edit fa-lg"></span> Add New Product</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #E91E63"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="javascript:void(0);" style="background: #833471"><span class="fa fa-check fa-lg"></span><span id="apply_changes"> Apply Changes (0)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #B53471" id="block_item" ><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" style="background: #F79F1F" id="unblock_item" ><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" style="background: #673AB7" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" style="background: #EE5A24" id="export_inventory" ><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #B53471"><span class="fa fa-ban fa-lg"></span> Import/Export Log </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" style="background: #607D8B" id="flag_item" ><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #3F51B5" id="unflag_inventory" ><span class="fa fa-flag"></span> UNFlag</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #FE4C4C"><span class="fa fa-flag"></span> Manage Flags</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 3){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_3" style="margin: 0 15px">
		<div class="row">
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #E91E63"><span class="fa fa-edit fa-lg"></span> Add a Products </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-status" style="background: #833471"><span class="fa fa-bars fa-lg"></span> Add/Edit SKU Status </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);" style="background: #1289A7"><span class="fa fa-check fa-lg"></span><span id="apply_changes">Apply Changes (0)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #B53471" id="block_item" ><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" style="background: #F79F1F" id="unblock_item" ><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="<?= BASE_URL ?>#/app/inventory-block-unblock-logs" style="background: #673AB7"><span class="fa fa-list-ul fa-lg"></span> Block/Unblock Log</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #EE5A24"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" style="background: #B53471" id="export_inventory" ><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #607D8B"><span class="fa fa-long-arrow-down fa-lg"></span><span class="fa fa-long-arrow-up fa-lg"></span> Import/Export Log </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #3F51B5" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="<?= BASE_URL ?>#/app/inventory-delete-logs" style="background: #FE4C4C"><span class="fa fa-list-ul fa-lg"></span> Delete Log</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" style="background: #673AB7" id="flag_item" ><span class="fa fa-flag"></span> Flag(Y/N)</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #1665D8" id="unflag_inventory" ><span class="fa fa-flag"></span> UNFlag</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #795548"><span class="fa fa-flag"></span> Manage Flags</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 21){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_21" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 20){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_20" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 16 && false){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_16" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item"><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 7){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_7" style="margin: 0 15px">
		<div class="row">
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" style="background: #E91E63"><span class="fa fa-edit fa-lg"></span> Add New Products </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import" style="background: #833471"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);" style="background: #1289A7"><span class="fa fa-check fa-lg"></span><span id="apply_changes">Apply Changes (0)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #B53471" id="block_item" ><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" style="background: #F79F1F" id="unblock_item" ><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" style="background: #673AB7" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" style="background: #EE5A24" id="export_inventory" ><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status" style="background: #B53471"><span class="fa fa-ban fa-lg"></span> Import/Export Log </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" style="background: #EE5A24" id="flag_item" ><span><span class="fa fa-flag"></span> Flag(Y/N)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" style="background: #607D8B" id="unflag_inventory" ><span><span class="fa fa-flag"></span> UNFlag</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags" style="background: #3F51B5"><span class="fa fa-flag"></span> Manage Flags</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 13){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_13" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" ><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple col-md-4 inv-btn ng-binding" href="javascript:void(0);"><span class="fa fa-check fa-lg"></span><span id="apply_changes">Apply Changes (0)</span></a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 15){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_15" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" ><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 22){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_22" style="margin: 0 15px">
		<div class="row">
			<div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info col-md-4 inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item" ><span class="fa fa-edit fa-lg"></span> Add a Product </a></div>
			<div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark col-md-4 inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 8){ ?>
	<div class="btn-inventory-dashboard" id="inv_button_8" style="margin: 0 15px">
		<div class="row">
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="<?= BASE_URL ?>#/app/inventory-product-item"><span class="fa fa-edit fa-lg"></span> Add New Products </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/inventory-import"><span class="fa fa-download fa-lg"></span> Import Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn ng-binding" href="javascript:void(0);"><span class="fa fa-check fa-lg"></span><span id="apply_changes">Apply Changes (0)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" id="block_item" ><span class="fa fa-ban fa-lg"></span> Block an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-success inv-btn" href="javascript:void(0);" id="unblock_item" ><span class="fa fa-check-square-o fa-lg"></span> Unblock an Item</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-danger-dark inv-btn" href="javascript:void(0);" id="delete_item" ><span class="fa fa-trash-o fa-lg"></span> Delete</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn bg-green inv-btn" href="javascript:void(0);" id="export_inventory" ><span class="fa fa-upload fa-lg"></span> Export Inventory</a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-primary inv-btn" href="<?= BASE_URL ?>#/app/product-export-import-status"><span class="fa fa-ban fa-lg"></span> Import/Export Log </a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-info inv-btn" href="javascript:void(0);" id="flag_item" ><span><span class="fa fa-flag"></span> Flag(Y/N)</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-danger inv-btn" href="javascript:void(0);" id="unflag_inventory" ><span><span class="fa fa-flag"></span> UNFlag</span></a></div>
		   <div class="col-lg-2 col-md-4"><a type="button" class="btn btn-purple inv-btn" href="<?= BASE_URL ?>#/app/inventory-manageflags"><span class="fa fa-flag"></span> Manage Flags</a></div>
		</div>
	</div>
<?php }else if($marketplacecode == 18){ ?>
	<div id="panelRepeat1" class="panel panel-primary">
	   <div class="panel-heading ng-binding">
		  Add Inventory Images 
		  <paneltool class="pull-right" tool-refresh="standard" tool-collapse="tool-collapse" tool-dismiss="tool-dismiss"> <a ng-click="panelRepeat1 = !panelRepeat1" uib-tooltip="Collapse Panel" panel-collapse="" href="#" class="ng-scope"> <em class="fa fa-plus ng-no-animation ng-hide" ng-show="panelRepeat1"></em> <em class="fa fa-minus ng-no-animation" ng-show="!panelRepeat1"></em> </a> </paneltool>
	   </div>
	   <div class="panel-wrapper in collapse">
		  <div class="panel-body">
			 <div class="row">
				<div class="col-lg-6">
				   <label class="col-sm-2 control-label">Folder Name</label> 
				   <div class="col-sm-7">
					  <select name="account" class="form-control" style="">
						 <option value="0">Select Folder</option>
					  </select>
				   </div>
				   <div class="form-group col-md-3"> <a href="#" class="mar-right-5"><em class="fa fa-plus"></em> Add a New Folder</a> </div>
				</div>
			 </div>
			 <div class="row mar-top-10">
				<div class="col-lg-6">
				   <label class="col-md-2 control-label">Upload Files</label> 
				   <div class="col-sm-7">
					  <input filestyle="" type="file" data-button-text="Multiple" id="inventoryImages" data-class-button="btn btn-default" data-class-input="form-control inline" nv-file-select="" uploader="uploader" multiple="multiple" class="form-control" accept="image/gif, image/jpeg, image/jpg, image/png" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
					  <div class="bootstrap-filestyle input-group">
						 <input type="text" class="form-control " disabled="">
						 <span class="group-span-filestyle input-group-btn" tabindex="0">
						 <label for="inventoryImages" class="btn btn-default ">
						 <span class="glyphicon glyphicon-folder-open"></span> Choose file
						 </label>
						 </span>
					  </div>
				   </div>
				   <input type="button" id="btnimageUpload" value="Upload" class="btn btn-primary col-md-2" disabled="disabled">&nbsp;&nbsp;&nbsp; 
				</div>
			 </div>
		  </div>
	   </div>
	</div>
<?php } ?>

