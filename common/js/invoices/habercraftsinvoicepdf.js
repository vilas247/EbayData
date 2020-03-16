function HaberCraftsInvoicePDF_Mod(data,iHCTemplate) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);

	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	for (var j = 0; j < data.length; j++) {

		var mpc = '';
		var n = '';
		var merTempArray = '';
		var isfooterComplted = 1;
		var isfooterheight = 0;
		var isfooterpage = 1;
		var itemgridendpos = 0;
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')($scope.tempordDetails, {
				"ordernumber": data[j].orderid
			}, true);*/
		}


		var totalPagesExp = data.length;

		var returuncenteredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFontType("normal");
			doc.setFontSize(8);
			doc.text(textOffset, y, text);
		};

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFont("helvetica");
			doc.setTextColor(0, 0, 0);
			doc.setFontSize(16);
			doc.text(textOffset, y, text);
		};

		var offercenteredText = function (text, y, fsize) {
			console.log(doc.internal.scaleFactor, "---", doc.internal.getFontSize());
			doc.setFontSize(fsize);
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (340 - textWidth) / 2;
			doc.setFont("courier");
			doc.setFontType("italic");
			doc.setTextColor(0, 0, 0);
			doc.text(textOffset, y, text);
		};


		var footer = function () {
			var text = 'Invoice';
			doc.setFontSize(20);
			doc.setFontType("bold");

			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;


			doc.text(textOffset, 74, text);
			// doc.text('Invoice', 490, 25);
		};


		var Gridfooter1 = function () {
			doc.addImage(X247Invoices.HCRDisc, 'JPEG', 20, 515, 555, 115);
			var hcrElementID = document.getElementById(hcreturnaddressid);
			if (hcrElementID === null || hcrElementID === undefined || hcrElementID === '') {

			} else {
				hcreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(hcreturnaddressid));
				doc.autoTable(hcreturnaddressres.columns, hcreturnaddressres.data, {
					margin: {
						left: 99
					},
					// startY: 625,
					startY: 630,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						fontSize: 10,
						fontStyle: 'bold',
						rowHeight: 15,
						overflow: 'linebreak'
					},
					tableWidth: 150
				});
			}

			if (iHCTemplate == 1) {
				doc.addImage(X247Invoices.HCRy48, 'JPEG', 250, 635, 240, 57);
				doc.setFontStyle('bold');
				doc.setFontSize(6);
				doc.text('POSTAGE PAID GB', 431, 675);
				doc.setFontSize(7);
				doc.text('HQ47082', 431, 685);
			}

			if (iHCTemplate == 2) {
				doc.addImage(X247Invoices.HCRy24, 'JPEG', 250, 635, 240, 57);
				doc.setFontStyle('bold');
				doc.setFontSize(8);
				doc.text('POSTAGE PAID GB', 400, 675);
				doc.setFontSize(8);
				doc.text('HQ47082', 400, 685);
			}

			if (iHCTemplate == 3) {
				doc.setFontStyle('bold');
				doc.setFontSize(12);
				doc.text('EXPRESS', 320, 660);
			}

			doc.setFontStyle('normal');
			doc.setFontSize(9);
			doc.text('Return Address:', 305, 706);
			doc.text('Lyndons. T/A Habercrafts', 305, 716);
			doc.text('18 Main Drive, East Lane Business Park.', 305, 726);
			doc.text('Wembley. London. HA9 7NA', 305, 736);

			doc.setFontStyle('normal');
			doc.setFontSize(8);
			returuncenteredText('Thank you for shopping with Lyndons Art & Graphics Ltd T/A HaberCrafts.', 818);
			returuncenteredText('_________________________________________________________________________________________________________________________', 820);
			doc.setFontStyle('normal');
			doc.setFontSize(8);

			returuncenteredText('www.habercrafts.com, 18 Main Drive, East Lane Business Park, Wembley,London.HA9 7NA. UK -', 830);
			returuncenteredText('Email: sales@habercrafts.com Phone: 020 8908 4862', 840);
		}
		var Gridfooter = function (data) {
			if (j == 0 && isfooterheight == 0) {
				isfooterheight = data.cursor.y;
				itemgridendpos = doc.autoTableEndPosY();
				doc.addImage(HCRDisc, 'JPEG', 20, 515, 555, 115);
				var hcrElementID = document.getElementById(hcreturnaddressid);
				if (hcrElementID === null || hcrElementID === undefined || hcrElementID === '') {

				} else {
					hcreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(hcreturnaddressid));
					doc.autoTable(hcreturnaddressres.columns, hcreturnaddressres.data, {
						margin: {
							left: 99
						},
						// startY: 625,
						startY: 630,
						pageBreak: 'avoid',
						theme: 'plain',
						styles: {
							fontSize: 10,
							fontStyle: 'bold',
							rowHeight: 15,
							overflow: 'linebreak'
						},
						tableWidth: 150
					});
				}

				if (iHCTemplate == 1) {
					doc.addImage(X247Invoices.HCRy48, 'JPEG', 250, 635, 240, 57);
					doc.setFontStyle('bold');
					doc.setFontSize(6);
					doc.text('POSTAGE PAID GB', 431, 675);
					doc.setFontSize(7);
					doc.text('HQ47082', 431, 685);
				}

				if (iHCTemplate == 2) {
					doc.addImage(X247Invoices.HCRy24, 'JPEG', 250, 635, 240, 57);
					doc.setFontStyle('bold');
					doc.setFontSize(8);
					doc.text('POSTAGE PAID GB', 400, 675);
					doc.setFontSize(8);
					doc.text('HQ47082', 400, 685);
				}

				if (iHCTemplate == 3) {
					doc.setFontStyle('bold');
					doc.setFontSize(12);
					doc.text('EXPRESS', 320, 660);
				}

				doc.setFontStyle('normal');
				doc.setFontSize(9);
				doc.text('Return Address:', 305, 706);
				doc.text('Lyndons. T/A Habercrafts', 305, 716);
				doc.text('18 Main Drive, East Lane Business Park.', 305, 726);
				doc.text('Wembley. London. HA9 7NA', 305, 736);

				doc.setFontStyle('normal');
				doc.setFontSize(8);
				returuncenteredText('Thank you for shopping with Lyndons Art & Graphics Ltd T/A HaberCrafts.', 818);
				returuncenteredText('_________________________________________________________________________________________________________________________', 820);
				doc.setFontStyle('normal');
				doc.setFontSize(8);

				returuncenteredText('www.habercrafts.com, 18 Main Drive, East Lane Business Park, Wembley,London.HA9 7NA. UK -', 830);
				returuncenteredText('Email: sales@habercrafts.com Phone: 020 8908 4862', 840);
				isfooterComplted = 0;
			} else {
				doc.addImage(X247Invoices.HCRDisc, 'JPEG', 20, 515, 555, 115);
				if (parseFloat(isfooterheight) > parseFloat(data.cursor.y)) {
					doc.pageCount = doc.pageCount + 1;
					isfooterpage = isfooterpage + 1;
					itemgridendpos = doc.autoTableEndPosY();
					var hcrElementID = document.getElementById(hcreturnaddressid);
					if (hcrElementID === null || hcrElementID === undefined || hcrElementID === '') {

					} else {
						hcreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(hcreturnaddressid));
						doc.autoTable(hcreturnaddressres.columns, hcreturnaddressres.data, {
							margin: {
								left: 99
							},
							// startY: 625,
							startY: 630,
							pageBreak: 'avoid',
							theme: 'plain',
							styles: {
								fontSize: 10,
								fontStyle: 'bold',
								rowHeight: 15,
								overflow: 'linebreak'
							},
							tableWidth: 150
						});
					}

					if (iHCTemplate == 1) {
						doc.addImage(X247Invoices.HCRy48, 'JPEG', 250, 635, 240, 57);
						doc.setFontStyle('bold');
						doc.setFontSize(6);
						doc.text('POSTAGE PAID GB', 431, 675);
						doc.setFontSize(7);
						doc.text('HQ47082', 431, 685);
					}

					if (iHCTemplate == 2) {
						doc.addImage(X247Invoices.HCRy24, 'JPEG', 250, 635, 240, 57);
						doc.setFontStyle('bold');
						doc.setFontSize(8);
						doc.text('POSTAGE PAID GB', 400, 675);
						doc.setFontSize(8);
						doc.text('HQ47082', 400, 685);
					}

					if (iHCTemplate == 3) {
						doc.setFontStyle('bold');
						doc.setFontSize(12);
						doc.text('EXPRESS', 320, 660);
					}

					doc.setFontStyle('normal');
					doc.setFontSize(9);
					doc.text('Return Address:', 305, 706);
					doc.text('Lyndons. T/A Habercrafts', 305, 716);
					doc.text('18 Main Drive, East Lane Business Park.', 305, 726);
					doc.text('Wembley. London. HA9 7NA', 305, 736);

					doc.setFontStyle('normal');
					doc.setFontSize(8);
					returuncenteredText('Thank you for shopping with Lyndons Art & Graphics Ltd T/A HaberCrafts.', 818);
					returuncenteredText('_________________________________________________________________________________________________________________________', 820);
					doc.setFontStyle('normal');
					doc.setFontSize(8);

					returuncenteredText('www.habercrafts.com, 18 Main Drive, East Lane Business Park, Wembley,London.HA9 7NA. UK -', 830);
					returuncenteredText('Email: sales@habercrafts.com Phone: 020 8908 4862', 840);
					isfooterComplted = 0;
				}
			}


		}

		var options = {
			afterPageContent: Gridfooter,
			margin: {
				top: 80
			}
		};

		var deliveryid = "hcdeliveryvat_ppi";
		var deliveryres = '';

		var billingid = "hcbillingvat_ppi";
		var billingres = '';
		
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
			
			$('#hcbshipname_ppi').text(ship_address.Name);
			$('#hcbshipaddress1_ppi').text(ship_address.Address1);
			$('#hcbshipaddress2_ppi').text(ship_address.Address2);
			$('#hcbshipcity_ppi').text(ship_address.City);
			$('#hcbshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#hcbshippostcode_ppi').text(ship_address.PostCode);
			$('#hcbshipcountryname_ppi').text(ship_address.CountryName);
			$('#hcbshipphone_ppi').text(ship_address.Phone);
			
		/* Ship address end */

		var shippinginstid = "hcshippinginstvat_ppi";
		var shippinginstres = '';
		if(typeof data[j].buyermessage != "undefined"){
			$('#buyermessage_ppi').text(data[j].buyermessage);
		}

		var additionalinfoid = "hcadditionalinfovat_ppi";
		var additionalinfores = '';
		
		$('#shipemail_ppi').text(ship_address.Email);
		
		var childid = "hcordervat_ppi";
		var childres = '';
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var shipping_service = 'Standard';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['Quantity']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>L L</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */
		
		var channelid = "hcchannelvat_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		$('#shippingservice_ppi').text(shipping_service);
		$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/* channel data end */

		var shippingid = "hcbasicvat_ppi";
		var shippingres = '';
		
		$('#hcsshipname_ppi').text(ship_address.Name);
			$('#hcsshipaddress1_ppi').text(ship_address.Address1);
			$('#hcsshipaddress2_ppi').text(ship_address.Address2);
			$('#hcsshipcity_ppi').text(ship_address.City);
			$('#hcsshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#hcsshippostcode_ppi').text(ship_address.PostCode);
			$('#hcsshipcountryname_ppi').text(ship_address.CountryName);
			$('#hcsshipphone_ppi').text(ship_address.Phone);

		var totpriceid = "hctotalpricevat_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var newid = "hcnewvat_ppi";
		var newres = '';

		var barcodeid = "hcbarcodevat_ppi";
		var barcoderes = '';
		
		$("#hcbarImagevat_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		
		var returnaddressid = "hcBTCreturnaddressvat_ppi";
		var returnaddressres = '';


		var hcreturnaddressid = "hcreturnaddressvat_ppi";
		var hcreturnaddressres = '';
		
		$('#hcshipname_ppi').text(ship_address.Name);
			$('#hcshipaddress1_ppi').text(ship_address.Address1);
			$('#hcshipaddress2_ppi').text(ship_address.Address2);
			$('#hcshipcity_ppi').text(ship_address.City);
			$('#hcshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#hcshippostcode_ppi').text(ship_address.PostCode);
			$('#hcshipcountryname_ppi').text(ship_address.CountryName);
			$('#hcshipphone_ppi').text(ship_address.Phone);

		var hcshippingmethodid = "hcshippingmethodvat_ppi";
		var hcshippingmethodres = '';
		
		$('#hcshipping_service').text(shipping_service);

		var hcpaymentmethodid = "hcpaymentmethodvat_ppi";
		var hcpaymentmethodres = '';

		var hcOrderBoxid = "hcOrderBox_ppi";
		var hcOrderBoxres = '';

		var hcOrderBox1id = "hcOrderBox1_ppi";
		var hcOrderBox1res = '';

		var channelpos = 30;

		var iscompanyimage = 0;
		var comapnyEndPos = 0;


		doc.addImage(X247Invoices.HCRLogo, 'JPEG', 177, 10, 250, 57); // Image Center


		footer();
		doc.setFontType("bold");
		doc.setFontSize(12);
		doc.text("Lyndons Art & Graphics Ltd T/A HaberCrafts", 20, 92);
		doc.setFontType("normal");
		doc.setFontSize(9);
		doc.text("Invoice Date:", 20, 107);
		var Spurchasedate = data[j].purchasedate;
		doc.text(Spurchasedate, 80, 107); //45           
		doc.text("VAT Number :751 9381 14", 20, 122);
		doc.text("Order Number :", 20, 137);
		doc.text(data[j].orderid, 90, 137); //60
		doc.setFontType("bold");
		doc.setFontSize(12);


		var shippingEndPos = 0;

		// #region Adding Shipping Address  

		var yposordergrid = doc.autoTableEndPosY() + 30;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));


			var shippingoptions = {
				margin: {
					left: 20
				},
				startY: 142,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					overflow: 'linebreak'
				},
				tableWidth: 250
			};

			doc.autoTable(shippingres.columns, shippingres.data, shippingoptions);
			shippingEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Shipping Address

		// #region  Adding Billing Address

		var billingElementID = document.getElementById(billingid);
		if (billingElementID === null || billingElementID === undefined || billingElementID === '') {} else {
			billingres = doc.autoTableHtmlToJson(document.getElementById(billingid));
			doc.autoTable(billingres.columns, billingres.data, {
				// startY: ipos,
				margin: {
					//  left: 320
					left: 295
				},
				startY: 142,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15
				}
			});

		}

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 20,
					bottom: 320
				},
				startY: shippingEndPos + 15, // itemgridPos + 20,
				pageBreak: 'auto',
				// afterPageContent: Gridfooter,
				styles: {
					// overflow: 'linebreak',
					columnWidth: 'wrap',
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
					row.cells[0].styles.columnWidth = 'auto';
					row.cells[3].styles.halign = 'right';
					row.cells[4].styles.halign = 'right';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						//  cell.styles.halign = 'left';
						// cell.styles.columnWidth = 'auto';
						// cell.styles.overflow = 'linebreak';
						cell.styles.fontStyle = 'bold';
					}

					if (data.column.dataKey == 4) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 5) {
						cell.styles.halign = 'right';
					}
				},
				columnStyles: {
					0: {
						overflow: 'linebreak'
					},
					2: {
						columnWidth: 'auto'
					}
				}
			});
		}

		var itemgridendpos = doc.autoTableEndPosY();

		var totalPriceEndPos = 0;

		var totalpriceElementID = document.getElementById(totpriceid);
		if (totalpriceElementID === null || totalpriceElementID === undefined || totalpriceElementID === '') {

		} else {
			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			var totalpriceoptions = {
				margin: {
					left: 367,
					bottom: 320
				},
				startY: itemgridendpos + 1,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: Gridfooter1,
				styles: {
					//fillStyle: 'DF',
					//lineColor: [165, 164, 164],
					//lineWidth: 0.5,
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
					row.cells[0].styles.fontStyle = 'bold';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 1) {
						cell.styles.halign = 'right';
					}
					if (data.column.dataKey == 0) {
						//  cell.styles.halign = 'left';
						cell.styles.fontStyle = 'bold';
					}

					if (data.column.dataKey == 2) {
						cell.styles.fontStyle = 'bold';
					}
					if (data.column.dataKey == 3) {
						cell.styles.fontStyle = 'bold';
					}
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
			totalPriceEndPos = doc.autoTableEndPosY();
		}

		// #endregion Adding Price Calculation Grid

		if (parseFloat(totalPriceEndPos) >= parseFloat(620)) {
			doc.addPage();
		}
		doc.addImage(X247Invoices.HCRDisc, 'JPEG', 20, 515, 555, 115);
		var hcrElementID = document.getElementById(hcreturnaddressid);
		if (hcrElementID === null || hcrElementID === undefined || hcrElementID === '') {

		} else {
			hcreturnaddressres = doc.autoTableHtmlToJson(document.getElementById(hcreturnaddressid));
			doc.autoTable(hcreturnaddressres.columns, hcreturnaddressres.data, {
				margin: {
					left: 99
				},
				// startY: 625,
				startY: 630,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fontSize: 10,
					fontStyle: 'bold',
					rowHeight: 15,
					overflow: 'linebreak'
				},
				tableWidth: 150
			});
		}

		if (iHCTemplate == 1) {
			doc.addImage(X247Invoices.HCRy48, 'JPEG', 250, 635, 240, 57);
			doc.setFontStyle('bold');
			doc.setFontSize(6);
			doc.text('POSTAGE PAID GB', 431, 675);
			doc.setFontSize(7);
			doc.text('HQ47082', 431, 685);
		}

		if (iHCTemplate == 2) {
			doc.addImage(X247Invoices.HCRy24, 'JPEG', 250, 635, 240, 57);
			doc.setFontStyle('bold');
			doc.setFontSize(8);
			doc.text('POSTAGE PAID GB', 400, 675);
			doc.setFontSize(8);
			doc.text('HQ47082', 400, 685);
		}

		if (iHCTemplate == 3) {
			doc.setFontStyle('bold');
			doc.setFontSize(12);
			doc.text('EXPRESS', 320, 660);
		}

		doc.setFontStyle('normal');
		doc.setFontSize(9);
		doc.text('Return Address:', 305, 706);
		doc.text('Lyndons. T/A Habercrafts', 305, 716);
		doc.text('18 Main Drive, East Lane Business Park.', 305, 726);
		doc.text('Wembley. London. HA9 7NA', 305, 736);

		doc.setFontStyle('normal');
		doc.setFontSize(8);
		returuncenteredText('Thank you for shopping with Lyndons Art & Graphics Ltd T/A HaberCrafts.', 818);
		returuncenteredText('_________________________________________________________________________________________________________________________', 820);
		doc.setFontStyle('normal');
		doc.setFontSize(8);

		returuncenteredText('www.habercrafts.com, 18 Main Drive, East Lane Business Park, Wembley,London.HA9 7NA. UK -', 830);
		returuncenteredText('Email: sales@habercrafts.com Phone: 020 8908 4862', 840);


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