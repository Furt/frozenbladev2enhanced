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
<br/><br/><br/><br/><br/><br/><img src="images/text/account.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
  <!-- script start -->
<br><br><br>
<?php
//account database info
include_once "config.php";

//default = 250g per transport. ex: $TELEPORT_COST = 954, would mean 954 gold per transport
				

if(isset($_POST['submit']))
{
	$account = $_POST['account'];
	$password = $_POST['password'];
	$character = $_POST['character'];
	$location = $_POST['location'];

	$acct = "";							//acct id from db
	$race = "";							//characters race id

	$con = mysql_connect($aHost.":".$aPort, $aUsername, $aPass) or die(mysql_error());
	mysql_select_db($aDatabase) or die(mysql_error());

	$account = mysql_real_escape_string($account);
	$password = mysql_real_escape_string($password);
	$character = mysql_real_escape_string($character);
	$location = mysql_real_escape_string($location);

	$query = "SELECT acct FROM accounts WHERE login = '".$account."' AND password = '".$password."'";

	$result = mysql_query($query) or die(mysql_error());
	$numrows = mysql_num_rows($result);

	echo "<tr><td align=center>";

	//if no rows exist, wrong username/password
	if($numrows == 0)
	{
		die("<center>Invalid Username/Password!</center>");
	}
	else
	{
		$row = mysql_fetch_array($result);
		$acct = $row[0];
	}
	mysql_close();	//kill connection to accounts db

	$con = mysql_connect($cHost.":".$cPort, $cUsername, $cPass) or die(mysql_error());
	mysql_select_db($cDatabase) or die(mysql_error());
	$query = "SELECT race, gold FROM characters WHERE acct = ".$acct." AND name = '".$character."'";

	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);

	if ($numrows == 0)
	{
		die("That Character does not exist on that Account!");
	}

	$row = mysql_fetch_array($result);
	$race = $row[0];

	if($row[1] < ($TELEPORT_COST * 10000))
	{
		die("Your Character does not have enough Gold to be teleported");
	}
	$gold = $row[1];

	$map = "";
	$x = "";
	$y = "";
	$z = "";
	$place = "";

	// Updated as of 23/09/2008
	switch($location)
	{
		//stormwind
		case 1:
			$map = "0";
			$x = "-8913.23";
			$y = "554.633";
			$z = "93.7944";
			$place = "Stormwind City";
			break;
		//ironforge
		case 2:
			$map = "0";
			$x = "-4981.25";
			$y = "-881.542";
			$z = "501.66";
			$place = "Ironforge";
			break;
		//darnassus
		case 3:
			$map = "1";
			$x = "9951.52";
			$y = "2280.32";
			$z = "1341.39";
			$place = "Darnassus";
			break;
		//exodar
		case 4:
			$map = "530";
			$x = "-3987.29";
			$y = "-11846.6";
			$z = "-2.01903";
			$place = "The Exodar";
			break;
		//orgrimmar
		case 5:
			$map = "1";
			$x = "1676.21";
			$y = "-4315.29";
			$z = "61.5293";
			$place = "Orgrimmar";
			break;
		//thunderbluff
		case 6:
			$map = "1";
			$x = "-1196.22";
			$y = "29.0941";
			$z = "176.949";
			$place = "Thunder Bluff";
			break;
		//undercity
		case 7:
			$map = "0";
			$x = "1586.48";
			$y = "239.562";
			$z = "-52.149";
			$place = "The Undercity";
			break;
		//silvermoon
		case 8:
			$map = "530";
			$x = "9473.03";
			$y = "-7279.67";
			$z = "14.2285";
			$place = "Silvermoon City";
			break;
		//shattrath
		case 9:
			$map = "530";
			$x = "-1863.03";
			$y = "4998.05";
			$z = "-21.1847";
			$place = "Shattrath City";
			break;
		//dalaran
		case 20:
			$map = "571"; // Need Coords
			$x = "5812.79"; // Need Coords
			$y = "647.158"; // Need Coords
			$z = "647.413"; // Need Coords
			$place = "Dalaran";
			break;
		//valiance keep
		case 21:
			$map = "571"; // Need Coords
			$x = "2285.24"; // Need Coords
			$y = "5244.92"; // Need Coords
			$z = "11.3552"; // Need Coords
			$place = "Valiance Keep";
			break;
		//warsong hold
		case 22:
			$map = "571"; // Need Coords
			$x = "2508.75"; // Need Coords
			$y = "6172.98"; // Need Coords
			$z = "53.1912"; // Need Coords
			$place = "Warsong Hold";
			break;
		//for unknowness -> Shattrath City
		default:
			die("That is an invalid location!");
			break;
	}

	//disallows factions to use enemy portals
	switch($race)
	{
		//alliance
		case 1:
		case 3:
		case 4:
		case 7:
		case 11:
			if((($location >=5) && ($location <=8)) && ($location != 9))
			{
				die("<center>Alliance players can <b>NOT</b> Teleport to Horde areas!</center>");
			}	
			break;
		//horde
		case 2:
		case 5:
		case 6:
		case 8:
		case 10:
			if ((($location >=1) && ($location <=4)) && ($location != 9))
			{
				die("<center>Horde Players can <b>NOT</b> Teleport to Alliance areas!</center>");
			}
			break;
		default:
			die("<center>That is not a valid Race!</center>");
			break;
	}

	$newGold = $gold - ($TELEPORT_COST * 10000);

	$query = "UPDATE characters SET positionX = ".$x.", positionY = ".$y.", positionZ = ".$z.", mapid = ".$map.", gold = ".$newGold." WHERE acct = ".$acct." AND name = '".$character."'";
	$result = mysql_query($query) or die(mysql_error());

	echo "<center";
	echo "<br />";
	echo "<br />";
	echo "The Character '<b>".$character."</b>' (Account: '<b>".$account."</b>') has been teleported to '<b>".$place."</b>'<br />";
	echo "The Character '<b>".$character."</b>' now has '<b>".($newGold / 10000)."</b>' Gold left<br />";
	echo "<a href='javascript:history.go(-1)'>Back</a>";
	echo "</center>";

	mysql_close();	//kill connection to characters db
}
else
{
	echo "<center>";
	echo "<form name=myform method=post action'/tele.php'>";

	echo "<br />";
	echo "<h1><u><b>Character Teleporter</b></u></h1>";
	echo "<tr><td colspan=2 align=center><font size=1>(<b>Note</b>: Cost is <b>".$TELEPORT_COST."g</b> for 1 teleport)</font></td></tr>";
	echo "<br />";
	echo "<br />";
	echo "<tr><td width=125>Account: </td><td><input type=text name=account value=''></td></tr>";
	echo "<br />";
	echo "<tr><td width=125>Password: </td><td><input type=password name=password value=''></td></tr>";
	echo "<br />";
	echo "<tr><td width=125>Character: </td><Td><input type=text name=character value=''></td></tr>";
	echo "<br />";
	echo "<tr><td width=125>Location: </td><td>";

	echo "<select name=location>";
	echo "<option value='--------'>---Alliance---</option>";
	echo "<option value='1'>Stormwind City</option>";
	echo "<option value='2'>Ironforge</option>";
	echo "<option value='3'>Darnassus</option>";
	echo "<option value='4'>The Exodar</option>";
	echo "<option value='21'>Valiance Keep</option>";
	echo "<option value='--------'>---Horde---</option>";
	echo "<option value='5'>Orgrimmar</option>";
	echo "<option value='6'>Thunder Bluff</option>";
	echo "<option value='7'>The Undercity</option>";
	echo "<option value='8'>Silvermoon City</option>";
	echo "<option value='22'>Warsong Hold</option>";
	echo "<option value='--------'>---Neutral---</option>";
	echo "<option value='9'>Shattrath City</option>";
	echo "<option value='20'>Dalaran</option>";
	echo "</select>";
	echo "<br />";
	echo "<tr><td colspan=2 align=center><br><input type=submit name=submit value=Teleport></td></tr>";
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

<br /></td>
<?php
include('./lib/rightnavi.php')
?>
</tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 � <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>