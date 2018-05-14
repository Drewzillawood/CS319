<?php

$user = new User($_POST['usr']);
$conn = new mysqli("127.0.0.1", "root", "", "portfolio");

if($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error . "<br>");

}

$sql = "SELECT * FROM users WHERE UserName='".$user->usr."'";
$sql = $conn->query($sql);

if($user->isAlphanumeric() && $user->isAlphabetical() && $user->passwordsMatch() && $user->isEmailAddress() && $sql->num_rows === 0) {

	$sql =  "INSERT INTO users(UserName, FirstName, LastName, Email, Password)";
	$sql .= "VALUES ('".$user->usr."','".$user->fnm."','".$user->lnm."','".$user->eml."','".md5($user->psw)."')";
	$conn->query($sql);
	echo 1;

} else {

	echo 0;

}

$conn->close();

class User {

	public function __construct($arr) {

		$this->usr = $arr[0];
		$this->fnm = $arr[1];
		$this->lnm = $arr[2];
		$this->eml = $arr[3];
		$this->psw = $arr[4];
		$this->cpw = $arr[5];

	}

	public function isAlphanumeric() {

		return preg_match('/^[a-zA-Z0-9]\w+$/', $this->usr);

	}

	public function isAlphabetical() {

		return preg_match('/^[a-zA-Z]+$/', $this->fnm) && preg_match('/^[a-zA-Z]+$/', $this->lnm);

	}

	public function passwordsMatch() {

		return $this->psw === $this->cpw;

	}

	public function isEmailAddress() {

		return preg_match('/[a-zA-Z0-9_\.]+@[a-zA-Z0-9_\.]+/', $this->eml);

	}

}

?>