<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
include("../common/header.php");
$dbcode = isset($_SESSION['dbcode'])?$_SESSION['dbcode']:'';
?>
<!-- Content Starts -->  
<div class="portlets-wrapper traditional" style="margin-top:55px;min-height:1300px">
   <!-- uiView: pcontent -->
   <div class="content-wrapper" style="">
	  <div class="ful-width" id="newdesigntrad">
		 <div class="row">
			<div class="singleNav">
			   <p> <a href="<?= BASE_URL ?>">Home</a> &gt; <a href="<?= BASE_URL.'scan-pick-ship' ?>">Deliver </a>&gt; Scan, Pack and Ship </p>
			</div>
		 </div>
		 <div id="wrapper" class="toggled">
			<div class="clearfix clear-both"></div>
			<div id="page-content-wrapper">
				<div class="row">
					<div class="col-md-3 ng-hide">
						<span> <input type="text" id="sProfileSearchName" class="form-control" name="sProfileSearchName">
						<button class="btn btn-theme" type="submit"> Save </button> </span>
					</div>
				  <div class="col-md-12">
					 <div style="padding-right:10px">
						<div class="clearfix"></div>
						<div class="panel panel-primary" id="panelRepeat1">
						   <div class="panel-heading">
							  Filters 
							  <div class="pull-right">
									<a style="color:#ffff" href="#">
										<em class="fa fa-minus"></em>
									</a>
								</div>
						   </div>
						   <div class="panel-wrapper" style="height: auto;">
							  <div class="panel-body">
								 <form class="form-inline row mar-bottom-5" id="apply_filter">
									<div class="form-group col-md-4">
									   <label for="exampleInputName2" style="width:40%; float:left">Date:</label> 
									   <select class="form-control m-b not_multi" id="datesevcice" name="datesevcice" style="width:150px;margin-right:1%">
										  <!--<option value="0" selected="selected">Select Date</option>-->
										  <option value="All" selected="selected" style="">All</option>
										  <option value="1">Last Day</option>
										  <option value="7" >Last 7 Days</option>
										  <option value="30" >Last 30 Days</option>
										  <option value="CDate" >Custom Date</option>
									   </select>
									</div>
									<!-- Custom select date start-->
									<div id="customDate" class="modal fade">
									   <div class="modal-dialog modal-dialog" style="">
											<div class="modal-content">
												<div>
													<h2 style="color: #5b5b5b; font-size: 26px; font-weight: normal; margin-bottom: 5px" class="mar-top-15" id="ngdialog1-aria-labelledby">Custom Order Dates</h2>
													<div class="ful-width traditional" id="exportOrdesMainDiv">
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="panel-default">
															<div class="panel-body">
																<div class="row mar-top-5">
																   <div class="col-md-5"> <label class="control-label">From Date</label> </div>
																   <div class="col-md-5"> <label class="control-label">To Date</label> </div>
																</div>
																<div class="row">
																   <div class="col-md-5">
																	  <div class="form-group">
																		 <div class="input-group">
																			<input type="text" required name="startdate" class="form-control" uib-datepicker-popup="dd-MMMM-yyyy" id="custom_start" >
																		 </div>
																	  </div>
																   </div>
																   <div class="col-md-5">
																	  <div class="form-group">
																		 <div class="input-group">
																			<input type="text" required name="enddate" class="form-control" id="custom_end"  close-text="Close">
																		 </div>
																	  </div>
																   </div>
																</div>
																<div class="row form-group">
																   <div class="col-lg-5"> <button class="btn btn-warning margin-top-tw cancel" data-dismiss="modal" type="button">Cancel</button> </div>
																   <div class="col-lg-1 mar-right-15 pull-right"> <button class="btn btn-info margin-top-tw" data-dismiss="modal">Save</button> </div>
																   <div class="col-lg-2" id="whirl-div" style="margin-right: 20px"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										  </div>
									   </div>
									</div>
									<!-- Custom select date end-->
									<div class="form-group col-md-4">
									   <label for="exampleInputEmail2" style="width:40%; float:left">Order Stage:</label> 
									   <select class="form-control m-b" id="ordersevcice" name="ordersevcice[]" multiple="multiple" style="display:none">
										  <option value="1"  style="">Pending</option>
										  <option value="2" selected="selected" >Just Arrived</option>
										  <option value="3" >Picking List Printed</option>
										  <option value="4" >Dispatch Note Printed</option>
										  <option value="5" >Courier Label Printed</option>
										  <option value="6" >Awaiting Courier Pickup</option>
										  <option value="7" >Invoice Printed</option>
										  <option value="8" >Canceled</option>
										  <option value="9" >Backorder</option>
										  <option value="10" >Refunded</option>
										  <option value="11" >Dispatched</option>
										  <option value="12" >Awaiting Return From Customer</option>
										  <option value="13" >RMA Received</option>
										  <option value="14" >RMA Resent - Just Arrived</option>
										  <option value="18" >Sent To FBA</option>
										  <option value="20" >Dispatched Confirmed</option>
										  <option value="22" >Re-Dispatched</option>
										  <option value="23" >Awaiting Customer Confirmation</option>
									   </select>
									</div>
									<div class="form-group col-md-4">
									   <label for="exampleInputEmail2" style="width:40%; float:left">Shipping Service:</label> 
									   <select class="form-control m-b" id="shippingsevcice" name="shippingsevcice[]" multiple="multiple" style="display: none;">
										  
									   </select>
									</div>
									<div class="form-group col-md-4">
									   <label for="exampleInputName2" style="width:40%; float:left">Marketplace Account:</label> 
									   <select class="form-control m-b" id="accountservice" name="accountservice[]" multiple="multiple" style="display: none;">
									   </select>
									</div>
									<div class="form-group col-md-4">
									   <label for="exampleInputEmail2" style="width:40%; float:left">Country Code:</label> 
									   <select class="form-control m-b" id="countrysevcice" name="countrysevcice[]" multiple="multiple" style="display:none">
									   </select>
									</div>
									<div class="form-group col-md-4">
									   <label for="exampleInputEmail2" style="width:40%; float:left"> Supplier:</label> 
									   <select class="form-control m-b" id="supplierservice" name="supplierservice[]" multiple="multiple" style="display:none">
										  <option value="Sample"  style="">Sample</option>
										  <option value="Tree Of Life" >Tree Of Life</option>
										  <option value="Best Pet" >Best Pet</option>
										  <option value="Pedigree" >Pedigree</option>
										  <option value="ToolStream" >ToolStream</option>
										  <option value="Draper" >Draper</option>
										  <option value="ToolBank" >ToolBank</option>
										  <option value="Vow" >Vow</option>
									   </select>
									</div>
									<div class="form-group col-md-4">
									   <label for="exampleInputName2" style="width:40%; float:left">Item Order:</label> 
									   <select class="form-control m-b" id="itemorderservice" name="itemorderservice" style="width:150px;float:left">
										  <option value="0"  style="">All</option>
										  <option value="1" >Single</option>
										  <option value="2" >Multiple</option>
									   </select>
									</div>
									<div class="form-group col-md-6"> 
										<button id="btnApplyFilter" class="btn btn-theme mar-right-15" type="button"> Apply Filter </button> 
										<button id="btnResetFilter" class="btn btn-theme" type="reset"> Reset Filter </button> 
									</div>
								 </form>
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			   <div class="spacer10"></div>	
				<div class="row">
					<div class="col-md-12">
						<div class="row col-md-12 btnTop">
							<a type="button" class="btn btn-primary" id="print_picking_list_fixed" style="background-color: #1665D8; margin-bottom: 5px">
								<span class="fa fa-edit fa-lg"></span> Print Picking List
							</a>
							<a type="button" class="btn btn-purple" id="move_order_stage_fixed" style="background-color: #833471; margin-bottom: 5px">
								<span class="fa fa-random fa-lg"></span> Move Order Stage
							</a>
							<a type="button" class="btn btn-success" id="unlock_orders_fixed" style="background-color: #E91E63; margin-bottom: 5px">
								<span class="fa fa-unlock fa-lg"></span> Unlock Orders
							</a>
							<a type="button" class="btn bg-green" id="export_orders_fixed" style="background-color: #673AB7; margin-bottom: 5px">
								<span class="fa fa-upload fa-lg"></span> Export Orders
							</a>
							<a type="button" class="btn btn-success" id="print_invoice_lable_fixed" style="background-color: #242424; margin-bottom: 5px">
								<span class="icon-printer fa-lg"></span> Print Invoice/Label
							</a>
							<a type="button" class="btn btn-success" id="upload_tracking_ids_fixed" style="background-color: #EE5A24; margin-bottom: 5px">
								<span class="icon-printer fa-lg"></span> Upload Tracking ID's
							</a>
							<?php if($dbcode == 20){ ?>
								<a type="button" class="btn btn-info mar-left-5" style="background-color: #3F51B5; margin-bottom: 5px">Send to FBA</a>
							<?php } ?>
							<a type="button" class="btn btn-purple" id="mark_shipped_fixed" tooltip="Mark as shipped on marketplaces" style="background-color: #FE4C4C; margin-bottom: 5px">Mark as Shipped</a> 
						</div>
					</div>
				</div>
				<div class="spacer10"></div>
				<br/>
				<div class="row">
					<div class="col-sm-12">
						<div class="scan-general">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td class="ng-binding">Total Number of Orders: <span id="recordsTotal" >0</span></td>
										<td class="ng-binding">Single Item Order Count: <span id="singleordercount" >0</span></td>
										<td class="ng-binding">Multiple Item Order Count: <span id="multipleordercount" >0</span></td>
										<td class="ng-binding">Number of Items: <span id="totalitem" >0</span></td>
										<td class="ng-binding">Number of Item quanity: <span id="totalitemquantity" >0</span></td>
										<td class="ng-binding">No Of Orders Selected: <span id="selected_skus" >0</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row" style="padding-top:2px">
					<div class="col-sm-12 col-md-12 text-right fullWidth mar-top-5">
						<ul class="list-inline" style="float: left; margin-top: 15px">
							<li> <div ng-show="rshow" class="" style="">
								<form role="form" id="fullSearch" class="form-inline">
									<div class="form-group text-left mar-top-5 mar-right-5">
										<ul class="list-inline">
											<li class="mar-right-5">
												<label>Order Search</label>
													<select name="account" id="accountSearch" class="form-control m-b" style="">
														<option value="orderid" selected="selected">Order No</option>
														<option value="itemsku">SKU</option>
														<option value="itemname">Item Name</option>
														<option value="shippingpostcode">Postcode</option>
														<option value="binlocation">Bin Location</option>
														<option value="shippingservice">Shipping Service</option>
														<option value="shipingname">Shipping Name</option>
														<option value="phonenumber">Phone Number</option>
														<option value="emailid">Email-ID</option>
														<option value="couriertrackingnumber">Courier Tracking Number</option>
														<option value="ebayuserid">eBay User ID</option>
														<option value="ProductId">Product ID</option>
														<option value="SupplierSKU">Supplier SKU</option>
													</select>
											</li>
											<li>
												<input type="text" id="txtSearch" required placeholder="Search" class="form-control srch-filed">
											</li>
											<li>
												<!--<a href="#" id="aSearch">-->
												<button type="submit" style="border:none">
													<em type="submit" class="fa fa-search pad-font-icon"></em>
												</button>
											</li>
											<li>
												<a href="#">Clear Search</a>
											</li>
											<li>
												<span class="srchStage">
													<label class="chkbox mar-right-5">
														<input type="checkbox" checked id="pSearchByStage" name="pSearchByStage" class="">
													</label>&nbsp;Search in all Order Stages
												</span>
											</li>
											<li>
												<span class="srchStage">
													<label class="chkbox mar-right-5">
														<input type="checkbox" id="isPrime" name="isPrime" class="">
													</label>&nbsp;Prime Orders
												</span>
											</li>
											<li>
												<a href="#" class="mar-right-30 settings_tab" data-toggle="modal" data-target="#settingModal" placeholder="Columns Settings">
													<img src="<?= BASE_URL?>common/images/settings-icon.682ad8cc.png">
												</a>
											</li>
										</ul>
									</div>
								</form>
							</li>
						</ul>
					</div>
				</div>
				<div class="row col-md-10" id="scroll" title="Scroll to Top" style="padding-left: 2%;z-index: 100;top: 101px; display: none;">
					<a type="button" class="btn btn-primary" id="print_picking_list_fixed" style="background-color: #1665D8; margin-bottom: 5px">
						<span class="fa fa-edit fa-lg"></span> Print Picking List
					</a>
					<a type="button" class="btn btn-purple" id="move_order_stage_fixed" style="background-color: #833471; margin-bottom: 5px">
						<span class="fa fa-random fa-lg"></span> Move Order Stage
					</a>
					<a type="button" class="btn btn-success" id="unlock_orders_fixed" style="background-color: #E91E63; margin-bottom: 5px">
						<span class="fa fa-unlock fa-lg"></span> Unlock Orders
					</a>
					<a type="button" class="btn bg-green" id="export_orders_fixed" style="background-color: #673AB7; margin-bottom: 5px">
						<span class="fa fa-upload fa-lg"></span> Export Orders
					</a>
					<a type="button" class="btn btn-success" id="print_invoice_lable_fixed" style="background-color: #242424; margin-bottom: 5px">
						<span class="icon-printer fa-lg"></span> Print Invoice/Label
					</a>
					<a type="button" class="btn btn-success" id="upload_tracking_ids_fixed" style="background-color: #EE5A24; margin-bottom: 5px">
						<span class="icon-printer fa-lg"></span> Upload Tracking ID's
					</a>
					<?php if($dbcode == 20){ ?>
						<a type="button" class="btn btn-info mar-left-5" style="background-color: #3F51B5; margin-bottom: 5px">Send to FBA</a>
					<?php } ?>
					<a type="button" class="btn btn-purple" id="mark_shipped_fixed" tooltip="Mark as shipped on marketplaces" style="background-color: #FE4C4C; margin-bottom: 5px">Mark as Shipped</a> 
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-bordered">
							<table id="order_dashboard" class="dataTable no-footer table table-bordered table-striped">
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
</div>
<div id="settingModal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class=" " style="">
				<div class="row pad-left-right-15 " id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Customise Order View</b></h4>
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
							<button class="btn btn-theme mar-left-15" id="order_settings"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Custom select date start-->
<div id="customDate" class="modal fade">
   <div class="modal-dialog modal-dialog" style="">
      <div class="modal-content">
         <div>
            <h2 style="color: #5b5b5b; font-size: 26px; font-weight: normal; margin-bottom: 5px" class="mar-top-15" id="ngdialog1-aria-labelledby">Custom Order Dates</h2>
            <div class="ful-width traditional" id="exportOrdesMainDiv">
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <div class="panel-default">
                     <div class="panel-body">
                        <div class="row mar-top-5">
                           <div class="col-md-5"> <label class="control-label">From Date</label> </div>
                           <div class="col-md-5"> <label class="control-label">To Date</label> </div>
                        </div>
                        <div class="row">
                           <div class="col-md-5">
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" required name="startdate" class="form-control" uib-datepicker-popup="dd-MMMM-yyyy" id="custom_start1" >
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" required name="enddate" class="form-control" id="custom_end1"  close-text="Close">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-lg-5"> <button class="btn btn-warning margin-top-tw cancel" data-dismiss="modal" type="button">Cancel</button> </div>
                           <div class="col-lg-1 mar-right-15 pull-right"> <button class="btn btn-info margin-top-tw" data-dismiss="modal">Save</button> </div>
                           <div class="col-lg-2" id="whirl-div" style="margin-right: 20px"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Custom select date end-->
<!-- Print pickup list popup-->
<div id="pickupList" class="modal fade" role="alertdialog">
	<div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="ngdialog1-aria-labelledby">Picking List Profile</h4>
					</div>
					<form class="pickupListPrint">
						<div class="col-md-10 mar-top-20 return-manage-pop-check pad-right-10">
						   <label class="col-xs-3"> Picking List </label> 
						   <select style="width: 250px;" id="pickupSheetSelect" required="" class="form-control m-b" data-parsley-error-message="Please select Pickup Sheet Profile">
							  <option value="">Select Picking List Profile</option>
						   </select>
						</div>
						<div class="col-lg-12">
							<div class="form-group col-lg-3 pull-right mar-top-10">
								<button class="btn btn-theme mar-left-15"> <span class="icon-printer"></span> Print </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="pickupListPreview" class="modal fade" role="alertdialog">
	<div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="ngdialog1-aria-labelledby">Picking List Preview</h4>
					</div>
					<div class="col-lg-12">
						<div class="panel-default">
							<div class="panel-body">
								<div class="form-group">
									<div class="col-lg-12 iframe-width-height-dummy" id="iframe_content"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Print pickup list popup end-->
<!-- Move order stage popup-->
<div id="MoveOrderStage" class="modal fade" role="alertdialog">
	<div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 style="color: #5b5b5b; font-size: 26px; font-weight: normal; margin-bottom: 5px; margin-left: 15px; margin-top: 15px">Set Order Stage</h4>
					</div>
					<form id="moveOrderStageForm">
						<div class="col-md-10 mar-top-20 return-manage-pop-check pad-right-10">
							<label class="col-xs-3"> Order Stage </label> 
							<select style="width: 250px;" class="form-control m-b" id="moveOrderStageSelect" required class="form-control m-b">
								<option value="">--select--</option>
								<option value="1" style="">Pending</option>
								<option value="2">Just Arrived</option>
								<option value="3">Picking List Printed</option>
								<option value="4">Dispatch Note Printed</option>
								<option value="5">Courier Label Printed</option>
								<option value="6">Awaiting Courier Pickup</option>
								<option value="7">Invoice Printed</option>
								<option value="8">Canceled</option>
								<option value="9">Backorder</option>
								<option value="10">Refunded</option>
								<option value="11">Dispatched</option>
								<option value="12">Awaiting Return From Customer</option>
								<option value="13">RMA Received</option>
								<option value="14">RMA Resent - Just Arrived</option>
								<option value="18">Sent To FBA</option>
								<option value="20">Dispatched Confirmed</option>
								<option value="22">Re-Dispatched</option>
								<option value="23">Awaiting Customer Confirmation</option>
							</select>
						</div>
						<div class="col-lg-12">
							<div class="form-group col-lg-3 pull-right mar-top-10">
								<button class="btn btn-theme mar-left-15"> <span class="icon-printer"></span> Save </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Move order stage popup end-->
<!-- Get all users popup-->
<div id="GetAllUsers" class="modal fade" role="alertdialog">
	<div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="ngdialog1-aria-labelledby">Assign Locked Orders To Me</h4>
					</div>
					<form class="unlockOrdersForm">
						<div class="col-md-10 mar-top-20 return-manage-pop-check pad-right-10">
						   <label class="col-xs-3"> Locked by User: </label> 
						   <select style="width: 250px;" id="unlockOrdersSelect" required="" class="form-control m-b">
							  <option value="">----Select----</option>
						   </select>
						</div>
						<div class="col-lg-12">
							<div class="form-group col-lg-3 pull-right mar-top-10">
								<button class="btn btn-theme mar-left-15"></span> Unlock </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- get all users popup end-->
<!-- Export Orders popup-->
<div id="ExportOrders" class="modal fade" role="alertdialog">
	<div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="ngdialog1-aria-labelledby">Export Orders</h4>
					</div>
					<div class="modal-body">
						<form id="exportOrdersForm" method="POST">
							<div class="col-md-10 mar-top-20 return-manage-pop-check pad-right-10">
								<label class="col-xs-3"> Order Stage </label> 
								<select style="width: 250px;" name="orderstagecode" class="form-control m-b" id="moveOrderStageSelect" required class="form-control m-b">
									<option value="">--select--</option>
									<option value="1" style="">Pending</option>
									<option value="2">Just Arrived</option>
									<option value="3">Picking List Printed</option>
									<option value="4">Dispatch Note Printed</option>
									<option value="5">Courier Label Printed</option>
									<option value="6">Awaiting Courier Pickup</option>
									<option value="7">Invoice Printed</option>
									<option value="8">Canceled</option>
									<option value="9">Backorder</option>
									<option value="10">Refunded</option>
									<option value="11">Dispatched</option>
									<option value="12">Awaiting Return From Customer</option>
									<option value="13">RMA Received</option>
									<option value="14">RMA Resent - Just Arrived</option>
									<option value="18">Sent To FBA</option>
									<option value="20">Dispatched Confirmed</option>
									<option value="22">Re-Dispatched</option>
									<option value="23">Awaiting Customer Confirmation</option>
								</select>
							</div>
							<div class="row mar-top-5">
								<div class="col-md-5">
									<label class="control-label">From Date</label>
								</div>
								<div class="col-md-5">
									<label class="control-label">To Date</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group">
											<input type="text" name="fromdate" class="form-control" uib-datepicker-popup="dd-MMMM-yyyy" id="exp_start">
											<ul class="parsley-errors-list" id="parsley-id-3621"></ul>
											<label class="input-group-addon" for="start"><span class="fa fa-calendar"></span></label>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group">
											<input type="text" name="todate" class="form-control" id="exp_end" uib-datepicker-popup="dd-MMMM-yyyy">
											<ul class="parsley-errors-list" id="parsley-id-2721"></ul>
											<label class="input-group-addon" for="end"> <span class="fa fa-calendar"></span> </label>
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-3 control-label">Email Address</label>
								<div class="col-md-7">
									<input type="text" id="email_address" required="" class="form-control" name="email_address">
									<ul class="parsley-errors-list" id="parsley-id-4869"></ul>
									<span>Separate e-mail addresses with commas(',').</span>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-lg-2"> <button class="btn btn-warning margin-top-tw cancel" data-dismiss="modal" type="button"> Cancel </button> </div>
									<div class="col-lg-5 pull-right text-right"> <button type="submit" class="btn btn-info margin-top-tw"> Save </button> </div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Export Orders popup end-->

<!-- Upload Trackid start -->
<div id="UploadTrackingId" class="modal fade" role="alertdialog" aria-labelledby="ngdialog3-aria-labelledby">
	<div class="modal-dialog" style="">
		<div class="modal-content">
			<div class=" " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="ngdialog1-aria-labelledby">Upload Tracking ID's</h4>
					</div>
					<div class="row modal-body">
						<div class="col-lg-12">
							<div class="panel-default">
								<div class="panel-body">
									<form id="UploadTrackingIdForm" role="form" class="form-horizontal">
										<div class="row">
											<div>
											   <div class="col-md-4">
												  <fieldset>
													 <div class="form-group">
														<div>
														   <div> <label> <input type="radio" name="trackInvoice" checked="checked" value="0" style=""> Track ID </label> </div>
														</div>
													 </div>
												  </fieldset>
											   </div>
											   <div class="col-md-8">
												  <fieldset>
													 <div class="form-group">
														<div>
														   <div>
															<label>
																<input type="hidden" id="filepathaws" name="filepathaws" />
																<input type="radio" name="trackInvoice" value="1"> Track ID and Change Order Stage
															</label>
														</div>
														</div>
													 </div>
												  </fieldset>
											   </div>
											</div>
										</div>
										<div class="row mar-top-10">
											<div class="form-group file-input-inventory">
											   <label class="col-lg-4">Sample Template File</label> 
											   <div class="col-lg-8"> <a style="cursor: pointer" href="https://clientfileuploads.s3.amazonaws.com/dispatchtemplate/DespatchedOrderFile.xlsx"><i class="fa fa-download"></i></a> </div>
											</div>
										</div>
										<div class="row mar-top-10">
											<div class="form-group file-input-inventory">
											   <label class="col-lg-4">Upload Tracking File</label> 
											   <div class="col-lg-8">
												  <input filestyle="" required="required" valid-file="" type="file" name="file" id="upload-select" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" runat="server" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
												  <div class="bootstrap-filestyle input-group"><input type="text" class="form-control " disabled=""> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="upload-select" class="btn btn-default "><span class="glyphicon glyphicon-folder-open"></span> Choose file</label></span></div>
												  <span class="text-danger ng-hide" style=""> Please Select File Location. </span> 
											   </div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
											   <div class="col-lg-2"> <button class="btn btn-warning margin-top-tw cancel" data-dismiss="modal" type="button"> Cancel </button> </div>
											   <div class="col-lg-5 pull-right text-right"> <button type="submit" class="btn btn-info margin-top-tw"> Save </button> </div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </div>
</div>
<!-- Upload trackid end -->

<!-- Print invoice/Label start-->
<div id="PrintInvoiceLabel" class="modal fade">
   <div class="modal-dialog modal-dialog" style="">
		<div class="modal-content">
			<div>
				<button type="button" class="close" data-dismiss="modal" style="margin-right:10px">&times;</button>
				<h2 style="color: #5b5b5b; font-size: 26px; font-weight: normal; margin-bottom: 0px; margin-left: 15px; margin-top: 15px" id="ngdialog2-aria-labelledby">Select Document to Print</h2>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel-default">
						<div class="panel-body">
							<p class="selected_printlabel"></p>
								<form id="PrintInvoiceLabelForm">
									<div class="col-md-6">
										<fieldset>
										   <div class="form-group">
											  <div class="col-lg-offset-2 col-lg-10">
												 <div class="checkbox c-checkbox">
													<label> <input type="checkbox" name="invoicetemplate" id="invoicetemplate" > <span class="fa fa-check"></span>Invoice </label>
												 </div>
											  </div>
										   </div>
										</fieldset>
									</div>
									<div class="col-md-6">
										<fieldset>
										   <div class="form-group">
											  <div class="col-lg-offset-2 col-lg-10">
												 <div class="checkbox c-checkbox">
													<label> <input type="checkbox" name="courierChkboxLabel" id="courierChkboxLabel"> <span class="fa fa-check"></span>Label </label>
												 </div>
											  </div>
										   </div>
										</fieldset>
									</div>
									<div class="form-group col-md-8 hide"  id="invoicetemplate_select">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Template</label>
										<?php if(($dbcode != 50) && ($dbcode != 45) && ($dbcode != 43) && ($dbcode != 78) && ($dbcode != 30)){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
											   <option value="" selected="selected">Select Template</option>
											   <option value="1">Invoice without PPI</option>
											   <option value="2">Invoice with PPI</option>
											   <option value="3">Amazon Invoice Layout</option>
											   <option value="4">eBay Invoice Layout</option>
											   <?php if($dbcode == 41){ ?>
												<option value="6">Trimming Shop 007 Ltd / HQ71198</option>
												<option value="7">Wedding Suppliers London Ltd / HQ60963</option>
												<option value="8">Trimming Shop Group Ltd / HQ80936</option>
											   <?php } ?>
											   <?php if($dbcode == 47){ ?>
												<option value="9">Royal Mail 8 X 8 Address Labels</option>
												<?php } ?>
												<?php if($dbcode == 44){ ?>
												<option value="15">Royal Mail 48</option>
												<?php } ?>
												<?php if($dbcode == 29){ ?>
												<option value="17">Clothing Direct - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 17){ ?>
												<option value="18">St Michael's Hospice - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 59 || $dbcode == 18){ ?>
												<option value="19" >Alexthefatdawg - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 61){ ?>
												<option value="20">Juile Bookshop - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 50){ ?>
												<option value="21">DHL - Label</option>
												<option value="22">Courier - Invoice</option>
												<option value="23">Royal Mail 2nd Class - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 57){ ?>
												<option value="24">Royal Mail 24 Class - Invoice</option>
												<option value="25">Royal Mail 48 Class - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 51){ ?>
												<option value="28">Royal Mail 1st Class - Invoice</option>
												<option value="29">Royal Mail 2nd Class - Invoice</option>
												<option value="30">DPD - Invoice</option>
												<option value="31">Shop Counter Sales - Invoice</option>
												<?php } ?>
												<?php if($dbcode == 68){ ?>
												<option value="37">Haber Crafts Invoice - RM48</option>
												<option value="38">Haber Crafts Invoice - RM24</option>
												<option value="40">Haber Crafts Invoice - Express</option>
												<?php } ?>
												<?php if($dbcode == 77){ ?>
												<option value="45">Champion Dreams Ltd RM 48 Class Invoice</option>
												<option value="53">Champion Dreams Ltd RM 24 Class Invoice</option>
												<?php } ?>
												<?php if($dbcode == 70){ ?>
												<option value="46">Pannu Design Invoice</option>
												<?php } ?>
												<?php if($dbcode == 78){ ?>
												<option value="48">Frederick Thomas Ties Invoice</option>
												<option value="50">PPI First Class UK Invoice</option>
												<option value="51">PPI Second Class UK Invoice</option>
												<option value="52">PPI First Class NON UK Invoice</option>
												<?php } ?>
												<?php if($dbcode == 79){ ?>
												<option value="54">Invoice - Direct Products</option>
												<option value="55">Label - Direct Products</option>
												<?php } ?>
												<?php if($dbcode == 71){ ?>
												<option value="47">Urban Trading Invoice (Default)</option>
												<option value="59">Urban Trading - Direct link</option>
												<option value="60">Urban Trading - Direct link Tracked</option>
												<option value="61">Urban Trading - Royal Mail 2nd Class</option>
												<option value="62">Urban Trading - Royal Mail Tracked 48</option>
												<option value="63">Urban Trading - UPS</option>
												<?php } ?>
												<?php if($dbcode == 58){ ?>
												<option value="64">Boris Doris Invoice</option>
												<?php } ?>
												<?php if($dbcode == 74){ ?>
												<option value="65">84 charing cross Invoice</option>
												<?php } ?>
												<?php if($dbcode == 46){ ?>
												<option value="66">FootKit Invoice</option>
												<option value="67">PERFECT FIT MENS Invoice</option>
												<?php } ?>
												<?php if($dbcode == 64){ ?>
												<option value="68">Rejel Automotive Invoice</option>
												<?php } ?>
											</select>
										<?php } ?>
										<?php if($dbcode == 78){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
												<option value="0" selected="selected">Select Template</option>
												<option value="48">Frederick Thomas Ties Invoice</option>
												<option value="50">UK 24 PPI</option>
												<option value="51">Intl 1st PPI</option>
												<option value="52">No PPI</option>
											</select>
										<?php } ?>
										<?php if($dbcode == 50){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
												<option value="0" selected="selected">Select Template</option>
												<option value="5">Invoice</option>
												<option value="21">DHL - Label</option>
												<option value="22">Courier Label</option>
												<option value="23">Royal Mail 2nd Class - Label</option>
											</select>
										<?php } ?>
										<?php if($dbcode == 43){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
												<option value="0" selected="selected">Select Template</option>
												<option value="5">Invoice without PPI with VAT</option>
												<option value="32">Royal Mail 1st Class</option>
												<option value="33">Royal Mail 2nd Class</option>
												<option value="34">Royal Mail 1st Class Signature</option>
												<option value="35">Royal Mail 2nd Class Signature</option>
											</select>
										<?php } ?>
										<?php if($dbcode == 45){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
												<option value="0" selected="selected">Select Template</option>
												<option value="26">Invoice</option>
												<option value="27">Label</option>
											</select>
										<?php } ?>
										<?php if($dbcode == 30){ ?>
											<select class="chosen-select form-control" name="templatelabel" id="templatelabel_select">
												<option value="0" selected="selected">Select Template</option>
												<option value="69">Royal Mail Class1</option>
												<option value="70">Royal Mail Class2</option>
											</select>
										<?php } ?>
									</div>
									<div class="form-group col-md-8 hide"  id="courierlabel">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Courier</label> 
										<select class="chosen-select form-control" name="courierlabel" id="courierlabel_select">
											<option value="0" selected="selected">Select Courier</option>
											<option value="GFS">GFS</option>
											<?php if($dbcode == 49){ ?>
												<option value="PostPackages">Post n Packages</option>
											<?php } ?>
											<?php if($dbcode == 52){ ?>
												<option value="Flipkart" >Flipkart</option>
											<?php } ?>
											<?php if($dbcode == 77){ ?>
												<option value="9">APC</option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group col-md-8 hide"  id="carrierlabel">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Carrier</label> 
										<select class="chosen-select form-control" name="courierlabel" id="carrierlabel_select">
										   <option value="" selected="selected">Select Carrier</option>
										</select>
									</div>
									<div class="form-group col-md-8 hide"  id="accountlabel">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Account</label> 
										<select class="chosen-select form-control" name="courierlabel" id="accountlabel_select">
											<option value="0" selected="selected">Select Account</option>
											<option value="Trimming Shop Group Limited">Trimming Shop Group Limited</option>
											<option value="Trimming Shop 007 Limited">Trimming Shop 007 Limited</option>
											<option value="Wedding Suppliers London Ltd">Wedding Suppliers London Ltd</option>
										</select>
									</div>
									<div class="form-group col-md-8 hide"  id="servicecodelabel">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Service Code</label> 
										<select class="chosen-select form-control" name="courierlabel" id="servicecodelabel_select">
										   <option value="" selected="selected">Select Service Code</option>
										</select>
									</div>
									<div class="form-group col-md-8 hide" id="serviceslabel">
										<label style="color: #5b5b5b; font-size: 16px; font-weight: normal">Select Services</label>
										<div>
											<select class="chosen-select form-control" name="servicelabel" id="serviceslabel_select">
												<option value="0" selected="selected">Select Services 222</option>
												<?php if($dbcode == 77){ ?>
													<option value="281" >9 AM Parcel Service</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group col-md-8 hide" id="parcellabel">
										<div class="row">
											<div>
												<div class="col-md-4">
													<fieldset>
														<div class="form-group">
														   <div>
															  <div>
																 <label> <input type="radio" name="lblcourier" checked="checked" value="0"> Parcel </label>
																 <ul class="parsley-errors-list" id="parsley-id-multiple-lblcourier"></ul>
															  </div>
														   </div>
														</div>
													</fieldset>
												</div>
												<div class="col-md-8">
													<fieldset>
														<div class="form-group">
														   <div>
															  <div>
																 <label> <input type="radio" name="lblcourier" value="1"> Large Letter </label>
																 <ul class="parsley-errors-list" id="parsley-id-multiple-lblcourier"></ul>
															  </div>
														   </div>
														</div>
													</fieldset>
												</div>
											</div>
										</div>
										<div class="row">
										   <div style="">
											  <div class="col-md-12">
												 <fieldset>
													<div class="form-group">
													   <div>
														  <div> <label> Average Weight (Kgs) </label> </div>
													   </div>
													</div>
												 </fieldset>
											  </div>
										   </div>
										</div>
										<div class="row">
										   <div>
											  <div class="col-md-12">
												 <fieldset>
													<div class="form-group">
													   <div>
														  <div>
															 <input type="text" name="weight" id="weight" placeholder="Average Weight">
															 <ul class="parsley-errors-list" id="parsley-id-6739"></ul>
														  </div>
													   </div>
													</div>
												 </fieldset>
											  </div>
										   </div>
										</div>
									</div>
									<div class="form-group col-md-12">
										<div class="col-lg-2"> <button class="btn btn-warning margin-top-tw cancel" data-dismiss="modal" type="button"> Cancel </button> </div>
										<div class="col-lg-5 pull-right text-right">
										   <button type="submit" class="btn btn-info margin-top-tw">
										   <span> Print</span>
										   </button>
										</div>
										<div ng-show="authMsgUpdateRGroup" style="margin-top: 5px;" class="col-lg-4 alert alert-danger text-center ng-binding ng-hide">  </div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Print invoice/Label end-->

<!-- printinvoice api start -->
<div id="printinvoiceapi" class="modal fade" role="alertdialog" aria-labelledby="ngdialog3-aria-labelledby">
	<div class="modal-dialog modal-dialog" style="">
		<div class="modal-content">
			<div class=" " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="row modal-body">
						<div class="col-lg-12">
							<div class="panel-default">
								<div class="panel-body printinvoiceapi_data">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </div>
</div>
<!-- printinvoice api end -->
<div id="invoicelableprint">
	<!-- placeholder for invoice template -->
</div>

<div id="pickupsheetprint">
	<!-- placeholder for invoice template -->
</div>

<style>
.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox] {
    visibility: unset;
}
.multiselect {
    width: 150px;
    margin-right: 1%;
}
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
.drop-and-drag-image .col-md-3 {
    height: 290px;
}
.drop-and-drag-image img {
    width: 220px;
    height: 220px;
    padding-top: 0px;
}
.portlets-wrapper {
    overflow: visible;
}
.wrapper {
	overflow: visible;
}
</style>
<?php include("../common/footer.php"); ?>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/orders/common-orders.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/orders/common-invoices.js"></script>
<script type="text/javascript" charset="utf8"  src="<?= BASE_URL ?>common/js/multi-select/multiselect-jquery.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>common/bootstrap/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">	
<script src="<?= BASE_URL ?>common/bootstrap/vendor/moment/min/moment-with-locales.min.js"></script>
<script src="<?= BASE_URL ?>common/bootstrap/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/alasql.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/JsBarcode.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/CODE128.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/jspdf.min.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/jspdf.plugin.autotable.js"></script>
<script src="<?= BASE_URL ?>common/js/jspdf/jspdf.plugin.text-align.js"></script>
<script>
$(document).ready(function(){
	$(window).scroll(function () {
            if ($(this).scrollTop() > 250) {
                $('#scroll').fadeIn();
            } else {
                $('#scroll').fadeOut();
            }
        });
	$('#custom_start').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('#custom_end').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('#custom_start1').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('#custom_end1').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('#exp_start').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('#exp_end').datetimepicker({
		format: 'DD-MM-YYYY'
	});
	$('.traditional').addClass('whirl');
	X247Orders.sortable_s('sortable1');
	X247Orders.load_filters('orders/filter_data.php');
	X247Orders.main_data('orders/scripts/order_dashboard_processing.php','orders/marketplace_columns.php','order_dashboard');
	
	//settings apply click send save data file also
	$('body').on("click", "#order_settings", function( e) {
		X247Orders.order_settings('settingModal','orders/assign_order_columns.php');
	});
	
	$('#ordersevcice').multiselect({includeSelectAllOption: true});
	$('#supplierservice').multiselect({includeSelectAllOption: true});
	
	$('#datesevcice').on("change",function( e) {
		if($(this).val() == "CDate"){
			$('#customDate').modal('show');
		}
	});
});
</script>