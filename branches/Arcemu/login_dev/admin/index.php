<?php

// Script      :     Character Emailer
// Used by     :     GM, Administrator
// Author      :     Kaasie
// Made for    :     ArcEmu.org
// Contact     :     erikdekker@live.nl
// Copyright   :     2008, Zenio Webdevelopment B.V
// License     :     Creative Commons Attribution-Noncommercial 3.0 Netherlands License.

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
Scripted by Kaasie

<?
}
?>




