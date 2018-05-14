//We won't do anything until DOM is loaded
document.addEventListener("DOMContentLoaded", main);

function main() {
	
	var form = document.getElementById("thisForm");
	
	form.addEventListener("submit", function(ev){
		
		ev.preventDefault();
		var valid = fNameFunction()
				  & lNameFunction()
				  & genderFunction()
				  & stateFunction();

		
		if(valid) {
			
			window.location.href = "./validation2.html";
			
		}
		
	});
	
}

function fNameFunction() {
	
		var fName = document.getElementById("fName");
		var input = fName.querySelector("input");
		
		var correct = fName.querySelector(".correct");
		var wrong = fName.querySelector(".wrong");
	
		if (/^[a-zA-Z0-9]+$/.test(input.value)) {
			
			correct.style.display = "inline";
			wrong.style.display = "none";
			return true;
			
		} else {
			correct.style.display = "none";
			wrong.style.display = "inline";
			return false;
		}
	
}

function lNameFunction() {
	
		var lName = document.getElementById("lName");
		var input = lName.querySelector("input");
		
		var correct = lName.querySelector(".correct");
		var wrong = lName.querySelector(".wrong");
	
		if (/^[a-zA-Z0-9]+$/.test(input.value)) {
			
			correct.style.display = "inline";
			wrong.style.display = "none";
			return true;
			
		} else {
			
			correct.style.display = "none";
			wrong.style.display = "inline";
			return false;
		}
	
}

function genderFunction() {
	
		var gen = document.getElementById("genders");
		var input = gen.querySelector("select");
		
		var correct = gen.querySelector(".correct");
		var wrong = gen.querySelector(".wrong");
	
		if (input.value != "none") {
			
			correct.style.display = "inline";
			wrong.style.display = "none";
			return true;
			
		} else {
			
			correct.style.display = "none";
			wrong.style.display = "inline";
			return false;
		}
	
}

function stateFunction() {
	
		var st = document.getElementById("states");
		var input = st.querySelector("select");
		
		var correct = st.querySelector(".correct");
		var wrong = st.querySelector(".wrong");
		
	
		if (input.value != "none") {
			
			localStorage.setItem("theState", input.value);
			correct.style.display = "inline";
			wrong.style.display = "none";
			return true;
			
		} else {
			
			correct.style.display = "none";
			wrong.style.display = "inline";
			return false;
			
		}
	
}



