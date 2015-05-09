<?php

function connect() {
	$databasehost = "localhost";
	$databasename = "travelrdb";
	$databaseuser = "root";
	$databasepass = null;

	$con = mysql_connect($databasehost, $databaseuser, $databasepass) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
}

function disconnect() {
	mysql_close();
}

?>