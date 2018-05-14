<?php

// Initialize session variable
session_start();
$_SESSION["usr"] = $_POST["usr"];

// Create mysqli object
$conn = new mysqli("127.0.0.1", "root", "", "drew_database");

if($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error . "<br>");

}

// Check our database for a matching username and password
$sql = "SELECT * FROM users WHERE UserName LIKE ('".$_POST['usr']."') AND Password LIKE ('".md5($_POST['psw'])."')";


// If there are no matching rows with our username and password
if(($conn->query($sql))->num_rows === 0) {

	// Do not trigger flag
	echo 0;

} else {

	// Trigger flag
	echo 1;

}

$conn->close();

?>