<?php
$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

$users = json_decode(file_get_contents("users.txt"));
$user = Array();
$userExists = 0;
for($i = 0; $i < sizeof($users); $i++) {

	if(rsa_decrypt(base64_decode($users[$i]->user), json_decode($users[$i]->pvky)) === $_POST['to']) {

		$user = $i;
		$userExists = 1;

	}

}

if($userExists == 1) {

	$messages = json_decode(file_get_contents("messages.txt"));
	if(is_null($messages)) {

		$messages = Array();

	}
	$message['to'] = $_POST['to'];
	$message['from'] = $_POST['from'];
	$message['message'] = base64_encode(rsa_encrypt($_POST['message'], json_decode($users[$user]->pkey)));
	array_push($messages, $message);
	file_put_contents("messages.txt", json_encode($messages));
	echo $userExists;

} else {

	echo $userExists;

}

//Function for encrypting with RSA
function rsa_encrypt($string, $public_key) {
    //Create an instance of the RSA cypher and load the key into it
    $cipher = new Crypt_RSA();
    $cipher->loadKey($public_key);
    //Set the encryption mode
    $cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    //Return the encrypted version
    return $cipher->encrypt($string);
}



//Function for decrypting with RSA 
function rsa_decrypt($string, $private_key) {
    //Create an instance of the RSA cypher and load the key into it
    $cipher = new Crypt_RSA();
    $cipher->loadKey($private_key);
    //Set the encryption mode
    $cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    //Return the decrypted version
    return $cipher->decrypt($string);
}

?>