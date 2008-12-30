<?php

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    $logged_in = 0;
    return;
} else {

    // remember, $_SESSION['password'] will be encrypted.

    if(!get_magic_quotes_gpc()) {
        $_SESSION['username'] = addslashes($_SESSION['username']);
    }
    // addslashes to session username before using in a query.
    $qry = "SELECT password FROM accounts WHERE login = '".$_SESSION['username']."'";
    $sqlmembers = mysql_query($qry);
    $pass =  mysql_num_rows($sqlmembers);

    if($pass != 1) {
        $logged_in = 0;
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        // kill incorrect session variables.
    }

    $db_pass =  mysql_fetch_array ($sqlmembers);

    // now we have encrypted pass from DB in
    //$db_pass['password'], stripslashes() just incase:

    $db_pass['password'] = stripslashes($db_pass['password']);
    $_SESSION['password'] = stripslashes($_SESSION['password']);

    //compare:

    if($_SESSION['password'] == $db_pass['password']) {
        // valid password for username
        $logged_in = 1; // they have correct info
                    // in session variables.
    } else {
        $logged_in = 0;
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        // kill incorrect session variables.
    }
}

// clean up
unset($db_pass['password']);

$_SESSION['username'] = stripslashes($_SESSION['username']);

?>