$('#setting_apply').on("click", function( e) {
	jsonObj = [];
	check = 1;
	$('#settingModal').modal('hide');
	$('.traditional').addClass('whirl');
	var page_type = $(this).attr('data-type');
	$('#sortable1 li').each(function(i){
		item = {}
		item ["view_column"] = $(this).attr('name');
		item ["value"] = $(this).attr('id');
		item ["pos"] = check;
		check++;
		jsonObj.push(item);
	});
	$.ajax({
		type: 'POST',
		url: app_base_url + 'ebay/save_customise_dashboard_tabcols.php',
		async: true,
		cache: true,
		data: {'tabcols':JSON.stringify(jsonObj),page_type:page_type},
		dataType: 'json',
		success: function (res) {
			$('.traditional').removeClass('whirl');
			if (res) {
				location.reload(true);
			} else {
				alert("Some error occured");
			}
		}
	});
	
});
/* check all inventories */
function checkAll(ele) {
     var checkboxes = document.getElementsByName('productSKUs');
	 var check=0;
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
				 check++;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
	$('.orders_selected').text(check);
}
/* check of single order*/
function checkSingle(ele) {
	var arr = get_checked_count();
	$('.orders_selected').text(arr.length);
}
/* checked inventory array values */
function get_checked_count(){
	var favorite = [];
	$.each($("input[name='productSKUs']:checked"), function(){
		favorite.push($(this).val());
	});
	return favorite;
}
/* check all inventories */
function checkAllSortable(ele) {
     var checkboxes = document.getElementsByName('selectedCols[]');
	 var check=0;
     if (ele.checked) {
		$('#sortable1 li').each(function(i){
			if($(this).attr('name') != "SKU"){
				$(this).remove();
			}
		});
        for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
				check++;
				if(checkboxes[i].value != "SKU"){
					$('#sortable1').append('<li class="ui-state-default ui-sortable-handle" name="'+checkboxes[i].value+'" id="'+checkboxes[i].id+'"> '+checkboxes[i].value+' </li>');
				}
             }
        }
     } else {
        for (var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].value != "SKU"){
				 if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
					
				 }
			}
        }
		$('#sortable1 li').each(function(i){
			if($(this).attr('name') != "SKU"){
				$(this).remove();
			}
		});
		 
     }
}
/* check all single inventory */
function checkAllSortableSingle(ele) {
    if (ele.checked) {
		if($(ele).attr('value') != "SKU"){
			$('#sortable1').append('<li class="ui-state-default ui-sortable-handle" name="'+$(ele).attr('value')+'" id="'+$(ele).attr('id')+'"> '+$(ele).attr('value')+' </li>');
		}
    } else {
		$('#sortable1 li').each(function(i){
			if($(ele).attr('value') != "SKU"){
				if($(ele).attr('value') == $(this).attr('name')){
					$(this).remove();
				}
			}
		});
		$('#check_all').prop('checked', true);
    }
}