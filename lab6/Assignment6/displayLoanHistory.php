<?php

session_start();

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

$user = $_POST['user'];
$sql = "SELECT * FROM loanhistory WHERE userName = '$user'";
$rows = mysqli_fetch_all($Library->query($sql),MYSQLI_ASSOC);

$table = "<table border='2'>";

$table .= "<tr>";
$table .= "<th>userName</th>";
$table .= "<th>BookId</th>";
$table .= "<th>DueDate</th>";
$table .= "<th>ReturnedDate</th>";
$table .= "</tr>";

for($i = 0; $i < sizeof($rows); $i++) {

	$temp = $rows[$i];
	$table .= "<tr>";
		$table .= "<td>".$temp['userName']."</td>";
		$table .= "<td>".$temp['BookId']."</td>";
		$table .= "<td>".$temp['DueDate']."</td>";
		$table .= "<td>".$temp['ReturnedDate']."</td>";
	$table .= "</tr>";

}

$table .= "</table>";

echo $table;

$Library->close();

?>