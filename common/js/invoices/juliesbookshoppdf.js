function juliesbookshopPDF(data) {
	var doc = new jsPDF('p', 'pt');
	doc.setLineWidth(0.1);
	if (typeof doc.putTotalPages === 'function') {
		doc.putTotalPages(totalPagesExp);
	}


	for (var j = 0; j < data.length; j++) {
		var totalPagesExp = data.length;
		var options = {
			// afterPageContent: footer,
			margin: {
				top: 80
			}
		};

		var centeredText = function (text, y) {
			var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
			var textOffset = (doc.internal.pageSize.width - (textWidth)) / 2;
			doc.setFont("helvetica");
			doc.setTextColor(0, 0, 0);
			doc.setFontSize(16);
			doc.text(textOffset, y, text);
		};


		var deliveryid = "jbdelivery_ppi";
		var deliveryres = '';

		var saleaddrid = "jbSaleAddress_ppi";
		var saleaddrres = '';

		var almarketid = "jbmarket_ppi";
		var almarketres = '';

		var alorderid = "jborder_ppi";
		var alorderres = '';

		var newid = "jbnew_ppi";
		var newres = '';

		var jbthanksnoteid = "jbthanksnote_ppi";
		var jbthanksnoteres = '';

		var jbstandardinternationalid = "jbstandardinternational_ppi";
		var jbstandardinternationalres = '';

		var channelpos = '';
		var startpos = 30;
		var orderpos = '';

		var sellerElementID = document.getElementById(saleaddrid);
		if (sellerElementID === null || sellerElementID === undefined || sellerElementID === '') {

		} else {
			saleaddrres = doc.autoTableHtmlToJson(document.getElementById(saleaddrid));
			doc.autoTable(saleaddrres.columns, saleaddrres.data, {
				startY: 100,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 12,
					overflow: 'linebreak',
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 12,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				// tableWidth: 275
				tableWidth: 275
			});
		}

		if (data[j].accountname !== 'Amazon - Julies Bookshop USA' && data[j].accountname !== 'Amazon - Tartan Frog USA' && data[j].accountname !== 'Amazon - Hemmingway USA' && data[j].accountname !== 'Amazon - Hemmingway USA' && data[j].accountname !== 'Amazon - MegaBooks US' && data[j].accountname !== 'Amazon - Big Bank Books') {
			var alexmaillogo = X247Invoices.julie1;
			doc.addImage(alexmaillogo, 'JPEG', 425, 60, 120, 60);
		}

		if (data[j].accountname === 'Amazon - Julies Bookshop USA' || data[j].accountname === 'Amazon - Tartan Frog USA' || data[j].accountname === 'Amazon - Hemmingway USA' || data[j].accountname === 'Amazon - Hemmingway USA' || data[j].accountname === 'Amazon - MegaBooks US' || data[j].accountname === 'Amazon - Big Bank Books') {
			var alexmaillogo = X247Invoices.julie2;
			doc.addImage(alexmaillogo, 'JPEG', 425, 60, 120, 40);
		}
		doc.setFontType("bold");
		doc.setFontSize(8);

		var deliverElementID = document.getElementById(deliveryid);
		if (deliverElementID === null || deliverElementID === undefined || deliverElementID === '') {

		} else {
			deliveryres = doc.autoTableHtmlToJson(document.getElementById(deliveryid));
			doc.autoTable(deliveryres.columns, deliveryres.data, {
				margin: {
					left: 315
				},
				startY: 65,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 16,
					fontSize: 10,
					overflow: 'linebreak',
					fontStyle: 'bold'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				// tableWidth: 275
				tableWidth: 110
			});
		}

		// #region ebay UK TARTAN-FROG Address

		if (data[j].accountname === 'eBay - Tartan Frog' || data[j].accountname === 'Amazon - Tartan Frog USA') {

			doc.setFontType("bold");
			doc.setFontSize(7);
			if (data[j].accountname === 'eBay - Tartan Frog') {
				doc.writeText(0, 160, "Sender:TARTAN-FROG", {
					align: 'right',
					width: 540
				});
			} else {
				doc.writeText(0, 160, "Sender:TARTAN-FROG USA", {
					align: 'right',
					width: 540
				});
			}

			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "The Limes Farmhouse,sandhutton", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Thirsk,North Yorkshire,Y07 4RS", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion ebay UK TARTAN-FROG Address

		// #region Amazon UK Hemingway Ventures Ltd Address

		if (data[j].accountname === 'Amazon - Hemmingway UK' || data[j].accountname === 'Amazon - Hemmingway USA' || data[j].accountname === 'eBay - Hemingways') {

			doc.setFontType("bold");
			doc.setFontSize(7);
			doc.writeText(0, 160, "Sender:Hemingway Ventures Ltd.", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "Unit 41a,Number 1 Industrial Estate", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Consett,Co Durham,DH8 6SZ", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion Amazon UK Hemingway Ventures Ltd Address

		// #region Amazon US DURHAM-CITY-BOOKSHOP-ENGLAND Address

		if (data[j].accountname === 'Amazon - MegaBooks US') {
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 160, "Sender:DURHAM-CITY-BOOKSHOP-ENGLAND", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "The Book Factory,PO Box 182", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "hirsk,North Yorkshire,Y07 988", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});

		}

		// #endregion Amazon US DURHAM-CITY-BOOKSHOP-ENGLAND Address

		// #region Amazon US Big Bang Books Address

		if (data[j].accountname === 'Amazon - Big Bank Books' || data[j].accountname === 'Amazon - Big Bank Books UK' || data[j].accountname === 'eBay - Big Bank Books') {

			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 160, "Sender:Big Bang Books", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "45 Rowan Tree Avenue", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Durham,Ciuntry Durham,DH1 1DX", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion Amazon US Big Bang Books Address

		// #region Amazon US AND UK Julies Bookshop Address

		if (data[j].accountname === 'Amazon - Julies Bookshop UK' || data[j].accountname === 'Amazon - Julies Bookshop USA' || data[j].accountname === "eBay - Julie's Bookshop") {

			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 160, "Sender:Julies Bookshop", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "Unit 44, Number 1 Industrial Estate", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Consett,DH8 6TW", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion Amazon US AND UK Julies Bookshop Address


		// #region Amazon UK Mega Books Address

		if (data[j].accountname === 'Amazon - MegaBooks UK' || data[j].accountname === 'eBay - MegaBooks UK') {

			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 160, "Sender:The book factory", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "The Book Factory,PO Box 182", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Thirsk,North Yorkshire,Y07 988", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion Amazon US Big Bang Books Address

		// #region Amazon UK MAGIC-MEDIA Address

		if (data[j].accountname === 'Amazon - Magic Media UK') {

			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 160, "Sender:*** MAGIC-MEDIA ***", {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
			doc.writeText(0, 170, "The Limes Farmhouse,Sandhutton", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 180, "Thirsk,North Yorkshire,Y07 4RS", {
				align: 'right',
				width: 540
			});
			doc.writeText(0, 190, "UNITED KINGDOM", {
				align: 'right',
				width: 540
			});
			doc.setFontType("bold");
			doc.setFontSize(6);
			doc.writeText(0, 200, data[j].orderid, {
				align: 'right',
				width: 540
			});
			doc.setFontType("normal");
			doc.setFontSize(6);
		}

		// #endregion Amazon US MAGIC-MEDIA Address

		if (data[j].accountname === 'Amazon - Julies Bookshop USA' || data[j].accountname === 'Amazon - Tartan Frog USA' || data[j].accountname === 'Amazon - Hemmingway USA' || data[j].accountname === 'Amazon - Hemmingway USA' || data[j].accountname === 'Amazon - MegaBooks US' || data[j].accountname === 'Amazon - Big Bank Books') {

			var jbstandardinternationalElementID = document.getElementById(jbstandardinternationalid);
			if (jbstandardinternationalElementID === null || jbstandardinternationalElementID === undefined || jbstandardinternationalElementID === '') {

			} else {
				jbstandardinternationalres = doc.autoTableHtmlToJson(document.getElementById(jbstandardinternationalid));
				var jbstandardinternationalresoptions = {
					startY: 230,
					pageBreak: 'avoid',
					theme: 'plain',
					styles: {
						rowHeight: 18,
						fontSize: 12,
						fontStyle: 'normal'
					}
				};
				doc.autoTable(jbstandardinternationalres.columns, jbstandardinternationalres.data, jbstandardinternationalresoptions);
			}
		}


		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("-----------------------------------------------------------------------------------------------------------------------------------------------------", 45, 250);


		var almarketElementID = document.getElementById(almarketid);
		if (almarketElementID === null || almarketElementID === undefined || almarketElementID === '') {

		} else {
			almarketres = doc.autoTableHtmlToJson(document.getElementById(almarketid));
			var almarketresoptions = {
				startY: 260,
				pageBreak: 'avoid',
				theme: 'plain',
				styles: {
					rowHeight: 18,
					fontSize: 12,
					fontStyle: 'normal'
				},
				tableWidth: 400,
				drawHeaderRow: function (row, data) {
					row.cells[0].styles.fontStyle = 'bold';
				},
				createdCell: function (cell, data) {
					if (data.column.dataKey == 0) {
						cell.styles.fontStyle = 'bold';
					}
				}
			};
			doc.autoTable(almarketres.columns, almarketres.data, almarketresoptions);
		}

		doc.setFontType("bold");
		doc.setFontSize(10);
		doc.text("-----------------------------------------------------------------------------------------------------------------------------------------------------", 45, doc.autoTableEndPosY() + 20);


		doc.setFontType("bold");
		doc.setFontSize(12);
		doc.text("Items:", 45, doc.autoTableEndPosY() + 40);
		var alorderElementID = document.getElementById(alorderid);
		if (alorderElementID === null || alorderElementID === undefined || alorderElementID === '') {

		} else {
			alorderres = doc.autoTableHtmlToJson(document.getElementById(alorderid));
			doc.autoTable(alorderres.columns, alorderres.data, {
				startY: doc.autoTableEndPosY() + 60,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal'
				},
				headerStyles: {
					fillColor: [255, 255, 255],
					fontSize: 10,
					textColor: [0, 0, 0],
					fontStyle: 'bold'
				},
				bodyStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				}

			});
		}


		doc.setFontType("bold");
		doc.setFontSize(12);
		doc.text("Notes:", 45, doc.autoTableEndPosY() + 15);
		centeredText('Thanks for your order!', doc.autoTableEndPosY() + 30);

		var jbthanksnoteElementID = document.getElementById(jbthanksnoteid);
		if (jbthanksnoteElementID === null || jbthanksnoteElementID === undefined || jbthanksnoteElementID === '') {

		} else {
			jbthanksnoteres = doc.autoTableHtmlToJson(document.getElementById(jbthanksnoteid));
			doc.autoTable(jbthanksnoteres.columns, jbthanksnoteres.data, {
				startY: doc.autoTableEndPosY() + 45,
				pageBreak: 'auto',
				theme: 'plain',
				// afterPageContent: footer,
				styles: {
					overflow: 'linebreak',
					fontSize: 10,
					fontStyle: 'normal'
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