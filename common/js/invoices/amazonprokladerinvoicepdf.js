function AmazonProKladerInvoicePDF(data) {

	var doc = new jsPDF('p', 'pt', 'a4');
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
		
		if (data[j].marketplacecode == 2) {
			var centeredText = function (text, y, fsize) {
				doc.setFontSize(fsize);
				doc.setTextColor(0, 0, 0);
				var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
				var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
				// doc.setFont("arial");
				doc.text(textOffset, y, text);
			};


			var PKStampBoxid = "PKStampBox_ppi";
			var PKStampBoxres = '';

			var DPSPAddrvatid = "PKSPAddrvat_ppi";
			var DPSPAddrvatres = '';
			
			/*Ship address */
				var ship_address = data[j]['shippingaddresses'][0];
				$('#shipname_ppi').text(ship_address.Name);
				$('#shipaddress1ppi').text(ship_address.Address1);
				$('#shipaddress2ppi').text(ship_address.Address2);
				$('#shipcity_ppi').text(ship_address.City);
				$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
				$('#shippostcode_ppi').text(ship_address.PostCode);
				$('#shipcountryname_ppi').text(ship_address.CountryName);
				$('#shipphone_ppi').text(ship_address.Phone);
				$('#shipemail_ppi').text(ship_address.Email);
			/* Ship address end */

			var DPcorderid = "PKcorder_ppi";
			var DPcorderres = '';
			
			/* orders data */
				var multiple_orders = {};
				var multiple_orders_items = '';
				
				if(data[j]['orderitems'].length > 0){
					multiple_orders = data[j]['orderitems'];
					for (var jm = 0; jm < multiple_orders.length; jm++) {
						multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Ean']+"</span></td><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td></tr>";
					}
				}
				
				$('#multipleorders_ppi').html(multiple_orders_items);
			/* orders data end */

			var DPtotalpricevatid = "PKtotalpricevat_ppi";
			var DPtotalpricevatres = '';
			
			$('#vatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
			$('#shippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));
			

			var newid = "PKnewvat_ppi";
			var newres = '';

			var startpos = 29;

			// #region Company Logo

			doc.addImage(X247Invoices.PKLogo, 'JPEG', 30, 30, 300, 75);

			doc.setFontType("bold");
			doc.setFontSize(23);
			doc.text('INVOICE', 435, 60);

			// #endregion Company Logo

			// #region Purchase Date

			doc.addImage(X247Invoices.greybar, 'JPEG', 25, 113, 532, 20);
			doc.setFontType("bold");
			doc.setFontSize(10);
			doc.text('Date:', 35, 127);
			//    doc.text('Invoice No:', 380, 127);
			doc.text('Invoice No:', 312, 127);
			var pdate = data[j].purchasedate;
			doc.text(pdate, 65, 127);
			doc.text(data[j].orderid, 375, 127);

			// #endregion Purchase Date

			// #region Delivery Address

			var DPSPElementID = document.getElementById(DPSPAddrvatid);
			if (DPSPElementID === null || DPSPElementID === undefined || DPSPElementID === '') {

			} else {
				DPSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(DPSPAddrvatid));
				doc.autoTable(DPSPAddrvatres.columns, DPSPAddrvatres.data, {
					margin: {
						left: 30
					},
					startY: 150,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						overflow: 'linebreak',
						rowHeight: 16,
						fontSize: 10,
						fontStyle: 'bold'

					},
					tableWidth: 350
				});
			}

			// #endregion Delivery Address

			doc.addImage(X247Invoices.PKSupplier, 'JPEG', 380, 150, 175, 125);

			// #region Items Details Grid

			var tempcolumns = [];

			var DPOrderElementID = document.getElementById(DPcorderid);
			if (DPOrderElementID === null || DPOrderElementID === undefined || DPOrderElementID === '') {

			} else {
				DPcorderres = doc.autoTableHtmlToJson(document.getElementById(DPcorderid));
				doc.autoTable(DPcorderres.columns, DPcorderres.data, {
					margin: {
						left: 25
					},
					startY: 305,
					theme: 'plain',
					pageBreak: 'auto',
					styles: {
						overflow: 'linebreak',
						//fillStyle: 'DF',
						//lineColor: [0,0,0],
						//lineWidth: 0.1
					},
					headerStyles: {
						//   fillColor: [118, 143, 163],
						//  lineColor: [0, 0, 0],
						fontSize: 10,
						textColor: [0, 0, 0],
						fontStyle: 'bold'
					},
					bodyStyles: {
						fillColor: [255, 255, 255],
						textColor: [0, 0, 0]
					},
					drawHeaderRow: function (row, data) {
						row.cells[3].styles.halign = 'right';
						row.cells[4].styles.halign = 'right';
						tempcolumns.push(data.table.headerRow.cells[0].textPos);
						tempcolumns.push(data.table.headerRow.cells[1].textPos);
						tempcolumns.push(data.table.headerRow.cells[2].textPos);
						tempcolumns.push(data.table.headerRow.cells[3].textPos);
						tempcolumns.push(data.table.headerRow.cells[4].textPos);
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

			doc.addImage(X247Invoices.greygridbar, 'JPEG', 25, 302, 532, 20);
			doc.setTextColor(0, 0, 0);
			doc.setFontType("bold");
			doc.setFontSize(7);

			$.each(tempcolumns, function (value, key) {
				if (key == 0) {
					doc.text("EAN", value.x.toFixed(0), value.y + 5);
				}
				if (key == 1) {
					doc.text("SKU", value.x.toFixed(0), value.y + 5);
				}
				if (key == 2) {
					doc.text("ITEM", value.x.toFixed(0), value.y + 5);
				}
				if (key == 3) {
					doc.text("QTY", value.x.toFixed(0) - 10, value.y + 5);
				}
				if (key == 4) {
					doc.text("PRICE", (value.x.toFixed(0) - 23), (value.y + 5));
				}

			});

			// #endregion Items Details Grid

			// #region Shipping Cost Details
			doc.setFontSize(10);
			doc.setTextColor(118, 143, 163);
			doc.text("_______________________________________________________________________________________________", 25, doc.autoTableEndPosY() + 5);
			doc.setTextColor(0, 0, 0);
			doc.setFontType("bold");
			doc.setFontSize(10);

			doc.writeText(0, doc.autoTableEndPosY() + 23, "VAT:", {
				align: 'right',
				width: 510
			});
			doc.setTextColor(118, 143, 163);
			doc.text("___________________", 450, doc.autoTableEndPosY() + 29);
			doc.setTextColor(0, 0, 0);
			doc.writeText(0, doc.autoTableEndPosY() + 45, "Shipping:", {
				align: 'right',
				width: 510
			});
			doc.setTextColor(118, 143, 163);
			doc.text("___________________", 450, doc.autoTableEndPosY() + 51);
			doc.setTextColor(0, 0, 0);
			doc.writeText(0, doc.autoTableEndPosY() + 67, "Total:", {
				align: 'right',
				width: 510
			});
			doc.setTextColor(118, 143, 163);
			doc.text("___________________", 450, doc.autoTableEndPosY() + 73);
			doc.setTextColor(0, 0, 0);

			var utvat = 0.00;

			utvat = X247Invoices.GrandTotalWithVatHaberCrafts(j, data[j].orderitems, data[j]);
			doc.writeText(0, doc.autoTableEndPosY() + 23, "£ " + parseFloat(utvat).toString(), {
				align: 'right',
				width: 546
			});

			var pp = 0.00;
			if (data[j].orderitems.length > 0) {
				pp = X247Invoices.subtotal(j, data[j].orderitems);
			}

			doc.writeText(0, doc.autoTableEndPosY() + 45, "£ " + parseFloat(pp).toString(), {
				align: 'right',
				width: 546
			});


			var utsubtot = 0.00;
			if (data[j].orderitems.length > 0) {
				utsubtot = X247Invoices.subtotalunitPrice(j, data[j].orderitems);
			}


			var utnetotot = 0.00;
			utnetotot = parseFloat(parseFloat(pp) + parseFloat(utsubtot)).toFixed(2);

			doc.writeText(0, doc.autoTableEndPosY() + 67, "£ " + parseFloat(utnetotot).toString(), {
				align: 'right',
				width: 546
			});

			// #endregion Shipping Cost Details

			// #region Footer details

			var botText1 = "If you are not satisfied with your order or service then please get";
			var botText2 = "in contact with us before leaving less than 5* feedback";

			doc.setFontSize(10);
			doc.setFontType("normal");
			centeredText(botText1, 770, 15);
			centeredText(botText2, 785, 15);

			var bottext3 = "Pro Klader Ltd,Dunstone House,Dunstone Road, Chesterfield, S419QD.";
			var bottext4 = "Company Number: 11076121 VAT Number: 283220423";
			var bottext5 = "View our other sites at www.proklader.com";
			var bottext6 = "Email us at sales@proklader.com";
			centeredText(bottext3, 795, 8);
			centeredText(bottext4, 805, 8);
			centeredText(bottext5, 815, 8);
			centeredText(bottext6, 825, 8);

			// #endregion Footer details

		} else {
			if (data[j].accountcode == 142) {
				var centeredText = function (text, y, fsize) {
					doc.setFontSize(fsize);
					doc.setTextColor(0, 0, 0);
					var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
					var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
					// doc.setFont("arial");
					doc.text(textOffset, y, text);
				};

				var PKStampBoxid = "PKStampBox_ppi";
				var PKStampBoxres = '';

				var DPSPAddrvatid = "PKSPAddrvat_ppi";
				var DPSPAddrvatres = '';
				
				/*Ship address */
					var ship_address = data[j]['shippingaddresses'][0];
					$('#shipname_ppi').text(ship_address.Name);
					$('#shipaddress1ppi').text(ship_address.Address1);
					$('#shipaddress2ppi').text(ship_address.Address2);
					$('#shipcity_ppi').text(ship_address.City);
					$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
					$('#shippostcode_ppi').text(ship_address.PostCode);
					$('#shipcountryname_ppi').text(ship_address.CountryName);
					$('#shipphone_ppi').text(ship_address.Phone);
					$('#shipemail_ppi').text(ship_address.Email);
				/* Ship address end */

				var DPcorderid = "PKcorder_ppi";
				var DPcorderres = '';
				
				/* orders data */
					var multiple_orders = {};
					var multiple_orders_items = '';
					
					if(data[j]['orderitems'].length > 0){
						multiple_orders = data[j]['orderitems'];
						for (var jm = 0; jm < multiple_orders.length; jm++) {
							multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Ean']+"</span></td><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td></tr>";
						}
					}
					
					$('#multipleorders_ppi').html(multiple_orders_items);
				/* orders data end */

				var DPtotalpricevatid = "PKtotalpricevat_ppi";
				var DPtotalpricevatres = '';
				
				$('#vatprice_ppi').text(X247Invoices.X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
				$('#shippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
				$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

				var newid = "PKnewvat_ppi";
				var newres = '';

				var startpos = 29;

				// #region Company Logo

				doc.addImage(X247Invoices.workwearlogo, 'JPEG', 45, 30, 250, 75);

				doc.setFontType("bold");
				doc.setFontSize(23);
				doc.text('INVOICE', 435, 60);

				// #endregion Company Logo

				// #region Purchase Date

				doc.addImage(X247Invoices.orangebar, 'JPEG', 25, 113, 532, 20);
				doc.setTextColor(0, 0, 0);
				doc.setFontType("bold");
				doc.setFontSize(10);
				doc.text('Date:', 35, 127);
				//   doc.text('Invoice No:', 380, 127);
				doc.text('Invoice No:', 312, 127);
				var pdate = data[j].purchasedate;
				doc.text(pdate, 65, 127);
				doc.text(data[j].orderid, 375, 127);


				// #endregion Purchase Date

				// #region Delivery Address

				var DPSPElementID = document.getElementById(DPSPAddrvatid);
				if (DPSPElementID === null || DPSPElementID === undefined || DPSPElementID === '') {

				} else {
					DPSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(DPSPAddrvatid));
					doc.autoTable(DPSPAddrvatres.columns, DPSPAddrvatres.data, {
						margin: {
							left: 30
						},
						startY: 150,
						pageBreak: 'avoid',
						theme: 'plain',
						styles: {
							overflow: 'linebreak',
							rowHeight: 16,
							fontSize: 10,
							fontStyle: 'bold'

						},
						tableWidth: 350
					});
				}

				// #endregion Delivery Address

				doc.addImage(X247Invoices.vistusworkwear, 'JPEG', 380, 150, 175, 125);

				// #region Items Details Grid

				var tempcolumns = [];

				var DPOrderElementID = document.getElementById(DPcorderid);
				if (DPOrderElementID === null || DPOrderElementID === undefined || DPOrderElementID === '') {

				} else {
					DPcorderres = doc.autoTableHtmlToJson(document.getElementById(DPcorderid));
					doc.autoTable(DPcorderres.columns, DPcorderres.data, {
						margin: {
							left: 25
						},
						startY: 305,
						theme: 'plain',
						pageBreak: 'auto',
						styles: {
							overflow: 'linebreak',
							//fillStyle: 'DF',
							//lineColor: [0,0,0],
							//lineWidth: 0.1
						},
						headerStyles: {
							//  fillColor: [119, 119, 119],
							//  lineColor: [119, 119, 119],
							fontSize: 10,
							textColor: [0, 0, 0],
							fontStyle: 'bold'
						},
						bodyStyles: {
							fillColor: [255, 255, 255],
							textColor: [0, 0, 0]
						},
						drawHeaderRow: function (row, data) {
							row.cells[3].styles.halign = 'right';
							row.cells[4].styles.halign = 'right';

							tempcolumns.push(data.table.headerRow.cells[0].textPos);
							tempcolumns.push(data.table.headerRow.cells[1].textPos);
							tempcolumns.push(data.table.headerRow.cells[2].textPos);
							tempcolumns.push(data.table.headerRow.cells[3].textPos);
							tempcolumns.push(data.table.headerRow.cells[4].textPos);
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

				doc.addImage(X247Invoices.orangegridbar, 'JPEG', 25, 302, 532, 20);
				doc.setTextColor(0, 0, 0);
				doc.setFontType("bold");
				doc.setFontSize(7);

				$.each(tempcolumns, function (value, key) {
					if (key == 0) {
						doc.text("EAN", value.x.toFixed(0), value.y + 5);
					}
					if (key == 1) {
						doc.text("SKU", value.x.toFixed(0), value.y + 5);
					}
					if (key == 2) {
						doc.text("ITEM", value.x.toFixed(0), value.y + 5);
					}
					if (key == 3) {
						doc.text("QTY", value.x.toFixed(0) - 10, value.y + 5);
					}
					if (key == 4) {
						doc.text("PRICE", (value.x.toFixed(0) - 23), (value.y + 5));
					}

				});

				// #endregion Items Details Grid

				// #region Shipping Cost Details
				doc.setFontSize(10);
				doc.setTextColor(119, 119, 119);
				doc.text("_______________________________________________________________________________________________", 25, doc.autoTableEndPosY() + 5);
				doc.setTextColor(0, 0, 0);
				doc.setFontType("bold");
				doc.setFontSize(10);

				doc.writeText(0, doc.autoTableEndPosY() + 23, "VAT:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(119, 119, 119);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 29);
				doc.setTextColor(0, 0, 0);
				doc.writeText(0, doc.autoTableEndPosY() + 45, "Shipping:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(119, 119, 119);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 51);
				doc.setTextColor(0, 0, 0);
				doc.writeText(0, doc.autoTableEndPosY() + 67, "Total:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(119, 119, 119);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 73);
				doc.setTextColor(0, 0, 0);

				var utvat = 0.00;

				utvat = X247Invoices.GrandTotalWithVatHaberCrafts(j, data[j].orderitems, data[j]);
				doc.writeText(0, doc.autoTableEndPosY() + 23, "£ " + utvat.toFixed(2).toString(), {
					align: 'right',
					width: 546
				});

				var pp = 0.00;
				if (data[j].orderitems.length > 0) {
					pp = X247Invoices.subtotal(j, data[j].orderitems);
				}

				doc.writeText(0, doc.autoTableEndPosY() + 45, "£ " + parseFloat(pp).toString(), {
					align: 'right',
					width: 546
				});


				var utsubtot = 0.00;
				if (data[j].orderitems.length > 0) {
					utsubtot = X247Invoices.subtotalunitPrice(j, data[j].orderitems);
				}

				var utnetotot = 0.00;
				utnetotot = parseFloat(parseFloat(pp) + parseFloat(utsubtot)).toFixed(2);

				doc.writeText(0, doc.autoTableEndPosY() + 67, "£ " + parseFloat(utnetotot).toString(), {
					align: 'right',
					width: 546
				});

				// #endregion Shipping Cost Details

				// #region Footer details

				doc.addImage(X247Invoices.workweartactical, 'JPEG', 25, 605, 530, 150);


				var botText1 = "If you are not satisfied with your order or service then please get";
				var botText2 = "in contact with us before leaving less than 5* feedback";

				doc.setFontSize(10);
				doc.setFontType("normal");
				centeredText(botText1, 770, 15);
				centeredText(botText2, 785, 15);

				var bottext3 = "Pro Klader Ltd,Dunstone House,Dunstone Road, Chesterfield, S419QD.";
				var bottext4 = "Company Number: 11076121 VAT Number: 283220423";
				var bottext5 = "View our other sites at www.proklader.com";
				var bottext6 = "Email us at sales@proklader.com";
				centeredText(bottext3, 795, 8);
				centeredText(bottext4, 805, 8);
				centeredText(bottext5, 815, 8);
				centeredText(bottext6, 825, 8);

				// #endregion Footer details
			} else {
				var centeredText = function (text, y, fsize) {
					doc.setFontSize(fsize);
					doc.setTextColor(0, 0, 0);
					var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
					var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
					// doc.setFont("arial");
					doc.text(textOffset, y, text);
				};

				var PKStampBoxid = "PKStampBox_ppi";
				var PKStampBoxres = '';

				var DPSPAddrvatid = "PKSPAddrvat_ppi";
				var DPSPAddrvatres = '';
				
				/*Ship address */
					var ship_address = data[j]['shippingaddresses'][0];
					$('#shipname_ppi').text(ship_address.Name);
					$('#shipaddress1ppi').text(ship_address.Address1);
					$('#shipaddress2ppi').text(ship_address.Address2);
					$('#shipcity_ppi').text(ship_address.City);
					$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
					$('#shippostcode_ppi').text(ship_address.PostCode);
					$('#shipcountryname_ppi').text(ship_address.CountryName);
					$('#shipphone_ppi').text(ship_address.Phone);
					$('#shipemail_ppi').text(ship_address.Email);
				/* Ship address end */

				var DPcorderid = "PKcorder_ppi";
				var DPcorderres = '';
				
				/* orders data */
					var multiple_orders = {};
					var multiple_orders_items = '';
					
					if(data[j]['orderitems'].length > 0){
						multiple_orders = data[j]['orderitems'];
						for (var jm = 0; jm < multiple_orders.length; jm++) {
							multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Ean']+"</span></td><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td></tr>";
						}
					}
					
					$('#multipleorders_ppi').html(multiple_orders_items);
				/* orders data end */

				var DPtotalpricevatid = "PKtotalpricevat_ppi";
				var DPtotalpricevatres = '';
				
				$('#vatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
				$('#shippingprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
				$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

				var newid = "PKnewvat_ppi";
				var newres = '';

				var startpos = 29;

				// #region Company Logo

				doc.addImage(X247Invoices.ebayMilLogo, 'JPEG', 45, 30, 250, 75);

				doc.setFontType("bold");
				doc.setFontSize(23);
				doc.text('INVOICE', 435, 60);

				// #endregion Company Logo

				// #region Purchase Date

				doc.addImage(X247Invoices.blackbar, 'JPEG', 25, 113, 532, 20);
				doc.setTextColor(255, 255, 255);
				doc.setFontType("bold");
				doc.setFontSize(10);
				doc.text('Date:', 35, 127);
				//   doc.text('Invoice No:', 380, 127);
				doc.text('Invoice No:', 312, 127);
				var pdate = data[j].purchasedate;
				doc.text(pdate, 65, 127);
				doc.text(data[j].orderid, 375, 127);


				// #endregion Purchase Date

				// #region Delivery Address

				var DPSPElementID = document.getElementById(DPSPAddrvatid);
				if (DPSPElementID === null || DPSPElementID === undefined || DPSPElementID === '') {

				} else {
					DPSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(DPSPAddrvatid));
					doc.autoTable(DPSPAddrvatres.columns, DPSPAddrvatres.data, {
						margin: {
							left: 30
						},
						startY: 150,
						pageBreak: 'avoid',
						theme: 'plain',
						styles: {
							overflow: 'linebreak',
							rowHeight: 16,
							fontSize: 10,
							fontStyle: 'bold'

						},
						tableWidth: 350
					});
				}

				// #endregion Delivery Address

				doc.addImage(vistusmil, 'JPEG', 380, 150, 175, 125);

				// #region Items Details Grid

				var tempcolumns = [];

				var DPOrderElementID = document.getElementById(DPcorderid);
				if (DPOrderElementID === null || DPOrderElementID === undefined || DPOrderElementID === '') {

				} else {
					DPcorderres = doc.autoTableHtmlToJson(document.getElementById(DPcorderid));
					doc.autoTable(DPcorderres.columns, DPcorderres.data, {
						margin: {
							left: 25
						},
						startY: 305,
						theme: 'plain',
						pageBreak: 'auto',
						styles: {
							overflow: 'linebreak',
							//fillStyle: 'DF',
							//lineColor: [0,0,0],
							//lineWidth: 0.1
						},
						headerStyles: {
							// fillColor: [0, 0, 0],
							// lineColor: [0, 0, 0],
							fontSize: 10,
							textColor: [255, 255, 255],
							fontStyle: 'bold'
						},
						bodyStyles: {
							fillColor: [255, 255, 255],
							textColor: [0, 0, 0]
						},
						drawHeaderRow: function (row, data) {
							// console.log(row, "row", data, "data");
							row.cells[3].styles.halign = 'right';
							row.cells[4].styles.halign = 'right';
							tempcolumns.push(data.table.headerRow.cells[0].textPos);
							tempcolumns.push(data.table.headerRow.cells[1].textPos);
							tempcolumns.push(data.table.headerRow.cells[2].textPos);
							tempcolumns.push(data.table.headerRow.cells[3].textPos);
							tempcolumns.push(data.table.headerRow.cells[4].textPos);
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

				doc.addImage(X247Invoices.blackgridbar, 'JPEG', 25, 300, 532, 20);
				doc.setTextColor(255, 255, 255);
				doc.setFontType("bold");
				doc.setFontSize(7);

				$.each(tempcolumns, function (value, key) {
					if (key == 0) {
						doc.text("EAN", value.x.toFixed(0), value.y + 3);
					}
					if (key == 1) {
						doc.text("SKU", value.x.toFixed(0), value.y + 3);
					}
					if (key == 2) {
						doc.text("ITEM", value.x.toFixed(0), value.y + 3);
					}
					if (key == 3) {
						doc.text("QTY", value.x.toFixed(0) - 10, value.y + 3);
					}
					if (key == 4) {
						doc.text("PRICE", (value.x.toFixed(0) - 23), (value.y + 3));
					}

				});

				// #endregion Items Details Grid

				// #region Shipping Cost Details
				doc.setFontSize(10);
				doc.setTextColor(0, 0, 0);
				doc.text("_______________________________________________________________________________________________", 25, doc.autoTableEndPosY() + 5);
				doc.setTextColor(0, 0, 0);
				doc.setFontType("bold");
				doc.setFontSize(10);

				doc.writeText(0, doc.autoTableEndPosY() + 23, "VAT:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(0, 0, 0);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 29);
				doc.setTextColor(0, 0, 0);
				doc.writeText(0, doc.autoTableEndPosY() + 45, "Shipping:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(0, 0, 0);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 51);
				doc.setTextColor(0, 0, 0);
				doc.writeText(0, doc.autoTableEndPosY() + 67, "Total:", {
					align: 'right',
					width: 510
				});
				doc.setTextColor(0, 0, 0);
				doc.text("___________________", 450, doc.autoTableEndPosY() + 73);
				doc.setTextColor(0, 0, 0);

				var utvat = 0.00;

				utvat = X247Invoices.GrandTotalWithVatHaberCrafts(j, data[j].orderitems, data[j]);
				doc.writeText(0, doc.autoTableEndPosY() + 23, "£ " + parseFloat(utvat).toString(), {
					align: 'right',
					width: 546
				});

				var pp = 0.00;
				if (data[j].orderitems.length > 0) {
					pp = X247Invoices.subtotal(j, data[j].orderitems);
				}

				doc.writeText(0, doc.autoTableEndPosY() + 45, "£ " + parseFloat(pp).toString(), {
					align: 'right',
					width: 546
				});


				var utsubtot = 0.00;
				if (data[j].orderitems.length > 0) {
					utsubtot = X247Invoices.subtotalunitPrice(j, data[j].orderitems);
				}


				var utnetotot = 0.00;
				utnetotot = parseFloat(parseFloat(pp) + parseFloat(utsubtot)).toFixed(2);

				doc.writeText(0, doc.autoTableEndPosY() + 67, "£ " + parseFloat(utnetotot).toString(), {
					align: 'right',
					width: 546
				});

				// #endregion Shipping Cost Details

				// #region Footer details

				doc.addImage(X247Invoices.tactical, 'JPEG', 25, 605, 530, 150);


				var botText1 = "If you are not satisfied with your order or service then please get";
				var botText2 = "in contact with us before leaving less than 5* feedback";

				doc.setFontSize(10);
				doc.setFontType("normal");
				centeredText(botText1, 770, 15);
				centeredText(botText2, 785, 15);

				var bottext3 = "Pro Klader Ltd,Dunstone House,Dunstone Road, Chesterfield, S419QD.";
				var bottext4 = "Company Number: 11076121 VAT Number: 283220423";
				var bottext5 = "View our other sites at www.proklader.com";
				var bottext6 = "Email us at sales@proklader.com";
				centeredText(bottext3, 795, 8);
				centeredText(bottext4, 805, 8);
				centeredText(bottext5, 815, 8);
				centeredText(bottext6, 825, 8);

				// #endregion Footer details
			}
		}

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