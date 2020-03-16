<?php
	if(!isset($_SESSION)){
		session_start();
	}
	function market_columns($marketplacecode='0'){
		$total_cols = array();
		if($marketplacecode == 0){ // default columns
			$total_cols = array(array("name"=>"SKU","val"=>"sku"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Product Name","val"=>"ProductTitle"),array("name"=>"Quantity","val"=>"totalQty"),
					array("name"=>"Status","val"=>"active"),array("name"=>"Warehouse","val"=>"warehouse"),
					array("name"=>"Supplier","val"=>"supplier"),array("name"=>"Sales 24 Hrs","val"=>"lastdays"),
					array("name"=>"Sales 7 Days","val"=>"last7days"),array("name"=>"Sales 30 Days","val"=>"last30days"),
					array("name"=>"EAN","val"=>"ean"),array("name"=>"Account Name","val"=>"fkaccountcode"),
					array("name"=>"Market Place","val"=>"fkmarketplacecode"),array("name"=>"Binlocation","val"=>"binlocation"));
		}
		else if($marketplacecode == 1){ // eabay account columns
			$total_cols = array(array("name"=>"SKU","val"=>"sku"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Account","val"=>"fkaccountcode"),array("name"=>"Product Title","val"=>"ebayproducttitle"),
					array("name"=>"Buy It Now Price","val"=>"buyitnowprice"),array("name"=>"Launch Quantity","val"=>"launchqty"),
					array("name"=>"EAN","val"=>"ean"),array("name"=>"Quantity","val"=>"totalQty"),
					array("name"=>"Status","val"=>"active"),array("name"=>"eBay Item ID","val"=>"itemid"),
					array("name"=>"Listing Error","val"=>"itemerrordescription"),array("name"=>"Listed Date","val"=>"ebaylisteddatetime"),
					array("name"=>"eBay Schedule","val"=>"ebayschedule"),array("name"=>"Revised Date","val"=>"ebayrevisedatetime"),
					array("name"=>"Revision Response","val"=>"revisionresponse"),array("name"=>"Sales 24 Hrs","val"=>"lastdays"),
					array("name"=>"Sales 7 Days","val"=>"last7days"),array("name"=>"Sales 30 Days","val"=>"last30days"));
		}else if($marketplacecode == 2){ // amazon columns		
			$total_cols = array(array("name"=>"SKU","val"=>"sku"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Product Title","val"=>"amazonproducttitle"),array("name"=>"Quantity","val"=>"totalQty"),
					array("name"=>"ASIN","val"=>"asin"),array("name"=>"Min Price","val"=>"minprice"),
					array("name"=>"Max Price","val"=>"maxprice"),array("name"=>"Status","val"=>"active"),
					array("name"=>"EAN","val"=>"ean"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Account","val"=>"fkaccountcode"),array("name"=>"Amazon Category","val"=>"amazoncategory"),
					array("name"=>"Product Condition","val"=>"productcondition"),array("name"=>"Launch Quantity","val"=>"launchqty"),
					array("name"=>"Fixed Price","val"=>"fixedprice"),array("name"=>"Sales 24 Hrs","val"=>"lastdays"),
					array("name"=>"Sales 7 Days","val"=>"last7days"),array("name"=>"Sales 30 Days","val"=>"last30days"));
		}else if($marketplacecode == 7){ // rakuten columns	
			$total_cols = array(array("name"=>"SKU","val"=>"sku"),array("name"=>"Product Title","val"=>"rakutenproducttitle"),
					array("name"=>"Quantity","val"=>"totalQty"),array("name"=>"Price","val"=>"price"),
					array("name"=>"Status","val"=>"active"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Account","val"=>"accountcode"),array("name"=>"Listed Date  Time","val"=>"listeddatetime"),
					array("name"=>"Listing Error","val"=>"listederrordatetime"),array("name"=>"Supplier","val"=>"supplier"),
					array("name"=>"Sales 24 Hrs","val"=>"lastday"),
					array("name"=>"Sales 7 Days","val"=>"last7days"),array("name"=>"Sales 30 Days","val"=>"last30days"));
			
		}else if($marketplacecode == 8){ // trademe columns	
			$total_cols = array(
					  array( "name"=> "SKU", "val"=> "sku"),
					  array( "name"=> "SKU Type", "val"=> "skutype"),
					  array( "name"=> "Account", "val"=> "accountcode"),
					  array( "name"=> "Product Title", "val"=> "trademeproducttitle"),
					  array( "name"=> "Buy It Now Price", "val"=> "trademebuynowprice"),
					  array( "name"=> "Quantity", "val"=> "totalQty", "sortable"=> "totalquantity"),
					  array( "name"=> "Status", "val"=> "active"),
					  array( "name"=> "Listed Date time", "val"=> "trademelisteddatetime"),
					  array( "name"=> "Listing Error ", "val"=> "trademeerrorlisteddatetime"),
					  array( "name"=> "Trademe Category", "val"=> "trademecategory"),
					  array( "name"=> "Product Description", "val"=> "trademedescription"),
					  array( "name"=> "Launch Quantity", "val"=> "launchqty"),
					  array( "name"=> "Duration", "val"=> "trademeduration"),
					  array( "name"=> "Sales 24 Hrs", "val"=> "lastday"),
					  array( "name"=> "Sales 7 Days", "val"=> "last7days"),
					  array( "name"=> "Sales 30 Days", "val"=> "last30days"),
					);
			
		}else if($marketplacecode == 3){//webstore columns
			$total_cols= array(
					  array("name"=> "SKU", "val"=> "sku", "sortable"=> "sku"),
					  array("name"=> "Product Title", "val"=> "webstoreproductname", "sortable"=> "webstoreproductname"),
					  array("name"=> "Quantity", "val"=> "totalQty", "sortable"=> "totalquantity"),
					  array("name"=> "Price", "val"=> "saleprice", "sortable"=> ""),
					  array("name"=> "Status", "val"=> "active", "sortable"=> "active"),
					  array("name"=> "SKU Type", "val"=> "skutype", "sortable"=> ""),
					  array("name"=> "Account", "val"=> "fkaccountcode", "sortable"=> ""),
					  array("name"=> "Sales 24 Hrs", "val"=> "lastday", "sortable"=> ""),
					  array("name"=> "Sales 7 Days", "val"=> "last7day", "sortable"=> ""),
					  array("name"=> "Sales 30 Days", "val"=> "last30day", "sortable"=> ""),
					  array("name"=> "Listing Errors", "val"=> "webstoreerrormessage", "sortable"=> "")
					);
		}else if($marketplacecode == 9){//cdiscount columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "cdiscountproducttitle"),
					  array("name"=> "Quantity", "val"=> "totalQty"),
					  array("name"=> "Price", "val"=> "cdiscountprice"),
					  array("name"=> "RRP Price", "val"=> "cdiscountrrp"),
					  array("name"=> "Status", "val"=> "active"),
					  array("name"=> "SKU Type", "val"=> "skutype"),
					  array("name"=> "EAN", "val"=> "ean",),
					  array("name"=> "Account", "val"=> "cdiscountaccountcode"),
					  array("name"=> "Listed Date Time", "val"=> "cdiscountlisteddatetime"),
					  array("name"=> "Listing Error ", "val"=> "cdiscounterrorlisteddatetime"),
					  array("name"=> "CDiscount Category", "val"=> "cdiscountcategory"),
					  array("name"=> "Sales 24 Hrs", "val"=> "lastday"),
					  array("name"=> "Sales 7 Days", "val"=> "last7days"),
					  array("name"=> "Sales 30 Days", "val"=> "last30days")
					);
		}else if($marketplacecode == 101){//game columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "producttitle"),
					  array("name"=> "Account", "val"=> "accountcode"),
					  array("name"=> "Quantity", "val"=> "quantity"),
					  array("name"=> "Price", "val"=> "price"),
					  array("name"=> "ProductID Type", "val"=> "productidtype"),
					  array("name"=> "ProductID", "val"=> "productid"),
					  array("name"=> "State", "val"=> "state"),
					  array("name"=> "Product Description", "val"=> "description"),
					  array("name"=> "Update/Delete", "val"=> "updatedelete"),
					  array("name"=> "Available Startdate", "val"=> "availablestartdate"),
					  array("name"=> "Available Enddate", "val"=> "availableenddate"),
					  array("name"=> "Discount Startdate", "val"=> "discountstartdate"),
					  array("name"=> "Discount Enddate", "val"=> "discountenddate")
					);
		}else if($marketplacecode == 16){//fba columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku", "sortable"=> "MerchantSku"),
					  array("name"=> "FBA SKU", "val"=> "fbasku", "sortable"=> "FulfillmentChannelSku"),
					  array("name"=> "Product Title", "val"=> "productname"),
					  array("name"=> "ASIN", "val"=> "asin", "sortable"=> ""),
					  array("name"=> "Fulfillable Quantity", "val"=> "fulfillablequantity", "sortable"=> ""),
					  array("name"=> "Unfulfillable Quantity", "val"=> "unfulfillablequantity", "sortable"=> ""),
					  array("name"=> "Last Updated Date Time", "val"=> "lastupdateddatetime", "sortable"=> ""),
					  array("name"=> "Account Name", "val"=> "accountname", "sortable"=> ""),
					);
		}else if($marketplacecode == 13){//abebooks columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "title"),
					  array("name"=> "Quantity", "val"=> "quantitylimit"),
					  array("name"=> "Price", "val"=> "price"),
					  array("name"=> "Status", "val"=> "active"),
					  array("name"=> "Author", "val"=> "author"),
					  array("name"=> "Account", "val"=> "abebookaccountcode"),
					  array("name"=> "Book Language", "val"=> "booklanguage"),
					  array("name"=> "ISBN", "val"=> "isbn"),
					  array("name"=> "Launch Quantity", "val"=> "launchquantity"),
					  array("name"=> "No Of Images", "val"=> "numberofimages")
					);
		}else if($marketplacecode == 17){//allegro columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "producttitle"),
					  array("name"=> "Description", "val"=> "description"),
					  array("name"=> "Start Price", "val"=> "startprice"),
					  array("name"=> "Minium Price", "val"=> "minimumprice"),
					  array("name"=> "Account", "val"=> "accountcode"),
					  array("name"=> "No Of Items", "val"=> "numberofitems")
					);
		}else if($marketplacecode == 21){//SKUcloud columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "producttitle"),
					  array("name"=> "Description", "val"=> "description"),
					  array("name"=> "Base Price", "val"=> "baseprice"),
					  array("name"=> "Identifier Type", "val"=> "identifiertype"),
					  array("name"=> "Identifier Value", "val"=> "identifiervalue"),
					  array("name"=> "Brand", "val"=> "brand")
					);
		}else if($marketplacecode == 20){//onbuy columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "producttitle"),
					  array("name"=> "Description", "val"=> "description"),
					  array("name"=> "Brand", "val"=> "brandname"),
					  array("name"=> "MPN", "val"=> "mpn"),
					  array("name"=> "Stock", "val"=> "stock"),
					  array("name"=> "RRP", "val"=> "rrp")
					);
		}else if($marketplacecode == 22){//frugo columns
			$total_cols = array(
					  array("name"=> "SKU", "val"=> "sku"),
					  array("name"=> "Product Title", "val"=> "title"),
					  array("name"=> "Product ID", "val"=> "productId"),
					  array("name"=> "EAN", "val"=> "gtiNs"),
					  array("name"=> "Brand", "val"=> "brand"),
					  array("name"=> "Quantity", "val"=> "quantityInStock"),
					  array("name"=> "Stock Staus", "val"=> "stockStatus"),
					  array("name"=> "Category Name", "val"=> "categoryName"),
					  array("name"=> "Category Path", "val"=> "categoryValue"),
					  array("name"=> "Currency", "val"=> "currency"),
					  array("name"=> "Price Without Vat", "val"=> "normalPriceWithoutVAT"),
					  array("name"=> "Manufacturer", "val"=> "manufacturer"),
					  array("name"=> "ISBN", "val"=> "isbn"),
					  array("name"=> "Restock Date", "val"=> "restockDate")
					);
		}else if($marketplacecode == 15){//shopify columns
			$total_cols = array(
						  array("name"=> "SKU", "val"=> "sku"),
						  array("name"=> "Product Title", "val"=> "producttitle"),
						  array("name"=> "Description", "val"=> "productdescription"),
						  array("name"=> "Brand", "val"=> "brandname"),
						  array("name"=> "Product Type", "val"=> "producttype"),
						  array("name"=> "Standard Price", "val"=> "standardprice")
						);
		}else{
			$total_cols = array(array("name"=>"SKU","val"=>"sku"),array("name"=>"SKU Type","val"=>"skutype"),
					array("name"=>"Product Name","val"=>"ProductTitle"),array("name"=>"Quantity","val"=>"totalQty"),
					array("name"=>"Status","val"=>"active"),array("name"=>"Warehouse","val"=>"warehouse"),
					array("name"=>"Supplier","val"=>"supplier"),array("name"=>"Sales 24 Hrs","val"=>"lastdays"),
					array("name"=>"Sales 7 Days","val"=>"last7days"),array("name"=>"Sales 30 Days","val"=>"last30days"),
					array("name"=>"EAN","val"=>"ean"),array("name"=>"Account Name","val"=>"fkaccountcode"),
					array("name"=>"Market Place","val"=>"fkmarketplacecode"),array("name"=>"Binlocation","val"=>"binlocation"));
		}
		return $total_cols;
		
	}
	function accountNames(){
		
		$data = array();
		$data[0] = 'Common';
		$data[1] = 'eBay - eBay UK';
		$data[2] = 'Amazon - Amazon UK';
		return $data;
	}
	function marketplaceNames(){
		$data = array();
		$data[0] = 'Common';
		$data[1] = 'eBay';
		$data[2] = 'Amazon';
		return $data;
	}
	function accountNamesDynamic($marketplacecode){
		$data = array();
		if(isset($_SESSION['inventory_tabs'])){
			$tab_accounts= $_SESSION['inventory_tabs'];
			if($marketplacecode == "2"){//Amazon
				if(isset($tab_accounts['amazonAccounts']['accounts'])){
					$accounts = $tab_accounts['amazonAccounts']['accounts'];
					foreach($accounts as $k=>$v){
						$data[$v['amzaccountcode']] = $v['amzaccountname'];
					}
				}
			}elseif($marketplacecode == "1"){
				if(isset($tab_accounts['ebayAccounts']['ebayaccounts'])){
					$accounts = $tab_accounts['ebayAccounts']['ebayaccounts'];
					foreach($accounts as $k=>$v){
						$data[$v['ebayaccountcode']] = $v['ebayaccountname'];
					}
				}
			}
			elseif($marketplacecode == "101"){
				if(isset($tab_accounts['gameAccounts']['accounts'])){
					$accounts = $tab_accounts['gameAccounts']['accounts'];
					foreach($accounts as $k=>$v){
						$data[$v['gameaccountcode']] = $v['gameaccountname'];
					}
				}
			}
			elseif($marketplacecode == "9"){
				if(isset($tab_accounts['cdiscountAccounts']['accounts'])){
					$accounts = $tab_accounts['cdiscountAccounts']['accounts'];
					foreach($accounts as $k=>$v){
						$data[$v['cdiscountaccountcode']] = $v['cdiscountaccountname'];
					}
				}
			}
			elseif($marketplacecode == "3"){
				if(isset($tab_accounts['webstoreAccounts']['webstoreaccounts'])){
					$accounts = $tab_accounts['webstoreAccounts']['webstoreaccounts'];
					foreach($accounts as $k=>$v){
						$data[$v['webstoreaccountcode']] = $v['webstoreaccountname'];
					}
				}
			}
			elseif($marketplacecode == "21"){
				if(isset($tab_accounts['skucloudAccounts']['accounts'])){
					$accounts = $tab_accounts['skucloudAccounts']['accounts'];
					foreach($accounts as $k=>$v){
						$data[$v['accountcode']] = $v['accountname'];
					}
				}
			}
			elseif($marketplacecode == "20"){
				if(isset($tab_accounts['onbuyAccounts']['accounts'])){
					$accounts = $tab_accounts['onbuyAccounts']['accounts'];
					foreach($accounts as $k=>$v){
						$data[$v['accountcode']] = $v['accountname'];
					}
				}
			}
		}
		return $data;
	}
?>