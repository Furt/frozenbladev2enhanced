<?php

require 'db_connect.php';

// require our database connection
// which also contains the check_login.php
// script. We have $logged_in for use.

if ($logged_in == 0) {
    ?>
<html>
<head>
<title>Member Profile</title>
</head>
<body>
Im sorry, but you must be logged in to view this page!
</body>
</html>
<?php
}
else {  ?>
<html>
<head>
<title>Member Profile</title>
</head>
<body>
Welcome to the members only section!!!</body>
</html>
<?php
}
?>