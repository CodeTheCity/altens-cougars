var ctx;

var points = [];
var capture = [];

var red =  "rgba(255,0,0,1)";
var green =  "rgba(0,255,0,0.5)";

var width = 0;
var height = 0;

var image;
function init()
{
	console.log('Init');

	var canvas = document.getElementById('floor');
	ctx = canvas.getContext('2d');
	console.log("Contex is " + ctx);

	width = canvas.width;
	height = canvas.height;

	var img = document.getElementById('floorplan');
	console.log(img);

	image = new Image();
	image.src = img.src;

	draw();

	document.getElementById('floor').onmousedown = mouse;	
	document.onkeydown = keyboard;	
}

function keyboard(e)
{
	points.push(capture);
	capture = [];

	console.log('------------------------------------------------------');

	if (e.key == "p") {
		var string = JSON.stringify(points,undefined,"  ");
		console.log(string);
	} else if (e.key == "r") {
		console.log('r pressed');
		draw();
	} else {
		console.log(points)
	}
}

function mouse(e)
{
	var canvasElement = e.target;
	var x;
	var y;

	if (e.pageX || e.pageY) {
		x = e.pageX;
		y = e.pageY;
	} else {
		x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}

	x -= canvasElement.offsetLeft;
	y -= canvasElement.offsetTop;

	console.log('x: ' + x + ', y: ' + y);

	capture.push({x:x-3,y:y-5});
	draw();
}


function draw()
{
	ctx.clearRect(0,0,width,height);

	ctx.drawImage(image,0,0);
	drawPoints();
	drawRooms();
}

function drawPoints()
{
	if(capture.length < 2)
		return;

	ctx.strokeStyle = red;

    ctx.beginPath();
    ctx.moveTo(capture[0].x,capture[0].y);

	for(var i = 0;i < capture.length;i++) {
		var p = capture[i]
		ctx.lineTo(p.x,p.y);
	}
	ctx.stroke();
}

function drawRooms()
{
	if(points.length == 0) {
		console.log('no points');
		//return;
	}
	for(var i = 0; i < points.length;i++) 
		drawRoom(points[i]);
}

function drawRoom(room)
{
	if(room.length < 1)
		return;
	console.log(room);

	ctx.fillStyle = green;

    ctx.beginPath();
    ctx.moveTo(room[0].x,room[0].y);

	//Draw the coords for this room
	for(var i = 0; i < room.length; i++) {
		var p = room[i]
		ctx.lineTo(p.x,p.y);
	}
    ctx.fill();	
}
