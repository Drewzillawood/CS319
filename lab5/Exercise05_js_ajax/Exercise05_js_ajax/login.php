<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<h1>Please Login with your Username and Password</h1>

<!-- Simple form for login -->
<form id="login" method="post" action="viewPosts.php">

	Username: <input id = "usr" name="user" type="text"><br>
	Password: <input id = "psw" type="password"><br><div id="err"></div>
			  <input id = "sub" type="button" value="login">

</form>
</html>

<script>

	$(document).ready(function() {	

		// On click use ajax call to php file
		$("#sub").click(function() {

			// Pass username and password values to checkLogin.php
			$.ajax({
				url : 'checkLogin.php',
				type : 'POST',
				data : { user :  $("#usr").val(),
						 pswd :  $("#psw").val()},
				success : function(output) {

					// If username was valid, direct to login
					if(output == 1) {

						$("#login").submit();

					// Else do not direct anywhere, display error message
					} else {

						$("#err").html("Incorrect username or password");

					}

				}

			});
		
		});

	});

</script>