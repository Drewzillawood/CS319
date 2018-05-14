$(document).ready(function() {

	$("#button").click(function() {

		if(($("#u").val() === "admin" &&
		    $("#p").val() === "admin") ||
		    $("#u").val().charAt(0) === "u" ||
		    $("#U").val().charAt(0) === "U") {

			$("#thisForm").attr("action", "booksLibrary.php");
		} else {

			alert("Not a correct username and password");
			$("#thisForm").attr("action", "login.php");

		}
	});	

});