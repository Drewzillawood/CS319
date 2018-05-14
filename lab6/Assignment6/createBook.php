<?php
	
session_start();

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

$bookId = $_POST['BookId'];
$sql = "SELECT * FROM books WHERE (BookId%4)=($bookId%4)";
$arr = mysqli_fetch_all($Library->query($sql));

if(sizeof($arr) < 20) {

	$bookTitle = $_POST['BookTitle'];
	$bookAuthor = $_POST['Author'];
	$sql = "INSERT INTO books(BookId, BookTitle, Author, Availability) VALUES ('$bookId','$bookTitle','$bookAuthor',1)";
	$Library->query($sql);
	$sql = "INSERT INTO booklocation(BookId, ShelfId) VALUES ($bookId, ($bookId%4))";
	$Library->query($sql);
	echo 1;

} else {

	echo 0;

}

$Library->close();

?>