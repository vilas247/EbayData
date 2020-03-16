/* Amazon Invoice */
function amazoninvoicePDF(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0, kj = 0; j < data.length; j++, kj++) {
		$(".testempty_"+j).html(X247Invoices.testempty);
		$(".testempty1_"+j).html(X247Invoices.testempty1);
		var totalPagesExp = data.length;
		var footer = function (data) {
			var pageno = kj + 1;
			var str = pageno;
			if (typeof doc.putTotalPages === 'function') {
				str = str + " / " + totalPagesExp;
			}
			doc.setFontSize(6);
			doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
			doc.setFontSize(6);
		};
		var options = {
			afterPageContent: footer,
			margin: {
				top: 80
			}
		};


		var AZreturnaddressid = "AZreturnaddress_ppi";
		var AZreturnres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1_ppi').text(ship_address.Address1);
			$('#shipaddress2_ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
			$('#shipphone_ppi').text(ship_address.Phone);
			$('#shipemail_ppi').text(ship_address.Email);
		/* Ship address end */

		var AZDashid = "AZDash_ppi";
		var AZDashres = '';

		var AZOrderChannelid = "AZOrderChannel_ppi";
		var AZOrderChannelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		/* channel data end */

		var AZDeliveryAddressid = "AZDeliveryAddress_ppi";
		var AZDeliveryAddressres = '';

		var AZboxreturnaddressid = "AZboxreturnaddress_ppi";
		var AZboxreturnaddressres = '';
		
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

		var AZorderid = "AZorder_ppi";
		var AZorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Quantity']+"</td><td><p>"+multiple_orders[jm]['ProductTitle']+"</p><p>"+X247Invoices.testempty+"</p><p>SKU : "+multiple_orders[jm]['Sku']+"</p><p>"+X247Invoices.testempty+"</p><p>ASIN : "+multiple_orders[jm]['ASIN']+"</p></td><td>"+multiple_orders[jm]['TotalPrice']+"</td><td><p>SubTotal : "+multiple_orders[jm]['UnitPrice']+"</p><p>"+X247Invoices.testempty+"</p><p>Shipping Price : "+multiple_orders[jm]['ShippingPrice']+"</p><p>"+X247Invoices.testempty+"</p><p>--------------------</p><p>"+X247Invoices.testempty1+"</p><p>Total : "+multiple_orders[jm]['TotalPrice']+"</p><p>"+X247Invoices.testempty+"</p><p>--------------------</p></td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */
		
		var AZboxOrderid = "AZboxOrder_ppi";
		var AZboxOrderres = '';
		
		/* order data */
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		$('#shippingservice_ppi').text(shipping_service);
		$('#buyername_ppi').text(ship_address.Name);
		/* order data end */

		var AZThanqTextid = "AZThanqText_ppi";
		var AZThanqTextres = '';

		var AZOrderTotalid = "AZOrderTotal_ppi";
		var AZOrderTotalres = '';
		/*totalprice */
			$('#totalprice_ppi').text(data[j].totalprice);
		/* total price end */

		var AZTotalBoxid = "AZTotalBox_ppi";
		var AZTotalBoxres = '';

		var newid = "newAmazon_ppi";
		var newres = '';

		var companypos = 30;

		var AZreturnaddressElementID = document.getElementById(AZreturnaddressid);
		if (AZreturnaddressElementID === null || AZreturnaddressElementID === undefined || AZreturnaddressElementID === '') {

		} else {
			AZreturnres = doc.autoTableHtmlToJson(document.getElementById(AZreturnaddressid));
			doc.autoTable(AZreturnres.columns, AZreturnres.data, {
				startY: companypos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 17,
					fontSize: 12,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontStyle = 'normal';
					row.cells[0].styles.fontSize = 12;
				}
			});
		}

		var AZDashElementID = document.getElementById(AZDashid);
		if (AZDashElementID === null || AZDashElementID === undefined || AZDashElementID === '') {

		} else {

			AZDashres = doc.autoTableHtmlToJson(document.getElementById(AZDashid));
			var Dashoptions = {
				startY: doc.autoTableEndPosY() + 10,
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8
				}
			};
			doc.autoTable(AZDashres.columns, AZDashres.data, Dashoptions);
		}


		var AZOrderChannelElementID = document.getElementById(AZOrderChannelid);
		if (AZOrderChannelElementID === null || AZOrderChannelElementID === undefined || AZOrderChannelElementID === '') {

		} else {
			AZOrderChannelres = doc.autoTableHtmlToJson(document.getElementById(AZOrderChannelid));
			doc.autoTable(AZOrderChannelres.columns, AZOrderChannelres.data, {
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 12
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].fontStyle = 'bold';
					row.cells[0].fontSize = 12;
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.fontStyle = 'normal';
						cell.styles.fontSize = 10;
					}
				}
			});
		}


		var newpos = 0;
		var lblreturn = 0;

		var AZDeliveryAddressElementID = document.getElementById(AZDeliveryAddressid);
		if (AZDeliveryAddressElementID === null || AZDeliveryAddressElementID === undefined || AZDeliveryAddressElementID === '') {

		} else {
			AZDeliveryAddressres = doc.autoTableHtmlToJson(document.getElementById(AZDeliveryAddressid));
			var newpos = doc.autoTableEndPosY() + 10;
			doc.autoTable(AZDeliveryAddressres.columns, AZDeliveryAddressres.data, {
				startY: newpos,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [164, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 155,
					fontSize: 8
				}
			});

			lblreturn = doc.autoTableEndPosY();

			AZboxreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(AZboxreturnaddressid));
			doc.autoTable(AZboxreturnaddressres.columns, AZboxreturnaddressres.data, {
				margin: {
					left: 45
				},
				startY: newpos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 10,
					overflow: 'linebreak'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontSize = 10;
				},
				tableWidth: 190
			});

			AZboxOrderres = doc.autoTableHtmlToJson(document.getElementById(AZboxOrderid));
			doc.autoTable(AZboxOrderres.columns, AZboxOrderres.data, {
				margin: {
					left: 240
				},
				startY: newpos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 10,
					overflow: 'linebreak'
				},
				tableWidth: 250,
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[0].styles.fontStyle = 'normal';
					row.cells[1].styles.fontStyle = 'normal';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.halign = 'right';
						cell.styles.fontStyle = 'normal';
					}
				}
			});
		}


		var AZorderElementID = document.getElementById(AZorderid);
		if (AZorderElementID === null || AZorderElementID === undefined || AZorderElementID === '') {

		} else {
			AZorderres = doc.autoTableHtmlToJson(document.getElementById(AZorderid));
			doc.autoTable(AZorderres.columns, AZorderres.data, {
				startY: lblreturn + 20,
				pageBreak: 'auto',
				afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [164, 164, 164],
					lineWidth: 0.5,
					fontSize: 8
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				createdCell: function (cell, data) {
					//console.log(cell, data);
					if (data.column.dataKey == 1) {
						cell.styles.halign = 'left';
					}
					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';

					}
				},
				drawHeaderRow: function (row, data) {
					row.cells[3].styles.halign = 'right';
				},
				columnStyles: {
					1: {
						width: 150
					}
				}

				//createdCell: function (cell, data) {
				//    if (data.column.dataKey == 2) {
				//        cell.styles.halign = 'left';
				//        cell.styles.fontStyle = 'bold';
				//    }

				//    if (data.column.dataKey == 4) {
				//        cell.styles.halign = 'right';
				//    }
				//    if (data.column.dataKey == 3) {
				//        cell.styles.halign = 'right';
				//    }
				//}
			});
		}

		var AZTotalBoxElementID = document.getElementById(AZTotalBoxid);
		if (AZTotalBoxElementID === null || AZTotalBoxElementID === undefined || AZTotalBoxElementID === '') {

		} else {
			AZTotalBoxres = doc.autoTableHtmlToJson(document.getElementById(AZTotalBoxid));
			doc.autoTable(AZTotalBoxres.columns, AZTotalBoxres.data, {
				startY: doc.autoTableEndPosY(),
				pageBreak: 'auto',
				afterPageContent: footer,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [164, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 30,
					fontSize: 8
				}
			});

			var AZOrderTotalElementID = document.getElementById(AZOrderTotalid);
			if (AZOrderTotalElementID === null || AZOrderTotalElementID === undefined || AZOrderTotalElementID === '') {

			} else {
				AZOrderTotalres = doc.autoTableHtmlToJson(document.getElementById(AZOrderTotalid));
				doc.autoTable(AZOrderTotalres.columns, AZOrderTotalres.data, {
					margin: {
						left: 428
					},
					startY: doc.autoTableEndPosY() - 25,
					pageBreak: 'auto',
					theme: 'plain',
					styles: {
						rowHeight: 15,
						fontSize: 10,
						overflow: 'linebreak',
						fontStyle: 'bold',
						lineColor: [255, 255, 255],
						lineWidth: 0
					},
					drawHeaderRow: function (row, data) {
						row.cells[0].styles.fontSize = 10;
						row.cells[1].styles.fontSize = 10;
						row.cells[0].styles.halign = 'right';
						row.cells[1].styles.halign = 'right';
					}
				});
			}
		}

		if (AZThanqTextid === null || AZThanqTextid === undefined || AZThanqTextid === '') {

		} else {
			AZThanqTextres = doc.autoTableHtmlToJson(document.getElementById(AZThanqTextid));
			doc.autoTable(AZThanqTextres.columns, AZThanqTextres.data, {
				startY: doc.autoTableEndPosY() + 33,
				pageBreak: 'avoid',
				afterPageContent: footer,
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontStyle = 'normal';
				},
			});
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