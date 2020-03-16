/* Ebay Invoice */
function eBayinvoicePDF(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {
		var totalPagesExp = data.length;
		var footer = function (data) {
			var pageno = j + 1;
			var str = pageno;
			if (typeof doc.putTotalPages === 'function') {
				str = str + " / " + totalPagesExp;
			}
			doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
			doc.setFontSize(6);
		};

		var options = {
			afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var ebayreturnaddressid = "ebayreturnaddress_ppi";
		var ebayreturnaddressres = '';
		
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

		var ebayDashid = "ebayDash_ppi";
		var ebayDashres = '';
		
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		$('#orderid_ppi').text(data[j]['orderid']);
		/* channel data end */

		var ebayorderid = "ebayorder_ppi";
		var ebayorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Quantity']+"</td><td><span>"+multiple_orders[jm]['OrderLineItemId']+"</span></td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var ebaytotalpriceid = "ebaytotalprice_ppi" ;
		var ebaytotalpriceres = '';
		
		/* order data */
			$('#shippingservice_ppi').text(shipping_service);
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		/* order data end */

		var ebayEmptyTableid = "ebayEmptyTable_ppi";
		var ebayEmptyTableres = '';

		var newid = "newebay_ppi";
		var newres = '';


		var companypos = 30;

		var ebayreturnaddressElementID = document.getElementById(ebayreturnaddressid);
		if (ebayreturnaddressElementID === null || ebayreturnaddressElementID === undefined || ebayreturnaddressElementID === '') {

		} else {
			ebayreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(ebayreturnaddressid));
			// console.log("AZ", ebayreturnaddressres);
			doc.autoTable(ebayreturnaddressres.columns, ebayreturnaddressres.data, {
				startY: companypos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 10,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontStyle = 'normal';
					row.cells[0].styles.fontSize = 10;
				},
				createdCell: function (cell, data) {
					if (data.row.index == 0) {
						cell.styles.fontStyle = 'bold';
					}
				}
			});
		}

		var invoiceTextPos = doc.autoTableEndPosY();
		doc.setFontSize(12);
		doc.setFontType("bold");
		doc.text('Invoice/Packing slip', 418, doc.autoTableEndPosY() + 10);


		var ebayDashElementID = document.getElementById(ebayDashid);
		if (ebayDashElementID === null || ebayDashElementID === undefined || ebayDashElementID === '') {

		} else {
			ebayDashres = doc.autoTableHtmlToJson(document.getElementById(ebayDashid));
			var Dashoptions = {
				margin: {
					left: 415
				},
				startY: invoiceTextPos + 20,
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak',
					columnWidth: 'wrap'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].fontStyle = 'normal';
					row.cells[0].fontSize = 12;
					row.cells[1].fontStyle = 'normal';
					row.cells[1].fontSize = 12;
				}
			};
			doc.autoTable(ebayDashres.columns, ebayDashres.data, Dashoptions);
		}


		var ebayEmptyTableElementID = document.getElementById(ebayEmptyTableid);
		if (ebayEmptyTableElementID === null || ebayEmptyTableElementID === undefined || ebayEmptyTableElementID === '') {

		} else {
			ebayEmptyTableres = doc.autoTableHtmlToJson(document.getElementById(ebayEmptyTableid));
			doc.autoTable(ebayEmptyTableres.columns, ebayEmptyTableres.data, {
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [255, 255, 255],
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
				}
			});
		}


		var ebayorderElementID = document.getElementById(ebayorderid);
		if (ebayorderElementID === null || ebayorderElementID === undefined || ebayorderElementID === '') {

		} else {
			ebayorderres = doc.autoTableHtmlToJson(document.getElementById(ebayorderid));
			doc.autoTable(ebayorderres.columns, ebayorderres.data, {
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [255, 255, 255],
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

					if (data.column.dataKey == 2) {
						cell.styles.columnWidth = 'wrap';
					}
				}
			});
		}

		var ebaytotalpriceElementID = document.getElementById(ebaytotalpriceid);
		if (ebaytotalpriceElementID === null || ebaytotalpriceElementID === undefined || ebaytotalpriceElementID === '') {

		} else {
			ebaytotalpriceres = doc.autoTableHtmlToJson(document.getElementById(ebaytotalpriceid));
			doc.autoTable(ebaytotalpriceres.columns, ebaytotalpriceres.data, {
				margin: {
					// left: 363
					left: 250
				},
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [255, 255, 255],
					//  lineColor: [0, 0, 0],
					lineWidth: 0,
					fontSize: 10,
					columnWidth: 'wrap'
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
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.halign = 'right';
					row.cells[1].styles.columnWidth = 'wrap';
					row.cells[0].styles.fontStyle = 'normal';
					row.cells[1].styles.fontStyle = 'normal';
				},
				createdCell: function (cell, data) {
					cell.styles.halign = 'right';
					if (data.row.index == 2) {
						data.row.cells[0].styles.fontStyle = 'bold';
						data.row.styles.fontStyle = 'bold';
						data.row.styles.fontStyle = 'bold';
					}

					if (data.row.index == 0) {
						data.row.cells[0].styles.columnWidth = 'wrap';
					}
				},
				// tableWidth: 100
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