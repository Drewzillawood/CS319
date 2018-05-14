

$(document).ready(function() {
	
	// Change the font size of thisP when a p element is hoevered over
	$("p").hover(function(){
	
		$("#thisP").css("font-size", "24px");
	
	});
	
	// Set text of our button to red if we click it
	$("#sillyButton").click(function(){
	
		$("#sillyButton").css("color", "red");
	
	});
	
	// If we click the "thisP" element, color button black
	$("#thisP").click(function() {
	
		$("#sillyButton").css("background-color", "black");
		
	});
	
	// When mousing away from bold text, turn purple
	$("b").mouseout(function(){
	
		$("b").css("color", "purple");
	
	});
	
	// Set whole background to yellow
	$("#uhOh").click(function(){
	
		$("div").css("background-color", "yellow");
		// Hide divs slowly
		$("div").hide("slow");
	
	});
	
	// Double click anywhere
	$("body").dblclick(function(){
		
		// Bring it back quickly
		$("div").show("normal");
		
	});
	
	$("#sillyButton").dblclick(function(){
		
		// Slide the bolded text out of view over .8 seconds
		$("b").slideUp(800);
		
	});
	
	// Move our button
	$("#otherButton").click(function(){
		
		$("#otherButton").animate({left: '250px'});
		
	});
	
	// Manipulate our button further
	$("#otherButton").dblclick(function(){
		
		$("#otherButton").animate({
			left: '100px',
			opacity: '0.5',
			height: '500px',
			width: '500px'
		});
		
	});
	
	
	

});
  
