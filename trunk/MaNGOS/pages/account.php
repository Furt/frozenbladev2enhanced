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
  <!-- account script start -->
  <?php

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
    
    # Encrypt Password & Get IP
    $encrypted_password = sha1(strtoupper($_POST[login]) . ':' . strtoupper($_POST[password])); 
    $ip = $_SERVER['REMOTE_ADDR'];
    
    # Connect to database
    $db = @mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_pass']);
    if (!$db) return $error[] = 'Database: '.mysql_error();
    if (!@mysql_select_db($config['mysql_account'], $db)) return $error[] = 'Database: '.mysql_error();

    # Check make sure user isnt ipbanned 
    $BanCheck = mysql_query("SELECT * FROM ip_banned WHERE ip = '$ip' || ip = '$ip/32' LIMIT 1");
    $ban = mysql_num_rows($BanCheck);
    if ($ban == 1) { return $error[] = 'You Have Been Banned From This Server'; }
    
    # Check account limit for IP address
    if($config['MaxIPs'] > 0)
    {
        $UserCheck = mysql_query("SELECT * FROM account WHERE last_ip = '$ip'");
        if (mysql_num_rows($UserCheck) >= $config['MaxIPs']) return $error[] = '<font size=2 face=Tahoma><br /><b> You have reached your maximum amount of accounts</b></font>';
    }

    # Check username is not in use already
    $query = "SELECT `id` FROM `account` WHERE `username` = '".mysql_real_escape_string($_POST['login'])."' LIMIT 1";
    $res = mysql_query($query, $db);
    if (!$res) return $error[] = 'Database: '.mysql_error();
    if (mysql_num_rows($res) > 0) return $error[] = 'Username already in use.';

    # Check account limit for email
    if($config['MaxEmails'] > 0)
    {
        $email = "SELECT `id` FROM `account` WHERE `email` = '".mysql_real_escape_string($_POST['email'])."'";
        $re = mysql_query($email, $db);
        if (!$re) return $error[] = 'Database: '.mysql_error();
        if (mysql_num_rows($re) >= $config['MaxEmails']) return $error[] = '<font size=2 face=Tahoma><br /><b> You have reached your maximum amount of accounts using that email address.</b></font>';
    }

    if($config['EncryptedPass'] > 0)
        $query = "INSERT INTO `accounts` (`username`, `sha_pass_hash`, `gmlevel`, `email`, `joindate`, `last_ip`, `expansion`) VALUES ('".mysql_real_escape_string($_POST['login'])."', '$encrypted_password', '0', '".mysql_real_escape_string($_POST['email'])."', NOW(), '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string($_POST['flag'])."')";
    else
        die('You must you encrypted passwords!');

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
      <div style="width:300px">
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
            <input type="submit" value="Submit" class="button"/>
          </div></form>
        
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
        </div>
		<center>
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