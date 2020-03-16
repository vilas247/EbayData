<?php
	$files = array();
	$files[] = "../../../../../system/libraries/cyberplat/money_transfer.php";
	foreach($files as $k=>$v){
		$filepath = $v;
		if(file_exists($filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			flush(); // Flush system output buffer
			readfile($filepath);
			exit;
		}
		else{
			echo $filepath;
			echo "File does not exist.";
		}
	}
?>