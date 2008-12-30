<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->
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


<div class="bar"><br /></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('./lib/leftnavi.php')
?>
<td width="430" valign="top">

<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/pcs.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
<?php

error_reporting(E_ALL ^ E_NOTICE);

# If theres no session_id() then create one
if(!session_id())
    session_start();

$msg = Array();
$error = Array();

function ModifyPassword(){
    global $config, $msg, $error;
    if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ) {
        // Insert your code for processing the form here, e.g emailing the submission, entering it into a database. <br>
        $msg[] = 'Security code accepted!';
        unset($_SESSION['security_code']);
    } else {
        // Insert your code for showing an error message here. <br>
        $error[] = 'Error, You have provided an invalid security code!';
    }
    
    # Valid Email: example@example.com
    $pattern_email='^([a-zA-Z0-9._-]+)@((\[[0-9a-zA-Z]{1,3}\.[0-9a-zA-Z]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$';

    # Check submitted data
    if (empty($_POST['login'])) $error[] = 'Error, You forgot to enter your account name!';
    if (empty($_POST['oldpassword'][0]) || empty($_POST['oldpassword'][1])) $error[] = 'Error, You forgot to enter your current password!';
    if ($_POST['oldpassword'][0] !== $_POST['oldpassword'][1]) $error[] = 'Current password does not match!';
    if (empty($_POST['newpassword'][0]) || empty($_POST['newpassword'][1])) $error[] = 'Error, You forgot to enter your new password!';
    if ($_POST['newpassword'][0] !== $_POST['newpassword'][1]) $error[] = 'New password does not match!';
    if (empty($_POST['email']) || !ereg($pattern_email, $_POST['email'])) $error[] = 'Please fill in a valid email adress!';
    if (!empty($error)) return false;

    # Gather Passwords & IP
    $encrypted_oldpassword = sha1(strtoupper($_POST['login']).":".strtoupper($_POST['oldpassword'][1]));
    $encrypted_newpassword = sha1(strtoupper($_POST['login']).":".strtoupper($_POST['newpassword'][1]));
    $ip = $_SERVER['REMOTE_ADDR'];
    
    # Connect to database
    $db = @mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_pass']);
    if (!$db) return $error[] = 'Database: '.mysql_error();
    if (!@mysql_select_db($config['mysql_account'], $db)) return $error[] = 'Database: '.mysql_error();
    
    # Check make sure user isnt ipbanned
    $BanCheck = mysql_query("SELECT * FROM `ipbans` WHERE `ip` = '$ip' || `ip` = '$ip/32' LIMIT `1`");
    $ban = mysql_num_rows($BanCheck);
    if ($ban > 0) { return $error[] = 'You Have Been Banned From This Server'; }

    # Verify email in database
    $EmailCheck = mysql_query("SELECT `email` FROM `accounts` WHERE `email` = '".mysql_real_escape_string($_POST['email'])."' LIMIT 1");
    $echeck = mysql_num_rows($EmailCheck);
    if ($echeck == 0) { return $error[] = 'Your email information doesn\'t checkout.'; }

    # Check password in database
    if($config['EncryptedPass'])
        $PassCheck = mysql_query("SELECT `encrypted_password` FROM `accounts` WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' AND `encrypted_password` = '{$encrypted_oldpassword}' LIMIT 1");
    else
        $PassCheck = mysql_query("SELECT `password` FROM `accounts` WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' AND `password` = '".mysql_real_escape_string($_POST['oldpassword'][1])."' LIMIT 1");

    $pcheck = mysql_num_rows($PassCheck);
    if ($pcheck !== 1) { return $error[] = 'Your password information doesn\'t checkout.'; }	

    # Update password in database
    if($config['EncryptedPass'])
        $query = "UPDATE `accounts` SET `encrypted_password`='{$encrypted_newpassword}' WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' AND encrypted_password='{$encrypted_oldpassword}' LIMIT 1";
    else
        $query = "UPDATE `accounts` SET `password`='".mysql_real_escape_string($_POST['newpassword'][1])."' WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' AND `password` = '".mysql_real_escape_string($_POST['oldpassword'][1])."' LIMIT 1";

    $res = mysql_query($query, $db);
    if (!$res) return $error[] = 'Database: '.mysql_error();
    
    # Account modified
    $msg[] = 'The Account <span style="color:#00FF00"><strong>'.htmlentities($_POST['login']).'</strong></span> has been modified!<br>Allow 5 to 10 Minutes For The Server To Update.';
    
    # Close the database connection
    mysql_close($db);
    return true;
}

# If $_POST is not empty then ModifyPassword()
if(!empty($_POST)){
    ModifyPassword();
}
?>

    <center>
      <div style="width:300px">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		          <div align="center"><br><br><br>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td><input type="button" OnClick="window.location='./account.php'" value="Create Account" class="button"/></td><td><input type="button" OnClick="window.location='./fps.php'" value="Forgotten Password" class="button"/></td>
			</tr>
            <tr class="head"><th colspan="2"></th></tr>
            <tr>
                <th>Username: </th><td align="center"><input class="button" type="text" name="login" size="20" maxlength="16"/></td>
            </tr>
            <tr>
                <th>Old Password: </th><td align="center"><input class="button" type="password" name="oldpassword[]" size="20" maxlength="16"/></td>
            </tr>
            <tr>
                <th>Retype Old Password: </th><td align="center"><input class="button" type="password" name="oldpassword[]" size="20" maxlength="16"/></td>
            </tr>
	        <tr>
                <th>New Password: </th><td align="center"><input class="button" type="password" name="newpassword[]" size="20" maxlength="16"/></td>
            </tr>
            <tr>
                <th> New Retype Password: </th><td align="center"><input class="button" type="password" name="newpassword[]" size="20" maxlength="16"/></td>
            </tr>
            <tr>
                <th>E-mail: </th><td align="center"><input class="button" type="text" name="email" size="20" maxlength="30"/></td>
            </tr>

<TR>
 <th>Security Image: </th><td align="center"><img src="CaptchaSecurityImages.php" />
  </td>
          </tr>
          <TR>
 <th>Security Code: </th><td align="center"><input name="security_code" type="text" class="button" id="security_code" />
  </td>
          </tr>

             				
        </table>
        <input type="button" class="button" value="Back" onClick="history.go(-1)" />
        <input type="submit" value="Submit" class="button"/>
        </form>

		<?php
        if (!empty($error)){
            echo '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr><td class="error" align="center">';
            foreach($error as $text)
                echo $text.'</br>';
            echo '</td></tr></table>';
        };
        if (!empty($msg)){
            echo '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr><td align="center">';
            foreach($msg as $text)
                echo $text.'</br>';
            echo '</td></tr></table>';
            exit();
        };
        ?>

    </div>
    </center>
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
</tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 © <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>