<?php  
	error_reporting(0);
	function getdbconnection()
	{
			$db_name     = "db_ebaycategory";
			$db_username = "magentouser";
			$db_password = "AppleGoogle34";
			$hostname    = "magentodb.co13c6zl8ys8.eu-west-1.rds.amazonaws.com";
			
			// Create connection
			$conn = new mysqli($hostname, $db_username, $db_password, $db_name);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			return $conn;
	}
	
	$dbconnection = getdbconnection();
	global $siteId;

	$fromURL = $_GET['fromURL'];//'aHR0cDovL3d3dy5uZXRwcmljZWRpcmVjdC5jby51ay8yNDd0c2FkbWluL01hcmtldHBsYWNlL2luY2x1ZGVzL2F0dHJpYnV0ZV9yZWRpcmVjdC5waHA=';//
	$siteId = $_GET['siteid'];//3;//
	$accId = $_GET['accId'];//'MQ==';//
	$eid = $_GET['eid'];//9419;//$_GET['eid'];
	
	// switch($siteId) {
	// 	case 0: 
	// 		$catTableName           = "`tbl_ebay_category_new_us`"; 
	// 		$attrSetTableName       = "`tbl_ebay_attributeset_details_us`"; 
	// 		$attrListTableName      = "`tbl_ebay_attributelist_us`"; 
	// 		$attrValueTableName     = "`tbl_ebay_attributeset_values_us`"; 
	// 		$attrdepndancyTableName = "`tbl_ebay_attributeset_dependency_us`"; 
	// 	  break;
	// 	case 3: 
	// 		$catTableName           = "`tbl_ebay_category_new`"; 
	// 		$attrSetTableName       = "`tbl_ebay_attributeset_details`"; 
	// 		$attrListTableName      = "`tbl_ebay_attributelist`";
	// 		$attrValueTableName     = "`tbl_ebay_attributeset_values`";
	// 		$attrdepndancyTableName = "`tbl_ebay_attributeset_dependency`"; 
	// 	  break;
	// }

	$catTableName           = "`tbl_ebay_categories`"; 
	$attrSetTableName       = "`tbl_ebay_attributeset_details`"; 
	$attrListTableName      = "`tbl_ebay_attributelist`";
	$attrValueTableName     = "`tbl_ebay_attributeset_values`";
	$attrdepndancyTableName = "`tbl_ebay_attributeset_dependency`"; 	
	
	function checkForAttributesetId($categoryId){
		global $catTableName;
		global $dbconnection;
		$q = $dbconnection->query("SELECT `Attributesetid`, `enable_status` FROM $catTableName WHERE `Categoryid`='$categoryId'");
		$r = $q->fetch_assoc();
		
		if ($r['Attributesetid']>0 || $r['enable_status'] == "Enabled") return true; 
		else {
			print_r($r);
			return false;
		}
	}
 
 ?>
<script type="text/javascript">
function getDesiredDepth(menus) {
	var catValues = menus.value.split(",");
	var depth = catValues[1];
	document.form1.desiredDepth.value = depth;
	document.form1.submit();
}

function getClose(parentid, url, accId, eid, cat_txt) {
    //window.opener.document.form1.ebayCategoryId.value = parentid;
	//window.opener.document.form1.ebayCategoryId.focus();
	//window.opener.location.href='create_inventory.php?inventory='+'ebay'+'&ebayCategoryId='+parentid;
	//window.opener.document.getElementById('attribute').style.display='block';
	//window.close();
	//window.opener.location.href('create_inventory.php?inventory='+'ebay'+'&id='+parentid);
	//location.href('add_ebayinventory.php?id='+parentid);
	// Main URL Start
	// var url = 'http://www.247cloudhub.co.uk/#/app/capture-cat-acctids'
	
	// Main URL End
	
	// Showcase URL Start
	 var url = 'https://showcase.247cloudhub.co.uk/#/app/capture-cat-acctids'
	
	// Showcase URL End
	//document.location.href = url+"?categoryId="+parentid+"&accId="+accId+"&eid="+eid;
	var w = 4;
	var h = 4;
	//var cat_txt = document.getElementById('show_category').value;
	var cat_text = cat_txt.replace('&','__');
	var mypage = url+"?categoryId="+parentid+"&accId="+accId+"&dbeid="+eid+"&cat_txt="+cat_text;
	var myname = 'Loading';

	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	//console.log(cat_txt+'-----'+unescape(cat_txt));
	
	settings = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=yes,toolbar=no';
	win = window.open(mypage, myname, settings);
	self.close();
}

function redirectToAttribute(parentid, fromURL, accId, siteid) {
	document.location.href = 'display_ebay_attributes_new.php?categoryID='+parentid+'&fromURL='+fromURL+"&accId="+accId+"&siteid="+siteid;
}
</script>

<?php 
//require_once("../../db_connect.php");
function calculateChild($childCategory,$dsiteId)
{
	global $catTableName;
	global $dbconnection;
	$queryChild =  $dbconnection->query("select count(*) as `childCount` from $catTableName where `SiteId`='$dsiteId' and `parentId`='$childCategory' AND `parentId`!=`Categoryid`");
	$arrChild   =  $queryChild->fetch_assoc();
	if($arrChild['childCount'] > 0)
	{
	$childSymbol=">>";
	return $childSymbol;
	}
	else
	{
	$childSymbol="";
	return $childSymbol;
	}

}
$txt_CAM_CNAM_display = "";
$allCatIds[]    = "";
$allCatLevels[] = 1;
$desiredDepth = 1;
if(isset($_REQUEST['desiredDepth']) && $_REQUEST['desiredDepth'] != '') $desiredDepth = $_REQUEST['desiredDepth']+1;
if(isset($_POST['submitted']) && $_POST['submitted'] == 1) {
	$CAM_CNAM_display = $_POST['show_category'];
	$CAM_CNAM_display = "";
	foreach($_POST['loops'] as $loops) {
		$postedValues= $_REQUEST['cat_'.$loops];
		list($catId, $depth) = explode(",", $postedValues);
		if($catId != '' && $depth != '') {
			$allCatIds[]    = $catId;
			$allCatLevels[] = $depth + 1;
		}
	}	
}

function displayMenu($parentId = "", $level, $i=0, $matchId,$dsiteId) {
	global $catTableName;
	global $CAM_CNAM_display;
	global $txt_CAM_CNAM_display;
	global $dbconnection;
	global $fromURL;
	global $accId;
	global $eid;
	// $select = "SELECT `parentId`, `Name`, `Level`, `Categoryid` FROM $catTableName WHERE `eBAYId`!=''";
	$select = "SELECT `parentId`, `Name`, `Level`, `Categoryid` FROM $catTableName WHERE `SiteId` = '$dsiteId'";
	if($parentId == "") $condition = " AND `parentId`!=''";
	else $condition = " AND `parentId`='$parentId'";	
	$condition .= " AND `Level`='$level'";
	$select .= $condition;

	$query = $dbconnection->query($select) or die(mysqli_error());
	if(mysqli_num_rows($query)) {
		$options = "<td width=\"15px\"><select name=\"cat_$i\" size=\"10\" onchange=\"getDesiredDepth(document.form1.cat_$i)\">";
		while($row = $query->fetch_array()) {
		    $displayArrow = calculateChild($row['Categoryid'],$dsiteId);
			if($row['Categoryid'] == $matchId)
				{ $options .= "<option value=\"".$row['Categoryid'].",".$row['Level']."\" selected=\"selected\">".$row['Name']." ".$displayArrow."</option>"; 
					$CAM_CNAM_display .= $row['Name']." ".$displayArrow;
				}
					
			else
				{ $options .= "<option value=\"".$row['Categoryid'].",".$row['Level']."\">".$row['Name']." ".$displayArrow."</option>"; }
		}	
		$options .= "</select></td>";
		echo $options;
	}
	else
	{
		$CAM_CNAM_display_alias=str_replace("'","\'",$CAM_CNAM_display);
	//	if (checkForAttributesetId($parentId))
	//	echo "</tr><tr><td width=\"25px\" colspan=\"5\"><input type=\"text\" value=\"".htmlspecialchars($CAM_CNAM_display)."\" name=\"txt_CAM_CNAM_display\" style=\"width:400px;\" /><input name=\"cat_name\" type=\"textbox\" value=\"$parentId\"/>&nbsp;<input name=\"cat_submit\" type=\"button\" value=\"Select\" onclick=\"javascript:getClose($parentId, '".base64_decode($fromURL)."', '".base64_decode($accId)."','".$eid."', '".htmlspecialchars($CAM_CNAM_display_alias)."')\"/></td>";
	//	else
		// echo "</tr><tr><td width=\"25px\" colspan=\"5\"><input type=\"text\" value=\"".htmlspecialchars($CAM_CNAM_display)."\" name=\"txt_CAM_CNAM_display\" style=\"width:400px;\" /><input name=\"cat_name\" type=\"textbox\" value=\"$parentId\"/>&nbsp;<input name=\"cat_submit\" type=\"button\" value=\"Select\" onclick=\"javascript:getClose($parentId, '".base64_decode($fromURL)."', '".base64_decode($accId)."','".$eid."', '".htmlspecialchars($CAM_CNAM_display_alias)."')\"/></td>";
		echo "</tr><tr><td width=\"25px\" colspan=\"5\"><input type=\"text\" value=\"".$CAM_CNAM_display."\" name=\"txt_CAM_CNAM_display\" style=\"width:400px;\" /><input name=\"cat_name\" type=\"textbox\" value=\"$parentId\"/>&nbsp;<input name=\"cat_submit\" type=\"button\" value=\"Select\" onclick=\"javascript:window.parent.getCloseCategory($parentId, '".base64_decode($fromURL)."', '".base64_decode($accId)."','".$eid."', '".htmlspecialchars($CAM_CNAM_display_alias)."')\"/></td>";
	}
}
?>
<form id="form1" name="form1" method="post" action="">
<table width="50%" border="0">
<tr>
<?php
	for($i=0; $i<$desiredDepth; $i++) {
		echo "<input name=\"loops[]\" type=\"hidden\" value=\"$i\" />";
		displayMenu($allCatIds[$i], $allCatLevels[$i], $i, $allCatIds[$i+1],$siteId);
		$searchg = substr(trim($CAM_CNAM_display), -1);
		$CAM_CNAM_display_alias=str_replace("'","\'",$CAM_CNAM_display);
	}
	//print "<pre>";
//print_r($allCatIds);

?>
</tr>
</table>
<input name="submitted" type="hidden" value="1" />
<input name="desiredDepth" type="hidden" value="" />
<input name="show_category" id="show_category" type="hidden" value="<?=$CAM_CNAM_display ?>" />
<!--<label>
<select name="select" size="10" id="select">
</select>
</label>-->
</form>
<script>
console.log(window.parent.AWS);
</script>