function royalmailPackingPDF(data) {

	var doc = new jsPDF('p', 'pt', 'letter');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}

	var today = new Date();
	doc.setFontSize(16);
	doc.setFontType("bold");
	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+'-'+today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
	//toDate = ($filter('date')(toDate, "dd/MM/yyyy"));
	doc.text("Packing List for " + date, 45, 30);
	
	var itemtotalArray = 0;
	var itemtotalArrayAmt = 0;
	$.each(data, function (k, v) {
		var order_temp = v.orderitems;
		if(data[j]['orderitems'].length > 0){
			var order_det = order_temp;
			$.each(order_det, function (kk, vv) {
				itemtotalArray = parseFloat(itemtotalArray) + 1;
				var shipping_total = 0;
				var subtotal = 0;
				if(parseFloat(vv.ShippingPrice) >= 0){
					shipping_total = parseFloat(vv.ShippingPrice);
				}
				if(parseFloat(vv.unitprice) >= 0){
					subtotal = parseFloat(vv.UnitPrice);
				}
				var total = parseFloat(subtotal) + parseFloat(shipping_total);
				itemtotalArrayAmt = parseFloat(itemtotalArrayAmt) + parseFloat(total);
			});
		}
	});

	var FinalArrayTotalString = "Total Summary: " + itemtotalArray + " items on " + data.length + " orders with a total value of " + String.fromCharCode('163') + "" + itemtotalArrayAmt.toFixed(2);

	doc.setFontSize(14);
	doc.setFontType("bold");
	doc.text(FinalArrayTotalString, 45, 55);

	for (var j = 0; j < data.length; j++) {

		var totalPagesExp = data.length;
		var options = {
			margin: {
				top: 80
			}
		};

		var rmlblitemlid = "rmlblitem_ppi";
		var rmlblitemres = '';
		
		/* orders data */
		var multiple_orders = {};
		var shipping_service = 'Standard';
		var multiple_orders_items = '';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td>Item SKU : "+multiple_orders[jm]['Sku']+" | <strong><span>"+multiple_orders[jm]['ProductTitle']+"</span></strong> | QTY : "+multiple_orders[jm]['Quantity']+" | Royal Mail | Inventory [    ] | sent [ ] </td></tr>";
			}
		}
		
		multiple_orders_items += "<tr><td>_______________________________________________________________________________________________________________</td></tr>"; 
		$('#rmlmultiple_orders').html(multiple_orders_items);
		/* orders data end */

		var shippingid = "rmlblShipping_ppi";
		var shippingres = '';
		
		var ship_address = data[j]['shippingaddresses'][0];
		var rmlshipping = "<span>"+ship_address.Name+"</span> | Delivery to <span>"+ship_address.CountryName+"</span>,"+ship_address.PostCode;
		$('#rmlshipping').html(rmlshipping);
		
		var rmlblorderid = "rmlblorder_ppi";
		var rmlblorderres = '';
		
		$('#rmlorderid').text(data[j]['orderid']);
		$('#rmlpurchasedate').text(data[j]['purchasedate']);
		$('#rmlaccountname').text(data[j]['accountname']);
		$('#rml_total').text(data[j]['totalprice']);
		

		var rmlblDasjid = "rmlblsent_ppi";
		var rmlblDasjres = '';

		var newid = "mnew_ppi";
		var newres = '';

		var AZDashid = "rmDash_ppi";
		var AZDashres = '';

		var channelpos = '';
		var companypos = 30;
		var orderpos = '';

		var iscompanyimage = 0;
		var comapnyEndPos = 0;

		var newpos = 30;
		var lblreturn = 0;

		var shippingElementID = document.getElementById(shippingid);
		if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

		} else {
			if (j == 0)
				newpos = 60;
			else
				newpos = doc.autoTableEndPosY() + 5;
			shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
			doc.autoTable(shippingres.columns, shippingres.data, {
				startY: newpos,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 8,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 8,
					rowHeight: 8,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				}
			});
		}

		var orderlblElementID = document.getElementById(rmlblorderid);
		if (orderlblElementID === null || orderlblElementID === undefined || orderlblElementID === '') {

		} else {
			rmlblorderres = doc.autoTableHtmlToJson(document.getElementById(rmlblorderid));
			doc.autoTable(rmlblorderres.columns, rmlblorderres.data, {
				startY: doc.autoTableEndPosY() + 10,
				margin: {
					left: 50
				},
				theme: 'plain',
				pageBreak: 'auto',
				styles: {
					rowHeight: 10,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fontSize: 8,
					rowHeight: 10,
					fontStyle: 'normal'
				}
			});
		}

		var notesize = doc.autoTableEndPosY();
		doc.setFontSize(8);
		doc.setFontType("bold");
		doc.text('Notes:', 55, notesize + 15);
		var rmitemlblElementID = document.getElementById(rmlblitemlid);
		if (rmitemlblElementID === null || rmitemlblElementID === undefined || rmitemlblElementID === '') {

		} else {
			rmlblitemres = doc.autoTableHtmlToJson(document.getElementById(rmlblitemlid));
			doc.autoTable(rmlblitemres.columns, rmlblitemres.data, {
				startY: notesize + 20,
				margin: {
					left: 60
				},
				theme: 'plain',
				pageBreak: 'avoid',
				styles: {
					rowHeight: 12,
					fontSize: 8,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontSize = 8;
					row.cells[0].styles.fontStyle = 'normal';
					row.cells[0].styles.rowHeight = 12;
					row.cells[0].styles.overflow = 'linebreak';
				}

			});
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