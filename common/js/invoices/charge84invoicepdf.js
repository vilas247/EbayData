function Charing84InvoicePDF(data) {

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

		var centeredText = function (text, y, fsize, ftype) {
			doc.setFontSize(fsize);
			if (ftype === 'N') {
				doc.setFontType("normal");
			} else {
				doc.setFontType("bold");
			}
			doc.setTextColor(0, 0, 0);
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.text(textOffset, y, text);
		};


		var Charcompanyid = "Char_companyaddr_ppi";
		var Charcompanyres = '';

		var Charreturnid = "Char_returnaddr_ppi";
		var Charreturnidres = '';

		var Charcorderid = "Charcorder_ppi";
		var Charcorderres = '';
		
		/* orders data */
			var multiple_orders = {};
			var multiple_orders_items = '';
			
			if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Quantity']+"</span></td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span><p>"+X247Invoices.testempty+"</p><p>SKU: "+multiple_orders[jm]['Sku']+"</p><p>"+X247Invoices.testempty+"</p><p>"+X247Invoices.testempty+"</p><p>ISBN:<div>"+multiple_orders[jm]['ASIN']+"</div></p></td><td></td><td>Very Good</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
			
			$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var Chartotalpricevatid = "Chartotalpricevat_ppi";
		var Chartotalpricevatres = '';
		
		$('#totalprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		$('#totalshipping_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

		var CharNotesid = "CharNotes_ppi";
		var CharNotesres = '';

		var BOStampBoxid = "CharStampBox_ppi";
		var BOStampBoxres = '';

		var BOSPLabelAddrvatid = "CharSPLabelAddrvat_ppi";
		var BOSPLabelAddrvatres = '';
		
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

		var BOreturnaddressvatid = "Charreturnaddressvat_ppi";
		var BOreturnaddressvatres = '';
		
		$('#chshipname_ppi').text(ship_address.Name);
		$('#chshipaddress1ppi').text(ship_address.Address1);
		$('#chshipaddress2ppi').text(ship_address.Address2);
		$('#chshipcity_ppi').text(ship_address.City);
		$('#chshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#chshippostcode_ppi').text(ship_address.PostCode);
		$('#chshipcountryname_ppi').text(ship_address.CountryName);

		var BOSPAddrvatid = "BOSPAddrvat_ppi";
		var BOSPAddrvatres = '';
		
		$('#chsshipname_ppi').text(ship_address.Name);
		$('#chsshipaddress1ppi').text(ship_address.Address1);
		$('#chsshipaddress2ppi').text(ship_address.Address2);
		$('#chsshipcity_ppi').text(ship_address.Xity);
		$('#chsshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#chsshippostcode_ppi').text(ship_address.PostCode);
		$('#chsshipcountryname_ppi').text(ship_address.CountryName);

		var newid = "Charnewvat_ppi";
		var newres = '';
		var startpos = 29;

		// #region Company Address

		var CharcompanytxtID = document.getElementById(Charcompanyid);
		if (CharcompanytxtID === null || CharcompanytxtID === undefined || CharcompanytxtID === '') {

		} else {
			Charcompanyres = doc.autoTableHtmlToJson(document.getElementById(Charcompanyid));
			doc.autoTable(Charcompanyres.columns, Charcompanyres.data, {
				margin: {
					left: 25
				},
				startY: 28,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 14,
					fontSize: 10
				},
				tableWidth: 210
			});
		}

		// #endregion Company Address

		// #region Company Return Address

		var CharreturntxtID = document.getElementById(Charreturnid);
		if (CharreturntxtID === null || CharreturntxtID === undefined || CharreturntxtID === '') {

		} else {
			Charreturnidres = doc.autoTableHtmlToJson(document.getElementById(Charreturnid));
			doc.autoTable(Charreturnidres.columns, Charreturnidres.data, {
				margin: {
					left: 255
				},
				startY: 28,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 12,
					fontSize: 8
				},
				tableWidth: 210
			});
		}

		// #endregion Company Return Address

		// #region Customer Address

		var BOSPLabelAddrvatElementID = document.getElementById(BOSPLabelAddrvatid);
		if (BOSPLabelAddrvatElementID === null || BOSPLabelAddrvatElementID === undefined || BOSPLabelAddrvatElementID === '') {

		} else {
			BOSPLabelAddrvatres = doc.autoTableHtmlToJson(document.getElementById(BOSPLabelAddrvatid));
			doc.autoTable(BOSPLabelAddrvatres.columns, BOSPLabelAddrvatres.data, {
				margin: {
					left: 255
				},
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 11,
					overflow: 'linebreak',
					fontStyle: 'normal',
					columnWidth: 'wrap',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 11,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 230 //250
			});
		}

		// #endregion Customer Address

		// #region Bar code Image

		var boImage = $('#CharbarImagevat_' + j).attr("src");
		if (typeof boImage != 'undefined' && boImage !== '' && boImage != null) {
			doc.addImage(boImage, 'JPEG', 255, doc.autoTableEndPosY() + 10, 150, 82);
		}

		// #endregion Bar code Image


		if (typeof X247Invoices.CharRMPPL !== 'undefined' && X247Invoices.CharRMPPL != null && X247Invoices.CharRMPPL !== '') {
			doc.addImage(X247Invoices.CharRMPPL, 'JPEG', 365, 28, 204, 60);
		}


		doc.setFontType("bold");
		doc.setFontSize(8);
		doc.text('POSTAGE PAID GB', 490, 70);
		doc.text('HQ16801', 490, 80);

		doc.setFontStyle('normal');
		doc.setFontSize(9);
		doc.text("___________________________________________________________________________________________________________", 30, doc.autoTableEndPosY() + 92); // 102

		doc.setFontStyle('bold');
		doc.setFontSize(12);
		doc.text("Marketplace: ", 30, doc.autoTableEndPosY() + 112);
		doc.text("Order Number: ", 30, doc.autoTableEndPosY() + 132);
		doc.text("Ship Method: ", 30, doc.autoTableEndPosY() + 152);
		doc.text("Customer Name: ", 30, doc.autoTableEndPosY() + 172);
		doc.text("Order Date: ", 30, doc.autoTableEndPosY() + 192);
		doc.text("Marketplace Order #: ", 30, doc.autoTableEndPosY() + 212);
		doc.text("Email: ", 30, doc.autoTableEndPosY() + 232);

		doc.setFontStyle('normal');
		doc.setFontSize(12);
		if (typeof data[j].saleschannel != 'undefined' && data[j].saleschannel !== '' && data[j].saleschannel != null) {
			doc.text(data[j].saleschannel, 255, doc.autoTableEndPosY() + 112);
		}
		doc.text(data[j].orderid, 255, doc.autoTableEndPosY() + 132);

		var ryShipping = '';
		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService === 'undefined') {
				ryShipping = "standard";
			} else {
				ryShipping = data[j].orderitems[0].ShippingService;
			}
		}

		doc.text(ryShipping, 255, doc.autoTableEndPosY() + 152);

		if (typeof data[j].shippingaddresses[0].Name != 'undefined') {
			doc.text(data[j].shippingaddresses[0].Name, 255, doc.autoTableEndPosY() + 172);
		}

		Spurchasedate = '';
		Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 255, doc.autoTableEndPosY() + 192);

		doc.text(data[j].orderid, 255, doc.autoTableEndPosY() + 212);

		if (typeof data[j].shippingaddresses[0].Email != 'undefined' && data[j].shippingaddresses[0].Email != '' && data[j].shippingaddresses[0].Email != null) {
			doc.text(data[j].shippingaddresses[0].Email, 255, doc.autoTableEndPosY() + 232);
		}


		doc.setFontStyle('normal');
		doc.setFontSize(9);
		doc.text("___________________________________________________________________________________________________________", 30, doc.autoTableEndPosY() + 242);
		doc.setFontStyle('bold');
		doc.setFontSize(12);
		doc.text("Items: ", 30, doc.autoTableEndPosY() + 262);

		// #region Items Details Grid

		var CharcorderElementID = document.getElementById(Charcorderid);
		if (CharcorderElementID === null || CharcorderElementID === undefined || CharcorderElementID === '') {

		} else {
			Charcorderres = doc.autoTableHtmlToJson(document.getElementById(Charcorderid));
			doc.autoTable(Charcorderres.columns, Charcorderres.data, {
				margin: {
					left: 25
				},
				startY: doc.autoTableEndPosY() + 272,
				pageBreak: 'auto',
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
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 4) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		// #endregion Items Details Grid

		// #region Items Total Calculation Grid

		var ChartotalpricevatElementID = document.getElementById(Chartotalpricevatid);
		if (ChartotalpricevatElementID === null || ChartotalpricevatElementID === undefined || ChartotalpricevatElementID === '') {

		} else {
			Chartotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(Chartotalpricevatid));

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

			doc.autoTable(Chartotalpricevatres.columns, Chartotalpricevatres.data, totalpriceoptions);
		}

		// #endregion Items Total Calculation Grid

		// #region Buyer Message

		doc.setFontStyle('bold');
		doc.setFontSize(12);
		doc.text("Notes: ", 30, doc.autoTableEndPosY() + 10);

		var CharNotesElementID = document.getElementById(CharNotesid);
		if (CharNotesElementID === null || CharNotesElementID === undefined || CharNotesElementID === '') {

		} else {
			CharNotesres = doc.autoTableHtmlToJson(document.getElementById(CharNotesid));
			doc.autoTable(CharNotesres.columns, CharNotesres.data, {
				margin: {
					left: 25
				},
				startY: doc.autoTableEndPosY() + 20,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 11,
					overflow: 'linebreak',
					fontStyle: 'normal',
					columnWidth: 'wrap',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 11,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				tableWidth: 230 //250
			});
		}

		// #endregion Buyer Message

		// #region Footer

		centeredText("Thanks for your order!", doc.autoTableEndPosY() + 10, 12, 'B');
		centeredText("If you have any questions or concerns regarding this order, please contact us at m.guida@ntlworld.com", doc.autoTableEndPosY() + 25, 10, 'N');

		//centeredText("Thanks for your order!",10, 12, 'B');
		//centeredText("If you have any questions or concerns regarding this order, please contact us at m.guida@ntlworld.com",20, 10, 'N');

		// #endregion Footer

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