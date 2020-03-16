<?php
//$data = file_get_contents("php://input");
$data = 'U2FsdGVkX19JS9PbuKpvQCKh/sN4IxhVba6Zfv8NjNQD14OFCyJjvhsmXA07qJKMfB3pWD2vXa6qvQrJzGQw/l8Npoy/RwAcrRistF0ISVazuzicfoR9B90L986pcQYhqw41LD1+zYGcPBSeQT06HQ==';
$passphrase = "38aystr0ngpa55w0rd";
/*$method = 'aes-256-cbc';
echo base64_decode($data);exit;
$key = substr(hash('sha256', $passphrase, true), 0, 32);
$iv = "";
$decrypted = openssl_decrypt(base64_decode($data), $method, $passphrase);
echo $decrypted;exit;*/
?>
<script type="text/javascript" src="aes.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="../aes-json-format.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    //var encrypt = CryptoJS.AES.encrypt('<?php echo $data ?>', '<?php echo $passphrase ?>');
	//console.log(encrypt);
    var decrypt = CryptoJS.AES.decrypt('<?php echo $data ?>', '<?php echo $passphrase ?>');
	var res = decrypt.toString(CryptoJS.enc.Utf8);
	console.log(res);
	var post_data = json_decode(res);
	
});
</script>
<div id="data"></div>