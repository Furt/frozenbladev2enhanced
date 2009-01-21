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
<br/><br/><br/><br/><br/><br/><img src="images/text/account.png">
</div></div><div class="story"><center><div style="width:300px; text-align:left">
      <div align="center">
	        </div>
      <div style="width:300px">
  <!-- account script start -->
  <?php
  
	/*
	Function name: CHECK FOR SYMBOLS
	Description: return TRUE if matches. ( True = OK ) ( False = NOT OKÂ*Â*)
	*/
	function check_for_symbols($string){
		$len=strlen($string);
		$alowed_chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		for($i=0;$i<$len;$i++)if(!strstr($alowed_chars,$string[$i]))return TRUE;
	return FALSE;
	}
	
	/*
	Function name: OUTPUT USERNAME:PASSWORD AS SHA1 crypt
	Description: obious.
	*/
	function sha_password($user,$pass){
		$user = strtoupper($_POST[username]);
		$pass = strtoupper($_POST[password]);
		
	return SHA1($user.':'.$pass);
	}
	if ($_POST['registration']){
		/*Connect and Select*/
		$realmd_bc_new_connect = mysql_connect($config['mysql_host'],$config['mysql_user'],$config['mysql_pass']);
		$selectdb = mysql_select_db($config['mysql_account'],$realmd_bc_new_connect);
	if (!$realmd_bc_new_connect || !$selectdb){
		echo "Could NOT connect to db, please check the config part of the file!";
	die;
	}
	/*Checks*/
	$email = $_POST['email'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$flag = $_POST['flag'];
	$username = strtoupper($_POST['username']);
	$encrypted_password = sha_password($username,$_POST['password']);

	$qry_check_username = mysql_query("SELECT username FROM `account` WHERE username='$username'");
	
	if(empty($_POST['username'])) {
		echo "Username field is blank";
	}
	
	if (check_for_symbols($_POST[password]) == TRUE || check_for_symbols($username) == TRUE || mysql_num_rows($qry_check_username) != 0){
		echo '<br><br><br><br>Error with creating account, might already be in use or your username / password has invalid symbols in it.<br><br><center><input type="button" class="button" value="Back" onClick="history.go(-1)" /></center>';
	}else{
	mysql_query("INSERT INTO account (`username`, `sha_pass_hash`, `gmlevel`, `email`, `last_ip`, `expansion`) VALUES ('$username', '$encrypted_password', '0', '$email', '$ip', '$flag')");// Insert into database.
		echo '<br><br><br><br><center>The Account <span style="color:#00FF00"><strong>'.htmlentities($_POST['username']).'</strong></span> has been created!</br><input type="button" class="button" value="Back" onClick="history.go(-1)" /></center>';
}


}else{
?>
        <form action="home.php?act=Account" method="POST">
          <div align="center">
            <br><br>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td></td><td></td>
                </tr>
              <tr class="head">
                <th colspan="2"></th></tr>
              <tr>
                <th>Username: </th><td><input class="button" type="text" name="username" size="20" maxlength="16"/></td>
                </tr>
              <tr>
                <th>Password: </th><td><input class="button" type="password" name="password[]" size="20" maxlength="16"/></td>
                </tr>
              <tr>
                <th>E-mail: </th><td><input class="button" type="text" name="email" size="20" maxlength="30"/></td>
                </tr>
              
              <th>Account Type:</th><td>
                <select name="flag" type="select">
                  <option value="0">Normal</option>
                  <option value="1">Burning Crusade</option>
                  <option selected value="2">WotLK</option>
                  </select></td>
                
                <TR>
                  <th>Security Image: </th><td><img src="CaptchaSecurityImages.php" />
                    </td>
                  </tr>
              <TR>
                <th>Security Code: </th><td><input name="security_code" type="text" class="button" id="security_code" />
                  </td>
                </tr>
              
              
            </table><br>
            <input type="button" class="button" value="Back" onClick="history.go(-1)" />
            <input type="submit" name="registration" value="Submit" class="button"/>
          </div></form>
<?php
// Do not remove this;)
}
?>
          <!-- account reg stop -->
		<center>
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