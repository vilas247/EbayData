function RejelAutomotiveInvoicePDF(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var mpc = '';
		var n = '';
		var merTempArray = '';
		var isfooterComplted = 1;
		var isfooterheight = 0;
		var isfooterpage = 1;
		var itemgridendpos = 0;
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')($scope.tempordDetails, {
				"ordernumber": data[j].orderid
			}, true);*/
		}


		var totalPagesExp = data.length;

		var returuncenteredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFontType("normal");
			doc.setFontSize(8);
			doc.text(textOffset, y, text);
		};

		var deliveryid = "RAdeliveryvat_ppi";
		var deliveryres = '';
		
		/*Return address */
			var return_address = data[j]['invoicetoaddresses'][0];
			$('#invoicetoname_ppi').text(return_address.Name);
			$('#invoicetoaddress1_ppi').text(return_address.Address1);
			$('#invoicetoaddress2_ppi').text(return_address.Address2);
			$('#invoicetocity_ppi').text(return_address.City);
			$('#invoicetostateorregion_ppi').text(return_address.StateOrRegion);
			$('#invoicetopostcode_ppi').text(return_address.PostCode);
			$('#invoicetocountryname_ppi').text(return_address.CountryName);
		/* Return address end */

		var billingid = "RAbillingvat_ppi";
		var billingres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1ppi').text(ship_address.Address1);
			$('#shipaddress2ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shipstateorregion_ppi').text(ship_address.Stateorregion);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
			$('#shipphone_ppi').text(ship_address.Phone);
		/* Ship address end */

		var shippinginstid = "RAshippinginstvat_ppi";
		var shippinginstres = '';

		var additionalinfoid = "RAadditionalinfovat_ppi";
		var additionalinfores = '';

		var shippingid = "RAbasicvat_ppi";
		var shippingres = '';
		
		$('#rashipname_ppi').text(ship_address.Name);
		$('#rashipaddress1ppi').text(ship_address.Address1);
		$('#rashipaddress2ppi').text(ship_address.Address2);
		$('#rashipcity_ppi').text(ship_address.City);
		$('#rashipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#rashippostcode_ppi').text(ship_address.PostCode);
		$('#rashipcountryname_ppi').text(ship_address.CountryName);
		$('#rashipphone_ppi').text(ship_address.Phone);

		var childid = "RAordervat_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var shipping_service = "Standard";
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */
		
		var channelid = "RAchannelvat_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		$('#shippingservice_ppi').text(shipping_service);
		/* channel data end */

		var totpriceid = "RAtotalpricevat_ppi";
		var totpriceres = '';
		$('#totalprice_ppi').html("&pound;"+parseFloat(parseFloat(X247Invoices.subtotalUnitPrice(j,data[j].orderitems)) - parseFloat(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems))).toFixed(2));
		$('#shippingprice_ppi').html("&pound;"+parseFloat(X247Invoices.subtotal(j,data[j].orderitems)).toFixed(2));
		$('#taxprice_ppi').html("&pound;"+parseFloat(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j])).toFixed(2));
		$('#grandtotal_ppi').html("&pound;"+parseFloat(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j])).toFixed(2));

		var newid = "RAnewvat_ppi";
		var newres = '';

		var barcodeid = "RAbarcodevat_ppi";
		var barcoderes = '';
		
		/* barcode */
			$("#RAbarImagevat_ppi").JsBarcode(data[j].orderid, {
				format: "CODE128", width: 1, displayValue: true, height: 40
			});
		/* barcode end */

		var returnaddressid = "RABTCreturnaddressvat_ppi";
		var returnaddressres = '';
		
		/*Return address */
			var return_address = data[j]['invoicetoaddresses'][0];
			$('#RAbtComp1A_ppi').text(return_address.Address1);
			$('#RAbtComp1Bvat_ppi').text(return_address.Address2);
			$('#RAbtComp1D_ppi').text(return_address.City);
			$('#RAbtComp1Evat_ppi').text(return_address.PostCode);
			$('#RAbtComp1Fvat_ppi').text(return_address.CountryName);
		/* Return address end */


		var hcreturnaddressid = "RAreturnaddressvat_ppi";
		var hcreturnaddressres = '';
		
		$('#rarshipname_ppi').text(ship_address.Name);
		$('#rarshipaddress1ppi').text(ship_address.Address1);
		$('#rarshipaddress2ppi').text(ship_address.Address2);
		$('#rarshipcity_ppi').text(ship_address.City);
		$('#rarshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#rarshippostcode_ppi').text(ship_address.PostCode);
		$('#rarshipcountryname_ppi').text(ship_address.CountryName);
		$('#rarshipphone_ppi').text(ship_address.Phone);

		var hcshippingmethodid = "RAshippingmethodvat_ppi";
		var hcshippingmethodres = '';
		
		$('#rashippingservice_ppi').text(shipping_service);

		var hcpaymentmethodid = "RApaymentmethodvat_ppi";
		var hcpaymentmethodres = '';
		
		$('#paymentmethod_ppi').text(data[j].paymentmethod);

		var hcOrderBoxid = "RAOrderBox_ppi";
		var hcOrderBoxres = '';

		var hcOrderBox1id = "RAOrderBox1_ppi";
		var hcOrderBox1res = '';

		var RAPriceDisplayid = "RAPriceDisplay_ppi";
		var RAPriceDisplayres = '';
		
		$('#pricewithoutvat_ppi').html("&pound;"+parseFloat(parseFloat(X247Invoices.subtotalUnitPrice(j,data[j].orderitems)) - parseFloat(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]))).toFixed(2));
		$('#vatamount_ppi').html("&pound;"+parseFloat(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j])).toFixed(2));

		var RAadditionalinfovatid = "RAadditionalinfovat_ppi";
		var RAadditionalinfovatres = '';
		
		$('#shippingemail_ppi').text(ship_address.Email);
		$('#ebaybuyerid_ppi').text(data[j].ebaybuyerid);


		var channelpos = 30;
		var comapnyEndPos = 0;


		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("Rejel Automotive Ltd, Rejel House,Murdock Road, Bedford, MK41 7PE", 20, 25);
		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("Invoice Date:", 20, 40);
		Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 80, 40);
		doc.text("Invoice Number :", 20, 50);

		if (data[j].marketplacecode == 1) {
			var ebayOrder = '';
			var dashcount = data[j].orderid.split('-', 1).join('-').length;
			if (dashcount == 0) {
				ebayOrder = "";
			} else {
				ebayOrder = data[j].orderid.slice(0, dashcount);
			}
			doc.text(ebayOrder, 90, 50);
		} else {
			doc.text(data[j].orderid, 90, 50);
		}

		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("Shipping Summary", 20, 70);
		doc.text("Billing Summary", 295, 70);
		doc.setFontType("normal");
		doc.setFontSize(9);


		var shippingEndPos = 0;

		// #region Adding Shipping Address  

		var yposordergrid = doc.autoTableEndPosY() + 30;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));


			var shippingoptions = {
				margin: {
					left: 20
				},
				startY: 80,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					overflow: 'linebreak'
				},
				tableWidth: 250
			};

			doc.autoTable(shippingres.columns, shippingres.data, shippingoptions);
			shippingEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Shipping Address

		// #region  Adding Billing Address

		var billingElementID = document.getElementById(billingid);
		if (billingElementID === null || billingElementID === undefined || billingElementID === '') {} else {
			billingres = doc.autoTableHtmlToJson(document.getElementById(billingid));
			doc.autoTable(billingres.columns, billingres.data, {
				margin: {
					left: 295
				},
				startY: 80,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});

		}

		// #endregion  Adding Billing  Address

		// #region Shipping Method

		var shippingMethodEndPos = 0;
		var shippingmethodElementID = document.getElementById(hcshippingmethodid);
		if (shippingmethodElementID === null || shippingmethodElementID === undefined || shippingmethodElementID === '') {} else {
			hcshippingmethodres = doc.autoTableHtmlToJson(document.getElementById(hcshippingmethodid));
			doc.autoTable(hcshippingmethodres.columns, hcshippingmethodres.data, {
				// startY: ipos,
				margin: {
					left: 20
				},
				startY: shippingEndPos + 10,
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
			shippingMethodEndPos = doc.autoTableEndPosY();
		}

		// #endregion Shipping Method

		// #region Payment Method

		var paymentmethodElementID = document.getElementById(hcpaymentmethodid);
		if (paymentmethodElementID === null || paymentmethodElementID === undefined || paymentmethodElementID === '') {} else {
			hcpaymentmethodres = doc.autoTableHtmlToJson(document.getElementById(hcpaymentmethodid));
			doc.autoTable(hcpaymentmethodres.columns, hcpaymentmethodres.data, {
				margin: {
					left: 295
				},
				startY: shippingEndPos + 10,
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
		}

		// #endregion Payment Method

		// #region Track Number

		doc.setFontSize(10);
		doc.setFontType("bold");
		doc.text('Tracking Number', 25, shippingMethodEndPos + 15);

		// #endregion Track Number

		// #region  Shipping Instructions

		var shippingInstEndPos = 0;
		var shippinginstElementID = document.getElementById(shippinginstid);
		if (shippinginstElementID === null || shippinginstElementID === undefined || shippinginstElementID === '') {} else {
			shippinginstres = doc.autoTableHtmlToJson(document.getElementById(shippinginstid));
			doc.autoTable(shippinginstres.columns, shippinginstres.data, {
				// startY: ipos,
				margin: {
					left: 20
				},
				startY: shippingMethodEndPos + 30,
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15
				},
				tableWidth: 250
			});
			shippingInstEndPos = doc.autoTableEndPosY();
		}

		// #endregion  Shipping Instructions

		// #region Additional info

		var additionalInfoEndPos = 0;

		// #region  Adding Additional Info

		var RAadditionalinfovatElementID = document.getElementById(RAadditionalinfovatid);
		if (RAadditionalinfovatElementID === null || RAadditionalinfovatElementID === undefined || RAadditionalinfovatElementID === '') {} else {
			RAadditionalinfovatres = doc.autoTableHtmlToJson(document.getElementById(RAadditionalinfovatid));
			doc.autoTable(RAadditionalinfovatres.columns, RAadditionalinfovatres.data, {
				margin: {
					left: 295
				},
				startY: shippingMethodEndPos + 40,
				pageBreak: 'avoid',
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15
				},
				tableWidth: 265
			});

		}

		// #endregion  Adding Additional Info

		// #endregion  Additional info    

		additionalInfoEndPos = doc.autoTableEndPosY();

		var orderRAGridPos = 0;

		if (shippingInstEndPos > additionalInfoEndPos) {
			orderRAGridPos = shippingInstEndPos;
		} else {
			orderRAGridPos = additionalInfoEndPos;
		}

		// #region Adding Item Grid 

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 20
					//  bottom: 320
				},
				startY: orderRAGridPos + 15,
				pageBreak: 'auto',
				// afterPageContent: Gridfooter,
				styles: {
					overflow: 'linebreak',
					columnWidth: 'wrap',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				columnStyles: {
					0: {
						overflow: 'linebreak'
					},
					2: {
						columnWidth: 'auto'
					}
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.columnWidth = 'auto';
					row.cells[3].styles.halign = 'right';
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {

					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 4) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		var itemgridendpos = doc.autoTableEndPosY();

		// #endregion Adding Item Grid

		// #region Adding Price Calculation Grid

		var totalPriceEndPos = 0;

		var totalpriceElementID = document.getElementById(totpriceid);
		if (totalpriceElementID === null || totalpriceElementID === undefined || totalpriceElementID === '') {

		} else {
			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			var totalpriceoptions = {
				margin: {
					left: 367
					// bottom: 320
				},
				startY: itemgridendpos + 1,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: Gridfooter1,
				styles: {
					//fillStyle: 'DF',
					//lineColor: [165, 164, 164],
					//lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 16
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				drawHeaderRow: function (row, data) {
					row.cells[1].styles.halign = 'right';
					row.cells[0].styles.fontStyle = 'bold';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 1) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 0) {
						//  cell.styles.halign = 'left';
						cell.styles.fontStyle = 'bold';
					}

					if (data.column.dataKey == 2) {
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 3) {
						cell.styles.fontStyle = 'bold';
					}
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
			totalPriceEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Price Calculation Grid

		// #region Price Display 

		var RAPriceDisplayidElementID = document.getElementById(RAPriceDisplayid);
		if (RAPriceDisplayidElementID === null || RAPriceDisplayidElementID === undefined || RAPriceDisplayidElementID === '') {

		} else {
			RAPriceDisplayres = doc.autoTableHtmlToJson(document.getElementById(RAPriceDisplayid));
			doc.autoTable(RAPriceDisplayres.columns, RAPriceDisplayres.data, {
				margin: {
					left: 20
				},
				startY: doc.autoTableEndPosY() + 15,
				pageBreak: 'auto',
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				}
			});
		}

		var itemgridendpos = doc.autoTableEndPosY();

		// #endregion  Price Display

		doc.setFontStyle('normal');
		doc.setFontSize(9);
		returuncenteredText('INVOICE TOTAL INCLUDES VAT @ 20% VAT GB 801 6773 39  Thank you for shopping with Rejel Automotive Ltd.', 818);

		if (j == data.length - 1) {
			//var status = X247Orders.moveOrderStage(data,6,doc);
			if (data.length >= 101) {
				var filename = 'invoice_' + new Date().getTime().toString().substring(0, 10) + ".pdf";
				doc.save(filename);
			}
			else{
				var blob = doc.output("blob");
				if (window.navigator && window.navigator.msSaveOrOpenBlob) {
				  window.navigator.msSaveOrOpenBlob(blob);
				}
				else {
				  var objectUrl = URL.createObjectURL(blob);
				  window.open(objectUrl);
				}
			}
		} else {
			doc.addPage();
		}
	}
}