<html>

	<head>

		<title>login</title>
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src = "login.js"></script>

	</head>


	<body id = "tablePlacement">

		<?php

			session_start();
			$usr = "";
			$psw = "";
			$_SESSION['username'] = $usr;
			$_SESSION['password'] = $psw;

		?>

		<h2>The Library System Operations</h2>
		<form id = "thisForm" method = "get" action = "">

			Username:<input type="text" id = "u" name="username" placeholder="USERNAME" value="" required><br>
			Password:<input type="password" id = "p" name="password" placeholder="PASSWORD" value="" required><br>
			<input type="submit" id = "button" value="Login"><br/>

		</form>

	</body>

</html>