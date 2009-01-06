<?php

require 'config.php';		//database info
require 'db_connect.php';    // database connect script.

if($logged_in == 1) {
    echo('You are logged in, <b>'.$_SESSION['username'].'</b>.<br /><br /><center><span class="button"><a href="./lib/logout.php">Logout</a></span></center><br />');


} else {


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
<center><p>Please wait, <?php echo $_SESSION['username']; ?>, <br /> while we log you in.<br /></center></center>
<META HTTP-EQUIV="refresh" CONTENT="3"><br /><br /></p>

<?php

} else {    // if form hasn't been submitted

?>
<br />
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td>Username:</td></tr>
<tr><td>
<input type="text" name="uname" maxlength="40">
</td></tr>
<tr><td>Password:</td></tr>
<tr><td>
<input type="password" name="passwd" maxlength="50">
</td></tr>
<tr><td colspan="2" align="right">
<a href="fps.php">Forgot Pass?</a><input type="submit" name="submit" value="Login">
</td></tr>
</table>
</form>
<br /><br />
<?php
}
}
?>