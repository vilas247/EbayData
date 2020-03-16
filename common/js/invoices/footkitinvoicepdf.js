function FootKitInvoicePDF(data,iHCTemplate) {
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
		var options = {
			margin: {
				top: 20
			}
		};

		var deliveryid = "FKdeliveryvat_ppi";
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

		var billingid = "FKBilling_ppi";
		var billingres = '';
		
		$('#fkinvoicetoname_ppi').text(return_address.Name);
		$('#fkinvoicetoaddress1_ppi').text(return_address.Address1);
		$('#fkinvoicetoaddress2_ppi').text(return_address.Address2);
		$('#fkinvoicetocity_ppi').text(return_address.City);
		$('#fkinvoicetostateorregion_ppi').text(return_address.StateOrRegion);
		$('#fkinvoicetopostcode_ppi').text(return_address.PostCode);
		$('#fkinvoicetocountryname_ppi').text(return_address.CountryName);

		var shippingid = "FKShippingAddr_ppi";
		var shippingres = '';
		
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

		var hcpaymentmethodid = "FKpaymentmethod_ppi";
		var hcpaymentmethodres = '';
		
		$('#paymentmethod_ppi').text(data[j].paymentmethod);

		var FKshippinginsid = "FKshippinginst_ppi";
		var FKshippinginsres = '';

		var additionalinfoid = "FKadditionalinfo_ppi";
		var additionalinfores = '';

		var childid = "FKorder_ppi";
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
		
		var hcshippingmethodid = "FKshippingmethod_ppi";
		var hcshippingmethodres = '';
		
		$('#shippingservice_ppi').text(shipping_service);

		var totpriceid = "FKtotalprice_ppi";
		var totpriceres = '';
		
		$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
		$('#totalshipping_ppi').text(X247Invoices.Fredricksubtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		$('#vatprice_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));

		var returnaddressid = "FKReturn_ppi";
		var returnaddressres = '';

		var newid = "hcnewvat_ppi";
		var newres = '';

		var recborderid = "FKrecborder_ppi";
		var recborderres = '';

		var slipaddrid = "FKSlipAddr_ppi";
		var slipaddrres = '';
		
		$('#fkshipname_ppi').text(ship_address.Name);
		$('#fkshipaddress1ppi').text(ship_address.Address1);
		$('#fkshipaddress2ppi').text(ship_address.Address2);
		$('#fkshipcity_ppi').text(ship_address.City);
		$('#fkshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#fkshippostcode_ppi').text(ship_address.PostCode);
		$('#fkshipcountryname_ppi').text(ship_address.CountryName);

		var channelpos = 30;

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

		if (iHCTemplate == 1) {
			doc.addImage(X247Invoices.FKLogo, 'JPEG', 20, 10, 250, 57); // Image Center
			doc.setFontType("bold");
			doc.setFontSize(12);
			doc.text("Footkit", 25, 92);
		}
		if (iHCTemplate == 2) {
			doc.addImage(X247Invoices.PKLogo, 'JPEG', 20, 10, 250, 57); // Image Center
			doc.setFontType("bold");
			doc.setFontSize(12);
			doc.text("PERFECT FIT MENS", 25, 92);
		}


		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("Invoice Date:", 25, 107);
		Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 85, 107); //45           
		doc.text("Order Number :", 25, 122);
		doc.text(data[j].orderid, 95, 122); //60
		doc.setFontType("bold");
		doc.setFontSize(12);


		var shippingEndPos = 0;

		// #region Adding Shipping Address  

		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.setTextColor(128, 128, 128);
		doc.text("Shipping Summary", 35, 137);

		var yposordergrid = 132; // doc.autoTableEndPosY() + 30;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));


			var shippingoptions = {
				margin: {
					left: 20
				},
				startY: 142,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					overflow: 'linebreak',
					fontSize: 9,
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 250
			};

			doc.autoTable(shippingres.columns, shippingres.data, shippingoptions);
			shippingEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Shipping Address

		// #region  Adding Billing Address

		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.setTextColor(128, 128, 128);
		doc.text("Billing Summary", 305, 137);

		var billingElementID = document.getElementById(billingid);
		if (billingElementID === null || billingElementID === undefined || billingElementID === '') {} else {
			billingres = doc.autoTableHtmlToJson(document.getElementById(billingid));
			doc.autoTable(billingres.columns, billingres.data, {
				// startY: ipos,
				margin: {
					//  left: 320
					left: 295
				},
				startY: 142,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 9
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
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
					rowHeight: 15,
					fontSize: 9
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},

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
					rowHeight: 15,
					fontSize: 9
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
			});
		}

		// #endregion Payment Method

		// #region  Shipping Instructions

		var shippingInstEndPos = 0;
		var shippinginstElementID = document.getElementById(FKshippinginsid);
		if (shippinginstElementID === null || shippinginstElementID === undefined || shippinginstElementID === '') {} else {
			FKshippinginsres = doc.autoTableHtmlToJson(document.getElementById(FKshippinginsid));
			doc.autoTable(FKshippinginsres.columns, FKshippinginsres.data, {
				// startY: ipos,
				margin: {
					left: 20
				},
				startY: shippingMethodEndPos + 10,
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 9,
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
			});
			shippingInstEndPos = doc.autoTableEndPosY();
		}

		// #endregion  Shipping Instructions

		// #region Additional info

		var additionalInfoEndPos = 0;

		var additionalinfoElementID = document.getElementById(additionalinfoid);
		if (additionalinfoElementID === null || additionalinfoElementID === undefined || additionalinfoElementID === '') {} else {
			additionalinfores = doc.autoTableHtmlToJson(document.getElementById(additionalinfoid));
			doc.autoTable(additionalinfores.columns, additionalinfores.data, {
				// startY: ipos,
				margin: {
					// left: 320
					left: 295
				},
				startY: shippingMethodEndPos + 10,
				overflow: 'linebreak',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 9
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
			});
			additionalInfoEndPos = doc.autoTableEndPosY();
		}


		var itemgridPos = 0;
		if (shippingInstEndPos > additionalInfoEndPos) {
			itemgridPos = shippingInstEndPos;
		} else {
			itemgridPos = additionalInfoEndPos;
		}


		// #endregion  Additional info    

		// #region Adding Item Grid 

		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.setTextColor(128, 128, 128);
		doc.text("Item Summary", 35, itemgridPos + 15);

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 20,
					bottom: 320
				},
				startY: itemgridPos + 20, // shippingEndPos + 15,
				pageBreak: 'auto',
				// afterPageContent: Gridfooter,
				styles: {
					// overflow: 'linebreak',
					columnWidth: 'wrap',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					fontSize: 9
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
					row.cells[0].styles.columnWidth = 'auto';
					row.cells[3].styles.halign = 'right';
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						//  cell.styles.halign = 'left';
						// cell.styles.columnWidth = 'auto';
						// cell.styles.overflow = 'linebreak';
						cell.styles.fontStyle = 'bold';
					}

					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 4) {
						cell.styles.halign = 'right';
					}
				},
				columnStyles: {
					0: {
						overflow: 'linebreak'
					},
					2: {
						columnWidth: 'auto'
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
					left: 367,
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
					fontSize: 9,
					overflow: 'linebreak',
					rowHeight: 14,
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 9,
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
						cell.styles.fontStyle = 'bold';
					}

					if (data.column.dataKey == 2) {
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 3) {
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 4) {
						cell.styles.fontStyle = 'bold';
					}
					if (data.row.index == 4) {
						cell.styles.fontStyle = 'bold';
					}
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
			totalPriceEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Price Calculation Grid

		doc.setFontType("normal");
		doc.setFontSize(9);
		//  doc.text("Thank you for shopping with Perfect Fit Mens", 25, totalPriceEndPos + 10);
		doc.text("VAT Number: GB 439 061 354", 430, totalPriceEndPos + 10);

		if (iHCTemplate == 1) {
			doc.setFontType("normal");
			doc.setFontSize(9);
			doc.text("Thank you for shopping with Footkit", 25, totalPriceEndPos + 10);
		}
		if (iHCTemplate == 2) {
			doc.setFontType("normal");
			doc.setFontSize(9);
			doc.text("Thank you for shopping with Perfect Fit Mens", 25, totalPriceEndPos + 10);
		}


		var hcrElementID = document.getElementById(returnaddressid);
		if (hcrElementID === null || hcrElementID === undefined || hcrElementID === '') {

		} else {
			returnaddressres = doc.autoTableHtmlToJson(document.getElementById(returnaddressid));
			doc.autoTable(returnaddressres.columns, returnaddressres.data, {
				margin: {
					left: 20
				},
				// startY: 625,
				startY: totalPriceEndPos + 20,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fontSize: 9,
					fontStyle: 'normal',
					rowHeight: 14,
					overflow: 'linebreak'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 9,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				createdCell: function (cell, data) {
					if (data.row.index === 1) {
						cell.styles.fontStyle = 'bold';
					}
				}
			});
		}


		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 25, doc.autoTableEndPosY() + 5);
		doc.text("Return Slip", 30, doc.autoTableEndPosY() + 20);
		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("Reason for return:", 30, doc.autoTableEndPosY() + 40);

		doc.rect(30, doc.autoTableEndPosY() + 60, 35, 10);
		doc.text("Too big", 67, doc.autoTableEndPosY() + 68);
		doc.rect(30, doc.autoTableEndPosY() + 70, 35, 10)
		doc.text("Too small", 67, doc.autoTableEndPosY() + 78);
		doc.rect(30, doc.autoTableEndPosY() + 80, 35, 10)
		doc.text("Wrong colour", 67, doc.autoTableEndPosY() + 88);

		doc.rect(150, doc.autoTableEndPosY() + 60, 35, 10);
		doc.text("Not as expected", 187, doc.autoTableEndPosY() + 68);
		doc.rect(150, doc.autoTableEndPosY() + 70, 35, 10)
		doc.text("Defective", 187, doc.autoTableEndPosY() + 78);
		doc.rect(150, doc.autoTableEndPosY() + 80, 35, 10)
		doc.text("Other", 187, doc.autoTableEndPosY() + 88);

		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("If other please describe ____________________________", 30, doc.autoTableEndPosY() + 100);

		doc.text("Would you prefer a refund or exchange?", 30, doc.autoTableEndPosY() + 120);

		doc.rect(30, doc.autoTableEndPosY() + 125, 35, 10);
		doc.text("Refund", 67, doc.autoTableEndPosY() + 133);
		doc.rect(30, doc.autoTableEndPosY() + 135, 35, 10)
		doc.text("Exchange", 67, doc.autoTableEndPosY() + 143);

		doc.text("If you would like an exchange what would you like it exchanging for?", 30, doc.autoTableEndPosY() + 163);

		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("Order Number:", 280, doc.autoTableEndPosY() + 20);
		doc.text(data[j].orderid, 355, doc.autoTableEndPosY() + 20);
		doc.text("Invoice Date:", 280, doc.autoTableEndPosY() + 35);
		doc.text(Spurchasedate, 355, doc.autoTableEndPosY() + 35); //45     
		doc.text("Buyer Address:", 280, doc.autoTableEndPosY() + 50);

		// #region Adding Slip Address

		var slipElementID = document.getElementById(slipaddrid);
		if (slipElementID === null || slipElementID === undefined || slipElementID === '') {

		} else {
			slipaddrres = doc.autoTableHtmlToJson(document.getElementById(slipaddrid));
			var slipoptions = {
				margin: {
					left: 275
				},
				startY: doc.autoTableEndPosY() + 55,
				pageBreak: 'auto',
				theme: 'plain',
				styles: {
					rowHeight: 13,
					overflow: 'linebreak',
					fontSize: 9,
				},
				tableWidth: 250
			};

			doc.autoTable(slipaddrres.columns, slipaddrres.data, slipoptions);
		}

		// #endregion Adding Slip Address


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