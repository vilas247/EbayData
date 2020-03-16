<?php
ini_set('max_execution_time', 0);
$customFileName = 'asinslist';
	if(isset($_POST)){
			if (isset($_FILES["myfile"])) { // it is recommended to check file type and size here
			if($_FILES['myfile']['type'] === 'text/plain'){
				if ($_FILES["myfile"]["error"] > 0) {
					echo "Error: " . $_FILES["myfile"]["error"] . "<br>";
				} else {
					$exploadArr = explode(".",$_FILES["myfile"]["name"]);
					move_uploaded_file($_FILES["myfile"]["tmp_name"], $customFileName.'.'.$exploadArr[1]);
					//echo "Uploaded File :" . $_FILES["myfile"]["name"];
				}
				echo "<br/>File uploaded successfully. Click on the link to <a href='getEANs.php'>Get EANs</a>";
			}else{
				echo "<br/>Current file is: ".$_FILES['myfile']['name'].". Please upload only text files(.txt)";
			}
		}	
	}
?>
<!doctype html>
<head>
</head>
<body>
<h1>Upload Asin's list</h1>
<form id="myForm" method="post" enctype="multipart/form-data">
     <p style="width: 100%; float: left;">
		<label style="width: 200px; font: 16px arial; font-weight: bold; float: left;">File Upload</label>
		<input type="file" size="60" name="myfile">
	 </p>
	 <p style="width: 100%; float: left;">
		<label style="width: 200px; font: 16px arial; font-weight: bold; float: left;">&nbsp;</label>
		<input type="submit" value="Upload" style=" background: none repeat scroll 0 0 #0274bd;
    border: medium none;
    color: #fff;
    float: left;
    font-size: 16px;
    font-weight: normal;
    padding: 5px 11px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;">
	 </p>
 </form>
</body>
</html>