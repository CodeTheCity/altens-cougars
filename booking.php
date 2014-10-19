<?php

define ('API_BASE_URL', 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/api/');

?><html>
<head>

<style>

body {
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
	font-weight: 300;
}

h1, h2, h3, h4, h5, h6 {
	font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
	font-weight: 500;
}

input[type="radio"] {
	margin-top: 4px;
	margin-right: 10px;
	margin-bottom: 4px;
}

label {
	display: inline-block;
	padding-top: 4px;
	margin-right: 10px;
	padding-bottom: 4px;
	
	font-size: 0.9em;
}

table tr th, table tr td {
	padding: 10px;
}

table tr td:first-child {
	font-weight: 600;
}

p.lead {
	font-size: 1.2em;
}

.cursor {
	cursor: pointer;
}

.btn-small {
	margin-top: 20px;
	margin-bottom: 20px;
	padding: 10px 10px;
	
	font-size: 0.8em;
}

.small {
	font-size: 0.8em;
}

.ml-20 {
	margin-left: 20px;
}

.hidden {
	display: none;
}


.evenRow{
            background-color: Red;
        }



</style>

</head>
<body>

<h1>Availability<small>able</small> - Community Centre</h1>

<p class="lead">Room to book: <span data-id="room"></span> <a class="cursor small hidden" data-id="changeRoom" href="#">Change</a></p>
<div class="container-rooms">
<?php

$ch = curl_init( API_BASE_URL . 'rooms?building=1' );

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$rooms = json_decode ( curl_exec($ch), true );

curl_close($ch);

foreach ( $rooms as $room ) {

	echo '<div class="ml-20"><input name="room" id="room-' . $room['id'] . '" value="' . $room['id'] . '" type="radio"><label for="room-' . $room['id'] . '">' . $room['name'] . '</label></div>' . PHP_EOL;

}

?>
<button class="btn btn-small hidden" id="btnRoom">I want to book <span data-id="room"></span></button>
</div>


<? print("Todays date is: ".Date("l F d, Y")."</br></br>");
 ?>


<div class="container-booked hidden">

	<p class="lead">When do you want to book it for? <span data-id="booked">

<?php
print "<select id=\"available_dates\" name=\"selected_day\">";



for ($daynum=0; $daynum<=7; $daynum++){
   $datetime = new DateTime(Date());
   $datetime->modify('+'.$daynum.' day');


print "<option id=$daynum >".$datetime->format('l F d, Y')."</option>";

}
 
print "</select>";
 
 
 ?>


</span> <a class="cursor small hidden" data-id="changeBooked" href="#">Change</a></p>
	<div class="container-booked">
	
		<table>

<?php
print "<thread><th></th>"; 
$times = array("8am","9am","10am","11am","12pm","1pm","2pm","3pm","4pm","5pm","6pm","7pm","8pm","9pm","10pm"); 

foreach ($times as $time) {
  print "<th>$time</th>";
}
print "</thread>";
?>

			<tr>

<?php
$daysofweek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
$times1 = array("8am","9am","10am","11am","12pm","1pm","2pm","3pm","4pm","5pm","6pm","7pm","8pm","9pm","10pm");


foreach ($daysofweek as $day1) {
  print "<td>$day1</td>";
	foreach ($times1 as $time1) {
  		print "<td><input class=\"evenRow\" type=\"checkbox\" id=$day1 /></td>";
	}
  print "</tr><tr>";
}

print "</tr>";
?>

		</table>
		
		<?php
		
		/*$ch = curl_init( API_BASE_URL . 'schedule?room=1' );
		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$rooms = json_decode ( curl_exec($ch), true );
		
		curl_close($ch);
		
		foreach ( $rooms as $room ) {
		
			echo '<div class="ml-20"><input name="room" id="room-' . $room['id'] . '" value="' . $room['id'] . '" type="radio"><label for="room-' . $room['id'] . '">' . $room['name'] . '</label></div>' . PHP_EOL;
		
		}*/
		
		?>
		
		<button class="btn btn-small hidden" id="btnBooked">Book this room for <span data-id="booked"></span></button>
	</div>

</div>



<!--[if !IE]><!--><script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><script>window.jQuery || document.write('<script src="js/jquery-2.0.2.min.js"><\/script>')</script><!--<![endif]-->
<!--[if IE]><script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script><![endif]-->




























<script>

var room;
var btnRoom = false;
var changeRoom = false;

$(function() {

	$('input[name="room"]').on('change', function() {
	
		room = $(this).attr('value');
		$('*[data-id="room"]').html( $( 'label[for="room-' + $(this).attr('value') + '"]' ).text() );
		
		if ( !btnRoom ) {
			btnRoom = true;
			$('#btnRoom').fadeIn();
		}
	
	});
	
	$('#btnRoom').on('click', function() {
	
		if ( !changeRoom ) {
			changeRoom = true;
			$('[data-id="changeRoom"]').fadeIn();
		}
		
		$.when( $('.container-rooms').fadeOut() ).done(function() {
		
			$('.container-booked').fadeIn();
		
		});
	
	});

});

</script>

</body>
</html>
