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


<div class="bar"></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('./lib/leftnavi.php')
?>
<td width="430" valign="top">

<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/account.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
  <!-- account script start -->
<?php
// Connects to your Database
mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
mysql_select_db($config['mysql_dbname']) or die(mysql_error());

//checks cookies to make sure they are logged in
if(isset($_COOKIE['ID_my_site']))
{
$username = $_COOKIE['ID_my_site'];
$pass = $_COOKIE['Key_my_site'];
$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
while($info = mysql_fetch_array( $check ))
{

//if the cookie has the wrong password, they are taken to the login page
if ($pass != $info['password'])
{ header("Location: login.php");
}

//otherwise they are shown the admin area
else
{
echo "<a href=logout.php>[Logout]</a><br>";     echo "<a href=forum/>[forum]</a><br>"; 
echo "Greetings $username, welcome to the Brand new Account management page! PLease report All bugs on the forum =]";
echo " ------------------------------------------------------------------------------------";
echo "<br><br><br>";
echo "<a href=account/unstuck.php>unstuck</a>";
}
}
}
else

//if the cookie does not exist, they are taken to the login screen
{
header("Location: login.php");
}
?> 
          
          <!-- account reg stop -->
          
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