<?php
	
session_start();

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

$user = $_SESSION['usr'];
$book = $_POST;
$bookTitle = $book['book'][1];
$BookId = $book['book'][0];
date_default_timezone_set("America/Chicago");
$returnDay = date("d");
$returnMonth = date("m");
$returnYear = date("Y");
$returnedDate = $returnYear."/".$returnMonth."/".$returnDay;
$sql = "UPDATE loanhistory SET ReturnedDate = '$returnedDate' WHERE BookId = '$BookId' AND userName = '$user'";
$Library->query($sql);
$sql = "UPDATE books SET Availability = 1 WHERE BookTitle='$bookTitle'";
$Library->query($sql);
$Library->close();

?>