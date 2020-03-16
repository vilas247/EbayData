function GizmoznGadgetzInvoicePDF(data) {
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

		var companyid = "GNGcompanylogo_ppi";
		var companyres = '';

		var deliveryid = "GNGdelivery_ppi";
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
		/* Ship address end */

		var channelid = "GNGchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "GNGbasic_ppi";
		var shippingres = '';

		var childid = "GNGorder_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var shipping_service = 'Standard';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "GNGtotalprice_ppi";
		var totpriceres = '';
		
		$('#totalprice_ppi').text(X247Invoices.subtotalunitPrice(j,data[j].orderitems));
		$('#vatprice_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.totalPriceAmt(j,data[j].orderitems,data[j]));

		var returnid = "GNGreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "GNGshippingservice_ppi";
		var shippingserviceres = '';
		
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
			$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/*special shipping service end */

		var boxid = "GNGboxreturnaddress_ppi";
		var boxres = '';
		
		$('#gnshipname_ppi').text(ship_address.Name);
		$('#gnshipaddress1ppi').text(ship_address.Address1);
		$('#gnshipaddress2ppi').text(ship_address.Address2);
		$('#gnshipcity_ppi').text(ship_address.City);
		$('#gnshipstateorregion_ppi').text(ship_address.StateOrRegion);
		$('#gnshippostcode_ppi').text(ship_address.PostCode);
		$('#gnshipcountryname_ppi').text(ship_address.CountryName);

		var newid = "GNGnew_ppi";
		var newres = '';

		var channelpos = '';

		//  var companypos = doc.autoTableEndPosY() + 30;
		var companypos = 30;
		var orderpos = '';
		doc.addImage(X247Invoices.GNGLogo, 'JPEG', 40, companypos, 201, 73);
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
					// // console.log.log("Cell", cell, "Data", data);
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
			// newpos = doc.autoTableEndPosY() + 40;
			newpos = 600;
			lblreturn = newpos - 6;

			if (returnyPosition >= DynamicPGSize) {
				// if (returnyPosition >= 550) {
				doc.addPage();
			}

			doc.setFontSize(8);
			doc.setFontType("bold");
			doc.text('FOR RETURNS NOTE INFORMATION PLEASE REFER TO WEBSITE', 40, lblreturn);
			doc.autoTable(returnres.columns, returnres.data, {
				// startY: doc.autoTableEndPosY() + 40,
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

			boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
			doc.autoTable(boxres.columns, boxres.data, {
				margin: {
					left: 65
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
			doc.text('If undelivered please return to: Gizmoz n Gadgetz,Unit 22,Riverside Business Centre (Rear Doors),', 50, newpos + 178);
			doc.text('High Wycombe,Bucks, HP11 2QS,United Kingdom', 50, newpos + 189);

			var GNGcountryCodechecking = data[j];
			if (typeof GNGcountryCodechecking.['shippingaddresses'][0].CountryCode !== 'undefined') {
				if (GNGcountryCodechecking.['shippingaddresses'][0].CountryCode === "GB" || GNGcountryCodechecking.['shippingaddresses'][0].CountryCode === 'UK' || GNGcountryCodechecking.['shippingaddresses'][0].CountryCode === 'United Kingdom') {

					// orderitems.item
					var GNGshprice = '';
					if (data[j].orderitems.length > 0) {
						if (typeof data[j].orderitems[0].ShippingPrice !== 'undefined' && data[j].orderitems[0].ShippingPrice !== '' && data[j].orderitems[0].ShippingPrice !== null) {
							GNGshprice = data[j].orderitems[0].ShippingPrice;
						}
					}

					if (parseFloat(GNGshprice) > 0 && parseFloat(GNGshprice) < 5) {
						doc.addImage(X247Invoices.GNG24Logo, 'JPEG', 250, newpos + 6, 301, 57);
						doc.setFontType("bold");
						doc.setFontSize(8);
						doc.text('POSTAGE PAID GB', 472, newpos + 50);
						// doc.text('HQ49071', 472, newpos + 60);
						doc.text('HQ59391', 472, newpos + 60);
					} else if (parseFloat(GNGshprice) >= 5) {
						doc.setFontType("bold");
						doc.setFontSize(12);
						doc.text('TRACKED', 265, newpos + 50);
					} else {
						doc.addImage(X247Invoices.GNG48Logo, 'JPEG', 250, newpos + 6, 301, 57);
						doc.setFontType("bold");
						doc.setFontSize(8);
						doc.text('POSTAGE PAID GB', 472, newpos + 50);
						//    doc.text('HQ49071', 472, newpos + 60);
						doc.text('HQ59391', 472, newpos + 60);
					}
				} else {
					doc.addImage(X247Invoices.GNGAirmail, 'JPEG', 250, newpos + 6, 301, 57);
					doc.setFontType("bold");
					doc.setFontSize(8);
					doc.text('POSTAGE PAID GB', 472, newpos + 50);
					//   doc.text('HQ49071', 472, newpos + 60);
					doc.text('HQ59391', 472, newpos + 60);
				}
			} else {
				var GNGshprice = '';
				if (data[j].orderitems.length > 0) {
					if (typeof data[j].orderitems[0].ShippingPrice !== 'undefined' && data[j].orderitems[0].ShippingPrice !== '' && data[j].orderitems[0].ShippingPrice !== null) {
						GNGshprice = data[j].orderitems[0].ShippingPrice;
					}
				}

				if (parseFloat(GNGshprice) > 0 && parseFloat(GNGshprice) < 5) {
					doc.addImage(X247Invoices.GNG24Logo, 'JPEG', 250, newpos + 6, 301, 57);
					doc.setFontType("bold");
					doc.setFontSize(8);
					doc.text('POSTAGE PAID GB', 472, newpos + 50);
					//  doc.text('HQ49071', 472, newpos + 60);
					doc.text('HQ59391', 472, newpos + 60);
				} else if (parseFloat(GNGshprice) >= 5) {

				} else {
					doc.addImage(X247Invoices.GNG48Logo, 'JPEG', 250, newpos + 6, 301, 57);
					doc.setFontType("bold");
					doc.setFontSize(8);
					doc.text('POSTAGE PAID GB', 472, newpos + 50);
					//  doc.text('HQ49071', 472, newpos + 60);
					doc.text('HQ59391', 472, newpos + 60);
				}
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