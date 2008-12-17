<?php

// database connect script.

require 'db_connect.php';

if($logged_in == 1) {
    die('You are already logged in, '.$_SESSION['username'].'.');

}

?>
<html>
<head>
<title>Login</title>
</head>
<body>
<?php

if (isset($_POST['submit'])) { // if form has been submitted



    /* check they filled in what they were supposed to and authenticate */

    if(!$_POST['uname'] | !$_POST['passwd']) {

        die('You did not fill in a required field.');

    }



    // authenticate.



    if (!get_magic_quotes_gpc()) {

        $_POST['uname'] = addslashes($_POST['uname']);

    }



    $qry = "SELECT login, password FROM accounts WHERE login = '".$_POST['uname']."'";
    $sqlmembers = mysql_query($qry);
$info = mysql_fetch_array ($sqlmembers);

    $check = mysql_num_rows ($sqlmembers);



    if ($check == 0) {

        die('That Account does not exist in our database.');

    }






    // check passwords match



    $_POST['passwd'] = stripslashes($_POST['passwd']);

    $info['password'] = stripslashes($info['password']);

    $_POST['passwd'] = md5($_POST['passwd']);



    if ($_POST['passwd'] != $info['password']) {

        echo "Incorrect password, please try again.";

    }



    // if we get here username and password are correct,

    //register session variables and set last login time.



    $date = date('m d, Y');



    $qry = "UPDATE accounts SET last_login = '$date' WHERE username = '".$_POST['uname']."'";

    $query=mysql_query($qry);



    $_POST['uname'] = stripslashes($_POST['uname']);

    $_SESSION['username'] = $_POST['uname'];

    $_SESSION['password'] = $_POST['passwd'];



?>
<h1>Logged in</h1>
<p>Welcome back <?php echo $_SESSION['username']; ?>, you are logged in.</p>

<?php

} else {    // if form hasn't been submitted

?>
<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table align="center" border="1" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td>
<input type="text" name="uname" maxlength="40">
</td></tr>
<tr><td>Password:</td><td>
<input type="password" name="passwd" maxlength="50">
</td></tr>
<tr><td colspan="2" align="right">
<input type="submit" name="submit" value="Login">
</td></tr>
</table>
</form>
<?php
}
?>
</body>
</html>