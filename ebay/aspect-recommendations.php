<!DOCTYPE html>
<!-- saved from url=(0050)https://showcase.247cloudhub.co.uk/#/app/dashboard -->
<html ng-app="247commerceApp" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths ng-scope gr__showcase_247cloudhub_co_uk">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>
      <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
      <meta name="description" content="247 CloudHub is a multichannel ecommerce software platform for Inventory and Order Management including Amazon Repricing.">
      <meta name="keywords" content="Multichannel Order Management, Inventory management, Amazon Repricing, eBay Listing, eBay Design">
      <title data-ng-bind="pageTitle()" class="ng-binding">247 CloudHub | Dashboard</title>
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/vendor.728ca6c0.css">
      <link href="./247 CloudHub _ Dashboard_files/css" rel="stylesheet" type="text/css">
      <link href="./247 CloudHub _ Dashboard_files/css(1)" rel="stylesheet" type="text/css">
      <link rel="shortcut icon" href="https://showcase.247cloudhub.co.uk/favican.ico" type="image/x-icon">
      <link rel="icon" href="https://showcase.247cloudhub.co.uk/favican.ico" type="image/x-icon">
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/main.b1c77ee9.css">
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/external.3fd5dc70.css">
      <link href="./247 CloudHub _ Dashboard_files/css" rel="stylesheet" type="text/css">
      <link href="./247 CloudHub _ Dashboard_files/css(1)" rel="stylesheet" type="text/css">
      <link href="./247 CloudHub _ Dashboard_files/font-awesome.min.css" rel="stylesheet">
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/simple-line-icons.css">
      <link rel="stylesheet" type="text/css" href="./247 CloudHub _ Dashboard_files/jquery.fancybox-1.3.4.css" media="screen">
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/selectize.default.css">
      <link rel="stylesheet" href="./247 CloudHub _ Dashboard_files/ebaycustom.css">
      <style>.cke{visibility:hidden;}</style>
      <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
      <style type="text/css">
        .traffic-table table>tbody>tr>td,
        .traffic-table table>tbody>tr>th {
            white-space: nowrap;   
            border-top: 1px solid #efeded !important;
            border: 1px solid #efeded !important;
            border-color: #efeded !important;
        }        
      </style>
   </head>
   <body data-ng-class="{ &#39;layout-fixed&#39; : app.layout.isFixed, &#39;aside-collapsed&#39; : app.layout.isCollapsed, &#39;layout-boxed&#39; : app.layout.isBoxed }" data-gr-c-s-loaded="true" class="layout-fixed">
      <header ng-include="'views/partials/top-navbar.html'" class="topnavbar-wrapper ng-scope">
               <style class="ng-scope">li.hiddenLI {
                  display: none;
                  }
               </style>
               <nav role="navigation" class="navbar topnavbar ng-scope" ng-controller="servicetopnavController">
                  <div class="navbar-header">
                     <a href="https://showcase.247cloudhub.co.uk/#/" class="navbar-brand">
                        <div class="brand-logo"> <img src="./247 CloudHub _ Dashboard_files/logo-white.e37dbcec.png" alt="App Logo" class="img-responsive media-logo-none"> </div>
                        <div class="brand-logo-collapsed"> <img src="./247 CloudHub _ Dashboard_files/logo-white.e37dbcec.png" alt="App Logo" class="img-responsive media-logo-block"> </div>
                     </a>
                  </div>
                  <div class="nav-wrapper">
                     <ul class="nav navbar-nav">
                        <li>  <a href="https://showcase.247cloudhub.co.uk/#" ng-click="app.layout.isCollapsed = !app.layout.isCollapsed" class="hidden-xs display-none-nav"> <em class="fa fa-navicon"></em> </a>  <a href="https://showcase.247cloudhub.co.uk/#" toggle-state="aside-toggled" no-persist="no-persist" class="visible-xs sidebar-toggle"> <em class="fa fa-navicon"></em> </a> </li>
                        <li class="dropdown display-li" style="min-height: 55px">
                           <a href="https://showcase.247cloudhub.co.uk/#" data-toggle="dropdown" id="arrow-top-navi" class="service-button" style="padding-bottom: 11px !important; font-size: 16px; padding-right: 22px; margin: 0px; padding-top: 15px"> <img src="./247 CloudHub _ Dashboard_files/push-pin.6dc5842c.png" width="" style="margin-right:5px; margin-top:-5px"> Services </a> 
                           <ul class="dropdown-menu sub-menu animated fadeInLeft" style="border: none; box-shadow: none; top: 58px; left: 170px; width: 100%">
                              <li>
                                 <div id="vtab" class="col-md-11 col-md-offset-1">
                                    <ul class="col-sm-3">
                                       <li class="Optimise" ng-show="appModuleList['Optimise'] == 'true'">Optimise</li>
                                       <li class="Compete selected" ng-show="appModuleList['Compete'] == 'true'">Compete</li>
                                       <li class="Deliver" ng-show="appModuleList['Deliver'] == 'true'">Deliver</li>
                                       <li class="Service" ng-show="appModuleList['Service'] == 'true'">Service</li>
                                       <li class="Configure" ng-show="appModuleList['Configure'] == 'true'">Configure</li>
                                       <li class="Analyse" ng-show="appModuleList['Analyse'] == 'true'">Analyse</li>
                                       <li class="Locate" ng-show="appModuleList['Locate'] == 'true'">Locate</li>
                                       <li class="Locate" ng-click="removequicklink()">Remove Quick Links</li>
                                    </ul>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="inventorydashboard" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="inventorydashboard" data-name="Inventory Hub (Common Inventory)" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Inventory Hub (Common Inventory)</a> <img id="dimg_inventorydashboard" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventorydashboard" width="" height="" class="ng-hide"> <img id="uimg_inventorydashboard" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventorydashboard" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Edit all your basic inventory information including stock, basic descriptions and other important content here.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="amazoninventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="amazoninventory" data-name="Amazon" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Amazon</a> <img id="dimg_amazoninventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="amazoninventory" width="" height="" class="ng-hide"> <img id="uimg_amazoninventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!amazoninventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">This is the dashboard for your inventory integration with Amazon. You will find all the Amazon specific fields for input in this section.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="ebayinventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="ebayinventory" data-name="eBay" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">eBay</a> <img id="dimg_ebayinventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="ebayinventory" width="" height="" class="ng-hide"> <img id="uimg_ebayinventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!ebayinventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">This is the dashboard for your inventory integration with eBay. You will find all the eBay specific fields for input in this section, including functions such as List to eBay and Revise.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="rakuteninventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="rakuteninventory" data-name="Rakuten" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Rakuten</a> <img id="dimg_rakuteninventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="rakuteninventory" width="" height="" class="ng-hide"> <img id="uimg_rakuteninventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!rakuteninventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">All the data fields required to list on Rakuten are provided on this screen for you to create or edit your inventory.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="fnacinventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="fnacinventory" data-name="FNAC" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">FNAC</a> <img id="dimg_fnacinventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="fnacinventory" width="" height="" class="ng-hide"> <img id="uimg_fnacinventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!fnacinventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">All the data fields required to list on  FNAC are provided on this screen for you to create or edit your inventory.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="cdiscountinventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="cdiscountinventory" data-name="Cdiscount" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Cdiscount</a> <img id="dimg_cdiscountinventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="cdiscountinventory" width="" height="" class="ng-hide"> <img id="uimg_cdiscountinventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!cdiscountinventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">All the data fields required to list on CDiscount are provided on this screen for you to create or edit your inventory.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="website" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="website" data-name="Website" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Website</a> <img id="dimg_website" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="website" width="" height="" class="ng-hide"> <img id="uimg_website" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!website" width="" height="" class=""> </h3>
                                             <p class="ng-binding">This is the dashboard for your inventory integration with eBay. You will find all the eBay specific fields for input in this section, including functions such as List to eBay and Revise.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="addproduct" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="addproduct" data-name="Add a Product" href="https://showcase.247cloudhub.co.uk/#/app/inventory-dashboard" class="ng-binding">Add a Product</a> <img id="dimg_addproduct" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="addproduct" width="" height="" class="ng-hide"> <img id="uimg_addproduct" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!addproduct" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create a new product quickly and easily for each of your marketplaces in an easy to use web form.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="addproductnew" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="addproductnew" data-name="Add a product New" href="https://showcase.247cloudhub.co.uk/#/app/add-product-new" class="ng-binding">Add a product New</a> <img id="dimg_addproductnew" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="addproductnew" width="" height="" class="ng-hide"> <img id="uimg_addproductnew" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!addproductnew" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="productexportimportstatus" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="productexportimportstatus" data-name="Product Export Import Status Monitor" href="https://showcase.247cloudhub.co.uk/#/app/product-export-import-status" class="ng-binding">Product Export Import Status Monitor</a> <img id="dimg_productexportimportstatus" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="productexportimportstatus" width="" height="" class="ng-hide"> <img id="uimg_productexportimportstatus" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!productexportimportstatus" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Check on the status of any inventory import or export request from this page.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="listingstatusmonitor" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="listingstatusmonitor" data-name="Listing Status Monitor" href="https://showcase.247cloudhub.co.uk/#/app/listing-status-monitor" class="ng-binding">Listing Status Monitor</a> <img id="dimg_listingstatusmonitor" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="listingstatusmonitor" width="" height="" class="ng-hide"> <img id="uimg_listingstatusmonitor" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!listingstatusmonitor" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Check the status of feeds and updates to Amazon Seller Central for your inventory. Understand where any submission errors occurred with exact dates and times.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="inventorygraphicaldashboard" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="inventorygraphicaldashboard" data-name="Inventory Graphical Dashboard" href="https://showcase.247cloudhub.co.uk/#/app/inventory-graphical-dashboard" class="ng-binding">Inventory Graphical Dashboard</a> <img id="dimg_inventorygraphicaldashboard" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventorygraphicaldashboard" width="" height="" class="ng-hide"> <img id="uimg_inventorygraphicaldashboard" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventorygraphicaldashboard" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A snapshot of inventory status, problem listings, items not live. Download each report in Excel quickly and easily as required.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="inventoryimport" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="inventoryimport" data-name="Inventory Import" href="https://showcase.247cloudhub.co.uk/#/app/inventory-import" class="ng-binding">Inventory Import</a> <img id="dimg_inventoryimport" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventoryimport" width="" height="" class="ng-hide"> <img id="uimg_inventoryimport" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventoryimport" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Import new products and update existing ones in bulk using a variety of standard or custom import profiles.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} -->
                                          <li id="inventoryexport" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'}">
                                             <h3 class="serviceItemshead"> <a data-id="inventoryexport" data-name="Inventory Export" href="https://showcase.247cloudhub.co.uk/#/app/inventory-export" class="ng-binding">Inventory Export</a> <img id="dimg_inventoryexport" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventoryexport" width="" height="" class="ng-hide"> <img id="uimg_inventoryexport" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventoryexport" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Export any inventory information held in 247Cloudhub quickly and easily for rework or reporting.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Optimise'] | filter:{pageAccess:'true'} --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: block;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="amazonrepricinginventory" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="amazonrepricinginventory" data-name="Repricing Inventory" href="https://showcase.247cloudhub.co.uk/#/app/amazon-repricing-inventory" class="ng-binding">Repricing Inventory</a> <img id="dimg_amazonrepricinginventory" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="amazonrepricinginventory" width="" height="" class="ng-hide"> <img id="uimg_amazonrepricinginventory" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!amazonrepricinginventory" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A complete list of all ASINs in your inventory being repriced and by which logic and parameters. </p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="repricingproductstatus" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="repricingproductstatus" data-name="Product Re-Pricing Status" href="https://showcase.247cloudhub.co.uk/#/app/repricing-product-status-direct" class="ng-binding">Product Re-Pricing Status</a> <img id="dimg_repricingproductstatus" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="repricingproductstatus" width="" height="" class="ng-hide"> <img id="uimg_repricingproductstatus" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!repricingproductstatus" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Drill down into the status of any ASIN being repriced in your inventory and analyse adjustment history.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="competitionanalysis" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="competitionanalysis" data-name="Competitor Analysis" href="https://showcase.247cloudhub.co.uk/#/app/competition-analysis" class="ng-binding">Competitor Analysis</a> <img id="dimg_competitionanalysis" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="competitionanalysis" width="" height="" class="ng-hide"> <img id="uimg_competitionanalysis" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!competitionanalysis" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Analyse a specific competitor, their account status and the inventory you are competing on to help make better decisions around pricing.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="inventorycompetitor" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="inventorycompetitor" data-name="Inventory Competitor Analysis" href="https://showcase.247cloudhub.co.uk/#/app/inventory-competitor/" class="ng-binding">Inventory Competitor Analysis</a> <img id="dimg_inventorycompetitor" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventorycompetitor" width="" height="" class="ng-hide"> <img id="uimg_inventorycompetitor" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventorycompetitor" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Check all competitors listing against your Inventory comparing your pricing and buy box status quickly and easily.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="amazonrepricinginventorydashboard" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="amazonrepricinginventorydashboard" data-name="Amazon Repricing Graphical Dashboard" href="https://showcase.247cloudhub.co.uk/#/app/amazon-repricing-inventory-dashboard" class="ng-binding">Amazon Repricing Graphical Dashboard</a> <img id="dimg_amazonrepricinginventorydashboard" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="amazonrepricinginventorydashboard" width="" height="" class="ng-hide"> <img id="uimg_amazonrepricinginventorydashboard" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!amazonrepricinginventorydashboard" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A snapshot report of repricing activities across each of your Amazon accounts.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="repricingreport" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="repricingreport" data-name="BuyBox Report" href="https://showcase.247cloudhub.co.uk/#/app/repricing-report" class="ng-binding">BuyBox Report</a> <img id="dimg_repricingreport" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="repricingreport" width="" height="" class="ng-hide"> <img id="uimg_repricingreport" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!repricingreport" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Repricing Report</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="algorithm-repricing" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="algorithm-repricing" data-name="Algorithm Repricing" href="https://showcase.247cloudhub.co.uk/#/app/algorithm-repricing" class="ng-binding">Algorithm Repricing</a> <img id="dimg_algorithm-repricing" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="algorithm-repricing" width="" height="" class="ng-hide"> <img id="uimg_algorithm-repricing" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!algorithm-repricing" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] -->
                                          <li id="algorithm-repricing" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Compete']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="algorithm-repricing" data-name="Bybox Reports" href="https://showcase.247cloudhub.co.uk/#/app/by-box-reports" class="ng-binding">Bybox Reports</a> <img id="dimg_algorithm-repricing" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="algorithm-repricing" width="" height="" class="ng-hide"> <img id="uimg_algorithm-repricing" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!algorithm-repricing" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Compete'] --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="scanpackship" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="scanpackship" data-name="Scan, Pack and Ship" href="https://showcase.247cloudhub.co.uk/#/app/scan-pack-ship" class="ng-binding">Scan, Pack and Ship</a> <img id="dimg_scanpackship" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="scanpackship" width="" height="" class="" style=""> <img id="uimg_scanpackship" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!scanpackship" width="" height="" class="ng-hide" style=""> </h3>
                                             <p class="ng-binding">Complete end to end order processing here from just arriving to being dispatched by your courier.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="scanpackshipprintconsole" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="scanpackshipprintconsole" data-name="Scan, Pack and Ship with Print Console" href="https://showcase.247cloudhub.co.uk/#/app/scan-pack-ship-printconsole" class="ng-binding">Scan, Pack and Ship with Print Console</a> <img id="dimg_scanpackshipprintconsole" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="scanpackshipprintconsole" width="" height="" class="ng-hide"> <img id="uimg_scanpackshipprintconsole" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!scanpackshipprintconsole" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="fbaorders" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="fbaorders" data-name="FBA Orders" href="https://showcase.247cloudhub.co.uk/#/app/fba-orders" class="ng-binding">FBA Orders</a> <img id="dimg_fbaorders" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="fbaorders" width="" height="" class="ng-hide"> <img id="uimg_fbaorders" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!fbaorders" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Integrate FBA sales for reporting. Inject shipments from websites and other marketplaces into FBA for shipping directly by Amazon.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="manualtelephoneorder" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="manualtelephoneorder" data-name="Manual / Telephone Order" href="https://showcase.247cloudhub.co.uk/#/app/manual-telephone-order" class="ng-binding">Manual / Telephone Order</a> <img id="dimg_manualtelephoneorder" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="manualtelephoneorder" width="" height="" class="" style=""> <img id="uimg_manualtelephoneorder" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!manualtelephoneorder" width="" height="" class="ng-hide" style=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="deliverpendingorders" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="deliverpendingorders" data-name="Pending Orders" href="https://showcase.247cloudhub.co.uk/#/app/deliver-pending-orders" class="ng-binding">Pending Orders</a> <img id="dimg_deliverpendingorders" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="deliverpendingorders" width="" height="" class="ng-hide"> <img id="uimg_deliverpendingorders" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!deliverpendingorders" width="" height="" class=""> </h3>
                                             <p class="ng-binding">View any pending orders from eBay and Amazon being held at the present moment in time.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="printlog" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="printlog" data-name="PDF Print Log" href="https://showcase.247cloudhub.co.uk/#/app/print-log" class="ng-binding">PDF Print Log</a> <img id="dimg_printlog" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="printlog" width="" height="" class="ng-hide"> <img id="uimg_printlog" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!printlog" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Search for any order and re-print the necessary documents associated with it from past print and order processing runs.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="printlogprintconsole" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="printlogprintconsole" data-name="Print Console Print Log" href="https://showcase.247cloudhub.co.uk/#/app/print-log-print-console" class="ng-binding">Print Console Print Log</a> <img id="dimg_printlogprintconsole" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="printlogprintconsole" width="" height="" class="ng-hide"> <img id="uimg_printlogprintconsole" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!printlogprintconsole" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="generatemanifestcancellabels" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="generatemanifestcancellabels" data-name="Generate Courier Manifest and Cancel Shipments" href="https://showcase.247cloudhub.co.uk/#/app/generate-manifest-cancel-labels" class="ng-binding">Generate Courier Manifest and Cancel Shipments</a> <img id="dimg_generatemanifestcancellabels" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="generatemanifestcancellabels" width="" height="" class="ng-hide"> <img id="uimg_generatemanifestcancellabels" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!generatemanifestcancellabels" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="orderexportstatusmonitor" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="orderexportstatusmonitor" data-name="Order Export Status Monitor" href="https://showcase.247cloudhub.co.uk/#/app/order-export-status-monitor" class="ng-binding">Order Export Status Monitor</a> <img id="dimg_orderexportstatusmonitor" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="orderexportstatusmonitor" width="" height="" class="ng-hide"> <img id="uimg_orderexportstatusmonitor" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!orderexportstatusmonitor" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="delivergraphicaldashboard" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="delivergraphicaldashboard" data-name="Deliver Graphical Dashboard" href="https://showcase.247cloudhub.co.uk/#/app/order-dashboard" class="ng-binding">Deliver Graphical Dashboard</a> <img id="dimg_delivergraphicaldashboard" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="delivergraphicaldashboard" width="" height="" class="ng-hide"> <img id="uimg_delivergraphicaldashboard" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!delivergraphicaldashboard" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A snapshot of order status, problem in processes, orders unfulfilled. Download each report in Excel quickly and easily as required.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] -->
                                          <li id="scanpackshipexport" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Deliver']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="scanpackshipexport" data-name="Scan, Pack and Ship Export" href="https://showcase.247cloudhub.co.uk/#/app/scan-pack-ship-export" class="ng-binding">Scan, Pack and Ship Export</a> <img id="dimg_scanpackshipexport" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="scanpackshipexport" width="" height="" class="ng-hide"> <img id="uimg_scanpackshipexport" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!scanpackshipexport" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Deliver'] --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Service'] -->
                                          <li id="delivercreateorder" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Service']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="delivercreateorder" data-name="Create Order" href="https://showcase.247cloudhub.co.uk/#/app/deliver-create-order" class="ng-binding">Create Order</a> <img id="dimg_delivercreateorder" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="delivercreateorder" width="" height="" class="ng-hide"> <img id="uimg_delivercreateorder" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!delivercreateorder" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create manual orders for processing, mark items as paid and inject them into the Scan, Pack and Ship screens for processing.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Service'] -->
                                          <li id="delivercustomerservice" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Service']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="delivercustomerservice" data-name="Customer Services" href="https://showcase.247cloudhub.co.uk/#/app/deliver-customer-service" class="ng-binding">Customer Services</a> <img id="dimg_delivercustomerservice" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="delivercustomerservice" width="" height="" class="ng-hide"> <img id="uimg_delivercustomerservice" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!delivercustomerservice" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Manage any incoming returns here. Make decisions around the restocking of an item and process financial tranactions and refunds.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Service'] -->
                                          <li id="websitecustomers" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Service']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitecustomers" data-name="Website Customers" href="https://showcase.247cloudhub.co.uk/#/app/website-customers" class="ng-binding">Website Customers</a> <img id="dimg_websitecustomers" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitecustomers" width="" height="" class="ng-hide"> <img id="uimg_websitecustomers" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitecustomers" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create manual orders for processing, mark items as paid and inject them into the Scan, Pack and Ship screens for processing.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Service'] -->
                                          <li id="websitesales" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Service']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitesales" data-name="Website Sales" href="https://showcase.247cloudhub.co.uk/#/app/website-sales" class="ng-binding">Website Sales</a> <img id="dimg_websitesales" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitesales" width="" height="" class="ng-hide"> <img id="uimg_websitesales" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitesales" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create manual orders for processing, mark items as paid and inject them into the Scan, Pack and Ship screens for processing.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Service'] -->
                                          <li id="vieworderscreen" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Service']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="vieworderscreen" data-name="Competitor Analysis" href="https://showcase.247cloudhub.co.uk/#/app/view-order-screen/0/0/0" class="ng-binding">Competitor Analysis</a> <img id="dimg_vieworderscreen" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="vieworderscreen" width="" height="" class="ng-hide"> <img id="uimg_vieworderscreen" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!vieworderscreen" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Service'] --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="organisation" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="organisation" data-name="Organisation Settings" href="https://showcase.247cloudhub.co.uk/#/app/organisation" class="ng-binding">Organisation Settings</a> <img id="dimg_organisation" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="organisation" width="" height="" class="ng-hide"> <img id="uimg_organisation" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!organisation" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Add or update your Company details and preferences here.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="usersettings" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="usersettings" data-name="User Permissions and Settings" href="https://showcase.247cloudhub.co.uk/#/app/user-settings" class="ng-binding">User Permissions and Settings</a> <img id="dimg_usersettings" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="usersettings" width="" height="" class="ng-hide"> <img id="uimg_usersettings" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!usersettings" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Add or update user settings and permissions. Add and remove users.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="marketplace" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="marketplace" data-name="Marketplace Accounts" href="https://showcase.247cloudhub.co.uk/#/app/marketplace" class="ng-binding">Marketplace Accounts</a> <img id="dimg_marketplace" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="marketplace" width="" height="" class="ng-hide"> <img id="uimg_marketplace" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!marketplace" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Integrate new marketplace accounts or websites with the Cloud Hub. Activate or deactivate existing integrations.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="websiteconfiguration" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websiteconfiguration" data-name="Website Configuration" href="https://showcase.247cloudhub.co.uk/#/app/website-configuration" class="ng-binding">Website Configuration</a> <img id="dimg_websiteconfiguration" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websiteconfiguration" width="" height="" class="ng-hide"> <img id="uimg_websiteconfiguration" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websiteconfiguration" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Add or update user settings and permissions. Add and remove users.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="orderworkflow" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="orderworkflow" data-name="Order Workflows" href="https://showcase.247cloudhub.co.uk/#/app/order-workflow" class="ng-binding">Order Workflows</a> <img id="dimg_orderworkflow" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="orderworkflow" width="" height="" class="ng-hide"> <img id="uimg_orderworkflow" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!orderworkflow" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create the most appropriate workflow for your business when processing orders. Assign these workflows to specific users.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="emailftp" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="emailftp" data-name="Email and FTP Settings" href="https://showcase.247cloudhub.co.uk/#/app/email-ftp" class="ng-binding">Email and FTP Settings</a> <img id="dimg_emailftp" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="emailftp" width="" height="" class="ng-hide"> <img id="uimg_emailftp" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!emailftp" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Integrate company email accounts with the CloudHub for managing customer service inbound emails.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="shippingcarrierconfiguration" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="shippingcarrierconfiguration" data-name="Shipping and Carriers" href="https://showcase.247cloudhub.co.uk/#/app/shipping-carrier-configuration" class="ng-binding">Shipping and Carriers</a> <img id="dimg_shippingcarrierconfiguration" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="shippingcarrierconfiguration" width="" height="" class="ng-hide"> <img id="uimg_shippingcarrierconfiguration" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!shippingcarrierconfiguration" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Integrate couriers and shipping services to automate the label printing and courier management process.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="invoicedesign" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="invoicedesign" data-name="Invoice Templates" href="https://showcase.247cloudhub.co.uk/#/app/invoice-design" class="ng-binding">Invoice Templates</a> <img id="dimg_invoicedesign" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="invoicedesign" width="" height="" class="ng-hide"> <img id="uimg_invoicedesign" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!invoicedesign" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="editcarrierlabeldesign" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="editcarrierlabeldesign" data-name="Carrier Labels" href="https://showcase.247cloudhub.co.uk/#/app/edit-carrier-label-design" class="ng-binding">Carrier Labels</a> <img id="dimg_editcarrierlabeldesign" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="editcarrierlabeldesign" width="" height="" class="ng-hide"> <img id="uimg_editcarrierlabeldesign" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!editcarrierlabeldesign" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="documentprintmanagement" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="documentprintmanagement" data-name="Document Print Management" href="https://showcase.247cloudhub.co.uk/#/app/document-print-management" class="ng-binding">Document Print Management</a> <img id="dimg_documentprintmanagement" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="documentprintmanagement" width="" height="" class="ng-hide"> <img id="uimg_documentprintmanagement" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!documentprintmanagement" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="orderstages" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="orderstages" data-name="Deliver Order Stages Settings" href="https://showcase.247cloudhub.co.uk/#/app/order-stages" class="ng-binding">Deliver Order Stages Settings</a> <img id="dimg_orderstages" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="orderstages" width="" height="" class="ng-hide"> <img id="uimg_orderstages" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!orderstages" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="ebayorderdownloadsettings" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="ebayorderdownloadsettings" data-name="eBay Order Download Settings" href="https://showcase.247cloudhub.co.uk/#/app/ebay-order-download-settings" class="ng-binding">eBay Order Download Settings</a> <img id="dimg_ebayorderdownloadsettings" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="ebayorderdownloadsettings" width="" height="" class="ng-hide"> <img id="uimg_ebayorderdownloadsettings" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!ebayorderdownloadsettings" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="optimiseprofiles" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="optimiseprofiles" data-name="Optimise Profiles" href="https://showcase.247cloudhub.co.uk/#/app/optimise-profiles" class="ng-binding">Optimise Profiles</a> <img id="dimg_optimiseprofiles" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="optimiseprofiles" width="" height="" class="" style=""> <img id="uimg_optimiseprofiles" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!optimiseprofiles" width="" height="" class="ng-hide" style=""> </h3>
                                             <p class="ng-binding">Configure your eBay listing templates, their design and layout here. Specify your eBay Payment profile and integrate PayPal within your listings. Configure the custom data fields you wish to use and control where you apply them. Set up the various shipping services and costs associated with your eBay listings.  Pre-define set information for listing your items to eBay for quick, easy submission.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="ebayinventoryfeedsettings" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="ebayinventoryfeedsettings" data-name="eBay Inventory Feed Settings" href="https://showcase.247cloudhub.co.uk/#/app/ebay-inventory-feed-settings" class="ng-binding">eBay Inventory Feed Settings</a> <img id="dimg_ebayinventoryfeedsettings" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="ebayinventoryfeedsettings" width="" height="" class="ng-hide"> <img id="uimg_ebayinventoryfeedsettings" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!ebayinventoryfeedsettings" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="inventoryworkflows" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="inventoryworkflows" data-name="Inventory Workflows" href="https://showcase.247cloudhub.co.uk/#/app/inventory-workflows" class="ng-binding">Inventory Workflows</a> <img id="dimg_inventoryworkflows" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventoryworkflows" width="" height="" class="ng-hide"> <img id="uimg_inventoryworkflows" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventoryworkflows" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create the most appropriate workflow for your business when creating and editing items in your inventory. Assign these workflows to specific users.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="productvariationsetup" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="productvariationsetup" data-name="Product Variations Setup" href="https://showcase.247cloudhub.co.uk/#/app/product-variation-setup" class="ng-binding">Product Variations Setup</a> <img id="dimg_productvariationsetup" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="productvariationsetup" width="" height="" class="ng-hide"> <img id="uimg_productvariationsetup" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!productvariationsetup" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Set processes for how you list items with size, colour and custom variation dropdowns.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="categorymapping" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="categorymapping" data-name="Category Mapping" href="https://showcase.247cloudhub.co.uk/#/app/category-mapping" class="ng-binding">Category Mapping</a> <img id="dimg_categorymapping" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="categorymapping" width="" height="" class="ng-hide"> <img id="uimg_categorymapping" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!categorymapping" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create rules for assigning products to the relevant categories across the marketplaces.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="productstagesettings" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="productstagesettings" data-name="Optimise Product Stages Settings" href="https://showcase.247cloudhub.co.uk/#/app/product-stage-settings" class="ng-binding">Optimise Product Stages Settings</a> <img id="dimg_productstagesettings" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="productstagesettings" width="" height="" class="ng-hide"> <img id="uimg_productstagesettings" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!productstagesettings" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="stockallocationrules" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="stockallocationrules" data-name="Stock Allocation Rules" href="https://showcase.247cloudhub.co.uk/#/app/stock-allocation-rules" class="ng-binding">Stock Allocation Rules</a> <img id="dimg_stockallocationrules" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="stockallocationrules" width="" height="" class="ng-hide"> <img id="uimg_stockallocationrules" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!stockallocationrules" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Choose the stock levels to declare to each of your marketplaces. Set rules and preferences for each.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="ebaylistingpreferences" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="ebaylistingpreferences" data-name="eBay Listing Preferences" href="https://showcase.247cloudhub.co.uk/#/app/ebay-listing-preferences" class="ng-binding">eBay Listing Preferences</a> <img id="dimg_ebaylistingpreferences" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="ebaylistingpreferences" width="" height="" class="ng-hide"> <img id="uimg_ebaylistingpreferences" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!ebaylistingpreferences" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="competeautopricingrules" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="competeautopricingrules" data-name="Compete Pricing Rules" href="https://showcase.247cloudhub.co.uk/#/app/compete-auto-pricing-rules" class="ng-binding">Compete Pricing Rules</a> <img id="dimg_competeautopricingrules" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="competeautopricingrules" width="" height="" class="ng-hide"> <img id="uimg_competeautopricingrules" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!competeautopricingrules" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create your rules and preferences for re-pricing against your competitors. Set different strategies based on a variety of Amazon Marketplace situations.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="repricingprofiles" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="repricingprofiles" data-name="Repricing Profiles" href="https://showcase.247cloudhub.co.uk/#/app/repricing-profiles" class="ng-binding">Repricing Profiles</a> <img id="dimg_repricingprofiles" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="repricingprofiles" width="" height="" class="ng-hide"> <img id="uimg_repricingprofiles" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!repricingprofiles" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create your rules and preferences for re-pricing against your competitors. Set different strategies based on a variety of Amazon Marketplace situations.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] -->
                                          <li id="product-catalogue" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Configure']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="product-catalogue" data-name="Product Catalogue" href="https://showcase.247cloudhub.co.uk/#/app/product-catalogue" class="ng-binding">Product Catalogue</a> <img id="dimg_product-catalogue" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="product-catalogue" width="" height="" class="ng-hide"> <img id="uimg_product-catalogue" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!product-catalogue" width="" height="" class=""> </h3>
                                             <p class="ng-binding"></p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Configure'] --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="salesreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="salesreports" data-name="Sales" href="https://showcase.247cloudhub.co.uk/#/app/sales-reports" class="ng-binding">Sales</a> <img id="dimg_salesreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="salesreports" width="" height="" class="ng-hide"> <img id="uimg_salesreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!salesreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A series of sales reports to analyse data at an item, customer and marketplace level.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="vatreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="vatreports" data-name="VAT" href="https://showcase.247cloudhub.co.uk/#/app/vat-reports" class="ng-binding">VAT</a> <img id="dimg_vatreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="vatreports" width="" height="" class="ng-hide"> <img id="uimg_vatreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!vatreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">VAT report for sales across all marketplaces, consolidated into one easy to read exportable table.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="shippingcostreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="shippingcostreports" data-name="Shipping Costs" href="https://showcase.247cloudhub.co.uk/#/app/shipping-cost-reports" class="ng-binding">Shipping Costs</a> <img id="dimg_shippingcostreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="shippingcostreports" width="" height="" class="ng-hide"> <img id="uimg_shippingcostreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!shippingcostreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Check shipping costs from couriers against what is charged to your customers.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="returnsreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="returnsreports" data-name="Returns" href="https://showcase.247cloudhub.co.uk/#/app/returns-reports" class="ng-binding">Returns</a> <img id="dimg_returnsreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="returnsreports" width="" height="" class="ng-hide"> <img id="uimg_returnsreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!returnsreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">This captures all returns data and each return transaction's individual status.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="productsreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="productsreports" data-name="Products" href="https://showcase.247cloudhub.co.uk/#/app/products-reports" class="ng-binding">Products</a> <img id="dimg_productsreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="productsreports" width="" height="" class="ng-hide"> <img id="uimg_productsreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!productsreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Analyse the performance and status of individual products in your inventory. Drill into the detail to understand more.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="orderstagesreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="orderstagesreports" data-name="Order Stages" href="https://showcase.247cloudhub.co.uk/#/app/order-stages-reports" class="ng-binding">Order Stages</a> <img id="dimg_orderstagesreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="orderstagesreports" width="" height="" class="ng-hide"> <img id="uimg_orderstagesreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!orderstagesreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A status report outlining where each order is in its progression from being just arrived to dispatched and in the hands of your end customer.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="lateshipmentsreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="lateshipmentsreports" data-name="Late Shipments" href="https://showcase.247cloudhub.co.uk/#/app/lateshipments-reports" class="ng-binding">Late Shipments</a> <img id="dimg_lateshipmentsreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="lateshipmentsreports" width="" height="" class="ng-hide"> <img id="uimg_lateshipmentsreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!lateshipmentsreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Monitor your late shipments across all marketplaces ensuring your order defect rates remain low.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="inventorypagereports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="inventorypagereports" data-name="Inventory Age" href="https://showcase.247cloudhub.co.uk/#/app/inventorypage-reports" class="ng-binding">Inventory Age</a> <img id="dimg_inventorypagereports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="inventorypagereports" width="" height="" class="ng-hide"> <img id="uimg_inventorypagereports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!inventorypagereports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Use this report to help make decisions around optimising the sell through rate of your stock to hand. Make pricing decisions to clear and minimise stockholding items using this report.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="fastsellingproductsreports" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="fastsellingproductsreports" data-name="Fast Selling Products" href="https://showcase.247cloudhub.co.uk/#/app/fastsellingproducts-reports" class="ng-binding">Fast Selling Products</a> <img id="dimg_fastsellingproductsreports" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="fastsellingproductsreports" width="" height="" class="ng-hide"> <img id="uimg_fastsellingproductsreports" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!fastsellingproductsreports" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="reportnotificationsettings" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="reportnotificationsettings" data-name="Report Notifications" href="https://showcase.247cloudhub.co.uk/#/app/report-notification-settings" class="ng-binding">Report Notifications</a> <img id="dimg_reportnotificationsettings" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="reportnotificationsettings" width="" height="" class="ng-hide"> <img id="uimg_reportnotificationsettings" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!reportnotificationsettings" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Automate notifications and reports to be sent via email to selected users</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websitesales" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitesales" data-name="Website Sales" href="https://showcase.247cloudhub.co.uk/#/app/website-sales" class="ng-binding">Website Sales</a> <img id="dimg_websitesales" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitesales" width="" height="" class="ng-hide"> <img id="uimg_websitesales" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitesales" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websiteshoppingcart" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websiteshoppingcart" data-name="Website Shopping Cart" href="https://showcase.247cloudhub.co.uk/#/app/website-shopping-cart" class="ng-binding">Website Shopping Cart</a> <img id="dimg_websiteshoppingcart" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websiteshoppingcart" width="" height="" class="ng-hide"> <img id="uimg_websiteshoppingcart" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websiteshoppingcart" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websiteproducts" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websiteproducts" data-name="Website Products" href="https://showcase.247cloudhub.co.uk/#/app/website-products" class="ng-binding">Website Products</a> <img id="dimg_websiteproducts" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websiteproducts" width="" height="" class="ng-hide"> <img id="uimg_websiteproducts" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websiteproducts" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websitecustomers" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitecustomers" data-name="Website Customers" href="https://showcase.247cloudhub.co.uk/#/app/website-customers" class="ng-binding">Website Customers</a> <img id="dimg_websitecustomers" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitecustomers" width="" height="" class="ng-hide"> <img id="uimg_websitecustomers" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitecustomers" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websitereviews" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitereviews" data-name="Website Reviews" href="https://showcase.247cloudhub.co.uk/#/app/website-reviews" class="ng-binding">Website Reviews</a> <img id="dimg_websitereviews" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitereviews" width="" height="" class="ng-hide"> <img id="uimg_websitereviews" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitereviews" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websitesearchterms" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websitesearchterms" data-name="Website Search Terms" href="https://showcase.247cloudhub.co.uk/#/app/website-search-terms" class="ng-binding">Website Search Terms</a> <img id="dimg_websitesearchterms" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websitesearchterms" width="" height="" class="ng-hide"> <img id="uimg_websitesearchterms" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websitesearchterms" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] -->
                                          <li id="websiterefreshstatistics" class="serviceItems ng-scope ng-hide ui-draggable ui-draggable-handle" style="min-height: 140px" ng-repeat="pageDetails in appPagesList['Analyse']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="websiterefreshstatistics" data-name="Website Refresh Statistics" href="https://showcase.247cloudhub.co.uk/#/app/website-refresh-statistics" class="ng-binding">Website Refresh Statistics</a> <img id="dimg_websiterefreshstatistics" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="websiterefreshstatistics" width="" height="" class="ng-hide"> <img id="uimg_websiterefreshstatistics" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!websiterefreshstatistics" width="" height="" class=""> </h3>
                                             <p class="ng-binding">See your top selling items, ensure you forecast and plan when re-ordering from suppliers is needed.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Analyse'] --> 
                                       </ul>
                                    </div>
                                    <div class="col-sm-9 topnavscroll" style="display: none;">
                                       <ul class="droptrue">
                                          <span style="padding-top: 20px;padding-left: 15px;padding-bottom: 20px">To add a page to Quick Links shortcuts click on the Red Up Arrow.To Remove a Quick Link on the Red Down Arrow.</span> <br> <br> <!-- ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="suppliermanagement" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="suppliermanagement" data-name="Supplier Management" href="https://showcase.247cloudhub.co.uk/#/app/supplier-management" class="ng-binding">Supplier Management</a> <img id="dimg_suppliermanagement" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="suppliermanagement" width="" height="" class="ng-hide"> <img id="uimg_suppliermanagement" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!suppliermanagement" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Create and edit your supplier records, assigning them to specific products within your inventory.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="purchaseorders" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="purchaseorders" data-name="Purchase Orders" href="https://showcase.247cloudhub.co.uk/#/app/purchase-orders" class="ng-binding">Purchase Orders</a> <img id="dimg_purchaseorders" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="purchaseorders" width="" height="" class="ng-hide"> <img id="uimg_purchaseorders" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!purchaseorders" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Generate purchase orders with your suppliers to re-order the products you sell across the marketplaces.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="warehousestocklocations" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="warehousestocklocations" data-name="Warehouse and Stock Locations" href="https://showcase.247cloudhub.co.uk/#/app/warehouse-stock-locations" class="ng-binding">Warehouse and Stock Locations</a> <img id="dimg_warehousestocklocations" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="warehousestocklocations" width="" height="" class="ng-hide"> <img id="uimg_warehousestocklocations" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!warehousestocklocations" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Assign and manage the warehouse and shelf locations of items in your warehouse.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="goodsreceived" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="goodsreceived" data-name="Goods Received" href="https://showcase.247cloudhub.co.uk/#/app/goods-received" class="ng-binding">Goods Received</a> <img id="dimg_goodsreceived" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="goodsreceived" width="" height="" class="ng-hide"> <img id="uimg_goodsreceived" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!goodsreceived" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Check in stock received from purchase orders raised with your suppliers. Allocate the stock to list live on your marketplaces at the touch of a button.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="accountspayable" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="accountspayable" data-name="Accounts Payable" href="https://showcase.247cloudhub.co.uk/#/app/accounts-payable" class="ng-binding">Accounts Payable</a> <img id="dimg_accountspayable" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="accountspayable" width="" height="" class="ng-hide"> <img id="uimg_accountspayable" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!accountspayable" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Manage supplier accounts payable for stock purchased to resell on the marketplaces after raising a PO and receiving goods into stock.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="stockmovementlog" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="stockmovementlog" data-name="Stock Movement Log" href="https://showcase.247cloudhub.co.uk/#/app/stock-movement-log" class="ng-binding">Stock Movement Log</a> <img id="dimg_stockmovementlog" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="stockmovementlog" width="" height="" class="ng-hide"> <img id="uimg_stockmovementlog" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!stockmovementlog" width="" height="" class=""> </h3>
                                             <p class="ng-binding">Control and analyse stock inflows, outflows and general adjustments from this easy to use function.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] -->
                                          <li id="warehousegraphicaldashboard" class="serviceItems ng-scope ui-draggable ui-draggable-handle" style="min-height: 114px" ng-repeat="pageDetails in appPagesList['Locate']" ng-show="pageDetails.pageAccess=='true'">
                                             <h3 class="serviceItemshead"> <a data-id="warehousegraphicaldashboard" data-name="Warehouse Graphical Dashboard" href="https://showcase.247cloudhub.co.uk/#/app/warehouse-graphical-dashboard" class="ng-binding">Warehouse Graphical Dashboard</a> <img id="dimg_warehousegraphicaldashboard" src="./247 CloudHub _ Dashboard_files/down.10027e1b.jpg" ng-show="warehousegraphicaldashboard" width="" height="" class="ng-hide"> <img id="uimg_warehousegraphicaldashboard" src="./247 CloudHub _ Dashboard_files/side-arrow-hover.b20b5dbc.png" ng-show="!warehousegraphicaldashboard" width="" height="" class=""> </h3>
                                             <p class="ng-binding">A snapshot of all warehouse related activities, supplier management, item locations and stock levels.</p>
                                          </li>
                                          <!-- end ngRepeat: pageDetails in appPagesList['Locate'] --> 
                                       </ul>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </li>
                     </ul>
                     <div id="quicklinksmain" class="width-top-drag">
                        <div id="cart" class="top-draganddrop">
                           <ul id="horizontal1" class="quickLinkAdd ui-droppable">
                              <li>Quick Links : </li>
                              <li class="placeholder"></li>
                              <!-- ngRepeat: item in itemsArray --><!-- ngIf: itemsArray.length > 0 -->
                              <li ng-repeat="item in itemsArray" ng-if="itemsArray.length > 0" id="scanpackship" ng-class="scanpackship" class="ng-scope" style=""><a href="https://showcase.247cloudhub.co.uk/#/app/scan-pack-ship" rel="Scan, Pack and Ship" class="ng-binding">Scan, Pack and Ship </a></li>
                              <!-- end ngIf: itemsArray.length > 0 --><!-- end ngRepeat: item in itemsArray --><!-- ngIf: itemsArray.length > 0 -->
                              <li ng-repeat="item in itemsArray" ng-if="itemsArray.length > 0" id="manualtelephoneorder" ng-class="manualtelephoneorder" class="ng-scope"><a href="https://showcase.247cloudhub.co.uk/#/app/manual-telephone-order" rel="Manual / Telephone Order" class="ng-binding">Manual / Telephone Order </a></li>
                              <!-- end ngIf: itemsArray.length > 0 --><!-- end ngRepeat: item in itemsArray --><!-- ngIf: itemsArray.length > 0 -->
                              <li ng-repeat="item in itemsArray" ng-if="itemsArray.length > 0" id="optimiseprofiles" ng-class="optimiseprofiles" class="ng-scope"><a href="https://showcase.247cloudhub.co.uk/#/app/optimise-profiles" rel="Optimise Profiles" class="ng-binding">Optimise Profiles </a></li>
                              <!-- end ngIf: itemsArray.length > 0 --><!-- end ngRepeat: item in itemsArray --> 
                           </ul>
                        </div>
                        <div style="text-align:right" ng-show="extraQuicklink==1 &amp;&amp; divArray.length>0" class="arrow-top-image ng-hide">
                           <a href="javascript:void(0);" ng-click="showExtraList()" style="color:white"><img src="./247 CloudHub _ Dashboard_files/arrow.d9a9cb86.jpg" style="margin-top: -5px"></a> 
                           <ul id="showExtraLis" style="display:none">
                              <!-- ngRepeat: lis in divArray --> 
                           </ul>
                        </div>
                     </div>
                     <ul class="nav navbar-nav navbar-right" style="margin-right: 20px">
                        <li class="dropdown dropdown-list">
                           <a href="javascript:void(0);" dropdown-animate="" class="dropdown-toggle">
                              <em>
                                  <img src="./247 CloudHub _ Dashboard_files/10.jpg" width="31" height="31">
                              </em>
                           </a>
                           <ul class="dropdown-menu dropdown-menu-user">
                              <li>
                                 <div class="list-group">
                                    <!-- ngIf: allVendorDb.length>0 -->
                                    <a ng-if="allVendorDb.length>0" href="javascript:void(0);" ng-controller="DialogMainCtrl" ng-click="openCustomPopup('swiftVendordetails.html')" class="list-group-item ng-scope" style="">
                                       <div class="media">
                                          <div class="pull-left"> <em class="fa fa-exchange" style="font-size: 30px; color:#23c5e2"></em>  </div>
                                          <div class="media-body clearfix">
                                             <p class="m0 workflow-padding-7" style="padding-top:5px">Switch VendorDB</p>
                                          </div>
                                       </div>
                                    </a>
                                    <!-- end ngIf: allVendorDb.length>0 --> 
                                    <a href="javascript:void(0);" ng-click="decryptIds(usercode)" class="list-group-item">
                                       <div class="media">
                                          <div class="pull-left"> <em class="fa fa-edit" style="font-size: 30px; color:#23c5e2"></em>  </div>
                                          <div class="media-body clearfix">
                                             <p class="m0 workflow-padding-7" style="padding-top:5px">Edit Account Profile</p>
                                          </div>
                                       </div>
                                    </a>
                                    <a href="https://showcase.247cloudhub.co.uk/#/app/change-password" class="list-group-item">
                                       <div class="media">
                                          <div class="pull-left"> <em class="icon-lock-open" style="font-size: 30px; color:#0274bd"></em>  </div>
                                          <div class="media-body clearfix">
                                             <p class="m0 workflow-padding-7">Change Password</p>
                                          </div>
                                       </div>
                                    </a>
                                    <a href="https://showcase.247cloudhub.co.uk/#" class="list-group-item" style="display: none">
                                       <div class="media">
                                          <div class="pull-left"> <em class="fa fa-tasks fa-2x text-success"></em> </div>
                                          <div class="media-body clearfix workflow-padding-8">
                                             <p class="m0">Pending Tasks</p>
                                             <p class="m0 text-muted"> <small>11 pending task</small> </p>
                                          </div>
                                       </div>
                                    </a>
                                    <a href="https://showcase.247cloudhub.co.uk/#/logout" class="list-group-item"> <span>Sign Out</span> <span class="label pull-right"><em class="fa fa-power-off fa-2x text-poweroff"></em></span> </a> 
                                 </div>
                              </li>
                           </ul>
                        </li>
                        <li> <a href="https://showcase.247cloudhub.co.uk/#/lock" title="Lock screen" class="em-font-topnav"> <em class="icon-lock"></em>  </a> </li>
                        <li class="visible-lg"> <a href="https://showcase.247cloudhub.co.uk/#" toggle-fullscreen="toggle-fullscreen" class="em-font-topnav"> <em class="fa fa-expand"></em>  </a> </li>
                        <li class="side-open-top"> <a href="https://showcase.247cloudhub.co.uk/#" toggle-state="offsidebar-open" no-persist="no-persist" style="margin-left:10px" class="em-font-topnav"> <em class="icon-notebook"></em>  </a> </li>
                     </ul>
                  </div>
               </nav>
               <script async="" src="//www.google-analytics.com/analytics.js"></script><script async="" src="./247 CloudHub _ Dashboard_files/analytics.js.download"></script><script type="text/javascript" class="ng-scope">$(function () {
                  var $items = $('#vtab>ul>li');
                  $items.mouseover(function () {
                      $items.removeClass('selected');
                      $(this).addClass('selected');
                  
                      var index = $items.index($(this));
                      $('#vtab>div').hide().eq(index).show();
                  }).eq(1).mouseover();
                  });
               </script>
      </header> 
      <!-- Content Starts -->  
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <ul class="list-inline">
                    <li>
                        <div ng-show="rshow" class="" style="">
                            <form role="form" class="form-inline ng-pristine ng-valid" ng-submit="getOrdersBySearch()">
                                <div class="form-group text-left mar-top-5 mar-right-5">
                                    <ul class="list-inline">
                                        <li class="mar-right-5">
                                            <label>Search</label>
                                                <input type="text" placeholder="Search" ng-model="filterorders.searchText" class="form-control srch-filed ng-pristine ng-untouched ng-valid">
                                        </li>
                                        <li><a href="#" id="aSearchOrder" ng-click="getOrdersBySearch()"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>
                                        <li><a href="#" ng-click="clearSearchFields()">Clear Search</a></li>
                                        <li> <span class="srchStage"> <label class="chkbox mar-right-5"> </label>&nbsp;eBay Account ID:  </span> </li>
                                        <li> <span class="srchStage"> <label class="chkbox mar-right-5"></label>&nbsp;<strong>32546687</strong> </span> </li>
                                    </ul>
                                </div>
                            </form>     
                        </div>
                    </li>
                    <li>
                        <div ng-show="!rshow" style="margin-left: -15px;" class="ng-hide"> 
                            <form role="form" class="form-inline ng-pristine ng-valid" ng-submit="getOrdersBySearch()">
                                <div class="form-group text-left mar-right-5">
                                    <ul class="list-inline">
                                        <li class="mar-right-5">
                                            <label>Order Search</label>
                                        </li>
                                        <li>
                                            <input type="text" placeholder="Search" ng-model="filterorders.searchText" class="form-control srch-filed ng-pristine ng-untouched ng-valid">
                                        </li>
                                        <li><a href="#" id="aSearchOrder" ng-click="getOrdersBySearch()"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>
                                        <li><a href="#" ng-click="clearSearchFields()">Clear Search</a></li>
                                        <li> <span class="srchStage"> <label class="chkbox mar-right-5"> <input type="checkbox" ng-model="pSearchByStage" id="pSearchByStage" name="pSearchByStage" class="ng-pristine ng-untouched ng-valid"> </label>&nbsp;Search in all Order Stages </span> </li>
                                        <li> <span class="srchStage"> <label class="chkbox mar-right-5"> <input type="checkbox" ng-model="isPrime" id="isPrime" name="isPrime" ng-change="ShowPrimeOrders()" class="ng-pristine ng-untouched ng-valid"> </label>&nbsp;Prime Orders </span> </li>
                                        <li>
                                            <a href="#" class="mar-right-5" ng-click="openCustomSettings()" placeholder="Columns Settings"><img src="images/settings-icon.682ad8cc.png"></a>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div> 
            <div class="col-sm-6 col-md-6">
                <ul class="list-inline">
                    <li><button class="btn btn-primary">Download Report</button></li>
                    <li><span>Ebay Account ID <strong>1212121212</strong></span></li>
                    <li><button class="btn btn-primary">Submit Multi-buy Discount</button></li>
                </ul>                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive table-bordered scroll-table traffic-table">
<?php
require_once("../db-config.php");
require_once("../ebay_api_end_points.php");
require_once("../curl.php");

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
$limit = 500;
$sorting = '';
$sorting_col = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sort_col']) && $_GET['sort_col'] != '') {
	$sorting_col = $_GET['sort_col'];
}

if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
	if(!empty($res)){
		echo $res;		
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response<br/>";exit;
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				$random_number = strtotime("now");
				
				$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id) values ('".$random_number."','headers','".$seller_ebay_id."')";
				mysqli_query($conn,$sql);
				if(isset($response['listingViolations'])){
					$listingViolations = $response['listingViolations'];
					foreach($listingViolations as $k=>$v){
						$listing_id = '';
						$compliance_type = '';
						$reason_code = '';
						$missing_value = '';
						if(isset($v['listingId'])){
							$listing_id = $v['listingId'];
						}
						if(isset($v['complianceType'])){
							$compliance_type = $v['complianceType'];
						}
						if(isset($v['violations'])){
							foreach($v['violations'] as $viok=>$viov){
								if(isset($viov['reasonCode'])){
									$reason_code = $viov['reasonCode'];
								}
								$violation_data = $viov['violationData'];
								foreach($violation_data as $vdk=>$vdv){
									if(!empty($listing_id)){
										//echo $listing_id.'-->'.$vdk;echo "<br/>";
										$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id,ebay_item_id,reason_code,aspect_name) values
											('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$reason_code."','".addslashes($vdv['value'])."')";
										mysqli_query($conn,$sql);
									}
								}
								if(isset($viov['correctiveRecommendations']['aspectRecommendations'])){
									$violation_recomm = $viov['correctiveRecommendations']['aspectRecommendations'];
									foreach($violation_recomm as $vrk=>$vrv){
										$sql1 = "select * from ebay_aspect_adoption_report where random_number='".$random_number."' and aspect_name='".addslashes($vrv['localizedAspectName'])."' and ebay_item_id='".$listing_id."'";
										$res_val = mysqli_query($conn,$sql1);
										if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
											$data = $res_val->fetch_assoc();
											$sql_u = "update ebay_aspect_adoption_report set aspect_value_corrective='".addslashes($vrv['suggestedValues'][0])."' where id=".$data['id'];
											mysqli_query($conn,$sql_u);
										}
									}
								}
							}
						}
					}
					
				}
				$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col);
				if(!empty($res)){
					echo $res;
				}
				else{
					echo "Error Response<br/><br/>";exit;
				}
			}else{
				echo "Error Response<br/><br/>";exit;
			}
		}
	}
}

function get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col){
	$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";
	$max_value_missing = 1;
	$max_value = 1;
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		//$response['header'] = json_decode($headers['response'],true);
		$orderby = '';
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_count_missing = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NULL GROUP BY ebay_item_id ) AS counts";
		$res_count_missing = mysqli_query($conn,$sql_count_missing);
		if(!empty($res_count_missing) && mysqli_num_rows($res_count_missing) > 0){
			$count_missing = $res_count_missing->fetch_assoc();
			$max_value_missing = $count_missing['max_value'];
		}
		$sql_count = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NOT NULL GROUP BY ebay_item_id ) AS counts";
		$res_count = mysqli_query($conn,$sql_count);
		if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
			$count = $res_count->fetch_assoc();
			$max_value = $count['max_value'];
		}
		
		$response .= '<table id="aspect_adoptions" class="dataTable no-footer table table-bordered table-striped" role="grid" aria-describedby="aspect_adoptions_info">';
		$response .= '<thead>';
		$response .= '<tr role="row" class="suceess">';
		$response .= '<th class="sorting_asc"><input type="checkbox" id="ckbCheckAll" /></th>';
		$response .= '<th>Item Id</th>';
		$response .= '<th>Product Title</th>';
		//$response .= '<th>Reason Code</th>';
		for($i=0;$i<$max_value;$i++){
			$response .= '<th>eBay Recommended Aspect Name</th>';
			$response .= '<th>eBay Recommended Aspect Value</th>';
		}
		for($i=0;$i<$max_value_missing;$i++){
			$response .= '<th>Missing Aspect Name</th>';
			$response .= '<th>Missing Aspect Value</th>';
		}
		$response .= '</tr>';
		$response .= '</thead>';
		$response .= '<tbody>';
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' group by ebay_item_id";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		$even_odd = 1;
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				$count_check_missing = 0;
				$count_check = 0;
				if(($even_odd%2) == 0){
					$even = "even";
				}else{
					$even = "odd";
				}
				$even++;
				$response .= '<tr role="row" class="'.$even.'">';
				$response .= "<td><input type='checkbox' id='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				$response .= "<td>".$values['ebay_item_id']."</td>";
				$response .= "<td>".$values['product_name']."</td>";
				$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
				$res_inner_val = mysqli_query($conn,$sql_inner_val);
				if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
					$missing_aspect_name = "";
					$ebay_aspect_name = "";
					while($values_inner = $res_inner_val->fetch_assoc()){
						if(!empty($values_inner['aspect_value_corrective'])){
							$ebay_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$ebay_aspect_name .= "<td><select id='select-aspect' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$ebay_aspect_name .= "<option value='".$avv."' ".$selected." >".$avv."</option>";
									}
									$ebay_aspect_name .= "</select></td>";
								}else{
									$ebay_aspect_name .= "<td><select id='select-aspect' ><option value='".$values_inner['aspect_value_corrective']."' >".$values_inner['aspect_value_corrective']."</option></select></td>";
								}
							}else{
								$ebay_aspect_name .= "<td><select id='select-aspect' ><option value='".$values_inner['aspect_value_corrective']."' >".$values_inner['aspect_value_corrective']."</option></select></td>";
							}
							
							$count_check++;
						}else{
							$missing_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$missing_aspect_name .= "<td><select id='select-aspect' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$missing_aspect_name .= "<option value='".$avv."' ".$selected." >".$avv."</option>";
									}
									$missing_aspect_name .= "</select></td>";
								}else{
									$missing_aspect_name .= "<td><select id='select-aspect' ><option value='".$values_inner['aspect_value_corrective']."' >".$values_inner['aspect_value_corrective']."</option></select></td>";
								}
							}else{
								$missing_aspect_name .= "<td><select id='select-aspect' ><option value='".$values_inner['aspect_value_corrective']."' >".$values_inner['aspect_value_corrective']."</option></select></td>";
							}
							$count_check_missing++;
						}
						
					}
					for($k=0;$k<($max_value_missing-$count_check_missing);$k++){
						$missing_aspect_name .= "<td>&nbsp;</td>";
						$missing_aspect_name .= "<td>&nbsp;</td>";
					}
					for($j=0;$j<($max_value-$count_check);$j++){
						$ebay_aspect_name .= "<td>&nbsp;</td>";
						$ebay_aspect_name .= "<td>&nbsp;</td>";
					}
					
					$response .= $ebay_aspect_name.$missing_aspect_name;
				}
				$response .= "</tr>";
			}
		}else{
			return array();
		}
		
		$response .= '</tbody>';
		$response .= '</table>';
		return $response;
	}else{
		return array();
	}
}


?> 
                </div>              
            </div>
        </div>
    </div>
    <!-- Content Ends --> 
    <footer style="background-color: #1f1f1f" ng-include="'views/partials/footer.html'" class="ng-scope">
              <div class="row login-footer ng-scope">
                <div class="col-md-3 text-left ng-scope" ng-controller="DialogMainCtrl"> <span class="pad-left-20">Contact:&nbsp;<a ng-click="openCustomPopup('customerSupport.html')" href="https://showcase.247cloudhub.co.uk/#">support@247cloudhub.co.uk</a></span> </div>
                <div class="col-md-6 text-center"> <span>©</span> <span ng-bind="app.year" class="ng-binding">2011 - 2019 247 Commerce Limited.</span> <span ng-bind="app.description" class="ng-binding">All Rights Reserved.</span> <span> 247 Cloudhub is a registered trademark of <a href="http://www.247commerce.co.uk/" tabindex="9" target="_blank">247Commerce.</a> <a href="https://showcase.247cloudhub.co.uk/#/app/privacy-policy" tabindex="10" style="margin-left:10px" target="_blank">Privacy Policy</a><a href="https://showcase.247cloudhub.co.uk/#/app/terms-of-use" tabindex="11" style="margin-left:10px" target="_blank">Terms of Use</a></span>  </div>
                <div class="col-md-3 text-right"> <span class="pad-right-20 ng-binding">Licensed to: 247 Commerce Ltd</span> </div>
              </div>
              <script class="ng-scope">(function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function ()
                { (i[r].q = i[r].q || []).push(arguments) }
                
                , i[r].l = 1 * new Date(); a = s.createElement(o),
                m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
                
                ga('create', 'UA-69432614-1', 'auto');
                //ga('send', 'pageview');
              </script>
          </footer>      
   </body>
</html>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>
<script>
$(document).ready(function(){
  $('select').selectize({create:true,allowEmptyOption: false,closeAfterSelect:true});
  $("#ckbCheckAll").click(function(){
	  $('input:checkbox').not(this).prop('checked', this.checked);
  });
  $('#aspect_adoptions').DataTable();
});
</script>