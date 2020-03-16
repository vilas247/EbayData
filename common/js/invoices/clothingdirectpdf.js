function clothingDirectPDF(data) {
	
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 80
			}
		};


		var CDcompanyAddressid = "CDcompanyAddress_ppi";
		var CDcompanyAddressres = '';
		if(data[j].accountname == "eBay - SL"){
			$('#CDemail_ppi').text('Email:info@secretlabel.co.uk');
		}else if(data[j].accountname == "eBay - BBC"){
			$('#CDemail_ppi').text('Email:info@bigbrandsclothing.co.uk');
		}else{
			$('#CDemail_ppi').text('Email:info@secretlabel.co.uk');
		}

		var CDProductInfoid = "CDProductInfo_ppi";
		var CDProductInfores = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var subtotal = 0;
		var shipping = 0;
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				subtotal += parseFloat(multiple_orders[jm]['UnitPrice']);
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['BinLocation']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
				shipping += parseFloat(multiple_orders[jm]['ShippingPrice']);
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var CDTotalPriceVatid = "CDTotalPriceVat_ppi";
		var CDTotalPriceVatres = '';
		
		$('#subtotalprice_ppi').text(subtotal);
		$('#postagepacking_ppi').text(shipping);
		$('#ordertotal_ppi').text(shipping + subtotal);
		$('#CDpaymentmethod_ppi').text(data[j].paymentmethod);

		var CDShipingAddressid = "CDShipingAddress_ppi";
		var CDShipingAddressres = '';
		
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
			
			
			$('#CDshipname_ppi').text(ship_address.Name);
			$('#CDshipaddress1ppi').text(ship_address.Address1);
			$('#CDshipaddress2ppi').text(ship_address.Address2);
			$('#CDshipcity_ppi').text(ship_address.City);
			$('#CDshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#CDshippostcode_ppi').text(ship_address.PostCode);
			$('#CDshipcountryname_ppi').text(ship_address.CountryName);
			$('#CDshipphone_ppi').text(ship_address.Phone);
			$('#CDshipemail_ppi').text(ship_address.Email);
		/* Ship address end */

		var newid = "newvat_ppi";
		var newres = '';

		var CDPelStickerAddressid = "CDPelStickerAddress_ppi";
		var CDPelStickerAddressres = '';
		
		var CDOrderInfoid = "CDOrderInfo_ppi";
		var CDOrderInfores = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		if(ship_address.Name != '' && ship_address.Name != null){
			$('#CDcustomer_ppi').html("<td>"+ship_address.Name+"</td>");
		}
		/* channel data end */

		var channelpos = 30;

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

		var imagePos = 110;
		if (data[j].accountname === 'eBay - BBC') {
			var secretLogo = X247Invoices.secretLogo1;
			doc.addImage(secretLogo, 'JPEG', 40, 30, 220, 22);
		} else if (data[j].accountname === 'eBay - SL') {
			var secretLogo = X247Invoices.secretLogo2;
			doc.addImage(secretLogo, 'JPEG', 40, 30, 200, 35);
		} else if (data[j].accountname === 'Amazon - BIG BRANDS CLOTHING CO') {
			var secretLogo = X247Invoices.secretLogo3;
			doc.addImage(secretLogo, 'JPEG', 40, 30, 220, 22);
		} else {
			var secretLogo = X247Invoices.secretLogo4;
			doc.addImage(secretLogo, 'JPEG', 40, 30, 200, 129);
			imagePos = 149;
		}

		var CDcompanyAddressElementID = document.getElementById(CDcompanyAddressid);
		if (CDcompanyAddressElementID === null || CDcompanyAddressElementID === undefined || CDcompanyAddressElementID === '') {} else {
			CDcompanyAddressres = doc.autoTableHtmlToJson(document.getElementById(CDcompanyAddressid));
			doc.autoTable(CDcompanyAddressres.columns, CDcompanyAddressres.data, {
				startY: imagePos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal',
					rowHeight: 16
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
				tableWidth: 275
			});
		}

		var compAddressPos = doc.autoTableEndPosY() + 10;

		var CDOrderInfoElementID = document.getElementById(CDOrderInfoid);
		if (CDOrderInfoElementID === null || CDOrderInfoElementID === undefined || CDOrderInfoElementID === '') {} else {
			CDOrderInfores = doc.autoTableHtmlToJson(document.getElementById(CDOrderInfoid));
			doc.autoTable(CDOrderInfores.columns, CDOrderInfores.data, {
				margin: {
					left: 285
				},
				startY: imagePos, //doc.autoTableEndPosY() + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal',
					rowHeight: 16
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
				tableWidth: 275
			});
		}

		var CDProductInfoElementID = document.getElementById(CDProductInfoid);
		if (CDProductInfoElementID === null || CDProductInfoElementID === undefined || CDProductInfoElementID === '') {

		} else {
			CDProductInfores = doc.autoTableHtmlToJson(document.getElementById(CDProductInfoid));
			doc.autoTable(CDProductInfores.columns, CDProductInfores.data, {
				startY: compAddressPos,
				pageBreak: 'auto',
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					//lineWidth: 0.5,
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal',
					rowHeight: 16
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal',
					rowHeight: 16
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

		var CDTotalPriceVatElementID = document.getElementById(CDTotalPriceVatid);
		if (CDTotalPriceVatElementID === null || CDTotalPriceVatElementID === undefined || CDTotalPriceVatElementID === '') {

		} else {
			CDTotalPriceVatres = doc.autoTableHtmlToJson(document.getElementById(CDTotalPriceVatid));

			var totalpriceoptions = {
				margin: {
					left: 367
				},
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					//lineWidth: 0.5,
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'normal',

				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				drawHeaderRow: function (row, data) {
					row.cells[1].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 1) {
						cell.styles.halign = 'right';
					}
				}
			};

			doc.autoTable(CDTotalPriceVatres.columns, CDTotalPriceVatres.data, totalpriceoptions);
		}

		var CDShipingAddressElementID = document.getElementById(CDShipingAddressid);
		if (CDShipingAddressElementID === null || CDShipingAddressElementID === undefined || CDShipingAddressElementID === '') {} else {
			CDShipingAddressres = doc.autoTableHtmlToJson(document.getElementById(CDShipingAddressid));
			doc.autoTable(CDShipingAddressres.columns, CDShipingAddressres.data, {

				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal',
					rowHeight: 16
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
				tableWidth: 275
			});
		}


		var secretLogo = X247Invoices.secretLogo5;
		doc.addImage(secretLogo, 'JPEG', 246, 593, 225, 62);
		var CDPelStickerAddressElementID = document.getElementById(CDPelStickerAddressid);
		if (CDPelStickerAddressElementID === null || CDPelStickerAddressElementID === undefined || CDPelStickerAddressElementID === '') {} else {
			CDPelStickerAddressres = doc.autoTableHtmlToJson(document.getElementById(CDPelStickerAddressid));
			doc.autoTable(CDPelStickerAddressres.columns, CDPelStickerAddressres.data, {
				margin: {
					//left: 30
					left: 85
				},
				// startY: 655,
				startY: 660,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal',
					rowHeight: 16
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
				tableWidth: 275
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