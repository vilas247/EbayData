function fairwayImportersNewInvoice(data) {

	var doc = new jsPDF('p', 'pt', [288, 432]);
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	var height = doc.internal.pageSize.height;

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 38
			}
		};
		var footer = function (data) {
			doc.setFontSize(8);
			doc.setFontType("bold");
			var bcImage = $('#fibarImage_ppi').attr("src");
			if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
				doc.addImage(bcImage, 'JPEG', 30, 390, 195, 45);
			}
			doc.text('Order ID:', 30, 390);
		};

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			//doc.setFont("helvetica");
			//doc.setTextColor(0, 0, 0);
			//doc.setFontSize(16);
			doc.text(textOffset, y, text);
		};

		var deliveryid = "fideliveryaddress_ppi";
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

		var barcodeid = "fibarcode_ppi";
		var barcoderes = '';
		
		/* barcode */
		$("#fibarImage1_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		$("#fibarImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		/* barcode end */

		var childid = "fiproductinfo_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Ean']+"</td><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var shippingserviceid = "fishippingservice_ppi";
		var shippingserviceres = '';

		var companyaddressid = "ficompanyaddress_ppi";
		var companyaddressres = '';

		var verticalbarcodeid = "fibarcodevertical_ppi";
		var verticalbarcoderes = '';

		var newid = "mnew_ppi";
		var newres = '';
		var startpos = 10;

		var deliverElementID = document.getElementById(deliveryid);
		if (deliverElementID === null || deliverElementID === undefined || deliverElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 5
				},
				startY: startpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 13,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal',
					//  columnWidth: 'wrap'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 130
			});
		}

		var returnendposfi = doc.autoTableEndPosY();
		doc.setFontSize(8);
		doc.setFontType("bold");
		doc.text('Return Address:', 145, startpos + 10);
		doc.text('Fairway.tastic', 145, startpos + 20);
		doc.setFontSize(8);
		doc.setFontType("normal");
		doc.text('Fairway.tastic,Kings Court Farm', 145, startpos + 30);
		doc.text('Cooksmill Green,Chelmsford,Essex', 145, startpos + 40);
		doc.text('CM1 3SH,England', 145, startpos + 50);
		doc.text('www.fairwaytastic.co.uk', 145, startpos + 60);
		doc.text('Telephone: 00 44 (0) 1245 248699', 145, startpos + 70);
		doc.text('E-Mail: fairwayimport@gmail.com', 145, startpos + 80);

		doc.addImage(X247Invoices.csImage, 'JPEG', 5, 110, 275, 188); // 25  increment
		doc.setFontSize(8);
		doc.setFontType("normal");

		var bcVDImage = $('#fibarImage1evertical_ppi').attr("src");
		if (typeof bcVDImage != 'undefined' && bcVDImage !== '' && bcVDImage != null) {
			// doc.addImage(bcVDImage, 'JPEG', 5, 110, 45, 163);
			//doc.addImage(bcVDImage, 'JPEG', 5, 110, 45, 193);
		}


		var pName = '';
		var tprice = 0;
		if (data[j].orderitems.length > 0) {
			pName = data[j].orderitems[0].ProductTitle;
			tprice = parseFloat(data[j].orderitems[0].UnitPrice) * parseFloat(data[j].orderitems[0].Quantity);
		}

		var a3 = pName.match(/.{1,35}/g);
		doc.setFontSize(8);
		doc.setFontType("bold");
		// var jUUnit = 187;
		var jUUnit = 187 + 11;
		var ik = 10
		for (var jk = 0; jk < a3.length; jk++) {
			if (jk == 0) {
				doc.text(a3[jk].toString(), 20, parseInt(jUUnit));
			} else {
				doc.text(a3[jk].toString(), 20, parseInt(jUUnit) + ik);
				ik += 10;
			}
		}

		//doc.text('X', 138, 157);
		//doc.text(tprice.toFixed(2).toString(), 238, 187);
		//doc.text(tprice.toFixed(2).toString(), 238, 232);

		//    doc.text('X', 138, 164);
		doc.text('X', 112, 164);
		doc.text(tprice.toFixed(2).toString(), 238, 197);
		doc.text(tprice.toFixed(2).toString(), 238, 252);


		doc.setFontType("normal");

		var bcImage = $('#fibarImage_ppi').attr("src");
		if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
			//  doc.addImage(bcImage, 'JPEG', 87, 390, 195, 45);
			doc.addImage(bcImage, 'JPEG', 5, 390, 275, 45);
		}
		if (typeof ordmarketplace != 'undefined' && ordmarketplace != null && ordmarketplace != '') {
			if (ordmarketplace[0].marketplacecode === "2") {
				var thanktext = "Thank you for buying from us on Amazon Marketplace";
				doc.setFontSize(8);
				doc.setFontType("bold");
				centeredText(thanktext, 385);
				// doc.text(thanktext, 52, 380);
			}
		}


		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 10,
					bottom: 50
				},
				startY: 273 + 30,
				pageBreak: 'auto',
				styles: {
					overflow: 'linebreak',
					fontSize: 8,
					fontStyle: 'normal',
					rowHeight: 12,
				},
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
				columnStyles: {
					0: {
						columnWidth: 75
					},
					1: {
						columnWidth: 75
					}
				}
			});
		}
		
		var orderGridPos = doc.autoTableEndPosY();
		if (orderGridPos <= 298) {
			if (typeof ordmarketplace != 'undefined' && ordmarketplace != null && ordmarketplace != '') {
				if (ordmarketplace[0].marketplacecode === "2") {
					var thanktext = "Thank you for buying from us on Amazon Marketplace";
					doc.setFontSize(8);
					doc.setFontType("bold");
					centeredText(thanktext, 385);
					// doc.text(thanktext, 52, 380);
				}
			}
			if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
				doc.addImage(bcImage, 'JPEG', 5, 390, 275, 45);
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