// CALCULATOR.JS
//   Note: Look at 04_SampleProgram first
//
//

// 
var Calc = {

Model : {
	
	oldVal : undefined,
	newVal : undefined,
	operand: undefined
	
},


View : {
  textRow : {id: "textRow", type: "text", value: "", onclick:""},
  button1 : {id: "button1", type: "button", value: 1, onclick:""},
  button2 : {id: "button2", type: "button", value: 2, onclick:""},
  button3 : {id: "button3", type: "button", value: 3, onclick:""},
  button4 : {id: "button4", type: "button", value: 4, onclick:""},
  button5 : {id: "button5", type: "button", value: 5, onclick:""},
  button6 : {id: "button6", type: "button", value: 6, onclick:""},
  button7 : {id: "button7", type: "button", value: 7, onclick:""},
  button8 : {id: "button8", type: "button", value: 8, onclick:""},
  button9 : {id: "button9", type: "button", value: 9, onclick:""},
  button0 : {id: "button0", type: "button", value: 0, onclick:""},
  buttonPlus     : {id: "buttonPlus", type: "button", value: '+', onclick:""},
  buttonMinus    : {id: "buttonMinus", type: "button", value: '-', onclick:""},
  buttonMultiply : {id: "buttonMultiply", type: "button", value: '*', onclick:""},
  buttonPeriod   : {id: "buttonPeriod", type: "button", value: '.', onclick:""},
  buttonEquals   : {id: "buttonEquals", type: "button", value: '=', onclick:""},
  buttonDivide   : {id: "buttonDivide", type: "button", value: '/', onclick:""}
  
},

Controller : {

	

},

run : function() {
  Calc.attachHandlers();
  console.log(Calc.display());
  return Calc.display();
},


displayElement : function (element) {
  var s = "<input ";
  s += " id=\"" + element.id + "\"";
  s += " type=\"" + element.type + "\"";
  s += " value= \"" + element.value + "\"";
  s += " onclick= \"" + element.onclick + "\"";
  s += ">";
  return s;

},

display : function() {
  var s;
  s = "<table id=\"myTable\" border=2>"
  s += "<tr><td>" + Calc.displayElement(Calc.View.textRow) + "</td></tr>";
  s += "<tr><td>";
  s += Calc.displayElement(Calc.View.button1);
  s += Calc.displayElement(Calc.View.button2);
  s += Calc.displayElement(Calc.View.button3);
  s += Calc.displayElement(Calc.View.buttonPlus);
  s += "</tr></td>";
  s += "<tr style = \"width:100%\"><td>";
  s += Calc.displayElement(Calc.View.button4);
  s += Calc.displayElement(Calc.View.button5);
  s += Calc.displayElement(Calc.View.button6);
  s += Calc.displayElement(Calc.View.buttonMinus);
  s += "</tr></td>";
  s += "<tr><td>";
  s += Calc.displayElement(Calc.View.button7);
  s += Calc.displayElement(Calc.View.button8);
  s += Calc.displayElement(Calc.View.button9);
  s += Calc.displayElement(Calc.View.buttonMultiply);
  s += "</tr></td>";
  s += "<tr><td>";
  s += Calc.displayElement(Calc.View.button0);
  s += Calc.displayElement(Calc.View.buttonPeriod);
  s += Calc.displayElement(Calc.View.buttonEquals);
  s += Calc.displayElement(Calc.View.buttonDivide);
  s += "</tr></td></table>";
  return s;
},

attachHandlers : function() {
	
  Calc.View.button9.onclick = "Calc.button9Handler()"; 
  Calc.View.button8.onclick = "Calc.button8Handler()"; 
  Calc.View.button7.onclick = "Calc.button7Handler()"; 
  Calc.View.button6.onclick = "Calc.button6Handler()";
  Calc.View.button5.onclick = "Calc.button5Handler()"; 
  Calc.View.button4.onclick = "Calc.button4Handler()"; 
  Calc.View.button3.onclick = "Calc.button3Handler()"; 
  Calc.View.button2.onclick = "Calc.button2Handler()"; 
  Calc.View.button1.onclick = "Calc.button1Handler()"; 
  Calc.View.button0.onclick = "Calc.button0Handler()"; 
  Calc.View.buttonPlus.onclick = "Calc.buttonAddHandler()";
  Calc.View.buttonEquals.onclick = "Calc.buttonEqualHandler()";
 
},

button9Handler : function() {
	
  document.getElementById("textRow").value += "9";
	
},

button8Handler : function() {
	
  document.getElementById("textRow").value += "8";
	
},

button7Handler : function() {
  
  document.getElementById("textRow").value += "7";
  
},

button6Handler : function() {
	
  document.getElementById("textRow").value += "6";
	
},

button5Handler : function() {
	
  document.getElementById("textRow").value += "5";
	
},

button4Handler : function() {
	
  document.getElementById("textRow").value += "4";
	
},

button3Handler : function() {
	
  document.getElementById("textRow").value += "3";
	
},

button2Handler : function() {
	
  document.getElementById("textRow").value += "2";
	
},

button1Handler : function() {
	
  document.getElementById("textRow").value += "1";
	
},

button0Handler : function() {
	
  document.getElementById("textRow").value += "0";
	
},

buttonAddHandler : function() {
	
  Calc.Model.oldVal = document.getElementById("textRow").value;
  Calc.Model.operand= "+";
  document.getElementById("textRow").value = "";
	
},

buttonEqualHandler: function() {

  if(Calc.Model.operand == "+") {
	  
	 document.getElementById("textRow").value = Calc.model.oldVal + document.getElementById("textRow").value;
		
  }
}

} // end of Calc;
