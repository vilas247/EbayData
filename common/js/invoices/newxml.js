/* Invoice Witout PPI */
function newXML(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }
	for (var j = 0; j < data.length; j++) {
		var totalPagesExp = data.length;
		var footer = function (data) {
			var pageno = j + 1;
			var str = pageno;
			if (typeof doc.putTotalPages === 'function') {
				str = str + " / " + totalPagesExp;
			}
			doc.text(str, 545, doc.internal.pageSize.height - 30);
			doc.setFontSize(6);
		};

		var mpc = '';
		var n = '';
		var merTempArray = '';
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			mpc = {"ordernumber": data[j].orderid};
		}
		var options = {
			afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var deliveryid = "delivery_ppi";
		var deliveryres = '';

		var channelid = "channel_ppi";
		var channelres = '';
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "basic_ppi";
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
			$('#shipphone_ppi').text(ship_address.Phone);
			$('#shipemail_ppi').text(ship_address.Email);
		/* Ship address end */

		var childid = "order_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "totalpriceT_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		/* total price end */

		var newid = "new_ppi";
		var newres = '';

		var barcodeid = "barcode_ppi";
		var barcoderes = '';
		/* barcode */
		$("#barImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		/* barcode end */
		var returnaddressid = "BTCreturnaddress_ppi";
		var returnaddressres = '';

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
		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

		} else {
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
			// console.log(doc.autoTableEndPosY());
		}

		/* Image Integration */
		var miorder = '';
		miorder = data[j].orderid;
		var mindex = miorder.indexOf("M-");
		if (mindex == 0) {

		} else {
			var elem = document.getElementById(barcodeid);
			var idimage = '#' + barcodeid + ' tbody img';
			var imgElements = document.querySelectorAll(idimage);
			var dataImage = doc.autoTableHtmlToJson(elem);
			
			var images = [];
			// console.log(dataImage);
			doc.autoTable(dataImage.columns, dataImage.rows, {
				margin: {
					left: 403
				},
				startY: channelpos - 20,
				pageBreak: 'avoid',
				theme: 'plain',
				bodyStyles: {
					rowHeight: 82
				},
				drawCell: function (cell, opts) {
					if (opts.column.dataKey === 0) {
						var img = imgElements[opts.row.index];
						images.push({
							elem: img,
							x: cell.textPos.x,
							y: cell.textPos.y
						});
					}
				},
				afterPageContent: function () {
					for (var i = 0; i < images.length; i++) {
						doc.addImage(images[i].elem, 'png', images[i].x, images[i].y, 150, 82);
					}
				}

			});
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
				startY: comapnyEndPos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
		}


		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));

			var shippingoptions = {
				margin: {
					left: 403
				},
				startY: channelpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					overflow: 'linebreak'
				},
				createdCell: function (cell, data) {
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
				startY: doc.autoTableEndPosY() + 30,
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


			var strcomp1 = '';
			var strcomp2 = '';
			var comaddr = 1;
			if (comaddr == 1) {

				if (typeof $('#btComp1A_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1A_' + j + ' span').html() + " ";

				if (typeof $('#btComp1B_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1B_' + j + ' span').html() + " ";

				if (typeof $('#btComp1C_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1C_' + j + ' span').html() + " ";

				if (typeof $('#btComp1D_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1D_' + j + ' span').html() + " ";

				if (typeof $('#btComp1E_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1E_' + j + ' span').html() + " ";

				if (typeof $('#btComp1F_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp1F_' + j + ' span').html();

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

			if (comaddr == 0) {
				
				if (typeof $('#btComp2A_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2A_' + j + ' span').html() + " ";

				if (typeof $('#btComp2B_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2B_' + j + ' span').html() + " ";

				if (typeof $('#btComp2C_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2C_' + j + ' span').html() + " ";

				if (typeof $('#btComp2D_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2D_' + j + ' span').html() + " ";

				if (typeof $('#btComp2E_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2E_' + j + ' span').html() + " ";

				if (typeof $('#btComp2F_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#btComp2F_' + j + ' span').html();


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