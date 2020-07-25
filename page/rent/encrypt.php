<?php 
$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';
 
function encryptthis($data, $key) {
	$encryption_key = base64_decode($key);
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
	return base64_encode($encrypted . '::' . $iv);
}
 
function decryptthis($data, $key) {
	$encryption_key = base64_decode($key);
	list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
/* 
if(isset($_POST['submit'])){
$data=$_POST['foo'];
$encrypted=encryptthis($data, $key);
$decrypted=decryptthis($encrypted, $key);
echo '<h2>Original Data</h2>';
echo '<p>'.$data.'</p>';
echo '<h2>Encrypted Data</h2>';
echo '<pre>'.$encrypted.'</pre>';
echo '<h2>Decrypted Data</h2>';
echo '<p>'.$decrypted.'</p>';
}
 
echo '<form method="post">
<input type="text" name="foo">
<input type="submit" name="submit" value="submit">
</form>';
*/
?>