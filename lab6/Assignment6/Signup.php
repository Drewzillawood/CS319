<?php

$user = new User($_POST['usr']);
$conn = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt our message if we couldn't connect to the server
if($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error . "<br>");

} 

// Check to see if the username has already been taken
$sql = "SELECT * FROM users WHERE UserName='".$user->usr."'";
$sql = $conn->query($sql);

// Run all validation checks on our new user
if($user->isAlphaNumeric() && $user->isAlphabetical() && $user->passwordsMatch() && null !== $user->isAPhoneNumber() && $user->isEmailAddress() && $sql->num_rows === 0) {

	// Inserting our data into the database
	$sql =  "INSERT INTO users(UserName, Password, Email, Phone, Librarian, FirstName, Lastname)";
	$sql .= "VALUES ('".$user->usr."','".md5($user->psw)."','".$user->eml."','".$user->num."','".$user->lib."','".$user->fnm."','".$user->lnm."')";
	$conn->query($sql);
	echo 1;

} else {

	// If the new user information is not valid, or is already taken, return false
	echo 0;

}

$conn->close();

// Class to designate and validate all user attributes
class User {

	// Assign all proper attributes to a single user object
	public function __construct($arr) {

		$this->usr = $arr[0];
		$this->psw = $arr[1];
		$this->cpw = $arr[2];
		$this->eml = $arr[3];
		$this->num = $arr[4];
		$this->lib = $arr[5];
		$this->fnm = $arr[6];
		$this->lnm = $arr[7];

	}

	// Verify if username is alphanumeric
	public function isAlphaNumeric() {

		return preg_match('/^[a-zA-Z0-9]\w+$/', $this->usr);

	}

	// Verify first and last name are alphabetical
	public function isAlphabetical() {

		return (preg_match('/^[a-zA-Z]+$/', $this->fnm) && preg_match('/^[a-zA-Z]+$/', $this->lnm));

	}

	// Verify the passwords match
	public function passwordsMatch() {

		return $this->psw === $this->cpw;

	}

	// Verify valid phonenumber
	public function isAPhoneNumber() {

		$num = str_replace('/\D/', '', $this->num);
		if(strlen($num) != 10) {

			return null;

		} else {

			return $num;

		}

	}

	// Verify valid email address
	public function isEmailAddress() {

		return preg_match('/^(([a-zA-Z0-9_]+\.)*[a-zA-Z0-9_]+)@(([a-zA-Z0-9_]+\.)+([a-zA-Z0-9_]*))$/', $this->eml);

	}

}

?>