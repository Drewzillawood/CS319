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
$dueDay = date("d") + 7;
$dueMonth = date("m");
$dueYear = date("Y");
$dueDate = $dueYear."/".$dueMonth."/".$dueDay;

$sql = "SELECT * FROM loanhistory WHERE userName='$user'";
$arr = mysqli_fetch_all($Library->query($sql),MYSQLI_ASSOC);
$size = 0;
for($i = 0; $i < sizeof($arr); $i++) {

	$temp = $arr[$i];
	if(empty($temp['ReturnedDate'])) {

		$size++;

	}

}


if($size < 2) {

	$sql = "INSERT INTO loanhistory(userName, BookId, DueDate, ReturnedDate) VALUES('$user', '$BookId', '$dueDate', null)";
	$Library->query($sql);
	$sql = "UPDATE books SET Availability = 0 WHERE BookTitle='$bookTitle'";
	$Library->query($sql);
	echo 1;

} else {

	echo 0;

}

$Library->close();

?>