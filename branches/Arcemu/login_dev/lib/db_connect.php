<?php



$dbhost = 'localhost';


// your database username.
    $dbusername = 'root';

// the password that corresponds to the above username.
    $dbpasswd = 'password';

// the database name that your username is associated with.
    $database_name = 'logon';

    
    $connection = mysql_connect("$dbhost","$dbusername","$dbpasswd")

    or die ("Couldn't connect to server.");


$db = mysql_select_db("$database_name", $connection)

    or die("Couldn't select database.");


// we write this later on, ignore for now.


include('check_login.php');


?>