function EESMusicRoyalMail1ClassPDF(data,iEEStemplate) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}


	for (var j = 0; j < data.length; j++) {
		var EESdatefrom = data[j].purchasedate;
		var mpc = '';
		var n = '';
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')($scope.tempordDetails, {
				"ordernumber": data[j].orderid
			}, true);*/
		}

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFont("helvetica");
			doc.setTextColor(0, 0, 0);
			doc.setFontSize(9);
			doc.text(textOffset, y, text);
		};

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 30
			}
		};

		var deliveryid = "EESdelivery_ppi";
		var deliveryres = '';

		var shippingid = "EESAddress_ppi";
		var shippingres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1_ppi').text(ship_address.Address1);
			$('#shipaddress2_ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
		/* Ship address end */
		
		var childid = "EESorder_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td></td><td></td><td></td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var channelid = "EESchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		$('#shippingservice_ppi').text(shipping_service);
		/* channel data end */

		var totpriceid = "EEStotalprice_ppi";
		var totpriceres = '';
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var returnid = "rmreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "EESshippingservice_ppi";
		var shippingserviceres = '';
		
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
			$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/*special shipping service end */

		var newid = "EESnew_ppi";
		var newres = '';

		var barcodeid = "EESbarcode_ppi";
		var barcoderes = '';
		
		$("#EESbarImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});

		var EESOrderBoxid = "EESOrderBox_ppi";
		var EESOrderBoxres = '';

		var companypos = 30;

		if (iEEStemplate == 1) {
			doc.addImage(X247Invoices.EESRoyalMail1, 'JPEG', 127, 10, 150, 41);
		}
		if (iEEStemplate == 2) {
			doc.addImage(X247Invoices.EESRoyalMail2, 'JPEG', 127, 10, 150, 41);
		}

		doc.addImage(X247Invoices.EESCompanyLogo, 'JPEG', 365, 10, 184, 45);

		doc.setFontType("normal");
		doc.setFontSize(8);

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
			doc.autoTable(shippingres.columns, shippingres.data, {
				margin: {
					left: 30
				},
				//   startY: 95,
				// startY: 68,
				startY: 54,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 11,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 11,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 280
			});
		}
		var shippingPos = doc.autoTableEndPosY() + 30;
		//    var shippingPos = doc.autoTableEndPosY() + 30;
		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 330
				},
				//startY: 120,
				//    startY: 78,
				startY: 54,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 14,
					fontSize: 9,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 9,
					textColor: [0, 0, 0],
					//fontStyle: 'normal'
					fontStyle: 'normal'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					cell.styles.halign = 'right';
				},
				tableWidth: 280
			});
		}

		var deliveryPos = doc.autoTableEndPosY();

		var returnAddressTxt1 = "Return To:EESLtd 18 Brookhouse Buss Park";
		var returnAddressTxt2 = "Brunel Rd, Ipswich, IP2 0EF";

		doc.setFontSize(9);
		doc.setFontType("normal");
		//doc.text(returnAddressTxt1, 75, shippingPos);
		//doc.text(returnAddressTxt2, 125, shippingPos + 20);
		doc.text(returnAddressTxt1, 60, shippingPos);
		doc.text(returnAddressTxt2, 105, shippingPos + 12);
		doc.text(data[j].orderid, 45, shippingPos + 28);
		//doc.addImage(X247Invoices.FDXRoyalLogo, 'JPEG', 140, 20, 275, 95);

		if (iEEStemplate == 1) {
			//  doc.text("Shipping Method: Royal Mail 1st Class", 30, shippingPos + 60);
			//  doc.text("Shipping Method: Royal Mail 1st Class", 30, shippingPos + 67);
			doc.text("Shipping Method: Royal Mail 1st Class", 30, deliveryPos + 43);

		}
		if (iEEStemplate == 2) {
			//  doc.text("Shipping Method: Royal Mail", 30, shippingPos + 60);
			// doc.text("Shipping Method: Royal Mail", 30, shippingPos + 67);
			doc.text("Shipping Method: Royal Mail", 30, deliveryPos + 43);
		}
		if (iEEStemplate == 3) {
			doc.text("Shipping Method: DPD", 30, shippingPos + 60);
		}

		doc.text("Source:" + data[j].saleschannel + " - " + EESdatefrom, 30, deliveryPos + 60);


		var EESOrderBoxElementID = document.getElementById(EESOrderBoxid);
		if (EESOrderBoxElementID === null || EESOrderBoxElementID === undefined || EESOrderBoxElementID === '') {

		} else {

			EESOrderBoxres = doc.autoTableHtmlToJson(document.getElementById(EESOrderBoxid));

			doc.autoTable(EESOrderBoxres.columns, EESOrderBoxres.data, {
				margin: {
					left: 390
				},
				//   startY: deliveryPos + 10,
				startY: deliveryPos + 20,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					//  rowHeight: 155,
					rowHeight: 45,
					fontSize: 9
				},
				tableWidth: 160
			});
			//  doc.text($scope.xmlTempArr[j].invoice.orderid, 400, deliveryPos + 30);
			doc.text(data[j].orderid, 400, deliveryPos + 43);
		};

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 30
				},
				//   startY: deliveryPos + 60,
				startY: deliveryPos + 73,
				pageBreak: 'auto',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					// lineColor: [165, 164, 164],
					lineColor: [0, 0, 0],
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
				headerStyles: {
					fillColor: [211, 211, 211],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'bold',
					fillStyle: 'DF',
					lineColor: [0, 0, 0],
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 1) {
						// cell.styles.halign = 'left';
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 2) {
						// cell.styles.halign = 'right';
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 3 || data.column.dataKey == 4 || data.column.dataKey == 5 || data.column.dataKey == 6 || data.column.dataKey == 7) {
						cell.styles.halign = 'right';
					}
				}
			});
		}

		var totpriceElementID = document.getElementById(totpriceid);
		if (totpriceElementID === null || totpriceElementID === undefined || totpriceElementID === '') {

		} else {

			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			doc.autoTable(totpriceres.columns, totpriceres.data, {
				margin: {
					left: 367
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 14,
					fontSize: 10
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
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					cell.styles.halign = 'right';
				}
			});
		};

		var totlPos = doc.autoTableEndPosY() + 10;
		if (totlPos >= 610) {
			doc.addPage();
		}
		//   doc.addImage(FDXRoyalLogo, 'JPEG', 30, 20, 275, 95);


		if (iEEStemplate == 1) {
			//doc.addImage(EESBottomImage, 'JPEG', 50, 620, 500, 120);
			centeredText('Eastern Entertainment Services Ltd. Registered in UK. Company No. 3688486 www.eesmusic.co.uk', 770);
			centeredText('Registered in UK. Company No. 3688486', 790);
			var txt1 = 'Directors: R Whiting - L Davey VAT Number: GB 720 3194 70 '; // + $scope.EESdatefrom;
			centeredText(txt1, 810);
		}
		if (iEEStemplate == 2) {
			//  doc.addImage(EESBottomImage, 'JPEG', 50, 620, 500, 120);
			centeredText('Eastern Entertainment Services Ltd - www.eesmusic.co.uk - www.facebook.com/EESMusicShop', 770);
			centeredText('Registered in UK. Company No. 3688486', 790);
			centeredText('Directors: L Davey - R Whiting VAT Number: GB 720 3194 70', 810);
		}

		if (iEEStemplate == 3) {
			//  doc.addImage(EESBottomImage, 'JPEG', 50, 620, 500, 120);
			centeredText('Eastern Entertainment Services Ltd. www.eesmusic.co.uk', 760);
			centeredText('Registered in UK. Company No. 3688486', 780);
			centeredText('Directors: R Whiting - L Davey', 800);
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