(function(root, factory) {
	if(typeof define === 'function' && define.amd) {
		define(['jquery'], function($) {
			root.X247Inventory = factory(root, $);
		})
	}
	else {
		root.X247Inventory = factory(root, root,jQuery);
	}
}(this, function(root, $) {
	root.X247Inventory = {};
	
	X247Inventory['cols_data'] = '';
	X247Inventory['tab_columns'] = '';
	X247Inventory['total_columns'] = '';
	X247Inventory['inventory_tabs'] = '';
	X247Inventory['selected_skus'] = [];
	X247Inventory['block_skus'] = [];
	X247Inventory['flag_details'] = [];
	X247Inventory['flag_skus'] = [];
	var $ = jQuery;



	X247Inventory.change_limit = function(value){
		var limit_array = [10,25,50,100];
		var final_html = '<div class="dataTables_paginate paging_simple_numbers" id="aspect_adoptions_paginate" ><span>';
		for(var i=0;i<limit_array.length;i++){
			var selected = '';
			if(limit_array[i] == value){
				selected = 'current';
			}
			final_html += '<a class="paginate_button limit_change '+selected+'" onClick="X247Inventory.change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="traffic_promotion">'+limit_array[i]+'</a>';
		}
		final_html += '</span></div>';
		return final_html;
	}


	X247Inventory.change_limit_data = function(limit){
		jQuery('.traditional').addClass('whirl');
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		var key = X247Inventory.get_table_column_urls(marketplacecode,X247Inventory.tab_columns);
		if(marketplacecode == "1"){
			var fkaccountcode = $('#eBayaccount').val();
		}else if(marketplacecode == "2"){
			var fkaccountcode = $('#amzaccount').val();
		}else if(marketplacecode == "101"){
			var fkaccountcode = $('#gameaccount').val();
		}else if(marketplacecode == "9"){
			var fkaccountcode = $('#cdiscountaccount').val();
		}else if(marketplacecode == "3"){
			var fkaccountcode = $('#webstoreaccount').val();
		}else if(marketplacecode == "21"){
			var fkaccountcode = $('#skucloudaccount').val();
		}else if(marketplacecode == "20"){
			var fkaccountcode = $('#onbuyaccount').val();
		}else if(marketplacecode == "7"){
			var fkaccountcode = $('#rakutenaccount').val();
		}else if(marketplacecode == "13"){
			var fkaccountcode = $('#abebooksaccount').val();
		}else if(marketplacecode == "15"){
			var fkaccountcode = $('#shopifyaccount').val();
		}else if(marketplacecode == "22"){
			var fkaccountcode = $('#frugoaccount').val();
		}else if(marketplacecode == "8"){
			var fkaccountcode = $('#trademeaccount').val();
		}else{
			var fkaccountcode =0;
		}
		if(fkaccountcode == ""){
			fkaccountcode = 0;
		}
		
		var template = "";
		if(key >= 0){
			if(typeof(X247Inventory.tab_columns[key]['table_template']) != undefined){
				template = X247Inventory.tab_columns[key]['table_template'];
			}else{
				template = "scripts/alltabs_table_data.php";
			}
		}
		jQuery('#inventory_dashboard').DataTable({
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
				"lengthMenu": X247Inventory.change_limit(limit)
			},
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": app_base_url + template,
				"type": "POST",
				"data":{cols_data:JSON.stringify(X247Inventory.cols_data),fkaccountcode:fkaccountcode,marketplacecode:marketplacecode,search:{value:jQuery('#txtSearch').val()}},
			},
		});
		var table = jQuery('#inventory_dashboard').DataTable();
		jQuery('body').on( 'click','#aSearch', function () {
			table.search(jQuery('#txtSearch').val()).draw();
		});
		jQuery('.dataTables_filter').hide();
		jQuery('.container-fluid').show();
		jQuery('.traditional').removeClass('whirl');
	}

	$('body').on('change','#amzaccount, #eBayaccount, #gameaccount, #cdiscountaccount, #webstoreaccount, #skucloudaccount, #onbuyaccount,#rakutenaccount, #abebooksaccount, #shopifyaccount, #frugoaccount, #trademeaccount',function(){
		X247Inventory.change_limit_data(10);
	})

	
	X247Inventory.settings_columns = function(original_columns,new_columns){
		
	}
	
	X247Inventory.check_val_exist = function(arr,val){
		var status = false;
		jQuery.each(arr,function(k,v){
			if(v.name == val){
				status = true;
				return true;
			}
		});
		return status;
	}


	X247Inventory.main_data = function(main_url,template,table_id){
		X247Inventory['selected_skus'] = [];
		jQuery('body #'+table_id+" tbody").html('');
		jQuery('body #'+table_id+" #table_columns").html('');
		jQuery('body #'+table_id+" #table_data_rows").html('');
		$('#inventory_buttons').html('');
		$('#inventory_search').html('');
		X247Inventory['cols_data'] = '';
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "1"){
			var fkaccountcode = $('#eBayaccount').val();
		}else if(marketplacecode == "2"){
			var fkaccountcode = $('#amzaccount').val();
		}else{
			var fkaccountcode =0;
		}
		jQuery('body .btn-inventory-dashboard').hide();
		jQuery.ajax({
			type: 'POST',
			url: app_base_url + "inventory/inventory_tabs/get_inventory_buttons.php",
			//dataType: 'json',
			data:{marketplacecode:marketplacecode},
			success: function (res) {
				$('#inventory_buttons').html(res);
			}
		});
		jQuery.ajax({
			type: 'POST',
			url: app_base_url + "inventory/inventory_tabs/get_inventory_search.php",
			//dataType: 'json',
			data:{marketplacecode:marketplacecode},
			success: function (res) {
				$('#inventory_search').html(res);
				if(marketplacecode == "2"){
					var amzaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.amazonAccounts) != "undefined"){
						var amzdata = data1.amazonAccounts.accounts;
						$.each(amzdata,function(k,v){
							amzaccount += '<option value="'+v.amzaccountcode+'" class="" >'+v.amzaccountname+'</option>'; 
						});
					}
					$('#amzaccount').html(amzaccount);
				}
				if(marketplacecode == "1"){
					var eBayaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.ebayAccounts) != "undefined"){
						var eBaydata = data1.ebayAccounts.ebayaccounts;
						$.each(eBaydata,function(k,v){
							eBayaccount += '<option value="'+v.ebayaccountcode+'" class="" >'+v.ebayaccountname+'</option>'; 
						});
					}
					$('#eBayaccount').html(eBayaccount);
				}
				if(marketplacecode == "101"){
					var gameaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.gameAccounts) != "undefined"){
						var edata = data1.gameAccounts.accounts;
						$.each(edata,function(k,v){
							gameaccount += '<option value="'+v.gameaccountcode+'" class="" >'+v.gameaccountname+'</option>'; 
						});
					}
					$('#gameaccount').html(gameaccount);
				}
				if(marketplacecode == "9"){
					var cdiscountaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.cdiscountAccounts) != "undefined"){
						var edata = data1.cdiscountAccounts.accounts;
						$.each(edata,function(k,v){
							cdiscountaccount += '<option value="'+v.cdiscountaccountcode+'" class="" >'+v.cdiscountaccountname+'</option>'; 
						});
					}
					$('#cdiscountaccount').html(cdiscountaccount);
				}
				if(marketplacecode == "3"){
					var webstoreaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.webstoreAccounts) != "undefined"){
						var edata = data1.webstoreAccounts.webstoreaccounts;
						$.each(edata,function(k,v){
							webstoreaccount += '<option value="'+v.webstoreaccountcode+'" class="" >'+v.webstoreaccountname+'</option>'; 
						});
					}
					$('#webstoreaccount').html(webstoreaccount);
				}
				if(marketplacecode == "21"){
					var skucloudaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.skucloudAccounts) != "undefined"){
						var edata = data1.skucloudAccounts.accounts;
						$.each(edata,function(k,v){
							skucloudaccount += '<option value="'+v.accountcode+'" class="" >'+v.accountname+'</option>'; 
						});
					}
					$('#skucloudaccount').html(skucloudaccount);
				}
				if(marketplacecode == "20"){
					var onbuyaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.onbuyAccounts) != "undefined"){
						var edata = data1.onbuyAccounts.accounts;
						$.each(edata,function(k,v){
							onbuyaccount += '<option value="'+v.accountcode+'" class="" >'+v.accountname+'</option>'; 
						});
					}
					$('#onbuyaccount').html(onbuyaccount);
				}
				if(marketplacecode == "16"){
					var amzaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.amazonAccounts) != "undefined"){
						var edata = data1.amazonAccounts.accounts;
						$.each(edata,function(k,v){
							amzaccount += '<option value="'+v.amzaccountcode+'" class="" >'+v.amzaccountname+'</option>'; 
						});
					}
					$('#amzaccount').html(amzaccount);
				}
				if(marketplacecode == "7"){
					var rakutenaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.rakutenAccounts) != "undefined"){
						var edata = data1.rakutenAccounts.accounts;
						$.each(edata,function(k,v){
							rakutenaccount += '<option value="'+v.accountcode+'" class="" >'+v.accountname+'</option>'; 
						});
					}
					$('#rakutenaccount').html(rakutenaccount);
				}
				if(marketplacecode == "13"){
					var abebooksaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.abeAccounts) != "undefined"){
						var edata = data1.abeAccounts.accounts;
						$.each(edata,function(k,v){
							abebooksaccount += '<option value="'+v.abebookaccountcode+'" class="" >'+v.abebookaccountname+'</option>'; 
						});
					}
					$('#abebooksaccount').html(abebooksaccount);
				}
				if(marketplacecode == "15"){
					var shopifyaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.shopifyAccounts) != "undefined"){
						var edata = data1.shopifyAccounts.accounts;
						$.each(edata,function(k,v){
							shopifyaccount += '<option value="'+v.accountcode+'" class="" >'+v.accountname+'</option>'; 
						});
					}
					$('#shopifyaccount').html(shopifyaccount);
				}
				if(marketplacecode == "22"){
					var frugoaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.fruugoAccounts) != "undefined"){
						var edata = data1.fruugoAccounts.accounts;
						$.each(edata,function(k,v){
							frugoaccount += '<option value="'+v.accountCode+'" class="" >'+v.accountName+'</option>'; 
						});
					}
					$('#frugoaccount').html(frugoaccount);
				}
				if(marketplacecode == "8"){
					var trademeaccount = '<option value="" class="" selected="selected">Select</option>';
					var data1 = JSON.parse(X247Inventory.inventory_tabs);
					if(typeof(data1.trademeAccounts) != "undefined"){
						var edata = data1.trademeAccounts.accounts;
						$.each(edata,function(k,v){
							trademeaccount += '<option value="'+v.trademeaccountcode+'" class="" >'+v.trademeaccountname+'</option>'; 
						});
					}
					$('#trademeaccount').html(trademeaccount);
				}
			}
		});
		jQuery.ajax({
			type: 'POST',
			url: app_base_url + main_url,
			//dataType: 'json',
			data:{marketplacecode:marketplacecode},
			success: function (res) {
				response = JSON.parse(res);
				if(marketplacecode != "18"){
					$('#total_products').show();
					X247Inventory.total_columns = response.total_columns;
					if((response.column_details) != "" && typeof(response.column_details.data.colsdata) != "undefined"){
						X247Inventory.cols_data = JSON.parse(response.column_details.data.colsdata);
					}
					var settings_inputboxes = "";
					var sortable1 = "";
					if(X247Inventory.cols_data == ""){
						X247Inventory.cols_data = X247Inventory.total_columns;
					}
					if(X247Inventory.cols_data != ""){
						var table_columns = '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
						table_columns += '<th class="no-sort">&nbsp;</th>';
						table_columns += '<th class="no-sort">Action</th>';
						jQuery.each(X247Inventory.cols_data,function(k,v){
							table_columns += '<th>'+v.name+'</th>';
						});
						jQuery('body #table_columns').append(table_columns);
					}
					if(X247Inventory.cols_data.length == X247Inventory.total_columns.length){
						jQuery('#check_all').prop('checked',true);
					}
					jQuery.each(X247Inventory.total_columns,function(i,v){
							var checked = X247Inventory.check_val_exist(X247Inventory.cols_data,v.name);
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
					jQuery('.dynamic_li').remove();
					jQuery('#sortable1').html('');
					jQuery('#settings_inputboxes').append(settings_inputboxes);
					jQuery('#sortable1').append(sortable1);
					jQuery('#searchProfileCode').html('<option value="" selected="selected">Select</option>');
					jQuery('#searchProfileCodeExport').html('<option value="">--Select Search Profile--</option>');
					if(typeof(response.search_profile_details.profiles) != "undefined"){
						var search_profile = response.search_profile_details.profiles;
						var searchProfileCode = "";
						jQuery.each(search_profile,function(k,v){
							searchProfileCode += '<option value='+v.profilecode+' >'+v.profilename+'</option>';
						});
						jQuery('#searchProfileCode').append(searchProfileCode);
						jQuery('#searchProfileCodeExport').append(searchProfileCode);
					}
					if(typeof(response.flag_details.flags) != "undefined"){
						var flag_details = response.flag_details.flags;
						X247Inventory.flag_details = flag_details;
						var searchFlagCode = "";
						jQuery.each(flag_details,function(k,v){
							searchFlagCode += '<option value='+v.flagid+' >'+v.flagname+'</option>';
						});
						jQuery('#searchFlagCode').append(searchFlagCode);
					}
					if ($.fn.DataTable.isDataTable( '#'+table_id ) ) {
						$('#'+table_id).DataTable().destroy();
						var destroy = "destroy:true";
					}else{
						var destroy = "cache: false";
					}
					jQuery('#'+table_id).DataTable({
						destroy,
						//"cache": false,
						fixedHeader: {
							header: true
						},
						columnDefs: [
						  { targets: 'no-sort', orderable: false }
						],
						"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
						info:false,
						"pageLength": 10,
						"language":{
							"lengthMenu": X247Inventory.change_limit(10)
						},
						"processing": true,
						"serverSide": true,
						"ajax": {
							"url": app_base_url+template,
							"type": "POST",
							"data":{cols_data:JSON.stringify(X247Inventory.cols_data),marketplacecode:marketplacecode,fkaccountcode:fkaccountcode},
							dataFilter: function(data){
								var json = jQuery.parseJSON( data );
								if(marketplacecode == "101" || marketplacecode == "13" || marketplacecode == "20" || marketplacecode == "15" || marketplacecode == "22"){
									var text = json.recordsTotal;
								}else{
									var text = json.recordsTotal+" (Parent Products: "+json.parentproducts+", Child Products: "+json.childproducts+", Non Relationship Products: "+json.nonrelationshipproducts+")";
								}
								jQuery('#total_Count').text(text);
								X247Inventory.flag_skus = json.flagSKUS;
								return data;
							},
						},
						initComplete: function() {
							$.each(X247Inventory.flag_skus,function(k,v){
								var flag_color = X247Inventory.getFlagcolor(v);
								if(flag_color != ""){
									$('input[type=checkbox][data-sku='+k+']').closest('tr').css('background-color',flag_color);
								}
							});
						}
					});

					var table = jQuery('#'+table_id).DataTable();
					jQuery('body').on( 'click','#aSearch', function () {
						table.search($('#txtSearch').val()).draw();
					});
					jQuery('.dataTables_filter').hide();
					jQuery('.container-fluid').show();
					jQuery('.traditional').removeClass('whirl');
				}else{//for inventory Images
					$('#total_products').hide();
				}
			}
		});
	}
	X247Inventory.getFlagcolor = function(id){
		var flagcolor = "";
		$.each(X247Inventory.flag_details,function(k,v){
			if(v.flagid == id){
				flagcolor =  v.flagcolorcode;
				return flagcolor;
			}
		});
		return flagcolor;
	}
	X247Inventory.sortable_s = function(id){
	   jQuery("#"+id).sortable();
	   jQuery("#"+id).disableSelection();
	   var selected = 0;

	   var itemlist = jQuery('#'+id);
	   var len = jQuery(itemlist).children().length;

	   jQuery("#"+id+" li").click(function () {
	      selected = jQuery(this).index();
	      if (jQuery("#"+id+" li").hasClass('select')) {
	          jQuery("#"+id+" li").removeClass('select');
	          jQuery(this).addClass("select");
	      } else {
	          jQuery(this).addClass("select");
	      }
	      //alert("Selected item is " + jQuery(this).text());

	   });
	}
	X247Inventory.tab_columns_data = function(url,tabs_url,template,table_id){
		jQuery.ajax({
			type: 'GET',
			url: app_base_url + tabs_url,
			//dataType: 'json',
			success: function (res) {
				X247Inventory.inventory_tabs = res;
				var response = JSON.parse(res);
				X247Inventory.tab_columns = response.tab_columns;
				var li_tabs = "";
				for(var i=0;i<X247Inventory.tab_columns.length;i++){
					var active = "";
					if(X247Inventory.tab_columns[i]['active']){
						active = "active";
					}
					li_tabs += "<li class='"+active+"' data-val="+X247Inventory.tab_columns[i]['iid']+" ><a href='#' >"+X247Inventory.tab_columns[i]['heading']+"</a></li>";
				}
				jQuery('.inventory_tabs').append(li_tabs);
				X247Inventory.main_data(url,template,table_id);
			}
		});
	}
	X247Inventory.inventory_settings = function(id,url){
		jsonObj = [];
		check = 1;
		jQuery('#'+id).modal('hide');
		jQuery('.traditional').addClass('whirl');
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
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
			data: {'tabcols':JSON.stringify(jsonObj),marketplacecode:marketplacecode},
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
	
	X247Inventory.load_main_data = function(table_id,val){
		//alert($.fn.DataTable.isDataTable( '#'+table_id ));
		if ($.fn.DataTable.isDataTable( '#'+table_id ) ) {
			$('#'+table_id).DataTable().destroy();
		}
		var key = X247Inventory.get_table_column_urls(val,X247Inventory.tab_columns);
		var main_url = "";
		var template = "";
		if(key >= 0){
			if(typeof(X247Inventory.tab_columns[key]['template']) != undefined){
				var main_url = X247Inventory.tab_columns[key]['template'];
			}
			if(typeof(X247Inventory.tab_columns[key]['table_template']) != undefined){
				var template = X247Inventory.tab_columns[key]['table_template'];
			}
		}
		if(main_url != "" && template != ""){
			X247Inventory.main_data(main_url,template,table_id);
		}
	}
	
	X247Inventory.get_table_column_urls = function(id,tab_columns){
		var key = -1;
		jQuery.each(tab_columns,function(k,v){
			if(v.iid == id){
				key = k;
			}
		});
		return key;
	}
	jQuery('body').on('click','.fa-location-arrow',function(){
		jQuery.ajax({
			type: 'POST',
			url: app_base_url + 'inventory/get_allbin_locations.php',
			async: true,
			cache: true,
			data: {'tabcols':jQuery(this).data('sku')},
			dataType: 'json',
			success: function (res) {
				jQuery('.traditional').removeClass('whirl');
				jQuery('#allbinLocations').modal('show');
			}
		});
	});
	jQuery('body').on('click','.expand_tr',function(){
		if(X247Inventory.cols_data != ""){
			var table_columns = '<th class="no-sort">Action</th>';
			table_columns += '<th class="no-sort"></th>';
			jQuery.each(X247Inventory.cols_data,function(k,v){
				table_columns += '<th>'+v.name+'</th>';
			});
			var length = X247Inventory.cols_data.length;
			if(jQuery(this).hasClass('expand_true') == true){
				jQuery(this).closest('tr').next().remove();
				jQuery(this).removeClass('expand_true');
				jQuery(this).removeClass('fa-minus');
			}else{
				var id = jQuery(this);
				var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
				var accountcode = $(this).data('accountcode');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/get_child_skus.php',
					//async: true,
					//cache: true,
					"data":{cols_data:JSON.stringify(X247Inventory.cols_data),sku:jQuery(this).data('sku'),marketplacecode:marketplacecode,accountcode:accountcode},
					success: function (res) {
						res = JSON.parse(res);
						var tr_data = "";
						jQuery.each(res.data,function(k,v){
							tr_data += "<tr>";
 							jQuery.each(v,function(vk,vv){
								tr_data += "<td>"+vv+"</td>";
							});
							tr_data += "</tr>";
						});
						jQuery('.traditional').removeClass('whirl');
						id.addClass('expand_true');
						id.addClass('fa-minus');
						var table_data = "<tr><td colspan='"+(length+3)+"' ><label class='col-sm-3 attributes no-padding-right'><strong>Child / Variation Products:</strong></label><table class='table table-striped table-bordered table-hover'><thead><tr>"+table_columns+"</tr></thead><tbody>"+tr_data+"</tbody></table></td></tr>";
						jQuery(table_data).insertAfter(id.closest('tr'));
					}
				});
			}
		}
	});
	jQuery('body').on('click','#ckbCheckAll',function(){
		jQuery('input:checkbox').not(this).prop('checked', this.checked);
	});
	jQuery('body').on('change keyup','.cmnTotQtyClass',function(){
		var sku = jQuery(this).data('sku');
		var marketplace = jQuery(this).data('marketplace');
		var checkbox_value = sku+"_"+marketplace;
		jQuery('input[type=checkbox][value='+checkbox_value+']').prop('checked', true);
		if(jQuery.inArray( checkbox_value, X247Inventory.selected_skus ) == -1){
			X247Inventory.selected_skus.push(checkbox_value);
		}
		var text = "Apply Changes("+X247Inventory.selected_skus.length+")";
		jQuery('#apply_changes').text(text);
		//console.log(X247Inventory.selected_skus);
	});
	jQuery('body').on('click','#apply_changes',function(){
		if(X247Inventory.selected_skus.length > 0){
			jQuery('.traditional').addClass('whirl');
			var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
			var post_data = [];
			if(marketplacecode == "0"){
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else if(marketplacecode == "1"){//eBay
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var ebaybinprice = jQuery('#buyitnowprice_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,ebaybinprice:ebaybinprice};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "2"){//Amazon
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var minprice = jQuery('#minprice_'+v).val();
					var maxprice = jQuery('#maxprice_'+v).val();
					var fixedprice = jQuery('#fixedprice_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,minprice:minprice,maxprice:maxprice,fixedprice:fixedprice};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "9"){//Cdiscount
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var cdiscountprice = jQuery('#cdiscountprice_'+v).val();
					var cdiscountrrp = jQuery('#cdiscountrrp_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,cdiscountprice:cdiscountprice,cdiscountrrp:cdiscountrrp};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "3"){//webstore
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var cdiscountprice = jQuery('#cdiscountprice_'+v).val();
					var cdiscountrrp = jQuery('#cdiscountrrp_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,cdiscountprice:cdiscountprice,cdiscountrrp:cdiscountrrp};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "7"){//rakuten
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var rakutenstandardprice = jQuery('#price_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,rakutenstandardprice:rakutenstandardprice};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "13"){//abebooks
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var rakutenstandardprice = jQuery('#price_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/abebooks/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else if(marketplacecode == "8"){//trademe
				jQuery.each(X247Inventory.selected_skus,function(k,v){
					var checkbox = jQuery('input[type=checkbox][value='+v+']');
					var sku = checkbox.data('sku');
					var marketplacecode = checkbox.data('marketplace');
					var accountcode = checkbox.data('accountcode');
					var quantity = jQuery('#'+v).val();
					var trademebuynowprice = jQuery('#trademebuynowprice_'+v).val();
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode,'quantity':quantity,trademebuynowprice:trademebuynowprice};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/save_inventory_dashboard.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			jQuery('.traditional').removeClass('whirl');
		}
	});
	jQuery('body').on('click','#block_item',function(){	
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "0"){	
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}else if(marketplacecode == "1"){//eBay
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}

		}
		else if(marketplacecode == "2"){//Amazon
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "3"){//webstore
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "7"){//rakuten
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "8"){//trademe
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/block_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			}else{
				alert("Please select products");
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	jQuery('body').on('click','#unblock_item',function(){		
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "0"){	
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}else if(marketplacecode == "1"){//eBay
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}

		}
		else if(marketplacecode == "2"){//Amazon
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "3"){//webstore
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "7"){//rakuten
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}
		else if(marketplacecode == "8"){//trademe
			if(jQuery('input[name="myCheckboxes[]"]:checked').length > 0) {
				jQuery('.traditional').addClass('whirl');
				var post_data = [];
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					var marketplacecode = jQuery(this).data('marketplace');
					var accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
				console.log(post_data);
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/unblock_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data)},
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
			else{
				alert("Please select products");
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	jQuery('body').on('click','#delete_inventory',function(){
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "0"){	
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}else if(marketplacecode == "1"){//eBay
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "2"){//Amazon
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "3"){//webstore
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "7"){//rakuten
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "13"){//abebooks
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/abebooks/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "15"){//shopify
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/shopify/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "22"){//frugo
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/frugo/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "8"){//trademe
			jQuery('.traditional').addClass('whirl');
			jQuery('#deleteInventory').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="delete_option"]:checked').val();
			console.log(selected_val);
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/delete_inventory.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),marketplacecode:marketplacecode,accountcode:accountcode},
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
			}else{
				alert("Please select Products");
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	jQuery('body').on('click','#flag_inventory_select_final',function(){
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "0"){	
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}else if(marketplacecode == "1"){//eBay
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "2"){//Amazon
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "3"){//webstore
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "7"){//rakuten
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		else if(marketplacecode == "8"){//trademe
			jQuery('.traditional').addClass('whirl');
			jQuery('#finalFlagSelection').modal('hide');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="flag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:jQuery('input[name="flag_selected_input"]:checked').val()},
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
			}else{
				alert("Please select Products");
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	jQuery('body').on('click','#unflag_inventory_final',function(){
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		if(marketplacecode == "0"){	
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}else if(marketplacecode == "1"){//eBay
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		else if(marketplacecode == "2"){//Amazon
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		else if(marketplacecode == "3"){//webstore
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		else if(marketplacecode == "7"){//rakuten
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		else if(marketplacecode == "8"){//trademe
			jQuery('.traditional').addClass('whirl');
			var post_data = [];
			var marketplacecode = "";
			var accountcode = "";
			var selected_val = jQuery('input[name="unflag_option"]:checked').val();
			if(selected_val == "selectedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}else if(selected_val == "displayedItems"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					post_data.push(data);
				});
			}
			if(post_data.length > 0){
				jQuery('#inventoryUnFlag').modal('hide');
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/update_inventory_flag.php',
					async: true,
					cache: true,
					data: {'post_data':JSON.stringify(post_data),flag:''},
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
			}else{
				alert("Please Select Products");
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	$('body').on('click','#delete_item',function(){
		$('#deleteInventory').modal('show');
	});
	$('body').on('click','#flag_item',function(){
		$('#inventoryFlag').modal('show');
	});
	$('body').on('click','#flag_inventory',function(){
		var selected_val = jQuery('input[name="flag_option"]:checked').val();
		var length = 0;
		if(selected_val == "selectedItems"){
			length = jQuery('input[name="myCheckboxes[]"]:checked').length;
		}
		if(selected_val == "displayedItems"){
			length = jQuery('input[name="myCheckboxes[]"]').length;
		}
		if(length > 0){
			$('#inventoryFlag').modal('hide');
			$('#flag_select_option').html('');
			var data = "";
			var i=0;
			$.each(X247Inventory.flag_details,function(k,v){
				var checked = "";
				if(i==0){
					checked = "checked";
				}
				data += '<label>';
				data += '<input type="radio" name="flag_selected_input" '+checked+' value="'+v.flagid+'"> <span class="fa fa-circle"></span>';
				data += '<textarea style="height:30px;width:115px;background-color:'+v.flagcolorcode+'; overflow:auto" disabled="disabled"></textarea>';
				data += '<spam class="ng-binding">'+v.flagname+'</spam></label>';
				i++;
			});
			$('#flag_select_option').html(data);
			$('#inventoryFlagSelection').modal('show');
		}else{
			alert("Please select Products");
		}
		
	});
	$('body').on('click','#flag_inventory_select',function(){
		$('#inventoryFlagSelection').modal('hide');
		$('#flag_select_final').html('');
		var post_data = [];
		var data = 'Please click "Ok" to proceed or "Cancel" to discard Selected Products';
		var selected_val = jQuery('input[name="flag_option"]:checked').val();
		if(selected_val == "selectedItems"){
			jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
				var sku = jQuery(this).data('sku');
				marketplacecode = jQuery(this).data('marketplace');
				accountcode = jQuery(this).data('accountcode');
				post_data.push(sku);
			});
		}else if(selected_val == "displayedItems"){
			jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
				var sku = jQuery(this).data('sku');
				marketplacecode = jQuery(this).data('marketplace');
				accountcode = jQuery(this).data('accountcode');
				post_data.push(sku);
			});
		}
		if(post_data.length > 0){
			data += post_data.toString()+"?";
			$('#flag_select_final').html(data);
			$('#finalFlagSelection').modal('show');
		}else{
			alert("Please select Products");
		}
		
		
	});
	$('body').on('click','#unflag_inventory',function(){
		$('#inventoryUnFlag').modal('show');
	});
	$('body').on('click','#export_inventory',function(){
		$('#exportInventory').modal('show');
	});
	$('body').on('click','.close_settings,.close',function(){
		$('.modal').modal('hide');
		$('.exporttab').removeClass('hide');
		$('.exportli').addClass('licolor');
		$('.exportli1').removeClass('licolor');
		$('.exporttab1').addClass('hide');
	});
	$('body').on('click','#export_inventory_next',function(){
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
			var post_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					marketplacecode = jQuery(this).data('marketplace');
					accountcode = jQuery(this).data('accountcode');
					post_data.push(sku);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if(selected_val == "1" && post_data.length > 0){
				status_export = true;
			}
			if(status_export){
				jQuery.ajax({
					type: 'GET',
					url: app_base_url + 'inventory/export_profile.php',
					//async: true,
					//cache: true,
					//data: {'post_data':JSON.stringify(post_data),flag:''},
					//dataType: 'json',
					success: function (res) {
						res = JSON.parse(res);
						if(res.status){
							jQuery('#export_selected_profile').html('');
							var export_profiles = res.export_profile_details.exportprofiles;
							var search_export_profiles = "<option value=''>---Select---</option>";
							jQuery.each(export_profiles,function(k,v){
								search_export_profiles += "<option value='"+v.profileid+"'>"+v.profilename+"</option>";
							});
							jQuery('#export_selected_profile').html(search_export_profiles);
							$('.exporttab').addClass('hide');
							$('.exportli').removeClass('licolor');
							$('.exportli1').addClass('licolor');
							$('.exporttab1').removeClass('hide');
						}else{
							console.log(res);
						}
					}
				});
			}else{
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
	});
	jQuery('body').on('click','#export_inventory_final',function(){
		var marketplacecode = jQuery('ul.inventory_tabs').find('li.active').data('val');
		jQuery('.traditional').addClass('whirl');
		$('.exporttab').removeClass('hide');
		$('.exportli').addClass('licolor');
		$('.exportli1').removeClass('licolor');
		$('.exporttab1').addClass('hide');
		jQuery('#exportInventory').modal('hide');
		if(marketplacecode == "0"){
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/alltabs/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}else if(marketplacecode == "1"){//eBay
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/ebay/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		else if(marketplacecode == "2"){//Amazon
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/amazon/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		else if(marketplacecode == "9"){//Cdiscount
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/cdiscount/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		else if(marketplacecode == "3"){//webstore
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/webstore/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		else if(marketplacecode == "7"){//rakuten
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/rakuten/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		else if(marketplacecode == "8"){//trademe
			var sku_data = [];
			var status_export = false;
			var selected_val = jQuery('input[name="export_option"]:checked').val();
			var email_address = jQuery('#email_address').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var exportprofileid = jQuery('#export_selected_profile').val();
			var searchprofileid = jQuery('#searchProfileCodeExport').val();
			if(selected_val == "1"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]:checked'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "2"){
				jQuery.each(jQuery('input[name="myCheckboxes[]"]'),function(){
					var sku = jQuery(this).data('sku');
					//marketplacecode = jQuery(this).data('marketplace');
					if(marketplacecode == 0){
						var accountcode = 0;
					}else{
						var accountcode = jQuery(this).data('accountcode');
					}
					var data = {'sku':sku,'marketplacecode':marketplacecode,'accountcode':accountcode};
					sku_data.push(data);
				});
			}else if(selected_val == "4"){
				if($('#searchProfileCodeExport').val() != ""){
					status_export = true;
				}
			}else{
				status_export = true;
			}
			if((selected_val == "1" || selected_val == "2") && sku_data.length > 0){
				status_export = true;
			}
			
			if(status_export){
				jQuery.ajax({
					type: 'POST',
					url: app_base_url + 'inventory/update_inventory/trademe/export_inventory_profile.php',
					async: true,
					cache: true,
					data: {'sku_data':JSON.stringify(sku_data),email_address:email_address,exportprofileid:exportprofileid,type:selected_val,searchprofileid:searchprofileid},
					dataType: 'json',
					success: function (res) {
						jQuery('.traditional').removeClass('whirl');
						if(res.status){
							//location.reload(true);
							alert("Exported successfully");
						}else{
							console.log(res);
						}
					}
				});
			}else{
				jQuery('.traditional').removeClass('whirl');
				if(selected_val == "4" && $('#searchProfileCodeExport').val() == ""){
					alert("Please select Item search profile");
				}else{
					alert("Please select products to Export");
				}
			}
		}
		jQuery('.traditional').removeClass('whirl');
	});
	$('body').on('change keyup','.amzMinPriceClass',function(){
		var sku = jQuery(this).data('sku');
		var marketplace = jQuery(this).data('marketplace');
		var checkbox_value = sku+"_"+marketplace;
		jQuery('input[type=checkbox][value='+checkbox_value+']').prop('checked', true);
		if(jQuery.inArray( checkbox_value, X247Inventory.selected_skus ) == -1){
			X247Inventory.selected_skus.push(checkbox_value);
		}
		var text = "Apply Changes("+X247Inventory.selected_skus.length+")";
		jQuery('#apply_changes').text(text);
		jQuery('#seleted_skus').text(X247Inventory.selected_skus.length);
		console.log(X247Inventory.selected_skus);
	});
	

	return root.X247Inventory;

}));