function fairwayImportersPDF1(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 38
			}
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

		var newid = "mnew_ppi";
		var newres = '';
		var startpos = 38;

		var deliverElementID = document.getElementById(deliveryid);
		if (deliverElementID === null || deliverElementID === undefined || deliverElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 74
				},
				startY: startpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 12,
					overflow: 'linebreak',
					fontStyle: 'bold',
					columnWidth: 'wrap'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 12,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				// tableWidth: 275
				tableWidth: 265
			});
		}

		doc.addImage(X247Invoices.csImage, 'JPEG', 279, startpos, 250, 185);

		doc.setFontSize(12);
		doc.setFontType("bold");
		doc.text('Return Address:', 74, 215);
		doc.setFontSize(9);
		doc.setFontType("normal");
		doc.text('Fairway.tastic,Kings Court Farm,Cooksmill Green', 74, 225);
		doc.text('Chelmsford,Essex,CM13SH,England', 74, 235);


		var imgElements = document.querySelectorAll('#fishippingservice_ppi tbody img');
		var images = [];

		doc.setFontSize(12);
		doc.setFontType("bold");
		//  doc.text('Order ID:', 317, 274);
		doc.text('Order ID:', 279, 274);
		var bcImage = $('#fibarImage_ppi').attr("src");
		if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
			doc.addImage(bcImage, 'JPEG', 331, 255, 193, 45);
		}
		var pName = '';
		var tprice = 0;

		doc.setFontSize(12);
		doc.setFontType("bold");
		var thanktext = "Thank you for buying from us on Amazon Marketplace";
		doc.text(thanktext, 40, 384);

		if (data[j].orderitems.length > 0) {
			pName = data[j].orderitems[0].ProductTitle;
			tprice = parseFloat(data[j].orderitems[0].UnitPrice) * parseFloat(data[j].orderitems[0].Quantity);
		}

		var a3 = pName.match(/.{1,30}/g);
		doc.setFontSize(9);
		doc.setFontType("bold");
		var jUUnit = 125;
		var ik = 10
		for (var jk = 0; jk < a3.length; jk++) {
			if (jk == 0) {
				doc.text(a3[jk].toString(), 289, parseInt(jUUnit));
			} else {
				doc.text(a3[jk].toString(), 289, parseInt(jUUnit) + ik);
				ik += 10;
			}
		}

		doc.text('X', 374, 92);
		doc.text(tprice.toFixed(2).toString(), 489, 125);
		doc.text(tprice.toFixed(2).toString(), 489, 180);
		doc.setFontType("normal");

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {

				startY: 414,
				pageBreak: 'auto',
				theme: 'plain',
				tableWidth: 'auto',
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal',
					rowHeight: 16,
					columnWidth: 'wrap'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 12,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
				columnStyles: {
					0: {
						columnWidth: 150
					},
					1: {
						columnWidth: 150
					}
				}
			});
		}

		var endposproduct = doc.autoTableEndPosY();
		doc.setFontSize(9);
		doc.setFontType("normal");

		var companyElementID = document.getElementById(companyaddressid);
		if (companyElementID === null || companyElementID === undefined || companyElementID === '') {

		} else {
			companyaddressres = doc.autoTableHtmlToJson(document.getElementById(companyaddressid));
			doc.autoTable(companyaddressres.columns, companyaddressres.data, {

				startY: 710, //610,
				pageBreak: 'auto',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					// fontSize: 14,
					fontSize: 12,
					fontStyle: 'normal',
					rowHeight: 18
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					//  fontSize: 14,
					fontSize: 12,
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