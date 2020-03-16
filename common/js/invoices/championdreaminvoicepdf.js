function ChampionDreamInvoiceNewPDF(data,CDLTemplate) {

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


		var CDLcompanyid = "CDL_companyaddr_ppi";
		var CDLcompanyres = '';

		var CDLStampBoxid = "CDLStampBox_ppi";
		var CDLStampBoxres = '';

		var CDLreturnaddressvatid = "CDLreturnaddressvat_ppi";
		var CDLreturnaddressvatres = '';
		
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

		var CDLSPAddrvatid = "CDLSPAddrvat_ppi";
		var CDLSPAddrvatres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#cdshipname_ppi').text(ship_address.Name);
			$('#cdshipaddress1ppi').text(ship_address.Address1);
			$('#cdshipaddress2ppi').text(ship_address.Address2);
			$('#cdshipcity_ppi').text(ship_address.City);
			$('#cdshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#cdshippostcode_ppi').text(ship_address.PostCode);
			$('#cdshipcountryname_ppi').text(ship_address.CountryMame);
			$('#cdshipphone_ppi').text(ship_address.Phone);
			$('#cdshipemail_ppi').text(ship_address.Email);
		/* Ship address end */

		var CDLcorderid = "CDLcorder_ppi";
		var CDLcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Quantity']+"</span></td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span><p>"+X247Invoices.testempty+"</p><p>SKU : "+multiple_orders[jm]['Sku']+"</p></td><td>"+multiple_orders[jm]['ItemCondition']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var CDLtotalpricevatid = "CDLtotalpricevat_ppi";
		var CDLtotalpricevatres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		/* total price end */

		var newid = "CDLnew_ppi";
		var newres = '';
		var startpos = 29;


		// #region Company Logo

		// doc.addImage(CDLLogo, 'JPEG', 10, startpos, 235, 65);
		doc.addImage(X247Invoices.CDLLogo, 'JPEG', 10, startpos, 200, 65);

		// #endregion Company Logo

		// #region Company Address
		var CDLcompanyElementID = document.getElementById(CDLcompanyid);
		if (CDLcompanyElementID === null || CDLcompanyElementID === undefined || CDLcompanyElementID === '') {

		} else {
			CDLcompanyres = doc.autoTableHtmlToJson(document.getElementById(CDLcompanyid));
			doc.autoTable(CDLcompanyres.columns, CDLcompanyres.data, {
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

		// doc.text("Test", 555, 5);

		// #region Shipping Address

		var CDLSPAddrElementID = document.getElementById(CDLSPAddrvatid);
		if (CDLSPAddrElementID === null || CDLSPAddrElementID === undefined || CDLSPAddrElementID === '') {

		} else {
			CDLSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(CDLSPAddrvatid));
			doc.autoTable(CDLSPAddrvatres.columns, CDLSPAddrvatres.data, {
				margin: {
					//left: 440
					//left: 390
					left: 252

				},
				startY: startpos,
				//  pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 9,
					overflow: 'linebreak',
					fontStyle: 'normal',
					//columnWidth: 'wrap',
					//fillStyle: 'DF',
					//lineColor: [165, 164, 164],
					//lineWidth: 0.5,
					halign: 'right'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 9,
					textColor: [0, 0, 0],
					fontStyle: 'bold',
					halign: 'right'
				},
				// tableWidth: 245
				tableWidth: 335
			});
		}

		// #endregion Shipping Address

		var shipaddrEndPos = doc.autoTableEndPosY() + 10;

		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.writeText(0, shipaddrEndPos, 'Shipping Method', {
			align: 'right',
			width: 555
		}); // 265, shipaddrEndPos


		doc.setFontSize(9);
		doc.setFontType("normal");
		var CDLShippingMT = '';
		if (data[j].marketplacecode === "1") {
			CDLShippingMT = "eBay - ";
		}
		if (data[j].marketplacecode === "2") {
			CDLShippingMT = "Amazon - ";
		}
		if (data[j].marketplacecode === "3") {
			CDLShippingMT = "Webstore - ";
		}
		if (data[j].marketplacecode === "7") {
			CDLShippingMT = "Rakuten - ";
		}
		if (data[j].marketplacecode === "8") {
			CDLShippingMT = "Trade Me - ";
		}
		if (data[j].marketplacecode === "9") {
			CDLShippingMT = "CDiscount - ";
		}
		if (data[j].marketplacecode === "13") {
			CDLShippingMT = "Abebook - ";
		}
		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService === 'undefined') {

				CDLShippingMT += "Standard";
			} else {
				CDLShippingMT += data[j].orderitems[0].ShippingService;
			}
		}

		//  doc.text(CDLShippingMT, 265, shipaddrEndPos + 15);
		doc.writeText(0, shipaddrEndPos + 15, CDLShippingMT, {
			align: 'right',
			width: 555
		});

		doc.setFontSize(9);
		doc.setFontType("bold");

		doc.writeText(0, shipaddrEndPos + 30, 'Shipping Instructions', {
			align: 'right',
			width: 555
		}); // 265,

		doc.setFontSize(9);
		doc.setFontType("normal");

		var CDLBMsg = '';
		if (data[j].buyermessage != 'undefined' && data[j].buyermessage !== '' && data[j].buyermessage != null) {
			CDLBMsg = data[j].buyermessage;
		}
		//   doc.text(CDLBMsg, 265, shipaddrEndPos + 45);
		doc.writeText(0, shipaddrEndPos + 45, CDLBMsg, {
			align: 'right',
			width: 555
		});

		doc.setFontSize(9);
		doc.setFontType("bold");

		// doc.text('Marketplace User:', 265, shipaddrEndPos + 60);
		doc.writeText(0, shipaddrEndPos + 60, 'Marketplace User', {
			align: 'right',
			width: 555
		});

		var CDLbuyID = '';
		if (data[j].ebaybuyerid != 'undefined' && data[j].ebaybuyerid !== '' && data[j].ebaybuyerid != null) {
			CDLbuyID = data[j].ebaybuyerid;
		}

		doc.setFontSize(9);
		doc.setFontType("normal");

		// doc.text(CDLbuyID, 265, shipaddrEndPos + 75);
		doc.writeText(0, shipaddrEndPos + 75, CDLbuyID, {
			align: 'right',
			width: 555
		});

		doc.setFontSize(9);
		doc.setFontType("bold");

		// doc.text('Marketplace e-mail:', 265, shipaddrEndPos + 90);
		doc.writeText(0, shipaddrEndPos + 90, 'Marketplace e-mail', {
			align: 'right',
			width: 555
		});

		doc.setFontSize(9);
		doc.setFontType("normal");

		var CDLSPEmail = '';
		var ship_address = data[j]['shippingaddresses'][0];
		if (ship_address.Email != 'undefined' && ship_address.Email !== '' && ship_address.Email != null) {
			CDLSPEmail = ship_address.Email;
		}
		//  doc.text(CDLSPEmail, 265, shipaddrEndPos + 105);
		doc.writeText(0, shipaddrEndPos + 105, CDLSPEmail, {
			align: 'right',
			width: 555
		});


		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text("Item Summary", 15, shipaddrEndPos + 120);
		doc.setFontSize(9);
		doc.setFontType("normal");

		// #region Items Details Grid

		var CDLOrderElementID = document.getElementById(CDLcorderid);
		if (CDLOrderElementID === null || CDLOrderElementID === undefined || CDLOrderElementID === '') {

		} else {
			CDLcorderres = doc.autoTableHtmlToJson(document.getElementById(CDLcorderid));
			doc.autoTable(CDLcorderres.columns, CDLcorderres.data, {
				margin: {
					left: 15
				},
				startY: shipaddrEndPos + 125,
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
					row.cells[4].styles.halign = 'right';
					row.cells[3].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 4) {
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
		var totendPOS = 0;
		var CDLtotalpriceElementID = document.getElementById(CDLtotalpricevatid);
		if (CDLtotalpriceElementID === null || CDLtotalpriceElementID === undefined || CDLtotalpriceElementID === '') {

		} else {
			CDLtotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(CDLtotalpricevatid));

			var totalpriceoptions = {
				margin: {
					left: 367,
					bottom: 296
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'auto',
				theme: 'plain',
				styles: {
					//  overflow: 'linebreak'
					fontSize: 9
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

			doc.autoTable(CDLtotalpricevatres.columns, CDLtotalpricevatres.data, totalpriceoptions);
			totendPOS = doc.autoTableEndPosY();
		}

		// #endregion Items Total Calculation Grid

		// #region PPL Stamp  

		// startY: 555

		console.log(totendPOS, "totendPOS", parseFloat(totendPOS), "----------", parseFloat(545));
		if (parseFloat(totendPOS) >= parseFloat(546)) {
			doc.addPage();
		}

		var CDLStampBoxElementID = document.getElementById(CDLStampBoxid);
		if (CDLStampBoxElementID === null || CDLStampBoxElementID === undefined || CDLStampBoxElementID === '') {

		} else {

			CDLStampBoxres = doc.autoTableHtmlToJson(document.getElementById(CDLStampBoxid));

			doc.autoTable(CDLStampBoxres.columns, CDLStampBoxres.data, {
				margin: {
					left: 252
				},
				// startY: 585,
				startY: 555,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					//  rowHeight: 155,
					//rowHeight: 215,
					rowHeight: 225,
					fontSize: 9
				},
				tableWidth: 330
			});


			// #region Universal Stamp


			//doc.addImage(X247Invoices.CDLSUKOnly, 'JPEG', 282, 588, 266, 56);
			//doc.setFontSize(7);
			//doc.setFontType("bold");
			//doc.text('POSTAGE PAID GB', 480, 626);
			//doc.text('HQ32057', 480, 636);
			//doc.setFontType("normal");

			if (CDLTemplate == 1) {
				doc.addImage(X247Invoices.CDLSUKOnly, 'JPEG', 282, 558, 266, 56);
			}
			if (CDLTemplate == 2) {
				doc.addImage(X247Invoices.CDL24PPL, 'JPEG', 282, 558, 266, 56);
			}

			doc.setFontSize(7);
			doc.setFontType("bold");
			doc.text('POSTAGE PAID GB', 480, 596);
			doc.text('HQ32057', 480, 606);
			doc.setFontType("normal");

			// #endregion Universal Stamp

			var CDLrtAddrElementID = document.getElementById(CDLreturnaddressvatid);
			if (CDLrtAddrElementID === null || CDLrtAddrElementID === undefined || CDLrtAddrElementID === '') {

			} else {
				CDLreturnaddressvatres = doc.autoTableHtmlToJson(document.getElementById(CDLreturnaddressvatid));
				doc.autoTable(CDLreturnaddressvatres.columns, CDLreturnaddressvatres.data, {
					margin: {
						left: 265
					},
					// startY: 110,
					//  startY: 664,
					startY: 627,
					pageBreak: 'auto',
					theme: 'plain',
					styles: {
						overflow: 'linebreak',
						// fontSize: 14,
						fontSize: 9,
						fontStyle: 'normal',
						rowHeight: 16
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

				doc.setFontSize(8);
				doc.setFontType("normal");
				//doc.text('If undelivered,please return to: Champion Dreams Ltd,Trevor Phillips', 265, doc.autoTableEndPosY() + 10);
				//doc.text('Unit 6 Victory Close,Three Legged Cross,Wimborne,Dorset', 265, doc.autoTableEndPosY() + 22);
				//doc.text('BH21 6SX,UK', 265, doc.autoTableEndPosY() + 34);

				doc.text('If undelivered,please return to: Champion Dreams Ltd,Unit 6 Victory Close,', 265, doc.autoTableEndPosY() + 10);
				doc.text('Three Legged Cross,Wimborne,Dorset,BH21 6SX,UK', 265, doc.autoTableEndPosY() + 22);
				// doc.text('', 265, doc.autoTableEndPosY() + 34);
				doc.setFontSize(9);

				console.log(doc.autoTableEndPosY() + 22, "doc.autoTableEndPosY() + 22");
			}
		};


		// #endregion PPL Stamp

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