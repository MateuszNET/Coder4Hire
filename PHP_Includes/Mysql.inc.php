<?php
	require_once('Config.php');

	$dbc = @mysql_connect($MySQL_Host, $MySQL_User, $MySQL_Password);

	if (!$dbc) {
		trigger_error('Could not connect to MySQL: ' . mysql_connect_error());
	}
	
	mysql_select_db($MySQL_Name,$dbc);
?>