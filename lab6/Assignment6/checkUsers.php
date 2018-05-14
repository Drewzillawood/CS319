<?php

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

$usr = $_POST['username'];
$sql = "SELECT * FROM users WHERE UserName = '$usr'";
$sql = json_encode(mysqli_fetch_row($Library->query($sql)));
echo $sql;

$Library->close();

?>