//We won't do anything until DOM is loaded
document.addEventListener("DOMContentLoaded", main);

function main() {
	
	var form = document.getElementById("thisForm");
	
	form.addEventListener("submit", function(ev) {
		
		ev.preventDefault();
		var sub = usrName();
		
		if(sub == "undergrad") {
			
			localStorage.setItem("userName", sub);
			window.location.href = "./bookslibrary.html"
			
		} else if(sub == "admin") {
			
			window.location.href = "./bookslibrary.html"
			
		}
		
	});
	
}

function usrName() {
	
	var usr = document.getElementById("username");
	var psw = document.getElementById("password");
	if((usr.value.charAt(0) == 'u' || usr.value.charAt(0) == 'U') && psw.value != "") {
		
		//alert("UNDERGRAD");
		return "undergrad";
		
	} else if(usr.value == "admin" && psw.value == "admin") {
		
		//alert("admin");
		return "admin";
		
	} else {
		
		alert("Not a correct username/password.");
		
	}
	
}