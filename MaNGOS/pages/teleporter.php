<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Unstuck script by: Blackboy0
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->
<td width="430" valign="top">
<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/teleporter.png">
</div></div><div class="story"><center><div style="width:300px; text-align:left">
      <div align="center">

	  <!-- script start -->
<br><br><br>
<?php

if(isset($_POST['submit']))
{
	$account = $_POST['account'];
	$password = $_POST['password'];
	$character = $_POST['character'];
	$location = $_POST['location'];

	$acct = "";							//acct id from db
	$race = "";							//characters race id

	$con = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_account']) or die(mysql_error());

	$account = mysql_real_escape_string($account);
	$password = mysql_real_escape_string($password);
	$character = mysql_real_escape_string($character);
	$location = mysql_real_escape_string($location);

	$query = "SELECT acct FROM accounts WHERE login = '".$account."' AND password = '".$password."'";

	$result = mysql_query($query) or die(mysql_error());
	$numrows = mysql_num_rows($result);
	
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

	$con = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_character']) or die(mysql_error());
	$query = "SELECT race, gold FROM characters WHERE acct = ".$acct." AND name = '".$character."'";

	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);

	if ($numrows == 0)
	{
		die("That Character does not exist on that Account!");
	}

	$row = mysql_fetch_array($result);
	$race = $row[0];

	if($row[1] < ($config['teleport_cost'] * 10000))
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

	$newGold = $gold - ($config['teleport_cost'] * 10000);

	$query = "UPDATE characters SET positionX = ".$x.", positionY = ".$y.", positionZ = ".$z.", mapid = ".$map.", gold = ".$newGold." WHERE acct = ".$acct." AND name = '".$character."'";
	$result = mysql_query($query) or die(mysql_error());
	?>
	<center
	<br />
	<br />
	The Character <b><?php echo $character ?></b> (Account: <b><?php echo $account ?></b>) has been teleported to <b><?php echo $place ?></b>.<br />
	The Character <b><?php echo $character ?></b> now has <b><?php echo ($newGold / 10000) ?></b> Gold left.<br />
	<a href='javascript:history.go(-1)'><br /><center><b>BACK</b></center></a>
	</center>
	<?php
	mysql_close();	//kill connection to characters db
}
else
{
	?>
    <center>
    <form action="home.php?act=Teleporter" method="post" name="myform" id="myform">
    (<b>Note</b>: Cost is <b><?php echo $config['teleport_cost'] ?>g</b> for 1 teleport)
	<br /><br />

    <table width="200" border="0">
  <tr>
    <td>Account:</td>
    <td><input type="text" name="account" value='' /></td>
  </tr>
  <tr>
    <td>Character:</td>
    <td><input type="text" name="character" value='' /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="password" name="password" value='' /></td>
  </tr>
  <tr>
    <td>Location:</td>
    <td><select name=location>
	<option value='--------'>---Alliance---</option>
	<option value='1'>Stormwind City</option>
	<option value='2'>Ironforge</option>
	<option value='3'>Darnassus</option>
	<option value='4'>The Exodar</option>
	<option value='21'>Valiance Keep</option>
	<option value='--------'>---Horde---</option>
	<option value='5'>Orgrimmar</option>
	<option value='6'>Thunder Bluff</option>
	<option value='7'>The Undercity</option>
	<option value='8'>Silvermoon City</option>
	<option value='22'>Warsong Hold</option>
	<option value='--------'>---Neutral---</option>
	<option value='9'>Shattrath City</option>
	<option value='20'>Dalaran</option>
	</select></td>
  </tr>
</table>
	<input type="submit" name="submit" value="Teleport" />
	</form>
	<br /><br />
	You <b>MUST</b> be offline for this tool to successfully work</small><br />
</center>

<?php
}
?>

          <!-- script stop -->
          
          <center>
        </div>
      </div>
      <div align="center">
        </center>
      </div>
</div>
<div class="story-bot" align="center"><br/>
</div><br /></td>