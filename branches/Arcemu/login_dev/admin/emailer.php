<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Emailer script by: Kaasie
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
require_once('../lib/config.php')
?>
<title><?php  echo $config['Title']; ?></title>

<link rel="shortcut icon" href="../images/favicon.ico">
<link href="style/style.css" rel="stylesheet" type="text/css">
<!--[if IE]><link href="css/ie-fix.css" rel="stylesheet" type="text/css"><![endif]-->
<script type="text/javascript" src="./js/img-trans.js"></script>
<script type="text/javascript" src="./js/pre-load.js"></script>
</head><body>

<div class="maintile"><div class="blue"><div class="gryphon-right"><div class="gryphon-left"></div></div></div></div><div class="wowlogo"></div><div></div><div class="container"><div class="top"></div>


<div class="banner"></div>


<div class="bar"><br /></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('../lib/leftnavi.php')
?>
<td width="430" valign="top">

<div class="story-top"><div align="center">
<br/><br/><br/><br/><br/><br/><img src="../images/text/account.png">

</div></div><div class="story"><center><div style="width:300px; text-align:left">

      <div align="center">
  <!-- script start -->
<?php
if(isset($_POST['submit'])){

include("mailconfig.php");

if($sender_id == "0"){
echo "Please read installation.txt first!";
exit;
}


$succesfull = False;



mysql_connect($db_host, $db_user, $db_password) or die(mysql_error());
mysql_select_db($db_name) or die(mysql_error());



$to_name = mysql_real_escape_string($_POST['to']);
$subject = mysql_real_escape_string($_POST['subject']);
$body = mysql_real_escape_string($_POST['body']);
$item = mysql_real_escape_string($_POST['item']);
$gold = mysql_real_escape_string($_POST['gold']);

if(empty($subject)){
echo 'You didnt entered a subject, Please <a href="javascript:history.go(-1);">go back</a> and try again.<br>';
}

if(empty($body)){
echo 'You didnt entered a message, Please <a href="javascript:history.go(-1);">go back</a> and try again.<br>';
}



if(empty($item)){
$item = "0";
}



if(isset($gold)){
$gold = $gold * 10000;
}



$query = mysql_query("SELECT guid FROM characters WHERE name = '" . $to_name . "'");
$result = mysql_fetch_assoc($query);

if($query === false){
echo "Query:" . $query . "<br>";
echo "Error:" . mysql_error() . "<br>";
}

$rows = mysql_num_rows($query);

if($rows == "0"){

echo 'This character does not exist. Please <a href="javascript:history.go(-1);">go back</a> and try again. <br><br>';

}else{

$to_guid = $result['guid'];


$send_mail = mysql_query("INSERT INTO mailbox_insert_queue(sender_guid, receiver_guid, subject, body, stationary, money, item_id, item_stack) VALUES (" . $sender_id . ", " . $to_guid . ", '" . $subject . "', '" . $body . "', 0, " . $gold . ", " . $item . ", 1)");


if($send_mail === true){
echo "The message has been sent, the player will receive it in about 2 minutes.";
$succesfull = True;
}else{
echo 'Something went wrong while sending the mail. Please <a href="javascript:history.go(-1);">go back</a> and try again. <br><br>';
}
}
}
if($succesfull == False){
?>


<form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
To character:<br>
<input type="text" name="to"><br><br>
Subject:<br>
<input type="text" name="subject"><br><br>
Message:<br>
<input type="text" name="body"><br><br>
Item ID, blank if no item<br>
<input type="text" name="item"><br><br>
Amount in gold, blank if none<br>
<input type="text" name="gold"><br><br>
<input type="submit" name="submit" value="Send">
</form>
<br /><br />

<?
}
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
include('../lib/rightnavi.php')
?>
</tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 © <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>