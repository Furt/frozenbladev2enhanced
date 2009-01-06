<?php

require 'config.php';		//database info
require 'db_connect.php';    // database connect script.

if ($logged_in == 0) {
    die('You are not logged in so you cannot log out.');
}

unset($_SESSION['username']);
unset($_SESSION['password']);
// kill session variables
$_SESSION = array();
session_destroy();
header('Location:../home.php');
?>