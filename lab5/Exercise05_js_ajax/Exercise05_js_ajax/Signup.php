<?php
$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

$rsa = new Crypt_RSA();
$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
extract($rsa->createKey(1024)); /// makes $publickey and $privatekey available

// Flag to indicate whether username is available or not
$flag = 1;
$json = Array();
// We now have the user and their respective keys
$json = generateNewJsonObject($json, $publickey, $privatekey);

// Retrieve file in a variable as an object to compare
// against our current user and be sure their username
// is not already taken
$file = json_decode(file_get_contents("users.txt"));
$newFile = Array();

// Empty file case, simply put the new user object into file
if(sizeof($file[0]) === 0 || $file === "") {

	array_push($newFile, $json);
	file_put_contents("users.txt", json_encode($newFile));
	echo $flag;

// Check that there wasn't a blank username
} else if(isset($json['user']) && isset($json['pswd'])) {

	$flag = 1;
	for($i = 0; $i < sizeof($file); $i++) {

		// Scan through all current users
		// I encrypted my users and passwords in storage
		// So I decrypt them here for comparison
		if(rsa_decrypt(base64_decode($file[$i]->user), json_decode($file[$i]->pvky)) === rsa_decrypt(base64_decode($json['user']),json_decode($json['pvky']))) {

			// If user does exist, flag becomes 0 to indicate it
			$flag = 0;

		} 

		// Push all users into file
		array_push($newFile, $file[$i]);

	}

	// If new user is valid, push into file as well
	if($flag == 1) {

		array_push($newFile, $json);

	}

	// Override current file with updated file
	file_put_contents("users.txt", json_encode($newFile));

	// Echo value for ajax call
	echo $flag;

}
// Helper function to generate a JSON object for our user
function generateNewJsonObject($obj, $pkey, $pvky) {

	// Using $_POST super global to retrieve our values
	if((isset($_POST['user']) && isset($_POST['pswd']))) {

		if($_POST['user'] != "" && $_POST['pswd'] != "") {

			// I encrypt my user and password strings into the JSON object
			$obj['user'] = json_encode(base64_encode(rsa_encrypt($_POST['user'], $pkey)));
			$obj['pswd'] = json_encode(base64_encode(rsa_encrypt($_POST['pswd'], $pkey)));
			$obj['pkey'] = json_encode($pkey);
			$obj['pvky'] = json_encode($pvky);

		}

 	}
 	return $obj;

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


