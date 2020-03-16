(function(root, factory) {
	if(typeof define === 'function' && define.amd) {
		define(['jquery'], function($) {
			root.X247Orders = factory(root, $);
		})
	}
	else {
		root.X247Orders = factory(root, root,$);
	}
}(this, function(root, $) {
	root.X247Orders = {};
	var $ = jQuery;
	X247Orders['total_columns'] = '';
	X247Orders['cols_data'] = '';
	X247Orders['fullSearch'] = '';
	X247Orders['multipleItems'] = [];
	X247Orders['allOrdersData'] = [];
	X247Orders['pickupsheetprofiles'] = [];
	X247Orders['revitalpickupheet'] = [];
	X247Orders['pickupsheetcol'] = [];
	X247Orders['pickupsheetPDFData'] = [];
	X247Orders['primeOrders'] = [];
	X247Orders['noImage'] = "data:image/jpeg;base64,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AFJkICBkb3ViQG/gAAAAAAAAAAAAR3JuIGRvdWJAb+AAAAAAAAAAAABCbCAgZG91YkBv4AAAAAAAAAAAAEJyZFRVbnRGI1JsdAAAAAAAAAAAAAAAAEJsZCBVbnRGI1JsdAAAAAAAAAAAAAAAAFJzbHRVbnRGI1B4bEBSAAAAAAAAAAAACnZlY3RvckRhdGFib29sAQAAAABQZ1BzZW51bQAAAABQZ1BzAAAAAFBnUEMAAAAATGVmdFVudEYjUmx0AAAAAAAAAAAAAAAAVG9wIFVudEYjUmx0AAAAAAAAAAAAAAAAU2NsIFVudEYjUHJjQFkAAAAAAAAAAAAQY3JvcFdoZW5QcmludGluZ2Jvb2wAAAAADmNyb3BSZWN0Qm90dG9tbG9uZwAAAAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAEASAAAAAEAAThCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAHjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAThCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAADhCSU0EAgAAAAAAAgAAOEJJTQQwAAAAAAABAQA4QklNBC0AAAAAAAYAAQAAAAI4QklNBAgAAAAAABAAAAABAAACQAAAAkAAAAAAOEJJTQQeAAAAAAAEAAAAADhCSU0EGgAAAAADWwAAAAYAAAAAAAAAAAAAAEsAAABLAAAAEwBOAG8ALQBJAG0AYQBnAGUALQBBAHYAYQBpAGwAYQBiAGwAZQAxAAAAAQAAAAAAAAAA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OjMwIiBkYzpmb3JtYXQ9ImltYWdlL2pwZWciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4MTAyNjNhZi1hNDlmLWQwNDUtYTI2NC1lOTA0MzJmMzE5YWIiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDo4YzhmZDI4MS0zZDAzLTA1NGItOTg2NC01ZjUyOWMzMzZlZjgiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDplMzFkNjNjZi04ZjYyLWQ2NGMtOTdiYi04Y2Y2ZGVjNTBjOWUiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmUzMWQ2M2NmLThmNjItZDY0Yy05N2JiLThjZjZkZWM1MGM5ZSIgc3RFdnQ6d2hlbj0iMjAxOS0xMi0xOFQxMjoyNjo0OCswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTggKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjb252ZXJ0ZWQiIHN0RXZ0OnBhcmFtZXRlcnM9ImZyb20gaW1hZ2UvcG5nIHRvIGltYWdlL2pwZWciLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjgxMDI2M2FmLWE0OWYtZDA0NS1hMjY0LWU5MDQzMmYzMTlhYiIgc3RFdnQ6d2hlbj0iMjAxOS0xMi0xOFQxMjoyOCswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTggKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSJ3Ij8+/+IMWElDQ19QUk9GSUxFAAEBAAAMSExpbm8CEAAAbW50clJHQiBYWVogB84AAgAJAAYAMQAAYWNzcE1TRlQAAAAASUVDIHNSR0IAAAAAAAAAAAAAAAEAAPbWAAEAAAAA0y1IUCAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARY3BydAAAAVAAAAAzZGVzYwAAAYQAAABsd3RwdAAAAfAAAAAUYmtwdAAAAgQAAAAUclhZWgAAAhgAAAAUZ1hZWgAAAiwAAAAUYlhZWgAAAkAAAAAUZG1uZAAAAlQAAABwZG1kZAAAAsQAAACIdnVlZAAAA0wAAACGdmlldwAAA9QAAAAkbHVtaQAAA/gAAAAUbWVhcwAABAwAAAAkdGVjaAAABDAAAAAMclRSQwAABDwAAAgMZ1RSQwAABDwAAAgMYlRSQwAABDwAAAgMdGV4dAAAAABDb3B5cmlnaHQgKGMpIDE5OTggSGV3bGV0dC1QYWNrYXJkIENvbXBhbnkAAGRlc2MAAAAAAAAAEnNSR0IgSUVDNjE5NjYtMi4xAAAAAAAAAAAAAAASc1JHQiBJRUM2MTk2Ni0yLjEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAADzUQABAAAAARbMWFlaIAAAAAAAAAAAAAAAAAAAAABYWVogAAAAAAAAb6IAADj1AAADkFhZWiAAAAAAAABimQAAt4UAABjaWFlaIAAAAAAAACSgAAAPhAAAts9kZXNjAAAAAAAAABZJRUMgaHR0cDovL3d3dy5pZWMuY2gA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";



	X247Orders.change_limit = function(value){
		var limit_array = [50,100,250,500,650];
		var final_html = '<div class="dataTables_paginate paging_simple_numbers" id="aspect_adoptions_paginate" ><span>';
		for(var i=0;i<limit_array.length;i++){
			var selected = '';
			if(limit_array[i] == value){
				selected = 'current';
			}
			final_html += '<a class="paginate_button limit_change '+selected+'" onClick="X247Orders.change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="traffic_promotion">'+limit_array[i]+'</a>';
		}
		final_html += '</span></div>';
		return final_html;
	}
	
	X247Orders.order_settings = function(id,url){
		jsonObj = [];
		check = 1;
		jQuery('#'+id).modal('hide');
		jQuery('.traditional').addClass('whirl');
		jQuery('#sortable1 li').each(function(i){
			item = {}
			item ["name"] = jQuery(this).attr('name');
			item ["val"] = jQuery(this).attr('id');
			item ["pos"] = check;
			check++;
			jsonObj.push(item);
		});
		jQuery.ajax({
			type: 'POST',
			url: app_base_url + url,
			async: true,
			cache: true,
			data: {'tabcols':JSON.stringify(jsonObj)},
			dataType: 'json',
			success: function (res) {
				jQuery('.traditional').removeClass('whirl');
				if(res.status){
					location.reload(true);
				}else{
					console.log(res);
				}
			}
		});
	}
	X247Orders.change_limit_data = function(limit){
		$('.traditional').addClass('whirl');
		var ordersevcice = $('#ordersevcice').val();
		var shippingservicecodes = $('#shippingsevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var accountcodes = $('#accountservice').val();
		var itemtype = $('#itemorderservice').val();
		var numberofdays = $('#datesevcice').val();
		var supplier = $('#supplierservice').val();
		if(numberofdays == "CDate"){
			var fromDate = $('#custom_start').val();
			var toDate = $('#custom_end').val();
		}else{
			var fromDate = "";
			var toDate = "";
		}
		if(X247Orders.fullSearch == "Yes"){
			var column = $('body #accountSearch').val();
			var data = $('body #txtSearch').val();
			var pSearchByStage = $('body #pSearchByStage').val();
			var searchData = column+"|||||"+data+"|||||"+pSearchByStage;
			var jsonData = {cols_data:JSON.stringify(X247Orders.cols_data),searchData:searchData,orderstages:ordersevcice,shippingservicecodes:shippingservicecodes,shippingcountrycodes:shippingcountrycodes,accountcodes:accountcodes,numberofdays:numberofdays,fromDate:fromDate,toDate:toDate,itemtype:itemtype,supplier:supplier};
		}else{
			var jsonData = {cols_data:JSON.stringify(X247Orders.cols_data),orderstages:ordersevcice,shippingservicecodes:shippingservicecodes,shippingcountrycodes:shippingcountrycodes,accountcodes:accountcodes,numberofdays:numberofdays,fromDate:fromDate,toDate:toDate,itemtype:itemtype,supplier:supplier};
		}
		$('#order_dashboard').DataTable({
			destroy: true,
			"cache": false,
			fixedHeader: {
				header: true
			},
			columnDefs: [
				{ targets: 'no-sort', orderable: false }
			],
			"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
			info:false,
			"pageLength": limit,
			"language":{
				"lengthMenu": X247Orders.change_limit(limit)
			},
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": app_base_url+"orders/scripts/order_dashboard_processing.php",
				"type": "POST",
				"data":jsonData,
				dataFilter: function(data){
					var json = $.parseJSON( data );
					X247Orders.multipleItems = json.multipleItems;
					X247Orders.allOrdersData = json.allOrdersData;
					X247Orders.primeOrders = json.primeOrders;
					$('#recordsTotal').text(json.recordsTotal);
					$('#singleordercount').text(json.singleordercount);
					$('#multipleordercount').text(json.multipleordercount);
					$('#totalitem').text(json.totalitem);
					$('#totalitemquantity').text(json.totalitemquantity);
					return data;
				},
			},initComplete: function() {
				$('.traditional').removeClass('whirl');
			}
		});
		var table = $('#order_dashboard').DataTable();
		$('body').on( 'click','#aSearch', function () {
			X247Orders.fullSearch = "Yes";
			var column = $('body #accountSearch').val();
			var data = $('body #txtSearch').val();
			var pSearchByStage = $('body #pSearchByStage').val();
			var text_data = column+"|||||"+data+"|||||"+pSearchByStage;
			table.search(text_data).draw();
		});
		$('.dataTables_filter').hide();
		$('.container-fluid').show();
	}
	$('body').on('click','#btnApplyFilter',function(){
		X247Orders.fullSearch = "";
		$('#txtSearch').val('');
		var limit = $(".limit_change.current:first").text();
		X247Orders.change_limit_data(limit);
	});
	$('body').on('click','#btnResetFilter',function(){
		$('#txtSearch').val('');
		$('#ordersevcice').val('');
		$('#shippingsevcice').val('');
		$('#countrysevcice').val('');
		$('#accountservice').val('');
		$('#datesevcice').val('All');
		$('#supplierservice').val('');
		$('#itemorderservice').val('0');
		$("#countrysevcice").multiselect('refresh');
		$("#accountservice").multiselect('refresh');
		$("#shippingsevcice").multiselect('refresh');
		$("#ordersevcice").multiselect('refresh');
		$("#supplierservice").multiselect('refresh');
		//$('#apply_filter').reset();
		var limit = $(".limit_change.current:first").text();
		X247Orders.change_limit_data(limit);
		X247Orders.fullSearch = "";
	});
	
	$('body').on('submit','#fullSearch',function(e){
		e.preventDefault();
		X247Orders.fullSearch = "Yes";
		$('#shippingsevcice').val('');
		$('#countrysevcice').val('');
		$('#accountservice').val('');
		$('#datesevcice').val('All');
		$('#supplierservice').val('');
		$('#itemorderservice').val('0');
		$("#countrysevcice").multiselect('refresh');
		$("#accountservice").multiselect('refresh');
		$("#shippingsevcice").multiselect('refresh');
		$("#supplierservice").multiselect('refresh');
		//$('#apply_filter').reset();
		var limit = $(".limit_change.current:first").text();
		X247Orders.change_limit_data(limit);
	});
	
	X247Orders.check_val_exist = function(arr,val){
		var status = false;
		$.each(arr,function(k,v){
			if(v.name == val){
				status = true;
				return true;
			}
		});
		return status;
	}
	X247Orders.load_filters = function(filter_url){
		var ordersevcice = $('#ordersevcice').val();
		var shippingservicecodes = $('#shippingsevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var accountcodes = $('#accountservice').val();
		var itemtype = $('#itemorderservice').val();
		var numberofdays = $('#datesevcice').val();
		var supplier = $('#supplierservice').val();
		if(numberofdays == "CDate"){
			var fromDate = $('#custom_start').val();
			var toDate = $('#custom_end').val();
		}else{
			var fromDate = "";
			var toDate = "";
		}
		$.ajax({
			type: 'POST',
			url: app_base_url + filter_url,
			//dataType: 'json',
			data:{orderstages:ordersevcice,shippingservicecodes:shippingservicecodes,shippingcountrycodes:shippingcountrycodes,accountcodes:accountcodes,numberofdays:numberofdays,fromDate:fromDate,toDate:toDate,itemtype:itemtype,supplier:supplier},
			success: function (res) {
				var res = JSON.parse(res);
				res = res.data;
				var shipping = res.shipping;
				var shippingcountries = res.shippingcountries;
				var marketplacedetails = res.marketplacedetails;
				
				var shippingsevcice = "";
				$.each(shipping,function(k,v){
					if(v.shippingservicename != ""){
						shippingsevcice += "<option value='"+v.shippingservicename+"'>"+v.shippingservicename+"</option>";
					}
				});
				
				var countrysevcice = "";
				$.each(shippingcountries,function(k,v){
					if(v.code != ""){
						countrysevcice += "<option value='"+v.code+"'>"+v.name+"</option>";
					}
				});
				
				var accountservice = "";
				$.each(marketplacedetails,function(k,v){
					if(v.accoutcode != ""){
						accountservice += "<option value='"+v.accoutcode+"'>"+v.accoutname+"</option>";
					}
				});
				
				$('#shippingsevcice').html(shippingsevcice);
				$('#countrysevcice').html(countrysevcice);
				$('#accountservice').html(accountservice);
				
				$('#countrysevcice').multiselect({includeSelectAllOption: true});
				$('#accountservice').multiselect({includeSelectAllOption: true});
				$('#shippingsevcice').multiselect({includeSelectAllOption: true});
			}
		});
	}

	X247Orders.main_data = function(main_url,columns_url,table_id){
		
		var ordersevcice = $('#ordersevcice').val();
		var shippingservicecodes = $('#shippingsevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var shippingcountrycodes = $('#countrysevcice').val();
		var accountcodes = $('#accountservice').val();
		var itemtype = $('#itemorderservice').val();
		var numberofdays = $('#datesevcice').val();
		var supplier = $('#supplierservice').val();
		if(numberofdays == "CDate"){
			var fromDate = $('#custom_start').val();
			var toDate = $('#custom_end').val();
		}else{
			var fromDate = "";
			var toDate = "";
		}
		
		$('body #'+table_id+" tbody").html('');
		$('body #'+table_id+" #table_columns").html('');
		$('body #'+table_id+" #table_data_rows").html('');
		X247Orders.multipleItems = [];
		$.ajax({
			type: 'POST',
			url: app_base_url + columns_url,
			//dataType: 'json',
			//data:{marketplacecode:marketplacecode},
			success: function (res) {
				var response = JSON.parse(res);
				var settings_inputboxes = "";
				var sortable1 = "";
				X247Orders.total_columns = response.total_columns;
				if($.isEmptyObject(response.column_details)){
					X247Orders.cols_data = response.total_columns;
				}else{
					X247Orders.cols_data = response.column_details;
				}
				if(X247Orders.cols_data != ""){
					var table_columns = '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
					table_columns += '<th class="no-sort">&nbsp;</th>';
					$.each(X247Orders.cols_data,function(k,v){
						table_columns += '<th>'+v.name+'</th>';
					});
					$('body #table_columns').append(table_columns);
				}
				if(X247Orders.cols_data.length == X247Orders.total_columns.length){
					$('#check_all').prop('checked',true);
				}
				$.each(X247Orders.total_columns,function(i,v){
					var checked = X247Orders.check_val_exist(X247Orders.cols_data,v.name);
					if(checked){
						var checked = "checked";
						sortable1 += '<li class="ui-state-default" name="'+v.name+'" id="'+v.val+'">'+v.name+'</li>';
					}else{
						var checked = "";
					}
					if(v.name == "SKU"){
						var disabled = "disabled checked";
					}else{
						var disabled = "";
					}
									
					settings_inputboxes += '<label class="checkbox-inline c-checkbox col-xs-3 dynamic_li" style="">';
					settings_inputboxes +=	'<input name="selectedCols[]" '+disabled+' '+checked+' value="'+v.name+'" onchange="checkAllSortableSingle(this)" type="checkbox" id="'+v.val+'"> <span class="fa fa-check"></span>'+v.name;
					settings_inputboxes +=	'</label>';
				});
				$('.dynamic_li').remove();
				$('#sortable1').html('');
				$('#settings_inputboxes').append(settings_inputboxes);
				$('#sortable1').append(sortable1);
				$('#'+table_id).DataTable({
					//destroy,
					//"cache": false,
					fixedHeader: {
						header: true
					},
					columnDefs: [
						{ targets: 'no-sort', orderable: false }
					],
					"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
					//info:false,
					"pageLength": 100,
					"language":{
						"lengthMenu": X247Orders.change_limit(100)
					},
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": app_base_url+main_url,
						"type": "POST",
						"data":{cols_data:JSON.stringify(X247Orders.cols_data),orderstages:ordersevcice,shippingservicecodes:shippingservicecodes,shippingcountrycodes:shippingcountrycodes,accountcodes:accountcodes,numberofdays:numberofdays,fromDate:fromDate,toDate:toDate,itemtype:itemtype,supplier:supplier},
						dataFilter: function(data){
							var json = $.parseJSON( data );
							X247Orders.multipleItems = json.multipleItems;
							X247Orders.allOrdersData = json.allOrdersData;
							X247Orders.primeOrders = json.primeOrders;
							$('#recordsTotal').text(json.recordsTotal);
							$('#singleordercount').text(json.singleordercount);
							$('#multipleordercount').text(json.multipleordercount);
							$('#totalitem').text(json.totalitem);
							$('#totalitemquantity').text(json.totalitemquantity);
							return data;
						},
					},initComplete: function() {
						$('.traditional').removeClass('whirl');
					}
				});

				var table = $('#'+table_id).DataTable();
				$('body').on( 'click','#aSearch', function () {
					X247Orders.fullSearch = "Yes";
					var column = $('body #accountSearch').val();
					var data = $('body #txtSearch').val();
					var pSearchByStage = $('body #pSearchByStage').val();
					var text_data = column+"|||||"+data+"|||||"+pSearchByStage;
					table.search(text_data).draw();
				});
				$('.dataTables_filter').hide();
				
			}
		});
	}
	
	$('body').on('click','.expand_tr',function(){
		var orderId = $(this).data('order-id');
		var table_columns = '<th>Source</th>';
		table_columns += '<th>Order Id</th>';
		table_columns += '<th>Item Sku</th>';
		table_columns += '<th>Product Title</th>';
		table_columns += '<th>Qty Ordered</th>';
		table_columns += '<th>Unit Price</th>';
		table_columns += '<th>Total Price</th>';
		table_columns += '<th>Shipping Price</th>';
		table_columns += '<th>Order Note</th>';
		table_columns += '<th>Shipping Services</th>';
		var length = X247Orders.cols_data.length;
		
		var mergeordercheck = orderId[0]+orderId[1];
		if(X247Orders.multipleItems != ""){
			var multipleItems = X247Orders.multipleItems[orderId];
			if($(this).hasClass('expand_true') == true){
				$(this).closest('tr').next().remove();
				$(this).removeClass('expand_true');
				$(this).removeClass('fa-minus');
			}else{
				var tr_data = "";
				$.each(multipleItems,function(k,v){
					var shippingPrice = 0.0;
					if(v.ShippingPrice != '' && v.ShippingPrice != null && v.ShippingPrice >= 0){
						shippingPrice = v.ShippingPrice;
					}
					if(mergeordercheck == "M-"){
						orderId = v.childOrder;
					}
					tr_data += "<tr>";
						tr_data += "<td>"+multipleItems[0].source+"</td>";
						tr_data += "<td>"+orderId+"</td>";
						tr_data += "<td>"+v.Sku+"</td>";
						tr_data += "<td>"+v.ProductTitle+"</td>";
						tr_data += "<td>"+v.Quantity+"</td>";
						tr_data += "<td>£ "+v.UnitPrice+"</td>";
						tr_data += "<td>£ "+v.TotalPrice+"</td>";
						tr_data += "<td>£ "+shippingPrice+"</td>";
						tr_data += "<td></td>";
						tr_data += "<td>"+v.ShippingService+"</td>";
					tr_data += "</tr>";
				});
				$(this).addClass('expand_true');
				$(this).addClass('fa-minus');
				var table_data = "<tr style='background-color: #f5f7fa;'><td colspan='"+(length+2)+"'><label class='col-sm-3 attributes no-padding-right'><strong>Order item details:</strong></label><table style='background-color: #f5f7fa;' class='table table-striped table-bordered table-hover'><thead><tr>"+table_columns+"</tr></thead><tbody>"+tr_data+"</tbody></table></td></tr>";
						$(table_data).insertAfter($(this).closest('tr'));
			}
		}
	});
	X247Orders.sortable_s = function(id){
	   $("#"+id).sortable();
	   $("#"+id).disableSelection();
	   var selected = 0;

	   var itemlist = $('#'+id);
	   var len = $(itemlist).children().length;

	   $("#"+id+" li").click(function () {
	      selected = $(this).index();
	      if ($("#"+id+" li").hasClass('select')) {
	          $("#"+id+" li").removeClass('select');
	          $(this).addClass("select");
	      } else {
	          $(this).addClass("select");
	      }

	   });
	}
	
	/* print picking list of selected orders*/

	$('body').on("click", "#print_picking_list_fixed", function( e) {
		X247Orders.getPickUpList();
	});
	
	X247Orders.getPickUpList = function(){
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			var chkArray = [];
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$(".order_checkbox:checked").each(function() {
				chkArray.push($(this).val());
			});
			var jsonString = JSON.stringify(chkArray);
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/getorderpickupsheet.php',
				async: true,
				cache: true,
				data: {orders:jsonString},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					var data = res.data;
					var pickupsheets = data.pickupsheets;
					X247Orders.revitalpickupheet = data;
					var pickupsheets_select = '';
					$.each( pickupsheets, function( key, val ) {
						pickupsheets_select += "<option value="+val.pickupsheetprofilename+">"+val.pickupsheetprofileid+"</option>";
					});
					$('#pickupSheetSelect').append(pickupsheets_select);
					$('#pickupList').modal('show');
				}
			});
		}else{
			alert("Please select anyone order");
		}
	}

    X247Orders.getAllPickingList = function () {
        $.ajax({
				type: 'GET',
				url: app_base_url + 'orders/GetPickupSheetProfile.php',
				async: true,
				cache: true,
				//data: {orders:jsonString,pickupsheetprofileid:pickupsheetprofileid},
				dataType: 'json',
				success: function (res) {
					X247Orders.pickupsheetprofiles = res.data;
				}
			});
	}
	X247Orders.getAllPickingList();

	$('body').on("submit", ".pickupListPrint", function( e) {
		e.preventDefault();
		
		X247Orders.pickupsheetcol = [];
		X247Orders.pickupsheetPDFData = [];
		$('#pickupsheetprint').html("");
	
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			$('#pickupList').modal('hide');
			var chkArray = [];
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$(".order_checkbox:checked").each(function() {
				
				if($(this).attr('data-multiple-orders') == "Yes"){
					var multipleItems = X247Orders.multipleItems[$(this).val()];
					$.each(multipleItems,function(k,v){
						chkArray.push(v.Sku);
					});
				}else{
					chkArray.push($(this).data("sku"));
				}
			});
			var jsonString = JSON.stringify(chkArray);
			var pickupsheetprofileid = $('#pickupSheetSelect').val();
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/printpickupsheet.php',
				async: true,
				cache: true,
				data: {orders:jsonString,pickupsheetprofileid:pickupsheetprofileid},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res.status){

						//#region Generate Pickupsheet PDF with AJS
						var res6 = alasql('select * from ? where pickupsheetprofilecode=?', [X247Orders.pickupsheetprofiles, pickupsheetprofileid]);
						
						var columnstring = '';
						$.each(res6[0].pickupsheetprofiledetails, function (keycol,valuecol) {
							if (valuecol.columnname === 'SKU') {
								X247Orders.pickupsheetcol.push('sku');
								columnstring += 'sku' + ',';
							}
							else if (valuecol.columnname === 'Description') {
								X247Orders.pickupsheetcol.push('productname');
								columnstring += 'productname' + ',';
							}
							else if (valuecol.columnname === 'OrderQuantity') {
								X247Orders.pickupsheetcol.push('quantitytopick');
								columnstring += 'quantitytopick' + ',';
							}
							else if (valuecol.columnname === 'EAN') {
								X247Orders.pickupsheetcol.push('ean');
								columnstring += 'ean' + ',';
							}
							else if (valuecol.columnname === 'BinLocation') {
								X247Orders.pickupsheetcol.push('binlocationid');
								columnstring += 'binlocationid' + ',';
							}
							else if (valuecol.columnname === 'Image') {
								X247Orders.pickupsheetcol.push('imagepath');
								columnstring += 'imagepath' + ',';
							}
							else if (valuecol.columnname === 'OrderNotes') {
								X247Orders.pickupsheetcol.push('pickernotes');
								columnstring += 'pickernotes' + ',';
							}
							else if (valuecol.columnname === 'SLNO') {
								X247Orders.pickupsheetcol.push('SLNO');
								columnstring += 'SLNO' + ',';
							}
						});

						columnstring = columnstring.substring(0, columnstring.length - 1);

						var s1 = "select " + columnstring + " from ?";
						X247Orders.pickupsheetPDFData = alasql(s1, [X247Orders.revitalpickupheet.Items]);

						$.each(X247Orders.pickupsheetPDFData, function (keyimg,valueimg) {
							if (typeof valueimg.imagepath !== 'undefined' && valueimg.imagepath != null && valueimg.imagepath !== '') {
								var img = new Image();
								img.crossOrigin = 'Anonymous';
								img.onload = function () {
									var canvas = document.createElement('CANVAS');
									var ctx = canvas.getContext('2d');
									var dataURL;
									canvas.height = this.height;
									canvas.width = this.width;
									ctx.drawImage(this, 0, 0);
									dataURL = canvas.toDataURL('image/jpeg');
									$.extend(X247Orders.pickupsheetPDFData[keyimg], {
										'imagepath': dataURL
									});
									//   console.log(dataURL, 'dataURL......');
									canvas = null;

								};
								img.src = valueimg.imagepath;


							}
						});
						//FDX dbcode 45 for testing
						if (dbcode == 78) {
							var html_data = '<div id="revital-pickupsheet" style="display: none;">';
								html_data += '<div>';
								html_data += '<table id="REVPicksheet">';
									html_data += '<tbody>';
									var tr_data = "";
									$.each(revitalpickupheet.Items,function(k,aData){
										tr_data += "<tr>";
											tr_data += "<td>"+aData.quantitytopick+"</td>";
											tr_data += "<td>"+aData.sku+"</td>";
											tr_data += "<td>"+aData.stockcode+"</td>";
											tr_data += "<td>"+aData.size+"</td>";
											tr_data += "<td>"+aData.attribute+"</td>";
											tr_data += "<td>"+aData.productname+"</td>";
											tr_data += "<td>"+aData.binlocationid+"</td>";
										tr_data += "</tr>";
									});
									html_data += '</tbody>';
								html_data += '</table>';
								html_data += '</div>';
								html_data += '<table id="REVPicksheetBox"><tbody><tr><td></td></tr><tbody></table>';
							html_data += '</div>';
							$('#pickupsheetprint').html(html_data);
							X247Orders.generateRevitalPickupsheet();//need to create
						} else if (dbcode == 30) {
							var data = res.data;
							var content = '<iframe allowfullscreen="" frameborder="0" src="'+data.filepath+'"></iframe>';
							$('#iframe_content').html(content);
							$('#pickupListPreview').modal('show');
						} else {
							
							var explode = function () {
								
								var html_data = '<div id="all-pickupsheet" style="display: none;">';
								html_data += '<div>';
								html_data += '<table id="allPicksheet">';
									html_data += '<thead>';
										html_data += "<tr>";
											$.each(X247Orders.pickupsheetcol,function(k,aData){
												html_data += "<th><div>";
													if(aData == "sku"){
														html_data += "<div>SKU</div>";
													}else if(aData == "productname"){
														html_data += "<div>Product Title</div>";
													}else if(aData == "binlocationid"){
														html_data += "<div>BinLocation</div>";
													}else if(aData == "imagepath"){
														html_data += "<div>Image</div>";
													}else if(aData == "quantitytopick"){
														html_data += "<div>Order Qty</div>";
													}else if(aData == "pickernotes"){
														html_data += "<div>OrderNotes</div>";
													}else if(aData == "SLNO"){
														html_data += "<label>SLNO</label>";
													}
												html_data += "</div></th>";
											});
										html_data += '</tr>';
									html_data += '</thead>';
									var slno = 1;
									$.each(X247Orders.pickupsheetPDFData,function(pk,pData){
										html_data += '<tbody>';
											html_data += "<tr>";
												$.each(X247Orders.pickupsheetcol,function(k,aData){
													html_data += "<td><div>";
														if(aData == "imagepath"){
															html_data += "<div>Test</div>";
														}else if(aData == "SLNO"){
															html_data += "<div>"+slno+"</div>";
														}else{
															html_data += "<div>"+slno+"</div>";
														}
													html_data += "</div>"+pData[aData]+"</td>";
												});
											html_data += '</tr>';
										html_data += '</tbody>';
									});
								html_data += '</table>';
								html_data += '</div>';
								html_data += '<table id="allPicksheetBox"><tbody><tr><td></td></tr><tbody></table>';
								html_data += '</div>';
								$('#pickupsheetprint').html(html_data);
							
								X247Orders.generatePickupsheet();//Need to create
							};
							setTimeout(explode, 5000);
						}
					}else{
						alert(res.msg);
					}
				}
			});
		}else{
			alert("Please select anyone order");
		}
	});
	
	X247Orders.generateRevitalPickupsheet = function () {
        var doc = new jsPDF('p', 'pt');
        doc.setLineWidth(0.1);

        var billingid = "REVPicksheet";
        var billingres = '';
		
		var hcOrderBoxid = "REVPicksheetBox";
        var hcOrderBoxres = '';

        doc.setFontType("normal");
        doc.setFontSize(15);

            var alignFillDate = new Date();
            var currentDateTime = moment(alignFillDate).format('dd MMM yyyy, hh:mm:ss a');

            doc.text(currentDateTime, 30, 45);
            doc.text("Order-combined Picklist", 215, 45);

            doc.setLineWidth(2.5);
            doc.setDrawColor(18, 168, 157);
            doc.line(20, 66, 575, 66);


            doc.setFontType("normal");
            doc.setFontSize(12);

            doc.text("Qty", 25, 83);
            doc.text("SKU", 55, 83);
            doc.text("Stock Code", 135, 83);
            doc.text("Size", 215, 83);
            doc.text("Attr", 290, 83);
            doc.text("Name", 365, 83);
            doc.text("Bin Rack", 520, 83);

            doc.setLineWidth(0.5);
            doc.setDrawColor(18, 168, 157);
            // doc.setDrawColor(136, 193, 187);
            doc.line(20, 93, 575, 93);


            // #region Adding Billing Address  

            var yposordergrid = doc.autoTableEndPosY() + 30;

            var billingElementID = document.getElementById(billingid);
            if (billingElementID === null || billingElementID === undefined || billingElementID === '') {

            } else {
                billingres = doc.autoTableHtmlToJson(document.getElementById(billingid));

                var shippingoptions = {
                    margin: {
                        left: 20
                    },
                    startY: 110,
                    pageBreak: 'auto',
                    theme: 'plain',
                    styles: {
                        rowHeight: 15,
                        overflow: 'linebreak'
                    }, headerStyles: {
                        fillColor: [255, 255, 255],
                        fontSize: 10,
                        textColor: [0, 0, 0],
                        fontStyle: 'normal',
                    },
                    bodyStyles: {
                        fillColor: [255, 255, 255],
                        textColor: [0, 0, 0]
                    },
                    columnStyles: {
                        0: {
                            columnWidth: 30
                        },
                        1: {
                            columnWidth: 80
                        },
                        2: {
                            columnWidth: 80
                        },
                        3: {
                            columnWidth: 75
                        },
                        4: {
                            columnWidth: 75
                        },
                        5: {
                            columnWidth: 155
                        },
                        6: {
                            columnWidth: 65
                        }
                    }
                };

                doc.autoTable(billingres.columns, billingres.data, shippingoptions);
            }

            // #endregion Adding Billing Address

            var itemgridendpos = doc.autoTableEndPosY() + 10;

            var returnElementID = document.getElementById(hcOrderBoxid);
            if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

            } else {
                hcOrderBoxres = doc.autoTableHtmlToJson(document.getElementById(hcOrderBoxid));
                doc.autoTable(hcOrderBoxres.columns, hcOrderBoxres.data, {
                    margin: {
                        left: 365
                    },
                    startY: itemgridendpos + 15,
                    theme: 'plain',
                    styles: {
                        fillStyle: 'DF',
                        lineColor: [244, 128, 36],
                        lineWidth: 1.5,
                        overflow: 'linebreak',
                        rowHeight: 60,
                        fontSize: 8
                    }
                });

                doc.setFontType("normal");
                doc.setFontSize(12);

                doc.setDrawColor(0);
                doc.rect(402, itemgridendpos + 27, 8, 8);

                if (typeof X247Orders.revitalpickupheet.countofskus != undefined) {
                    doc.text(X247Orders.revitalpickupheet.countofskus + ' Items', 420, itemgridendpos + 35);
                } else {
                    doc.text(' Items');
                }

                if (typeof X247Orders.revitalpickupheet.countoforders != undefined) {
                    doc.text(X247Orders.revitalpickupheet.countoforders + ' Orders', 420, itemgridendpos + 55);
                } else {
                    doc.text(' Orders');
                }



                // returuncenteredText("To return something to us, please enter one of the below return codes into the 'Code / Qty' column above,", itemgridendpos + 30);
            }


        var blob = doc.output("blob");
        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveOrOpenBlob(blob);
        }
        else {
            var objectUrl = URL.createObjectURL(blob);
                window.open(objectUrl, "_blank");
        }
    }
	
	X247Orders.generatePickupsheet = function () {
            var doc = new jsPDF('p', 'pt');
            doc.setLineWidth(0.1);

            var billingid = "allPicksheet";
            var billingres = '';

            var hcOrderBoxid = "allPicksheetBox";
            var hcOrderBoxres = '';

            doc.setFontType("normal");
            doc.setFontSize(15);

            var alignFillDate = new Date();
            var currentDateTime = moment(alignFillDate).format('dd MMM yyyy, hh:mm:ss a');


            // #region Adding Billing Address

            doc.text(currentDateTime, 30, 42);
            doc.text("Order-combined Picklist", 215, 42);

            doc.setLineWidth(2.5);
            doc.setDrawColor(18, 168, 157);
            doc.line(20, 54, 575, 54);

            var yposordergrid = doc.autoTableEndPosY() + 30;

            var billingElementID = document.getElementById(billingid);
            if (billingElementID === null || billingElementID === undefined || billingElementID === '') {

            } else {
                billingres = doc.autoTableHtmlToJson(document.getElementById(billingid));
                var images = [];
                var shippingoptions = {
                    margin: {
                        left: 20
                    },
                    startY: 58,
                    pageBreak: 'auto',
                    theme: 'plain',
                    styles: {
                        rowHeight: 18,
                        overflow: 'linebreak',
                        fontSize: 10
                    }, headerStyles: {
                        fillColor: [255, 255, 255],
                        fontSize: 12,
                        textColor: [0, 0, 0],
                        fontStyle: 'normal',
                        rowHeight: 30,
                    },
                    bodyStyles: {
                        fillColor: [255, 255, 255],
                        textColor: [0, 0, 0]
                    },
                    drawCell: function (cell, opts) {
                        if (cell.raw === 'Test') {
                            if (typeof X247Orders.pickupsheetPDFData[opts.row.index].imagepath !== 'undefined' && X247Orders.pickupsheetPDFData[opts.row.index].imagepath !== '') {
                                images.push({
                                    elem: X247Orders.pickupsheetPDFData[opts.row.index].imagepath,
                                    x: cell.x,
                                    y: cell.y
                                });
                            } else {
                                images.push({
                                    elem: X247Orders.noImage,
                                    x: cell.x,
                                    y: cell.y
                                });
                            }
                        }
                    },
                    afterPageContent: function (data) {
                        if (data.pageCount == 1) {
                            doc.setLineWidth(0.7);
                            doc.setDrawColor(18, 168, 157);
                            doc.line(20, 81, 575, 81);
                        } else {

                            doc.setLineWidth(2.5);
                            doc.setDrawColor(18, 168, 157);
                            doc.line(20, 34, 575, 34);

                            doc.setLineWidth(0.7);
                            doc.setDrawColor(18, 168, 157);
                            doc.line(20, 61, 575, 61);
                        }
                        for (var i = 0; i < images.length; i++) {
                            if (images[i].elem !== '') {
                                doc.addImage(images[i].elem, 'jpeg', images[i].x, images[i].y, 30, 30);
                            }
                        }
                        images = [];

                    }, drawRow: function (row, data) {
                        console.log(X247Orders.pickupsheetcol, 'pickupsheetcol');
                        for (var i = 0; i < X247Orders.pickupsheetcol.length; i++) {
                            if (X247Orders.pickupsheetcol[i] === 'imagepath') {
                                row.height = 40
                            }
                        }
                    }
                };

                doc.autoTable(billingres.columns, billingres.data, shippingoptions);
            }

            // #endregion Adding Billing Address

            //#region Items Count Value

            var itemgridendpos = doc.autoTableEndPosY() + 10;



            var returnElementID = document.getElementById(hcOrderBoxid);
            if (returnElementID === null || returnElementID === undefined || returnElementID === '') {

            } else {
                hcOrderBoxres = doc.autoTableHtmlToJson(document.getElementById(hcOrderBoxid));
                doc.autoTable(hcOrderBoxres.columns, hcOrderBoxres.data, {
                    margin: {
                        left: 365
                    },
                    startY: itemgridendpos + 15,
                    theme: 'plain',
                    styles: {
                        fillStyle: 'DF',
                        lineColor: [244, 128, 36],
                        lineWidth: 1.5,
                        overflow: 'linebreak',
                        rowHeight: 60,
                        fontSize: 8
                    }
                });

                doc.setFontType("normal");
                doc.setFontSize(12);

                doc.setDrawColor(0);
                doc.rect(402, itemgridendpos + 27, 8, 8);

                if (typeof X247Orders.revitalpickupheet.countofskus != undefined) {
                    doc.text(X247Orders.revitalpickupheet.countofskus + ' Items', 420, itemgridendpos + 35);
                } else {
                    doc.text(' Items');
                }

                if (typeof X247Orders.revitalpickupheet.countoforders != undefined) {
                    doc.text(X247Orders.revitalpickupheet.countoforders + ' Orders', 420, itemgridendpos + 55);
                } else {
                    doc.text(' Orders');
                }
            }

            //#endregion Items Count Value

            var blob = doc.output("blob");
            if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                window.navigator.msSaveOrOpenBlob(blob);
            }
            else {
                var objectUrl = URL.createObjectURL(blob);
                window.open(objectUrl, "_blank");
            }
    }

	/* Pintpickup list functionality end */
	
	/* move order Stage */
	$("body").on('click','#move_order_stage_fixed',function() {
		X247Orders.changeOrderStage();
	});
	X247Orders.changeOrderStage = function(){
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('#MoveOrderStage').modal('show');
		}else{
			alert("Please select anyone order");
		}
	}
	X247Orders.get_checked_count = function(){
		var favorite = [];
		$.each($(".order_checkbox:checked"), function(){
			favorite.push($(this).val());
		});
		return favorite;
	}
	
	$('body').on("submit", "#moveOrderStageForm", function( e) {
		e.preventDefault();
		$('#MoveOrderStage').modal('hide');
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			var chkArray = [];
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$(".order_checkbox:checked").each(function() {
				var item = {};
				item['ordernumber'] = $(this).val();
				item['accountcode'] = $(this).data('account-code');
				item['marketplacecode'] = $(this).data('market-place');
				if($(this).attr('data-multiple-orders') == "No"){
					item['orderlineitemid'] = $(this).data('order-line-item-id');
					item['qtydispatched'] = $(this).data('qty-dispatched');
					item['sku'] = $(this).data("sku");
				}else{
					item['items'] = X247Orders.multipleItems[$(this).val()];
				}
				chkArray.push(item);
			});
			var jsonString = JSON.stringify(chkArray);
			var orderstagecode = $('#moveOrderStageSelect').val();
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/moveorderstage.php',
				async: true,
				cache: true,
				data: {orders:jsonString,orderstagecode:orderstagecode},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res.status){
						alert("Order State Changed Successsfully");
						loadOrders({});
					}else{
						alert(res.msg);
					}
				}
			});
		}else{
			alert("Please select anyone order");
		}
	});
	/* move order Stage end */
	
	/* unlock of selected orders*/
	$( "body" ).on('click','#unlock_orders_fixed',function() {
		X247Orders.getAllUsers();
	});
	$('body').on("click", "#unlock_orders", function( e) {
		X247Orders.getAllUsers();
	});

	X247Orders.getAllUsers = function(){
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		//if(count>0){
			$('.traditional').addClass('whirl');
			$.ajax({
				type: 'GET',
				url: app_base_url + 'orders/allusers.php',
				async: true,
				cache: true,
				//data: {orders:jsonString},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					var data = res.data;
					var users = data.users;
					var users_select = '';
					$.each( users, function( key, val ) {
						users_select += "<option value="+val.usercode+">"+val.firstname+" "+val.lastname+"("+val.username+")</option>";
					});
					$('#unlockOrdersSelect').append(users_select);
					$('#GetAllUsers').modal('show');
				}
			});
		/*}else{
			alert("Please select anyone order");
		}*/
	}

	$('body').on("submit", ".unlockOrdersForm", function( e) {
		e.preventDefault();
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			$('#GetAllUsers').modal('hide');
			var chkArray = [];
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$("#productSKUs:checked").each(function() {
				chkArray.push($(this).attr("data-sku"));
			});
			var jsonString = JSON.stringify(chkArray);
			var usercode = $('#unlockOrdersSelect').val();
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/cancelpickupsheet.php',
				async: true,
				cache: true,
				data: {orders:jsonString,usercode:usercode},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res.status == true){
						alert("Print Pickuplist Unlocked");
						//loadOrders({});
					}else{
						alert(res.msg);
					}
				}
			});
		}else{
			alert("Please select anyone order");
		}
	});
	/* unlock of selected orders end*/
	
	/* export orders of selected orders*/
	$( "body" ).on('click','#export_orders_fixed',function() {
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		$("#ExportOrders").modal('show');
	});

	$('body').on("click", "#export_orders", function( e) {
		var favorite = get_checked_count();
		var count = favorite.length;
		$("#ExportOrders").modal('show');
	});

	$('body').on("submit", "#exportOrdersForm", function( e) {
		e.preventDefault();
		$('.traditional').addClass('whirl');
		$('#ExportOrders').modal('hide');
		$.ajax({
			type: 'POST',
			url: app_base_url + 'orders/exportorders.php',
			async: true,
			cache: true,
			data: $('#exportOrdersForm').serializeArray(),
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if(res.status == true){
					alert("Orders Exported Successfully");
					//loadOrders({});
				}else{
					alert(res.msg);
				}
			}
		});
	});
	/* export orders of selected orders end*/
	
	/* upload tracking ids of selected orders*/
	$( "body" ).on('click','#upload_tracking_ids_fixed',function() {
		X247Orders.uploadtrackingids();
	});

	X247Orders.uploadtrackingids = function(){
		$("#UploadTrackingId").modal("show");
	}

	$('body').on("submit", "#UploadTrackingIdForm", function( e) {
		e.preventDefault();
		$('.traditional').addClass('whirl');
		$('#UploadTrackingId').modal('hide');
		var filepathaws = X247Orders.SaveTrackingUploadFile();
		$('#filepathaws').val(filepathaws);
		$.ajax({
			type: 'POST',
			url: app_base_url + 'orders/uploadtrackingid.php',
			async: true,
			cache: true,
			data: $('#UploadTrackingIdForm').serializeArray(),
			dataType: 'json',
			success: function (res) {
				$('.traditional').removeClass('whirl');
				if(res.status == true){
					alert("Uploaded Trackids Successfully");
					loadOrders({});
				}else{
					alert(res.msg);
				}
			}
		});
	});

	/* upload xl file to aws bucket */
	var creds = {};

	creds = {
		// "secret_key": "XQnK2R1wGI+qAG2+1bThY1WEYD1tSxrA23eFchRC",
		// "access_key": "AKIAJ47YDGMMN7RDQCNA",
		"secret_key": "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",
		"access_key": "AKIAJ5JDAHPY47LLIJDQ",
		"bucket": "clientfileuploadsdevolopment/CustomFilesUpload",
		"region": "eu-west-1"
	};

	var fileDetails = {
		"filename": '',
		"filetype": '',
		"filesize": '',
		"fileextension": '',
		"filepath": ''
	}

	X247Orders.SaveTrackingUploadFile = function() {
		var data = document.getElementById('upload-select').files;
		var file = data;
		var filepathaws = '';

		AWS.config.update({
			accessKeyId: creds.access_key,
			secretAccessKey: creds.secret_key
		});
		AWS.config.region =creds.region;
		var bucket = new AWS.S3({
			params: {
				Bucket: creds.bucket
			}
		});

		if (file && file.length > 0) {

			var d = new Date();
			var extension = file[0].name.match(/\.(.+)$/)[1];

			var text = "";
			var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

			for (var i = 0; i < 8; i++) {
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			}


			var uniqueFileName = text + '_' + '_' + new Date().getTime().toString().substring(0, 10) + '_' + file[0].name;

			fileDetails = {
				"filename": file[0].name,
				"filetype": file[0].type,
				"filesize": file[0].size,
				"fileextension": extension,
				"filepath": 'https://s3-' + creds.region + '.amazonaws.com/' + creds.bucket + '/' + uniqueFileName
			}
			var params = {
				Key: uniqueFileName,
				ContentType: file[0].type,
				Body: file[0],
				ServerSideEncryption: 'AES256',
				ACL: 'public-read'
			};
			filepathaws = fileDetails.filepath;
			bucket.putObject(params, function (err, data) {
				if (err) {
					alert('Excel Uploaded Failure:'+err.message);
					return false;
				} else {
					setTimeout(function () {
						uploadProgress = 0;
						$digest();
					}, 1000);
				
					//$scope.importTrackingFile(fileDetails.filepath);
				}
			}).on('httpUploadProgress', function (progress) {
				uploadProgress = Math.round(progress.loaded / progress.total * 100);
			});

		} else {
			alert("Please select a file to upload");
		}
		return filepathaws;
	}
	/* upload tracking ids of selected orders end */
	
	/* Mark as shipped order*/
	$("body").on('click','#mark_shipped_fixed',function() {
		X247Orders.markShipped();
	});
	$('body').on("click", "#mark_shipped", function( e) {
		X247Orders.markShipped();
	});

	X247Orders.markShipped = function(){
		var favorite = X247Orders.get_checked_count();
		var count = favorite.length;
		if(count>0){
			$('.traditional').addClass('whirl');
			var chkArray = [];
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$(".order_checkbox:checked").each(function() {
				var item = {};
				item['ordernumber'] = $(this).val();
				item['accountcode'] = $(this).data('account-code');
				item['marketplacecode'] = $(this).data('market-place');
				if($(this).attr('data-multiple-orders') == "No"){
					item['orderlineitemid'] = $(this).data('order-line-item-id');
					item['qtydispatched'] = $(this).data('qty-dispatched');
					item['sku'] = $(this).data("sku");
				}else{
					item['items'] = X247Orders.multipleItems[$(this).val()];
				}
				chkArray.push(item);
			});
			var jsonString = JSON.stringify(chkArray);
			var orderstagecode = 11;
			$.ajax({
				type: 'POST',
				url: app_base_url + 'orders/moveorderstage.php',
				async: true,
				cache: true,
				data: {orders:jsonString,orderstagecode:orderstagecode},
				dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res && res.status){
						alert("Order State Changed Successsfully");
						loadOrders({});
					}else{
						alert(res.msg);
					}
				}
			});
		}else{
			alert("Please select anyone order");
		}
	}
	$('body').on('click','#ckbCheckAll',function(){
		$('.order_checkbox').not(this).prop('checked', this.checked);
		var numberOfChecked = $(".order_checkbox:checked").length;
		$('#selected_skus').text(numberOfChecked);
	});
	$('body').on('click','.order_checkbox',function(){
		var numberOfChecked = $(".order_checkbox:checked").length;
		$('#selected_skus').text(numberOfChecked);
	});
	$('body').on('click','#isPrime',function(){
		if($(this).prop("checked") == true){
			var rows = $('.order_checkbox');
			$.each(rows,function(i, item) {
				if($.inArray($(item).val(),X247Orders.primeOrders) == -1){
					$(item).closest('tr').addClass("hide");
				}else{
					$(item).closest('tr').removeClass("hide");
				}

			});
		}else{
			$("#table_data_rows tr").removeClass("hide");
		}
	});
	

	/* Mark as shipped order end */
	
	
	return root.X247Orders;

}));