function KitmeoutInvoicePDF(data,KMOTemplateID) {

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


		var KMOcompanyid = "KMO_companyaddr_ppi";
		var KMOcompanyres = '';

		var KMOStampBoxid = "KMOStampBox_ppi";
		var KMOStampBoxres = '';

		var KMOreturnaddressvatid = "KMOreturnaddressvat_ppi";
		var KMOreturnaddressvatres = '';
		
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

		var kMOSPAddrvatid = "kMOSPAddrvat_ppi";
		var kMOSPAddrvatres = '';
		
		$('#kmshipname_ppi').text(ship_address.Name);
		$('#kmshipaddress1ppi').text(ship_address.Address1);
		$('#kmshipaddress2ppi').text(ship_address.Address2);
		$('#kmshipcity_ppi').text(ship_address.City);
		$('#kmshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#kmshippostcode_ppi').text(ship_address.PostCode);
		$('#kmshipcountryname_ppi').text(ship_address.CountryName);
		$('#kmshipphone_ppi').text(ship_address.Phone);

		var KMOcorderid = "KMOcorder_ppi";
		var KMOcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';

		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Quantity']+"</span></td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span><p>"+X247Invoices.testempty+"</p><p>SKU : "+multiple_orders[jm]['Sku']+"</p></td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var KMOtotalpricevatid = "KMOtotalpricevat_ppi";
		var KMOtotalpricevatres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var newid = "kmonew_ppi";
		var newres = '';
		var startpos = 29;


		// #region Company Logo

		doc.addImage(X247Invoices.KMOLogo, 'JPEG', 10, startpos, 235, 65);

		// #endregion Company Logo

		// #region Company Address
		var KMOcompanyElementID = document.getElementById(KMOcompanyid);
		if (KMOcompanyElementID === null || KMOcompanyElementID === undefined || KMOcompanyElementID === '') {

		} else {
			KMOcompanyres = doc.autoTableHtmlToJson(document.getElementById(KMOcompanyid));
			doc.autoTable(KMOcompanyres.columns, KMOcompanyres.data, {
				margin: {
					left: 10
				},
				startY: 99,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 14,
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
				tableWidth: 230
			});


		}

		// #endregion Company Address

		var companyendpos = doc.autoTableEndPosY() + 10;
		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text('Invoice Date :', 15, companyendpos + 15);
		doc.text('Order Number :', 15, companyendpos + 45);
		doc.setFontType("normal");
		doc.text(data[j].purchasedate, 15, companyendpos + 30);
		doc.text(data[j].orderid, 15, companyendpos + 60);

		// #region PPL Stamp  

		var KMOStampBoxElementID = document.getElementById(KMOStampBoxid);
		if (KMOStampBoxElementID === null || KMOStampBoxElementID === undefined || KMOStampBoxElementID === '') {

		} else {

			KMOStampBoxres = doc.autoTableHtmlToJson(document.getElementById(KMOStampBoxid));

			doc.autoTable(KMOStampBoxres.columns, KMOStampBoxres.data, {
				margin: {
					left: 252
				},
				startY: startpos,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					//  rowHeight: 155,
					rowHeight: 215,
					fontSize: 9
				},
				tableWidth: 330
			});


			// #region Universal Stamp


			if (KMOTemplateID == 0) {

				if (data[j].orderitems.length > 0) {
					if (typeof data[j].orderitems[0].ShippingService === 'undefined' || data[j].orderitems[0].ShippingService === '' || data[j].orderitems[0].ShippingService == null) {
						doc.addImage(X247Invoices.KMOSUKOnly, 'JPEG', 282, 32, 266, 56);
						doc.setFontSize(7);
						doc.setFontType("bold");
						doc.text('POSTAGE PAID GB', 480, 70);
						doc.text('HQ45150', 480, 80);
						doc.setFontType("normal");
					} else if (typeof data[j].orderitems[0].ShippingService === 'FR_StandardDeliveryFromAbroad' || typeof data[j].orderitems[0].ShippingService === 'IT_StandardDeliveryFromAbroad' || typeof data[j].orderitems[0].ShippingService === 'UK_SellersStandardInternationalRate') {
						doc.addImage(X247Invoices.KMOFCNUK, 'JPEG', 282, 32, 266, 56);
						doc.setFontSize(7);
						doc.setFontType("bold");
						doc.text('POSTAGE PAID GB', 480, 70);
						doc.text('HQ45150', 480, 80);
						doc.setFontType("normal");
					} else {
						doc.addImage(X247Invoices.KMOSUKOnly, 'JPEG', 282, 32, 266, 56);
						doc.setFontSize(7);
						doc.setFontType("bold");
						doc.text('POSTAGE PAID GB', 480, 70);
						doc.text('HQ45150', 480, 80);
						doc.setFontType("normal");
					}
				}
			}

			// #endregion Universal Stamp

			// #region Non UK PPL Stamp

			if (KMOTemplateID == 3) {

				doc.addImage(X247Invoices.KMOFCNUK, 'JPEG', 282, 32, 266, 56);
				doc.setFontSize(7);
				doc.setFontType("bold");
				doc.text('POSTAGE PAID GB', 480, 70);
				doc.text('HQ45150', 480, 80);
				doc.setFontType("normal");
			}

			// #endregion Non UK PPL Stamp

			// #region PPI First Class UK ONLY

			if (KMOTemplateID == 1) {

				doc.addImage(X247Invoices.KMOFUKOnly, 'JPEG', 282, 32, 266, 56);
				doc.setFontSize(7);
				doc.setFontType("bold");
				doc.text('POSTAGE PAID GB', 480, 70);
				doc.text('HQ45150', 480, 80);
				doc.setFontType("normal");
			}

			// #endregion PPI First Class UK ONLY

			// #region PPI Second Class UK ONLY

			if (KMOTemplateID == 2) {

				doc.addImage(X247Invoices.KMOSUKOnly, 'JPEG', 282, 32, 266, 56);
				doc.setFontSize(7);
				doc.setFontType("bold");
				doc.text('POSTAGE PAID GB', 480, 70);
				doc.text('HQ45150', 480, 80);
				doc.setFontType("normal");
			}

			// #endregion PPI Second Class UK ONLY

			// doc.addImage(KMOAirMail, 'JPEG', 275, 32, 275, 75);

			var KMOrtAddrElementID = document.getElementById(KMOreturnaddressvatid);
			if (KMOrtAddrElementID === null || KMOrtAddrElementID === undefined || KMOrtAddrElementID === '') {

			} else {
				KMOreturnaddressvatres = doc.autoTableHtmlToJson(document.getElementById(KMOreturnaddressvatid));
				doc.autoTable(KMOreturnaddressvatres.columns, KMOreturnaddressvatres.data, {
					margin: {
						left: 265
					},
					// startY: 110,
					startY: 108,
					pageBreak: 'auto',
					theme: 'plain',
					styles: {
						overflow: 'linebreak',
						// fontSize: 14,
						fontSize: 9,
						fontStyle: 'normal',
						rowHeight: 14
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						//  fontSize: 14,
						fontSize: 9,
						textColor: [0, 0, 0],
						fontStyle: 'bold'
					},
					bodyStyles: {
						fillColor: [255, 255, 255],
						textColor: [0, 0, 0]
					},
					tableWidth: 275
				});

				doc.setFontSize(9);
				doc.setFontType("normal");
				doc.text('If undelivered,please return to: Kit Me Out Online Limited,Unit 53', 265, doc.autoTableEndPosY() + 10);
				doc.text('Enterprise Trading Estate,Pedmore Road,Brierley Hill,West Midlands', 265, doc.autoTableEndPosY() + 22);
				doc.text('DY5 1TX,GB', 265, doc.autoTableEndPosY() + 34);
			}
		};


		// #endregion PPL Stamp

		// #region Shipping Address

		var kMOSPAddrvatid = "kMOSPAddrvat_ppi";
		var kMOSPAddrvatres = '';

		var KMOSPAddrElementID = document.getElementById(kMOSPAddrvatid);
		if (KMOSPAddrElementID === null || KMOSPAddrElementID === undefined || KMOSPAddrElementID === '') {

		} else {
			kMOSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(kMOSPAddrvatid));
			doc.autoTable(kMOSPAddrvatres.columns, kMOSPAddrvatres.data, {
				margin: {
					left: 10
				},
				startY: companyendpos + 75,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 14,
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
				tableWidth: 230
			});
		}

		// #endregion Shipping Address

		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text('Shipping Method', 265, companyendpos + 90);
		doc.text('Shipping Instructions', 265, companyendpos + 120);

		doc.setFontSize(9);
		doc.setFontType("normal");
		var KMOShippingMT = '';
		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService === 'undefined') {
				KMOShippingMT = "standard";
			} else {
				KMOShippingMT = data[j].orderitems[0].ShippingService;
			}
		}

		doc.text(KMOShippingMT, 265, companyendpos + 105);
		var KMOBMsg = '';
		if (data[j].buyermessage != 'undefined' && data[j].buyermessage !== '' && data[j].buyermessage != null) {
			KMOBMsg = data[j].buyermessage;
		}
		doc.text(KMOBMsg, 265, 135);
		doc.text('Marketplace User:', 265, companyendpos + 150);

		var KMObuyID = '';
		if (data[j].ebaybuyerid != 'undefined' && data[j].ebaybuyerid !== '' && data[j].ebaybuyerid != null) {
			KMObuyID = data[j].ebaybuyerid;
		}
		doc.text(KMObuyID, 265, companyendpos + 165);

		doc.text('Marketplace e-mail:', 265, companyendpos + 180);

		var KMOSPEmail = '';
		if (data[j].shippingaddresses[0].Email != 'undefined' && data[j].shippingaddresses[0].Email !== '' && data[j].shippingaddresses[0].Email != null) {
			KMOSPEmail = data[j].shippingaddresses[0].Email;
		}
		doc.text(KMOSPEmail, 265, companyendpos + 195);
		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text("Item Summary", 15, companyendpos + 215);
		doc.setFontSize(9);
		doc.setFontType("normal");

		// #region Items Details Grid

		var KMOOrderElementID = document.getElementById(KMOcorderid);
		if (KMOOrderElementID === null || KMOOrderElementID === undefined || KMOOrderElementID === '') {

		} else {
			KMOcorderres = doc.autoTableHtmlToJson(document.getElementById(KMOcorderid));
			doc.autoTable(KMOcorderres.columns, KMOcorderres.data, {
				margin: {
					left: 15
				},
				startY: companyendpos + 225,
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
					row.cells[2].styles.halign = 'right';
					row.cells[3].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 2) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		// #endregion Items Details Grid

		// #region Items Total Calculation Grid

		var KMOtotalpriceElementID = document.getElementById(KMOtotalpricevatid);
		if (KMOtotalpriceElementID === null || KMOtotalpriceElementID === undefined || KMOtotalpriceElementID === '') {

		} else {
			KMOtotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(KMOtotalpricevatid));

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

			doc.autoTable(KMOtotalpricevatres.columns, KMOtotalpricevatres.data, totalpriceoptions);
		}

		// #endregion Items Total Calculation Grid

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