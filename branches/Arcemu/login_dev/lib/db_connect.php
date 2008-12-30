<?php

	// database connect script.
	$connection = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_account']) or die(mysql_error());
	
include('check_login.php');


?>