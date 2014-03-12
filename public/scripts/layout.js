// JavaScript Document
var fontsize = 18,
canvas = document.getElementById('logo'),
context = canvas.getContext('2d');
context.font = fontsize + 'pt Arial';
context.fillStyle = 'white';
context.strokeStyle = 'white';
context.fillText("My", 10, fontsize+10);
context.strokeText("My", 10, fontsize+10 );
context.fillText("SocialArea", 10, 2*(fontsize+10));
context.strokeText("SocialArea", 10, 2*(fontsize+10));
context.fillText(".com", 75, 3*(fontsize+10));
context.strokeText(".com", 75, 3*(fontsize+10));

canvas1 = document.getElementById('canvas-title'),
context1 = canvas1.getContext('2d');
context1.font = fontsize + 'pt Arial';
//context.strokeStyle = 'white';
var x = canvas1.width/2;
var y = (canvas1.height + fontsize)/2;

var X_MID = canvas1.width/2;
var Y_MID = canvas1.height/2;
// Create gradient
var grd=context1.createRadialGradient(canvas1.width, Y_MID, canvas1.width/4, canvas1.width, Y_MID, canvas1.width/2);
grd.addColorStop(0,"lightgrey");
grd.addColorStop(1,"white");

// Fill with gradient
context1.fillStyle=grd;
context1.fillRect(0,0,canvas1.width,canvas1.height);

gradient = context1.createLinearGradient(0,0,canvas1.width,canvas.height);
gradient.addColorStop(0, 'blue');
gradient.addColorStop('0.25', 'green');
gradient.addColorStop('0.95', 'red');
gradient.addColorStop(1, 'black');
context1.fillStyle = gradient;
context1.fillText("<?php echo $this->layout()->title; ?>", 10, y);
//context1.strokeText("<?php echo $this->layout()->title; ?>", 10, y);
context1.textAlign('center');
$(document).ready(function(){
	  $("button").click(function(){
		  $("#pt").text("Hello world!");
		  $("#demo").text(Date());
	  });
	});
