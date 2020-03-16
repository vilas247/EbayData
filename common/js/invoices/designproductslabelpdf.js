function DesignProductsLabelPDF(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 29
			}
		};

		var centeredText = function (text, y, fsize) {
			doc.setFontSize(fsize);
			doc.setTextColor(0, 0, 0);
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.text(textOffset, y, text);
		};

		var DPcompanyid = "DP_companyaddr_ppi";
		var DPcompanyres = '';

		var DPStampBoxid = "DPStampBox_ppi";
		var DPStampBoxres = '';

		var DPreturnaddressvatid = "DPreturnaddressvat_ppi";
		var DPreturnaddressvatres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1ppi').text(ship_address.Address1);
			$('#shipaddress2ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
		/* Ship address end */

		var DPSPAddrvatid = "DPSPAddrvat_ppi";
		var DPSPAddrvatres = '';
		
		$('#dpshipname_ppi').text(ship_address.Name);
		$('#dpshipaddress1ppi').text(ship_address.Address1);
		$('#dpshipaddress2ppi').text(ship_address.Address2);
		$('#dpshipcity_ppi').text(ship_address.City);
		$('#dpshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#dpshippostcode_ppi').text(ship_address.PostCode);
		$('#dpshipcountryname_ppi').text(ship_address.CountryName);
		$('#dpshipphone_ppi').text(ship_address.Phone);
		$('#dpshipemail_ppi').text(ship_address.Email);

		var DPcorderid = "DPcorder_ppi";
		var DPcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var DPtotalpricevatid = "DPtotalpricevat_ppi";
		var DPtotalpricevatres = '';
		
		$('#totalprice_ppi').text(X247Invoices.subtotalunitPrice(j,data[j].orderitems));
		$('#vatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		$('#shippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

		var DPtotalpricelabelvatid = "DPtotalpricelabelvat_ppi";
		var DPtotalpricelabelvatres = '';
		
		$('#dptotalprice_ppi').text(X247Invoices.subtotalunitPrice(j,data[j].orderitems));
		$('#dpvatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		$('#dpshippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#dpgrandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

		var DPSPLabelAddrvatid = "DPSPLabelAddrvat_ppi";
		var DPSPLabelAddrvat = '';
		
		$('#dpsshipname_ppi').text(ship_address.Name);
		$('#dpsshipaddress1ppi').text(ship_address.Address1);
		$('#dpsshipaddress2ppi').text(ship_address.Address2);
		$('#dpsshipcity_ppi').text(ship_address.City);
		$('#dpsshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#dpsshippostcode_ppi').text(ship_address.PostCode);
		$('#dpsshipcountryname_ppi').text(ship_address.CountryName);
		$('#dpsshipphone_ppi').text(ship_address.Phone);
		$('#dpsshipemail_ppi').text(ship_address.Email);

		var newid = "DPnewvat_ppi";
		var newres = '';
		var startpos = 29;


		// #region PPL Stamp  

		var DPPPLStampElementID = document.getElementById(DPStampBoxid);
		if (DPPPLStampElementID === null || DPPPLStampElementID === undefined || DPPPLStampElementID === '') {

		} else {

			DPStampBoxres = doc.autoTableHtmlToJson(document.getElementById(DPStampBoxid));

			doc.autoTable(DPStampBoxres.columns, DPStampBoxres.data, {
				margin: {
					left: 28
				},
				startY: 28,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 255,
					fontSize: 9
				},
				tableWidth: 567
			});
		}

		doc.addImage(X247Invoices.RM1PPLStamp, 'JPEG', 35, 35, 190, 50);
		doc.setFontType("normal");
		doc.setFontSize(7);
		doc.text('POSTAGE PAID GB', 155, 71);
		doc.text('BLACKBURN22586', 155, 81);

		var DPSPLabelAddrvatElementID = document.getElementById(DPSPLabelAddrvatid);
		if (DPSPLabelAddrvatElementID === null || DPSPLabelAddrvatElementID === undefined || DPSPLabelAddrvatElementID === '') {

		} else {
			DPSPLabelAddrvatres = doc.autoTableHtmlToJson(document.getElementById(DPSPLabelAddrvatid));
			doc.autoTable(DPSPLabelAddrvatres.columns, DPSPLabelAddrvatres.data, {
				margin: {
					left: 30
				},
				startY: 105,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 20,
					fontSize: 12
				},
				tableWidth: 230
			});
		}

		doc.setFontType("normal");
		doc.setFontSize(7);
		doc.text('Direct Products (UK) Limited', 320, 220);
		doc.text('15 Deanfield Court, Clitheroe, BB7 IQS', 320, 235);

		// #endregion PPL Stamp

		// #region Company Logo 

		doc.addImage(X247Invoices.DPLogo, 'JPEG', 45, 298, 275, 47);

		// #endregion Company Logo

		// #region Store and Order Reference

		var KMOSPEmail = '';
		if (data[j].shippingaddresses[0].Email != 'undefined' && data[j].shippingaddresses[0].Email !== '' && data[j].shippingaddresses[0].Email != null) {
			KMOSPEmail = data[j].shippingaddresses[0].Email;
		}

		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text('Store ID:', 35, 360);
		doc.text('Invoice Number:', 35, 375);
		doc.text(KMOSPEmail, 80, 360);
		doc.text(data[j].orderid, 115, 375);


		if (data[j].marketplacecode == 1) {
			doc.text('eBay ID:', 35, 390);
			if (typeof data[j].ebaybuyerid != 'undefined' && data[j].ebaybuyerid != '' && data[j].ebaybuyerid != null) {
				doc.text(data[j].ebaybuyerid, 75, 390);
			}
		} else {
			doc.text('Order Reference:', 35, 390);
			doc.text(data[j].orderid, 115, 390);
		}

		doc.text('Order Date:', 325, 375);
		doc.text('Order Number:', 325, 390);

		var pdate = data[j].purchasedate;
		doc.text(pdate, 375, 375);
		doc.text(data[j].orderid, 385, 390);


		// #endregion Store and Order Reference

		// #region Items Details Grid

		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text('Item Summary', 35, 415);

		var DPOrderElementID = document.getElementById(DPcorderid);
		if (DPOrderElementID === null || DPOrderElementID === undefined || DPOrderElementID === '') {

		} else {
			DPcorderres = doc.autoTableHtmlToJson(document.getElementById(DPcorderid));
			doc.autoTable(DPcorderres.columns, DPcorderres.data, {
				margin: {
					left: 30
				},
				startY: 425,
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
				},
				drawHeaderRow: function (row, data) {
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

		// #endregion Items Details Grid

		// #region Items Total Calculation Grid

		var DPtotalpriceElementID = document.getElementById(DPtotalpricelabelvatid);
		if (DPtotalpriceElementID === null || DPtotalpriceElementID === undefined || DPtotalpriceElementID === '') {

		} else {
			DPtotalpricelabelvatres = doc.autoTableHtmlToJson(document.getElementById(DPtotalpricelabelvatid));

			var totalpriceoptions = {
				margin: {
					left: 367
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak'
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

			doc.autoTable(DPtotalpricelabelvatres.columns, DPtotalpricelabelvatres.data, totalpriceoptions);
		}

		// #endregion Items Total Calculation Grid

		// #region Footer Text

		doc.setFontType("bold");
		doc.setFontSize(9);

		doc.text(X247Invoices.KMOSPEmail, 35, doc.autoTableEndPosY() + 15);
		doc.setFontType("normal");
		doc.setFontSize(10);
		doc.text('Direct Products (UK) Limited 07766 555 356 Registered in England and Wales No, 4433689, VAT No, GB 693 247 312', 35, doc.autoTableEndPosY() + 30);
		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text('Did you know you can now visit our website. www.directproducts.co.uk', 35, doc.autoTableEndPosY() + 45);
		doc.text('For the latest updates please follow us at: Facebook - Direct products Twitter - D_ProductsUK', 35, doc.autoTableEndPosY() + 60);

		// #endregion Footer Text

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
			var newElementID = document.getElementById(newid);
			if (newElementID === null || newElementID === undefined || newElementID === '') {

			} else {
				doc.addPage();
			}
		}
	}
}function DesignProductsInvoicePDF(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 29
			}
		};

		var centeredText = function (text, y, fsize) {
			doc.setFontSize(fsize);
			doc.setTextColor(0, 0, 0);
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			// doc.setFont("helvetica");


			doc.text(textOffset, y, text);
		};

		var DPcompanyid = "DP_companyaddr_ppi";
		var DPcompanyres = '';

		var DPStampBoxid = "DPStampBox_ppi";
		var DPStampBoxres = '';

		var DPreturnaddressvatid = "DPreturnaddressvat_ppi";
		var DPreturnaddressvatres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1ppi').text(ship_address.Address1);
			$('#shipaddress2ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
		/* Ship address end */

		var DPSPAddrvatid = "DPSPAddrvat_ppi";
		var DPSPAddrvatres = '';
		
		$('#dpshipname_ppi').text(ship_address.Name);
		$('#dpshipaddress1ppi').text(ship_address.Address1);
		$('#dpshipaddress2ppi').text(ship_address.Address2);
		$('#dpshipcity_ppi').text(ship_address.City);
		$('#dpshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#dpshippostcode_ppi').text(ship_address.PostCode);
		$('#dpshipcountryname_ppi').text(ship_address.CountryName);
		$('#dpshipphone_ppi').text(ship_address.Phone);
		$('#dpshipemail_ppi').text(ship_address.Email);

		var DPcorderid = "DPcorder_ppi";
		var DPcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var DPtotalpricevatid = "DPtotalpricevat_ppi";
		var DPtotalpricevatres = '';
		
		$('#totalprice_ppi').text(X247Invoices.subtotalunitPrice(j,data[j].orderitems));
		$('#vatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		$('#shippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

		var newid = "DPnewvat_ppi";
		var newres = '';
		var startpos = 29;


		// #region Invoice Number

		centeredText(data[j].orderid, 25, 14);

		// #endregion Invoice Number

		// #region Company Address

		var DPcompanyElementID = document.getElementById(DPcompanyid);
		if (DPcompanyElementID === null || DPcompanyElementID === undefined || DPcompanyElementID === '') {

		} else {
			DPcompanyres = doc.autoTableHtmlToJson(document.getElementById(DPcompanyid));
			doc.autoTable(DPcompanyres.columns, DPcompanyres.data, {
				margin: {
					left: 10
				},
				startY: 30,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 9,
					overflow: 'linebreak',
					fontStyle: 'normal',
					columnWidth: 'wrap'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 9,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 250
			});


		}

		// #endregion Company Address

		var CompanyAddressPos = doc.autoTableEndPosY() + 15;

		var KMOStampBoxElementID = document.getElementById(DPStampBoxid);
		if (KMOStampBoxElementID === null || KMOStampBoxElementID === undefined || KMOStampBoxElementID === '') {

		} else {

			DPStampBoxres = doc.autoTableHtmlToJson(document.getElementById(DPStampBoxid));

			doc.autoTable(DPStampBoxres.columns, DPStampBoxres.data, {
				margin: {
					left: 15
				},
				startY: doc.autoTableEndPosY() + 5,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 15,
					fontSize: 9,
					fillColor: [128, 128, 128],
					textColor: [0, 0, 0]
				},
				tableWidth: 260
			});
		}

		var DPStampBoxElementID = document.getElementById(DPStampBoxid);
		if (DPStampBoxElementID === null || DPStampBoxElementID === undefined || DPStampBoxElementID === '') {

		} else {

			DPStampBoxres = doc.autoTableHtmlToJson(document.getElementById(DPStampBoxid));

			doc.autoTable(DPStampBoxres.columns, DPStampBoxres.data, {
				margin: {
					left: 290
				},
				startY: CompanyAddressPos - 10,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					//  rowHeight: 155,
					rowHeight: 15,
					fontSize: 9,
					fillColor: [128, 128, 128],
					//textColor: 255
					textColor: [0, 0, 0]
				},
				tableWidth: 260
			});
		}


		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.text('Shipping Summary', 25, CompanyAddressPos);
		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.text('Billing Summary', 310, CompanyAddressPos);
		doc.setFontType("normal");

		// #region Shipping Address

		var DPSPElementID = document.getElementById(DPSPAddrvatid);
		if (DPSPElementID === null || DPSPElementID === undefined || DPSPElementID === '') {

		} else {
			DPSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(DPSPAddrvatid));
			doc.autoTable(DPSPAddrvatres.columns, DPSPAddrvatres.data, {
				margin: {
					left: 25
				},
				startY: CompanyAddressPos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 16,
					fontSize: 9
				}
			});
		}

		// #endregion Shipping Address

		var SPAddressPos = doc.autoTableEndPosY() + 10;

		// #region Return Address

		var DPreturnaddresstxtID = document.getElementById(DPreturnaddressvatid);
		if (DPreturnaddresstxtID === null || DPreturnaddresstxtID === undefined || DPreturnaddresstxtID === '') {

		} else {
			DPreturnaddressvatres = doc.autoTableHtmlToJson(document.getElementById(DPreturnaddressvatid));
			doc.autoTable(DPreturnaddressvatres.columns, DPreturnaddressvatres.data, {
				//  margin: { left: 403 },
				margin: {
					left: 310
				},
				startY: CompanyAddressPos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 16,
					fontSize: 9
				}
			});
		}

		// #endregion return Address


		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text('Shipping Method', 25, SPAddressPos);
		doc.text('Payment Method', 310, SPAddressPos);
		doc.setFontType("normal");
		var KMOShippingMT = '';
		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService === 'undefined') {
				KMOShippingMT = "standard";
			} else {
				KMOShippingMT = data[j].orderitems[0].ShippingService;
			}
		}

		doc.text(KMOShippingMT, 25, SPAddressPos + 15);

		doc.setFontType("bold");
		doc.text('Shipping Instructions', 25, SPAddressPos + 30);
		doc.text('Additional Info', 310, SPAddressPos + 30);
		var KMOBMsg = '';
		if (data[j].buyermessage != 'undefined' && data[j].buyermessage !== '' && data[j].buyermessage != null) {
			KMOBMsg = data[j].buyermessage;
		}
		doc.setFontType("normal");
		doc.text(KMOBMsg, 25, SPAddressPos + 40);

		if (typeof data[j].paymentmethod !== undefined && data[j].paymentmethod !== null && data[j].paymentmethod !== '') {
			doc.text(data[j].paymentmethod, 310, SPAddressPos + 15);
		}

		doc.setFontType("bold");
		doc.text('Marketplace User:', 310, SPAddressPos + 60);
		doc.setFontType("normal");

		var KMObuyID = '';
		if (data[j].ebaybuyerid != 'undefined' && data[j].ebaybuyerid !== '' && data[j].ebaybuyerid != null) {
			KMObuyID = data[j].ebaybuyerid;
		}
		doc.text(KMObuyID, 310, SPAddressPos + 75);

		doc.setFontType("bold");
		doc.text('Marketplace e-mail:', 310, SPAddressPos + 90);
		doc.setFontType("normal");

		var KMOSPEmail = '';
		if (data[j].shippingaddresses[0].Email != 'undefined' && data[j].shippingaddresses[0].Email !== '' && data[j].shippingaddresses[0].Email != null) {
			KMOSPEmail = data[j].shippingaddresses[0].Email;
		}
		doc.text(KMOSPEmail, 310, SPAddressPos + 105);

		doc.setFontType("bold");
		doc.text('Item Summary:', 25, SPAddressPos + 115);

		// #region Items Details Grid

		var DPOrderElementID = document.getElementById(DPcorderid);
		if (DPOrderElementID === null || DPOrderElementID === undefined || DPOrderElementID === '') {

		} else {
			DPcorderres = doc.autoTableHtmlToJson(document.getElementById(DPcorderid));
			doc.autoTable(DPcorderres.columns, DPcorderres.data, {
				margin: {
					left: 25
				},
				startY: SPAddressPos + 125,
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
				},
				drawHeaderRow: function (row, data) {
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

		// #endregion Items Details Grid

		// #region Items Total Calculation Grid

		var DPtotalpriceElementID = document.getElementById(DPtotalpricevatid);
		if (DPtotalpriceElementID === null || DPtotalpriceElementID === undefined || DPtotalpriceElementID === '') {

		} else {
			DPtotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(DPtotalpricevatid));

			var totalpriceoptions = {
				margin: {
					left: 367
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak'
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

			doc.autoTable(DPtotalpricevatres.columns, DPtotalpricevatres.data, totalpriceoptions);
		}

		// #endregion Items Total Calculation Grid

		// #region Footer Text

		centeredText("Thank you for shopping with Direct Products", 839, 10);

		// #endregion Footer Text

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
			var newElementID = document.getElementById(newid);
			if (newElementID === null || newElementID === undefined || newElementID === '') {

			} else {
				doc.addPage();
			}
		}
	}
}