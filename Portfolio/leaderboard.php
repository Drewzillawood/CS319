<?php

$conn = new mysqli("127.0.0.1", "root", "", "portfolio");

if($conn->connect_error) {

	die("Connection failed: ".$conn->connect_error."<br>");

}

$sql = "SELECT * FROM easyleaderboard";
$easy = mysqli_fetch_all($conn->query($sql), MYSQLI_ASSOC);
$sql = "SELECT * FROM intermediateleaderboard";
$inte = mysqli_fetch_all($conn->query($sql), MYSQLI_ASSOC);
$sql = "SELECT * FROM expertleaderboard";
$expe = mysqli_fetch_all($conn->query($sql), MYSQLI_ASSOC);

$table  = "<table border = '2'>";
$table .= "<tr>";
$table .= "<th colspan = '3'>EASY</th>";
$table .= "<th colspan = '3'>INTERMEDIATE</th>";
$table .= "<th colspan = '3'>EXPERT</th>";
$table .= "</tr>";

for($i = 0; $i < sizeof($easy) || $i < sizeof($inte) || $i < sizeof($expe); $i++) {

	$easyTemp = null;
	$inteTemp = null;
	$expeTemp = null;

	if($i < sizeof($easy)) {

		$easyTemp = $easy[$i];

	}
	if($i < sizeof($inte)) {

		$inteTemp = $inte[$i];

	}
	if($i < sizeof($expe)) {

		$expeTemp = $expe[$i];

	}

	$table .= "<tr>";
	$table .= "<td>".($i+1)."</td>";
	if(null !== $easyTemp) {

		$table .= "<td>".$easyTemp["UserName"]."</td>";
		$table .= "<td>".$easyTemp["TimeCompleted"]."</td>";

	} else {

		$table .= "<td></td>";
		$table .= "<td></td>";

	}
	$table .= "<td>".($i+1)."</td>";
	if(null !== $inteTemp) {

		$table .= "<td>".$inteTemp["UserName"]."</td>";
		$table .= "<td>".$inteTemp["TimeCompleted"]."</td>";

	} else {

		$table .= "<td></td>";
		$table .= "<td></td>";

	}
	$table .= "<td>".($i+1)."</td>";
	if(null !== $expeTemp) {

		$table .= "<td>".$expeTemp["UserName"]."</td>";
		$table .= "<td>".$expeTemp["TimeCompleted"]."</td>";

	} else {

		$table .= "<td></td>";
		$table .= "<td></td>";

	}
	$table .= "</tr>";

}

$table .= "</table>";

echo $table;

$conn->close();

?>