<?php
	
	// Store file contents as object 	
	$file = json_decode(file_get_contents("posts.txt"));
	$newFile = Array();	

	// Check to see if current user is 'admin'
	if(isset($_POST['admin'])) {

		// Find admin specified user and remove it from file
		for($i = 0; $i < sizeof($file); $i++) {

			if($file[$i]->userID == $_POST['user'] && $file[$i]->postTitle == $_POST['title']) {

		

			} else {

				array_push($newFile, $file[$i]);

			}

		}

		file_put_contents("posts.txt", json_encode($newFile));

	// If the message already exists and matches with current user, update the message
	} else if(messageExists($_POST['userID'], $_POST['postTitle'], $file) != 0) {

		for($i = 0; $i < sizeof($file); $i++) {

			if($file[$i]->userID == $_POST['userID'] && $file[$i]->postTitle == $_POST['postTitle']) {

				$file[$i]->postID = $_POST['postID'];

			}
			

		}
		file_put_contents("posts.txt", json_encode($file));
		echo 1;

	// Otherwise simply add the new message to the beginning of our file
	} else {

		$message = Array();
		$message['userID'] = $_POST['userID'];
		$message['postID'] = $_POST['postID'];
		$message['postTitle'] = $_POST['postTitle'];
		$message['postTime'] = $_POST['postTime'];

		array_push($newFile, $message);
		for($i = 0; $i < sizeof($file); $i++) {

			array_push($newFile, $file[$i]);

		}

		file_put_contents("posts.txt", json_encode($newFile));
		echo 3;
		var_dump($_POST);

	}

	// Find if the message already exists
	function messageExists($usr, $ttl, $file) {

		for($i = 0; $i < sizeof($file); $i++) {

			if($usr == $file[$i]->userID) {

				if($ttl == $file[$i]->postTitle) {

					return 1;

				}

			}

		}

		return 0;

	}

?>