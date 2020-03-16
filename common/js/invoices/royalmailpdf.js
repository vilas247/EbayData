function royalmailPDF(data) {

	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	
	var courier_label = $('#courierlabel_select').val();
	var services_label = $('#serviceslabel_select').val();
	var template_label = $('#templatelabel_select').val();


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
		var options = {
			margin: {
				top: 80
			}
		};

		var companyid = "rmcompanylogo_ppi";
		var companyres = '';

		var deliveryid = "rmdelivery_ppi";
		var deliveryres = '';

		var channelid = "rmchannel_ppi";
		var channelres = '';
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */

		var shippingid = "rmbasic_ppi";
		var shippingres = '';

		var childid = "rmorder_ppi";
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

		var totpriceid = "rmtotalprice_ppi";
		var totpriceres = '';
		
		/*totalprice */
			$('#totalprice_ppi').text(X247Invoices.FredricksubtotalunitPrice(j,data[j].orderitems));
			$('#grandtotal_ppi').text(X247Invoices.FredrickGrandTotalWithVatHaberCrafts(j,data[j].orderitems,data[j]));
		/* total price end */

		var returnid = "rmreturnaddress_ppi";
		var returnres = '';

		var shippingserviceid = "rmshippingservice_ppi";
		var shippingserviceres = '';
		
		/*special shipping */
			$('#shippingservice_ppi').text(shipping_service);
			$('#paymentmethod_ppi').text(data[j].paymentmethod);
		/*special shipping service end */

		var boxid = "rmboxreturnaddress_ppi";
		var boxres = '';
		
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

		var newid = "mnew_ppi";
		var newres = '';

		var barcodeid = "rmbarcode_ppi";
		var barcoderes = '';
		
		$("#rmbarImage_ppi").JsBarcode(data[j].orderid, {
			format: "CODE128", width: 1, displayValue: true, height: 40
		});

		var returnaddressid = "rmCreturnaddress_ppi";
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

		var AZDashid = "rmDash_ppi";
		var AZDashres = '';

		var rmordernoteid = "rmordernote_ppi";
		var rmordernoteres = '';


		var channelpos = '';
		var companypos = 30;
		var orderpos = '';

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

		var cserviceName = [];

		/*cserviceName = $filter('filter')($scope.ddlCourierServices, {
			"id": parseInt($scope.InvoicetemplateID.itype)
		}, true);*/
		cserviceName = X247Invoices.checkFilter(X247Invoices.ddlCourierServices,template_label);

		doc.setFontType("bold");
		doc.setFontSize(13);
		var countryCodechecking = data[j];

		if (typeof countryCodechecking.shippingaddresses[0].CountryCode !== 'undefined') {
			if (countryCodechecking.shippingaddresses[0].CountryCode === "GB" || countryCodechecking.shippingaddresses[0].CountryCode === 'UK' || countryCodechecking.shippingaddresses[0].CountryCode === 'United Kingdom') {
				doc.addImage(X247Invoices.royalmailInvoiceLogo, 'JPEG', 40, 30, 515, 100);
				if (cserviceName.length > 0) {
					doc.text(cserviceName[0].cvalue, 385, 120);
				} else {
					var text1 = "HQ71198";
					doc.text(text1, 385, 120);
				}
			} else {
				doc.addImage(X247Invoices.royalmail1smail, 'JPEG', 40, 30, 515, 100);

				if (cserviceName.length > 0) {
					doc.text(cserviceName[0].cvalue, 420, 125);
				} else {
					var text1 = "HQ71198";
					doc.text(text1, 420, 125);
				}
				doc.addImage(X247Invoices.royalAirmail, 'JPEG', 40, 30, 235, 85);
			}
		} else {
			doc.addImage(X247Invoices.royalmailInvoiceLogo, 'JPEG', 40, 30, 515, 100);
			if (cserviceName.length > 0) {
				doc.text(cserviceName[0].cvalue, 385, 120);
			} else {
				var text1 = "HQ71198";
				doc.text(text1, 385, 120);
			}
		}

		doc.setFontType("normal");
		doc.setFontSize(8);

		var returnyPosition = doc.autoTableEndPosY();
		var newpos = 0;
		var lblreturn = 0;

		var returnElementID = document.getElementById(returnid);
		if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

		} else {
			if (dbcode == 41) {
				returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
				newpos = 150;
				doc.autoTable(returnres.columns, returnres.data, {
					startY: newpos,
					theme: 'plain',
					styles: {
						fillStyle: 'DF',
						lineColor: [165, 164, 164],
						lineWidth: 0.5,
						overflow: 'linebreak',
						//  rowHeight: 155,
						rowHeight: 165,
						fontSize: 8
					}
				});

				boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
				doc.autoTable(boxres.columns, boxres.data, {
					margin: {
						left: 45
					},
					startY: newpos + 10,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						rowHeight: 22,
						fontSize: 16,
						overflow: 'linebreak',
						fontStyle: 'bold'
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						fontSize: 16,
						textColor: [0, 0, 0],
						//fontStyle: 'normal'
						fontStyle: 'bold'
					},
					tableWidth: 400

				});
			} else {
				returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
				newpos = 150;
				doc.autoTable(returnres.columns, returnres.data, {
					startY: newpos,
					theme: 'plain',
					styles: {
						fillStyle: 'DF',
						lineColor: [165, 164, 164],
						lineWidth: 0.5,
						overflow: 'linebreak',
						rowHeight: 145,
						fontSize: 8
					}
				});

				boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
				doc.autoTable(boxres.columns, boxres.data, {
					margin: {
						left: 45
					},
					startY: newpos + 10,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						rowHeight: 20,
						fontSize: 14,
						overflow: 'linebreak',
						fontStyle: 'bold'
					},
					headerStyles: {
						fillColor: [255, 255, 255],
						fontSize: 14,
						textColor: [0, 0, 0],
						//fontStyle: 'normal'
						fontStyle: 'bold'
					},
					tableWidth: 280

				});
			}
		}

		doc.addImage(X247Invoices.royalmailDeliverLogo1, 'JPEG', 450, 160, 100, 100);

		doc.setFontSize(12);
		doc.setFontType("normal");
		var lblOrderID = data[j].orderid;

		//  doc.text('Order :', 40, 320);
		doc.text('Order :', 40, 330);
		doc.setFontType("bold");
		// doc.text(lblOrderID, 85, 320);
		doc.text(lblOrderID, 85, 330);
		var ryShipping = '';

		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService === 'undefined') {
				ryShipping = "standard";
			} else {
				ryShipping = data[j].orderitems[0].ShippingService;
			}
		}

		//  doc.text(ryShipping, 40, 335);
		doc.text(ryShipping, 40, 345);


		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				//startY: 450,
				startY: 350,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fontSize: 14,
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 14,
					textColor: [0, 0, 0],
					fontStyle: 'normal'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				}
			});
		}

		if (dbcode == 41) {
			if (typeof data[j].buyermessage !== 'undefined') {
				var rmordernoteElementID = document.getElementById(rmordernoteid);
				if (rmordernoteElementID === null || rmordernoteElementID === undefined || rmordernoteElementID === '') {

				} else {
					rmordernoteres = doc.autoTableHtmlToJson(document.getElementById(rmordernoteid));
					doc.autoTable(rmordernoteres.columns, rmordernoteres.data, {
						//startY: 450,
						startY: doc.autoTableEndPosY() + 20,
						pageBreak: 'auto',
						theme: 'plain',
						// afterPageContent: footer,
						styles: {
							overflow: 'linebreak',
							fontSize: 14,
							fontStyle: 'normal'
						},
						headerStyles: {
							fillColor: [255, 255, 255],
							fontSize: 14,
							textColor: [0, 0, 0],
							fontStyle: 'normal'
						},
						bodyStyles: {
							fillColor: [255, 255, 255],
							textColor: [0, 0, 0]
						}
					});
				};
			}
		}


		var miorder = '';
		miorder = data[j].orderid;

		var mindex = miorder.indexOf("M-");
		if (mindex == 0) {
			doc.setFontType("bold");
			doc.setFontSize(9);
			doc.text("Order No's: ", 40, 766);
			// doc.text($scope.xmlTempArr[j].invoice.Mergeitemorders, 90, 766);

			if (typeof merTempArray != 'undefined' && merTempArray != null && merTempArray != '') {
				doc.text(merTempArray, 90, 766);
			} else {
				doc.text('', 90, 766);
			}

			doc.setFontStyle('normal');
		}

		if (mpc != '' && mpc[0].marketplacecode === "1" && typeof mpc[0].marketplacecode !== 'undefined') {
			doc.setFontStyle('normal');
			doc.setFontSize(11);
			var ebayText = "Please note that all invoice amount paid is converted back to UK currencies as we are a UK based company ";
			doc.text(ebayText, 40, 766);
		}

		var AZDashElementID = document.getElementById(AZDashid);
		if (AZDashElementID === null || AZDashElementID === undefined || AZDashElementID === '') {

		} else {

			AZDashres = doc.autoTableHtmlToJson(document.getElementById(AZDashid));
			var Dashoptions = {
				startY: 767,
				theme: 'plain',
				styles: {
					rowHeight: 15,
					fontSize: 8,
					fontStyle: 'bold'
				}
			};
			doc.autoTable(AZDashres.columns, AZDashres.data, Dashoptions);
		}

		doc.setFontType("bold");
		doc.setFontSize(11);
		var text1 = "If undelivered please return to:";
		doc.text(text1, 40, 790);
		doc.setFontType("normal");
		doc.setFontSize(11);

		var text2 = "Unit 1 - 24 Thames Road, Barking, Essex, IG11 0HZ Tel No: 0208 507 9439";
		doc.text(text2, 200, 790);
		doc.setFontSize(14);
		var text4 = "Please visit www.trimmingshop.co.uk and avail 10% discount by using code TSLL10";
		doc.text(text4, 40, 805);
		// doc.text(text4,40, 820);
		doc.setFontSize(8);

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