var buildingFloors;

var interval = 60 * 1000;	//1 Minute

function init()
{
	showFloors();
	setInterval(function(){showFloors();},interval); //Wrap in anon func to bind state
}

function showFloors()
{
	console.log('Updating booking information');
	var url = '/api/floors/?building=1';
	buildingFloors = {};	

	var request = new XMLHttpRequest();
	request.open("GET", url, true);

	request.onload = function() {
		var floors = JSON.parse(request.response);
		loadRooms(floors);
	};

	request.onerror = function() {
		console.log('Error loading floors');
	};

	request.send();	
}

function loadRooms(floors)
{
	for(var i = 0; i < floors.length; i++) {
		var floor = floors[i];
		floor.rooms = [];
		buildingFloors[floor.floor_id] = floor;
	}

	var url = "/api/rooms/?building=1";
	
	var request = new XMLHttpRequest();
	request.open("GET", url, true);

	request.onload = function() {
		var rooms = JSON.parse(request.response);
		setupFloors(rooms);
	};

	request.onerror = function() {
		console.log('Error loading floors');
	};

	request.send();	
}

function setupFloors(rooms)
{
	for(var i = 0;i < rooms.length; i++) {
		var room = rooms[i];

		var id = room.floor.id;	
		buildingFloors[id].rooms.push(room);
	}

	for(var i in buildingFloors) {
		if(!buildingFloors.hasOwnProperty(i))
			continue;

		var floor = buildingFloors[i];

		//Load image
		floor.img = new Image();
		floor.img.src = floor.floor_plan;

		var canvas = document.getElementById('floor' + i);
		floor.ctx = canvas.getContext('2d');

		floor.width = canvas.width
		floor.height = canvas.height;

		//draw shit
		drawFloor(floor);
	}
}

function drawFloor(floor)
{
	floor.ctx.clearRect(0,0,floor.width,floor.height);

	floor.ctx.save()

	var scale = calculateScale(floor);

	floor.ctx.scale(scale,scale);
	floor.ctx.drawImage(floor.img,0,0);

	for(var i = 0; i < floor.rooms.length;i++) {
		var room = floor.rooms[i];

		if(!room.coords)
			continue;

		drawRoom(floor.ctx,room);
	}

	floor.ctx.restore()
}

/* Scale the ctx to fit within our canvas, if we need to*/
function calculateScale(floor)
{
	var fw = floor.width;
	var fh = floor.height;

	var iw = floor.img.width;
	var ih = floor.img.height;

	var wscale = 1;
	var hscale = 1;

	if(iw > fw) 
		wscale = fw/iw;

	if(ih > fw)
		hscale = fh/ih;

	//Find the largest reduction factor	 (smallest values)
	return (wscale < hscale) ? wscale : hscale;
}

function drawRoom(ctx,room)
{
	if(!room || !room.coords || room.coords.length == 0)
		return;
	
	var red =  "rgba(255,0,0,0.5)";
	var green =  "rgba(0,255,0,0.5)";

	if(room.available)
		ctx.fillStyle = green;
	else 
		ctx.fillStyle = red;

    ctx.beginPath();
    ctx.moveTo(room.coords[0].x,room.coords[0].y);

	//Draw the coords for this room
	for(var i = 0; i < room.coords.length; i++) {
		var p = room.coords[i]
		ctx.lineTo(p.x,p.y);
	}
    ctx.fill();	
}
