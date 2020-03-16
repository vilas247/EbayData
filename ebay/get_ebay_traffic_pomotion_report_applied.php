<?php
print_r($_REQUEST);exit;
if(isset($_REQUEST['post_data'])){
	$post_data = $_REQUEST['post_data'];
	foreach($post_data as $k=>$v){
		if(isset($v['promoted_listing'])){
			if(isset($v['promoted_listing']['campaign_id']) && !empty($v['promoted_listing']['campaign_id']) && isset($v['promoted_listing']['your_ad_rate']) && intval($v['promoted_listing']['your_ad_rate']) > 0){
				$campaignId = $v['promoted_listing']['campaign_id'];
				$bidPercentage = $v['promoted_listing']['your_ad_rate'];
				$listingId = $v['ebay_item_id'];
				//api call here
			}
		}
		if(isset($v['multi_buy'])){
			$multi_buy = $v['multi_buy'];
			if(isset($multi_buy['multibuy2']) && intval($multi_buy['multibuy2']) > 0 && isset($multi_buy['multibuy3']) && intval($multi_buy['multibuy3']) > 0 && isset($multi_buy['multibuy4']) && intval($multi_buy['multibuy4']) > 0){
				$listingIds = $v['ebay_item_id'];
				$multibuy2 = $multi_buy['multibuy2'];
				$multibuy3 = $multi_buy['multibuy3'];
				$multibuy4 = $multi_buy['multibuy4'];
				//api call
			}
		}
	}
}
?>