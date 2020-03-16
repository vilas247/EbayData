function alexthefatdawgPDF(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}


	for (var j = 0; j < data.length; j++) {
		console.log(data[j]);
		var totalPagesExp = data.length;
		var options = {
			// afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var alorderid = "alorder_ppi";
		var alorderres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var shipping_service = 'Standard';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Quantity']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['BinLocation']+"</td><td>good</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */
		
		var deliveryid = "aldelivery_ppi";
		var deliveryres = '';
		
		/*Ship address */
			var ship_address = data[j]['shippingaddresses'][0];
			$('#shipname_ppi').text(ship_address.Name);
			$('#shipaddress1ppi').text(ship_address.Address1);
			$('#shipaddress2ppi').text(ship_address.Address2);
			$('#shipcity_ppi').text(ship_address.City);
			$('#shippostcode_ppi').text(ship_address.PostCode);
			$('#shipcountryname_ppi').text(ship_address.CountryName);
		/* Ship address end */

		var saleaddrid = "alSaleAddress_ppi";
		var saleaddrres = '';

		var almarketid = "almarket_ppi";
		var almarketres = '';
		
		$('#accountname_ppi').text(data[j].accountname);
		$('#orderid_ppi').text(data[j].orderid);
		$('#shippingservice_ppi').text(shipping_service);
		$('#customer_ppi').text(ship_address.Name);
		$('#purchasedate_ppi').text(data[j].purchasedate);
		$('#email_ppi').text(ship_address.Email);

		var newid = "alnew_ppi";
		var newres = '';

		var channelpos = '';
		var startpos = 30;
		var orderpos = '';

		var sellerElementID = document.getElementById(saleaddrid);
		if (sellerElementID === null || sellerElementID === undefined || sellerElementID === '') {

		} else {
			saleaddrres = doc.autoTableHtmlToJson(document.getElementById(saleaddrid));
			doc.autoTable(saleaddrres.columns, saleaddrres.data, {
				startY: 100,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 12,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 12,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				// tableWidth: 275
				tableWidth: 275
			});
		}

		doc.addImage(X247Invoices.alexmaillogo, 'JPEG', 395, 60, 155, 70);
		doc.setFontType("normal");
		doc.setFontSize(8);
		doc.text("If undelivered,please return to", 315, 65);
		doc.text("Alexthefatdawg", 315, 80);
		doc.text("The Old Cheese Factory,", 315, 90);
		doc.text("Felinfach Nr Lampeter,", 315, 100);
		doc.text("Ceredigion,SA48 8AG", 315, 110);

		var deliverElementID = document.getElementById(deliveryid);
		if (deliverElementID === null || deliverElementID === undefined || deliverElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 325
				},
				startY: 135,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 14,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 275
			});
		}


		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("-----------------------------------------------------------------------------------------------------------------------------------------------------", 45, 250);


		var almarketElementID = document.getElementById(almarketid);
		if (almarketElementID === null || almarketElementID === undefined || almarketElementID === '') {

		} else {
			almarketres = doc.autoTableHtmlToJson(document.getElementById(almarketid));
			var almarketresoptions = {
				startY: 260,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 12,
					fontStyle: 'normal'
				},
				tableWidth: 400,
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontStyle = 'bold';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.fontStyle = 'bold';
					}
				}
			};
			doc.autoTable(almarketres.columns, almarketres.data, almarketresoptions);
		}

		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("-----------------------------------------------------------------------------------------------------------------------------------------------------", 45, doc.autoTableEndPosY() + 20);


		doc.setFontType("bold");
		doc.setFontSize(12);
		doc.text("Items:", 45, doc.autoTableEndPosY() + 40);
		var alorderElementID = document.getElementById(alorderid);
		if (alorderElementID === null || alorderElementID === undefined || alorderElementID === '') {

		} else {
			alorderres = doc.autoTableHtmlToJson(document.getElementById(alorderid));
			doc.autoTable(alorderres.columns, alorderres.data, {
				startY: doc.autoTableEndPosY() + 60,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal'
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