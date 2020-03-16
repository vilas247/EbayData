<?php
	if(!isset($_SESSION)){
		session_start();
	}
	function market_columns($marketplacecode='0'){
		$total_cols = array();
		$total_cols = array(
		  array(
			"name"=> "Account Name",
			"val"=> "accountname",
			//"col_name"=> "AccountName",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Order Date",
			"val"=> "purchasedate",
			//"col_name"=> "PurchaseDate",
			"sortable"=> "purchasedate",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Order ID",
			"val"=> "ordernumber",
			//"col_name"=> "OrderId",
			"selected"=> true,
			"sortable"=> "ordernumber",
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "SKU",
			"val"=> "sku",
			//"col_name"=> "Sku",
			"sortable"=> "sku",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Product Name",
			"val"=> "producttitle",
			//"col_name"=> "ProductTitle",
			"sortable"=> "producttitle",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Shipping Service",
			"val"=> "shippingservice",
			//"col_name"=> "ShippingService",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Shipping Postcode",
			"val"=> "postcode",
			//"col_name"=> "PostCode",
			"selected"=> false,
			"sortable"=> "postcode",
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Order Stage",
			"val"=> "orderstage",
			//"col_name"=> "orderstage",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Order Quantity",
			"val"=> "orderquantity",
			//"col_name"=> "OrderQuantity",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Order Total",
			"val"=> "ototal",
			//"col_name"=> "TotalPrice",
			"sortable"=> "ototal",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Product Total",
			"val"=> "ptotal",
			//"col_name"=> "TotalPrice",
			"sortable"=> "ptotal",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Shipping Total",
			"val"=> "stotal",
			//"col_name"=> "ShippingPrice",
			"sortable"=> "stotal",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> true
		  ),
		  array(
			"name"=> "Supplier",
			"val"=> "saleschannel",
			//"col_name"=> "SalesChannel",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Single/Multiple Order",
			"val"=> "single",
			//"col_name"=> "single",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Locked By",
			"val"=> "lockedby",
			//"col_name"=> "AccountName",
			"sortable"=> "",
			"selected"=> false,
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Available Qty",
			"val"=> "availableQty",
			//"col_name"=> "AvailableQty",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),

		  array(
			"name"=> "FBA Fulfillable Quantity",
			"val"=> "fbafulfillableqty",
			//"col_name"=> "fbafulfillableqty",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Ship by",
			"val"=> "latestshipdate",
			//"col_name"=> "LatestShipDate",
			"selected"=> false,
			"sortable"=> "latestshipdate",
			"pos"=> "",
			"issortable"=> true
		  ), array(
			"name"=> "Country",
			"val"=> "country",
			//"col_name"=> "Country ",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Binlocation",
			"val"=> "binlocation",
			//"col_name"=> "binlocation",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Cost Price",
			"val"=> "unitprice",
			//"col_name"=> "UnitPrice",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Buyers Name",
			"val"=> "buyername",
			//"col_name"=> "buyername",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "EAN",
			"val"=> "ean",
			//"col_name"=> "Ean",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  ),
		  array(
			"name"=> "Prime Order",
			"val"=> "isprime",
			//"col_name"=> "Ean",
			"selected"=> false,
			"sortable"=> "",
			"pos"=> "",
			"issortable"=> false
		  )


		);
		return $total_cols;
		
	}
?>