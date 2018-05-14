<?php 
$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

// Generate table
function createTable() {

	// Retrieve file
	$messages = json_decode(file_get_contents("messages.txt"));
	$temp = "";
	// Retrieve only private key for current user
	$key = getKey($_POST['user']);

	// Generate a table with each row only having messages directed to current user
	for($i = 0; $i < sizeof($messages); $i++) {

		if($messages[$i]->to == $_POST['user']) {

			$temp .= "<tr>";
				$temp .= "<td>".$messages[$i]->to."</td>";
				$temp .= "<td>".$messages[$i]->from."</td>";
				$temp .= "<td>".rsa_decrypt(base64_decode($messages[$i]->message), $key)."</td>";
			$temp .= "</tr>";

		}

	}

	return $temp;

}

// Retrieve private key for current user
function getKey($user) {

	$file = json_decode(file_get_contents("users.txt"));

	for($i = 0; $i < sizeof($file); $i++) {

		if($user == rsa_decrypt(base64_decode($file[$i]->user),json_decode($file[$i]->pvky))) {

			return json_decode($file[$i]->pvky);

		}

	}
	return "notaKey";

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
<!DOCTYPE html>
<html>
<head>
	<title>inbox</title>
</head>
<body>

<h1>Welcome to your inbox!</h1>
<table border='2'>
	<tr>
		<th>TO</th>
		<th>FROM</th>
		<th>MESSAGE</th>
	</tr>
	<!-- Generate table will appear here on refresh -->
	<?php echo createTable();?>
</table>
<!-- Button to redirect to viewPosts -->
<form action="viewPosts.php" method="POST">
	<input type="hidden" name="user" value="<?php echo $_POST['user']?>">
	<input type="submit" value="View Posts">
</form>
</body>
</html>