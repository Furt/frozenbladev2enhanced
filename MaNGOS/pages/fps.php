<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->
<td width="430" valign="top">
<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="images/text/fps.png">
</div></div><div class="story"><center><div style="width:300px; text-align:left">
      <div align="center">
  <!-- script start -->
<?php


error_reporting(E_ALL ^ E_NOTICE);

if(!session_id())
    session_start();

$msg = Array();
$error = Array();
include('./lib/RandomPasswordGen.php');
function RetrievePassword(){
    global $config, $msg, $error;
    if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ) {
        // Insert your code for processing the form here, e.g emailing the submission, entering it into a database. <br>
        $msg[] = 'Security code accepted!';
        unset($_SESSION['security_code']);
    } else {
        // Insert your code for showing an error message here<br>
        $error[] = 'Error, You have provided an invalid security code!';
    }
    
    # Valid Email: example@example.com
    $pattern_email='^([a-zA-Z0-9._-]+)@((\[[0-9a-zA-Z]{1,3}\.[0-9a-zA-Z]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$';
    
    if (empty($_POST['login'])) $error[] = 'Error, You forgot to enter your account name!';
    if (empty($_POST['email']) || !ereg($pattern_email, $_POST['email'])) $error[] = 'Please fill in a valid email adress!';
    if (!empty($error)) return false;
    
    # Connect to database
    $db = @mysql_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_pass']);
    if (!$db) return $error[] = 'Database: '.mysql_error();
    if (!@mysql_select_db($config['mysql_account'], $db)) return $error[] = 'Database: '.mysql_error();

    if($config['EncryptedPass'])
    {
        $query = "SELECT `sha_pass_hash` FROM `account` WHERE `username` = '".mysql_real_escape_string($_POST['login'])."' AND `email` = '".mysql_real_escape_string($_POST['email'])."' LIMIT 1";
    }else{
        die('You must use encrypted passwords!');
    }
    $res = mysql_query($query, $db);
    if (!$res) return $error[] = 'Database: '.mysql_error();
    if (mysql_num_rows($res) !== 1) return $error[] = 'Information you entered is invalid.';
    
    # Generate a password that is 10 characters long and that is 0-9a-z
    $ranpassword = generatePassword(10, 1);
    
    if($config['EncryptedPass'])
    {
        $update = "UPDATE `account` SET `sha_pass_hash` = \"".SHA1(CONCAT(UPPER('".$_POST['login']."'), ':', ('".$ranpassword."')))."\" WHERE `login` = '".mysql_real_escape_string($_POST['login'])."' LIMIT 1";
        $res = mysql_query($update, $db);
        if(!$res) return $error[] = 'Database: '.mysql_error();
        $email = 'The password for account <span style="color:#00FF00"><strong>'.htmlentities($_POST['login']).'</strong></span> has been changed to <span style="color:#00FF00"><strong>'.$ranpassword.'</strong></span>';
    }else{
		die('You must use encrypted passwords!');
	}
    
    if($config['EnableEmail'])
    {
        if(sendmail($_POST['email'], $config['SiteEmail'], $config['Sitename'], $email))
            return $msg[] = "<strong>Your password has been emailed to you.</strong>";
    }
    
    $msg[] = $email;

    mysql_close($db);
    return true;
}

function sendmail($to, $return, $title, $msg)
{
    # Attempt to send mail
    $mail_sent = mail($to, "Subject: $title", wordwrap($msg, 70, "<br />\n"), "From: $return");
    if(!$mail_sent)
    {
        # Open file for writing data to it.
        $file = fopen("./lib/config.php", "w");
        # Grab the current settings
        $settings = file("./lib/config.php");
        # Modify the configuration values to false
        $settings = str_replace('$config[\'EnableEmail\'] = true;','//Automatically Disabled
$config[\'EnableEmail\'] = false;',$settings);
        # Save data back into the file
        for($x=0; $x<sizeof($settings); $x++)
            fwrite($file, $settings[$x]);
        # Close the file
        fclose($file);        
    }
    return $mail_sent ? true : false;
}


if(!empty($_POST)){
    RetrievePassword();
}

?>
	<center>
</div>
      <div style="width:300px">
        <form action="home.php?act=Get_Pass" method="POST">
		          <div align="center"><br><br>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td></td><td></td>
            </tr>
            <tr class="head"><th colspan="2"></th></tr>
            <tr>
                <th>Username: </th><td align="center"><input class="button" type="text" name="login" size="20" maxlength="16"/></td>
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
          
          <center>
        </div>
      </div>
      <div align="center">
        </center>
      </div>
</div>
<div class="story-bot" align="center"><br/>
</div><br /></td>