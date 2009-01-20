<?php
$choice=$_GET['act'];

function home()
{}
switch($choice)
{
case "Donate":
include ("pages/donate.php");
break;

case "Connect":
include ("pages/connect.php");
break;

case "Staff_Members":
include ("pages/staff.php");
break;

case "Account":
include ("pages/account.php");
include ("lib/rightnavi.php");
break;

case "Change_Pass":
include ("pages/pcs.php");
include ("lib/rightnavi.php");
break;

case "Get_Pass":
include ("pages/fps.php");
include ("lib/rightnavi.php");
break;

case "Unstucker":
include ("pages/unstucker.php");
include ("lib/rightnavi.php");
break;

case "Teleporter":
include ("pages/teleporter.php");
include ("lib/rightnavi.php");
break;

case "Status":
include ("pages/status.php");
include ("lib/rightnavi.php");
break;

default:
case "News":
include ("pages/news.php");
include ("lib/rightnavi.php");
break;
home();
}
?>