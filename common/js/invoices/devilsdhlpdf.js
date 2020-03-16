function devilsDHLPDF(data,itype) {

	var doc = new jsPDF('p', 'pt', [288, 432]);
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
		n = data[j].orderid.indexOf("M-");
		if (parseInt(n) != parseInt(0)) {
			/*mpc = $filter('filter')($scope.tempordDetails, {
				"ordernumber": data[j].orderid
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

		if (itype == 1) {
			//    doc.addImage(X247Invoices.DevPriority, 'JPEG', 320, 30, 235, 85);
			doc.addImage(X247Invoices.DevPriority, 'JPEG', 100, 20, 150, 65);
		} else {
			//doc.addImage(X247Invoices.DevRoyalClass, 'JPEG', 320, 30, 235, 85);
			doc.addImage(X247Invoices.DevRoyalClass, 'JPEG', 100, 30, 150, 55);
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
			newpos = 95;
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
					rowHeight: 18,
					fontSize: 10,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					//fontStyle: 'normal'
					fontStyle: 'bold'
				},
				tableWidth: 280
			});
		}

		doc.setFontSize(10);
		doc.setFontType("normal");
		var lblOrderID = data[j].orderid;

		// doc.text('Order ref:', 40, 320);
		doc.text('Order ref:', 40, 260);
		doc.setFontType("bold");
		// doc.text(lblOrderID, 85, 320);
		doc.text(lblOrderID, 85, 260);

		doc.text('_____________________________________', 40, 395);
		doc.setFontType("bold");
		doc.setFontSize(6);
		var text1 = "If undelivered please return to:";
		doc.text(text1, 40, 410);
		doc.setFontType("normal");
		doc.setFontSize(6);

		var text2 = "";
		if (itype == 1) {
			text2 = "DITD LTD RETURNS, 19 Lime Walk, Headington, Oxford, OX3 7AB, UK";
		} else {
			text2 = "DITD LTD RETURNS, 19 Lime Walk, Headington, Oxford, OX3 7AB, UK";
		}

		doc.text(text2, 40, 420);
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