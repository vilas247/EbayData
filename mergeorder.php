$request = "<getorderdetailsrequest>
								<usertoken>".$usertoken."</usertoken>
								<dbcode>".$dbcode."</dbcode>
								<responsetype>json</responsetype>
								<orderstages>".$orderstages."</orderstages>
								<period>
									<numberofdays>".$numberofdays."</numberofdays>
									<fromdate>".$fromdate."</fromdate>
									<toodate>".$todate."</toodate>
								</period>
								<shippingservicecodes>".$shippingservicecodes."</shippingservicecodes>
								<shippingcountrycodes>".$shippingcountrycodes."</shippingcountrycodes>
								<accountcodes>".$accountcodes."</accountcodes>
								<itemtype>".$itemtype."</itemtype>
								<supplier>".$supplier."</supplier>
								<pagenumber>".$offset."</pagenumber>
								<numberofrecords>".$limit."</numberofrecords>
							</getorderdetailsrequest>";
			
			//echo $request;exit;
			$res = get_xml_response($orderdashboard_URL,$request);
			//print_r($res);exit;
			$res='{"usertoken":"0EB8B895-7EBC-499C-8FE6-8C4DE45F1A88","statuscode":"0","statusmessage":"Success","responsetype":"json","invoices":[{
    "InvoiceToAddresses": [
        {
            "PKInvoiceToAddressId": 442,
            "FKInvoiceId": 4033,
            "Name": "Ingeborg Broßmann",
            "Address1": null,
            "Address2": "Mylauer Berg 2",
            "City": "Netzschkau",
            "StateOrRegion": null,
            "County": null,
            "PostCode": "08491",
            "CountryCode": "DE",
            "CountryName": "DE",
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.77"
        }
    ],
    "OrderItems": [
        {
            "OrderItemNameValues": [],
            "PKOrderItemId": 521,
            "FKInvoiceId": 4033,
            "ASIN": "B07P997J6C",
            "Sku": "GMRS045M",
            "Image": null,
            "ProductTitle": "Good Mood Unisex Socken Beer UK6-8/EU39-42/US7-9",
            "Quantity": 1.0,
            "UnitPrice": 6.99,
            "TotalPrice": "6.99",
            "Weight": "0.0480",
            "Depth": "0",
            "Width": "0",
            "Height": "0",
            "ShippingPrice": null,
            "ShippingService": "Standard",
            "BinLocation": null,
            "OrderLineItemId": "69528178766163",
            "PickupStoreId": null,
            "ShipDiscountCurrencyCode": null,
            "ShippingTax": null,
            "PromoDiscountCurrencyCode": "EUR",
            "PromoDiscountAmount": "0.00",
            "PromotionIds": null,
            "Ean": "8585052001318",
            "VatRate": "20",
            "ItemTax": "1.12",
            "ItemCondition": "New",
            "Mpn": "GMRS045M",
            "Size": null,
            "Attri": null,
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.833",
            "ShipDiscountAmount": null,
            "DiscountAmount": null,
            "ImageId": null,
            "ImageQty": null,
            "Taxable": null,
            "childOrder": "123456"
        },
        {
            "OrderItemNameValues": [],
            "PKOrderItemId": 522,
            "FKInvoiceId": 4033,
            "ASIN": "B081VGD36W",
            "Sku": "GMRS084M",
            "Image": null,
            "ProductTitle": "Dedoles Good Mood Socken für Erwachsene, Größe 39-42/US7-9",
            "Quantity": 1.0,
            "UnitPrice": 6.99,
            "TotalPrice": "6.99",
            "Weight": "0.0480",
            "Depth": "0",
            "Width": "0",
            "Height": "0",
            "ShippingPrice": null,
            "ShippingService": "Standard",
            "BinLocation": null,
            "OrderLineItemId": "31065974141883",
            "PickupStoreId": null,
            "ShipDiscountCurrencyCode": null,
            "ShippingTax": null,
            "PromoDiscountCurrencyCode": "EUR",
            "PromoDiscountAmount": "0.00",
            "PromotionIds": null,
            "Ean": "8585052004623",
            "VatRate": "20",
            "ItemTax": "1.12",
            "ItemCondition": "New",
            "Mpn": "GMRS084M",
            "Size": null,
            "Attri": null,
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.897",
            "ShipDiscountAmount": null,
            "DiscountAmount": null,
            "ImageId": null,
            "ImageQty": null,
            "Taxable": null,
            "childOrder": "1234567"
        },
        {
            "OrderItemNameValues": [],
            "PKOrderItemId": 523,
            "FKInvoiceId": 4033,
            "ASIN": "B07NYBCWF2",
            "Sku": "GMRS001L",
            "Image": null,
            "ProductTitle": "Good Mood Bier Buntes Design-Geschenk Socken 1 Paar, Mehrfarbig, UK9-12/EU43-46/US10-12",
            "Quantity": 1.0,
            "UnitPrice": 6.99,
            "TotalPrice": "6.99",
            "Weight": "0.0510",
            "Depth": "0",
            "Width": "0",
            "Height": "0",
            "ShippingPrice": null,
            "ShippingService": "Standard",
            "BinLocation": null,
            "OrderLineItemId": "37189923863067",
            "PickupStoreId": null,
            "ShipDiscountCurrencyCode": null,
            "ShippingTax": null,
            "PromoDiscountCurrencyCode": "EUR",
            "PromoDiscountAmount": "0.00",
            "PromotionIds": null,
            "Ean": "8585052000069",
            "VatRate": "20",
            "ItemTax": "1.12",
            "ItemCondition": "New",
            "Mpn": "GMRS001L",
            "Size": null,
            "Attri": null,
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.96",
            "ShipDiscountAmount": null,
            "DiscountAmount": null,
            "ImageId": null,
            "ImageQty": null,
            "Taxable": null,
            "childOrder": "12345678"
        },
        {
            "OrderItemNameValues": [],
            "PKOrderItemId": 524,
            "FKInvoiceId": 4033,
            "ASIN": "B07P55S7DJ",
            "Sku": "GMRS031S",
            "Image": null,
            "ProductTitle": "Good Mood Kosmos Buntes Design-Geschenk Socken 1 Paar",
            "Quantity": 1.0,
            "UnitPrice": 6.99,
            "TotalPrice": "6.99",
            "Weight": "0.0480",
            "Depth": "0",
            "Width": "0",
            "Height": "0",
            "ShippingPrice": null,
            "ShippingService": "Standard",
            "BinLocation": null,
            "OrderLineItemId": "68684012401763",
            "PickupStoreId": null,
            "ShipDiscountCurrencyCode": null,
            "ShippingTax": null,
            "PromoDiscountCurrencyCode": "EUR",
            "PromoDiscountAmount": "0.00",
            "PromotionIds": null,
            "Ean": "8585052000915",
            "VatRate": "20",
            "ItemTax": "1.12",
            "ItemCondition": "New",
            "Mpn": "GMRS031S",
            "Size": null,
            "Attri": null,
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.99",
            "ShipDiscountAmount": null,
            "DiscountAmount": null,
            "ImageId": null,
            "ImageQty": null,
            "Taxable": null,
            "childOrder": "123456789"
        }
    ],
    "ShippingAddresses": [
        {
            "PKShippingAddressId": 442,
            "FKInvoiceId": 4033,
            "Address1": null,
            "Address2": "Mylauer Berg 2",
            "City": "Netzschkau",
            "StateOrRegion": null,
            "County": null,
            "PostCode": "08491",
            "CountryCode": "DE",
            "CountryName": "DE",
            "NoOfParcels": "noofparcels",
            "Phone": "0170/6030896",
            "MobileNo": "0170/6030896",
            "Email": "yd25p5l00mdksh9@marketplace.amazon.de",
            "Name": "Ingeborg Broßmann",
            "LastUpdatedDateInDb": "2019-12-06T10:21:35.727"
        }
    ],
    "PKInvoiceId": 4033,
    "OrderId": "M-028-4800742-1951509",
    "MarketPlaceCode": 2,
    "PurchaseDate": "2019-12-06T09:38:03",
    "SalesChannel": "Amazon.de",
    "AccountName": "Amazon - DE",
    "AccountCode": 221,
    "PaymentMethod": "Other",
    "Two47ShippingService": "two47shippingservice",
    "CurrentStock": "0",
    "TotalPrice": "27.96",
    "TotalWeight": "0",
    "OrderQuantity": "4",
    "OrderNotes": null,
    "MergeItemOrders": null,
    "CombinedShortOrderId": null,
    "LatestShipDate": "2019-12-10T22:59:59",
    "IsBusinessOrder": false,
    "IsPrime": false,
    "IsPremiumOrder": false,
    "EbayBuyerId": null,
    "BuyerMessage": null,
    "PayPalTransactionId": null,
    "LastUpdatedDateInDb": "2019-12-06T10:21:35.537"
}]}';