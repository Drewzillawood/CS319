// https://p5js.org/reference/
//this is a good site to reference the p5.js libraries

this.xVelocity = 1;
this.yVelocity = 0;
this.x = 0;
this.y = 0;
var food;
function setup() {
	
	createCanvas(500,500); 
	s = new Snake(); // create a new Snake
	var a = document.getElementById("diff1").getAttribute("target");
	alert(a);
	
	if(document.getElementById("eButton")) {
			
		frameRate(15);
		
	} else if(document.getElementById == "NORM") {
		
		frameRate(30);
		
	} else if(document.getElementById == "HARD") {
		
		frameRate(60);
		
	} else {
		
		alert("GOOD LUCK BRUH!")
		frameRate(20);
		
	}
	onGrid();
}

function draw() {
  background(255, 204, 0);
  s.restart();
  s.update();
  s.show();
  if(s.eatFood(food)){
  	onGrid();
  }
  fill(random(200), 0, 100);
  rect(food.x, food.y, 20, 20);
}

function onGrid(){
	var rows = floor(height/20); //height of the canvas
	var columns = floor(width/20); //width of the canvas
	food = createVector(floor(random(columns)), floor(random(rows)));
	food.mult(20);
}

this.direction = function(x, y){
	this.xVelocity = x;
	this.yVelocity = y;
}

function keyPressed(){ //this is built in to the p5.js function library
	if(keyCode == LEFT_ARROW || keyCode == 65){ //key code 65 corresponds to the key A
		s.direction(-1,0);
	}
	else if(keyCode == RIGHT_ARROW || keyCode == 68){ //key code 68 corresponds to the key D
		s.direction(1,0);
	}
    else if(keyCode == UP_ARROW || keyCode == 87){ //key code 87 corresponds to the key W
		s.direction(0,-1);
	}
	else if(keyCode == DOWN_ARROW || keyCode == 83){ //key code 83 corresponds to the key S
		s.direction(0,1);
	}
}

function Snake(){
	this.xVelocity = 1;
	this.yVelocity = 0;
	this.following = [];
	this.x = 0;
	this.y = 0;
	this.total = 0;
	

	this.update = function(){
		if (this.following.length === this.total) {
          var i = 0; 
          while(i < this.following.length - 1){
              this.following[i] = this.following[i + 1];
              i++;
          }
	    }
        this.following[this.total - 1] = createVector(this.x, this.y);
		this.x += this.xVelocity;
		this.y += this.yVelocity;
		//need to make sure that the "snake" does not leave the canvas
  		this.x = constrain(this.x, 0, width - 20);
		this.y = constrain(this.y, 0, height - 20);
	
	}

	this.show = function() {
		fill(255);
		for (var i = 0; i < this.following.length; i++) {
      		rect(this.following[i].x, this.following[i].y, 20, 20);
    	}
		rect(this.x, this.y, 20,20);

	}

	this.eatFood = function(pos){
		var distance = dist(this.x, this.y, pos.x, pos.y);
		if(distance > 1){
			return false;
		}else{
			this.total += 1;
			return true;
		}
	}
	this.direction = function(x, y){
		this.xVelocity = x * 20;
		this.yVelocity = y * 20;
	}
	this.restart = function() {
	    for (var i = 0; i < this.following.length; i++) {
	      var pos = this.following[i];
	      var d = dist(this.x, this.y, pos.x, pos.y);
	      if (d < 1) {
	        this.total = 0;
	        this.following = [];
	      }
        }
  }
}