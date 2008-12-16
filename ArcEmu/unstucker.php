// Project Name: FrozenBlade V2 Enhanced"
// Date: 25.07.2008 inital version
// Coded by: Furt
// Developed by: Kitten
// Email: *****
// License: GNU General Public License (GPL)
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
require_once('./lib/config.php')
?>
<title><?php  echo $config['Title']; ?></title>

<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!--[if IE]><link href="css/ie-fix.css" rel="stylesheet" type="text/css"><![endif]-->
<script type="text/javascript" src="./js/img-trans.js"></script>
<script type="text/javascript" src="./js/pre-load.js"></script>
</head><body>

<div class="maintile"><div class="blue"><div class="gryphon-right"><div class="gryphon-left"></div></div></div></div><div class="wowlogo"></div><div></div><div class="container"><div class="top"></div>


<div class="banner"></div>


<div class="bar"><br /><center><?php include('login-form.php') ?></center></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('./lib/leftnavi.php')
?>
<td width="430" valign="top">

<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/unstucker.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
  <!-- script start -->
<br><br><br>
<?php
//if unstuck button is pressed, verify and query db if valid
if(isset($_POST['submit']))
{
	//players account name, password and character name
	$account = $_POST['account'];
	$password = $_POST['password'];
	$character = $_POST['character'];

include_once "config.php";


	//get account id from characters table where the name is character '$character'
	$con = mysql_connect($cHost.":".$cPort, $cUsername, $cPass) or die(mysql_error());
	mysql_select_db($cDatabase) or die(mysql_error());

	$character = mysql_real_escape_string(htmlentities($character));

	$query = "SELECT acct FROM characters WHERE name = '".$character."'";

	$result = mysql_query($query) or die(mysql_error());
	$numrows = mysql_num_rows($result);

	echo "<tr><td align=center>";

	//if no rows exist, the character does not exist
	if($numrows == 0)
	{
		die("No such character exists on that account!");
	}

	$row = mysql_fetch_array($result);
	$acct = $row[0];

	mysql_close();

	//get make sure the character exists on the correct account and password is the same
	$con = mysql_connect($aHost.":".$aPort, $aUsername, $aPass) or die(mysql_error());
	mysql_select_db($aDatabase) or die(mysql_error());

	$account = mysql_real_escape_string($account);
	$password = mysql_real_escape_string($password);
	$acct = mysql_real_escape_string($acct);

	$query = "SELECT login, acct, password FROM accounts WHERE login ='".$account."' AND password = '".$password."' AND acct = '".$acct."'";

	$result = mysql_query($query) or die(mysql_error());
	$numrows = mysql_num_rows($result);

	//if no rows, user entered invalid data
	if ($numrows == 0)
	{
		die("Account name or password is incorrect!");
	}
	mysql_close();
	$con = mysql_connect($cHost.":".$cPort, $cUsername, $cPass) or die(mysql_error());
	mysql_select_db($cDatabase) or die(mysql_error());

	//update the character table to set the character to hearth location
	$query = "update characters SET positionX = bindpositionX, positionY = bindpositionY, positionZ = bindpositionZ, mapId = bindmapId, zoneId = bindzoneId, deathstate = 0 WHERE name = '".$character."'";

	mysql_query($query) or die(mysql_error());

	echo "<center>";
	echo "<br />";
	echo "<br />";
	echo "The Character with the name '<b>".$character."</b>' under Account '<b>".$account."</b>' has been unstuck!<br>";
	echo "<a href='javascript:history.go(-1)'>Back</a>";

	echo "</td></tr>";

	//close mysql connection
	mysql_close();
}
//if page is loaded, display unstuck form
else
{
	echo "<center>";
	echo "<form name=myform method=post action='unstucker.php'>";

	echo "<br />";
	echo "<tr><td>Account: </td><td><input type=text name=account value=''></td></tr>";
	echo "<br />";
	echo "<tr><td>Character: </td><td><input type=text name=character value=''></td></tr>";
	echo "<br />";
	echo "<tr><td>Password: </td><td><input type=password name=password value=''></td></tr>";
	echo "<br />";
	echo "<tr><td><br><input type=submit name=submit value=Unstuck></td></tr>";
	echo "</form>";
}

	echo "<center>";
	echo "</table>";
	echo "<br />";
	echo "<br />";
	echo "<small>You <b>MUST</b> be offline for this tool to successfully work</small><br /><br />";
	echo "<br />";
	echo " ";
	echo "<br />";
	echo "</center>";
?>
          <!-- script stop -->
          
          <center><br/>
        </div>
      </div>
      <div align="center">
        </center>
      </div>
</div>
<div class="story-bot" align="center"><br/>

</div>

<!-- End News Post -->

<br /></td>
<?php
include('./lib/rightnavi.php')
?>
</tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 © <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>