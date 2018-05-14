<?php 

// Establish connection to Database
$Library = new mysqli("127.0.0.1", "root", "", "drew_database");

// Halt all efforts if connection is not made
if($Library->connect_error) {

	die("Connection failed: ".$Library->connect_error."<br>");

}

if($_POST['display']) { 

	session_start();
	echo $_SESSION['usr'];

} else if($_POST['table']) {

	$Lib = new Library($Library);

} else if(isset($_POST['info'])) {

	$info = $_POST['info'];
	$sql = "SELECT * FROM books WHERE BookTitle = '$info'";
	$book = json_encode(mysqli_fetch_row($Library->query($sql)));
	echo $book;

} 

$Library->close();

class Library {

	public function __construct($Library) {

		$this->shelves = Array();
		array_push($this->shelves, new Shelf(0, "Arts", $Library));
		array_push($this->shelves, new Shelf(1, "Science", $Library));
		array_push($this->shelves, new Shelf(2, "Sports", $Library));
		array_push($this->shelves, new Shelf(3, "Literature", $Library));

		$this->displayLibrary($Library);

	}

	private function displayLibrary($Library) {

		$sql = "SELECT * FROM books INNER JOIN shelves ON (books.BookId%4)=(shelves.shelfId)";
		$rows = mysqli_fetch_all($Library->query($sql),MYSQLI_ASSOC);

		$table =  "<table border='2'>";
		$table .= "<tr class='header'>
					<th></th>
					<th>Arts</th>
					<th>Science</th>
					<th>Sports</th>
					<th>Literature</th>
				   </tr>";

		$rowConstructor = Array(Array(),Array(),Array(),Array());
		for($i = 0; $i < sizeof($rows); $i++) {

			$tempRow = $rows[$i];
			$aBook = new Book($tempRow['BookId'], $tempRow['BookTitle'], $tempRow['Author'], $tempRow['Availability'], $Library);
			switch ($tempRow['BookId']%4) {

				case 0:
					array_push($rowConstructor[0], $tempRow);
					break;
				case 1:
					array_push($rowConstructor[1], $tempRow);
					break;
				case 2:
					array_push($rowConstructor[2], $tempRow);
					break;
				case 3:
					array_push($rowConstructor[3], $tempRow);
					break;

			}

		}

		$size = 0;
		for($i = 0; $i < sizeof($rowConstructor); $i++) {

			if($size < sizeof($rowConstructor[$i])) {

				$size = sizeof($rowConstructor[$i]);

			}

		}

		for($i = 0; $i < $size; $i++) {

			$table.= "<tr><td>".($i+1)."</td>";
			for($j = 0; $j < 4; $j++) {

				if(sizeof($rowConstructor[$j]) > $i) {

					$temp = $rowConstructor[$j][$i];
					$table.= "<td class='cell".$temp['Availability']."'>".$temp['BookTitle']."</td>";

				} else {

					$table.= "<td></td>";

				}

			}
			$table.= "</tr>";

		}

		echo $table;

	}

}

class Book {

	public function __construct($BookId, $BookTitle, $Author, $Availability, $Library) {

		$sql = "INSERT INTO books(BookId, BookTitle, Author, Availability) VALUES ($BookId, '$BookTitle', '$Author', $Availability)";
		$Library->query($sql);
		$sql = "INSERT INTO booklocation(BookId, ShelfId) VALUES ($BookId, ($BookId%4))";
		$Library->query($sql);
		$this->BookId = $BookId;
		$this->BookTitle = $BookTitle;
		$this->Author = $Author;
		$this->Availability = $Availability;

	}

}

class Shelf {

	public function __construct($ShelfId, $ShelfName, $Library) {

		$sql = "INSERT INTO shelves(shelfId, ShelfName) VALUES ($ShelfId, '$ShelfName')";
		$Library->query($sql);
		$this->ID = $ShelfId;
		$this->Name = $ShelfName;
		$this->Books = Array();

	}

	public function addBook($BookId, $BookTitle, $Author, $Availability, $Library) {

		array_push($this->Books, new Book($BookId, $BookTitle, $Author, $Availability, $Library));

	}

}

?>