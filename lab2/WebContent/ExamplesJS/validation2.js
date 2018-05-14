//We won't do anything until DOM is loaded
document.addEventListener("DOMContentLoaded", main);

function main() {
	
	
	var form = document.getElementById("thisForm2");
	
	// Needed to keep page from refreshing and erasing pictures
	form.addEventListener("submit", function(ev) {
		
		// This line keeps the refreshing from happening
		ev.preventDefault();
		
		var add = addressFunction();
		alert(add);
		
		// Function call
		var valid = emailFunction()
				  & phoneFunction()
				  & (add != "");
				  
		
		
		if(valid) {
			
			localStorage.setItem("theAddress", add);
			
		} else {
			
			window.location.href = "maps.html";
			
		}
		
	});
	
}	


function emailFunction() {
		
	// Simple get elementbyid call
	var email = document.getElementById("email");
	// Check out the querySelector on w3Schools if you have questions
	var input = email.querySelector("input");
	
	// Getting our pictures
	var correct = email.querySelector(".correct");
	var wrong   = email.querySelector(".wrong");
	
	// Finding where the "." and "@" are inside of the email address
	var amp = input.value.indexOf("@");
	var per = input.value.indexOf(".");
	
	// Grabbing the whole string
	var myString = input.value;
	
	// IMPORTANT: THESE CONDITIONALS ARE REGEX STATEMENTS
	// Check out regexpal.com for some ways to see how it works
	// Basically this is what's happening
	// -/ everything inside of these marks is being executed /
	// -^ check everything within the string &    
	// -"+" just means we're still wanting to check if it happens more than once
	// -[everything inside here are our parameters]
	// --i.e. if the string has characters "a-z", AND "A-Z", AND "0-9"
	if(/^[a-zA-Z0-9]+$/.test(myString.substring(0,amp)) 
	   && /^[a-zA-Z0-9]+$/.test(myString.substring(amp+1,per)) 
	   && /^[a-zA-Z0-9]+$/.test(myString.substring(per+1,input.value.length))
	   && myString != "") {
		
		// Brings the display on from being hidden
		correct.style.display = "inline";
		wrong.style.display = "none";
			
	} else {
		
		correct.style.display = "none";
		wrong.style.display = "inline";
		
	}
		
}

function phoneFunction() {
	
	var phone = document.getElementById("pNumber");
	var input = phone.querySelector("input");
	
	var correct = phone.querySelector(".correct");
	var wrong   = phone.querySelector(".wrong");
	
	if(/^[0-9-]+$/.test(input.value) && input.value != "") {
		
		correct.style.display = "inline";
		wrong.style.display = "none";
			
	} else {
		
		correct.style.display = "none";
		wrong.style.display = "inline";
		
	}
	
}

function addressFunction() {
	
	var address = document.getElementById("address");
	var input = address.querySelector("input");
	
	var correct = address.querySelector(".correct");
	var wrong   = address.querySelector(".wrong");
	
	if(input.value.indexOf(",") > -1) {
		
		if(/^[a-zA-Z, ]+$/.test(input.value) && input.value != "") {
			
			correct.style.display = "inline";
			wrong.style.display = "none";
			alert(input.value);
			return input.value;
			
		}
		
	} else {
		
		correct.style.display = "none";
		wrong.style.display = "inline";
		return "";
		
	}
	
}
