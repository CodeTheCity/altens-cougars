<?php

mysql_query ("INSERT INTO bookings (`room_id`, `booking_from`, `booking_to`) VALUES ('3', '2014-09-01 00:00:00', '2014-10-30 00:00:00')") or die(mysql_error());

?>