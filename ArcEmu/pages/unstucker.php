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
<br/><br/><br/><br/><br/><br/><img src="images/text/unstucker.png" />
</div></div><div class="story"><center><div style="width:300px; text-align:left">
      <div align="center">

	  <!-- script start -->
<br /><br /><br />
<?php
//if unstuck button is pressed, verify and query db if valid
if(isset($_POST['submit']))
{
	//players account name, password and character name
	$account = $_POST['account'];
	$password = $_POST['password'];
	$character = $_POST['character'];


	//get account id from characters table where the name is character '$character'
	$con = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_character']) or die(mysql_error());

	$character = mysql_real_escape_string(htmlentities($character));

	$query = "SELECT acct FROM characters WHERE name = '".$character."'";

	$result = mysql_query($query) or die(mysql_error());
	$numrows = mysql_num_rows($result);

	//if no rows exist, the character does not exist
	if($numrows == 0)
	{
		die("No such character exists on that account!");
	}

	$row = mysql_fetch_array($result);
	$acct = $row[0];

	mysql_close();

	//get make sure the character exists on the correct account and password is the same
	$con = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_account']) or die(mysql_error());

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
	$con = mysql_connect($config['mysql_host'].":".$config['mysql_port'], $config['mysql_user'], $config['mysql_pass']) or die(mysql_error());
	mysql_select_db($config['mysql_character']) or die(mysql_error());

	//update the character table to set the character to hearth location
	$query = "update characters SET player_flags = 0, positionX = bindpositionX, positionY = bindpositionY, positionZ = bindpositionZ, mapId = bindmapId, zoneId = bindzoneId, deathstate = 0, aura = NULL WHERE name = '".$character."'";

	mysql_query($query) or die(mysql_error());
	?>
	<br />
	<br />
	The Character <b><?php echo $character ?></b> (Account: <b><?php echo $account ?></b>)<br />has been unstuck!<br />
	<br /><a href='javascript:history.go(-1)'><center><b>BACK</b></center></a>

	
	<?php
	//close mysql connection
	mysql_close();
}
//if page is loaded, display unstuck form
else
{
	?>
	<center>
    <form action="home.php?act=Unstucker" method="post" name="myform" id="myform">
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
</table>
	<input type="submit" name="submit" value="Unstuck" />
	</form>
   	<br />
	You <b>MUST</b> be offline for this tool to successfully work
    </center>
<?php } ?>
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