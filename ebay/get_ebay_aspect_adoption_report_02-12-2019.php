<?php 
require_once("../common/db-config.php");
require_once("../common/ebay_api_end_points.php");
require_once("../common/curl.php");
include("../common/inventory_config.php");
$select_size = 10;
$name_size = 60;

$total_cols = get_columns();
$db_columns = get_columns();
$sql_cols = "select * from customise_dashboard_columns WHERE page_type='ASPECT_ADOPTION'";
$res_cols = mysqli_query($conn,$sql_cols);
$res_cols = $res_cols->fetch_assoc();
//print_r($res_cols);exit;
if(!empty($res_cols)){
	$db_columns = json_decode($res_cols['tabcols'],true);
}

include("../common/header.php"); 
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
	.download_button{
		text-align:center;
		width:145px;
		float:right;
		margin-right:10px;
		margin-top:3px;
	}
	.modal-backdrop.fade.in{
		z-index:-1;
	}

</style>

<!-- Content Starts -->  
	<div class="portlets-wrapper traditional whirl" style="margin-top:55px">
      <div class="container-fluid" style="min-height: 0;">
		<div class="row">
			<div class="singleNav" style="padding-bottom:7px;">
				<p>
					<a href="<?= BASE_URL ?>#/app/dashboard">Home</a> &gt; 
					<a href="<?= BASE_URL ?>#/app/optimise">Optimise</a> &gt;
					<a href="<?= BASE_URL ?>#/app/inventory-dashboard">eBay Inventory</a> &gt;
					<!--<a href="<?= BASE_URL ?>#/">eBay Report</a> &gt;-->
					Aspect Recommendation Report
				</p>
			</div>
		</div>
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
					<button id="apply_changes" class="btn btn-primary" style="font-weight: bold;">Apply Changes(0)</button>
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
		<div class="row mar-top-0" id="total_records_display">
			<div class="col-lg-6">
				<p style="padding: 0 15px" >
					<p  id="lat_updated_date" ></p> 
				</p>
			</div>
			<div class="col-lg-6 pull-right text-right">
				<a href="#" class="mar-right-30" data-toggle="modal" data-target="#settingModal" placeholder="Columns Settings">
					<img src="<?= BASE_URL?>common/images/settings-icon.682ad8cc.png">
				</a>
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

$last_updated_date = "";
if(isset($_REQUEST['type'])){
	$url = VIOLATION_TYPE_API_URL."?type=".$_REQUEST['type'].'&seller_ebay_id='.$seller_ebay_id;
	$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size,$db_columns);
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
				$res = get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size,$db_columns);
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

function get_listing_data($conn,$seller_ebay_id,$offset,$limit,$sorting,$sorting_col,$select_size,$name_size,$db_columns){
	$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
	//echo $sql;exit;
	$response = "";
	$max_value_missing = 1;
	$max_value = 1;
	$res = mysqli_query($conn,$sql);
	if(!empty($res) && mysqli_num_rows($res) > 0){
		$headers = $res->fetch_assoc();
		if(empty($last_updated_date)){
			if(isset($headers['created_date'])){
				$last_updated_date = date("jS F Y h:i A",strtotime($headers['created_date']));
			}
		}
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
		if(check_val_exist($db_columns,'item_sku')){
			$response .= '<th>SKU</th>';
		}
		if(check_val_exist($db_columns,'ebay_item_id')){
			$response .= '<th>eBay Item ID</th>';
		}
		if(check_val_exist($db_columns,'product_name')){
			$response .= '<th>Product Name</th>';
		}
		
		//$response .= '<th>Reason Code</th>';
		for($i=0;$i<$max_value;$i++){
			$response .= '<th>Aspect Name</th>';
			$response .= '<th>Aspect Suggested Value</th>';
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
				$response .= "<td><input type='checkbox' style='display:block;margin:5px auto;' data-sku='".$values['item_sku']."' name='myCheckboxes[]' value='ebay_item_".$values['ebay_item_id']."' name='ebay_item_checkbox[]' ></td>";
				if(check_val_exist($db_columns,'item_sku')){
					$response .= "<td><a href='".BASE_URL.'#/app/inventory-product-item?skuitemid='.$values['item_sku']."'>".$values['item_sku']."</a></td>";
				}
				if(check_val_exist($db_columns,'ebay_item_id')){
					$response .= "<td><a target='_blank' href='https://www.ebay.co.uk/itm/".$values['ebay_item_id']."'>".$values['ebay_item_id']."</a></td>";
				}
				if(check_val_exist($db_columns,'product_name')){
					$response .= "<td>".replace_text_trim($name_size,$values['product_name'])."</td>";
				}
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

$sql = "select * from ebay_aspect_adoption_report WHERE ebay_seller_id='".$seller_ebay_id."' AND data_type='headers' ORDER BY id DESC LIMIT 1";
$res = mysqli_query($conn,$sql);
if(!empty($res) && mysqli_num_rows($res) > 0){
	$headers = $res->fetch_assoc();
	if(empty($last_updated_date)){
		if(isset($headers['created_date'])){
			$last_updated_date = date("jS F Y h:i A",strtotime($headers['created_date']));
		}
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

function get_columns(){
	
	$columns = array();
	$columns[] = array('view_column'=>'SKU','value'=>'item_sku','data-title'=>'sku');
	$columns[] = array('view_column'=>'eBay Item ID','value'=>'ebay_item_id','data-title'=>'Ebay Item Id');
	$columns[] = array('view_column'=>'Product Name','value'=>'product_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Aspect Name','value'=>'aspect_name','data-title'=>'Name');
	$columns[] = array('view_column'=>'Aspect Value','value'=>'aspect_value','data-title'=>'');
	//$columns[] = array('view_column'=>'Aspect Values','value'=>'aspect_values','data-title'=>'');
	$columns[] = array('view_column'=>'Aspect Suggested Value','value'=>'aspect_value_corrective','data-title'=>'');
	//$columns[] = array('view_column'=>'Report last updated ','value'=>'created_date','data-title'=>'');
	return $columns;
}

function check_val_exist($arr,$val){
	$status = false;
	foreach($arr as $k=>$v){
		if($v['value'] == $val){
			$status = true;
			break;
		}
	}
	return $status;
}


?> 
				</form>
                </div>              
            </div>
        </div>
    </div>
</div>
<style>
.selectize-control {
    min-width: 300px;
}

.selectize-dropdown {
    /*width: 600px !important;*/
}
</style>
    <!-- Content Ends --> 
<?php include("../common/footer.php"); ?>
<div id="settingModal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg" style="">
		<div class="modal-content">
			<div class="traditional " style="">
				<div class="row pad-left-right-15 traditional" id="inventorycustomiseview">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Customise Dashboard View</b></h4>
					</div>
					<div class="col-md-9 return-manage-pop-check pad-right-10">
						<h4 style="margin-left: 0px; font-weight: normal; margin-bottom: 20px">Pick the columns you want to view</h4>
						<label class="checkbox-inline c-checkbox col-xs-3">
							<input type="checkbox" id="check_all" onchange="checkAllSortable1(this)" <?= (count($db_columns) == count($total_cols)) ? "checked": "" ?> > <span class="fa fa-check"></span>Select All
						</label>
						<?php foreach($total_cols as $sk=>$sv){ 
							$checked = check_val_exist($db_columns,$sv['value']);
							if($checked){
								$checked = "checked";
							}else{
								$checked = "";
							}
							if($sv['view_column'] == "SKU"){
								$disabled = "disabled checked";
							}else if($sv['value'] == "aspect_name"){
								$disabled = "disabled checked";
							}else if($sv['value'] == "aspect_value"){
								$disabled = "disabled checked";
							}else if($sv['value'] == "aspect_value_corrective"){
								$disabled = "disabled checked";
							}else{
								$disabled = "";
							}
						?>
							<label class="checkbox-inline c-checkbox col-xs-3" style="">
							<input name="selectedCols[]" <?= $checked ?> <?= $disabled ?> value="<?= $sv['view_column'] ?>" onchange="checkAllSortableSingle(this)" type="checkbox" id="<?= $sv['value'] ?>"> <span class="fa fa-check"></span><?= $sv['view_column'] ?>
						</label>
						<?php } ?>
					</div>
					<div class="col-md-3">
						<h4 style="margin-left: -20px;  font-weight: normal">Arrange Columns</h4>
						<div class="add-product-ul-li">
							<ul style="height: 245px; margin-bottom: 20px" id="sortable1" class="ui-sortable">
								<?php foreach($db_columns as $k=>$v){ ?>
									<li class="ui-state-default" name="<?= $v['view_column'] ?>" id="<?= $v['value'] ?>"> <?= $v['view_column'] ?> </li>
								<?php } ?>
							</ul>
							<div class="arrow-return-alignment" style="float: right; width: 30px">
								<em class="fa fa-arrow-up fa-lg"></em> <em class="fa fa-arrow-down fa-lg"></em>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group col-lg-3 pull-right mar-top-10">
							<button class="btn btn-danger mar-left-15 close_settings"> Cancel </button>
							<button class="btn btn-theme mar-left-15" data-type="ASPECT_ADOPTION" id="setting_apply"> Apply </button> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="<?= BASE_URL ?>common/js/settings.js"></script>
<script>
$('#lat_updated_date').append('Report Last Updated: <?= $last_updated_date ?>');
function checkAllSortable1(ele) {
     var checkboxes = document.getElementsByName('selectedCols[]');
	 var check=0;
     if (ele.checked) {
		$('#sortable1 li').each(function(i){
			if($(this).attr('name') == "SKU" || $(this).attr('id') == 'aspect_name' || $(this).attr('id') == 'aspect_value' || $(this).attr('id') == 'aspect_value_corrective'){
				
			}else{
				$(this).remove();
			}
		});
        for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
				check++;
				if(checkboxes[i].value == "SKU" || checkboxes[i].value == "Aspect Name" || checkboxes[i].value == "Aspect Value" || checkboxes[i].value == "Aspect Suggested Value"){
					
				}else{
					$('#sortable1').append('<li class="ui-state-default ui-sortable-handle" name="'+checkboxes[i].value+'" id="'+checkboxes[i].id+'"> '+checkboxes[i].value+' </li>');
				}
             }
        }
     } else {
        for (var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].value == "SKU" || checkboxes[i].value == "Aspect Name" || checkboxes[i].value == "Aspect Value" || checkboxes[i].value == "Aspect Suggested Value"){
				 
			}else{
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
					
				 }
			}
        }
		$('#sortable1 li').each(function(i){
			if($(this).attr('name') == "SKU" || $(this).attr('id') == 'aspect_name' || $(this).attr('id') == 'aspect_value' || $(this).attr('id') == 'aspect_value_corrective'){
				
			}else{
				$(this).remove();
			}
		});
		 
     }
}
$(function () {
	$('.close_settings').click(function(){
		$('#settingModal').modal('hide');
	});
   $("#sortable1").sortable();
   $("#sortable1").disableSelection();
   var selected = 0;

   var itemlist = $('#sortable1');
   var len = $(itemlist).children().length;

   $("#sortable1 li").click(function () {
      selected = $(this).index();
      if ($("#sortable1 li").hasClass('select')) {
          $("#sortable1 li").removeClass('select');
          $(this).addClass("select");
      } else {
          $(this).addClass("select");
      }
      //alert("Selected item is " + $(this).text());

   });
});
var selected_skus = [];
var table_html="";
table_html = $('.traffic-table').html();
var download_button = '<a type="button" class="btn bg-green col-md-4 inv-btn download_button" href="<?= BASE_URL ?>ebay/csvdownload/download_ebay_aspect_adoption_report.php?seller_ebay_id=<?= $seller_ebay_id?>&type=ASPECTS_ADOPTION" style="background: #1289A7"><span class="fa fa-download fa-lg"></span> Download</a>';
function clear_and_submit() {
    jQuery(function($){
		$('#search_data').val('');
        var table = $('#aspect_adoptions').DataTable();
        table.search( '' );
        table.draw();
    });
}
function change_limit(value){
	var limit_array = [25,50,100,200];
	var final_html = '<div class="dataTables_paginate paging_simple_numbers" id="" ><span>';
	for(var i=0;i<limit_array.length;i++){
		var selected = '';
		if(limit_array[i] == value){
			selected = 'current';
		}
		final_html += '<a class="paginate_button limit_change '+selected+'" onClick="change_limit_data('+limit_array[i]+')" data-val="'+limit_array[i]+'" aria-controls="aspect_adoptions">'+limit_array[i]+'</a>';
	}
	final_html += '</span></div>';
	return final_html;
}

function change_limit_data(limit){
	$('.traditional').addClass('whirl');
	$('.traffic-table').html('');
	$('.traffic-table').html(table_html);
	$('#aspect_adoptions').DataTable({
		//destroy: true,
		fixedHeader: {
						header: true
					},
		columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">',
		//"bSort" : false,
		"pageLength": limit,
		info:false,
		"language":{
			"lengthMenu": change_limit(limit),
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		}
	});
	$('#aspect_adoptions').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#aspect_adoptions_paginate').after(download_button);
	$('.traditional').removeClass('whirl');
}

$(document).ready(function(){
	$('.select-aspect').on('change',function(){
		var sku_data = $(this).attr('name');
		var array = (sku_data).split('_');
		if($.inArray(array[0], selected_skus) == -1){
			selected_skus.push(array[0]);
			var checkbox_value = "ebay_item_"+array[0];
			$('input[type=checkbox][value='+checkbox_value+']').prop('checked', true);
		}
		if(selected_skus.length > 0){
			var text = "Apply Changes("+selected_skus.length+")";
			$('#apply_changes').text(text);
		}
	});
	$('.select-aspect').selectize({create:true,allowEmptyOption: false,closeAfterSelect:true});
	$("#ckbCheckAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);	  
	  
		if($('input[name="myCheckboxes[]"]:checked').length > 0) {
			//$('#apply_changes').show();
			var len = $('input[name="myCheckboxes[]"]:checked').length;
			var text = "Apply Changes("+len+")";
			$('#apply_changes').text(text);
		}
		else {
			var text = "Apply Changes(0)";
			$('#apply_changes').text(text);
		}
	});

	$('input[name="myCheckboxes[]"]').click(function() {
  		if($('input[name="myCheckboxes[]"]:checked').length > 0) {
	  		//$('#apply_changes').show();
			var len = $('input[name="myCheckboxes[]"]:checked').length;
			var text = "Apply Changes ("+len+")";
			$('#apply_changes').text(text);
	  	}
	  	else {
	  		//$('#apply_changes').hide();
			var text = "Apply Changes(0)";
			$('#apply_changes').text(text);
	  	}
	});

	$('#aspect_adoptions').DataTable({
		fixedHeader: {
						header: true
					},
	  columnDefs: [
		  { targets: 'no-sort', orderable: false }
		],
		"pageLength": 100,
		"language":{
			"lengthMenu": change_limit(100),
			"info": "Showing _START_ to _END_ of _TOTAL_ listings"
		},
		"sDom": '<"top"i>rt<"top"flp<"clear">>rt<"bottom"flp><"clear">'
	});
	$('#aspect_adoptions').show();
	$('.no-sort').removeClass('sorting_asc');
	$('.dataTables_filter').hide();
	$('#aspect_adoptions_paginate').after(download_button);
	$('.traditional').removeClass('whirl');
	
	//search datatable
	var table = $('#aspect_adoptions').DataTable();
	$('#search_data').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
	$('#apply_changes').click(function(){
		$('.traditional').addClass('whirl');
		var count_checked = 0;
		var selected_item_id = [];
		$('input[name="myCheckboxes[]"]:checked').each(function() {
			selected_item_id.push($(this).val());
			count_checked++;
		});
		if($('#ckbCheckAll:checked').length > 0) {
	  		count_checked--;
	  	}
		
		if(count_checked > 0){
			var form_data = $('form').serializeArray();
			console.log(selected_item_id);
			var post_data1 = [];
			for (var i = 0; i < form_data.length; i++) {
				var val = form_data[i];
				if((val.name != "aspect_adoptions_length") && (val.name != "myCheckboxes[]")){
					var array = (val.name).split('_');
					var item = "ebay_item_"+array[0];
					if($.inArray( item, selected_item_id ) >= 0){
						var item_id = array[0];
						//var sku = $('#'+item).attr('data-sku');
						var sku = $('input[value="'+item+'"]').attr('data-sku');
						var aspect_name = (val.name).replace(array[0]+"_","");
						var aspect_value = val.value;
						var push_array = {};
						var aspect_data = {};
						aspect_data = {'aspect_name':aspect_name,'aspect_value':aspect_value};
						aspect_data_final = [];
						aspect_data_final.push(aspect_data);
						push_array = {'ebay_item_id': item_id,'item_sku':sku,'aspect_data':aspect_data_final};
						var k=-1;
						for(var j=0;j<post_data1.length;j++){
							var data = post_data1[j];
							if(data.ebay_item_id==item_id){
								k=j;
								break;
							}
						}
						if(k>=0){
							var aspect_temp = post_data1[k]['aspect_data'];
							aspect_temp.push(aspect_data);
							post_data1[k]['aspect_data'] = aspect_temp;
						}else{
							post_data1.push(push_array);
						}
						
					}else{
						
					}
				}else{
					
				}
			}
			$.ajax({
				type: 'POST',
				url: app_base_url + 'ebay/get_ebay_aspect_adoption_applied.php',
				async: true,
				cache: true,
				data: {'post_data':post_data1},
				//dataType: 'json',
				success: function (res) {
					$('.traditional').removeClass('whirl');
					if(res.status){
						alert("success");
						//location.reload();
					}else{
						//alert(res.msg);
					}
				}
			});
		}else{
			alert("No Sku selected");
		}
		
	});
});
</script>