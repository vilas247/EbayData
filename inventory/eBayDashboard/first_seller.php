<?php
require_once("../../common/db-config.php");
require_once("../../common/ebay_api_end_points.php");
require_once("../../common/curl.php");
require_once('../../common/inventory_config.php');
require_once('../columns_helper.php');
if(!isset($_SESSION)){
	session_start();
}
$result = array();
$result1 = array();

if(isset($_SESSION['usercode']) &&isset($_SESSION['dbcode']) &&isset($_SESSION['usertoken'])){
	$usercode = $_SESSION['usercode']; 
	$dbcode = $_SESSION['dbcode']; 
	$usertoken = $_SESSION['usertoken'];
	$base_url = "https://showcase.247cloudhub.co.uk/";
	$inventorydashboard_URL = $base_url."ebayapis/ebay_data/get-user-profile.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK";	$request = "";
		//echo $request;exit;
	$response = get_xml_response($inventorydashboard_URL,$request);
	//print_r($response);exit;
	$xml = simplexml_load_string($response); 
	$res = $xml->GetUserProfileResponse;

	foreach($xml as $k=>$service) {
		$service = json_decode(json_encode($service), true);
		if(count($service)>1){
			foreach($service as $kk=>$vv){
				$result[$kk] = $vv;
			}
		}else{
			$result[$k] = $service[0];
		}
		
	}
	
	$inventorydashboard_URL1 = $base_url."ebayapis/ebay_data/get-seller-dashboard.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK";
	$request = "";
		//echo $request;exit;
	$response1 = get_xml_response($inventorydashboard_URL1,$request);
	//print_r($response1);exit;
	$xml1 = simplexml_load_string($response1);

	foreach($xml1 as $k1=>$v1){
		if($k1 == "SellerFeeDiscount"){
			$v1 = json_decode(json_encode($v1), true);
			$result1['SellerFeeDiscount'] = $v1['Percent'];
		}else if($k1 == "PowerSellerStatus"){
			$v1 = json_decode(json_encode($v1), true);
			$result1['PowerSellerStatus'] = $v1['Level'];
		}else if($k1 == "Performance"){
			$v1 = json_decode(json_encode($v1), true);
			$result1['Performance'][] = $v1;
		}
	}
	
}

?>

<div class="row">
	<div class="col-sm-1">  <span><img class="img-responsive"></span> </div>
	<div class="col-sm-2">
      <h4 class="zero-margin ng-binding" style="padding-bottom: 5px">Phillips Toys</h4>
      <h6 class="zero-margin ng-binding">@<?= @$result['UserID'] ?>(Feedback Score: <?= @$result['FeedbackScore'] ?>)</h6>
   </div>
   <div class="col-sm-1" style="border-left: 1px solid #e4e4e4">
      <h4 class="zero-margin cloudGreen ng-binding" style="padding-bottom: 5px;font-size: 18px">
		<?php if(isset($result['RegistrationDate'])){
			echo date("d M Y",strtotime($result['RegistrationDate']));
		} ?>
	</h4>
      <h6 class="zero-margin">eBay Member since</h6>
   </div>
   <div class="col-sm-6">
   <div class="row">
         <div class="col-sm-3" style="border-left: 1px solid #e4e4e4">Seller level Performance Standards &gt;&gt;</div>
		 <?php 
			if(isset($result1['Performance'])){
				foreach($result1['Performance'] as $k=>$v){ ?>
					 <div class="col-sm-3">
						<span><h4 class="zero-margin cloudeBronze" style="padding-bottom: 5px; color: #1289A7"><?= $v['Status'] ?></h4></span>
						<h6 class="zero-margin ng-binding"><?= (is_array($v['Site']))?implode(",",$v['Site']):$v['Site'] ?></h6>
					 </div>
		 <?php }} ?>
      </div>
   </div>
   <div class="col-sm-2" style="border-left: 1px solid #e4e4e4">
      <div class="row">
         <div class="col-sm-6">
            <h4 class="zero-margin cloudeBronze ng-binding" style="padding-bottom: 5px"><?= @$result1['PowerSellerStatus'] ?></h4>
            <h6 class="zero-margin">Power Seller Status</h6>
         </div>
         <div class="col-sm-6">
            <h4 class="zero-margin cloudeBronze ng-binding" style="padding-bottom: 5px; color: #3F51B5"><?= @$result1['SellerFeeDiscount'] ?>%</h4>
            <h6 class="zero-margin">Current Seller Fee Discount</h6>
         </div>
      </div>
   </div>
</div>

				