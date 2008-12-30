<?
if(isset($_POST['submit'])){

include("mailconfig.php");

mysql_connect($db_host, $db_user, $db_password) or die(mysql_error());
mysql_select_db($db_name) or die(mysql_error());

$name = $_POST['name'];

$query = mysql_query("SELECT guid FROM characters WHERE name = '" . $name . "'");
if($query === false){
die(mysql_error());
}else{
while ($arr = mysql_fetch_assoc($query)){
echo "I have found the ID of " . $name . "!<br> ID = ";
  echo $arr['guid'];
  exit;
} 
}
}
?>

<form method="post" action="lookup.php">
What will be the name, where all the emails come from?<br>
<input type="text" name="name">
<br><br>
<input type="submit" name="submit" value="Give me the sender ID!">
</form>

