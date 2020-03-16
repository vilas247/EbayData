<?php
require 'api/vendor/autoload.php';
use Aws\S3\S3Client;
function uploadImgToS3($bucketName, $imgFilePath, $imgName,$existingUrl='')
{
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
?>