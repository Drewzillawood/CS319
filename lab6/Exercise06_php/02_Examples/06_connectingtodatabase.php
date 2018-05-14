<?php
// THIS IS JUST A SIMPLE EXAMPLE TO SHOW CONNECTION TO A DATABASE
// YOU WILL NEED TO FILL THE PROPER CREDENTIALS FOR THE
// USERNAME, PASSWORD, AND DATABASESERVER names
// TODO: TRY USING THE CREDENTIALS SUPPLIED LATER IN THE EXERCISE

$username = "root";
$password = "";
$dbServer = "127.0.0.1"; 
$dbName   = "drew_database";

// --------------------------------------
// --- PART-1 --- CONNECT TO DATABASE ---
// --------------------------------------
// USE OO MYSQL IMPROVED 

// Create connection
$conn = new mysqli($dbServer, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
  echo "Connected successfully<br>";
}

echo $conn->host_info . "<br>";


// --------------------------------------
// --- PART-2 --- INSERT DATA -----------
// --------------------------------------
$sql =  "INSERT INTO users(UserName, Password, Email, Phone, Librarian, FirstName, Lastname)";
$sql .= "VALUES ('drewu', 'nenj7189', 'drew@uwood.net', '4024526255', 0, 'Drew', 'Underwood')";
$sql .= "ON DUPLICATE KEY UPDATE Librarian = 1";

// Specifically create a book
// $sql =  "INSERT INTO books(BookId, BookTitle, Author, Availability)";
// $sql .= "VALUES (225, 'Unwind', 'Neil Shusterman', 1)";
// $sql .= "ON DUPLICATE KEY UPDATE Availability = 0";

// Specifically create a loanhistory
// $sql =  "INSERT INTO loanhistory(userName, BookId, DueDate, ReturnedDate)";
// $sql .= "VALUES ('drewu', 225, '2018-12-10', '2018-12-09')";



// Delete a particular element
// $sql =  "DELETE FROM users";

/*if (*/$conn->query($sql); /*=== TRUE) {
//     echo "New record created successfully<br>";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }*/

// --------------------------------------
// --- PART-3 --- GET DATA --------------
// --------------------------------------
// $sql = "SELECT * FROM users";

// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "book: " . $row["BookTitle"]. "  Author: " . $row["Author"]. "<br>";
//     }
// } else {
//     echo "<br>0 results";
// }

// --------------------------------------
// --- PART-4 --- CLOSE -----------------
// --------------------------------------
$conn->close();

?>
