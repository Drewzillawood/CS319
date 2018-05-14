<?php

			session_start();
			$usr = $_GET['username'];
			$psw = $_GET['password']; 

?>

<html>

	<head>
		<title>booksLibrary</title>
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src = "booksLibrary.js"></script>

		<style>
		table, th, td {

			border: 1px solid black;

		}
		</style>

	</head>

	<body>
		
		Library of ISU <br>
		
		<input type = "hidden" id="tU" value = '<?php echo $usr?>'>
		<input type = "hidden" id="pW" value = '<?php echo $psw?>'>
		<div id = "tableSelector"></div>

	</body>

</html>