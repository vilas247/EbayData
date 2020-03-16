function BeautyNestInvoicePDF(data,RMmailtype) {
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

		var deliveryid = "BNestdelivery_ppi";
		var deliveryres = '';

		var shippingid = "BNestAddress_ppi";
		var shippingres = '';
		
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

		var channelid = "BNestchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var childid = "BNestorder_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['UnitPrice']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>0</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "BNesttotalprice_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var returnid = "rmreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "rmshippingservice_ppi";
		var shippingserviceres = '';

		var newid = "BNestnew_ppi";
		var newres = '';

		var barcodeid = "BNestbarcode_ppi";
		var barcoderes = '';
		
		/* barcode */
		$("#BNestbarImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});

		var EESOrderBoxid = "BNestOrderBox_ppi";
		var EESOrderBoxres = '';

		var boxid = "BNestbox_ppi";
		var boxres = '';

		var companypos = 30;

		doc.addImage(beautynestlogo, 'JPEG', 420, 42, 134, 50);


		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 425
				},
				startY: 109,
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
					fontStyle: 'normal',
					halign: 'right'
					// fontStyle: 'bold'
				},
				createdCell: function (cell, data) {
					cell.styles.halign = 'right';
				},
				tableWidth: 280
			});
		}

		doc.setFontType("normal");
		doc.setFontSize(8);

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {

			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
			doc.autoTable(shippingres.columns, shippingres.data, {
				margin: {
					left: 28 //47
				},
				startY: 155, //165,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 12,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 115
			});
		}
		doc.setFontType("bold");
		doc.setFontSize(7);
		var returntxtaddress1 = 'If undelivered please return to:';
		var returntxtaddress2 = 'Beauty Nest LTD 122 Collingwood Road Uxbridge UB8 3EW';

		doc.text(returntxtaddress1, 28, 285);
		doc.setFontType("normal");
		doc.setFontSize(7);
		doc.text(returntxtaddress2, 28, 295);

		if (RMmailtype == 1) {
			doc.addImage(X247Invoices.beautyRMail1stclass, 'JPEG', 144, 147, 151, 51);
		} else if (RMmailtype == 2) {
			doc.addImage(X247Invoices.beauty1stclasssignature, 'JPEG', 144, 147, 151, 80);
		} else if (RMmailtype == 3) {
			doc.addImage(X247Invoices.beautynestry2ndclass, 'JPEG', 144, 147, 151, 80);
		} else if (RMmailtype == 4) {
			doc.addImage(X247Invoices.beautyRM2ndclasssignature, 'JPEG', 144, 147, 151, 51);
		} else {
			doc.addImage(X247Invoices.beautynestry2ndclass, 'JPEG', 144, 147, 151, 80);
		}


		doc.setFontType("bold");
		doc.setFontSize(16);
		doc.text("Beauty Nest LTD", 30, 325);
		doc.setFontType("bold");
		doc.setFontSize(9);
		doc.text("Order Number:", 30, 340);
		doc.setFontType("normal");
		doc.text(data[j].orderid, 105, 340);
		doc.setFontType("bold");
		doc.text("Customer:", 30, 355);
		doc.setFontType("normal");
		doc.text(ship_address.Name, 80, 355);
		doc.setFontType("bold");
		doc.text("Shipping Service:", 30, 370);
		doc.setFontType("normal");
		doc.text("Royal Mail 2nd Class", 115, 370);
		doc.setFontType("bold");
		doc.text("Date:", 30, 385);
		doc.setFontType("normal");
		var bnestdate = data[j].purchasedate;
		doc.text(bnestdate, 55, 385);
		doc.setFontType("bold");
		doc.text("Channel:", 30, 400);
		doc.setFontType("normal");
		doc.text(data[j].saleschannel, 75, 400);

		var bcImage = $('#BNestbarImage_ppi').attr("src");
		if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
			doc.addImage(bcImage, 'JPEG', 375, 300, 180, 82);
		}

		doc.setFontType("normal");
		doc.setFontSize(7);


		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 30 //42
				},
				startY: 415, //doc.autoTableEndPosY()+10,
				pageBreak: 'auto',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5
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
				}
			});
		}


		var totpriceElementID = document.getElementById(totpriceid);
		if (totpriceElementID === null || totpriceElementID === undefined || totpriceElementID === '') {

		} else {

			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			doc.autoTable(totpriceres.columns, totpriceres.data, {
				margin: {
					left: 425 //315
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 16,
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
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					cell.styles.halign = 'right';
				}
			});
		};
		doc.setFontType("italic");
		doc.setFontSize(10);
		
		doc.text("wwww.kingdomofbeauty.eu", 30, 770);
		doc.text("The one stop shop for Beauty. Find your favorite brand cosmetics and fragrances up to 80% off.Perfume, fragrances,", 30, 790);
		doc.text("haircare, skincare, cosmetics, afterhave & gift sets with FREE UK Delivery Available.", 30, 810);

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