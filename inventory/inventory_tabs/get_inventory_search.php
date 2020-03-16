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
	<div class="">
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
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a> 
		</div>
	</div>
<?php }else if($marketplacecode == 2){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Amazon Accounts</label> 
			<select name="amzaccount" id="amzaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 1){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">eBay Accounts</label> 
			<select name="eBayaccount" id="eBayaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 101){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Game Accounts</label> 
			<select name="gameaccount" id="gameaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 9){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">CDiscount Accounts</label> 
			<select name="cdiscountaccount" id="cdiscountaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 3){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Webstore Accounts</label> 
			<select name="webstoreaccount" id="webstoreaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 21){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">SKUCloud Accounts</label> 
			<select name="skucloudaccount" id="skucloudaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 20){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">ONBuy Accounts</label> 
			<select name="onbuyaccount" id="onbuyaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 16){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Amazon Accounts</label> 
			<select name="amzaccount" id="amzaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 7){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Rakuten  Accounts</label> 
			<select name="rakutenaccount" id="rakutenaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 13){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Abebooks Accounts</label> 
			<select name="abebooksaccount" id="abebooksaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 15){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Shopify Accounts</label> 
			<select name="shopifyaccount" id="shopifyaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 22){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Fruugo Accounts</label> 
			<select name="frugoaccount" id="frugoaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label>
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
<?php }else if($marketplacecode == 8){ ?>
	<div class=" mar-top-0 ">
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Filter Profile</label> 
			<select name="account" id="searchProfileCode" class="form-control">
				<option value="" class="" selected="selected">Select</option>
			</select>
			<p class="pad-bottom-0 mar-bottom-0"> <a href="#" style="font-size: 12px; margin: 5px 0 0 5px">Create / Delete Filter</a> </p>
			<p class="pad-bottom-0 mar-bottom-0">
				<!-- ngIf: cmnInvetory.profileCode!='0' --> 
			</p>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Search For</label> 
			<div class="input-group">
				<input id="txtSearch" type="text" placeholder="" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" id="aSearch" type="button" >
						<em class="fa fa-search"></em>
					</button>
				</span>
			</div>
			<a href="#">Clear Search</a>
	   </div>
	</div>
	<div class="mar-top-0 ">
	   <div class="col-lg-6 form-group">
			<label class="font-normal mar-top-5">Trademe Accounts</label> 
			<select name="trademeaccount" id="trademeaccount" class="form-control" style="">
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	   <div class="col-lg-6 form-group">
		  <label class="font-normal mar-top-5">Select Search Flag Filter</label> 
			<select name="account" id="searchFlagCode" class="form-control" >
				<option value="" class="" selected="selected">Select</option>
			</select>
	   </div>
	</div>
<?php }else if($marketplacecode == 18){ ?>
	<div class="mar-top-0">
		<div class="form-group">
			<div class="col-sm-12 mar-top-15">
				<div class="row col-lg-6">
					<label class="col-md-3 control-label">Folder Name</label> 
					<div class="col-md-7">
						<select name="inventory_img_account" class="form-control" style=""></select>
					</div>
					<div class="col-md-2 pad-left-0 media-mar-top-10">
						<input type="button" value="Go" class="btn btn-theme media-mar-left-15">
					</div>
				</div>
			</div>
			<div class="col-sm-12 mar-top-15">
				<div class="row col-lg-6">
					<label class="col-md-3 control-label">Search For</label> 
					<div class="col-md-7">
						<input type="text" id="txtimgSearch" placeholder="Enter Image name or SKU" class="form-control col-md-6" style="">
					</div>
					<div class="col-md-2 pad-left-0 media-mar-top-10">
						<input type="button" value="Go" class="btn btn-theme media-mar-left-15">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 market-tabs" id="picksheet-tabs">
        <div class="panel-body" id="product-category-pop">
            <div type="pills" class="ng-isolate-scope">
				<ul class="nav nav-pills">
					<li heading="Folderwise Images" class="media-martab-left-0 media-mar-left-0 active">
						<a href="">Folderwise Images</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="mar-bottom-30 ng-scope">
							<p class="pad-10 mar-left-30"> <strong class="ng-binding">1 images found</strong> </p>
							<div class="row col-lg-12">
								<div class="imgtotalCount pull-right">
                                    <ul class="pagination">
										<li title="Page 1" class="active" style=""> <a href="" data-ng-class="Item.aClass">1</a> </li>
                                    </ul>
                                </div>
							</div>
						</div>
                        <div class="row mar-top-30 drop-and-drag-image">
							<!-- loop repaeat -->
							<div>
								<div class="col-md-3 text-center">
									<img ng-src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v1.jpg" id="img_0" src="https://s3-eu-west-1.amazonaws.com/clientfileuploads/prod_image/77/bundle/5036905442442v1.jpg">
									<button type="button"  class="btn btn-danger btn-xs invimg_btn" style="vertical-align:top">
										<span class="fa fa-trash fa-lg"></span>
									</button>
									<button type="button" class="btn btn-xs invimg_btn" style="margin-top: 39px">
										<span class="fa fa-edit fa-lg"></span>
									</button>
									<p class="mar-top-5 invimg_p"> <strong class="ng-binding">5036905442442v1.jpg </strong> </p>
								</div>
							</div>
                        </div>
						<div class="row col-lg-12">
							<div class="imgtotalCount pull-right">
                                <ul class="pagination">
									<li title="Page 1" class="active" style=""> <a href="" data-ng-class="Item.aClass">1</a> </li>
                                </ul>
                            </div>
						</div>
					</div>
                </div>
              </div>
            </div>
        </div>
    </div>
<?php } ?>
