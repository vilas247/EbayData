function PannuDesignInvoicePDF(data) {
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


		var PNDcompanyid = "PND_companyaddr_ppi";
		var PNDcompanyres = '';

		var PNDStampBoxid = "PNDStampBox_ppi";
		var PNDStampBoxres = '';

		var PNDreturnaddressvatid = "PNDreturnaddressvat_ppi";
		var PNDreturnaddressvatres = '';
		
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

		var PNDSPAddrvatid = "PNDSPAddrvat_ppi";
		var PNDSPAddrvatres = '';
		
		/*Ship address */
			$('#pnshipname_ppi').text(ship_address.Name);
			$('#pnshipaddress1ppi').text(ship_address.Address1);
			$('#pnshipaddress2ppi').text(ship_address.Address2);
			$('#pnshipcity_ppi').text(ship_address.City);
			$('#spnhipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#pnshippostcode_ppi').text(ship_address.PostCode);
			$('#pnshipcountryname_ppi').text(ship_address.CountryName);
			$('#pnshipphone_ppi').text(ship_address.Phone);
			$('#pnshipemail_ppi').text(ship_address.Email);
		/* Ship address end */

		var PNDcorderid = "PNDcorder_ppi";
		var PNDcorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['ProductTitle']+"</span><p>"+X247Invoices.testempty+"</p><p>SKU : "+multiple_orders[jm]['Sku']+"</p><p>"+X247Invoices.testempty+"</p><p>ItemId : "+multiple_orders[jm]['orderlineitemid']+"</p></td><td>"+multiple_orders[jm]['itemcondition']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>0.00</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var PNDtotalpricevatid = "PNDtotalpricevat_ppi";
		var PNDtotalpricevatres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var newid = "PNDnew_ppi";
		var newres = '';
		var startpos = 10;


		// #region Company Logo

		doc.addImage(X247Invoices.PNDLogo, 'JPEG', 437, startpos + 57, 123, 145);

		// #endregion Company Logo

		// #region Company Address

		var PNDcompanyElementID = document.getElementById(PNDcompanyid);
		if (PNDcompanyElementID === null || PNDcompanyElementID === undefined || PNDcompanyElementID === '') {

		} else {
			PNDcompanyres = doc.autoTableHtmlToJson(document.getElementById(PNDcompanyid));
			doc.autoTable(PNDcompanyres.columns, PNDcompanyres.data, {
				margin: {
					left: 340
				},
				//  startY: 161,
				startY: 220,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal',
					halign: 'right'

				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold',
					halign: 'right'
				},
				tableWidth: 215
			});


		}

		// #endregion Company Address

		// #region PPL Stamp  

		var PNDStampBoxElementID = document.getElementById(PNDStampBoxid);
		if (PNDStampBoxElementID === null || PNDStampBoxElementID === undefined || PNDStampBoxElementID === '') {

		} else {

			var PNDrtAddrElementID = document.getElementById(PNDreturnaddressvatid);
			if (PNDrtAddrElementID === null || PNDrtAddrElementID === undefined || PNDrtAddrElementID === '') {

			} else {
				PNDreturnaddressvatres = doc.autoTableHtmlToJson(document.getElementById(PNDreturnaddressvatid));
				doc.autoTable(PNDreturnaddressvatres.columns, PNDreturnaddressvatres.data, {
					margin: {
						left: 32
						// left: 17
					},
					startY: 180,
					//startY: 208,
					pageBreak: 'auto',
					theme: 'plain',
					styles: {
						overflow: 'linebreak',
						// fontSize: 14,
						fontSize: 10,
						fontStyle: 'normal',
						rowHeight: 16
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						//  fontSize: 14,
						fontSize: 10,
						textColor: [0, 0, 0],
						fontStyle: 'bold',
						rowHeight: 16
					},
					bodyStyles: {
						fillColor: [255, 255, 255],
						textColor: [0, 0, 0]
					},
					tableWidth: 275
				});

				doc.setFontSize(6);
				doc.setFontType("normal");
				doc.text('If undelivered,please return to: Pannu Furniture Designs LTD Unit 60 Great Western Close,', 38, doc.autoTableEndPosY() + 10);
				doc.text('Great Western Bussiness Park Bimingham B18 4QF GB', 38, doc.autoTableEndPosY() + 22);
				doc.setFontSize(9);
			}

			// #region Universal Stamp

			doc.addImage(X247Invoices.PNDPPL48, 'JPEG', 147, 137, 175, 40);
			doc.setFontSize(6);
			doc.setFontType("bold");
			// doc.text('POSTAGE PAID GB', 290, 170);
			doc.text('POSTAGE PAID GB', 262, 162);
			doc.setFontSize(7);
			// doc.text('HQ85800', 290, 180);
			doc.text('HQ85800', 262, 172);
			doc.setFontType("normal");

			// #endregion Universal Stamp
		}


		// #endregion PPL Stamp

		doc.setFontSize(16);
		doc.setFontType("bold");

		doc.text("Pannu Furniture Designs Ltd", 28, 335);
		doc.setFontSize(9);
		doc.setFontType("bold");
		doc.text('Order Number :', 28, 350);
		doc.text('Customer:', 28, 365);
		doc.text('Shipping Service:', 28, 380);
		doc.text('Date:', 28, 395);


		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text(data[j].orderid, 100, 350);
		doc.text(data[j].shippingaddresses[0].Name, 80, 365);
		doc.text("Royal Mail 2nd Class", 110, 380);
		doc.text(data[j].purchasedate, 55, 395);

		// #region Items Details Grid

		var PNDOrderElementID = document.getElementById(PNDcorderid);
		if (PNDOrderElementID === null || PNDOrderElementID === undefined || PNDOrderElementID === '') {

		} else {
			PNDcorderres = doc.autoTableHtmlToJson(document.getElementById(PNDcorderid));
			doc.autoTable(PNDcorderres.columns, PNDcorderres.data, {
				margin: {
					left: 28
				},
				startY: 405,
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
					row.cells[1].styles.halign = 'right';
					row.cells[3].styles.halign = 'right';
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if ((data.column.dataKey == 1) || (data.column.dataKey == 3) || (data.column.dataKey == 4)) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		// #endregion Items Details Grid

		// #region Items Total Calculation Grid
		var totendPOS = 0;
		var PNDtotalpriceElementID = document.getElementById(PNDtotalpricevatid);
		if (PNDtotalpriceElementID === null || PNDtotalpriceElementID === undefined || PNDtotalpriceElementID === '') {

		} else {
			PNDtotalpricevatres = doc.autoTableHtmlToJson(document.getElementById(PNDtotalpricevatid));

			var totalpriceoptions = {
				margin: {
					left: 367
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

			doc.autoTable(PNDtotalpricevatres.columns, PNDtotalpricevatres.data, totalpriceoptions);
			totendPOS = doc.autoTableEndPosY();
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