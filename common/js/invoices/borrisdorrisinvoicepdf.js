function BorrisDorrisInvociePDF(data) {

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

		var BOcompanyid = "BO_companyaddr_ppi";
		var BOcompanyres = '';

		var BOStampBoxid = "BOStampBox_" + j;
		var BOStampBoxres = '';

		var BOreturnaddressvatid = "BOreturnaddressvat_ppi";
		var BOreturnaddressvatres = '';
		
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

		var BOSPAddrvatid = "BOSPAddrvat_ppi";
		var BOSPAddrvatres = '';
		
		$('#boshipname_ppi').text(ship_address.Name);
		$('#boshipaddress1ppi').text(ship_address.Address1);
		$('#boshipaddress2ppi').text(ship_address.Address2);
		$('#boshipcity_ppi').text(ship_address.City);
		$('#boshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#boshippostcode_ppi').text(ship_address.PostCode);
		$('#boshipcountryname_ppi').text(ship_address.CountryName);

		var BOSPLabelAddrvatid = "BOSPLabelAddrvat_ppi";
		var BOSPLabelAddrvatres = '';
		
		$('#bosshipname_ppi').text(ship_address.Name);
		$('#bosshipaddress1ppi').text(ship_address.Address1);
		$('#bosshipaddress2ppi').text(ship_address.Address2);
		$('#bosshipcity_ppi').text(ship_address.Xity);
		$('#bosshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#bosshippostcode_ppi').text(ship_address.PostCode);
		$('#bosshipcountryname_ppi').text(ship_address.CountryName);

		var BOcorderid = "BOcorder_ppi";
		var BOcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>0.0</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var BOtotalpricevatid = "BOtotalpricevat_ppi";
		var BOtotalpricevatres = '';
		
		$('#vatprice_ppi').text(X247Invoices.GrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		$('#totalshipping_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));
		
		

		var BObarcodevatid = "BObarcodevat_ppi";
		var BObarcodevarres = "";
		
		/* barcode */
		$("#BObarImagevat_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		/* barcode end */

		var BO_RTcompanyaddid = "BO_RTcompanyaddr_ppi";
		var BO_RTcompanyaddrres = "";

		var BOBinLocation_id = "BOBinLocation_ppi";
		var BOBinLocation_res = "";
		
		$('#binlocationlabel_ppi').text(displayBinlocatonByOrderID(data[j].orderitems));

		var newid = "BOnewvat_ppi";
		var newres = '';
		var startpos = 29;


		var BOStampBoxElementID = document.getElementById(BOStampBoxid);
		if (BOStampBoxElementID === null || BOStampBoxElementID === undefined || BOStampBoxElementID === '') {

		} else {

			doc.setFontStyle('bold');
			doc.setFontSize(12);

			// #region Display Binlocation

			var BOBinLocation_ElementID = document.getElementById(BOBinLocation_id);
			if (BOBinLocation_ElementID === null || BOBinLocation_ElementID === undefined || BOBinLocation_ElementID === '') {

			} else {
				BOBinLocation_res = doc.autoTableHtmlToJson(document.getElementById(BOBinLocation_id));
				doc.autoTable(BOBinLocation_res.columns, BOBinLocation_res.data, {
					margin: {
						left: 35
					},
					startY: 45,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						rowHeight: 18,
						fontSize: 12,
						overflow: 'linebreak',
						fontStyle: 'normal',
						// columnWidth: 'wrap',
						fontStyle: 'bold'
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						fontSize: 12,
						textColor: [0, 0, 0],
						fontStyle: 'bold'
					},
					tableWidth: 217 //250
				});
			}

			// #endregion Display Binlocation


			// #region Customer Address

			var BOSPLabelAddrvatElementID = document.getElementById(BOSPLabelAddrvatid);
			if (BOSPLabelAddrvatElementID === null || BOSPLabelAddrvatElementID === undefined || BOSPLabelAddrvatElementID === '') {

			} else {
				BOSPLabelAddrvatres = doc.autoTableHtmlToJson(document.getElementById(BOSPLabelAddrvatid));
				doc.autoTable(BOSPLabelAddrvatres.columns, BOSPLabelAddrvatres.data, {
					margin: {
						left: 340
					},
					startY: 30,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						rowHeight: 18,
						fontSize: 12,
						overflow: 'linebreak',
						fontStyle: 'normal',
						// columnWidth: 'wrap',
						fontStyle: 'bold'
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						fontSize: 12,
						textColor: [0, 0, 0],
						fontStyle: 'bold'
					},
					tableWidth: 217 //250
				});


			}

			// #endregion Customer Address


			// #region Return Address

			var BOcompanytxtID = document.getElementById(BOcompanyid);
			if (BOcompanytxtID === null || BOcompanytxtID === undefined || BOcompanytxtID === '') {

			} else {
				BOcompanyres = doc.autoTableHtmlToJson(document.getElementById(BOcompanyid));
				doc.autoTable(BOcompanyres.columns, BOcompanyres.data, {
					margin: {
						left: 340
					},
					startY: doc.autoTableEndPosY() + 15,
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

			// #endregion return Address

			// #region Vertical Bar code Image

			doc.setFontStyle('normal');
			doc.setFontSize(9);

			$("#barImageArray").JsBarcode(data[j].orderid, {
				format: "CODE128",
				width: 1,
				displayValue: true,
				height: 40
			});
			var VIimg = document.getElementById('barImageArray');
			var rotatedBarcodeCanvas = document.getElementById("rotated-barcode");
			var rotatedBarcodeCanvasContext = rotatedBarcodeCanvas.getContext("2d");

			rotatedBarcodeCanvas.width = VIimg.height;
			rotatedBarcodeCanvas.height = VIimg.width;

			// Rotate
			rotatedBarcodeCanvasContext.translate(VIimg.height / 2, VIimg.width / 2);
			rotatedBarcodeCanvasContext.rotate(270 * Math.PI / 180);
			rotatedBarcodeCanvasContext.drawImage(VIimg, -VIimg.width / 2, -VIimg.height / 2);
			doc.addImage(rotatedBarcodeCanvas.toDataURL(), 'JPEG', 255, 30, 90, 193);

			// #endregion Vertical Bar code Image
		}


		doc.setFontStyle('normal');
		doc.setFontSize(9);
		doc.text("___________________________________________________________________________________________________________", 30, 253); // 102

		doc.text("Date: ", 30, 273); // 117
		Spurchasedate = '';
		Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 80, 273); //45

		doc.text("Invoice No: ", 30, 288); //60
		doc.text(data[j].orderid, 80, 288);

		doc.text("Order No: ", 310, 273); //60
		doc.text(data[j].orderid, 380, 273); //60

		doc.text("Email: ", 310, 288); //45
		doc.text('borisdorisbooks@yahoo.co.uk', 380, 288); //45


		var BOshippos = doc.autoTableEndPosY();

		// #region Shipping Address

		var BOSPAddrvatElementID = document.getElementById(BOSPAddrvatid);
		if (BOSPAddrvatElementID === null || BOSPAddrvatElementID === undefined || BOSPAddrvatElementID === '') {

		} else {
			BOSPAddrvatres = doc.autoTableHtmlToJson(document.getElementById(BOSPAddrvatid));
			doc.autoTable(BOSPAddrvatres.columns, BOSPAddrvatres.data, {
				margin: {
					left: 25
				},
				startY: 298,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 16,
					fontSize: 11
				}
			});
		}

		// #endregion Shipping Address

		var BOEODshippos = doc.autoTableEndPosY();

		// #region Company Return Address 

		var BO_RTcompanyaddElementID = document.getElementById(BO_RTcompanyaddid);
		if (BO_RTcompanyaddElementID === null || BO_RTcompanyaddElementID === undefined || BO_RTcompanyaddElementID === '') {

		} else {
			BO_RTcompanyaddrres = doc.autoTableHtmlToJson(document.getElementById(BO_RTcompanyaddid));
			doc.autoTable(BO_RTcompanyaddrres.columns, BO_RTcompanyaddrres.data, {
				margin: {
					left: 305
				},
				startY: 298,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 14,
					fontSize: 9
				}
			});
		}

		// #endregion Company Return Address 

		doc.setFontStyle('normal');
		doc.setFontSize(9);
		doc.text("___________________________________________________________________________________________________________", 30, BOEODshippos + 10);

		// #region Items Details Grid

		var BOcorderidElementID = document.getElementById(BOcorderid);
		if (BOcorderidElementID === null || BOcorderidElementID === undefined || BOcorderidElementID === '') {

		} else {
			BOcorderres = doc.autoTableHtmlToJson(document.getElementById(BOcorderid));
			doc.autoTable(BOcorderres.columns, BOcorderres.data, {
				margin: {
					left: 25
				},
				startY: BOEODshippos + 20,
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
					row.cells[2].styles.halign = 'right';
					row.cells[3].styles.halign = 'right';
					row.cells[5].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 2) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 5) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		// #endregion Items Details Grid


		var totBoPos = doc.autoTableEndPosY();

		// #region Items Total Calculation Grid

		var BOtotalpriceElementID = document.getElementById(BOtotalpricevatid);
		if (BOtotalpriceElementID === null || BOtotalpriceElementID === undefined || BOtotalpriceElementID === '') {

		} else {
			BOtotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(BOtotalpricevatid));

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

			doc.autoTable(BOtotalpricevatres.columns, BOtotalpricevatres.data, totalpriceoptions);
		}

		// #endregion Items Total Calculation Grid


		// #region Asin Bar code Image

		var boasinImage = $('#BObarImageasin_ppi').attr("src");
		if (typeof boasinImage != 'undefined' && boasinImage !== '' && boasinImage != null) {
			doc.addImage(boasinImage, 'JPEG', 30, totBoPos + 10, 150, 82);
		}

		// #endregion Asin  Bar code Image

		// #region VAT Number

		centeredText("VAT Number GB112094652", 822, 14);

		// #endregion VAT Number

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