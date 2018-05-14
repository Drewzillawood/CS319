<?php

session_start();

$user = $_SESSION["usr"];


if($_POST["time"] !== null && $_POST["diff"] !== null) {

	$time = $_POST["time"];
	$diff = $_POST["diff"]."leaderboard";

}

$conn = new mysqli("127.0.0.1", "root", "", "portfolio");

if($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error . "<br>");

}

$sql  = "INSERT INTO $diff(TimeCompleted, UserName)";
$sql .= "VALUES ('".$time."','".$user."')";
echo $user;

$conn->query($sql);

$conn->close();

?>