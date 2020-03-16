function michaelPDF(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	
	var courier_label = $('body #courierlabel_select').val();
	var services_label = $('body #serviceslabel_select').val();
	var template_label = $('body #templatelabel_select').val();
	
	for (var j = 0; j < data.length; j++) {
		var totalPagesExp = data.length;
		var options = {
			// afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var companyid = "stcompanylogo_ppi";
		var companyres = '';

		var channelid = "stchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "stbasic_ppi";
		var shippingres = '';

		var childid = "storder_ppi";
		var childres = '';
		
		/* orders data */
		var subtotal = 0;
		var shipping = 0;
		var shipping_service = 'Standard';
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping +=parseFloat( multiple_orders[jm]['shippingprice']);
				shipping_service = multiple_orders[jm]['ShippingService'];
				subtotal += parseFloat(multiple_orders[jm]['UnitPrice']);
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['binlocation']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "sttotalprice_ppi";
		var totpriceres = '';
		
		$('#totalprice_ppi').text(subtotal);
		$('#carriage_ppi').text(shipping);
		$('#grandtotal_ppi').text(parseFloat(parseFloat(shipping) + parseFloat((subtotal)).toFixed(2));

		var returnid = "streturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "stshippingservice_ppi";
		var shippingserviceres = '';
		
		$('#shippingservice_ppi').text(shipping_service);
		$('#paymentmethod_ppi').text(data[j].paymentmethod);

		var boxid = "stboxreturnaddress_ppi";
		var boxres = '';
		
		var deliveryid = "stdelivery_ppi";
		var deliveryres = '';
		
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
			
			$('#stshipname_ppi').text(ship_address.Name);
			$('#stshipaddress1ppi').text(ship_address.Address1);
			$('#stshipaddress2ppi').text(ship_address.Address2);
			$('#stshipcity_ppi').text(ship_address.City);
			$('#stshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#stshippostcode_ppi').text(ship_address.PostCode);
			$('#stshipcountryname_ppi').text(ship_address.CountryName);
		/* Ship address end */

		var newid = "stnew_ppi";
		var newres = '';

		var channelpos = '';

		//  var companypos = doc.autoTableEndPosY() + 30;
		var companypos = 30;
		var orderpos = '';


		if (X247Invoices.imgbase64companylogo != '') {

			var heightimg = 0;
			var widthimg = 0;

			if (X247Invoices.imgbaseHeight <= 73) {
				heightimg = X247Invoices.imgbaseHeight;
			} else {
				heightimg = 73;
			}

			if (X247Invoices.imgbasewidth <= 201) {
				widthimg = X247Invoices.imgbasewidth;
			} else {
				widthimg = 73;
			}

			doc.addImage(X247Invoices.imgbase64companylogo, 'JPEG', 40, 30, 201, 73);
			// iscompanyimage = 1;
		}


		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				//  margin: { left: 403 },
				margin: {
					left: 380
				},
				startY: companypos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 15,
					fontSize: 8
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
			orderpos = doc.autoTableEndPosY() + 30;
			var shippingoptions = {
				startY: doc.autoTableEndPosY() - 15,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8
				},
				tableWidth: 200,
				createdCell: function (cell, data) {
					if (data.column.dataKey == 8) {
						cell.styles.fontStyle = 'bold';
					}
				}

			};
			doc.autoTable(shippingres.columns, shippingres.data, shippingoptions);
		}


		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					fontSize: 8
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
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
					if (data.column.dataKey == 4) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 3) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		var shipservicepos = '';
		var shippingserviceElementID = document.getElementById(shippingserviceid);
		if (shippingserviceElementID === null || shippingserviceElementID === undefined || shippingserviceElementID === '') {

		} else {
			shippingserviceres = doc.autoTableHtmlToJson(document.getElementById(shippingserviceid));
			shipservicepos = doc.autoTableEndPosY() + 1;
			var shippingserviceoptions = {
				margin: {
					left: 40
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.fontStyle = 'normal';
					row.cells[1].styles.overflow = 'linebreak';
				},
				createdCell: function (cell, data) {

					if (data.column.dataKey == 0) {
						cell.styles.halign = 'right';
						cell.styles.fontStyle = 'bold';
					}
					cell.styles.fontSize = '8';
				},
				tableWidth: 275,
				styles: {
					overflow: 'linebreak'
				}
			};

			doc.autoTable(shippingserviceres.columns, shippingserviceres.data, shippingserviceoptions);
		}


		var totalpriceElementID = document.getElementById(totpriceid);
		if (totalpriceElementID === null || totalpriceElementID === undefined || totalpriceElementID === '') {

		} else {
			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			var totalpriceoptions = {
				margin: {
					left: 367
				},
				startY: shipservicepos + 1, //doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					fontSize: 8,
					overflow: 'linebreak'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					//if (data.column.dataKey == 1) {
					cell.styles.halign = 'right';
					// }
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
		}


		var returnyPosition = doc.autoTableEndPosY();
		var newpos = 0;
		var lblreturn = 0;

		var channelElementID = document.getElementById(channelid);
		if (channelElementID === null || channelElementID === undefined || channelElementID === '') {

		} else {
			channelres = doc.autoTableHtmlToJson(document.getElementById(channelid));
			doc.autoTable(channelres.columns, channelres.data, {
				margin: {
					left: 340
				},
				startY: orderpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.fontStyle = 'normal';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.halign = 'right';
						cell.styles.fontStyle = 'bold';
					}
				}
			});
		}


		var returnElementID = document.getElementById(returnid);
		if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

		} else {
			returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
			newpos = 600;
			lblreturn = newpos - 6;

			if (returnyPosition >= DynamicPGSize) {
				doc.addPage();
			}

			doc.setFontSize(8);
			doc.setFontType("bold");
			doc.text('FOR RETURNS NOTE INFORMATION PLEASE REFER TO WEBSITE', 40, lblreturn);
			doc.autoTable(returnres.columns, returnres.data, {
				startY: newpos,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 195,
					fontSize: 8
				}
			});

			if (courier_label == 1) {
				doc.addImage(imgMichelRYLogo24, 'JPEG', 250, newpos + 6, 304, 58);
			}
			if (courier_label == 2) {
				doc.addImage(imgMichelRYLogo48, 'JPEG', 250, newpos + 6, 304, 58);
			}

			doc.setFontType("bold");
			doc.setFontSize(10);

			doc.text("HQ56947", 475, newpos + 60);
			doc.setFontType("normal");
			doc.setFontSize(8);


			boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
			doc.autoTable(boxres.columns, boxres.data, {
				//margin: { left: 65 },
				margin: {
					left: 50
				},
				startY: newpos + 40,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				tableWidth: 182

			});

			doc.setFontType("normal");
			doc.setFontSize(8);
			doc.setFontType("normal");
			doc.setFontSize(8);
			doc.text("If undelivered please return to: St Michael's Hospice Donation Centre,Unit 1,Queensway Avenue South", 50, newpos + 178);
			doc.setFontType("normal");
			doc.setFontSize(8);
			doc.text('St Leonards on Sea,East Sussex,TN38 9AG,United Kingdom', 50, newpos + 189);

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