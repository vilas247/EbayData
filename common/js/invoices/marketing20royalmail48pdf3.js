function marketing20RoyalMail48PDF3(data) {

	var doc = new jsPDF('p', 'px', [317, 359]);
	//  var doc = new jsPDF('p', 'px',[317,359]);
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	
	var courier_label = $('body #courierlabel_select').val();
	var services_label = $('body #serviceslabel_select').val();
	var template_label = $('body #templatelabel_select').val();

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


		var ryShipping = '';
		if (data[j].orderitems.length > 1) {
			if (typeof data[j].orderitems[0].ShippingService == undefined) {
				ryShipping = "standard";
			} else {
				ryShipping = data[j].orderitems[0].ShippingService;
			}
		} else {
			// console.log("standard");
			ryShipping = data[j].orderitems.shippingservice;
			// ryShipping="standard";
		}

		var countryCodechecking = data[j];

		if (typeof countryCodechecking.shippingaddresses[0].CountryCode !== 'undefined') {

			if (ryShipping == "UK_RoyalMailFirstClassStandard" ) {
				doc.addImage(X247Invoices.royalmailfirst, 'JPEG', 10, 10, 300, 50);
			} else {
				if (countryCodechecking.shippingaddresses[0].CountryCode === "GB" || countryCodechecking.shippingaddresses[0].CountryCode === 'UK' || countryCodechecking.shippingaddresses[0].CountryCode === 'United Kingdom') {
					doc.addImage(X247Invoices.royammail48logowpincode, 'JPEG', 10, 10, 300, 50);
				} else {
					doc.addImage(X247Invoices.airmailroyammail48logowpincode, 'JPEG', 10, 10, 300, 50);
				}
			}

		} else {
			if (ryShipping == "UK_RoyalMailFirstClassStandard" ) {
				doc.addImage(X247Invoices.royalmailfirst, 'JPEG', 10, 10, 300, 50);
			} else {
				doc.addImage(X247Invoices.royammail48logowpincode, 'JPEG', 10, 10, 300, 50);
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
			returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
			newpos = 65;
			doc.autoTable(returnres.columns, returnres.data, {
				margin: {
					left: 10
				},
				startY: newpos,
				theme: 'plain',
				styles: {
					fillStyle: 'DF',
					lineColor: [165, 164, 164],
					lineWidth: 0.5,
					overflow: 'linebreak',
					// rowHeight: 110,
					rowHeight: 130,
					fontSize: 8,
					columnWidth: 300
				},
				tableWidth: 300
			});

			boxres = doc.autoTableHtmlToJson(document.getElementById(boxid));
			doc.autoTable(boxres.columns, boxres.data, {
				margin: {
					left: 15
				},
				startY: newpos + 10,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 16,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 16,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				tableWidth: 275
			});
		}

		doc.setFontSize(12);
		doc.setFontType("bold");
		doc.setFontType("bold");
		var ryShipping = '';
		if (data[j].orderitems.length > 0) {
			if (typeof data[j].orderitems[0].ShippingService == undefined) {
				ryShipping = "standard";
			} else {
				ryShipping = data[j].orderitems[0].ShippingService;
			}
		}
		doc.text(ryShipping, 10, 210);

		var childElementID = document.getElementById(childid);
		if (childElementID === null || childElementID === undefined || childElementID === '') {

		} else {
			childres = doc.autoTableHtmlToJson(document.getElementById(childid));
			doc.autoTable(childres.columns, childres.data, {
				margin: {
					left: 18
				},
				// startY: 220,
				// startY: 200,
				startY: 220,
				pageBreak: 'auto',
				theme: 'plain',
				styles: {
					overflow: 'linebreak',
					fontSize: 12,
					fontStyle: 'bold'
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
				}
			});
		}

		var miorder = '';
		miorder = data[j].orderid;

		var mindex = miorder.indexOf("M-");
		if (mindex == 0) {
			doc.setFontType("bold");
			doc.setFontSize(12);
			doc.text("Order No's: ", 10, 285);
			if (typeof merTempArray != 'undefined' && merTempArray != null && merTempArray != '') {
				doc.text(merTempArray, 40, 285);
			} else {
				doc.text('', 40, 285);
			}
			doc.setFontStyle('normal');
		}

		doc.setFontSize(12);
		doc.setFontType("bold");
		var lblOrderID = data[j].orderid;
		doc.text('Order :', 10, 305);
		doc.setFontType("bold");
		doc.text(lblOrderID, 40, 305);

		doc.setFontType("bold");
		doc.setFontSize(12);

		var textdash = "Return Address:-";
		doc.text(textdash, 10, 320);

		doc.setFontStyle('normal');
		doc.setFontSize(14);
		var text3 = "Jammy Deals Ltd Altec House, 27b Aintree Road, ";

		doc.text(text3, 10, 335);
		var text4 = "Perivale,Greenford,Middlesex,UB6 7LA";
		doc.text(text4, 10, 350);
		doc.setFontSize(10);
		doc.setFontStyle('normal');


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