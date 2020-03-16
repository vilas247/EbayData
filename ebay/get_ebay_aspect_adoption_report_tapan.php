<?php include("../common/header_tapan.php"); 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
$select_size = 10;
$name_size = 60;
?>
<style>
	.wrapper {
		overflow: visible;
	}

	.portlets-wrapper {
		overflow: visible;
	}

	.table-responsive {
		overflow: visible;
	}

</style>

<!-- Content Starts -->  
	<div class="portlets-wrapper traditional whirl" style="margin-top:70px">
	  <div class="row">
			<div class="singleNav" style="padding-bottom:7px;">
				<p>
					<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
					<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
					<a href="<?= BASE_URL ?>#/app/inventory-dashboard">Inventory</a> &gt;
					<a href="<?= BASE_URL ?>#/">eBay Report</a> &gt;
					Aspect Adoption Report 
				</p>
			</div>
		</div>
      <div class="container-fluid" style="min-height: 0;">
		<div class="row mar-top-0">
			<div class="col-lg-6 form-group">
				<label class="col-md-2 font-normal pad-left-0 mar-top-5">eBay Account:</label> 
				<div class="col-md-5">
					<select class="form-control" >
						<option value="" >Select</option>
						<option value="eBay UK" selected>eBay - eBay UK</option>
					</select>					
				</div>
				<div class="col-md-4" style="float: right;">
					<button id="apply_changes" class="btn btn-primary" style="display: none; font-weight: bold;">Apply Changes</button>
				</div>				
			</div>
			<div class="col-lg-6 form-group">
				<!-- <label class="col-md-2 pad-left-0 font-normal mar-top-5" style="text-align: right;">Search</label>  -->
				<div class="col-md-10">
					<ul class="list-inline">
						<li class="mar-right-5 col-md-9">
							<input type="text" id="search_data" placeholder="Search" class="form-control srch-filed">
						</li>
						<li><a href="#" id="aSearchOrder"><em type="submit" class="fa fa-search pad-font-icon"></em></a></li>
						<li><a href="#" onClick='clear_and_submit();' >Clear Search</a></li>
					</ul>					
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive table-bordered scroll-table traffic-table checkboxes">
				<form role="form" method="post" action="<?= BASE_URL ?>/ebay/insert.php" class="form-inline">
<?php

if(isset($_GET['seller_ebay_id']) && $_GET['seller_ebay_id'] != '') {
	$seller_ebay_id = $_GET['seller_ebay_id'];
}
else {
	echo "ebay seller id is missing"; exit;
}

$header=array(
	'Content-Type: application/json',
);
		
$offset = 0;
$limit = 500;
$sorting = '';
$sorting_col = '';
if(isset($_GET['limit']) && $_GET['limit'] != '' && intval($_GET['limit']) > 0) {
	$limit = $_GET['limit'];
}
if(isset($_GET['offset']) && $_GET['offset'] != '' && intval($_GET['offset']) > 0) {
	$offset = ($_GET['offset'] - 1) * $limit;
}
if(isset($_GET['sorting']) && $_GET['sorting'] != '' && ($_GET['sorting'] == "ASC" || $_GET['sorting'] == "DESC") ) {
	$sorting = $_GET['sorting'];
}
if(isset($_GET['sort_col']) && $_GET['sort_col'] != '') {
	$sorting_col = $_GET['sort_col'];
}

if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size);
	if(!empty($res)){
		echo $res;		
	}else{
		$req = $url;
		$res = get_json_response($header,array(),$url);
		//print_r($res);exit;
		$check_errors = json_decode($res);
		if(isset($check_errors->errors)){
			echo "Error Response<br/>";exit;
		}else{
			if(json_last_error() === 0){
				$response = json_decode($res,true);
				$random_number = strtotime("now");
				
				$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id) values ('".$random_number."','headers','".$seller_ebay_id."')";
				mysqli_query($conn,$sql);
				if(isset($response['listingViolations'])){
					$listingViolations = $response['listingViolations'];
					foreach($listingViolations as $k=>$v){
						$listing_id = '';
						$compliance_type = '';
						$reason_code = '';
						$missing_value = '';
						if(isset($v['listingId'])){
							$listing_id = $v['listingId'];
						}
						if(isset($v['complianceType'])){
							$compliance_type = $v['complianceType'];
						}
						if(isset($v['violations'])){
							foreach($v['violations'] as $viok=>$viov){
								if(isset($viov['reasonCode'])){
									$reason_code = $viov['reasonCode'];
								}
								$violation_data = $viov['violationData'];
								foreach($violation_data as $vdk=>$vdv){
									if(!empty($listing_id)){
										//echo $listing_id.'-->'.$vdk;echo "<br/>";
										$sql = "insert into ebay_aspect_adoption_report(random_number,data_type,ebay_seller_id,ebay_item_id,reason_code,aspect_name) values
											('".$random_number."','values','".$seller_ebay_id."','".$listing_id."','".$reason_code."','".addslashes($vdv['value'])."')";
										mysqli_query($conn,$sql);
									}
								}
								if(isset($viov['correctiveRecommendations']['aspectRecommendations'])){
									$violation_recomm = $viov['correctiveRecommendations']['aspectRecommendations'];
									foreach($violation_recomm as $vrk=>$vrv){
										$sql1 = "select * from ebay_aspect_adoption_report where random_number='".$random_number."' and aspect_name='".addslashes($vrv['localizedAspectName'])."' and ebay_item_id='".$listing_id."'";
										$res_val = mysqli_query($conn,$sql1);
										if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
											$data = $res_val->fetch_assoc();
											$sql_u = "update ebay_aspect_adoption_report set aspect_value_corrective='".addslashes($vrv['suggestedValues'][0])."' where id=".$data['id'];
											mysqli_query($conn,$sql_u);
										}
									}
								}
							}
						}
					}
					
				}
				$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size);
				if(!empty($res)){
					echo $res;
				}
				else{
					echo "Error Response<br/><br/>";exit;
				}
			}else{
				echo "Error Response<br/><br/>";exit;
			}
		}
	}
}

function get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size){
	$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";
	$max_value_missing = 1;
	$max_value = 1;
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		$random_number = $headers['random_number'];
		//$response['header'] = json_decode($headers['response'],true);
		$orderby = '';
		$sort = '';
		if(!empty($sorting_col)){
			$orderby = "ORDER BY ".$sorting_col;
			if(!empty($sorting)){
				$orderby .= " ".$sorting;
			}
		}
		$sql_count_missing = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NULL GROUP BY ebay_item_id ) AS counts";
		$res_count_missing = mysqli_query($conn,$sql_count_missing);
		if(!empty($res_count_missing) && mysqli_num_rows($res_count_missing) > 0){
			$count_missing = $res_count_missing->fetch_assoc();
			$max_value_missing = $count_missing['max_value'];
		}
		$sql_count = "SELECT MAX(counted) as max_value FROM ( SELECT COUNT(*) AS counted FROM ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND random_number = '".$random_number."' AND aspect_value_corrective IS NOT NULL GROUP BY ebay_item_id ) AS counts";
		$res_count = mysqli_query($conn,$sql_count);
		if(!empty($res_count) && mysqli_num_rows($res_count) > 0){
			$count = $res_count->fetch_assoc();
			$max_value = $count['max_value'];
		}
		
		$response .= '<table id="aspect_adoptions" class="dataTable no-footer table table-bordered table-striped" role="grid" aria-describedby="aspect_adoptions_info" style="display:none">';
		$response .= '<thead>';
		$response .= '<tr role="row" class="suceess">';
		$response .= '<th class="no-sort" ><input type="checkbox" id="ckbCheckAll" /></th>';
		$response .= '<th>SKU</th>';
		$response .= '<th>Item ID</th>';
		$response .= '<th>Product Name</th>';
		//$response .= '<th>Reason Code</th>';
		for($i=0;$i<$max_value;$i++){
			$response .= '<th>Aspect Name</th>';
			$response .= '<th>Aspect Value</th>';
		}
		for($i=0;$i<$max_value_missing;$i++){
			$response .= '<th>Aspect Name</th>';
			$response .= '<th>Aspect Value</th>';
		}
		$response .= '</tr>';
		$response .= '</thead>';
		$response .= '<tbody>';
		$sql_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' group by ebay_item_id";
		
		//echo $sql_val;exit;
		$res_val = mysqli_query($conn,$sql_val);
		$even_odd = 1;
		if(!empty($res_val) && mysqli_num_rows($res_val) > 0){
			while($values = $res_val->fetch_assoc()){
				$count_check_missing = 0;
				$count_check = 0;
				if(($even_odd%2) == 0){
					$even = "even";
				}else{
					$even = "odd";
				}
				$even_odd++;
				$response .= '<tr role="row" class="'.$even.'">';
				$response .= "<td><input type='checkbox' style='display:block;margin:5px auto;' name='myCheckboxes[]' value='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				$response .= "<td>".$values['item_sku']."</td>";
				$response .= "<td><a target='_blank' href='https://www.ebay.co.uk/itm/".$values['ebay_item_id']."'>".$values['ebay_item_id']."</a></td>";
				$response .= "<td>".replace_text_trim($name_size,$values['product_name'])."</td>";
				$sql_inner_val = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='values' AND random_number ='".$random_number."' and ebay_item_id='".$values['ebay_item_id']."'";
				$res_inner_val = mysqli_query($conn,$sql_inner_val);
				if(!empty($res_inner_val) && mysqli_num_rows($res_inner_val) > 0){
					$missing_aspect_name = "";
					$ebay_aspect_name = "";
					while($values_inner = $res_inner_val->fetch_assoc()){
						if(!empty($values_inner['aspect_value_corrective'])){
							$ebay_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$ebay_aspect_name .= "<td><select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$ebay_aspect_name .= "<option value='".$avv."' ".$selected." >".replace_text_trim($select_size,$avv)."</option>";
									}
									$ebay_aspect_name .= "</select></td>";
								}else{
									$ebay_aspect_name .= "<td><select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select></td>";
								}
							}else{
								$ebay_aspect_name .= "<td><select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select></td>";
							}
							
							$count_check++;
						}else{
							$missing_aspect_name .= "<td>".$values_inner['aspect_name']."</td>";
							if(!empty($values_inner['aspect_values'])){
								$aspect_values = explode("|||",$values_inner['aspect_values']);
								if(!empty($aspect_values)){
									
									$missing_aspect_name .= "<td><select id='select-aspect' class='select-aspect ebay_item_".$values['ebay_item_id']."' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' ><option >Search by Item...</option>";
									foreach($aspect_values as $avk=>$avv){
										$selected = "";
										if($values_inner['aspect_value_corrective'] == $avv){
											$selected = "selected";
										}
										$missing_aspect_name .= "<option value='".$avv."' ".$selected." >".replace_text_trim($select_size,$avv)."</option>";
									}
									$missing_aspect_name .= "</select></td>";
								}else{
									$missing_aspect_name .= "<td><select id='select-aspect' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' class='select-aspect ebay_item_".$values['ebay_item_id']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select></td>";
								}
							}else{
								$missing_aspect_name .= "<td><select id='select-aspect' class='select-aspect ebay_item_".$values['ebay_item_id']."' name='".$values['ebay_item_id']."_".$values_inner['aspect_name']."' ><option value='".$values_inner['aspect_value_corrective']."' >".replace_text_trim($select_size,$values_inner['aspect_value_corrective'])."</option></select></td>";
							}
							$count_check_missing++;
						}
						
					}
					for($k=0;$k<($max_value_missing-$count_check_missing);$k++){
						$missing_aspect_name .= "<td>&nbsp;</td>";
						$missing_aspect_name .= "<td>&nbsp;</td>";
					}
					for($j=0;$j<($max_value-$count_check);$j++){
						$ebay_aspect_name .= "<td>&nbsp;</td>";
						$ebay_aspect_name .= "<td>&nbsp;</td>";
					}
					
					$response .= $ebay_aspect_name.$missing_aspect_name;
				}
				$response .= '</tr>';
			}
		}else{
			return array();
		}
		
		$response .= '</tbody>';
		$response .= '</table>';
		return $response;
	}else{
		return array();
	}
}

function replace_text_trim($size,$text){
	/*if(intval(strlen($text)) > intval($size)){
		return substr($text, 0, $size)."...";
	}else{
		return $text;
	}*/

	return $text;
}


?> 
				</form>
                </div>              
            </div>
        </div>
    </div>
</div>
    <!-- Content Ends --> 
<?php include("../common/footer.php"); ?>
<style>
.select-aspect{
	width:auto;
}

#aspect_adoptions td, #aspect_adoptions th {
	vertical-align: middle;
	font-size: 15px;
	white-space: nowrap;
}

/* #aspect_adoptions tr td:nth-of-type(6),
#aspect_adoptions tr th:nth-of-type(6) {
	width: 150px;
} */
</style>
<script>
function clear_and_submit() {
    jQuery(function($){
		$('#search_data').val('');
        var table = $('#aspect_adoptions').DataTable();
        table.search( '' );
        table.draw();
    });
}
$(document).ready(function(){
	
  $('.select-aspect').selectize({create:true,allowEmptyOption: false,closeAfterSelect:true});
  $("#ckbCheckAll").click(function(){
	  $('input:checkbox').not(this).prop('checked', this.checked);	  
	  
	  if($('input[name="myCheckboxes[]"]:checked').length > 0) {
	  	$('#apply_changes').show();
	  }
	  else {
	  	$('#apply_changes').hide();
	  }
  });

  $('input[name="myCheckboxes[]"]').click(function() {
  		if($('input[name="myCheckboxes[]"]:checked').length > 0) {
	  		$('#apply_changes').show();
	  	}
	  	else {
	  		$('#apply_changes').hide();
	  	}
  });

  $('#aspect_adoptions').DataTable({
	  	columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
	  	//"sDom": '<"top"i>rt<"bottom"flp><"clear">'
	  	"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
	  	//"dom": '<"top"flp<"clear">>rt<"bottom"ifp<"clear">>'
		//"bSort" : false,
		//"scrollX": true,
		//"scrollY": 350,
		"pageLength": 100,
		/*"oLanguage": { 
			"sLengthMenu": " _MENU_"
		},*/
		"language":{
			"lengthMenu": "1|2|3",
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		}
	});
	$('#aspect_adoptions').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#aspect_adoptions').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
	$('#apply_changes').click(function(){
		var selected = [];
		var post_data = [];
		$('.checkboxes input:checked').each(function() {
			selected.push($(this).val());
		});
		console.log(selected);
		var form_data = $('form').serializeArray();
		form_data = $.grep(form_data, function(value) {
			if((value.name != "aspect_adoptions_length") && (value.name != "myCheckboxes[]")){
				var array = (value.name).split('_');
				var item = "ebay_item_"+array[0];
				console.log(item);
				console.log($.inArray( item, selected )>= 0);
				if($.inArray( item, selected ) >= 0){
					return value;
				}
			}
		});
	});
});
</script>