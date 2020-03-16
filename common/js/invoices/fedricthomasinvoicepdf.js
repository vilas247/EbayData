function FedricThomasInvoicePDF(data,FTTTemplateID) {

	var doc = new jsPDF('p', 'pt', 'a4');
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
				"ordernumber": $scope.xmlTempArr[j].invoice.orderid
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

		var FTTdeliveryid = "FTTdeliveryvat_ppi";
		var FTTdeliveryres = '';

		var FTTchannelid = "FTTchannelvat_ppi";
		var FTTchannelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var FTTshippingid = "FTTbasicvat_ppi";
		var FTTshippingres = '';
		
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

		var FTTchildid = "FTTordervat_ppi";
		var FTTchildres = '';
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var FTTtotpriceid = "FTTtotalpricevat_ppi";
		var FTTtotpriceres = '';
		$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
		$('#shippingprice_ppi').text(X247Invoices.Fredricksubtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		$('#vatprice_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));

		var FTTnewid = "FTTnewvat_ppi";
		var FTTnewres = '';

		var FTTbarcodeid = "FTTbarcodevat_ppi";
		var FTTbarcoderes = '';

		var FTTreturnaddressid = "FTTBTCreturnaddressvat_ppi";
		var FTTreturnaddressres = '';
		
		/*Return address */
			var return_address = data[j]['invoicetoaddresses'][0];
			$('#FTTbtComp1Bvat_ppi').text(return_address.Address1);
			$('#FTTbtComp1Bvat_ppi').text(return_address.Address2);
			$('#FTTbtComp1D_ppi').text(return_address.City);
			$('#FTTbtComp1Evat_ppi').text(return_address.PostCode);
			$('#FTTbtComp1Fvat_ppi').text(return_address.CountryName);
		/* Return address end */
		

		var FTTStampBoxid = "FTTStampBox_ppi";
		var FTTStampBoxres = '';


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


		var FTTdeliveryElementID = document.getElementById(FTTdeliveryid);
		if (FTTdeliveryElementID === null || FTTdeliveryElementID === undefined || FTTdeliveryElementID === '') {} else {
			var ipos = 0;
			if (iscompanyimage == 1) {

				ipos = 110;
			} else {
				ipos = 30;
			}
			FTTdeliveryres = doc.autoTableHtmlToJson(document.getElementById(FTTdeliveryid));
			doc.autoTable(FTTdeliveryres.columns, FTTdeliveryres.data, {
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
			//var bcImage = $('#FTTbarImagevat_' + j).attr("src");
			//if (typeof bcImage != 'undefined' && bcImage !== '' && bcImage != null) {
			//    doc.addImage(bcImage, 'JPEG', 408, 35, 150, 82);
			//}
		}

		var FTTchannelElementID = document.getElementById(FTTchannelid);
		if (FTTchannelElementID === null || FTTchannelElementID === undefined || FTTchannelElementID === '') {

		} else {
			FTTchannelres = doc.autoTableHtmlToJson(document.getElementById(FTTchannelid));

			if (mindex == 0) {
				channelpos = 112;
			} else {
				channelpos = doc.autoTableEndPosY() + 30;
			}


			doc.autoTable(FTTchannelres.columns, FTTchannelres.data, {
				startY: comapnyEndPos + 20,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});
		}


		var yposordergrid = doc.autoTableEndPosY() + 30;

		// #region PPL Stamp  

		var FTTStampBoxElementID = document.getElementById(FTTStampBoxid);
		if (FTTStampBoxElementID === null || FTTStampBoxElementID === undefined || FTTStampBoxElementID === '') {

		} else {

			FTTStampBoxres = doc.autoTableHtmlToJson(document.getElementById(FTTStampBoxid));

			doc.autoTable(FTTStampBoxres.columns, FTTStampBoxres.data, {
				margin: {
					left: 275
				},
				startY: 28,
				theme: 'plain',
				styles: {
					//    fillStyle: 'DF',
					//  lineColor: [165, 164, 164],
					//  lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 215,
					fontSize: 9
				},
				tableWidth: 312
			});
		}


		// #endregion PPL Stamp

		// #region Universal Stamp


		if (FTTTemplateID == 0) {

			if (data[j].orderitems.length > 0) {
				if (typeof data[j].orderitems[0].ShippingService === 'undefined' || data[j].orderitems[0].ShippingService === '' || data[j].orderitems[0].ShippingService == null) {
					doc.addImage(X247Invoices.FTTSUKOnly, 'JPEG', 282, 32, 266, 56);
					doc.setFontSize(7);
					doc.setFontType("bold");
					doc.text('POSTAGE PAID GB', 480, 70);
					doc.text('HQ93429', 480, 80);
					doc.setFontType("normal");
				} else if (typeof data[j].orderitems[0].ShippingService === 'FR_StandardDeliveryFromAbroad' || typeof data[j].orderitems[0].ShippingService === 'IT_StandardDeliveryFromAbroad' || typeof data[j].orderitems[0].ShippingService === 'UK_SellersStandardInternationalRate') {
					doc.addImage(X247Invoices.FTTFCNUK, 'JPEG', 282, 32, 266, 56);
					doc.setFontSize(7);
					doc.setFontType("bold");
					doc.text('POSTAGE PAID GB', 480, 70);
					doc.text('HQ93429', 480, 80);
					doc.setFontType("normal");
				} else {
					doc.addImage(X247Invoices.FTTSUKOnly, 'JPEG', 282, 32, 266, 56);
					doc.setFontSize(7);
					doc.setFontType("bold");
					doc.text('POSTAGE PAID GB', 480, 70);
					doc.text('HQ93429', 480, 80);
					doc.setFontType("normal");
				}
			}
		}

		// #endregion Universal Stamp

		// #region Non UK PPL Stamp

		if (FTTTemplateID == 3) {

			doc.addImage(X247Invoices.FTTFCNUK, 'JPEG', 282, 32, 266, 56);
			doc.setFontSize(7);
			doc.setFontType("bold");
			doc.text('POSTAGE PAID GB', 480, 70);
			doc.text('HQ93429', 480, 80);
			doc.setFontType("normal");
		}

		// #endregion Non UK PPL Stamp

		// #region PPI First Class UK ONLY

		if (FTTTemplateID == 1) {

			doc.addImage(X247Invoices.FTTFUKOnly, 'JPEG', 282, 32, 266, 56);
			doc.setFontSize(7);
			doc.setFontType("bold");
			doc.text('POSTAGE PAID GB', 480, 70);
			doc.text('HQ93429', 480, 80);
			doc.setFontType("normal");
		}

		// #endregion PPI First Class UK ONLY

		// #region PPI Second Class UK ONLY

		if (FTTTemplateID == 2) {
			doc.addImage(X247Invoices.FTTSUKOnly, 'JPEG', 282, 32, 266, 56);
			doc.setFontSize(7);
			doc.setFontType("bold");
			doc.text('POSTAGE PAID GB', 480, 70);
			doc.text('HQ93429', 480, 80);
			doc.setFontType("normal");
		}

		// #endregion PPI Second Class UK ONLY


		var FTTshippingElementID = document.getElementById(FTTshippingid);
		if (FTTshippingElementID === null || FTTshippingElementID === undefined || FTTshippingElementID === '') {

		} else {
			FTTshippingres = doc.autoTableHtmlToJson(document.getElementById(FTTshippingid));
			var shippingoptions = {};

			if (FTTTemplateID == 4) {
				shippingoptions = {
					margin: {
						left: 280
					},
					startY: 35,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						fontSize: 8,
						overflow: 'linebreak',
						rowHeight: 15,
						overflow: 'linebreak'
					},
					createdCell: function (cell, data) {
						if (data.row.index == 8) {
							cell.styles.overflow = 'linebreak';
						}
					},
					tableWidth: 270
				};
			} else {
				shippingoptions = {
					margin: {
						left: 280
					},
					//  startY: 108,
					startY: 90,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						fontSize: 8,
						overflow: 'linebreak',
						rowHeight: 15,
						overflow: 'linebreak'
					},
					createdCell: function (cell, data) {
						if (data.row.index == 8) {
							cell.styles.overflow = 'linebreak';
						}
					},
					tableWidth: 270
				};
			}


			doc.autoTable(FTTshippingres.columns, FTTshippingres.data, shippingoptions);
		}
		if (typeof ship_address.Email !== 'undefined' && ship_address.Email !== '' && ship_address.Email != null) {
			doc.setFontType("normal");
			doc.setFontSize(8);
			var fttemail = '';
			fttemail = "Email:" + ship_address.Email;
			doc.text(fttemail, 280, 253);
		}


		var FTTchildElementID = document.getElementById(FTTchildid);
		if (FTTchildElementID === null || FTTchildElementID === undefined || FTTchildElementID === '') {

		} else {
			FTTchildres = doc.autoTableHtmlToJson(document.getElementById(FTTchildid));
			doc.autoTable(FTTchildres.columns, FTTchildres.data, {
				startY: yposordergrid,
				pageBreak: 'auto',
				afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					//  fillStyle: 'DF',
					//  lineColor: [165, 164, 164],
					//  lineWidth: 0.5
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

		var FTTtotalpriceElementID = document.getElementById(FTTtotpriceid);
		if (FTTtotalpriceElementID === null || FTTtotalpriceElementID === undefined || FTTtotalpriceElementID === '') {

		} else {
			FTTtotpriceres = doc.autoTableHtmlToJson(document.getElementById(FTTtotpriceid));

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

			doc.autoTable(FTTtotpriceres.columns, FTTtotpriceres.data, totalpriceoptions);
			doc.setFontSize(8);

			var strcomp1 = '';
			var strcomp2 = '';
			var comaddr = 1;
			if (comaddr == 1) {

				if (typeof $('#FTTbtComp1Avat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Avat_ppi span').html() + " ";

				if (typeof $('#FTTbtComp1Bvat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Bvat_ppi span').html() + " ";

				if (typeof $('#FTTbtComp1Cvat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Cvat_ppi span').html() + " ";

				if (typeof $('#FTTbtComp1Dvat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Dvat_ppi span').html() + " ";

				if (typeof $('#FTTbtComp1Evat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Evat_ppi span').html() + " ";

				if (typeof $('#FTTbtComp1Fvat_ppi span').html() != 'undefined')
					strcomp1 += $('#FTTbtComp1Fvat_ppi span').html();


				var text1 = "Thank you for your business, we hope you enjoy our products.Should you wish to return this order for a refund, please contact us.";
				var text3 = strcomp1;

				var xOffset1 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text1) * doc.internal.getFontSize() / 2);
				var xOffset3 = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text3) * doc.internal.getFontSize() / 2);

				doc.text(text1, xOffset1, 767);

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
			doc.addPage();
		}
	}
}