<?php

$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

// Retrieve user and password
$usr = $_POST['user'];
$psw = $_POST['pswd'];

$file = json_decode(file_get_contents("users.txt"));
// Check that both username and password are valid
for($i = 0; $i < sizeof($file); $i++) {

	if(rsa_decrypt(base64_decode($file[$i]->user), json_decode($file[$i]->pvky)) === $usr && rsa_decrypt(base64_decode($file[$i]->pswd), json_decode($file[$i]->pvky)) === $psw) {

		echo json_decode("true");

	} 

}

//Function for decrypting with RSA 
function rsa_decrypt($string, $private_key)
{
    //Create an instance of the RSA cypher and load the key into it
    $cipher = new Crypt_RSA();
    $cipher->loadKey($private_key);
    //Set the encryption mode
    $cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    //Return the decrypted version
    return $cipher->decrypt($string);
}

?>