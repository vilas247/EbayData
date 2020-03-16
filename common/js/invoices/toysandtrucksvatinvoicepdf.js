function ToysandtucksVATInvoicePDF(data) {
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
			/*mpc = $filter('filter')($scope.tempordDetails, {
				"ordernumber": data[j].orderid
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

		var deliveryid = "toydeliveryvat_ppi";
		var deliveryres = '';

		var channelid = "toychannelvat_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "toybasicvat_ppi";
		var shippingres = '';

		var childid = "toyordervat_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Quantity']+" * <span>"+multiple_orders[jm]['ProductTitle']+"</span>,"+multiple_orders[jm]['Sku']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "toytotalpricevat_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
		/*special shipping service end */

		var newid = "toynewvat_ppi";
		var newres = '';

		var barcodeid = "toybarcodevat_ppi";
		var barcoderes = '';
		
		$("#toybarImagevat_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});

		var returnaddressid = "toyBTCreturnaddressvat_ppi";
		var returnaddressres = '';
		
		/*Return address */
			var return_address = data[j]['invoicetoaddresses'][0];
			$('#toybtComp1A_ppi').text(return_address.Address1);
			$('#toybtComp1Bvat_ppi').text(return_address.Address2);
			$('#toybtComp1D_ppi').text(return_address.City);
			$('#toybtComp1Evat_ppi').text(return_address.PostCode);
			$('#toybtComp1Fvat_ppi').text(return_address.CountryName);
		/* Return address end */

		var channelpos = 30;

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

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

		// #region  Adding Company Address

		var deliveryElementID = document.getElementById(deliveryid);
		if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {} else {
			//var ipos = 0;
			//if (iscompanyimage == 1) {
			//    ipos = 110;
			//} else {
			//    ipos = 30;
			//}
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			console.log(deliveryres, "deliveryres");
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				// startY: ipos,
				margin: {
					left: 385
				},
				startY: 120,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
			comapnyEndPos = doc.autoTableEndPosY();
		}

		// #endregion  Adding Company Address

		// #region Adding Barcode  

		var miorder = '';
		miorder = data[j].orderid;

		var mindex = miorder.indexOf("M-");
		if (mindex == 0) {

		} else {
			var bcImage = $('#toybarImagevat_' + j).attr("src");
			if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
				doc.addImage(bcImage, 'JPEG', 408, 35, 150, 82);
			}
		}

		// #endregion Adding Barcode  

		// #region Adding Channels  

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
				margin: {
					left: 385
				},
				startY: comapnyEndPos + 20,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
		}

		// #endregion Adding Channels  

		// #region Adding Shipping Address  

		var yposordergrid = doc.autoTableEndPosY() + 30;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));

			var ipos = 0;
			if (iscompanyimage == 1) {
				ipos = 110;
			} else {
				ipos = 30;
			}
			var shippingoptions = {
				//margin: {
				//    left: 403
				//},
				//startY: 120,
				startY: ipos,
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
				},
				tableWidth: 250
			};

			doc.autoTable(shippingres.columns, shippingres.data, shippingoptions);
		}

		// #endregion Adding Shipping Address    

		// #region Adding Item Grid 

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				startY: yposordergrid,
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

		// #endregion Adding Item Grid

		// #region Adding Price Calculation Grid

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

			// #endregion Adding Price Calculation Grid

			// #region Adding Footer Company Address

			doc.setFontSize(8);

			var strcomp1 = '';
			var strcomp2 = '';
			var comaddr = 1;
			if (comaddr == 1) {

				if (typeof $('#toybtComp1Avat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Avat_ppi span').html() + " ";

				if (typeof $('#toybtComp1Bvat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Bvat_ppi span').html() + " ";

				if (typeof $('#toybtComp1Cvat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Cvat_ppi span').html() + " ";

				if (typeof $('#toybtComp1Dvat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Dvat_ppi span').html() + " ";

				if (typeof $('#toybtComp1Evat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Evat_ppi span').html() + " ";

				if (typeof $('#toybtComp1Fvat_ppi span').html() != 'undefined')
					strcomp1 += $('#toybtComp1Fvat_ppi span').html();

				var text1 = "Thank you for your business, we hope you enjoy our products.Should you wish to return this order for a refund, please contact us.";
				var text3 = strcomp1;

				var xOffset1 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text1) * doc.internal.getFontSize() / 2);

				var xOffset3 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text3) * doc.internal.getFontSize() / 2);

				doc.text(text1, xOffset1, 767);

				doc.setFontType("bold");
				doc.text(text3, xOffset3, 778);
				doc.setFontStyle('normal');
			}

			// #endregion Adding Footer Company Address

			// #region Adding Merge Order no's

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
			// #endregion Adding Merge Order no's
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