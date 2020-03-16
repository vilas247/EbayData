(function(root, factory) {
	if(typeof define === 'function' && define.amd) {
		define(['jquery'], function($) {
			root.X247Invoices = factory(root, $);
		})
	}
	else {
		root.X247Invoices = factory(root, root,$);
	}
}(this, function(root, $) {
	root.X247Invoices = {};
	var $ = jQuery;
	
	X247Invoices['pdf_image_dir'] = app_base_url+"common/image_files";
	X247Invoices['DynamicPGSize'] = 530;
	X247Invoices['trimmingcarrierservices'] = [
      {
        "carrier": "dhl express",
        "service_code": "dom",
        "product_desc": "domestic express",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "dhl express",
        "service_code": "esi",
        "product_desc": "economy select (dutiable)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "dhl express",
        "service_code": "esu",
        "product_desc": "economy select",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "dhl express",
        "service_code": "ecx",
        "product_desc": "express worldwide (eu)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "dhl express",
        "service_code": "wpx",
        "product_desc": "express worldwide (dutiable)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "dhl express",
        "service_code": "dox",
        "product_desc": "express worldwide (non eu)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "nday",
        "product_desc": "next day",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "2day",
        "product_desc": "2 day service",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "3day",
        "product_desc": "3 day service",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "2DAYI",
        "product_desc": "TWO DAY IOD",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "2DAYP",
        "product_desc": "TWO DAY POD",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "hermes",
        "service_code": "2DAYS",
        "product_desc": "TWO DAY SIG",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmns",
        "product_desc": "tracked next day (signature)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmnn",
        "product_desc": "tracked next day (non signature)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rm2l",
        "product_desc": "tracked standard (non signature)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rm2h",
        "product_desc": "tracked (non signature)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "RML2",
        "product_desc": "ROYAL MAIL 48 (CRL) (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "RML1",
        "product_desc": "ROYAL MAIL 24 (CRL) (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmp1",
        "product_desc": "packet post daily first",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmp2",
        "product_desc": "packet post daily second",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmls",
        "product_desc": "tracked standard (signature)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "rmhs",
        "product_desc": "tracked (signature)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "IG1",
        "product_desc": "International Bus. Mail Large Letter Zone Sort Priority",
        "pallet": "parcel",
        "status": "active"
      }
      , {
        "carrier": "royal mail",
        "service_code": "IE1",
        "product_desc": "International Packets Sort Priority",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "RMP1",
        "product_desc": "Royal Mail 24 (CRL) (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "RMP2",
        "product_desc": "Royal Mail 48 (CRL) (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "CLL1",
        "product_desc": "ROYAL MAIL 24 (CRL) (LARGE LETTER) - SIGNED",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "CLL2",
        "product_desc": "ROYAL MAIL 48 (CRL) (LARGE LETTER) - SIGNED",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "CRL2",
        "product_desc": "ROYAL MAIL 48 (CRL) (PARCEL) - SIGNED",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "CRL1",
        "product_desc": "ROYAL MAIL 24 (CRL) (PARCEL) - SIGNED",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL1",
        "product_desc": "Standard Letter First Class (Large Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL2",
        "product_desc": "Standard Letter Second Class (Large Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL3",
        "product_desc": "Standard Letter 1st Class Signed For (Large Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL4",
        "product_desc": "Standard Letter 2nd Class Signed For (Large Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL5",
        "product_desc": "Standard Letter First Class (Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL6",
        "product_desc": "Standard Letter Second Class (Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL7",
        "product_desc": "Standard Letter 1st Class Signed For (Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL8",
        "product_desc": "Standard Letter 2nd Class Signed For (Letter)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STL9",
        "product_desc": "Standard Letter First Class (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STLA",
        "product_desc": "Standard Letter Second Class (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STLB",
        "product_desc": "Standard Letter 1st Class Signed For (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "STLC",
        "product_desc": "Standard Letter 2nd Class Signed For (Parcel)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "SD1",
        "product_desc": "Special Delivery 1pm õ00",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "SD1S",
        "product_desc": "Special Delivery 1pm õ00 Saturday",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "RMNS",
        "product_desc": "Tracked 24 Signature",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "TPNN",
        "product_desc": "Tracked 24 Non-Signature",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL1",
        "product_desc": "STANDARD LABEL 1ST CLASS (LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL2",
        "product_desc": "STANDARD LABEL 2ND CLASS (LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL3",
        "product_desc": "STANDARD LABEL 1ST CLASS SIGNED FOR (LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL4",
        "product_desc": "STANDARD LABEL 2ND CLASS SIGNED FOR (LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL5",
        "product_desc": "STANDARD LABEL 1ST CLASS (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL6",
        "product_desc": "STANDARD LABEL 2ND CLASS (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL7",
        "product_desc": "STANDARD LABEL 1ST CLASS SIGNED FOR (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPL8",
        "product_desc": "STANDARD LABEL 2ND CLASS SIGNED FOR (LARGE LETTER)",
        "pallet": "parcel",
        "status": "active"
      }, {
        "carrier": "royal mail",
        "service_code": "BPL9",
        "product_desc": "STANDARD LABEL 1ST CLASS (PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLA",
        "product_desc": "STANDARD LABEL 2ND CLASS (PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLB",
        "product_desc": "STANDARD LABEL 1ST CLASS SIGNED FOR (PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLD",
        "product_desc": "STANDARD LABEL 1ST CLASS (SMALL PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLC",
        "product_desc": "STANDARD LABEL 2ND CLASS SIGNED FOR (PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLE",
        "product_desc": "STANDARD LABEL 2ND CLASS (SMALL PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLF",
        "product_desc": "STANDARD LABEL 1ST CLASS SIGNED FOR (SMALL PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "royal mail",
        "service_code": "BPLG",
        "product_desc": "STANDARD LABEL 2ND CLASS SIGNED FOR (SMALL PARCEL)",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "12",
        "product_desc": "Next Day Parcel",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "32",
        "product_desc": "Next Day <5kg Express pack",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "19",
        "product_desc": "European Road Parcel",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "50",
        "product_desc": "Air Express Parcel",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "60",
        "product_desc": "Air Classic Parcel",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "11",
        "product_desc": "Two Day Delivery",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "13",
        "product_desc": "Next Day by Noon",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "14",
        "product_desc": "Next Day by 10:30am",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "16",
        "product_desc": "Saturday Delivery",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "17",
        "product_desc": "Saturday by Noon",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "18",
        "product_desc": "Saturday by 10:30am",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "01",
        "product_desc": "Sunday Delivery",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "29",
        "product_desc": "Sunday by Noon",
        "pallet": "parcel",
        "status": "active"
      },
      {
        "carrier": "DPD",
        "service_code": "07",
        "product_desc": "Sunday by 10:30am",
        "pallet": "parcel",
        "status": "active"
      }
    ];
	X247Invoices['PostPackagesServices'] = [{
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Large Letter'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Letter'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Packet'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Tracked (24 hour)'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Large Letter - SF'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Letter - SF'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Std 2nd Class - Packet - SF'
    }, {
      "carrier": 'Royal Mail',
      "service": 'Tracked (24 hour) - SF'
    }, {
      "carrier": 'Hermes / GFS',
      "service": 'Hermes 2Day'
    }, {
      "carrier": 'Hermes / GFS',
      "service": 'Hermes Next Day'
    }, {
      "carrier": 'Hermes / GFS',
      "service": 'Hermes 2Day - SF'
    }, {
      "carrier": 'Hermes / GFS',
      "service": 'Hermes Next Day - SF'
    }];
	X247Invoices['CourierServiceLabels'] = [
	  {
		  "ServiceCode": 6,
		  "ServiceName": "ROYAL MAIL 1C - First class",
		  "Service": "F1C",
		  "ServiceClass": "RM1",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 175,
		  "ServiceName": "ROYAL MAIL 2C - Second class",
		  "Service": "S2C",
		  "ServiceClass": "RM2",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 177,
		  "ServiceName": "ROYAL MAIL Recorded 24",
		  "Service": "F1C",
		  "ServiceClass": "RM1",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 178,
		  "ServiceName": "ROYAL MAIL Recorded 48",
		  "Service": "S2C",
		  "ServiceClass": "RM2",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 7,
		  "ServiceName": "ROYAL MAIL SIGNED FOR 24",
		  "Service": "S24",
		  "ServiceClass": "RM1",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 8,
		  "ServiceName": "ROYAL MAIL Standard 24",
		  "Service": "S24",
		  "ServiceClass": "RM1",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 223,
		  "ServiceName": "Royal Mail Tracked 24 (No Signature)",
		  "Service": "T24",
		  "ServiceClass": "RMT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 224,
		  "ServiceName": "Royal Mail Tracked 48 (No Signature)",
		  "Service": "T48",
		  "ServiceClass": "RMT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 75,
		  "ServiceName": "ROYAL MAIL TRACKED Signed 24",
		  "Service": "T24",
		  "ServiceClass": "RMT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 76,
		  "ServiceName": "ROYAL MAIL TRACKED Signed 48",
		  "Service": "T48",
		  "ServiceClass": "RMT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 57,
		  "ServiceName": "Special Delivery GUARANTEED BY 1PM",
		  "Service": "SD1",
		  "ServiceClass": "SD1",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 179,
		  "ServiceName": "Special Delivery GUARANTEED BY 9AM",
		  "Service": "SD4",
		  "ServiceClass": "SD1",
		  "Signature": "Y"
	  },
	  {
		  "Service Code": 26,
		  "Service Name": "INTERNATIONAL STANDARD ON ACCOUNT",
		  "Service": "OLA",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 27,
		  "ServiceName": "INTERNATIONAL ECONOMY ON ACCOUNT",
		  "Service": "OLS",
		  "Service": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 28,
		  "ServiceName": "INTERNATIONAL SIGNED ON ACCOUNT",
		  "Service": "OSA",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 29,
		  "ServiceName": "INTL SIGNED ON ACCOUNT EXTRA COMP",
		  "Service": "OSB",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 30,
		  "ServiceName": "INTERNATIONAL TRACKED ON ACCOUNT",
		  "Service": "OTA",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 31,
		  "ServiceName": "INTL TRACKED ON ACCOUNT EXTRA COMP",
		  "Service": "OTB",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 32,
		  "ServiceName": "INTERNATIONAL TRACKED &amp; SIGNED ON ACCT",
		  "Service": "OTC",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 33,
		  "ServiceName": "INTL TRACKED &amp; SIGNED ON ACCT EXTRA COMP",
		  "Service": "OTD",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 225,
		  "ServiceName": "INTL BUS MAIL LRG LTR MAX SORT PRIORITY",
		  "Service": "PS7",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 226,
		  "ServiceName": "INTL BUS MAIL LRG LTR ZONE SORT PRI",
		  "Service": "IG1",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 227,
		  "ServiceName": "INTL BUS MAIL SIGNED",
		  "Service": "MTM",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 228,
		  "ServiceName": "INTL BUS MAIL TRACKED",
		  "Service": "MTI",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 229,
		  "ServiceName": "INTL BUS MAIL TRACKED &amp; SIGNED",
		  "Service": "MTC",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 230,
		  "ServiceName": "INTL BUS PARCELS MAX SORT PRIORITY",
		  "Service": "PS9",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 231,
		  "ServiceName": "INTL BUS PARCELS TRACKED &amp; SIGNED",
		  "Service": "MTA",
		  "ServiceClass": "INT",
		  "Signature": "Y"
	  },
	  {
		  "ServiceCode": 232,
		  "ServiceName": "INTL BUS PARCELS ZONE SORT PRIORITY",
		  "Service": "IE1",
		  "ServiceClass": "INT",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 248,
		  "ServiceName": "Royal Mail 24 / 1st Class + ROYAL MAIL 24/48 ",
		  "Service": "RM1",
		  "ServiceClass": "RM24R",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 249,
		  "ServiceName": "Royal Mail 48 / 2nd Class + ROYAL MAIL 24/48",
		  "Service": "RM2",
		  "ServiceClass": "RM48R",
		  "Signature": "N"
	  },
	  {
		  "ServiceCode": 250,
		  "ServiceName": "INTERNATIONAL TRACKED & SIGNED ON ACCT",
		  "Service": "INT",
		  "ServiceClass": "1INTDAILY",
		  "Signature": "Y"
	  }

		];
	if (dbcode == 50) {
		
		X247Invoices.CourierServiceLabels.push({
				"ServiceCode": 176,
				"ServiceName": "ROYAL MAIL SIGNED FOR 48",
				"Service": "CRL48",
				"ServiceClass": "RM2",
				"Signature": "Y"
			},
			{
				"ServiceCode": 9,
				"ServiceName": "ROYAL MAIL Standard 48",
				"Service": "CRL48",
				"ServiceClass": "RM2",
				"Signature": "N"
			});
	} else {
			X247Invoices.CourierServiceLabels.push({
				"ServiceCode": 176,
				"ServiceName": "ROYAL MAIL SIGNED FOR 48",
				"Service": "S48",
				"ServiceClass": "RM2",
				"Signature": "Y"
			},
			{
				"ServiceCode": 9,
				"ServiceName": "ROYAL MAIL Standard 48",
				"Service": "S48",
				"ServiceClass": "RM2",
				"Signature": "N"
			});
	}
	X247Invoices['ddlCourierServices'] = [{
			"id": 1,
			"name": "Invoice without PPI",
			"cvalue": "1"
		}, {
			"id": 2,
			"name": "Invoice with PPI",
			"cvalue": "2"
		}, {
			"id": 3,
			"name": "Amazon Invoice Layout",
			"cvalue": "3"
		}, {
			"id": 4,
			"name": "eBay Invoice Layout",
			"cvalue": "4"
		}, {
			"id": 5,
			"name": "Invoice without PPI with VAT",
			"cvalue": "5"
		}, {
			"id": 6,
			"name": "Trimming Shop 007 Ltd / HQ71198",
			"cvalue": "HQ71198"
		}, {
			"id": 7,
			"name": "Wedding Suppliers London Ltd / HQ60963",
			"cvalue": "HQ60963"
		}, {
			"id": 8,
			"name": "Trimming Shop Group Ltd / HQ80936",
			"cvalue": "HQ80936"
		}];

	X247Invoices['filterorders'] = {
			searchDropdown: 'orderid',
			searchText: '',
			pageNumber: 1,
			pageCount: 100
		};

	X247Invoices['filterformData'] = {
			"startDate": '',
			"endDate": ''
		}

	X247Invoices['royalmailselection'] = {
			"rClass": 1,
			"rPostalcode": '',
			'ddlroyalAddress': '0'
		};

	X247Invoices['royalAddress'] = [{ "id": 1, "value": "Unit NO -29,Unimix House, Abbey Road, Park Royal,NW10 7TR, London , UK" }, { "id": 2, "value": "Unit NO -25,Unimix House, Abbey Road, Park Royal,NW10 7TR, London , UK" }, { "id": 3, "value": "51 Church Road, Hounslow ,London  , TW5 0LU" }];

	X247Invoices['api_couriers'] = {};
	X247Invoices['api_services'] = {};
	X247Invoices['imgbase64companylogo'] = '';
	X247Invoices['imgbaseHeight'] = '';
	X247Invoices['imgbasewidth'] = '';
	X247Invoices.toDataUrl = function(url) {
		X247Invoices['img'] = new Image();
		X247Invoices.img.crossOrigin = 'Anonymous';
		X247Invoices.img.onload = function () {
			var canvas = document.createElement('CANVAS');
			var ctx = canvas.getContext('2d');
			var dataURL;
			canvas.height = this.height;
			canvas.width = this.width;
			ctx.drawImage(this, 0, 0);
			dataURL = canvas.toDataURL("image/jpeg");
			X247Invoices.imgbase64companylogo = dataURL;
			X247Invoices.imgbaseHeight = this.height;
			X247Invoices.imgbasewidth = this.width;
			canvas = null;
		};
		X247Invoices.img.src = url;
	}
	
	X247Invoices.toDataUrl(app_base_url+"common/images/general/login-logo.jpg");

	X247Invoices['testempty'] = "\n\n";
	X247Invoices['testempty1'] = "\n";



	X247Invoices['royalmailInvoiceLogo'] = '';
	X247Invoices['royalmailDeliverLogo'] = '';
	X247Invoices['royalmailDeliverLogo1'] = '';
	X247Invoices['royalmail1smail'] = '';
	X247Invoices['royalAirmail'] = '';
	

	if (dbcode == 41) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.royalmailInvoiceLogo = pdfJsonFile.royalmailInvoiceLogo;
			X247Invoices.royalmailDeliverLogo = pdfJsonFile.royalmailDeliverLogo;
			X247Invoices.royalmailDeliverLogo1 = pdfJsonFile.royalmailDeliverLogo1;
			X247Invoices.royalmail1smail = pdfJsonFile.royalmail1smail;
			X247Invoices.royalAirmail = pdfJsonFile.royalAirmail;
		});
	}
	
	X247Invoices['imgCompanyLogo'] = '';
	X247Invoices['imgMailLogo1'] = '';
	X247Invoices['imgMailLogo2'] = '';
	

	if (dbcode == 30) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.imgCompanyLogo = pdfJsonFile.imgCompanyLogo;
			X247Invoices.imgMailLogo1 = pdfJsonFile.imgMailLogo1;
			X247Invoices.imgMailLogo2 = pdfJsonFile.imgMailLogo2;
		});
	}
		

	X247Invoices.AddressTotalPriceAmt = function(index, subPriceArr, totPrice) {
		var subtotal = 0;
		var a1 = subPriceArr.ItemArray.length;
		
		if (a1 == undefined) {
			subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ItemArray.ShippingPrice);
		} else {
			$.each(subPriceArr.ItemArray, function (key, value) {
				subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
			});
		}
		
		var subTotalPrice = 0;
		
		if (a1 == undefined) {
			subTotalPrice = parseFloat(subTotalPrice) + parseFloat(parseFloat(subPriceArr.ItemArray.UnitPrice) * parseFloat(subPriceArr.ItemArray.Quantity));
		} else {
			$.each(subPriceArr.ItemArray, function (key, value) {
				subTotalPrice = parseFloat(subTotalPrice) + parseFloat(parseFloat(value.UnitPrice) * parseFloat(value.Quantity));
			});
		}
		
		var FTP = 0;
		FTP = parseFloat(subTotalPrice) + parseFloat(subtotal);
		return FTP;
	}


	X247Invoices['royammail48logowpincode'] = "";
	X247Invoices['royalmailfirst'] = "";
	X247Invoices['airmailroyammail48logowpincode'] = "";

	if (dbcode == 44) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.royammail48logowpincode = pdfJsonFile.royammail48logowpincode;
			X247Invoices.royalmailfirst = pdfJsonFile.royalmailfirst;
			X247Invoices.airmailroyammail48logowpincode = pdfJsonFile.airmailroyammail48logowpincode;
		});
	}

	X247Invoices['csImage'] = "";
	if (dbcode == 46) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.csImage = pdfJsonFile.csImage;
		});
	}

	X247Invoices['secretLogo1'] = "";
	X247Invoices['secretLogo2'] = "";
	X247Invoices['secretLogo3'] = "";
	X247Invoices['secretLogo4'] = "";
	X247Invoices['secretLogo5'] = "";

	if (dbcode == 29) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.secretLogo1 = pdfJsonFile.secretLogo1;
			X247Invoices.secretLogo2 = pdfJsonFile.secretLogo2;
			X247Invoices.secretLogo3 = pdfJsonFile.secretLogo3;
			X247Invoices.secretLogo4 = pdfJsonFile.secretLogo4;
			X247Invoices.secretLogo5 = pdfJsonFile.secretLogo5;
		});
	}

	X247Invoices['imgMichelRYLogo48'] = "";
	X247Invoices['imgMichelRYLogo24'] = "";

	if (dbcode == 17) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.imgMichelRYLogo48 = pdfJsonFile.imgMichelRYLogo48;
			X247Invoices.imgMichelRYLogo24 = pdfJsonFile.imgMichelRYLogo24;
		});
	}


	X247Invoices['alexmaillogo'] = "";

	if (dbcode == 59) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.alexmaillogo = pdfJsonFile.alexmaillogo;
		});
	};


	X247Invoices['julie1'] = "";
	X247Invoices['julie2'] = "";

	if (dbcode == 61) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_' +dbcode+ '.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.julie1 = pdfJsonFile.julie1;
			X247Invoices.julie2 = pdfJsonFile.julie2;
		});
	};


	X247Invoices['DevPriority'] = "";
	X247Invoices['DevRoyalClass'] = "";

	if (dbcode == 50) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.DevPriority = pdfJsonFile.DevPriority;
			X247Invoices.DevRoyalClass = pdfJsonFile.DevRoyalClass;
		});
	}



	X247Invoices['startpageLogo'] = '';
	X247Invoices['returnLogo24'] = '';
	X247Invoices['returnLogo48'] = '';

	if (dbcode == 57) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.startpageLogo = pdfJsonFile.companylogo;
			X247Invoices.returnLogo24 = pdfJsonFile.returnLogo24;
			X247Invoices.returnLogo48 = pdfJsonFile.returnLogo48;

		});
	};
	X247Invoices['FDXRoyalLogo'] = '';

	if (dbcode == 45) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.FDXRoyalLogo = pdfJsonFile.FDXRoyalLogo;
		});
	}
	X247Invoices['EESCompanyLogo'] = '';
	X247Invoices['EESRoyalMail1'] = '';
	X247Invoices['EESBottomImage'] = '';
	X247Invoices['EESRoyalMail2'] = '';

	if (dbcode == 51) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.EESCompanyLogo = pdfJsonFile.EESCompanyLogo;
			X247Invoices.EESRoyalMail1 = pdfJsonFile.EESRoyalMail1;
			X247Invoices.EESBottomImage = pdfJsonFile.EESBottomImage;
			X247Invoices.EESRoyalMail2 = pdfJsonFile.EESRoyalMail2;
		});
	}
	X247Invoices['beautynestlogo'] = '';
	X247Invoices['beautynestry2ndclass'] = '';
	X247Invoices['beautyRMail1stclass'] = '';
	X247Invoices['beauty1stclasssignature'] = '';
	X247Invoices['beautyRM2ndclasssignature'] = '';

	if (dbcode == 43) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.beautynestlogo = pdfJsonFile.beautynestlogo;
			X247Invoices.beautynestry2ndclass = pdfJsonFile.beautynestry2ndclass;
			X247Invoices.beautyRMail1stclass = pdfJsonFile.beautyRMail1stclass;
			X247Invoices.beauty1stclasssignature = pdfJsonFile.beauty1stclasssignature;
			X247Invoices.beautyRM2ndclasssignature = pdfJsonFile.beautyRM2ndclasssignature;
		});
	}
	X247Invoices['HCRy48'] = '';
	X247Invoices['HCRy24'] = '';
	X247Invoices['HCRLogo'] = '';
	X247Invoices['HCRDisc'] = '';

	if (dbcode == 68) { 
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.HCRLogo = pdfJsonFile.HCRLogo;
			X247Invoices.HCRy48 = pdfJsonFile.HCRy48;
			X247Invoices.HCRy24 = pdfJsonFile.HCRy24;
			X247Invoices.HCRDisc = pdfJsonFile.HCRDisc;

		});
	}
	X247Invoices['KMOLogo'] = '';
	X247Invoices['KMOFCNUK'] = '';
	X247Invoices['KMOFUKOnly'] = '';
	X247Invoices['KMOSUKOnly'] = '';
	X247Invoices['PKLogo'] = '';
	X247Invoices['PKSupplier'] = '';
	X247Invoices['ebayMilLogo'] = '';
	X247Invoices['vistusmil'] = '';
	X247Invoices['tactical'] = '';
	X247Invoices['workwearlogo'] = '';
	X247Invoices['vistusworkwear'] = '';
	X247Invoices['workweartactical'] = '';
	X247Invoices['greybar'] = '';
	X247Invoices['blackbar'] = '';
	X247Invoices['orangebar'] = '';
	X247Invoices['greygridbar'] = '';
	X247Invoices['blackgridbar'] = '';
	X247Invoices['orangegridbar'] = '';


	if (dbcode == 74) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.KMOLogo = pdfJsonFile.KMOLogo;
			X247Invoices.KMOFCNUK = pdfJsonFile.KMOFCNUK;
			X247Invoices.KMOFUKOnly = pdfJsonFile.KMOFUKOnly;
			X247Invoices.KMOSUKOnly = pdfJsonFile.KMOSUKOnly;
			X247Invoices.PKLogo = pdfJsonFile.PKLogo;
			X247Invoices.PKSupplier = pdfJsonFile.PKSupplier;
			X247Invoices.ebayMilLogo = pdfJsonFile.ebayMilLogo;
			X247Invoices.vistusmil = pdfJsonFile.vistusmil;
			X247Invoices.tactical = pdfJsonFile.tactical;
			X247Invoices.workwearlogo = pdfJsonFile.workwearlogo;
			X247Invoices.vistusworkwear = pdfJsonFile.vistusworkwear;
			X247Invoices.workweartactical = pdfJsonFile.workweartactical;
			X247Invoices.greybar = pdfJsonFile.greybar;
			X247Invoices.blackbar = pdfJsonFile.blackbar;
			X247Invoices.orangebar = pdfJsonFile.orangebar;
			X247Invoices.greygridbar = pdfJsonFile.greygridbar;
			X247Invoices.blackgridbar = pdfJsonFile.blackgridbar;
			X247Invoices.orangegridbar = pdfJsonFile.orangegridbar;
		});
	}
	X247Invoices['CDLLogo'] = '';
	X247Invoices['CDLSUKOnly'] = '';
	X247Invoices['CDL24PPL'] = '';

	if (dbcode == 77) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.CDLLogo = pdfJsonFile.CDLLogo;
			X247Invoices.CDLSUKOnly = pdfJsonFile.CDLSUKOnly;
			X247Invoices.CDL24PPL = pdfJsonFile.CDL24PPL;
		});
	}
	X247Invoices['PNDLogo'] = '';
	X247Invoices['PNDPPL48'] = '';

	if (dbcode == 70) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.PNDLogo = pdfJsonFile.PNDLogo;
			X247Invoices.PNDPPL48 = pdfJsonFile.PNDPPL48;
		});
	};
	X247Invoices['UTLogo'] = '';
	X247Invoices['UTPPL48'] = '';
	X247Invoices['UTMainLogo'] = '';
	X247Invoices['UTPPLStamp'] = '';
	X247Invoices['UTQRCode'] = '';
	X247Invoices['UTRoyalMail'] = '';
	X247Invoices['UTRoyalMailLogo'] = '';
	X247Invoices['UTCN22'] = '';
	X247Invoices['UTsign'] = '';
	X247Invoices['UTRM48'] = '';
	X247Invoices['UTRM48Tracked'] = '';
	X247Invoices['UTIntTracked'] = '';

	X247Invoices['getIncludeCountryCodes'] = [];
	X247Invoices['getExcludeCountryCodes'] = [];

	if (dbcode == 71) {
		$.get(X247Invoices.pdf_image_dir+'/includecountries.json?_=' + new Date().getTime()).then(function (res) {
			X247Invoices.getIncludeCountryCodes = res;
		});

		$.get(X247Invoices.pdf_image_dir+'/excludecountries.json?_=' + new Date().getTime()).then(function (res) {
			X247Invoices.getExcludeCountryCodes = res;
		});

		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.UTLogo = pdfJsonFile.UTLogo;
			X247Invoices.UTPPL48 = pdfJsonFile.UTPPL48;
			X247Invoices.UTMainLogo = pdfJsonFile.UTMainLogo;
			X247Invoices.UTPPLStamp = pdfJsonFile.UTPPLStamp;
			X247Invoices.UTQRCode = pdfJsonFile.UTQRCode;
			X247Invoices.UTRoyalMail = pdfJsonFile.UTRoyalMail;
			X247Invoices.UTRoyalMailLogo = pdfJsonFile.UTRoyalMailLogo;
			X247Invoices.UTCN22 = pdfJsonFile.UTCN22;
			X247Invoices.UTsign = pdfJsonFile.UTsign;
			X247Invoices.UTRM48 = pdfJsonFile.UTRM48;
			X247Invoices.UTIntTracked = pdfJsonFile.UTIntTracked;
			X247Invoices.UTRM48Tracked = pdfJsonFile.UTRM48Tracked;

		});
	}
	X247Invoices['FTTFCNUK'] = '';
	X247Invoices['FTTFUKOnly'] = '';
	X247Invoices['FTTSUKOnly'] = '';
	if (dbcode == 78) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.FTTFCNUK = pdfJsonFile.FTTFCNUK;
			X247Invoices.FTTFUKOnly = pdfJsonFile.FTTFUKOnly;
			X247Invoices.FTTSUKOnly = pdfJsonFile.FTTSUKOnly;
		});
	}
	X247Invoices['GNGLogo'] = '';
	X247Invoices['GNG24Logo'] = '';
	X247Invoices['GNGAirmail'] = '';
	X247Invoices['GNG48Logo'] = '';
	X247Invoices['DPLogo'] = '';
	X247Invoices['RM1PPLStamp'] = '';


	if (dbcode == 79) {
		var pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.GNGLogo = pdfJsonFile.GNGLogo;
			X247Invoices.GNG24Logo = pdfJsonFile.GNG24Logo;
			X247Invoices.GNGAirmail = pdfJsonFile.GNGAirmail;
			X247Invoices.GNG48Logo = pdfJsonFile.GNG48Logo;
			X247Invoices.DPLogo = pdfJsonFile.DPLogo;
			X247Invoices.RM1PPLStamp = pdfJsonFile.RM1PPLStamp;
		});
	};
	X247Invoices['CharRMPPL'] = '';
	if (dbcode == 74) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json').then(function (res) {
			pdfJsonFile = res;
			X247Invoices.CharRMPPL = pdfJsonFile.RMPPL;
		});
	}
	X247Invoices['FKLogo'] = '';
	if (dbcode == 46) {
		pdfJsonFile = '';
		$.get(X247Invoices.pdf_image_dir+'/pdfimages_'+dbcode+'.json?_=' + new Date().getTime()).then(function (res) {
			pdfJsonFile = res;
			X247Invoices.FKLogo = pdfJsonFile.FKLogo;
			X247Invoices.PKLogo = pdfJsonFile.PKLogo
		});
	}
	X247Invoices.FredricksubtotalUnitPrice=function(index, priceArray) {
			var subtotal = 0;
			var a1 = priceArray.length;
			/*if (a1 == undefined) {
				subtotal = parseFloat(subtotal) + (parseFloat(priceArray.Quantity) * parseFloat(priceArray.UnitPrice));

			} else {*/
				$.each(priceArray, function (key, value) {
					subtotal = parseFloat(subtotal) + (parseFloat(value.Quantity) * parseFloat(value.UnitPrice));
				});
			//}
			//  subtotal = Math.round(subtotal);

			return parseFloat(subtotal).toFixed(2);
	}
	X247Invoices.FredrickTotalPriceAmt=function(index, subPriceArr, totPrice) {

			var subtotal = 0;
			var a1 = subPriceArr.length;
			/*if (a1 == undefined) {
				if (typeof subPriceArr.ShippingPrice !== 'undefined' && subPriceArr.ShippingPrice !== '') {
					subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ShippingPrice);
				}
			} else {*/
				$.each(subPriceArr, function (key, value) {
					if (typeof value.ShippingPrice !== 'undefined' && value.ShippingPrice !== '' && value.ShippingPrice !== null) {
						subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
					}
				});
			//}

			var subTotalPrice = 0;
			/*if (a1 == undefined) {
				subTotalPrice = parseFloat(subTotalPrice) + (parseInt(subPriceArr.Quantity) * parseFloat(subPriceArr.UnitPrice));
			} else {*/
				$.each(subPriceArr, function (key, value) {
					subTotalPrice = parseFloat(subTotalPrice) + (parseInt(value.Quantity) * parseFloat(value.UnitPrice));
				});
			//}
			var FTP = 0;
			FTP = parseFloat(subTotalPrice) + parseFloat(subtotal);

			return parseFloat(FTP).toFixed(2);
	}
	X247Invoices.Fredricksubtotal= function(index, priceArray) {
			var subtotal = 0;
			var a1 = priceArray.length;

			/*if (a1 == undefined) {
				subtotal = parseFloat(subtotal) + parseFloat(priceArray.ShippingPrice);
			} else {*/
				$.each(priceArray, function (key, value) {

					if (typeof value.ShippingPrice !== 'undefined' && value.ShippingPrice !== '' && value.ShippingPrice !== null) {
						subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
					}

				});

			//}
			return parseFloat(subtotal).toFixed(2);
	}
	X247Invoices.FredrickGrandTotalWithVatHaberCrafts=function(index, subPriceArr, totPrice) {

			var subtotal = 0;
			var a1 = subPriceArr.length;
			/*if (a1 == undefined) {
				if (typeof subPriceArr.ShippingPrice !== 'undefined' && subPriceArr.ShippingPrice !== '') {
					if(subPriceArr.ShippingPrice > 0){
						subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ShippingPrice);
					}
				}
			} else {*/
				$.each(subPriceArr, function (key, value) {
					if (typeof value.ShippingPrice !== 'undefined' && value.ShippingPrice !== '' && value.ShippingPrice !== null) {
						if(value.ShippingPrice > 0){
							subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
						}
					}
				});
			//}

			var subTotalPrice = 0;
			/*if (a1 == undefined) {
				if (typeof subPriceArr.TotalPrice !== 'undefined' && subPriceArr.TotalPrice !== '') {
					subTotalPrice = parseFloat(subTotalPrice) + parseFloat(subPriceArr.TotalPrice);
				}
			} else {*/
				$.each(subPriceArr, function (key, value) {
					if (typeof value.TotalPrice !== 'undefined' && value.TotalPrice !== '') {
						subTotalPrice = parseFloat(subTotalPrice) + parseFloat(value.TotalPrice);
					}
				});
			//}

			var FTP = 0;
			//  FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) * 20 / 100;

			FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) - ((parseFloat(subTotalPrice) + parseFloat(subtotal)) / 1.2)

			return parseFloat(FTP).toFixed(2);
	}
	X247Invoices.GrandTotalWithVatHaberCrafts=function(index, subPriceArr, totPrice) {

		var subtotal = 0;
		var a1 = subPriceArr.length;
		/*if (a1 == undefined) {
			if(typeof subPriceArr.ShippingPrice != "undefined" && subPriceArr.ShippingPrice > 0){
				subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ShippingPrice);
			}
		} else {*/
			$.each(subPriceArr, function (key, value) {
				if(typeof value.ShippingPrice != "undefined"  && value.ShippingPrice !== null  && value.ShippingPrice !== '' && value.ShippingPrice > 0){
					subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
				}
			});
		//}

		var subTotalPrice = 0;
		/*if (a1 == undefined) {
			subTotalPrice = parseFloat(subTotalPrice) + parseFloat(subPriceArr.TotalPrice);
		} else {*/
			$.each(subPriceArr, function (key, value) {
				subTotalPrice = parseFloat(subTotalPrice) + parseFloat(value.TotalPrice);
			});
		//}

		var FTP = 0;
		//  FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) * 20 / 100;

		FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) - ((parseFloat(subTotalPrice) + parseFloat(subtotal)) / 1.2)

		return parseFloat(FTP).toFixed(2);
	};


	X247Invoices.FredrickGrandTotalWithVatHaberCrafts=function(index, subPriceArr, totPrice) {

		var subtotal = 0;
		var a1 = subPriceArr.length;
		/*if (a1 == undefined) {
			if (typeof subPriceArr.ShippingPrice !== 'undefined' && subPriceArr.ShippingPrice !== '') {
				subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ShippingPrice);
			}
		} else {*/
			$.each(subPriceArr, function (key, value) {
				if (typeof value.ShippingPrice !== 'undefined' && value.ShippingPrice !== '' && value.ShippingPrice !== null) {
					subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
				}
			});
		//}

		var subTotalPrice = 0;
		/*if (a1 == undefined) {
			if (typeof subPriceArr.TotalPrice !== 'undefined' && subPriceArr.TotalPrice !== '') {
				subTotalPrice = parseFloat(subTotalPrice) + parseFloat(subPriceArr.TotalPrice);
			}
		} else {*/
			$.each(subPriceArr, function (key, value) {
				if (typeof value.TotalPrice !== 'undefined' && value.TotalPrice !== '') {
					subTotalPrice = parseFloat(subTotalPrice) + parseFloat(value.TotalPrice);
				}
			});
		//}

		var FTP = 0;
		//  FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) * 20 / 100;

		FTP = (parseFloat(subTotalPrice) + parseFloat(subtotal)) - ((parseFloat(subTotalPrice) + parseFloat(subtotal)) / 1.2)

		return parseFloat(FTP).toFixed(2);
	}
	
	X247Invoices.FredricksubtotalunitPrice=function (index, subPriceArr) {
            var subtotal = 0;
            $.each(subPriceArr, function (key, value) {
                    subtotal = parseFloat(subtotal) + (parseFloat(value.Quantity) * parseFloat(value.UnitPrice));
            });

            return subtotal;
    }

	X247Invoices.subtotalUnitPrice=function(index, priceArray) {
			var subtotal = 0;
			var a1 = priceArray.length;
			/*if (a1 == undefined) {
				subtotal = parseFloat(subtotal) + (parseFloat(priceArray.Quantity) * parseFloat(priceArray.UnitPrice));
			} else {*/
				$.each(priceArray, function (key, value) {
					subtotal = parseFloat(subtotal) + (parseFloat(value.Quantity) * parseFloat(value.UnitPrice));
				});
			//}
			return parseFloat(subtotal).toFixed(2);
	}
	X247Invoices.totalPriceAmt=function(index, subPriceArr, totPrice) {

		var subtotal = 0;
		var a1 = subPriceArr.length;
		/*if (a1 == undefined) {
				if(subPriceArr.ShippingPrice > 0){
					subtotal = parseFloat(subtotal) + parseFloat(subPriceArr.ShippingPrice);
				}
			} else {*/
				$.each(subPriceArr, function (key, value) {
					if(value.ShippingPrice > 0 && value.ShippingPrice !== null){
						subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
					}
				});
			//}

			var subTotalPrice = 0;
			/*if (a1 == undefined) {
				if(subPriceArr.TotalPrice > 0){
					subTotalPrice = parseFloat(subTotalPrice) + parseFloat(subPriceArr.TotalPrice);
				}
			} else {*/
				$.each(subPriceArr, function (key, value) {
					if(value.TotalPrice > 0){
						subTotalPrice = parseFloat(subTotalPrice) + parseFloat(value.TotalPrice);
					}
				});
			//}

			var FTP = 0;
			FTP = parseFloat(subTotalPrice) + parseFloat(subtotal);
			return parseFloat(FTP).toFixed(2);
	}
	X247Invoices.subtotal=function(index, priceArray) {
	  var subtotal = 0;
	  var a1 = priceArray.length;
	  /*if (a1 == undefined) {
				if(priceArray.ShippingPrice > 0){
					subtotal = parseFloat(subtotal) + parseFloat(priceArray.ShippingPrice);
				}
			} else {*/
				$.each(priceArray, function (key, value) {
					if(value.ShippingPrice > 0 && value.ShippingPrice !== null){
						subtotal = parseFloat(subtotal) + parseFloat(value.ShippingPrice);
					}
				});
			//}
			return parseFloat(subtotal).toFixed(2);
	}

	X247Invoices.displayBinlocatonByOrderID=function(arrBinLength) {
			var strbin = '';
			var a1 = arrBinLength.length;
			/*if (a1 == undefined) {
				if (typeof arrBinLength.binlocation !== 'undefined' && arrBinLength.binlocation != null && arrBinLength.binlocation !== '') {
					strbin += arrBinLength.binlocation + ",";
				}

			} else {*/
				$.each(arrBinLength, function (key, value) {
					if (typeof value.binlocation !== 'undefined' && value.binlocation != null && value.binlocation !== '') {
						strbin += value.binlocation + ",";
					}
				});
			//}
			return strbin.substring(0, strbin.length - 1);

	}
	/* filter asscocite array */
	X247Invoices.checkFilter=function(data, filt){
	  var tmp_array = [];
	  $.each( data, function( key, val ) {
		  if(val.ServiceCode == filt){
			  tmp_array.push(val);
		  }	
	  });
	  return tmp_array;
	}
	/* filter asscocite array end*/
	/* date format */
	X247Invoices.dateFilter=function(){
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();
		var year = d.getFullYear();

		var date = (day<10 ? '0' : '') + day+""+(month<10 ? '0' : '') + month+""+d.getFullYear();
		
		return date;
	}
	/* date format end */
	
	X247Invoices.loadAssignedCourierServices=function(){
		var url = app_base_url + 'orders/assignedCourierServices.php';
		$.ajax({
			type: 'GET',
			url: url,
			async: true,
			cache: true,
			dataType: 'json',
			success: function (res) {
				//$('.traditional').removeClass('whirl');
				var data = res.data;
					if (res.status) {
						var couriers = data.couriers;
						var courierlabel_select = '<option value="" selected="selected">Select Courier</option>';
						$.each( couriers, function( key, val ) {
							X247Invoices.api_couriers[val.couriercode] = val;
							$.each( val.services, function( ks, vs ) {
								X247Invoices.api_services[ks] = vs;
							});
							courierlabel_select += "<option value="+val.couriercode+">"+val.couriername+"</option>";
						});
						$('#courierlabel_select').html(courierlabel_select);
					}
				
			}
		});
	}
	X247Invoices.loadAssignedCourierServices();
	
	/* print invloice lable of selected orders*/

	$('body').on("click", "#print_invoice_lable_fixed", function( e) {
		X247Invoices.printInvoicelabel();
	});

	X247Invoices.printInvoicelabel = function(){
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$("#PrintInvoiceLabel").modal("show");
		}else{
			alert("Please select anyone order");
		}
	}

	$('body').on('change','#invoicetemplate',function( e) {
		e.preventDefault();
		if($(this).prop("checked")){
			$("#invoicetemplate_select").removeClass("hide");
			$("#templatelabel_select").prop('required',true);
		}else{
			$("#invoicetemplate_select").addClass("hide");
			$("#templatelabel_select").removeClass('required');

		}
		
	});
	$('body').on('change','#courierChkboxLabel',function( e) {
		e.preventDefault();
		if($(this).prop("checked")){
			$("#courierlabel").removeClass("hide");
			$("#courierlabel_select").prop('required',true);
			if(dbcode !== "49"){
				$("#serviceslabel").removeClass("hide");
				$("#serviceslabel_select").prop('required',true);
			}
		}else{
			$("#courierlabel").addClass("hide");
			$("#serviceslabel").addClass("hide");
			$("#parcellabel").addClass("hide");
			$("#courierlabel_select").removeClass('required');
			$("#serviceslabel_select").removeClass('required');
		}
		
	});
	
	X247Invoices.getUniqueServices=function(){
		var fin_out = [];
		$.each(X247Invoices.trimmingcarrierservices,function(k,v){
			var val = v.carrier;
			if($.inArray(val,fin_out) == -1){
				fin_out.push(v.carrier);
			}
		});
		return fin_out;
	}

	$('body').on('change','#courierlabel_select',function( e) {
		e.preventDefault();
		courier_val = $(this).val();
		var servicecodelabel_select = '<option value="" selected="selected">Select Service Code</option>';
		$('#servicecodelabel_select').html(servicecodelabel_select);
		if(courier_val == 'GFS' && courier_val != 'Flipkart' && courier_val != 'PostPackages'){
			$("#carrierlabel").removeClass('hide');
			$("#servicecodelabel").removeClass('hide');
			$("#serviceslabel").addClass('hide');
			var uniqueServices = X247Invoices.getUniqueServices();
			var carrierlabel_select = '<option value="" selected="selected">Select Carrier</option>';
			$.each(uniqueServices,function(k,v){
				carrierlabel_select += "<option value='"+v+"'>"+v+"</option>";
			});
			$('#carrierlabel_select').html(carrierlabel_select);
		}else{
			$("#carrierlabel").addClass('hide');
			$("#servicecodelabel").addClass('hide');
			$('#accountlabel').addClass('hide');
			$("#parcellabel").addClass("hide");
			$("#serviceslabel").removeClass('hide');
			var cour_val = parseInt($(this).val());
			if(X247Invoices.api_couriers.length > 0){
				if(cour_val != 0){
					var serviceslabel_select = '';
					var services = X247Invoices.api_couriers[cour_val].services;
					$.each(services, function (ks, vs) {
						serviceslabel_select += "<option value="+vs.courierservicecode+">"+vs.courierservicename+"</option>";
					});
					$("#serviceslabel_select").append(serviceslabel_select);
				}
			}
		}
		
	});
	$('body').on('change','#carrierlabel_select',function( e) {
		e.preventDefault();
		var car_val = $(this).val();
		var servcodeFilter = X247Invoices.getUniqueServicesFilter(car_val);
		var servicecodelabel_select = '<option value="" selected="selected">Select Service Code</option>';
		$.each(servcodeFilter,function(k,v){
			servicecodelabel_select += "<option value='"+v.service_code+"'>"+v.value+"</option>";
		});
		$('#servicecodelabel_select').html(servicecodelabel_select);
		if(courier_val == 'GFS' && car_val == "royal mail" && courier_val != 'Flipkart' && courier_val != 'PostPackages'){
			$('#accountlabel').removeClass('hide');
		}else{
			$('#accountlabel').addClass('hide');
		}
		
	});
	
	X247Invoices.getUniqueServicesFilter=function(val){
		var fin_out = [];
		$.each(X247Invoices.trimmingcarrierservices,function(k,v){
			var car_val = v.carrier;
			if(val == car_val){
				fin_out.push({"service_code":v.service_code,"value":v.product_desc});
			}
		});
		return fin_out;
	}

	$('body').on("change",'#serviceslabel_select',function( e) {
		e.preventDefault();
		var cour_val = parseInt($(this).val());
		if(cour_val == 8){
			$("#parcellabel").removeClass("hide");
		}else{
			$("#parcellabel").addClass("hide");
		}
		
	});

	$('body').on('submit','#PrintInvoiceLabelForm',function( e) {
		e.preventDefault();
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			$("#PrintInvoiceLabel").modal("hide");
			var chkArray = [];
			var ordersDataForInvoice = [];
			/* look for all checkboxes that have a class 'chk' attached to it and check if it was checked */
			$(".order_checkbox:checked").each(function() {
				var dataRowIndex = $(this).val();
				if(X247Orders.allOrdersData) {
					ordersDataForInvoice.push(X247Orders.allOrdersData[dataRowIndex]);
				}

			});
			var item = {};
			if($('#invoicetemplate').prop("checked")){
				item['invoicetemplate'] = 'checked';
				item['templatelabel'] = $('#templatelabel_select').val();
			}
			if($('#courierChkboxLabel').prop("checked")){
				item['courierChkboxLabel'] = 'checked';
				item['courierlabel_select'] = $('#courierlabel_select').val();
				item['serviceslabel_select'] = $('#serviceslabel_select').val();
				if($('#serviceslabel_select').val() == 1){
					item['lblcourier'] = $('#lblcourier').val();
					item['weight'] = $('#weight').val();
				}
			}
			chkArray.push(item);
			var jsonString = JSON.stringify(chkArray);
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/printInvoices.php',
				async: true,
				cache: true,
				data: {orders:chkArray},
				dataType: 'json',
				success: function (res) {
					if(res.status){
						$('.traditional').removeClass('whirl');
						var data = ordersDataForInvoice;
						$('#invoicelableprint').html(res.view);
						if($('#invoicetemplate').prop("checked")){
							var InvoicetemplateID = $('#templatelabel_select').val();
							if(InvoicetemplateID == 1 || InvoicetemplateID == 0) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/newxml.js', 'newXML', data);
							}else if (InvoicetemplateID == 2) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/invoicepdf.js', 'invoicePDF', data);
							}else if (InvoicetemplateID == 3) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/amazoninvoicepdf.js', 'amazoninvoicePDF', data);
							}else if(InvoicetemplateID == 4) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ebayinvoicepdf.js', 'eBayinvoicePDF', data);
							}else if (InvoicetemplateID == 5) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/invoicewithvat.js', 'invoiceWithVAT', data);
							} else if (InvoicetemplateID == 6 || InvoicetemplateID == 7 || InvoicetemplateID == 8) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/royalmailpdf.js', 'royalmailPDF', data);
							} else if (InvoicetemplateID == 9) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/royalmailpackingpdf.js', 'royalmailPackingPDF', data);
							} else if (InvoicetemplateID == 10) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/royalmailjustbeautypdf.js', 'royalmailJustBeautyPDF', data);
							} else if (InvoicetemplateID == 15) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/marketing20royalmail48pdf3.js', 'marketing20RoyalMail48PDF3', data);
							} else if (InvoicetemplateID == 16) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fairwayimporterspdf1.js', 'fairwayImportersPDF1', data);
							} else if (InvoicetemplateID == 17) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/clothingdirectpdf.js', 'clothingDirectPDF', data);
							} else if (InvoicetemplateID == 18) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/michaelpdf.js', 'michaelPDF', data);
							} else if (InvoicetemplateID == 19) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/alexthefatdawgpdf.js', 'alexthefatdawgPDF', data);
							} else if (InvoicetemplateID == 20) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/juliesbookshoppdf.js', 'juliesbookshopPDF', data);
							} else if (InvoicetemplateID == 21) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/devilsdhlpdf.js', 'devilsDHLPDF', data, 1);
							} else if (InvoicetemplateID == 22) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/devilscourierinvoicepdf.js', 'devilsCourierInvoicePDF', data);
							} else if (InvoicetemplateID == 23) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/devilsroyalpdf.js', 'devilsRoyalPDF', data, 2);
							} else if (InvoicetemplateID == 24) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/startatpageonepdf.js', 'startatpageonePDF', data, 1);
							} else if (InvoicetemplateID == 25) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/startatpageonepdf.js', 'startatpageonePDF', data, 2);
							} else if (InvoicetemplateID == 26) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fdxsportsinvoicepdf.js', 'FDXSportsInvoicePDF', data);
							} else if (InvoicetemplateID == 27) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fdxsportslabelpdf.js', 'FDXSportsLabelPDF', data);
							} else if (InvoicetemplateID == 28) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/eesmusicroyalmail1classpdf.js', 'EESMusicRoyalMail1ClassPDF', data,1);
							} else if (InvoicetemplateID == 29) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/eesmusicroyalmail1classpdf.js', 'EESMusicRoyalMail1ClassPDF', data,2);
							} else if (InvoicetemplateID == 30) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/eesmusicroyalmail1classdpdpdf.js', 'EESMusicRoyalMail1ClassDPDPDF', data,3);
							} else if (InvoicetemplateID == 31) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/eesmusicroyalmail1classdpdpdf.js', 'EESMusicRoyalMail1ClassDPDPDF', data,4);
							} else if (InvoicetemplateID == 32) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/beautynestinvoicepdf.js', 'BeautyNestInvoicePDF', data,1);
							} else if (InvoicetemplateID == 33) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/beautynestinvoicepdf.js', 'BeautyNestInvoicePDF', data,2);
							} else if (InvoicetemplateID == 34) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/beautynestinvoicepdf.js', 'BeautyNestInvoicePDF', data,3);
							} else if (InvoicetemplateID == 35) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/beautynestinvoicepdf.js', 'BeautyNestInvoicePDF', data,4);
							} else if (InvoicetemplateID == 36) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/toysandtrucksvatinvoicepdf.js', 'ToysandtucksVATInvoicePDF', data);
							} else if (InvoicetemplateID == 37) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/habercraftsinvoicepdf.js', 'HaberCraftsInvoicePDF_Mod', data,1);
							} else if (InvoicetemplateID == 38) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/habercraftsinvoicepdf.js', 'HaberCraftsInvoicePDF_Mod', data,2);
							} else if (InvoicetemplateID == 39) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fairwayimportersnewinvoice.js', 'fairwayImportersNewInvoice', data);
							} else if (InvoicetemplateID == 40) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/habercraftsinvoicepdf.js', 'HaberCraftsInvoicePDF_Mod', data,3);
							} else if (InvoicetemplateID == 41) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ktimeoutinvoice.js', 'KitmeoutInvoicePDF', data,0);
							} else if (InvoicetemplateID == 42) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ktimeoutinvoice.js', 'KitmeoutInvoicePDF', data,1);
							} else if (InvoicetemplateID == 43) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ktimeoutinvoice.js', 'KitmeoutInvoicePDF', data,2);
							} else if (InvoicetemplateID == 44) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ktimeoutinvoice.js', 'KitmeoutInvoicePDF', data,3);
							} else if (InvoicetemplateID == 45) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/championdreaminvoicepdf.js', 'ChampionDreamInvoiceNewPDF', data,1);
							} else if (InvoicetemplateID == 53) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/championdreaminvoicepdf.js', 'ChampionDreamInvoiceNewPDF', data,2);
							} else if (InvoicetemplateID == 46) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/pannudesigninvoicepdf.js', 'PannuDesignInvoicePDF', data);
							} else if (InvoicetemplateID == 47) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoicepdf.js', 'UrbanTradingFinalInvoicePDF', data);
							} else if (InvoicetemplateID == 48) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fedricthomasinvoicepdf.js', 'FedricThomasInvoicePDF', data,4);
							} else if (InvoicetemplateID == 49) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/gizmozngadgetsinvoicepdf.js', 'GizmoznGadgetzInvoicePDF', data,4);
							} else if (InvoicetemplateID == 50) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fedricthomasinvoicepdf.js', 'FedricThomasInvoicePDF', data,1);
							} else if (InvoicetemplateID == 51) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fedricthomasinvoicepdf.js', 'FedricThomasInvoicePDF', data,2);
							} else if (InvoicetemplateID == 52) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/fedricthomasinvoicepdf.js', 'FedricThomasInvoicePDF', data,3);
							} else if (InvoicetemplateID == 54) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/designproductsinvoicepdf.js', 'DesignProductsInvoicePDF', data);
							} else if (InvoicetemplateID == 55) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/designproductslabelpdf.js', 'DesignProductsLabelPDF', data);
							} else if (InvoicetemplateID == 56) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/amazonprokladerinvoicepdf.js', 'AmazonProKladerInvoicePDF', data);
							} else if (InvoicetemplateID == 57) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ebaymilitaryinvoicepdf.js', 'ebayMilitaryInvoicePDF', data);
							} else if (InvoicetemplateID == 58) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/ebayworkwearinvoicepdf.js', 'ebayWorkwearInvoicePDF', data);
							} else if (InvoicetemplateID == 59) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoice.js', 'UrbanTradingInvoice', data,1);
							} else if (InvoicetemplateID == 60) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoice.js', 'UrbanTradingInvoice', data,2);
							} else if (InvoicetemplateID == 61) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoice.js', 'UrbanTradingInvoice', data,3);
							} else if (InvoicetemplateID == 62) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoice.js', 'UrbanTradingInvoice', data,4);
							} else if (InvoicetemplateID == 63) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/urbantradinginvoice.js', 'UrbanTradingInvoice', data,5);
							} else if (InvoicetemplateID == 64) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/borrisdorrisinvoicepdf.js', 'BorrisDorrisInvociePDF', data);
							} else if (InvoicetemplateID == 65) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/charge84invoicepdf.js', 'Charing84InvoicePDF', data);
							} else if (InvoicetemplateID == 66) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/footkitinvoicepdf.js', 'FootKitInvoicePDF', data,1);
							} else if (InvoicetemplateID == 67) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/footkitinvoicepdf.js', 'FootKitInvoicePDF', data,2);
							} else if (InvoicetemplateID == 68) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/rejelautomotiveinvoicepdf.js', 'RejelAutomotiveInvoicePDF', data);
							} else if (InvoicetemplateID == 69) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/monogram.js', 'monogrampdf', data,1);
							} else if (InvoicetemplateID == 70) {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/monogram.js', 'monogrampdf', data,2);
							} else {
								X247Invoices.loadJS(app_base_url + 'common/js/invoices/newxml.js', 'newXML', data);
							}
						}
						if($('#courierChkboxLabel').prop("checked")){
							/*if (dbcode == 41) {
								if (typeof $('#courierlabel_select').val() == 'undefined') {
									toaster.pop("warning", "Please Select Courier");
									return false;
								} else {
									if ($('#courierlabel_select').val() === 'GFS') {
										if (parseInt($scope.gfsservices.gfscarrier) == 0 || $scope.gfsservices.gfscarrier == null || typeof $scope.gfsservices.gfscarrier == 'undefined') {
											toaster.pop("warning", "Please Select Carrier");
											return false;
										}
										if (parseInt(gfsservices.gfsserviecode) == 0 || $scope.gfsservices.gfsserviecode == null || typeof $scope.gfsservices.gfsserviecode == 'undefined') {
											toaster.pop("warning", "Please Select Servie Code");
											return false;
										}
									}
								}
								if (courierServices.selectedCourier !== 'GFS') {
									if (typeof courierServices.selectedServices == 'undefined') {
										toaster.pop("warning", "Please Select Service");
										return false;
									}
								}
							}
							else if ($scope.dbcode == 49) {
								if (typeof courierServices.selectedCourier == 'undefined') {
									toaster.pop("warning", "Please Select Courier");
									return false;
								}
							}
							else if ($scope.dbcode == 52) {
								if (typeof courierServices.selectedCourier == 'undefined') {
									toaster.pop("warning", "Please Select Courier");
									return false;
								}
							}
							else {
								if (typeof courierServices.selectedCourier == 'undefined') {
									toaster.pop("warning", "Please Select Courier");
									return false;
								}
								if (typeof courierServices.selectedServices == 'undefined') {
									toaster.pop("warning", "Please Select Service");
									return false;
								}
							}*/
							X247Invoices.labelselection(data);
						}
						
					}else{
						alert("Error Occured");
					}
					
				}
			});
		}else{
			alert("Please select anyone order");
		}
	});
	X247Invoices.labelselection=function(data) {
		var ordSKUArray = [];
		var selectQuery = '';
		var petsOrdersArray = [];
		var tempordDetails = [];
		var courier_label = $('body #courierlabel_select').val();
		var services_label = $('body #serviceslabel_select').val();
		var gfscarrier = $('body #carrierlabel_select').val();
		var gfsserviecode = $('body #servicecodelabel_select').val();
		var gfsroyalmailcarrier = $('body #accountlabel_select').val();
		for(var jd=0;jd< data.length;jd++){
			
			var multiple_orders = [];
			if(data[jd]['orderitems'].length > 0){
				multiple_orders = data[jd]['orderitems'];
			}

			var shipaddresses = data[jd]['shippingaddresses'][0];
			shipaddresses['items'] = multiple_orders;
			shipaddresses['orderdate'] = data[jd].purchasedate;
			tempordDetails[jd] = {
					"ordernumber": data[jd].orderid,
					"shippingaddreses": [shipaddresses],
			};
		}
		
		var isShowCourierServices = false;
		var skuArray = [];

		$(".order_checkbox:checked").each(function() {
			var orderIDval = $(this).val();
			var orderIDArr = orderIDval.split("+");
			if (typeof orderIDArr[3] === 'undefined' || orderIDArr[3] === '' || orderIDArr[3] === null) {
				skuArray.push({
					orderid: orderIDArr[0],
					accountcode: orderIDArr[1]
				});
				selectQuery += '"' + orderIDArr[0] + '",';
			} else {

				var orderstagemergeOrder = [];
				orderstagemergeOrder = alasql('select *,ordernumber from ? where ordernumber=?', [tempordDetails, orderIDArr[0]]);

				$.each(orderstagemergeOrder, function (v1, k) {
					skuArray.push({
						orderid: v1.ordernumber,
						accountcode: v1.accountcode
					});
				});
			}
		});
		if (parseInt(courier_label) == 1 && dbcode != 46 ) {
			var gfscarrier = $('body #carrierlabel_select').val();
			var gfsserviecode = $('body #servicecodelabel_select').val();
			var gfsroyalmailcarrier = $('body #accountlabel_select').val();
			if (dbcode == 41) {
				if (courier_label === 'GFS') {
					if (parseInt(gfscarrier) == 0 || gfscarrier == null) {
								toaster.pop("warning", "Please Select Carrier");
								return false;
							}
							if (parseInt(gfsserviecode) == 0 || gfsserviecode == null) {
								toaster.pop("warning", "Please Select Servie Code");
								return false;
							}
						}
					if (courier_label !== 'GFS') {
						if (typeof services_label == 'undefined') {
							toaster.pop("warning", "Please Select Service");
							return false;
						}
					}
			}
			if (parseInt(courier_label) == 1 && dbcode != 46) {

				var isInternationalCourier = '';
				
				if (X247Invoices.api_couriers.length > 0) {
					isInternationalCourier = X247Invoices.api_couriers[courier_label].isinternational;
				}

				var serviceLabelArray = [];
				var OrgTempOrdersList = [];
				//serviceLabelArray.push({Service:services_label});
				serviceLabelArray = X247Invoices.checkFilter(X247Invoices.CourierServiceLabels,services_label);
				if (serviceLabelArray.length > 0) {

					var text = "";
					var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

					for (var i = 0; i < 8; i++) {
						text += possible.charAt(Math.floor(Math.random() * possible.length));
					}


					var csvDateFormat = 'ddMMyyyy';
					var dcsvdate = new Date();
					var csvFileName = X247Invoices.dateFilter();
					var uniqueFileName = 'Royalmail' + '_' + csvFileName + '_' + dcsvdate.toLocaleTimeString().replace(/:/g, '') + '.csv';
					if (dbcode != 50) {
						alasql.fn.replaceHTMLCodes = function (htmlcodes) {
							if(htmlcodes != "" && htmlcodes != null && htmlcodes.length > 0){
									var s1 = '/&quot;|&amp;|&lt;|&gt;|&nbsp;|&iexcl;|&cent;|&pound;|&curren;|&yen;|&brvbar;|&sect;|&uml;|&copy;|&ordf;|&laquo;|&not;|&shy;|&reg;|&macr;|&euro;/g'
									var a1 = htmlcodes.replace(s1, "");
									return a1;
							}else{
								return "";
							}
						};
						selectQuery = selectQuery.substring(0, selectQuery.length - 1);

						var res = 'SEARCH / AS @a \ shippingaddreses / AS @c \ items / AS @b \ RETURN (';
						
						res += '"D" AS [Service Reference],';

						res += '"' + serviceLabelArray[0].Service + '" AS Service,';
						if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
							res += '"N" AS [Service Fomat],';
						} else {
							var lblcourier = $('#lblcourier').val();
							if (lblcourier === "1") {
								res += '"LL" AS [Service Fomat],';
							} else {
								if (dbcode == 50) {
									res += '"Parcel" AS [Service Fomat],';
								} else {
									res += '"P" AS [Service Fomat],';
								}
							}
						}

						if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
							res += '"T" AS [Service Class],';
						} else {
							if ((dbcode == 50 && serviceLabelArray[0].ServiceCode == 248) || (dbcode == 50 && serviceLabelArray[0].ServiceCode == 249) || (dbcode == 50 && serviceLabelArray[0].ServiceCode == 57)) {
								res += '"' + serviceLabelArray[0].ServiceCode + '" AS [Service Class],';
							} else {
								res += '"' + serviceLabelArray[0].ServiceClass + '" AS [Service Class],';
							}
						}
						
						res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Recipient/ Tracked Returns],';

						// res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Recipient/ Tracked Returns Complementary Name],';

						res += '"" as [Recipient/ Tracked Returns Complementary Name],';

						res += 'CASE WHEN @c->Address1 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address1) END as [Recipient/ Tracked Returns Address line 1],';

						res += 'CASE WHEN @c->Address2 =undefined THEN @c->City ELSE replaceHTMLCodes(@c->Address2) END as [Recipient/ Tracked Returns Address line 2],';

						res += 'CASE WHEN @c->City =undefined THEN "" ELSE replaceHTMLCodes(@c->City) END as [Recipient/ Tracked Returns Address line 3],';

						res += 'CASE WHEN @c->PostCode =undefined THEN "" ELSE @c->PostCode END as [Recipient/ Tracked Returns Postcode],';

						res += 'CASE WHEN @c->CountyName =undefined THEN @c->City ELSE replaceHTMLCodes(@c->CountyName) END as [Recipient/ Tracked Returns Post Town],';

						res += 'CASE WHEN @c->CountryCode =undefined THEN "" ELSE @c->CountryCode END as [Recipient/ Tracked Returns Country Code],';

						res += '@a->ordernumber AS Reference,';

						res += '"1" as [Items],';

						res += '"' + $('#weight').val() + '" AS [Weight(kgs)],';

						
						if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
							res += '"EML" as [Service Enhancement],';
						} else {
							res += '"" as [Service Enhancement],';
						}

						res += '"" as [Recipient Tel No],';
						
						if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
							res += 'CASE WHEN @c->email =undefined THEN "" ELSE @c->email END as [Recipient Email Address],';
						} else {
							res += '" " AS [Recipient Email Address],';
						}

						if (isInternationalCourier === "1") {
							var commercialdate = new Date();
							var newCommercialDate = dateFilter();
							//  var newCommercialDate = formatDateTime(commercialdate, dateTimeFormat, 0);
							res += '"' + newCommercialDate + '" as [Commercial Invoice Date],';
							res += '"Y" as [CN23 Only Flag],';
						} else {
							res += '"" as [Commercial Invoice Date],';
							res += '"" as [CN23 Only Flag],';
						}

						res += '"' + serviceLabelArray[0].Service + '" as [Signature] ) ';

						res += ' INTO csv("' + uniqueFileName + '",{headers:true}) FROM ?';

						//  var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [orders]);
						// for merge Order pupose we are uisng  OrgTempOrdersList Object
						var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [tempordDetails]);
						alasql(res, [resArray]);
					}
					 else {
						if (serviceLabelArray[0].ServiceCode == 9 || serviceLabelArray[0].ServiceCode == 176 || serviceLabelArray[0].ServiceCode == 232) {
							alasql.fn.replaceHTMLCodes = function (htmlcodes) {
								if(htmlcodes != "" && htmlcodes != null && htmlcodes.length > 0){
										var s1 = '/&quot;|&amp;|&lt;|&gt;|&nbsp;|&iexcl;|&cent;|&pound;|&curren;|&yen;|&brvbar;|&sect;|&uml;|&copy;|&ordf;|&laquo;|&not;|&shy;|&reg;|&macr;|&euro;/g'
										var a1 = htmlcodes.replace(s1, "");
										return a1;
								}else{
									return "";
								}
							};
							
							selectQuery = selectQuery.substring(0, selectQuery.length - 1);
							
							var res = 'SEARCH / AS @a \ shippingaddreses / AS @c \ items / AS @b \ RETURN (';
							
							res += '"' + serviceLabelArray[0].Service + '" AS Service,';
							
							if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
								res += '"N" AS [Service Fomat],';
							} else {
								var lblcourier = $('#lblcourier').val();
								if (lblcourier === "1") {
									res += '"LL" AS [Service Fomat],';
								} else {
									if (dbcode == 50) {
										res += '"Parcel" AS [Service Fomat],';
									} else {
										res += '"P" AS [Service Fomat],';
									}
								}
							}
							
							res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Recipient/ Tracked Returns],';
							res += '"" as [Recipient/ Tracked Returns Complementary Name],';
							res += 'CASE WHEN @c->Address1 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address1) END as [Recipient/ Tracked Returns Address line 1],';
							res += 'CASE WHEN @c->Address2 =undefined THEN @c->City ELSE replaceHTMLCodes(@c->Address2) END as [Recipient/ Tracked Returns Address line 2],';
							res += 'CASE WHEN @c->City =undefined THEN "" ELSE replaceHTMLCodes(@c->City) END as [Recipient/ Tracked Returns Address line 3],';
							res += 'CASE WHEN @c->PostCode =undefined THEN "" ELSE @c->PostCode END as [Recipient/ Tracked Returns Postcode],';
							res += 'CASE WHEN @c->CountyName =undefined THEN @c->City ELSE replaceHTMLCodes(@c->CountyName) END as [Recipient/ Tracked Returns Post Town],';
							res += 'CASE WHEN @c->CountryCode =undefined THEN "" ELSE @c->CountryCode END as [Recipient/ Tracked Returns Country Code],';
							res += '@a->ordernumber AS Reference,';
							res += '" " AS [Weight(kgs)]';
							
							res += ' )';
							
							res += ' INTO csv("' + uniqueFileName + '",{headers:true}) FROM ?';
							
							var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [tempordDetails]);
							
							alasql(res, [resArray]);
						} else {
							alasql.fn.replaceHTMLCodes = function (htmlcodes) {
								if(htmlcodes != "" && htmlcodes != null && htmlcodes.length > 0){
										var s1 = '/&quot;|&amp;|&lt;|&gt;|&nbsp;|&iexcl;|&cent;|&pound;|&curren;|&yen;|&brvbar;|&sect;|&uml;|&copy;|&ordf;|&laquo;|&not;|&shy;|&reg;|&macr;|&euro;/g'
										var a1 = htmlcodes.replace(s1, "");
										return a1;
								}else{
									return "";
								}
							};
							selectQuery = selectQuery.substring(0, selectQuery.length - 1);
							
							var res = 'SEARCH / AS @a \ shippingaddreses / AS @c \ items / AS @b \ RETURN (';
							
							res += '"D" AS [Service Reference],';
							
							res += '"' + serviceLabelArray[0].Service + '" AS Service,';
							
							if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
								res += '"N" AS [Service Fomat],';
							} else {
								var lblcourier = $('#lblcourier').val();
								if (lblcourier === "1") {
									res += '"LL" AS [Service Fomat],';
								} else {
									if (dbcode == 50) {
										res += '"Parcel" AS [Service Fomat],';
									} else {
										res += '"P" AS [Service Fomat],';
									}
								}
							}
							if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
								res += '"T" AS [Service Class],';
							} else {
								if ((dbcode == 50 && serviceLabelArray[0].ServiceCode == 248) || (dbcode == 50 && serviceLabelArray[0].ServiceCode == 249) || (dbcode == 50 && serviceLabelArray[0].ServiceCode == 57)) {
									res += '"' + serviceLabelArray[0].ServiceCode + '" AS [Service Class],';
								} else {
									res += '"' + serviceLabelArray[0].ServiceClass + '" AS [Service Class],';
								}
							}
							
							res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Recipient/ Tracked Returns],';

							// res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Recipient/ Tracked Returns Complementary Name],';
							res += '"" as [Recipient/ Tracked Returns Complementary Name],';
							res += 'CASE WHEN @c->Address1 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address1) END as [Recipient/ Tracked Returns Address line 1],';
							res += 'CASE WHEN @c->Address2 =undefined THEN @c->City ELSE replaceHTMLCodes(@c->Address2) END as [Recipient/ Tracked Returns Address line 2],';
							res += 'CASE WHEN @c->City =undefined THEN "" ELSE replaceHTMLCodes(@c->City) END as [Recipient/ Tracked Returns Address line 3],';
							res += 'CASE WHEN @c->PostCode =undefined THEN "" ELSE @c->PostCode END as [Recipient/ Tracked Returns Postcode],';
							res += 'CASE WHEN @c->CountyName =undefined THEN @c->City ELSE replaceHTMLCodes(@c->CountyName) END as [Recipient/ Tracked Returns Post Town],';
							res += 'CASE WHEN @c->CountryCode =undefined THEN "" ELSE @c->CountryCode END as [Recipient/ Tracked Returns Country Code],';
							res += '@a->ordernumber AS Reference,';
							res += '"1" as [Items],';
							res += '"' + $('#weight').val() + '" AS [Weight(kgs)],';
							if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
								res += '"EML" as [Service Enhancement],';
							} else {
								res += '"" as [Service Enhancement],';
							}
							
							res += '"" as [Recipient Tel No],';
							
							if (parseInt(services_label) == 223 || parseInt(services_label) == 224 || parseInt(services_label) == 75 || parseInt(services_label) == 76) {
								res += 'CASE WHEN @c->email =undefined THEN "" ELSE @c->email END as [Recipient Email Address],';
							} else {
								res += '" " AS [Recipient Email Address],';
							}

							if (isInternationalCourier === "1") {
								var commercialdate = new Date();
								var newCommercialDate = dateFilter();
								res += '"' + newCommercialDate + '" as [Commercial Invoice Date],';
								res += '"Y" as [CN23 Only Flag],';
							} else {
								res += '"" as [Commercial Invoice Date],';
								res += '"" as [CN23 Only Flag],';
							}
							
							res += '"' + serviceLabelArray[0].Signature + '" as [Signature] ) ';
							
							res += ' INTO csv("' + uniqueFileName + '",{headers:true}) FROM ?';
							
							var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [$scope.OrgTempOrdersList]);
							alasql(res, [resArray]);
						}

					}


				} else {
					alert("Print Documents In Bulk");
				}
			}

		}else {
			if (courier_label === 'GFS') {
				var text = "";
				var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
				for (var i = 0; i < 8; i++) {
					text += possible.charAt(Math.floor(Math.random() * possible.length));
				}
				var csvDateFormat = 'ddMMyyyy';
				var dcsvdate = new Date();
				var csvFileName = X247Invoices.dateFilter();
				var uniqueFileName = 'GFS' + '_' + csvFileName + '_' + dcsvdate.toLocaleTimeString().replace(/:/g, '') + '.csv';

				alasql.fn.replaceHTMLCodes = function (htmlcodes) {
					if(htmlcodes != "" && htmlcodes != null && htmlcodes.length > 0){
							var s1 = '/&quot;|&amp;|&lt;|&gt;|&nbsp;|&iexcl;|&cent;|&pound;|&curren;|&yen;|&brvbar;|&sect;|&uml;|&copy;|&ordf;|&laquo;|&not;|&shy;|&reg;|&macr;|&euro;/g'
							var a1 = htmlcodes.replace(s1, "");
							return a1;
					}else{
						return "";
					}
				};
				
				alasql.fn.replacePhoneCodes = function (htmlcodes) {
							var a1 = htmlcodes.replace(/\//g, '');
							return a1;
				};
				
				alasql.fn.ebayOrderNoTrim = function (htmlcodes) {
					var dashcount = htmlcodes.split('-', 2).join('-').length;
					if (dashcount == 0) {
						return "";
					} else {
						return htmlcodes.slice(0, dashcount - 1);
					}
				};
				
				selectQuery = selectQuery.substring(0, selectQuery.length - 1);
				
				var res = 'SEARCH / AS @a \ shippingaddreses / AS @c \ items / AS @b \ RETURN (';
				
				res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [Name],';
				res += '"" AS [Company],';
				res += 'CASE WHEN @c->Address1 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address1) END as [Street],';
				res += 'CASE WHEN @c->StateOrRegion =undefined THEN "" ELSE replaceHTMLCodes(@c->StateOrRegion) END as [District],';
				res += 'CASE WHEN @c->City =undefined THEN "" ELSE replaceHTMLCodes(@c->City) END as [City],';
				res += 'CASE WHEN @c->CountryName =undefined THEN @c->City ELSE replaceHTMLCodes(@c->CountryName) END as [County],';
				res += 'CASE WHEN @c->PostCode =undefined THEN "" ELSE @c->PostCode END as [Postcode],';
				res += 'CASE WHEN @c->CountryCode =undefined THEN "" ELSE @c->CountryCode END as [Country],';
				res += 'CASE WHEN @a->marketplacecode ="1" THEN ebayOrderNoTrim(@a->ordernumber) ELSE @a->ordernumber END as [Shipment Ref],';
				//  res += '@a->ordernumber AS [Shipment Ref],';
				res += '"" AS [Number of packs],';
				res += '"0.09" AS [Weight],';
				var gfscarrier = $('body #carrierlabel_select').val();
				var gfsserviecode = $('body #servicecodelabel_select').val();
				var gfsroyalmailcarrier = $('body #accountlabel_select').val();
				res += '"' + gfscarrier + '" AS [Carrier],';
				
				if (gfscarrier === 'DPD') {
					res += '"1384" AS [Contract No],';
				} else if (gfscarrier === 'hermes') {
					if (gfsserviecode === '2DAYI') {
						res += '"7RY070" AS [Contract No],';
					} else if (gfsserviecode === '2DAYP') {
						res += '"1RY010" AS [Contract No],';
					} else if (gfsserviecode === '2DAYS') {
						res += '"1RY020" AS [Contract No],';
					} else {
						res += '"" AS [Contract No],';
					}
				} else if (gfscarrier === 'royal mail') {
					if (gfsroyalmailcarrier === 'Trimming Shop Group Limited') {
						res += '"438270000" AS [Contract No],';
					} else if (gfsroyalmailcarrier === 'Trimming Shop 007 Limited') {
						res += '"397397000" AS [Contract No],';
					} else if (gfsroyalmailcarrier === 'Wedding Suppliers London Ltd') {
						res += '"400421000" AS [Contract No],';
					} else {
						res += '"" AS [Contract No],';
					}
				} else {
					res += '"" AS [Contract No],';
				}
				//  res += 'CASE WHEN @c->phone =undefined THEN "" ELSE @c->phone END as [Contract No],';
				res += '"' + gfsserviecode + '" AS [Service Code],';
				res += '@c->orderdate AS [Dispatch Date],';
				res += 'CASE WHEN @c->Phone =undefined or @c->Phone ="Invalid Request" THEN "" ELSE replacePhoneCodes(@c->Phone) END as [Phone No],';
				res += 'CASE WHEN @c->mobileno =undefined or @c->mobileno ="Invalid Request" THEN "" ELSE replacePhoneCodes(@c->mobileno) END as [Mobile No])';
				res += ' INTO csv("' + uniqueFileName + '",{headers:true}) FROM ?';
				// for merge Order pupose we are uisng  OrgTempOrdersList Object
				var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [tempordDetails]);
				alasql(res, [resArray]);
				
				var gfsservices = {
							'gfscarrier': 0,
							'gfsserviecode': 0,
							'gfsroyalmailcarrier': 0
						};
						
			} else if (courier_label === 'PostPackages') {
				var listOrgPetOrder = [];
				var listOrgPetOrder = tempordDetails;
				
				$.each(listOrgPetOrder, function (v1, k) {
					var ss1 = [];
					ss1 = $filter('filter')(petsOrdersArray, {
								"ordernumber": v1.ordernumber
						}, true);
					if (ss1.length > 0) {
								$.extend(listOrgPetOrder[k], {
									'servicecode': ss1[0].servicecode,
									'serviceweight': ss1[0].serviceweight
								});
					} else {
								$.extend(listOrgPetOrder[k], {
									'servicecode': 0,
									'serviceweight': 0
								});
					}
				});
				var text = "";
				var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
				
				for (var i = 0; i < 8; i++) {
					text += possible.charAt(Math.floor(Math.random() * possible.length));
				}
				
				var csvDateFormat = 'ddMMyyyy';
				var dcsvdate = new Date();
				var csvFileName = X247Invoices.checkFilter();
				var uniqueFileName = 'PostPackages' + '_' + csvFileName + '_' + dcsvdate.toLocaleTimeString().replace(/:/g, '') + '.csv';

						alasql.fn.replaceHTMLCodes = function (htmlcodes) {
							if(htmlcodes != "" && htmlcodes != null && htmlcodes.length > 0){
									var s1 = '/&quot;|&amp;|&lt;|&gt;|&nbsp;|&iexcl;|&cent;|&pound;|&curren;|&yen;|&brvbar;|&sect;|&uml;|&copy;|&ordf;|&laquo;|&not;|&shy;|&reg;|&macr;|&euro;/g'
									var a1 = htmlcodes.replace(s1, "");
									return a1;
							}else{
								return "";
							}
						};

						alasql.fn.replacePhoneCodes = function (htmlcodes) {
							var a1 = htmlcodes.replace(/\//g, '');
							return a1;
						};

						alasql.fn.ebayOrderNoTrim = function (htmlcodes) {
							var dashcount = htmlcodes.split('-', 2).join('-').length;
							if (dashcount == 0) {
								return "";
							} else {
								return htmlcodes.slice(0, dashcount - 1);
							}

						};
				selectQuery = selectQuery.substring(0, selectQuery.length - 1);
				var res = 'SEARCH / AS @a \ shippingaddreses / AS @c \ items / AS @b \ RETURN (';
				res += 'CASE WHEN @c->Name =undefined THEN "" ELSE replaceHTMLCodes(@c->Name) END  as [FullName],';
				res += '"" AS [CompanyName],';
				res += 'CASE WHEN @c->Address1 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address1) END as [Address1],';
				res += 'CASE WHEN @c->Address2 =undefined THEN "" ELSE replaceHTMLCodes(@c->Address2) END as [Address2],';
				res += '"" AS [Address3],';
				res += 'CASE WHEN @c->City =undefined THEN "" ELSE replaceHTMLCodes(@c->City) END as [Town],';
				res += 'CASE WHEN @c->StateOrRegion =undefined THEN "" ELSE replaceHTMLCodes(@c->StateOrRegion) END as [Region],';
				//  res += 'CASE WHEN @c->CountyName =undefined THEN @c->City ELSE replaceHTMLCodes(@c->CountyName) END as [County],';
				res += 'CASE WHEN @c->PostCode =undefined THEN "" ELSE @c->PostCode END as [PostalCode],';
				res += 'CASE WHEN @c->CountryCode =undefined THEN "" ELSE @c->CountryCode END as [CountryCode],';
				res += 'CASE WHEN @a->serviceweight ="undefined" THEN "" ELSE @a->serviceweight END as [TotalWeight],';
				res += '"" AS [PostalServiceCode],';
				res += '"" AS [DeliveryInstructions],';
				res += 'CASE WHEN @a->ordernumber ="undefined" THEN "" ELSE @a->ordernumber END as [OrderId],';
				res += 'CASE WHEN @a->ordernumber ="undefined" THEN "" ELSE @a->ordernumber END as [ReferenceNumber],';
				// res += '"' + ppsservices.ppsserviecode + '" AS [Service])';
				res += 'CASE WHEN @a->servicecode ="undefined" THEN "" ELSE @a->servicecode END as [Service])';
				res += ' INTO csv("' + uniqueFileName + '",{headers:true}) FROM ?';
				// for merge Order pupose we are uisng  OrgTempOrdersList Object
				var resArray = alasql('select *  FROM ? as a1 WHERE a1.ordernumber  in (' + selectQuery + ')', [listOrgPetOrder]);
				alasql(res, [resArray]);
				
				var ppsservices = {
							'ppscarrier': 0,
							'ppsserviecode': 0
						};
				$.each(listOrgPetOrder, function (v1, k) {
					$('#pservicecode_' + k).val('0');
					$('#pweight_' + k).val('')
				});
				if (typeof courierServices.invoice == 'undefined') {
					var checkboxes = {
								'checked': false,
								items: {}
							};
							OrdersCountSelect = 0;
				}
			} /*else if (courier_label === 'Flipkart') {
				var generatelabelrequest = '';
				var faccountcode = '2';
				var forderItemcode = 'OD508426789078452000';
				var finvoiceDate = '2017-03-22';
				generatelabelrequest = '<?xml version="1.0" encoding="ISO-8859-1"?><exportordersrequest><usertoken><![CDATA[' + $store.get('authtoken') + ']]></usertoken><dbcode>' + $store.get('dbc') + '</dbcode><responsetype><![CDATA[json]]></responsetype>';
				generatelabelrequest += '<flipkartaccountcode>' + faccountcode + '</flipkartaccountcode>';
				generatelabelrequest += '<orderitemid>' + forderItemcode + '</orderitemid>';
				generatelabelrequest += '<invoicedate>' + finvoiceDate + '</invoicedate>';
				generatelabelrequest += '<taxrate>5</taxrate>';
				generatelabelrequest += '</generatelabelrequest>';
				$http.post($store.get('deliverAPI') + '/OrderAPI/API/Labels/GenerateLabel', generatelabelrequest, {
						}).success(function (response) {
							if (response.statuscode === "0") {
								console.log(response, "response");
								ngDialog.close();
								toaster.pop('success', "Export Orders", 'Request sent successfully');
							} else {
								ngDialog.close();
								toaster.pop('error', "Export Orders", 'Error:' + response.statusmessage);
							}
						});
			}*/
			else {
				var requestArray = {};
				requestArray['skuArray'] = skuArray;
				requestArray['orderaction'] = '';
				requestArray['uniquereference'] = '';
				requestArray['shippingservicecode'] = '';
				requestArray['accountcode'] = '';
				requestArray['shippingcountrycode'] = '';
				requestArray['singleitem'] = '';
				requestArray['multipleitems'] = '';
				requestArray['all'] = '';
				requestArray['invoicetype'] = 0;
				requestArray['selectedCourier'] = 0;
				requestArray['selectedServices'] = 0;
				requestArray['courierservicename'] = '';
				requestArray['numberoflabels'] = 0;
				if ($('#courierlabel_select').val() > 0 && $('#serviceslabel_select').val() > 0) {
					requestArray['selectedCourier'] = $('body #courierlabel_select').val();
					requestArray['selectedServices'] = $('body #serviceslabel_select').val();
					
					if (dbcode == 46) {
						var ssservices = [];
						ssservices.push({courierservicename:$('#serviceslabel_select').val()});
						/*ssservices = $filter('filter')($scope.courServices, {
									"courierservicecode": courierServices.selectedServices
								}, true);*/
						requestArray['courierservicename'] = ssservices[0].courierservicename;
					} else {
						requestArray['courierservicename'] = $('#serviceslabel_select').val();
					}
					// requestArray['courierservicename'] = $('#courierServiceID').find(':selected').text();
					requestArray['numberoflabels'] = 1;
				}
				
				requestArray['packagingtype'] = '';
				requestArray['callFunction'] = "printDocumentsBulk";
				$('.traditional').removeClass('whirl');
				$.ajax({
					type: 'POST',
					url: app_base_url + 'orders/printLabelapi.php',
					async: true,
					cache: true,
					data: {request: requestArray},
					dataType: 'json',
					success: function (res) {
						$('.traditional').removeClass('whirl');
						if(res.status){
							var data = res.data;
							$('.printinvoiceapi_data').html(data.view);
							$('#printinvoiceapi').modal('show');
						}
					}
				});
			}
		}
	}
	
	X247Invoices.loadJS = function(file, methodName, data, type) {
		var script = document.createElement("script");
		script.type = "text/javascript";

		if (script.readyState) {
			script.onreadystatechange = function () {
				if (script.readyState == "loaded" || script.readyState == "complete") {
					script.onreadystatechange = null;
					if(type) {
					  window[methodName](data, type);
					}
					else {
					  window[methodName](data);
					}
					
				}
			}
		} else {
			script.onload = function () {
				if(type) {
				  window[methodName](data, type);
				}
				else {
				  window[methodName](data);
				}
			}
		}

		script.src = file;
		document.body.appendChild(script);
	}
	
	
	return root.X247Invoices;

}));