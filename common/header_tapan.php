<?php require_once("../ebayapis/ebay_data/ebay_api_end_points.php"); ?>
<html>
<head>
	<title>247cloudhub</title>
	<link rel="stylesheet" href="<?= BASE_URL ?>common/bootstrap/vendor/bootstrap/dist/css/bootstrap.css" />
	<link rel="stylesheet" href="<?= BASE_URL ?>common/css/header-footer.css" />
	<link rel="shortcut icon" href="<?= BASE_URL ?>common/images/favicon.ico"> 
	<link rel="stylesheet" href="<?= BASE_URL ?>common/css/main.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>common/css/main.b1c77ee9.css">
	<link rel="stylesheet" media = "print" href="<?= BASE_URL ?>common/css/media.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link href="<?= BASE_URL ?>common/bootstrap/vendor/fontawesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= BASE_URL ?>common/bootstrap/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
	<script type="text/javascript">var app_base_url = "<?= BASE_URL ?>";</script><!-- Dont remove this dependent in js file-->
	<script src="<?= BASE_URL ?>common/bootstrap/vendor/jquery/dist/jquery.js"></script>
	<script src="<?= BASE_URL ?>common/bootstrap/vendor/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?= BASE_URL ?>common/js/dashboard.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>common/css/datatable/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>common/css/selectize/selectize.default.css">
	<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/bootstrap/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/selectize/selectize.min.js"></script>
</head>

<body class="layout-fixed">
    <!-- bnPreload:  -->
    <div style="height:fit-content">
        <!-- uiView: content -->
        <div class="wrapper" style="">
        
			<header class="topnavbar-wrapper ng-scope">
				<nav role="navigation" class="navbar topnavbar">
					<div class="navbar-header">
						<a href="<?= BASE_URL ?>" class="navbar-brand">
							<div class="brand-logo"> <img src="<?= BASE_URL ?>common/images/dashboard_logo.png" alt="App Logo" class="img-responsive media-logo-none"> </div>
							<div class="brand-logo-collapsed"> <img src="<?= BASE_URL ?>common/images/dashboard_logo.png" alt="App Logo" class="img-responsive media-logo-block"> </div>
						</a>
					</div>
					<div class="nav-wrapper" style="height: 55px;">
						<ul class="nav navbar-nav">
							<li>
								<a href="#" ng-click="app.layout.isCollapsed = !app.layout.isCollapsed" class="hidden-xs display-none-nav">
									<em class="fa fa-navicon"></em>
								</a>
								<a href="#" toggle-state="aside-toggled" no-persist="no-persist" class="visible-xs sidebar-toggle">
									<em class="fa fa-navicon"></em>
								</a>
							</li>
							<li class="dropdown display-li" style="min-height: 55px">
								<a href="<?= BASE_URL ?>/services" data-toggle="dropdown" id="arrow-top-navi" class="service-button" style="padding-bottom: 11px !important; font-size: 15px; padding-right: 22px; margin: 0px">
									<img src="<?= BASE_URL ?>common/images/push-pin.6dc5842c.png" width="" style="margin-right:10px; margin-top:-5px"> Services
								</a>
								<!-- services start -->
									<?php include("../common/services.php"); ?>
								<!-- services end -->
							</li>
						</ul>
						<div id="quicklinksmain" class="width-top-drag">
							<div id="cart" class="top-draganddrop">
								<ul id="horizontal1" class="quickLinkAdd ui-droppable">
			                            <li>Quick Links : </li>
			                            <li class="placeholder"></li>
			                            <li id="scanpackship" style="">
			                                <a href="<?= BASE_URL ?>scan-pick-ship" rel="Scan, Pack and Ship" class="ng-binding">Scan, Pack and Ship </a>
			                            </li>
			                            <li id="inventoryhub">
			                                <a href="<?= BASE_URL ?>inventory-dashboard" rel="Inventory Hub (Common Inventory)" class="ng-binding">Inventory Hub (Common Inventory) </a>
			                            </li>
			                            <li id="repriceinventory">
			                                <a href="#/app/amazon-repricing-inventory" rel="Repricing Inventory">Repricing Inventory </a>
			                            </li>
								</ul>
							</div>
						</div>
						<ul class="nav navbar-nav navbar-right" style="margin-right: 20px">
							<li class="dropdown dropdown-list">
								<a href="javascript:void(0);" class="dropdown-toggle">
									<em>
										<img src="<?= BASE_URL ?>common/images/general/login-avatar.jpg" width="31" height="31" class="ng-scope">
									</em>
								</a>
								<ul class="dropdown-menu dropdown-menu-user">
									<li>
										<div class="list-group">
											<a class="list-group-item" style="" data-toggle="modal" data-target="#myModal">
												<div class="media">
													<div class="pull-left">
														<em class="fa fa-exchange" style="font-size: 30px; color:#23c5e2"></em>
													</div>
													<div class="media-body clearfix">
														<p class="m0 workflow-padding-7" style="padding-top:5px">Switch VendorDB</p>
													</div>
												</div>
											</a>
											<a href="<?= BASE_URL."user/updateprofile" ?>" class="list-group-item">
												<div class="media">
													<div class="pull-left">
														<em class="fa fa-edit" style="font-size: 30px; color:#23c5e2"></em>
													</div>
													<div class="media-body clearfix">
														<p class="m0 workflow-padding-7" style="padding-top:5px">Edit Account Profile</p>
													</div>
												</div>
											</a>
											<a href="<?= BASE_URL ?>user/updatepassword" class="list-group-item">
												<div class="media">
													<div class="pull-left">
														<em class="icon-lock-open" style="font-size: 30px; color:#0274bd"></em>
													</div>
													<div class="media-body clearfix">
														<p class="m0 workflow-padding-7">Change Password</p>
													</div>
												</div>
											</a>
											<a href="#" class="list-group-item" style="display: none">
												<div class="media">
													<div class="pull-left">
														<em class="fa fa-tasks fa-2x text-success"></em>
													</div>
													<div class="media-body clearfix workflow-padding-8">
														<p class="m0">Pending Tasks</p>
														<p class="m0 text-muted"> <small></small> </p>
													</div>
												</div>
											</a>
											<a href="<?= BASE_URL ?>logout" class="list-group-item">
												<span>Sign Out</span>
												<span class="label pull-right">
													<em class="fa fa-power-off fa-2x text-poweroff"></em>
												</span>
											</a>
										</div>
									</li>
								</ul>
							</li>
							<li>
								<a href="#/lock" title="Lock screen" class="em-font-topnav"><em class="icon-lock"></em>  </a>
							</li>
							<li class="visible-lg">
								<a href="#" toggle-fullscreen="toggle-fullscreen" class="em-font-topnav"> <em class="fa fa-expand"></em> </a>
							</li>
							<li class="side-open-top">
								<a href="#" toggle-state="offsidebar-open" no-persist="no-persist" style="margin-left:10px" class="em-font-topnav"> <em class="icon-notebook"></em> </a>
							</li>
						</ul>
					</div>
				</nav>
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 style="color: #5b5b5b; font-weight: normal;" id="ngdialog1-aria-labelledby">Switch VendorDb Details </h3>
							</div>
							<div class="modal-body">
								<div class="row" id="vendordbdetails">
									<div class="col-md-12 mar-left-10 mar-bottom-30">
										<form name="myForm" class="" id="switchDbcode">
											<fieldset>
												<div class="form-group">
													<label class="col-sm-4 control-label">VendorDb Code</label>
													<div class="col-sm-8 media-arrow-div dropdown-arrow" id="select-arrow">
														<select id="vendorcode" name="dbcode" class="chosen-select form-control ng-pristine ng-valid ng-touched" required style="">
														</select>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="form-group mar-top-10">
													<button class="btn btn-primary mar-left-10" type="submit"> Change </button>
												</div>
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
