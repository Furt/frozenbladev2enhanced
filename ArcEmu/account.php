// Project Name: FrozenBlade V2 Enhanced"
// Date: 25.07.2008 inital version
// Author: Furt
// Copyright: Kitten
// Email: *****
// License: GNU General Public License (GPL)
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- Addon Script made by Furt -->
<title>FrozenBlade Template by Kitten @ WoWps.org</title>

<link rel="shortcut icon" href="images/favicon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!--[if IE]><link href="css/ie-fix.css" rel="stylesheet" type="text/css"><![endif]-->
<script type="text/javascript" src="./js/img-trans.js"></script>
<script type="text/javascript" src="./js/pre-load.js"></script>
</head><body>

<div class="maintile"><div class="blue"><div class="gryphon-right"><div class="gryphon-left"></div></div></div></div><div class="wowlogo"></div><div></div><div class="container"><div class="top"></div>


<div class="banner"></div>


<div class="bar"></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr><td width="144" valign="top"><div id="links"><font class="style9">


<div class="menu"></div>
	
	
		<!-- Menu Links -->
	
				<li><a href="home.php">Home</a></li><br/><br/>
				<li><a href="recentposts.php">Recent Posts</a></li><br/><br/>
				<li><a href="donate.php">Make a Donation</a></li><br/><br/>
				<li><a href="connect.php">Connection Guide</a></li><br/><br/>
				<li><a href="staff.php">Staff Members</a></li><br/><br/>
	
		<!-- --------- -->
		
			
<div class="account"></div>
	 
		
		<!-- Account Links-->
			
				<li><a href="account.php">Create Account</a></li><br/><br/>
				<li><a href="banchecker.php">Ban Checker</a></li><br/><br/>
				<li><a href="ipban.php">IP Ban Checker</a></li><br/><br/>
		
		<!-- --------- -->		
		
			
<div class="workshop"></div>
				
		
		<!-- Workshop Links -->
			
				<li><a href="vote.php">Vote Page</a></li><br/><br/>
				<li><a href="votecp.php">Vote Panel</a></li><br/><br/>
				<li><a href="unstucker.php">Unstucker</a></li><br/><br/>
				<li><a href="tele.php">Teleporter</a></li><br/><br/>
				<li><a href="stats.php">Status Page</a></li><br/><br/>
				<li><a href="honor.php">Honor Page</a></li><br/><br/>
		
		<!-- --------- -->
			
			
<div class="forum"></div>
			

		<!-- Forum Links -->
			
				<li><a href="./forum">Forum Home</a></li><br/><br/>
				<li><a href="./forum">Bug Reporting</a></li><br/><br/>
				<li><a href="./forum">Announcements</a></li><br/><br/>
				<li><a href="./forum">General Chat</a></li><br/><br/>
				<li><a href="./forum">General Support</a></li><br/><br/>
				
		<!-- --------- -->	
	
	
</font></div><br/></td><td width="430" valign="top">

<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/account.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
  <!-- account script start -->
  <?php
include 'config.php';

error_reporting(E_ALL ^ E_NOTICE);

if(!session_id())
    session_start();

$msg = Array();
$error = Array();

function addUser(){
    global $config, $msg, $error;
    if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ) {
        // Insert you code for processing the form here, e.g emailing the submission, entering it into a database. <br>
        $msg[] = 'Security code accepted!';
        unset($_SESSION['security_code']);
    } else {
        // Insert your code for showing an error message here<br>
        $error[] = 'Error, You have provided an invalid security code!';
    }
    
    # Valid Email: example@example.com
    $pattern_email='^([a-zA-Z0-9._-]+)@((\[[0-9a-zA-Z]{1,3}\.[0-9a-zA-Z]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$';
    # Valid String: abc123
    $pattern_string='^[0-9a-zA-Z]';
    
    if (empty($_POST['login'])) $error[] = 'Error, You forgot to enter an account name!';
    if (empty($_POST['password'][0]) || empty($_POST['password'][1])) $error[] = 'Error, You forgot to enter a password!';
    if ($_POST['password'][0] !== $_POST['password'][1]) $error[] = 'Password does not match!';
    if (empty($_POST['email']) || !ereg($pattern_email, $_POST['email'])) $error[] = 'Please fill in a valid email adress!';
    if (!empty($error)) return false;
    
    # Extra Checks - To enable uncomment the following
    #define("STRING_CHECK", 1);
    
    if(defined("STRING_CHECK"))
    {
        if (!ereg($pattern_string, $_POST['login'])) $error[] = 'Error, Your account name contains invalid letters!';
        if (!ereg($pattern_string, $_POST['password'][1])) $error[] = 'Error, Your password contains invalid letters!';
        if (!empty($error)) return false;
    }
    
    # Gather Password & IP
    # $encrypted_password = sha1($_POST['password'][1]);
    $encrypted_password = sha1(strtoupper($_POST['login']).":".strtoupper($_POST['password'][1]));
    $ip = $_SERVER['REMOTE_ADDR'];
    
    # Connect to database
    $db = @mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_pass']);
    if (!$db) return $error[] = 'Database: '.mysql_error();
    if (!@mysql_select_db($config['mysql_dbname'], $db)) return $error[] = 'Database: '.mysql_error();

    # Check make sure user isnt ipbanned 
    $BanCheck = mysql_query("SELECT * FROM ipbans WHERE ip = '$ip' || ip = '$ip/32' LIMIT 1");
    $ban = mysql_num_rows($BanCheck);
    if ($ban == 1) { return $error[] = 'You Have Been Banned From This Server'; }
    
    # Check account limit for IP address
    if($config['MaxIPs'] > 0)
    {
        $UserCheck = mysql_query("SELECT * FROM accounts WHERE lastip = '$ip'");
        if (mysql_num_rows($UserCheck) >= $config['MaxIPs']) return $error[] = '<font size=2 face=Tahoma><br /><b> You have reached your maximum amount of accounts</b></font>';
    }

    # Check username is not in use already
    $query = "SELECT `acct` FROM `accounts` WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' LIMIT 1";
    $res = mysql_query($query, $db);
    if (!$res) return $error[] = 'Database: '.mysql_error();
    if (mysql_num_rows($res) > 0) return $error[] = 'Username already in use.';

    # Check account limit for email
    if($config['MaxEmails'] > 0)
    {
        $email = "SELECT `acct` FROM `accounts` WHERE `email` = '".mysql_real_escape_string($_POST['email'])."'";
        $re = mysql_query($email, $db);
        if (!$re) return $error[] = 'Database: '.mysql_error();
        if (mysql_num_rows($re) >= $config['MaxEmails']) return $error[] = '<font size=2 face=Tahoma><br /><b> You have reached your maximum amount of accounts using that email address.</b></font>';
    }

    if($config['EncryptedPass'] > 0)
        $query = "INSERT INTO `accounts` (`acct`, `login`, `encrypted_password`, `gm`, `banned`, `lastlogin`, `lastip`, `email`, `flags`, `forceLanguage`, `muted`) VALUES (NULL, '".mysql_real_escape_string($_POST['login'])."', '$encrypted_password', '0', '0', NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tbc'][0])."', 'enUS', '0')";
    else
        $query = "INSERT INTO `accounts` (`acct`, `login`, `password`, `gm`, `banned`, `lastlogin`, `lastip`, `email`, `flags`, `forceLanguage`, `muted`) VALUES (NULL, '".mysql_real_escape_string($_POST['login'])."', '".mysql_real_escape_string($_POST['password'][1])."', '0', '0', NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tbc'][0])."', 'enUS', '0')";

    $res = mysql_query($query, $db);
    if (!$res) return $error[] = 'Database: '.mysql_error();
    $msg[] = '<center>The Account <span style="color:#00FF00"><strong>'.htmlentities($_POST['login']).'</strong></span> has been created!</center></br>';
    mysql_close($db);
    return true;
}
if(!empty($_POST)){
    addUser();
}

?>
        
        
      </div>
      <div style="width:150px">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div align="center"><br>
            <br><br>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td><input type="button" OnClick="window.location='./pcs.php'" value="Password Changer" class="button"/></td><td><input type="button" OnClick="window.location='./fps.php'" value="Forgotten Password" class="button"/></td>
                </tr>
              <tr class="head">
                <th colspan="2"><?=$config['PageTitleACS'];?></th></tr>
              <tr>
                <th>Username: </th><td><input class="button" type="text" name="login" size="20" maxlength="16"/></td>
                </tr>
              <tr>
                <th>Password: </th><td><input class="button" type="password" name="password[]" size="20" maxlength="16"/></td>
                </tr>
              <tr>
                <th>Retype Password: </th><td><input class="button" type="password" name="password[]" size="20" maxlength="16"/></td>
                </tr>
              <tr>
                <th>E-mail: </th><td><input class="button" type="text" name="email" size="20" maxlength="30"/></td>
                </tr>
              
              <th>Account Type:</th><td>
                <select name="tbc" type="select">
                  <option value="0">Normal</option>
                  <option selected value="8">Burning Crusade</option>
                  <option value="44">WotLK</option>
                  </select></td>
                
                <TR>
                  <th>Security Image: </th><td><img src="CaptchaSecurityImages.php" />
                    </td>
                  </tr>
              <TR>
                <th>Security Code: </th><td><input name="security_code" type="text" class="button" id="security_code" />
                  </td>
                </tr>
              
              
            </table>
            <input type="button" class="button" value="Back" onClick="history.go(-1)" />
            <input type="submit" value="Submit" class="button"/>
          </div>
          </form>
        
        <div align="center">
          <?php
        if (!empty($error)){
            foreach($error as $text)
                echo $text.'</br>';
        };
        if (!empty($msg)){
            foreach($msg as $text)
                echo $text.'</br>';
            exit();
        };
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

<br /></td><td width="144" valign="top">


	<!-- Create Account Image/Link -->
		
		<a href="account.php"><div class="join"></div></a>

	<!-- --------- -->


<div class="stats"></div><font class="style30"><center>


			<!-- Server Online/Offline Status PHP Script -->

					<?php    
							
							if (! $sock = @fsockopen($ip, $port, $num, $error, 5))
								echo "<img src='images/temp/server-off.png'>";
							else{
								echo "<img src='images/temp/server-on.png'>";
								fclose($sock);
								}      
            		?>

			<!-- PHP Script Created by DJRavine -->



</center>
&nbsp;				Realmlist:
<center>						logon.crimson-storm.net
</center><br/>

</font><div class="vote"></div><center><font class="style10">
			

	<!-- Vote Links -->

		<a href="http://www.xtremetop100.com/world-of-warcraft/" target="_blank">
		<img src="images/friends+vote/xtremetop.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://www.wowserverslist.com/" target="_blank">
		<img src="images/friends+vote/wowservers.png" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>

	<!-- --------- -->


<br/></font></center><div class="affiliation"></div><font class="style10"><center>
			

	<!-- Affiliation Links -->
		
		<a href="http://wowps.org/forum/">
		<img src="images/friends+vote/wowps.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://virtue.nadasoft.net/">
		<img src="images/friends+vote/virtue.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://nadacod4.com/">
		<img src="images/friends+vote/nadacod4.gif" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://nadasoft.net/">
		<img src="images/friends+vote/nadasoft.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>

	<!-- --------- -->
	

</font><br/><br/><br/><br/></center></td></tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 © <a href="http://wowps.org/forum">WoWps.org</a> and yoursite.net. All rights reserved.<br />Designed and Coded by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>