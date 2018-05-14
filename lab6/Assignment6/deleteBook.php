<?php

session_start();

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

$bookId = $_POST['BookId'];
$sql = "DELETE FROM booklocation WHERE BookId=$bookId";
$Library->query($sql);
$sql = "DELETE FROM books WHERE BookId=$bookId";
$Library->query($sql);

$Library->close();	

?>