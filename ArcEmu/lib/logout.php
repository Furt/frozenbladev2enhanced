<?php 
session_start();
include('common-functions.php');
session_unset();
session_destroy();
	// Change the page where redirect an user
	// after logout.
		redirect('../home.php');
?>