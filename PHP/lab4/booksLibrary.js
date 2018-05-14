class Library {

	constructor(s) {

		this._name = s;
		this._struct = "<table id = 'myLib' border = '2'></table>";
		this._shelves = [];

	}

	addShelf(category) {

		this._shelves.push(new Shelf(category));

	}

}

class Shelf {

	constructor(s) {

		this._name = s;
		this._struct = "<th>" + s + "</th>";
		this._books = [];

	}

	addBook(name) {

		this._books.push(name);

	}

}

// Var to keep track of unique ID's
var available = 0;
var idAvailable = [];
for(var i = 0; i < 1000; i++) {

	idAvailable.push(i);

}
class Book {

	constructor(s, c) {

		this._name = s;
		this._borrowedBy = "";
		this._availability = 1;
		this._struct = "<td class = 'aBook'>" + s + "</td>";

		if (c===undefined) {
	
			assignId(this);
			assignCategory(this);
			
		} else {

			this._cat = c;
			assignId(this);

		}

	}

}

$(document).ready(function() {

	var tU = $("#tU").val();
	var pW = $("#pW").val();

	var books = [];

	for(var ch = 'A'.charCodeAt(0); ch <= 'Y'.charCodeAt(0); ch++) {

		books.push(new Book(String.fromCharCode(ch)));

	}

	var lib = new Library("myLib", books);
	displayLibrary(lib, books);
	dictateUI(lib, tU, pW);

});

function displayLibrary(library, books) {

	var row = $("<tr></tr>");
	var lib = $(library._struct);

	library.addShelf("Arts");
	library.addShelf("Science");
	library.addShelf("Sports");
	library.addShelf("Literature");

	while(library._shelves.length > 4) {

		library._shelves.pop();

	}

	for(var i = 0; i < library._shelves.length; i++) {

		row.append($(library._shelves[i]._struct));

	}

	lib.append($(row));

	if(books !== undefined) {

		for(var i = 0; i < books.length; i++) {

			books[i]._struct = books[i]._struct.substring(0, 19);
			books[i]._struct += (" value = " + books[i]._ID);
			books[i]._struct += (">" + books[i]._name + "</td>");
			switch(books[i]._cat) {

				case "Arts" :
					library._shelves[0].addBook(books[i]);
					break;
				case "Science" : 
					library._shelves[1].addBook(books[i]);
					break;
				case "Sports" :
					library._shelves[2].addBook(books[i]);
					break;
				case "Literature" :
					library._shelves[3].addBook(books[i]);
					break;

			}	

		}

	}

	row = $("<tr></tr>");
	var end = findMaxLength(library._shelves);
	for(var i = 0; i < end; i++) {

		try{
			row.append($(library._shelves[0]._books[i]._struct));
		} catch(err) {
			row.append($("<td></td>"));
		}
		try{
			row.append($(library._shelves[1]._books[i]._struct));
		} catch(err) {
			row.append($("<td></td>"))
		}	
		try {
			row.append($(library._shelves[2]._books[i]._struct));
		} catch(err) {
			row.append($("<td></td>"))
		}
		try {
			row.append($(library._shelves[3]._books[i]._struct));
		} catch(err) {
			row.append($("<td></td>"))
		}
		lib.append($(row));
		row = $("<tr></tr>");

	}

	lib.insertAfter($('#tableSelector'));

}

function dictateUI(lib, vip, vipPass) {

	if(vip === "admin" && vipPass === "admin") {

		var tBoxes = $("<div></div>")
		tBoxes.append($("<input id = 'n' type = 'text' placeholder = 'Book Name'>"));
		tBoxes.append($("<input id = 's' type = 'text' placeholder = 'Shelf (literature, science, sports, arts)'>"));
		var Button = $('<button id = "myButton" value = "Add Book">Add Book</button>');
		tBoxes.append(Button);
		tBoxes.insertAfter($("#myLib"));

		Button.click(function() {

			var nBook = new Book($("#n").val(), $("#s").val());
			nBook._struct =  nBook._struct.substring(0, 19);
			nBook._struct += (" value = " + nBook._ID);
			nBook._struct += (">" + nBook._name + "</td>");
			addBook(nBook, lib);
			console.log(lib);
			$("#myLib").remove();
			displayLibrary(lib);

			$(".aBook").click(function(){

				console.log("HERE!");
				var displayTab = $("<div id = 'display'></div>");
				displayTab.append($(this).text());
				displayTab.append(" ID: " + $(this).attr("value"));
				displayTab.append(" This book is of category: ");
				switch(($(this).attr("value") % 4)) {

					case 0 :
						displayTab.append("Art");
						break;
					case 1 :
						displayTab.append("Science");
						break;
					case 2 :
						displayTab.append("Sports");
						break;
					case 3 :
						displayTab.append("Literature");
						break;

				}	

				if($("#myLib").next().attr("id") === "display")  {

					$("#myLib").next().replaceWith(displayTab);

				} else {

					displayTab.insertAfter($("#myLib"));

				}

			});
			
		});

		$(".aBook").click(function(){

			console.log("HERE!");
			var displayTab = $("<div id = 'display'></div>");
			displayTab.append($(this).text());
			displayTab.append(" ID: " + $(this).attr("value"));
			displayTab.append(" This book is of category: ");
			switch(($(this).attr("value") % 4)) {

				case 0 :
					displayTab.append("Art");
					break;
				case 1 :
					displayTab.append("Science");
					break;
				case 2 :
					displayTab.append("Sports");
					break;
				case 3 :
					displayTab.append("Literature");
					break;

			}

			if($("#myLib").next().attr("id") === "display")  {

				$("#myLib").next().replaceWith(displayTab);

			} else {

				displayTab.insertAfter($("#myLib"));

			}

		});

	} else {

		var tick = 0;
		$(".aBook").click(function() {

			if(tick < 2){

				for(var i = 0; i < lib._shelves.length; i++) {

					for(var j = 0; j < lib._shelves[i]._books.length; j++) {

						try {

							if(($(this).attr("value") == lib._shelves[i]._books[j]._ID) && lib._shelves[i]._books[j]._availability == 1) {

								lib._shelves[i]._books[j]._availability = 0;
								lib._shelves[i]._books[j]._borrowedBy = vip;
								$(this).css("background-color", "red");
								tick++;

							} else if(lib._shelves[i]._books[j]._availability == 0 && lib._shelves[i]._books[j]._borrowedBy == vip) {

								lib._shelves[i]._books[j]._availability = 1;
								lib._shelves[i]._books[j]._borrowedBy = "";
								$(this).css("background-color", "white");
								tick--;

							}

						} catch (err) {


						}

					}

				}

			}

		});



	}

}

function addBook(book, lib) {

	switch(book._cat) {

		case "Arts" :
			lib._shelves[0].addBook(book);
			break;
		case "Science" :
			lib._shelves[1].addBook(book);
			break;
		case "Sports" :
			lib._shelves[2].addBook(book);
			break;
		case "Literature" :
			lib._shelves[3].addBook(book);
			break;

	}

}

function findMaxLength(array) {

	var max = 0;
	for(var i = 0; i < array.length; i++) {

		if(array[i]._books.length > max) {

			max = array[i]._books.length;

		}

	}
	return max;

}

// Assign a unique ID to our new book
function assignId(book) {

	var select = Math.floor(Math.random() * (1000 - available));

	if(book._cat !== undefined) {

		switch(book._cat) {

			case "Arts" :		
				while((select % 4) !== 0) {
					select = Math.floor(Math.random() * (1000 - available));
				}
				break;
			case "Science" :
				while((select % 4) !== 1) {
					select = Math.floor(Math.random() * (1000 - available));	
				}
				break;
			case "Sports" :
				while((select % 4) !== 2) {
					select = Math.floor(Math.random() * (1000 - available));
				}
				break;
			case "Literature" :
				while((select % 4) !== 3) {
					select = Math.floor(Math.random() * (1000 - available));
				}
				break;

		}

	}

	book._ID = idAvailable[select];
	swap(select, 999 - available)
	available++;

}

// Will determine a category for our book based off of ID
function assignCategory(book) {

	var assignment = book._ID % 4;
	switch(assignment) {

		case 0 :
			book._cat = "Arts";
			break;
		case 1 : 
			book._cat = "Science";
			break;
		case 2 : 
			book._cat = "Sports";
			break;
		case 3 :
			book._cat = "Literature";
			break;

	}

}

// Helper method to swap two array indices
function swap(i, j) {

	var temp = idAvailable[i];
	idAvailable[i] = idAvailable[j];
	idAvailable[j] = temp;

}