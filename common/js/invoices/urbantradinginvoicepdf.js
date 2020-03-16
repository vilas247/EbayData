function UrbanTradingFinalInvoicePDF(data) {
	var doc = new jsPDF('p', 'pt', [420, 595]);
	doc.page = 1;
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	var UTUnConditionOrders = [];
	var s4 = UTUnConditionOrders;
	var s5 = '';

	if (s4.length > 0) {
		s4 = s4.replace(/,/g, '","');
		s5 = '"' + s4;
		s5 = s5.substring(0, s5.length - 2);
	}

	for (var j = 0; j < data.length; j++) {

		var s7 = [];
		var s9 = [];
		s9.push(data[j]);
		s7 = alasql('select * from ? where  orderid in (' + s5 + ')', [s9]);

		if (s7.length > 0) {
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
		} else {
			var totalPagesExp = data.length;
			var options = {
				margin: {
					top: 20
				}
			};

			var centeredText = function (text, y) {
				doc.setFontSize(7);
				var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
				var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
				//  doc.setFont("helvetica");
				doc.setTextColor(0, 0, 0);

				doc.text(textOffset, y, text);
			};


			var UTcompanyid = "UT_companyaddr_ppi";
			var UTcompanyres = '';

			var UTStampBoxid = "UTStampBox_ppi";
			var UTStampBoxres = '';

			var UTreturnaddressvatid = "UTreturnaddressvat_ppi";
			var UTreturnaddressvatres = '';
			
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

			var UTSPAddrvatid = "UTSPAddrvat_ppi";
			var UTSPAddrvatres = '';
			
			$('#utshipname_ppi').text(ship_address.Name);
			$('#utshipaddress1ppi').text(ship_address.Address1);
			$('#utshipaddress2ppi').text(ship_address.Address2);
			$('#utshipcity_ppi').text(ship_address.City);
			$('#utshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#utshippostcode_ppi').text(ship_address.PostCode);
			$('#utshipcountryname_ppi').text(ship_address.CountryName);
			$('#utshipphone_ppi').text(ship_address.Phone);
			$('#utshipemail_ppi').text(ship_address.Email);

			var UTcorderid = "UTcorder_ppi";
			var UTcorderres = '';
			
			/* orders data */
			var multiple_orders = {};
			var multiple_orders_items = '';
			
			if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Quantity']+"</span></td><td>"+multiple_orders[jm]['Sku']+"</td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td></tr>";
			}
		}
			
			$('#multipleorders_ppi').html(multiple_orders_items);
			/* orders data end */

			var UTtotalpricevatid = "UTtotalpricevat_ppi";
			var UTtotalpricevatres = '';
			
			/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
			/* total price end */

			var newid = "UTnew_ppi";
			var newres = '';

			var UTRetAddrVatid = "UTSPAddrRetvat_ppi";
			var UTRetAddrVatres = '';
			
			$('#utsshipname_ppi').text(ship_address.Name);
			$('#utsshipaddress1ppi').text(ship_address.Address1);
			$('#utsshipaddress2ppi').text(ship_address.Address2);
			$('#utsshipcity_ppi').text(ship_address.City);
			$('#utsshipstateorregion_ppi').text(ship_address.StateOrRegion);
			$('#utsshippostcode_ppi').text(ship_address.PostCode);
			
			var startpos = 10;

			var CContinue = 0;


			// #region Calculate Height and Weight 

			var mainweight = [];
			var mainheight = [];
			if (data[j].orderitems.length > 0) {
				$.each(data[j].orderitems, function (ky1,it1) {
					if (typeof it1.Weight !== "undefined" && it1.Weight !== '') {
						mainweight.push(parseFloat(it1.Weight));
					}

					if (typeof it1.Mpn !== "undefined" && it1.Mpn !== '') {
						mainheight.push(parseFloat(it1.Mpn));
					}
				});
			}
			var ItemWeight = 0;
			if (mainweight.length > 0) {
				$.each(mainweight, function (itw, kyw) {
					ItemWeight = parseFloat(ItemWeight) + parseFloat(itw);
				});
			}
			var ItemHeight = 0;
			if (mainheight.length > 0) {
				$.each(mainheight, function (itw, kyw) {
					ItemHeight = parseFloat(ItemHeight) + parseFloat(itw);
				});
			}

			// #endregion Calculate Height and Weight 

			// #region Item Calculations of Subtotal,Shipping Price and Total Price

			var pp = 0.00;
			if (data[j].orderitems.length > 0) {
				$.each(data[j].orderitems, function (k, v) {
					pp += parseFloat(v.UnitPrice);
				});
			}
			var utsubtot = 0.00;
			if (data[j].orderitems.length > 1) {
				$.each(data[j].orderitems, function (k, v) {
					utsubtot += parseFloat(v.totalprice);
				});
			}

			var utnetotot = 0.00;
			utnetotot = parseFloat(parseFloat(pp) + parseFloat(utsubtot)).toFixed(2);

			// #endregion Item Calculations of Subtotal,Shipping Price and Total Price


			// if (CContinue != 0) {

			// #region Company Logo

			if (data[j].accountcode == 228 && data[j].marketplacecode == 2) {
				doc.setFontType("normal");
				doc.setFontSize(35);
				doc.text("S A P A", 20, 50);
				doc.setFontType("normal");
				doc.setFontSize(9);
			} else {
				doc.addImage(X247Invoices.UTMainLogo, 'JPEG', 20, 20, 125, 45);
				doc.addImage(X247Invoices.UTQRCode, 'JPEG', 360, 20, 45, 45);

				doc.setFontType("normal");
				doc.setFontSize(11);
				doc.text("ebay@urbantrading.co.uk", 230, 30);
				doc.text("0333 577 00890", 275, 60);
				doc.setFontType("normal");
				doc.setFontSize(9);
			}

			// #endregion Company Logo

			// #region Items Details Grid

			var PNDOrderElementID = document.getElementById(UTcorderid);
			if (PNDOrderElementID === null || PNDOrderElementID === undefined || PNDOrderElementID === '') {

			} else {
				UTcorderres = doc.autoTableHtmlToJson(document.getElementById(UTcorderid));
				doc.autoTable(UTcorderres.columns, UTcorderres.data, {
					margin: {
						left: 20
					},
					startY: 75,
					pageBreak: 'auto',
					theme: 'plain',
					styles: {
						overflow: 'linebreak',
						fontSize: 9,
						rowHeight: 16
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						fontSize: 10,
						textColor: [0, 0, 0],
						fontStyle: 'normal',
						rowHeight: 25
					},
					bodyStyles: {
						fillColor: [255, 255, 255],
						textColor: [0, 0, 0]
					},
					drawHeaderRow: function (row, data) {
						row.cells[1].styles.halign = 'center';
						row.cells[2].styles.halign = 'center';
						row.cells[3].styles.halign = 'right';

					},
					createdCell: function (cell, data) {

						if ((data.column.dataKey == 1) || (data.column.dataKey == 2)) {
							cell.styles.halign = 'center';
						}
						if ((data.column.dataKey == 3)) {
							cell.styles.halign = 'right';
						}
					}
				});
			}

			doc.text("_____________________________________________________________________________", 20, 94);
			doc.text("_____________________________________________________________________________", 20, doc.autoTableEndPosY() + 3);

			// #endregion Items Details Grid


			// #region Display Total Calculations

			doc.setFontType("normal");
			doc.setFontSize(8);

			doc.text("Invoice:", 20, doc.autoTableEndPosY() + 17);

			doc.text("Order Date:", 20, doc.autoTableEndPosY() + 37);

			doc.text("Bill To:", 20, doc.autoTableEndPosY() + 57);

			doc.text("Payment Via:", 20, doc.autoTableEndPosY() + 77);


			doc.writeText(0, doc.autoTableEndPosY() + 17, "+ P & P:", {
				align: 'right',
				width: 355
			});
			doc.writeText(0, doc.autoTableEndPosY() + 37, "- DISCOUNT:", {
				align: 'right',
				width: 355
			});
			doc.writeText(0, doc.autoTableEndPosY() + 37, "£ 0.00", {
				align: 'right',
				width: 390
			});
			doc.text("___________", 357, doc.autoTableEndPosY() + 42);

			doc.writeText(0, doc.autoTableEndPosY() + 57, "= NET TOTAL:", {
				align: 'right',
				width: 355
			});

			doc.writeText(0, doc.autoTableEndPosY() + 77, "+ VAT TOTAL:", {
				align: 'right',
				width: 355
			});

			doc.text("___________", 357, doc.autoTableEndPosY() + 83);
			doc.writeText(0, doc.autoTableEndPosY() + 97, '= INVOICE TOTAL:', {
				align: 'right',
				width: 355
			});


			doc.text("_______________________________________________________________________________________", 20, doc.autoTableEndPosY() + 107);


			doc.setFontType("normal");
			doc.setFontSize(8);

			doc.text(data[j].orderid, 52, doc.autoTableEndPosY() + 17);


			var pdate = '';
			var PDdate = new Date();
			var PDDateValue = data[j].purchasedate;
			doc.text(PDDateValue, 65, doc.autoTableEndPosY() + 37);

			doc.text(data[j].shippingaddresses[0].Name, 50, doc.autoTableEndPosY() + 57);


			if (data[j].paymentmethod !== 'undefined' && data[j].paymentmethod != null && data[j].paymentmethod != '') {
				doc.text(data[j].paymentmethod, 70, doc.autoTableEndPosY() + 77);
			} else {
				doc.text("", 70, doc.autoTableEndPosY() + 77);
			}


			doc.writeText(0, doc.autoTableEndPosY() + 17, "£ " + parseFloat(pp).toString(), {
				align: 'right',
				width: 390
			});
			doc.writeText(0, doc.autoTableEndPosY() + 57, "£ " + parseFloat(utnetotot).toString(), {
				align: 'right',
				width: 390
			});

			var utvat = 0.00;

			utvat = X247Invoices.GrandTotalWithVatHaberCrafts(j, data[j].orderitems, data[j]);
			doc.writeText(0, doc.autoTableEndPosY() + 77, "£ " + parseFloat(utvat).toString(), {
				align: 'right',
				width: 390
			});
			var utfinaltot = 0.00;
			utfinaltot = parseFloat(utnetotot) + parseFloat(utvat);
			doc.writeText(0, doc.autoTableEndPosY() + 97, "£ " + parseFloat(utfinaltot).toString(), {
				align: 'right',
				width: 390
			});

			if (data[j].accountcode == 228 && data[j].marketplacecode == 2) {
				centeredText("Sapa, Unit 4 & 5 Bevan Court, Bevan Close, Finedon Road Industrial Estate, Wellingborough, Northamptonshire,", 375);
				centeredText(" NN8 4BL, Company Reg: 08323554", 385);
			} else {
				centeredText("Urban Trading, Unit 7 Bevan Court, Bevan Close, Finedon Road Industrial Estate, Wellingborough, Northamptonshire,", 375);
				centeredText("NN8 4BL, Company Reg: 06932270 || VAT Reg: GB978509854", 385);
			}

			// #endregion Display Total Calculations
			// }

			// #region Shipping  Address Condition

			if (typeof data[j].shippingaddresses[0].CountryCode !== 'undefined') {

				var resInclude = [];
				console.log(resInclude.length, "resInclude length 1");
				resInclude = alasql('select * from ? where name=? OR code=?', [X247Invoices.getIncludeCountryCodes, data[j].shippingaddresses[0].CountryCode, data[j].shippingaddresses[0].CountryCode]);

				var resExclude = [];
				resExclude = alasql('select * from ? where name=? OR code=?', [X247Invoices.getExcludeCountryCodes, data[j].shippingaddresses[0].CountryCode, data[j].shippingaddresses[0].CountryCode]);
				//   if (resInclude.length > 0) {
				if (data[j].shippingaddresses[0].CountryCode === "GB" || data[j].shippingaddresses[0].CountryCode === 'UK' || data[j].shippingaddresses[0].CountryCode === 'United Kingdom') {

					var addrContinue = 0;

					if ((parseFloat(utnetotot) >= 0 && parseFloat(utnetotot) < 20) && (parseFloat(ItemWeight) < 1000) && (parseFloat(pp) == 0) && (parseFloat(ItemHeight) < 25)) {
						doc.addImage(X247Invoices.UTRM48, 'JPEG', 20, 388, 380, 50);
						doc.addImage(X247Invoices.UTRoyalMailLogo, 'JPEG', 355, 500, 35, 35);
						CContinue = 1;
						addrContinue = 1;
						console.log("UTRM48");
					} else if ((parseFloat(utnetotot) >= 0 && parseFloat(utnetotot) < 30) && (parseFloat(ItemWeight) >= 0 && parseFloat(ItemWeight) < 15000) && (parseFloat(pp) == 0)) {
						doc.addImage(X247Invoices.UTRM48Tracked, 'JPEG', 20, 388, 380, 50);
						doc.addImage(X247Invoices.UTRoyalMailLogo, 'JPEG', 355, 500, 35, 35);
						CContinue = 1;
						addrContinue = 1;
						console.log("UTRM48 Tracked");
					} else if (parseFloat(pp) > parseFloat("5.98")) {

						if (data[j].accountcode == 228 && data[j].marketplacecode == 2) {
							doc.setFontType("normal");
							doc.setFontSize(35);
							doc.text("S A P A", 30, 425);
							doc.addImage(X247Invoices.UTsign, 'JPEG', 20, 430, 381, 145);
							doc.setFontType("normal");
							doc.setFontSize(9);
							var txtfootertext = "SAPA,Order #" + data[j].orderid + ", Unit 4 & 5 Bevan Court, Bevan Close, Finedon Road Industrial Estate,";
							var txtfootertext1 = "Wellingborough, Northamptonshire, NN8 4BL";
							centeredText(txtfootertext, 575);
							centeredText(txtfootertext1, 585);
							CContinue = 1;
							addrContinue = 0;
							console.log("UTsign");
						} else {
							doc.addImage(X247Invoices.UTsign, 'JPEG', 20, 430, 381, 145);
							doc.addImage(X247Invoices.UTMainLogo, 'JPEG', 20, 390, 125, 45);
							doc.setFontType("normal");
							doc.setFontSize(9);
							var txtfootertext = "Urban Trading,Order #" + data[j].orderid + ", Unit 7 Bevan Court, Bevan Close, Finedon Road Industrial Estate,";
							var txtfootertext1 = "Wellingborough, Northamptonshire, NN8 4BL";
							centeredText(txtfootertext, 575);
							centeredText(txtfootertext1, 585);
						}
					} else {
						console.log("Item Not in this condition:", data[j].orderid);
						// continue;
						CContinue = 0;
						addrContinue = 0;
					}

					if (CContinue != 0 && addrContinue != 0) {
						var UTRetAddrVatElementID = document.getElementById(UTRetAddrVatid);
						if (UTRetAddrVatElementID === null || UTRetAddrVatElementID === undefined || UTRetAddrVatElementID === '') {

						} else {
							UTRetAddrVatres = doc.autoTableHtmlToJson(document.getElementById(UTRetAddrVatid));
							doc.autoTable(UTRetAddrVatres.columns, UTRetAddrVatres.data, {
								margin: {
									left: 20
								},
								startY: 450,
								pageBreak: 'auto',
								theme: 'plain',
								styles: {
									overflow: 'linebreak',
									// fontSize: 14,
									fontSize: 8,
									fontStyle: 'normal',
									rowHeight: 14
								},
								headerStyles: {
									fillColor: [255, 255, 255],
									//  fontSize: 14,
									fontSize: 8,
									textColor: [0, 0, 0],
									fontStyle: 'bold',
									rowHeight: 14
								},
								bodyStyles: {
									fillColor: [255, 255, 255],
									textColor: [0, 0, 0]
								},
								tableWidth: 275
							});
						}
					}

				} else if (resInclude.length > 0) {
					doc.addImage(X247Invoices.UTPPLStamp, 'JPEG', 20, 400, 180, 45);
					CContinue = 1;

					if (CContinue != 0) {
						var UTRetAddrVatElementID = document.getElementById(UTRetAddrVatid);
						if (UTRetAddrVatElementID === null || UTRetAddrVatElementID === undefined || UTRetAddrVatElementID === '') {

						} else {
							UTRetAddrVatres = doc.autoTableHtmlToJson(document.getElementById(UTRetAddrVatid));
							doc.autoTable(UTRetAddrVatres.columns, UTRetAddrVatres.data, {
								margin: {
									left: 20
								},
								startY: 450,
								pageBreak: 'auto',
								theme: 'plain',
								styles: {
									overflow: 'linebreak',
									// fontSize: 14,
									fontSize: 8,
									fontStyle: 'normal',
									rowHeight: 14
								},
								headerStyles: {
									fillColor: [255, 255, 255],
									//  fontSize: 14,
									fontSize: 8,
									textColor: [0, 0, 0],
									fontStyle: 'bold',
									rowHeight: 14
								},
								bodyStyles: {
									fillColor: [255, 255, 255],
									textColor: [0, 0, 0]
								},
								tableWidth: 275
							});
						}

						//   doc.addImage(UTCN22, 'JPEG', 245, 410, 165, 165);
						//   doc.addImage(UTCN22, 'JPEG', 245, 410, 155, 165);

					}
				} else if (resExclude.length > 0) {
					//  CN22
					console.log(resExclude, "resExclude direct link  Tracked");
					// console.log(ItemWeight, "$scope.xmlTempArr[j].invoice.orderid", $scope.xmlTempArr[j].invoice.orderid);

					if (parseFloat(utnetotot) < 2000 && parseFloat(ItemWeight) < 30) {
						doc.addImage(X247Invoices.UTPPLStamp, 'JPEG', 20, 400, 180, 45);
						CContinue = 1;
					} else if (parseFloat(utnetotot) > 2000 || parseFloat(ItemWeight) > 30) {
						doc.addImage(X247Invoices.UTIntTracked, 'PNG', 20, 400, 155, 45);
						CContinue = 1;
					} else {
						CContinue = 0;
						continue;
					}
					// doc.addImage(UTRM48, 'JPEG', 20, 388, 380, 50);
					if (CContinue != 0) {
						var UTRetAddrVatElementID = document.getElementById(UTRetAddrVatid);
						if (UTRetAddrVatElementID === null || UTRetAddrVatElementID === undefined || UTRetAddrVatElementID === '') {

						} else {
							UTRetAddrVatres = doc.autoTableHtmlToJson(document.getElementById(UTRetAddrVatid));
							doc.autoTable(UTRetAddrVatres.columns, UTRetAddrVatres.data, {
								margin: {
									left: 20
								},
								startY: 450,
								pageBreak: 'auto',
								theme: 'plain',
								styles: {
									overflow: 'linebreak',
									// fontSize: 14,
									fontSize: 8,
									fontStyle: 'normal',
									rowHeight: 14
								},
								headerStyles: {
									fillColor: [255, 255, 255],
									//  fontSize: 14,
									fontSize: 8,
									textColor: [0, 0, 0],
									fontStyle: 'bold',
									rowHeight: 14
								},
								bodyStyles: {
									fillColor: [255, 255, 255],
									textColor: [0, 0, 0]
								},
								tableWidth: 275
							});
						}

						//   doc.addImage(UTCN22, 'JPEG', 245, 410, 165, 165);
						doc.addImage(X247Invoices.UTCN22, 'JPEG', 245, 410, 155, 165);

					}
				} else {

				}
			}

			// #endregion Shipping  Address Condition

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
}