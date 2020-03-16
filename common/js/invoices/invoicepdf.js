/* Invoice With PPI */
function invoicePDF(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	for (var j = 0; j < data.length; j++) {
		var totalPagesExp = data.length;

		var mpc = '';
		var n = '';
		var merTempArray = '';
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')(tempordDetails, {
				"ordernumber": xmlTempArr[j].orderid
			}, true);*/
		}


		var options = {
			// afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var companyid = "BVcompanylogo_ppi";
		var companyres = '';

		var deliveryid = "BVdelivery_ppi";
		var deliveryres = '';

		var channelid = "BVchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "BVbasic_ppi";
		var shippingres = '';

		var childid = "BVorder_ppi";
		var childres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				multiple_orders_items += "<tr><td>"+multiple_orders[jm]['Sku']+"</td><td><span>"+multiple_orders[jm]['ProductTitle']+"</span></td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */

		var totpriceid = "BVtotalprice_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalUnitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));
		/* total price end */

		var returnid = "BVreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "BVshippingservice_ppi";
		var shippingserviceres = '';
		
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
			$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/*special shipping service end */

		var boxid = "BVboxreturnaddress_ppi";
		var boxres = '';
		
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

		var newid = "mnew_ppi";
		var newres = '';

		var barcodeid = "BVbarcode_ppi";
		var barcoderes = '';
		
		/* barcode start */
		$("#BVbarImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});
		/* barcode end */

		var returnaddressid = "BVCreturnaddress_ppi";
		var returnaddressres = '';
		
		/*Return address */
			var return_address = data[j]['invoicetoaddresses'][0];
			$('#spComp1A_ppi').text(return_address.Address1);
			$('#spComp1B_ppi').text(return_address.Address2);
			//$('#spComp1C_ppi').text(return_address.City);
			$('#spComp1D_ppi').text(return_address.City);
			$('#spComp1E_ppi').text(return_address.PostCode);
			$('#spComp1F_ppi').text(return_address.CountryName);
		/* Return address end */


		var channelpos = '';

		//  var companypos = doc.autoTableEndPosY() + 30;
		var companypos = 30;
		var orderpos = '';

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


		/* Bar Image Integration */

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

			doc.autoTable(dataImage.columns, dataImage.rows, {
				margin: {
					left: 360
				},
				startY: channelpos - 3,
				theme: 'plain',
				//bodyStyles: {
				//    rowHeight: 52
				//},
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
						doc.addImage(images[i].elem, 'png', images[i].x, images[i].y, 150, 52);
					}
				}

			});
		}

		var channelElementID = document.getElementById(channelid);
		if (channelElementID === null || channelElementID === undefined || channelElementID === '') {

		} else {
			channelres = doc.autoTableHtmlToJson(document.getElementById(channelid));
			var barendpos = 0;
			if (mindex == 0) {
				barendpos = 82;
			} else {
				barendpos = doc.autoTableEndPosY() + 30;
			}
			doc.autoTable(channelres.columns, channelres.data, {
				margin: {
					left: 340
				},

				startY: barendpos, //doc.autoTableEndPosY() + 30,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.fontStyle = 'normal';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.halign = 'right';
						cell.styles.fontStyle = 'bold';
					}
				}
			});
		}

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {

			var ipos = 0;
			if (iscompanyimage == 1) {
				ipos = 110;
			} else {
				ipos = 30;
			}


			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
			var shippingoptions = {
				startY: ipos,
				//  startY: companypos,                   
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8
				},
				tableWidth: 200,
				createdCell: function (cell, data) {
					if (data.column.dataKey == 8) {
						cell.styles.fontStyle = 'bold';
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
				startY: doc.autoTableEndPosY() + 10,
				pageBreak: 'auto',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					fontSize: 8
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
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

		var shipservicepos = '';
		var shippingserviceElementID = document.getElementById(shippingserviceid);
		if (shippingserviceElementID === null || shippingserviceElementID === undefined || shippingserviceElementID === '') {

		} else {
			shippingserviceres = doc.autoTableHtmlToJson(document.getElementById(shippingserviceid));
			shipservicepos = doc.autoTableEndPosY() + 1;
			var shippingserviceoptions = {
				margin: {
					left: 40
				},
				startY: doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
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
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.halign = 'right';
					row.cells[1].styles.fontStyle = 'normal';
					row.cells[1].styles.overflow = 'linebreak';
				},
				createdCell: function (cell, data) {
					// // console.log.log("Cell", cell, "Data", data);
					if (data.column.dataKey == 0) {
						cell.styles.halign = 'right';
						cell.styles.fontStyle = 'bold';
					}
					cell.styles.fontSize = '8';
				},
				tableWidth: 275,
				styles: {
					overflow: 'linebreak'
				}
			};

			doc.autoTable(shippingserviceres.columns, shippingserviceres.data, shippingserviceoptions);
		}


		var totalpriceElementID = document.getElementById(totpriceid);
		if (totalpriceElementID === null || totalpriceElementID === undefined || totalpriceElementID === '') {

		} else {
			totpriceres = doc.autoTableHtmlToJson(document.getElementById(totpriceid));

			var totalpriceoptions = {
				margin: {
					left: 367
				},
				startY: shipservicepos + 1, //doc.autoTableEndPosY() + 1,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					fontSize: 8,
					overflow: 'linebreak'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
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
					//if (data.column.dataKey == 1) {
					cell.styles.halign = 'right';
					// }
				}
			};

			doc.autoTable(totpriceres.columns, totpriceres.data, totalpriceoptions);
		}


		var returnyPosition = doc.autoTableEndPosY();
		var newpos = 0;
		var lblreturn = 0;

		var returnElementID = document.getElementById(returnid);
		if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

		} else {
			returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
			newpos = 600;
			lblreturn = newpos - 6;
			var DynamicPGSize = 530;
			if (parseInt(returnyPosition) >= parseInt(DynamicPGSize)) {
				doc.addPage();
			}

			doc.setFontSize(8);
			doc.setFontType("bold");
			doc.text('FOR RETURNS NOTE INFORMATION PLEASE REFER TO BELOW', 40, lblreturn);
			doc.autoTable(returnres.columns, returnres.data, {
				startY: newpos,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					rowHeight: 195,
					fontSize: 8
				}
			});

			boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
			doc.autoTable(boxres.columns, boxres.data, {
				margin: {
					left: 65
				},
				startY: newpos + 40,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					overflow: 'linebreak'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				tableWidth: 182

			});


			doc.setFontType("normal");
			doc.setFontSize(8);

			var strcomp1 = '';
			var strcomp2 = '';
			var comaddr = 1;
			if (comaddr == 1) {

				if (typeof $('#spComp1A_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1A_' + j + ' span').html() + " ";

				if (typeof $('#spComp1B_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1B_' + j + ' span').html() + " ";

				if (typeof $('#spComp1C_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1C_' + j + ' span').html() + " ";

				if (typeof $('#spComp1D_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1D_' + j + ' span').html() + " ";

				if (typeof $('#spComp1E_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1E_' + j + ' span').html() + " ";

				if (typeof $('#spComp1F_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp1F_' + j + ' span').html();

				doc.text('If undelivered please return to: ' + strcomp1, 45, newpos + 178);
				//  doc.text(strcomp2, 50, newpos + 189);
			}

			if (comaddr == 0) {

				if (typeof $('#spComp2A_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2A_' + j + ' span').html() + " ";

				if (typeof $('#spComp2B_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2B_' + j + ' span').html() + " ";

				if (typeof $('#spComp2C_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2C_' + j + ' span').html() + " ";

				if (typeof $('#spComp2D_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2D_' + j + ' span').html() + " ";

				if (typeof $('#spComp2E_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2E_' + j + ' span').html() + " ";

				if (typeof $('#spComp2F_' + j + ' span').html() != 'undefined')
					strcomp1 += $('#spComp2F_' + j + ' span').html();

				doc.text('If undelivered please return to: ' + strcomp1, 45, newpos + 178);
				// doc.text(strcomp2, 50, newpos + 189);
			}

			if (mindex == 0) {
				doc.setFontType("bold");
				doc.text("Order No's: ", 45, newpos + 188);
				if (typeof merTempArray != 'undefined' && merTempArray != null && merTempArray != '') {
					doc.text(merTempArray, 95, newpos + 188);
				} else {
					doc.text('', 95, newpos + 188);
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