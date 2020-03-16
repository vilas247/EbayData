<?php
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
include("../common/header.php");
?>
<!-- Content Starts -->  
	<div class="portlets-wrapper traditional" style="margin-top:55px;min-height:1300px">
		<div class="container-fluid" style="min-height: 0;">
			<div class="row">
				<div class="singleNav" style="padding-bottom:7px;">
					<p>
						<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
						<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
						Inventory 
					</p>
				</div>
			</div>
			<div class="row mar-top-10">
				<div class="row col-md-8">
					<label class="col-md-2 font-normal mar-top-5">
						<p class="fBold">eBay Seller ID:</p>
					</label>
					<div class="col-md-4">
						<select id="ddlebayaccount" name="ebayaccount" class="form-control ng-pristine ng-valid ng-touched" ng-model="ebayAccountName" ng-change="searchByAccount(ebayAccountName)" ng-options="ebayAccount.ebayaccountcode as ebayAccount.ebayaccountname for ebayAccount in ebayAccounts.ebayaccounts" style="">
							<option value="" class="" selected="selected">Select</option>
							<option label="eBay - eBay UK" value="string:1" selected="selected">eBay - eBay UK</option>
						</select>
					</div>
				</div>
				<div class="row"><br></div>
				<div class="row service_list ebaydash">
					<div class="col-sm-12">
						<div id="panelPortlet6" class="panel panel-primary panel-dashboard" style="margin-top: 0px">
							<div uib-collapse="panelPortlet2" id="panelPortletContent6" class="panel-wrapper in-collapsed-6 in collapse" aria-expanded="true" aria-hidden="false" style="height: auto;">
							<div class="panel-body" id="first_seller">
							  
							</div>
						</div>
					 </div>
				  </div>
			   </div>
			   <div class="col-sm-12 ebaytable-new">
				  <div id="panelPortlet6" class="panel panel-primary panel-dashboard" style="margin-top: 0px">
					 <div class="panel-heading portlet-handler" style="padding: 10px 0 10px 15px;background: #0273be !important;
						color: #fff !important"> Seller Level </div>
					 <div uib-collapse="panelPortlet2" id="panelPortletContent6" class="panel-wrapper in-collapsed-6 in collapse" aria-expanded="true" aria-hidden="false" style="height: auto;">
						<div class="panel-body">
						   <div class="table-responsive">
							  <table class="table table-bordered">
								 <thead>
									<tr class="text-right">
									   <th>&nbsp;</th>
									   <th>Region: UK, Ireland</th>
									   <th>Region: Germany, Austrial, Switzerland</th>
									   <th>Region: Global</th>
									   <th>Region: USA</th>
									</tr>
								 </thead>
								 <tbody>
									<tr>
									   <td>
										  <h5>Current Seller level</h5>
										  <small class="ng-binding">As of 21 December 2019</small>
									   </td>
									   <td>
										  <h3 class="txt-green ng-binding">TOP RATED</h3>
									   </td>
									   <td class="ng-binding">ABOVE STANDARD</td>
									   <td class="ng-binding">ABOVE STANDARD</td>
									   <td class="ng-binding">ABOVE STANDARD</td>
									</tr>
									<tr>
									   <td>
										  <h5>If we evaluated you today</h5>
										  <small class="ng-binding">Next evaluation on 21 January 2020</small>
									   </td>
									   <td>
										  <h3 class="txt-green ng-binding"><span>Your seller level would be</span>eBay ABOVE STANDARD Seller</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span>Your seller level would be</span>ABOVE STANDARD</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span>Your seller level would be</span>ABOVE STANDARD</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span>Your seller level would be</span>ABOVE STANDARD</h3>
									   </td>
									</tr>
									<tr>
									   <td>
										  <h5>Transaction defect rate</h5>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">4 of 10558 transactions</span>0.04%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 4 transactions</span>0.00%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 85 transactions</span>0.00%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 7 transactions</span>0.00%</h3>
									   </td>
									</tr>
									<tr>
									   <td>
										  <h5>Late Delivery rate</h5>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">105 of 2722 transactions</span>3.86%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 3 transactions</span>0.00%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 33 transactions</span>0.00%</h3>
									   </td>
									   <td>
										  <h3 class="ng-binding"><span class="ng-binding">0 of 1 transactions</span>0.00%</h3>
									   </td>
									</tr>
									<tr>
									   <td>
										  <h5>Cases closed without seller resolution</h5>
									   </td>
									   <td>
										  <h3 class="ng-binding">0.04%<span class="ng-binding">4 of 10558 transactions</span></h3>
									   </td>
									   <td>
										  <h3 class="ng-binding">0.00%<span class="ng-binding">0 of 4 transactions</span></h3>
									   </td>
									   <td>
										  <h3 class="ng-binding">0.00%<span class="ng-binding">0 of 85 transactions</span></h3>
									   </td>
									   <td>
										  <h3 class="ng-binding">0.00%<span class="ng-binding">0 of 7 transactions</span></h3>
									   </td>
									</tr>
									<tr>
									   <td>
										  <h5>Transactions and sales</h5>
									   </td>
									   <td>
										  <!-- ngIf: SellerUKLevelRange.TransactionsSalevalue!='' -->
										  <h3 ng-if="SellerUKLevelRange.TransactionsSalevalue!=''" class="ng-binding ng-scope" style="">27499<span>transactions</span></h3>
										  <!-- end ngIf: SellerUKLevelRange.TransactionsSalevalue!='' -->
										  <div class="gap-20"></div>
										  <!-- ngIf: SellerUKLevelRange.GMVSalesAmount!='' -->
										  <h3 ng-if="SellerUKLevelRange.GMVSalesAmount!=''" class="ng-binding ng-scope">£223922.40<span>sales</span></h3>
										  <!-- end ngIf: SellerUKLevelRange.GMVSalesAmount!='' -->
									   </td>
									   <td>
										  <!-- ngIf: SellerDELevelRange.TransactionsSalevalue!='' -->
										  <h3 ng-if="SellerDELevelRange.TransactionsSalevalue!=''" class="ng-binding ng-scope" style="">4<span>transactions</span></h3>
										  <!-- end ngIf: SellerDELevelRange.TransactionsSalevalue!='' -->
										  <div class="gap-20"></div>
										  <!-- ngIf: SellerDELevelRange.GMVSalesAmount!='' -->
										  <h3 ng-if="SellerDELevelRange.GMVSalesAmount!=''" class="ng-binding ng-scope">€124.44<span>sales</span></h3>
										  <!-- end ngIf: SellerDELevelRange.GMVSalesAmount!='' -->
									   </td>
									   <td>
										  <!-- ngIf: SellerGOLevelRange.TransactionsSalevalue!='' -->
										  <h3 ng-if="SellerGOLevelRange.TransactionsSalevalue!=''" class="ng-binding ng-scope" style="">85<span>transactions</span></h3>
										  <!-- end ngIf: SellerGOLevelRange.TransactionsSalevalue!='' -->
										  <div class="gap-20"></div>
										  <!-- ngIf: SellerGOLevelRange.GMVSalesAmount!='' -->
									   </td>
									   <td>
										  <!-- ngIf: SellerUSLevelRange.TransactionsSalevalue!='' -->
										  <h3 ng-if="SellerUSLevelRange.TransactionsSalevalue!=''" class="ng-binding ng-scope" style="">7<span>transactions</span></h3>
										  <!-- end ngIf: SellerUSLevelRange.TransactionsSalevalue!='' -->
										  <div class="gap-20"></div>
										  <!-- ngIf: SellerUSLevelRange.GMVSalesAmount!='' -->
										  <h3 ng-if="SellerUSLevelRange.GMVSalesAmount!=''" class="ng-binding ng-scope">$280.63<span>sales</span></h3>
										  <!-- end ngIf: SellerUSLevelRange.GMVSalesAmount!='' -->
									   </td>
									</tr>
								 </tbody>
							  </table>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			   <div class="col-sm-12 ebaytable">
				  <div id="panelPortlet6" class="panel panel-primary panel-dashboard" style="margin-top: 0px">
					 <div class="panel-heading portlet-handler" style="padding: 10px 0 10px 15px"> Catalogue Improvement Areas </div>
					 <div uib-collapse="panelPortlet2" id="panelPortletContent6" class="panel-wrapper in-collapsed-6 in collapse" aria-expanded="true" aria-hidden="false" style="height: auto;">
						<div class="panel-body">
						   <div class="table-responsive">
							  <table class="table table-striped">
								 <thead>
									<tr>
									   <th scope="col">Area</th>
									   <th scope="col">Count</th>
									</tr>
								 </thead>
								 <tbody>
									<tr>
									   <td><strong>eBay Top Rated Seller</strong> listing requirement and recommendations</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.eTRS == 0 --> <!-- ngIf: CatalogueImprovement.eTRS != 0 --><span ng-if="CatalogueImprovement.eTRS != 0" class="ng-scope" style=""> <a href="#" class="eTRS ng-binding" style="cursor:pointer" ng-click="ShowItemID('eTRS')"> 7638 </a> listings with recommendations </span><!-- end ngIf: CatalogueImprovement.eTRS != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>ItemSpecifics</strong> recommendations for the catalogue</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.ItemSpecifics == 0 --><span ng-if="CatalogueImprovement.ItemSpecifics == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations!</span><br> Your catalogue is already optimised as per eBay Standards.</span><!-- end ngIf: CatalogueImprovement.ItemSpecifics == 0 --> <!-- ngIf: CatalogueImprovement.ItemSpecifics != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>ProductIdentifier</strong> this recommendation type advises the seller that the listing is missing the product identifier, such as Brand/MPN, UPC, ISBN or EAN.</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.ProductIdentifier == 0 --><span ng-if="CatalogueImprovement.ProductIdentifier == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations!</span><br> Your catalogue is already optimised as per eBay Standards.</span><!-- end ngIf: CatalogueImprovement.ProductIdentifier == 0 --> <!-- ngIf: CatalogueImprovement.ProductIdentifier != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>Picture </strong> this recommendation type advises the seller that a specific picture in the listing is not meeting a specific picture quality requirement.</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.Picture == 0 --> <!-- ngIf: CatalogueImprovement.Picture != 0 --><span ng-if="CatalogueImprovement.Picture != 0" class="ng-scope" style=""> <a href="#" class="eTRS ng-binding" style="cursor:pointer" ng-click="ShowItemID('Picture')"> 6520 </a> listings with picture enhancement recommendations. </span><!-- end ngIf: CatalogueImprovement.Picture != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>Price</strong> this recommendation type provides a recommended price and/or a recommended price range for auction and fixed-price listings. These price recommendation values are based on similar items that have recently sold on eBay. Along with pricing recommendations, a recommended listing format (auction vs. fixed-price) is also returned. This recommendation type is only supported on the US, UK, and DE sites.</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.Price == 0 --><span ng-if="CatalogueImprovement.Price == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations!</span><br> Your catalogue is already optimised as per eBay Standards.</span><!-- end ngIf: CatalogueImprovement.Price == 0 --> <!-- ngIf: CatalogueImprovement.Price != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>Title</strong> this recommendation type provides guidance on forming an effective listing title. The Listing Recommendation API will suggest that the listing title is missing valuable keywords, missing recommended Item Specifics, or has keywords that should not be there since it misrepresents the item. The keywords or Item Specifics are called out in the response. This recommendation type is only supported on the US, UK, DE, and AU sites.</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.Title == 0 --><span ng-if="CatalogueImprovement.Title == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations!</span><br> Your catalogue is already optimised as per eBay Standards.</span><!-- end ngIf: CatalogueImprovement.Title == 0 --> <!-- ngIf: CatalogueImprovement.Title != 0 --> 
									   </td>
									</tr>
									<tr>
									   <td><strong>FnF</strong> this recommendation type advises the seller to offer expedited shipping for the item (same-day shipping or a handling time of 1 day) and/or offer at least one free shipping service option.</td>
									   <td>
										  <!-- ngIf: CatalogueImprovement.FnF == 0 --> <!-- ngIf: CatalogueImprovement.FnF != 0 --><span ng-if="CatalogueImprovement.FnF != 0" class="ng-scope" style=""> <a href="#" class="eTRS ng-binding" style="cursor:pointer" ng-click="ShowItemID('FnF')"> 7611 </a> with recommendations that can help earn the badge for Fast and Free on listings. </span><!-- end ngIf: CatalogueImprovement.FnF != 0 --> 
									   </td>
									</tr>
								 </tbody>
							  </table>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			   <div class="col-sm-12 ebaytable">
				  <div id="panelPortlet6" class="panel panel-primary panel-dashboard" style="margin-top: 0px">
					 <div class="panel-heading portlet-handler" style="padding: 10px 0 10px 15px"> Violations </div>
					 <div uib-collapse="panelPortlet2" id="panelPortletContent6" class="panel-wrapper in-collapsed-6 in collapse" aria-expanded="true" aria-hidden="false" style="height: auto;">
						<div class="panel-body">
						   <div class="table-responsive">
							  <table class="table table-striped">
								 <thead>
									<tr>
									   <th scope="col">HTTPS</th>
									   <th scope="col">OUTSIDE EBAY BUYING AND SELLING</th>
									   <th scope="col">RETURNS POLICY</th>
									   <th scope="col">ASPECTS ADOPTION</th>
									</tr>
								 </thead>
								 <tbody>
									<tr>
									   <td> For each of these violations, the seller will just need to remove the HTTP link (or update to HTTPS) from the listing details or product details.   </td>
									   <td> For each of these violations, the seller will just need to remove unapproved domain weblinks, phone numbers and email ID reference from listing this information and revise the listing.  </td>
									   <td> The seller will have to revise listing (or return business policy) with a supported return period for the eBay country site and category.  </td>
									   <td> For each category, eBay maintains list of required and recommended aspects. When checking Aspects Adoption, eBay include listings for which either a required or recommended aspect is missing or has an invalid value.  </td>
									</tr>
									<tr>
									   <td>
										  <!-- ngIf: getListingViolations.HTTPSCnt == 0 --> <!-- ngIf: getListingViolations.HTTPSCnt != 0 --><span ng-if="getListingViolations.HTTPSCnt != 0" class="ng-scope">  <a href="https://showcase.247cloudhub.co.uk/ebay/ebay_listing_violations_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" style="cursor:pointer;color:red" target="_blank" class="ng-binding"> 148 Listing<span ng-show="getListingViolations.HTTPSCnt!=0 &amp;&amp; getListingViolations.HTTPSCnt!=1" class="">s</span> </a> </span><!-- end ngIf: getListingViolations.HTTPSCnt != 0 --> 
									   </td>
									   <td>
										  <!-- ngIf: getListingViolations.OUTSIDE_EBAY == 0 --><span ng-if="getListingViolations.OUTSIDE_EBAY == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations there are no listings with Outside eBay Buying and Selling violations!</span></span><!-- end ngIf: getListingViolations.OUTSIDE_EBAY == 0 --> <!-- ngIf: getListingViolations.OUTSIDE_EBAY != 0 --> 
									   </td>
									   <td>
										  <!-- ngIf: getListingViolations.RETURNS_POLICY == 0 --><span ng-if="getListingViolations.RETURNS_POLICY == 0" class="ng-scope"><span class="cloudGreen fw500">Congratulations there are no listings with Returns Policy violations!</span></span><!-- end ngIf: getListingViolations.RETURNS_POLICY == 0 --> <!-- ngIf: getListingViolations.RETURNS_POLICY != 0 --> 
									   </td>
									   <td>
										  <!-- ngIf: getListingViolations.ASPECTS_ADOPTION == 0 --> <!-- ngIf: getListingViolations.ASPECTS_ADOPTION != 0 --><span ng-if="getListingViolations.ASPECTS_ADOPTION != 0" class="ng-scope">  <a href="https://showcase.247cloudhub.co.uk/ebay/get_ebay_aspect_adoption_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK&amp;type=ASPECTS_ADOPTION" class="eTRS ng-binding" style="cursor:pointer;color:red" target="_blank"> 21 Listing<span ng-show="getListingViolations.ASPECTS_ADOPTION!=0 &amp;&amp; getListingViolations.ASPECTS_ADOPTION!=1" class="">s</span> </a> </span><!-- end ngIf: getListingViolations.ASPECTS_ADOPTION != 0 --> 
									   </td>
									</tr>
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

<?php include("../common/footer.php"); ?>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
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
.drop-and-drag-image .col-md-3 {
    height: 290px;
}
.drop-and-drag-image img {
    width: 220px;
    height: 220px;
    padding-top: 0px;
}
.wrapper {
	overflow: visible;
}
.portlets-wrapper {
    overflow: visible;
}
</style>
<script>
$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: app_base_url + "inventory/eBayDashboard/first_seller.php",
		//dataType: 'json',
		//data:{marketplacecode:marketplacecode},
		success: function (res) {
			$('#first_seller').html(res);
		}
	});
});
</script>