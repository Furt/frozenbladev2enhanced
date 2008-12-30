<?php

//Configuration

//Logon Database information.
define("LOGON_HOST","localhost");
define("LOGON_USER","root");
define("LOGON_PASS","danielle");
define("LOGON_DB","logon");
define("ENCRYPT_PASSWORDS",false); // !!! - Not yet supported

//Local webserver's MySQL information.
define("MYSQL_HOST","localhost");
define("MYSQL_USER","root");
define("MYSQL_PASS","danielle");
define("MYSQL_DB","avs");

//In game mail settings
define("MAIL_SUBJECT","Thanks For Voting!");
define("MAIL_BODY","Thank you for voting for our server. Here is your reward!");

// Misc
define("RPPV",1); // Reward points per vote. Must be a whole number.

if(!session_id())
    session_start();
// force login to view.
if(!$_SESSION['vcp']['authenticated'] && $_GET['act'] != "vote")
{
	include("pages/login.php");
	new Login();
	die;
}
switch($_GET['act'])
{
default:
	include("pages/overview.php");
	new Overview();
	break;
case "logout":
    if(session_id())
        session_destroy();
header("Location: index.php");
    break;
case "rewards":
	include("pages/rewards.php");
	new Rewards();
	break;
case "spend":
	include("pages/spend.php");
	new Spend();
	break;
case "vote":
	include("pages/vote.php");
	new Vote();
	break;
}
?>