function startatpageonePDF(data,tempRID) {

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

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			//  doc.setFont("helvetica");
			doc.setTextColor(0, 0, 0);
			doc.setFontSize(8);
			doc.text(textOffset, y, text);
		};

		var companyid = "startcompanylogo_ppi";
		var companyres = '';

		var deliveryid = "startdelivery_ppi";
		var deliveryres = '';
		
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

		var startreturnshipid = "startreturnship_ppi";
		var startreturnshipres = '';
		
		$('#shipname_ppi').text(ship_address.Name);
			$('#stshipaddress1_ppi').text(ship_address.Address1);
			$('#stshipaddress2_ppi').text(ship_address.Address2);
			$('#stshipcity_ppi').text(ship_address.City);
			$('#stshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#stshippostcode_ppi').text(ship_address.PostCode);
			$('#stshipcountryname_ppi').text(ship_address.CountryName);
			$('#stshipphone_ppi').text(ship_address.Phone);
			$('#stshipemail_ppi').text(ship_address.Email);

		var startreturnaddresstxtid = "startreturnaddresstxt_ppi";
		var startreturnaddresstxtres = '';

		var channelid = "startchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "startbasic_ppi";
		var shippingres = '';

		var childid = "startorder_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['Quantity']+" * "+multiple_orders[jm]['UnitPrice']+"</td><td>"+data[j].purchasedate+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "starttotalprice_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#shippingprice_ppi').text(X247Invoices.Fredricksubtotal(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var returnid = "startreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "startshippingservice_ppi";
		var shippingserviceres = '';
		
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
			$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/*special shipping service end */

		var boxid = "startboxreturnaddress_ppi";
		var boxres = '';
		
		$('#strshipname_ppi').text(ship_address.Name);
			$('#strstshipaddress1_ppi').text(ship_address.Address1);
			$('#strstshipaddress2_ppi').text(ship_address.Address2);
			$('#strstshipcity_ppi').text(ship_address.City);
			$('#strstshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#strstshippostcode_ppi').text(ship_address.PostCode);
			$('#strstshipcountryname_ppi').text(ship_address.CountryName);
			$('#strstshipphone_ppi').text(ship_address.Phone);
			$('#strstshipemail_ppi').text(ship_address.Email);

		var newid = "startnew_ppi";
		var newres = '';

		var channelpos = '';

		var companypos = 30;
		var orderpos = '';
		doc.addImage(X247Invoices.startpageLogo, 'JPEG', 30, companypos, 201, 73);

		doc.setFontStyle('normal');
		doc.setFontSize(10);
		//  doc.text("________________________________________________________________________________________________", 30, 30);
		doc.text("________________________________________________________________________________________________", 30, 120);
		doc.setFontStyle('normal');
		doc.setFontSize(10);
		doc.text("Date: ", 30, 135); //45
		var Spurchasedate = '';
		Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 80, 135); //45
		doc.text("Order No: ", 30, 150); //60
		doc.text(data[j].orderid, 80, 150); //60


		doc.text(" No: ", 30, 165); //60
		doc.text(data[j].orderid, 80, 165); //60

		doc.text("Shipping Service: ", 30, 180); //75

		if (tempRID == 1) {
			doc.text('Royal Mail 24', 120, 180); //75
		} else {
			doc.text('Royal Mail 48', 120, 180); //75
		}

		doc.text("Phone: ", 310, 135); //75
		doc.text('07798877044', 380, 135); //75

		doc.text("Sales Channel: ", 310, 150); //45
		if (typeof data[j].saleschannel != 'undefined' && data[j].saleschannel != '' && data[j].saleschannel != null) {
			doc.text(data[j].saleschannel, 380, 150); //45
		} else {
			doc.text('', 380, 135); //45
		}

		doc.text("Email: ", 310, 165); //45
		doc.text('sarahn23@hotmail.com', 380, 165); //45

		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				//  margin: { left: 403 },
				margin: {
					left: 25
				},
				startY: 200, //110
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 15,
					fontSize: 10
				}
			});
		}


		var startreturnaddresstxtID = document.getElementById(startreturnaddresstxtid);
		if (startreturnaddresstxtID === null || startreturnaddresstxtID === undefined || startreturnaddresstxtID === '') {

		} else {
			startreturnaddresstxtres = doc.autoTableHtmlToJson(document.getElementById(startreturnaddresstxtid));
			doc.autoTable(startreturnaddresstxtres.columns, startreturnaddresstxtres.data, {
				//  margin: { left: 403 },
				margin: {
					left: 310
				},
				startY: 200, //110
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 15,
					fontSize: 10
				}
			});
		}

		var returnAddrPos = doc.autoTableEndPosY() + 10;

		doc.setFontStyle('normal');
		doc.setFontSize(10);
		doc.text("________________________________________________________________________________________________", 30, returnAddrPos);

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 25
				},
				startY: returnAddrPos + 10,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					rowHeight: 18,
					fontSize: 10
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

		var totalpriceElementID = document.getElementById(totpriceid);
		if (totalpriceElementID === null || totalpriceElementID === undefined || totalpriceElementID === '') {

		} else {
			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			var totalpriceoptions = {
				margin: {
					left: 380
				},
				startY: doc.autoTableEndPosY() + 1, //doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 18,
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
			};
			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
		}


		var totlPos = doc.autoTableEndPosY() + 20;
		doc.setFontSize(8);
		doc.setFontType("bold");
		//  doc.text('Thank you for your purchase from Start at Page 1. We hope you enjoy your new book! If you are happy with your new book,', 25, totlPos);
		centeredText('Thank you for your purchase from Start at Page 1. We hope you enjoy your new book! If you are happy with your new book,', totlPos);
		centeredText('please leave feedback, if not please contact us!', totlPos + 15);
		centeredText('V.A.T. Registration Number 132 4364 40', totlPos + 30);

		var returnyPosition = totlPos + 60;

		var startreturnshipElementID = document.getElementById(startreturnshipid);
		if (startreturnshipElementID === null || startreturnshipElementID === undefined || startreturnshipElementID === '') {

		} else {
			//if (returnyPosition >= DynamicPGSize) {
			if (returnyPosition >= 649) {
				// if (returnyPosition >= 550) {
				doc.addPage();
			}
			startreturnshipres = doc.autoTableHtmlToJson(document.getElementById(startreturnshipid));
			doc.autoTable(startreturnshipres.columns, startreturnshipres.data, {
				//  margin: { left: 403 },
				margin: {
					left: 30
				},
				startY: 651, //680,// totlPos+110,//110
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					rowHeight: 15,
					fontSize: 10,
					fontStyle: 'bold'
				},
				tableWidth: 275
			});
			// doc.addImage(returnLogo24, 'JPEG', 300, totlPos + 60, 250, 200);
			if (tempRID == 1) {
				doc.addImage(X247Invoices.returnLogo24, 'JPEG', 300, 651, 175, 150);
			} else {
				doc.addImage(X247Invoices.returnLogo48, 'JPEG', 300, 651, 175, 150);
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