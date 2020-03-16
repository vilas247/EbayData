/* Momogram PPI */
function monogrampdf(data,templateID) {
	
	var doc = new jsPDF('p', 'pt');
    doc.setLineWidth(0.1);
    if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}
	
	for (var j = 0; j < data.length; j++) {
        var totalPagesExp = data.length;
        var options = {

          margin: {
            top: 80
          }
        };

        var companyid = "mcompanylogo_ppi";
        var companyres = '';

        var deliveryid = "mdelivery_ppi";
        var deliveryres = '';

        var channelid = "mchannel_ppi";
        var channelres = '';

        var shippingid = "mbasic_ppi";
        var shippingres = '';

        var childid = "morder_ppi";
        var childres = '';

        var totpriceid = "mtotalprice_ppi";
        var totpriceres = '';

        var returnid = "mreturnaddress_ppi";
        var returnres = '';

        var shippingserviceid = "mshippingservice_ppi";
        var shippingserviceres = '';

        var boxid = "mboxreturnaddress_ppi";
        var boxres = '';

        var newid = "mnew_ppi";
        var newres = '';

        var channelpos = '';
		
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
			
			$('#shipname_ppi1').text(ship_address.Name);
			$('#shipaddress1ppi1').text(ship_address.Address1);
			$('#shipaddress2ppi1').text(ship_address.Address2);
			$('#shipcity_ppi1').text(ship_address.City);
			$('#shipstateorregion_ppi1').text(ship_address.StateOrRegion);
			$('#shippostcode_ppi1').text(ship_address.PostCode);
			$('#shipcountryname_ppi1').text(ship_address.CountryName);
			$('#shipphone_ppi1').text(ship_address.Phone);
			$('#shipemail_ppi1').text(ship_address.Email);
		/* Ship address end */
		
		/* orders data */
		var multiple_orders = {};
		var multiple_orders_items = '';
		var shipping_service = 'Standard';
		
		if(data[j]['orderitems'].length > 0){
			multiple_orders = data[j]['orderitems'];
			for (var jm = 0; jm < multiple_orders.length; jm++) {
				shipping_service = multiple_orders[jm]['ShippingService'];
				multiple_orders_items += "<tr><td><span>"+multiple_orders[jm]['Sku']+"</span></td><td>"+multiple_orders[jm]['ProductTitle']+"</td><td>"+multiple_orders[jm]['Quantity']+"</td><td>"+multiple_orders[jm]['UnitPrice']+"</td><td>"+multiple_orders[jm]['TotalPrice']+"</td></tr>";
			}
		}
		
		$('#multipleorders_ppi').html(multiple_orders_items);
		/* orders data end */
		
		/* channel data */
		$('#saleschannel_ppi').text(data[j]['saleschannel']);
		$('#orderid_ppi').text(data[j]['orderid']);
		$('#purchasedate_ppi').text(data[j]['purchasedate']);
		/* channel data end */
		
		$('#subtotal_ppi').text(X247Invoices.subtotal(j,data[j].orderitems));
		$('#grandtotal_ppi').text(X247Invoices.FredrickTotalPriceAmt(j,data[j].orderitems,data[j]));

        //  var companypos = doc.autoTableEndPosY() + 30;
        var companypos = 30;
        var orderpos = '';
        doc.addImage(X247Invoices.imgCompanyLogo, 'JPEG', 40, companypos, 201, 73);
        var deliveryElementID = document.getElementById(deliveryid);
        if (deliveryElementID === null || deliveryElementID === undefined || deliveryElementID === '') {

        } else {
          deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
          doc.autoTable(deliveryres.columns, deliveryres.data, {
            //  margin: { left: 403 },
            margin: {
              left: 380
            },
            startY: companypos,
            pageBreak: 'avoid',
            theme: 'plain',
            styles: {
              overflow: 'linebreak',
              rowHeight: 15,
              fontSize: 8
            },
            createdCell: function (cell, data) {
              if (data.column.dataKey == 3) {
                cell.styles.halign = 'right';
              }
            }
          });
        }

        var shippingElementID = document.getElementById(shippingid);
        if (shippingElementID === null || shippingElementID === undefined || shippingElementID === '') {

        } else {
          shippingres = doc.autoTableHtmlToJson(document.getElementById(shippingid));
          orderpos = doc.autoTableEndPosY() + 30;
          var shippingoptions = {
            startY: doc.autoTableEndPosY() - 15,
            pageBreak: 'avoid',
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
          doc.autoTable(childres.columns, childres.data,
            {
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
            startY: shipservicepos + 1,//doc.autoTableEndPosY() + 1,
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

        //doc.setFontSize(8);
        //doc.setFontType("bold");
        //doc.text('FOR RETURNS NOTE INFORMATION PLEASE REFER TO WEBSITE', 40, 594);

        var channelElementID = document.getElementById(channelid);
        if (channelElementID === null || channelElementID === undefined || channelElementID === '') {

        } else {
          channelres = doc.autoTableHtmlToJson(document.getElementById(channelid));
          doc.autoTable(channelres.columns, channelres.data, {
            margin: {
              left: 340
            },
            startY: orderpos,
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


        var returnElementID = document.getElementById(returnid);
        if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

        } else {
          returnres = doc.autoTableHtmlToJson(document.getElementById(returnid));
          // newpos = doc.autoTableEndPosY() + 40;
          newpos = 600;
          lblreturn = newpos - 6;
		  var DynamicPGSize = 530;

          if (returnyPosition >= DynamicPGSize) {
            // if (returnyPosition >= 550) {
            doc.addPage();
          }

          doc.setFontSize(8);
          doc.setFontType("bold");
          doc.text('FOR RETURNS NOTE INFORMATION PLEASE REFER TO WEBSITE', 40, lblreturn);
          doc.autoTable(returnres.columns, returnres.data, {
            // startY: doc.autoTableEndPosY() + 40,
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
            }, headerStyles: {
              fillColor: [255, 255, 255],
              fontSize: 8,
              textColor: [0, 0, 0],
              fontStyle: 'normal'
            },
            tableWidth: 182

          });

          doc.setFontType("normal");
          doc.setFontSize(8);
          doc.text('If undelivered please return to: The Monogram Group Ltd,Greatworth Park', 50, newpos + 178);
          doc.text('Greatworth,Banbury OX17 2HB,United Kingdom', 50, newpos + 189);

          if (templateID == 1) {
            doc.addImage(X247Invoices.imgMailLogo1, 'JPEG', 250, newpos + 6, 301, 57);

            doc.setFontType("bold");
            doc.setFontSize(8);
            doc.text('POSTAGE PAID GB', 468, newpos + 50);
            //   doc.text('HQ35849', 468, newpos + 60);
            doc.text('HQ35349', 468, newpos + 60);

          }
          if (templateID == 2) {
            doc.addImage(X247Invoices.imgMailLogo2, 'JPEG', 250, newpos + 6, 304, 58);

            doc.setFontType("bold");
            doc.setFontSize(8);
            doc.text('POSTAGE PAID GB', 472, newpos + 51);
            // doc.text('HQ35849', 472, newpos + 61);
            doc.text('HQ35349', 472, newpos + 61);
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