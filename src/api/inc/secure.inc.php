<?php

/* * * * * * * * * * * * * * * * * * * * * * */
/*                                           */
/*  NOTE: Database connection should be PDO  */
/*        before being used in a production  */
/*        environment. MySQL extension is    */
/*        deprecated as of PHP 5.5.0         */
/*                                           */
/* * * * * * * * * * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * * * * * * */
/*                                               */
/*  WISHLIST: It would be nice to have a         */
/*            database abstraction layer for     */
/*            PDO so we can use either MySQL     */
/*            or MSSQL etc...                    */
/*                                               */
/* * * * * * * * * * * * * * * * * * * * * * * * */

mysql_connect('hostname', 'username', 'password') or die(mysql_error());
mysql_select_db('database') or die(mysql_error());

?>