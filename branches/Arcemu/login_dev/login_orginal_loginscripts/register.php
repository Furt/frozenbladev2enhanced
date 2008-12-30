<?php
require('db_connect.php');    // database connect script.
?>

<html>
<head>
<title>Register an Account</title>
</head>
<body>

<?php

if (isset($_POST['submit'])) { // if form has been submitted
    /* check they filled in what they supposed to,
    passwords matched, username
    isn't already taken, etc. */

    if (!$_POST['uname'] || !$_POST['passwd'] ||
        !$_POST['passwd_again'] || !$_POST['email']) {
        die('You did not fill in a required field.');
    }

    // check if username exists in database.

    if (!get_magic_quotes_gpc()) {
        $_POST['uname'] = addslashes($_POST['uname']);
    }

    $qry = "SELECT login FROM accounts WHERE login = '".$_POST['uname']."'";
                $sqlmembers = mysql_query($qry);
                $name_check = mysql_fetch_array ($sqlmembers);
                $name_checkk = mysql_num_rows ($sqlmembers);
    
    if ($name_checkk != 0) {
        die('Sorry, the username: <strong>'.$_POST['uname'].'</strong>'
          . ' is already taken, please pick another one.');
    }

    // check passwords match

    if ($_POST['passwd'] != $_POST['passwd_again']) {
        die('Passwords did not match.');
    }

    // check e-mail format

    if (!preg_match("/.*@.*..*/", $_POST['email']) ||
         preg_match("/(<|>)/", $_POST['email'])) {
        die('Invalid e-mail address.');
    }

    // no HTML tags in username, website, location, password

    $_POST['uname'] = strip_tags($_POST['uname']);
    $_POST['passwd'] = strip_tags($_POST['passwd']);


    // now we can add them to the database.
    // encrypt password

    $_POST['passwd'] = md5($_POST['passwd']);

    if (!get_magic_quotes_gpc()) {
        $_POST['passwd'] = addslashes($_POST['passwd']);
        $_POST['email'] = addslashes($_POST['email']);

    }

    $insert = "INSERT INTO accounts (
            login,
            password,
            email,
            flags,
            last_login)
            VALUES (
            '".$_POST['uname']."',
            '".$_POST['passwd']."',
            '".$_POST['email']."',
            '".$_POST['flags']."',
            'Never')";

    $sqlmembers = mysql_query($insert);
?>

<h1>Registered</h1>

<p>Thank you, your information has been added to the database,
you may now <a href="login.php" title="Login">log in</a>.</p>

<?php

} else {    // if form hasn't been submitted

?>
<h1>Register</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellspacing="0" cellpadding="3">
<tr><td>Username*:</td><td>
<input type="text" name="uname" maxlength="40">
</td></tr>
<tr><td>Password*:</td><td>
<input type="password" name="passwd" maxlength="50">
</td></tr>
<tr><td>Confirm Password*:</td><td>
<input type="password" name="passwd_again" maxlength="50">
</td></tr>
<tr><td>E-Mail*:</td><td>
<input type="text" name="email" maxlength="100">
</td></tr>
 <th>Account Type:</th><td>
                <select name="tbc" type="select">
                  <option value="0">Normal</option>
                  <option selected value="8">Burning Crusade</option>
                  <option value="44">WotLK</option>
                  </select></td>

<tr><td colspan="2" align="right">
<input type="submit" name="submit" value="Sign Up">
</td></tr>
</table>
</form>

<?php

}

?>
</body>
</html>