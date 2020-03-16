<?php
include('ebay_api_end_points.php');
$data = "Seller should offer an option of express delivery within 2 days for Â£10 or less";
$array = array();
//include('common/header.php');
?>
<a href="<?= BASE_URL ?>ebay/get_ebay_aspect_adoption_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK&type=ASPECTS_ADOPTION" >Aspect Adoption Report</a><br/>
<a href="<?= BASE_URL ?>ebay/get_ebay_traffic_pomotion_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" >Traffic Report</a><br/>
<a href="<?= BASE_URL ?>ebay/ebay_recommendation_enhancement_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" >Recommended Enhancement Report</a><br/>
<a href="<?= BASE_URL ?>ebay/ebay_listing_violations_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK&type=HTTPS" >Listing Violations Report</a><br/>
<a href="<?= BASE_URL ?>ebay/ebay_campaign_report.php?seller_ebay_id=77_Champion_Dreams_Limited_eBay__eBay_UK" >Campaign Report</a><br/>
<?php //include('common/footer.php'); ?>