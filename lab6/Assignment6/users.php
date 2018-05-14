<?php

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

class Librarian {

	public function __construct() {



	}

}

class Student {

	public function __construct($Library) {

		$this->userName = $_SESSION['usr'];
		
	}

	public function checkoutBook($book, $Library) {

		$sql = "UPDATE books SET Availability = 0 WHERE BookTitle='$book'";
		$Library->query($sql);
		$sql = "INSERT INTO loanhistory(userName, BookId, DueDate, ReturnedDate) VALUES ('$this->userName', '$book', date('m/d/Y', time()), '')";

	}

	public function returnBook($book, $Library) {

		$sql = "UPDATE books SET Availability = 1 WHERE BookTitle='$book'";
		$Library->query($sql);

	}

}

$Library->close();

?>