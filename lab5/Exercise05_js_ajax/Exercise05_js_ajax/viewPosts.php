<?php

// Begin session with username
session_start();
$_SESSION = Array(

	"user" => $_POST['user']

);

// Retrieve file contents
$file = file_get_contents("posts.txt");
function createTable($table) {

	// Turn into JSON object
	$arr = json_decode($table);
	$temp = "";

	// Retrieve all values from file
	// Piece together our html table from the file contents
	for($i = 0; $i < sizeof($arr); $i++) {

		$temp .= "<tr class=".$arr[$i]->userID." id="."'".$arr[$i]->userID.str_replace(array("'", " "), '',$arr[$i]->postTitle)."'".">";
			$temp .= "<td>".$arr[$i]->postTitle."</td>";
			$temp .= "<td>".$arr[$i]->postID."</td>";
			$temp .= "<td>".$arr[$i]->postTime."</td>";
		$temp .= "</tr>";

	}
	return $temp;

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>viewPosts</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

<table id="myTable" border="2">
	<tr id="headers">
		<th>Title</th>
		<th>Description</th>
		<th>Time</th>
	</tr>
	<!-- Table creation occurs here upon refresh -->
	<?php echo createTable($file);?>
</table>
<!-- This is our update posts button -->
<!-- NOTE: UPDATE POSTS WILL OCCUR WHEN ENTERING TITLE OF
           AN EXISTING USER AND TITLE. THE NEW DESCRIPTION
           WILL OVERWRITE THE OLD ONE, AS OPPOSED TO CLICKING
           ON THE ELEMENT TO CHANGE THE DESCRIPTION -->
<input id="uButton" type="button" value="Update Posts"><br>
<!-- This is our send message button -->
<input id="send"	type="button" value="Send Message"><br>
<!-- This button will redirect user to their inbox -->
<form method="POST" action="inbox.php">
	<input type='hidden' name='user' value='<?php echo $_SESSION['user'];?>'>
	<input type='submit' value="Inbox">
</form>
<!-- logout button to destroy session -->
<form id="lout" action="login.php">
	<input id="logout" type='button' value="Logout">
</form>
<!-- Fillable div for displaying confirmation of succesful message -->
<div id="confirm"></div>
<!-- Fillable div for displaying update posts UI for user -->
<div id="update"></div>
<!-- Fillable div for displaying message UI for user -->
<div id="sendm"></div>
</body>

<script>
	
	$(document).ready(function() {

		// Update posts on click handler
		$("#uButton").click(function() {

			// Check if user is currently admin
			if('<?php echo $_SESSION['user'];?>' != "admin")  {

				// Create UI for user
				$("#update").html("<br><form id='temp'>Title: <input id='title' type='text'><br>Message: <input id='message' type='text'><br><input id='subButton' type='button' value='Submit'></form>");

				// Post click handler
				$("#subButton").click(function() {

					// Ajax call after submitting post values
					$.ajax({

						// Passing in values from input
						// 		- USERNAME
						//		- POST ID (MESSAGE CONTENT)
						// 		- TITLE OF POST
						// 		- TIME OF POST
						url : 'updatePosts.php',
				    	type : 'POST',
				    	data : {userID : "<?php echo $_SESSION['user'];?>",
				        	    postID : $("#message").val(),
				       		 	postTitle : $("#title").val(), 
				       		 	postTime   : Date()},
				    	success : function(output) {

				    		// Modify already existing post
				    		if(output == 1) {

					    		var oldEntry = "#";
					    		oldEntry += "<?php echo $_SESSION['user'];?>";
					    		oldEntry += $("#title").val().replace(/[\s']/g, '');
					    		oldEntry = (oldEntry + ' :nth-child(2)');
					    		$(oldEntry).text($("#message").val());

					    	// Insert new row at top of our table
					    	} else {

					    		var newEntry = "<tr class='<?php echo $_SESSION['user'];?>' id=";
				    			newEntry += "<?php echo $_SESSION['user'];?>";
				    			newEntry += $("#title").val().replace(/[\s']/g, '');
				    			newEntry += ">";
					    		newEntry += "<td>"+$("#title").val()+"</td>";
					    		newEntry += "<td>"+$("#message").val()+"</td>";
					    		newEntry += "<td>"+Date()+"</td>"; 
				    			newEntry += "</tr>";
				    			$(newEntry).insertAfter("#headers");

				    		}
				    		// Remove UI
				    		$("#update").empty();
				    		$(".<?php echo $_SESSION['user'];?> :nth-child(2)").dblclick(function() {

								$(this).html("<form id='clickForm'><input id='tempInput' type='text' value='"+$(this).text()+"'></form>");

									$("#clickForm").submit(function(e) {

										e.preventDefault();
										var temp = $("#tempInput").val();
										$(this).html(temp);
										var tempTitle = ($($(this).parent().parent().html()).html());

									$.ajax({

										url : 'updatePosts.php',
										type : 'POST',
										data : {userID : '<?php echo $_SESSION['user'];?>',
												postID : temp,
												postTitle : tempTitle,
												postTime : Date()}

									});

								});

							});

				    	}

					});

				});

			} else {

				// Admin UI, allows deletion of posts via selection of title and known user
				$("#update").html("<br><form id='adminForm'>User : <input id='user' type='text'><br>Title of message to delete:<br><input id='title' type='text'><br><input id='subButton' type='button' value='Delete'></form>");

				// On Deletion button click
				$("#subButton").click(function (){ 

					// Pass value of user and title through ajax
					$.ajax({

						url : 'updatePosts.php',
						type : 'POST',
						data : {admin : 'admin',
								user  : $("#user").val(),
								title : $("#title").val()},
						success : function(output) {

							// Select element to delete
							$('#'+$("#user").val()+$("#title").val().replace(/[\s']/g, '')).remove();
							$("#update").empty();

						}

					});

				});

			}

		});

		$("#send").click(function() {

			// Generate UI for sending a message
			$("#sendm").html("<br><form id='sendForm'>TO: <input id='receiver' type='text'><br>MESSAGE: <input id='content' type='text'><br><input id='sendSubmit' type='button' value='Send'>");

			// On send click event
			$("#sendSubmit").click(function() {

				$("confirm").html("");
				// Use ajax call to send our message server side
				$.ajax({

					url : 'sendMessage.php',
					type : 'POST',
					data : {to : $("#receiver").val(),
							from : '<?php echo $_SESSION['user'];?>',
							message : $("#content").val()},
					success : function(output) {

						if(output == 1) {

							$("#confirm").html("Message Sent Succesfully.");

						} else {

							$("#confirm").html("Invalid Recipient.")

						}
						$("#sendm").empty();

					}

				});

			});

		});

		$("#logout").click(function() {

			$.ajax({

				url : 'logout.php',
				success : function(output) {

					$("#lout").submit();

				}

			});

		});

		$(".<?php echo $_SESSION['user'];?> :nth-child(2)").dblclick(function() {

			$(this).html("<form id='clickForm'><input id='tempInput' type='text' value='"+$(this).text()+"'></form>");

			$("#clickForm").submit(function(e) {

				e.preventDefault();
				var temp = $("#tempInput").val();
				$(this).html(temp);
				var tempTitle = ($($(this).parent().parent().html()).html());

				$.ajax({

					url : 'updatePosts.php',
					type : 'POST',
					data : {userID : '<?php echo $_SESSION['user'];?>',
							postID : temp,
							postTitle : tempTitle,
							postTime : Date()}

				});

			});

		});

	});

</script>
</html>