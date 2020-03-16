function invoiceWithVAT(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {
		var mpc = '';
		var n = '';
		var merTempArray = '';
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')(tempordDetails, {
				"ordernumber": xmlTempArr[j].orderid
			}, true);*/
		}


		var totalPagesExp = data.length;

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFont("helvetica");
			doc.setTextColor(0, 0, 0);
			doc.setFontSize(16);
			doc.text(textOffset, y, text);
		};


		var footer = function (data) {
			var pageno = j + 1;
			var str = pageno;
			if (typeof doc.putTotalPages === 'function') {
				str = str + " / " + totalPagesExp;
			}
			doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
			doc.setFontSize(6);
			centeredText('Invoice', 25);
		};

		var options = {
			afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var deliveryid = "deliveryvat_ppi";
		var deliveryres = '';

		var channelid = "channelvat_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "basicvat_ppi";
		var shippingres = '';

		var childid = "ordervat_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		var vatrate = 0;
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
				vatrate = parseFloat(vatrate)+parseFloat(multiple_orders[jm]['VatRate']);
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "totalpricevat_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(data[j].totalprice);
			$('#grandtotal_ppi').text(data[j].totalprice);
			$('#vat_ppi').text(vatrate);
			var grandtotalvat_ppi = parseFloat(parseFloat(data[j].totalprice) + parseFloat(vatrate)).toFixed(2);
			$('#grandtotalvat_ppi').text(grandtotalvat_ppi);
		/* total price end */

		var newid = "newvat_ppi";
		var newres = '';

		var barcodeid = "barcodevat_ppi";
		var barcoderes = '';
		
		/* barcode start */
		$("#barImagevat_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		/* barcode end */

		var returnaddressid = "BTCreturnaddressvat_ppi";
		var returnaddressres = '';
		
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

		var channelpos = 30;

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

		// if (typeof $rootScope.companyProfile.imageurl != 'undefined') {
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
			iscompanyimage = 1;
		}
		//$base64.encode();

		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {} else {
			var ipos = 0;
			if (iscompanyimage == 1) {

				ipos = 110;
			} else {
				ipos = 30;
			}
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				//  startY: doc.autoTableEndPosY() + 30,
				// startY: channelpos,
				startY: ipos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});

			comapnyEndPos = doc.autoTableEndPosY();
		}

		/* Image Integration */

		var miorder = '';
		miorder = data[j].orderid;

		var mindex = miorder.indexOf("M-");
		if (mindex == 0) {

		} else {
			var bcImage = $('#barImagevat_ppi').attr("src");
			if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
				doc.addImage(bcImage, 'JPEG', 408, 35, 150, 82);
			}
		}

		var channelElementID = document.getElementById(channelid);
		if (channelElementID === null || channelElementID === undefined || channelElementID === '') {

		} else {
			channelres = doc.autoTableHtmlToJson(document.getElementById(channelid));

			if (mindex == 0) {
				channelpos = 112;
			} else {
				channelpos = doc.autoTableEndPosY() + 30;
			}


			doc.autoTable(channelres.columns, channelres.data, {
				// startY: doc.autoTableEndPosY() + 30,
				startY: comapnyEndPos + 20,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
		}


		var yposordergrid = doc.autoTableEndPosY() + 30;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));

			var shippingoptions = {
				margin: {
					left: 403
				},
				startY: 120, //channelpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					overflow: 'linebreak'
				},
				createdCell: function (cell, data) {
					// // console.log.log("Cell", cell, "Data", data);
					if (data.row.index == 8) {
						cell.styles.overflow = 'linebreak';
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
				startY: yposordergrid, //doc.autoTableEndPosY() + 30,
				pageBreak: 'auto',
				afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
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
				drawHeaderRow: function (row, data) {
					row.cells[3].styles.halign = 'right';
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 2) {
						cell.styles.halign = 'left';
						cell.styles.fontStyle = 'bold';
					}

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
					left: 367
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak'
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
					row.cells[1].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 1) {
						cell.styles.halign = 'right';
					}
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
			doc.setFontSize(8);
			// doc.text('THANK YOU FOR YOUR BUSINESS!', 40, doc.autoTableEndPosY() + 150);


			var strcomp1 = '';
			var strcomp2 = '';
			var comaddr = 1;
			if (comaddr == 1) {

				if (typeof $('#btComp1Avat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Avat_' + j + ' span').html() + " ";

				if (typeof $('#btComp1Bvat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Bvat_' + j + ' span').html() + " ";

				if (typeof $('#btComp1Cvat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Cvat_' + j + ' span').html() + " ";

				if (typeof $('#btComp1Dvat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Dvat_' + j + ' span').html() + " ";

				if (typeof $('#btComp1Evat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Evat_' + j + ' span').html() + " ";

				if (typeof $('#btComp1Fvat_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1Fvat_' + j + ' span').html();

				if (dbcode == 41) {
					doc.setFontStyle('normal');
					var trimdisctext = "Please visit www.trimmingshop.co.uk and avail 10% discount by using code TSLL10";
					var xOffset6 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(trimdisctext) * doc.internal.getFontSize() / 2);
					//  doc.text(trimdisctext, 40, 789);
					doc.text(trimdisctext, xOffset6, 756);

				}


				var text1 = "Thank you for your business, we hope you enjoy our products.Should you wish to return this order for a refund, please contact us.";
				// var text2 = "Should you wish to return this order for a refund, please contact us. ";
				var text3 = strcomp1;

				var xOffset1 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text1) * doc.internal.getFontSize() / 2);
				// var xOffset2 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text2) * doc.internal.getFontSize() / 2);
				var xOffset3 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text3) * doc.internal.getFontSize() / 2);

				doc.text(text1, xOffset1, 767);
				// doc.text(text2, xOffset2, 778);
				doc.setFontType("bold");
				doc.text(text3, xOffset3, 778);
				doc.setFontStyle('normal');
			}
			if (mindex == 0) {
				doc.setFontType("bold");
				doc.text("Order No's: ", 30, 756);
				//    doc.text(xmlTempArr[j].Mergeitemorders, 80, 756);

				if (typeof merTempArray != 'undefined' && merTempArray != null && merTempArray != '') {
					doc.text(merTempArray, 80, 756);
				} else {
					doc.text('', 80, 756);
				}
				doc.setFontStyle('normal');
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