<?php
// Turn off all error reporting
error_reporting(0);
ini_set('max_execution_time', 0);
header('content-type: application/json;');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

	try{
		$params = json_decode(file_get_contents('php://input'),true);
		//echo json_encode(array('posts'=>$params));exit;
			if(isset($params) && isset($params['callFunction']))
			{
				if(isset($params['callFunction']) && $params['callFunction']!="")
				{   
					$funName = $params['callFunction'];
					$funName($params);
				}
			}			
			//echo build_json_success($result);

	}catch(Exception $ex){
			//echo build_json_error($ex);
	}
	
/******************** START - Product Catalogue***********************/
	function getreportsdbconnection()
	{
		$servername = "magentodb.co13c6zl8ys8.eu-west-1.rds.amazonaws.com";
		$username = "magentouser";
		$password = "AppleGoogle34";
		$dbname = "ReportsDB";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}

	function getReportTypesFromDB($reqArray)
	{
		$reportsdbcon = getreportsdbconnection();
		//$dbconnection = $GLOBALS['dbconnection'];
		$marketplace = $reqArray['marketplacecode'];
		$getReportType = "SELECT * FROM markteplacereportype WHERE FKMarketplaceCode='".$marketplace."' AND Active=1";
		$getReportTypeQry = $reportsdbcon->query($getReportType);
		$returnValues = array();
		if(mysqli_num_rows($getReportTypeQry)) 
		{	$repTypes = array();
			while($reportTypeRes = mysqli_fetch_assoc($getReportTypeQry)) 
			{
				 $repTypes[] = $reportTypeRes;
			}
		}
		
		if(count($repTypes)<=0) 
		{
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'No Report Types Found';
		}else {
			$returnValues['statuscode'] = 0;
			$returnValues['reportTypes'] = $repTypes;
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function insertAmzEANUPCData($reqArray)
	{
		 $reportsdbcon = getreportsdbconnection();
		 $uuid  = uniqid();
		 $curDateTime = date("Y-m-d H:i:s");
		 $insertsql = "INSERT INTO marketplacereportdetails (Dbcode,FKAccountCode,FKMarketplaceCode,RequestedBy,RequestedDate,S3Url,Status,BatchID,FKReportType) VALUES ('".$reqArray['dbcode']."','".$reqArray['amazonAcct']."','".$reqArray['marketplacecode']."','".$reqArray['usercode']."','".$curDateTime."','".$reqArray['s3url']."',0, '".$uuid."','".$reqArray['reporttype']."')";
		 $returnValues = array();
		if($reportsdbcon->query($insertsql)) 
		{
			$returnValues['statuscode'] = 0;
			$returnValues['statusmessage'] = "success";
		}else {
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'Insertion Failed';
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function getAmzImgDownloadData($reqArray)
	{
		$reportsdbcon = getreportsdbconnection();
		$marketplace = $reqArray['marketplacecode'];
		$dbcode = $reqArray['dbcode'];
		$usercode = $reqArray['usercode'];
		
		$getReportDetails = "SELECT * FROM marketplacereportdetails WHERE FKMarketplaceCode='".$marketplace."' AND Dbcode='".$dbcode."' AND Active=1 ORDER BY PKMarketplaceReportDetailsCode DESC";
		$getReportDetailsQry = $reportsdbcon->query($getReportDetails);
		$returnValues = array();
		$repTypes = array();
		if(mysqli_num_rows($getReportDetailsQry)) 
		{	
			while($reportTypeRes = mysqli_fetch_assoc($getReportDetailsQry)) 
			{
				 $repTypes[] = $reportTypeRes;
			}
		}
		
		if(count($repTypes)<=0) 
		{
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'No Records Found';
		}else {
			$returnValues['statuscode'] = 0;
			$returnValues['reportdetails'] = $repTypes;
		}
		echo json_encode(array('data'=>$returnValues));
		
	}
	
	function insertAmzPrdDownloadData($reqArray)
	{
		$reportsdbcon = getreportsdbconnection();
		 $uuid  = uniqid();
		 $curDateTime = date("Y-m-d H:i:s");
		 $insertsql = "INSERT INTO marketplaceinventoryreport (FKAccountCode, FKMarketplaceCode, DBCode, RequestedBy, RequestedDate, InputFileURL, Status, AsinOrProductInfo, BatchID, Active) VALUES ('".$reqArray['amazonAcct']."','".$reqArray['marketplacecode']."','".$reqArray['dbcode']."','".$reqArray['usercode']."','".$curDateTime."','".$reqArray['s3url']."',0, '".$reqArray['fieldType']."','".$uuid."','1')";
		 $returnValues = array();
		if($reportsdbcon->query($insertsql)) 
		{
			$returnValues['statuscode'] = 0;
			$returnValues['statusmessage'] = "success";
		}else {
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'Insertion Failed';
		}
		echo json_encode(array('data'=>$returnValues));
	}	
	
	function getAmzPrdsDownloadData($reqArray)
	{
		$reportsdbcon = getreportsdbconnection();
		$marketplace = $reqArray['marketplacecode'];
		$dbcode = $reqArray['dbcode'];
		$usercode = $reqArray['usercode'];
		
		$getReportDetails = "SELECT * FROM marketplaceinventoryreport WHERE FKMarketplaceCode='".$marketplace."' AND DBCode='".$dbcode."' AND Active=1 ORDER BY PKMarketplaceInventoryReportCode DESC";
		$getReportDetailsQry = $reportsdbcon->query($getReportDetails);
		$returnValues = array();
		$repTypes = array();
		if(mysqli_num_rows($getReportDetailsQry)) 
		{	
			while($reportTypeRes = mysqli_fetch_assoc($getReportDetailsQry)) 
			{
				 $repTypes[] = $reportTypeRes;
			}
		}
		
		if(count($repTypes)<=0) 
		{
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'No Records Found';
		}else {
			$returnValues['statuscode'] = 0;
			$returnValues['prdsdetails'] = $repTypes;
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function inserteBayToolsData($reqArray)
	{
		 $reportsdbcon = getreportsdbconnection();
		 $uuid  = uniqid();
		 $curDateTime = date("Y-m-d H:i:s");
		 $insertsql = "INSERT INTO marketplaceinventoryreport (FKAccountCode, FKMarketplaceCode,DBCode,RequestedBy,RequestedDate, InputFileURL,Status,eBayCategoryOrStoreCategoryOrItemInformation, BatchID,Active) VALUES ('".$reqArray['ebayAcct']."','".$reqArray['marketplacecode']."','".$reqArray['dbcode']."','".$reqArray['usercode']."','".$curDateTime."','".$reqArray['s3url']."',0, '".$reqArray['cattype']."', '".$uuid."',1)";
		 $returnValues = array();
		if($reportsdbcon->query($insertsql)) 
		{
			$returnValues['statuscode'] = 0;
			$returnValues['statusmessage'] = "success";
		}else {
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'Insertion Failed';
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function deleteAmzImgsToolsData($reqArray)
	{
		 $reportsdbcon = getreportsdbconnection();
		 $deletesql = "DELETE FROM marketplacereportdetails WHERE PKMarketplaceReportDetailsCode='".$reqArray['PKMarketplaceReportTypeCode']."'";
		 $returnValues = array();
		if($reportsdbcon->query($deletesql)) 
		{
			$returnValues['statuscode'] = 0;
			$returnValues['statusmessage'] = "success";
		}else {
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'Delete Failed';
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function deleteAmzToolsData($reqArray)
	{
		 $reportsdbcon = getreportsdbconnection();
		 $deletesql = "DELETE FROM marketplaceinventoryreport WHERE PKMarketplaceInventoryReportCode='".$reqArray['PKMarketplaceInventoryReportCode']."'";
		 $returnValues = array();
		if($reportsdbcon->query($deletesql)) 
		{
			$returnValues['statuscode'] = 0;
			$returnValues['statusmessage'] = "success";
		}else {
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'Delete Failed';
		}
		echo json_encode(array('data'=>$returnValues));
	}
	
	function getAmazonCatalogueNodesFromDB()
	{
		$reportsdbcon = getreportsdbconnection();
		$getAmzCatNodes = "SELECT * FROM 247ch_categories";
		$getAmzCatNodesQry = $reportsdbcon->query($getAmzCatNodes);
		$returnValues = array();
		$nodeTypes = array();
		if(mysqli_num_rows($getAmzCatNodesQry)) 
		{	
			while($nodeRes = mysqli_fetch_assoc($getAmzCatNodesQry)) 
			{
				 $nodeTypes[] = $nodeRes;
			}
		}
		
		if(count($nodeTypes)<=0) 
		{
			$returnValues['statuscode'] = 404;
			$returnValues['statusmessage'] = 'No Records Found';
		}else {
			$returnValues['statuscode'] = 0;
			$returnValues['nodes'] = $nodeTypes;
		}
		echo json_encode($returnValues);
		
	}
	
		
/******************** END - Product Catalogue***********************/
?>