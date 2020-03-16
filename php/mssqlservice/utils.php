<?php

/************************************************/
/******** DATA STORAGE HELPERS ******************/
/************************************************/

define("READ",1);
define("ADD",2);
define("UPDATE",4);
define("DELETE",8);
define("ALL",READ+ADD+UPDATE+DELETE);
define("APIURL","configure.247commerce.com");//configure.247commerce.com winserver2012
define("DELIVERYAPIURL","deliver.247commerce.com");//deliver.247commerce.com winserver2012
define("COMPETEAPIURL","compete.247commerce.com"); //compete.247commerce.com
//define("COMPETEAPIURL","compete.247commerce.com");
//require 'vendor/autoload.php';  commented by vilas
require '../login/vendor/autoload.php';
use Aws\S3\S3Client;

class DataDescriptor
{
	public $data;
	public $dataFile;
	public $type;
	public $operations = 0;
	public $preWriteParser = null;
	public $preReadParser = null;
	
}
function getdbconnection(){
	
	require_once("/var/www/html/cloudhub/php/mssqlservice/db-config-ci.php");
	return $dbCI247;
	
	/*$servername = "magentodb.co13c6zl8ys8.eu-west-1.rds.amazonaws.com";
	$username = "magentouser";
	$password = "AppleGoogle34";
	$dbname = "php_session_data";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;*/  //commented by vilas
}
/* Upload Images To S3 */
function uploadImgToS3($bucketName, $imgFilePath, $imgName,$existingUrl=''){

	$client = S3Client::factory(array(
	'key' => 'AKIAJ47YDGMMN7RDQCNA',
	'secret' => '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'
	));
	if($existingUrl !=''){
		$urlExplode = explode("cloudhub-europe.s3.amazonaws.com/",$existingUrl);
		if(count($urlExplode)>1){
			$uploadImgResult = $client->deleteObject(array(
				'Bucket' => $bucketName,
				'Key' => $urlExplode[1],
				
			));
		}
	}
	
	// Below block of code is to upload the modified file into S3
	
	// Upload an object by streaming the contents of a file
	// $pathToFile should be absolute path to a file on disk
	$uploadImgResult = $client->putObject(array(
		'Bucket' => $bucketName,
		'Key' => $imgName,
		'SourceFile' => $imgFilePath,
		'ACL' => 'public-read',
	));
	return $uploadImgResult;
}
function uploadToS3($bucketName, $imgFilePath, $imgName,$existingUrl='',$dbcode){

 $client = S3Client::factory(array(
 'key' => 'AKIAJWVLXM5SOXRNMMTQ',
 'secret' => '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'
 ));
 $bucketName = 'clientfileuploads';
 if($existingUrl !=''){
  $urlExplode = explode("cloudhub-europe.s3.amazonaws.com/",$existingUrl);
		$uploadImgResult = $client->deleteObject(array(
		   'Bucket' => $bucketName,
		   'Key' => 'chatuploads/'.$dbcode.'/'.$urlExplode[1],
     ));
 }
 
 // Below block of code is to upload the modified file into S3
 
 // Upload an object by streaming the contents of a file
 // $pathToFile should be absolute path to a file on disk
 $uploadImgResult = $client->putObject(array(
  'Bucket' => $bucketName,
  'Key' => 'chatuploads/'.$dbcode.'/'.$imgName,
  'SourceFile' => $imgFilePath,
  'ACL' => 'public-read',
 ));
 return $uploadImgResult;
}

function uploadAmzCatalogueToS3($folderName, $filefullname, $filename, $existingUrl=''){

	$client = S3Client::factory(array(
					'key'    => 'AKIAJWVLXM5SOXRNMMTQ',
					'secret' => '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'
				));
	$bucket = 'clientfileuploads';
	
	if($existingUrl !=''){
		$urlExplode = explode("cloudhub-europe.s3.amazonaws.com/",$existingUrl);
		if(count($urlExplode)>1){
			$uploadImgResult = $client->deleteObject(array(
				'Bucket' => $bucketName,
				'Key' => $urlExplode[1],
				
			));
		}
	}
	
	// Below block of code is to upload the modified file into S3
	
	// Upload an object by streaming the contents of a file
	// $pathToFile should be absolute path to a file on disk
	
	/*$uploadImgResult = $client->putObject(array(
		'Bucket' => $bucketName,
		'Key' => $filename,
		'SourceFile' => $filefullname,
		'ACL' => 'public-read',
	));*/
	
			$uploadImgResult = $client->putObject(array(
				'Bucket' => $bucket,
				'Key'    => "amazoncataloguedata/".$filename,
				'SourceFile' => $filefullname,
				'ACL'    => 'public-read'
			));
									
									
	return $uploadImgResult;
}


function generate_imageUrlName( $length = 8 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$imageUrlName = substr( str_shuffle( $chars ), 0, $length );
	return $imageUrlName;
}
function imageResize($filePath,$imgName,$newwidth,$newwidth1,$existingimageUrl=''){
	$data =$filePath;
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	list(, $imagetype)      = explode(':', $type);
	list(, $imageext)      = explode('/', $imagetype);
	file_put_contents('../../customer/'.$imgName.".".$imageext, $data);
	$filePath = $_SERVER["DOCUMENT_ROOT"]."/customer/".$imgName.".".$imageext;
	
	$binary_data = file_get_contents($filePath);
	$src = imagecreatefromstring($binary_data);
	$width = imagesx($src);
	$height = imagesy($src);
	$newheight=$newwidth1;
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	$newheight1=$newwidth;
	$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
	
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	
	imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
	
	$filename = $_SERVER["DOCUMENT_ROOT"]."/customer/". $imgName.".".$imageext;
	$filename1 = $_SERVER["DOCUMENT_ROOT"]."/customer/small". $imgName.".".$imageext;
	imagejpeg($tmp,$filename,100);
	imagejpeg($tmp1,$filename1,100);
	imagedestroy($src);
	imagedestroy($tmp);
	imagedestroy($tmp1);
	
	$s3ImgUploadedData = uploadImgToS3('cloudhub-europe',$filename1,$imgName.".".$imageext,$existingimageUrl);
	$s3ImgUploadedData1 = $s3ImgUploadedData->toArray();
	$userimageurl = $s3ImgUploadedData1['ObjectURL'];
	if($userimageurl){
		unlink($filename);
		unlink($filename1);
		return $userimageurl;
	}
}
function build_from_generic($dd,$object,$merge=null)
{
	$result = $merge==null?eval("return new ".$dd->type."();"):$merge;
	foreach(get_class_vars($dd->type) as $var =>$data){
		if(strlen($var)>0){
			if(is_array($object) && isset($object[$var])){
				$dt = $object[$var];
				$result->$var=$dt;
			}else if(!is_array($object)){
				$result->$var=$object->$var;
			}
		}
	}
	return $result;
}

function generate_guid()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function load_data_file($dd)
{	
	if(!file_exists($dd->dataFile)){
		$toWrite = "[]";
		file_put_contents($dd->dataFile,$toWrite);
	}
	$toRead = file_get_contents($dd->dataFile);
	$tmpData = json_decode($toRead);
	$keys = array();
	foreach($dd->data as $k=>$v)$keys[]=$k;
	foreach($keys as $k)unset($dd->data[$k]);
	
	foreach($tmpData as $item){
		if($dd->preReadParser!=null){
			$item = call_user_func($dd->preReadParser,$item);
		}
		$dd->data[$item->id] = $item;
	}
}

function persist_data_file($dd)
{
	$writeData = array();
	foreach($dd->data as $item=>$val){
		$writeData[] = $val;
	}
	$toWrite = json_encode($writeData);
	file_put_contents($dd->dataFile,$toWrite);
}

function get_request_data()
{
	$requestData=array();
	foreach($_GET as $k=>$v) $requestData[strtolower($k)]=$v;
	foreach($_POST as $k=>$v) $requestData[strtolower($k)]=$v;
	
	if(isset($requestData["request_method"])){
		$requestData["method"] = strtoupper($requestData["request_method"]);
	}else if(isset($requestData["method"])){
		$requestData["method"] = strtoupper($requestData["method"]);
	}else{
		$requestData["method"] = strtoupper($_SERVER['REQUEST_METHOD']);
	}
	if ($requestData["method"] == 'POST' || $requestData["method"] == 'PUT'){
		$requestData["json"] = json_decode(file_get_contents('php://input'), true);
	}
	return $requestData;
}

function build_json_error($exception)
{
	return '{"result":"ko","data":{"text":"'. $exception->getMessage() .'"}}';
}

function build_json_success($object)
{
	return '{"result":"ok","data":'. json_encode($object) .'}';
}

function execute($dd)
{
	try{
		header('Content-Type: application/json');
		$data = get_request_data();
		switch($data["method"]){
			case "GET":
				if(isset($data["id"]))echo get_item_by_id($dd,$data["id"]);
				else echo get_all_items($dd);
				break;
			case "POST":
				echo save_item($dd,$data["json"]);
				break;
			case "PUT":
				echo update_item($dd,$data["id"],$data["json"]);
				break;
			case "DELETE":
				echo delete_item($dd,$data["id"]);
				break;
			default:
				header('HTTP/1.0 405 Method not allowed');
				break;
		}
	}catch(Exception $ex){
		header('HTTP/1.0 500 Internal error');
	}
}

function delete_item($dd,$id)
{
	load_data_file($dd);
	
	try {
		if(($dd->operations&DELETE) != DELETE) throw new Exception("Add operation not allowed");
		if(!isset($dd->data[$id])) throw new Exception("Missing item with id: '$id'.");
		unset($dd->data[$id]);
		persist_data_file($dd);
		return build_json_success(null);
	} catch(Exception $e) {
		return build_json_error($e);
	}
}

function get_item_by_id($dd,$id)
{
	load_data_file($dd);
	
	try {
		if(($dd->operations&READ) != READ) throw new Exception("Read operation not allowed");
		if(!isset($dd->data[$id])) throw new Exception("Missing item with id: '$id'.");
		return build_json_success($dd->data[$id]);
	} catch(Exception $e) {
		return build_json_error($e);
	}
}

function get_all_items($dd)
{
	load_data_file($dd);
	
	try {
		if(($dd->operations&READ) != READ) throw new Exception("Read operation not allowed");
		$real = array();
		foreach($dd->data as $k=>$v){
			$real[]=$v;
		}
		return build_json_success($real);
	} catch(Exception $e) {
		return build_json_error($e);
	}
}

function save_item($dd,$object)
{	
	load_data_file($dd);
	try {
		if(($dd->operations&ADD) != ADD) throw new Exception("Add operation not allowed");
		$newObject = build_from_generic($dd,$object);
		$newObject->id = generate_guid();
		if($dd->preWriteParser!=null){
			$newObject = call_user_func($dd->preWriteParser,$newObject);
		}
		$dd->data[$newObject->id] = $newObject;
		persist_data_file($dd);
		return build_json_success($newObject);
	} catch(Exception $e) {
		return build_json_error($e);
	}
}

function update_item($dd,$id,$object) 
{
	load_data_file($dd);
	
	try {
		if(($dd->operations&UPDATE) != UPDATE) throw new Exception("Add operation not allowed");
		if(!isset($dd->data[$id])) throw new Exception("Missing item with id: '$id'.");
		$previousObject = $dd->data[$id];
		$updatedObject = build_from_generic($dd,$object,$previousObject);
		if($dd->preWriteParser!=null){
			$updatedObject = call_user_func($dd->preWriteParser,$updatedObject);
		}
		$dd->data[$previousObject->id] = $updatedObject;
		persist_data_file($dd);
		return build_json_success($object);
	} catch(Exception $e) {
		return build_json_error($e);
	}
}

/************************************************/
/********* OTHER UTILITIES **********************/
/************************************************/
function ends_with($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function get_current_url() 
{
	$protocol = 'http';
	if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
		$protocol .= 's';
		$protocol_port = $_SERVER['SERVER_PORT'];
	} else {
		$protocol_port = 80;
	}

	$host = $_SERVER['HTTP_HOST'];
	$port = $_SERVER['SERVER_PORT'];
	$request = $_SERVER['PHP_SELF'];
	$query = isset($_SERVER['argv']) ? substr($_SERVER['argv'][0], strpos($_SERVER['argv'][0], ';') + 1) : '';
	$port = $port == $protocol_port ? '' : ':' . $port;
	$query = empty($query) ? '' : '?' . $query;
	
	if(!ends_with($host,$port)) $host = $host.$port;
	
	$toret = $protocol.'://'.$host.$request.$query;
	
	return $toret;
}

function send_data($verb,$url,$data=null)
{
	$url = dirname(dirname(get_current_url())).$url;
	//echo $url."<br>";
	$data_string = "";
	if($data!=null){
		$data_string = json_encode($data);
	}
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	if($data!=null){
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string)));
	}
	$response = curl_exec($ch);
	$error = curl_error($ch);
	$result = array( 'body' => '','curl_error' => '','http_code' => '','last_url' => '');
		 
	if ( $error != "" ){
		$result['curl_error'] = $error;
		return $result['curl_error']."\n<br>".$response;
	}

	$result['body'] = $response;
	$result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	$result['last_url'] = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
	//print_r($result);
	//echo "=================";
	return json_decode($result['body']);
}

function get_client_ip_utils() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

// http://coffeerings.posterous.com/php-simplexml-and-cdata
class SimpleXMLExtended extends SimpleXMLElement {
  public function addCData($cdata_text) {
    $node = dom_import_simplexml($this); 
    $no   = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
  } 
}
?>