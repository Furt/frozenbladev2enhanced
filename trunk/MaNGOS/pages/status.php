<td width="430" valign="top">
<div align="center">
<br/><br/><br/>
</div>
      <div align="center">
	  <center><img src="images/text/status.png"></center><br><br>
  <!-- script start -->
<?php
$character = array(
'db_host' => 'localhost',		//ip of db realm
'db_username' => 'root',		//character user
'db_password' => '****',	//character password
'db_name' => 'characters',			//character db name
);
include('function.inc.php');

?>
<table border="1" align="center"><tr><td align="center">Name</td><td align="center">Faction</td><td align="center">Race</td>
<td align="center">Class</td><td align="center">Level</td><td align="center">Map</td><td align="center">Zone</td></tr>
<?php	
$connect = mysql_connect($character[db_host],$character[db_username],$character[db_password]);
$selectdb = mysql_select_db($character[db_name],$connect);
if (!$connect || !$selectdb){
echo "Could NOT connect, Please check the config.";
die;
}
$query = "SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 54), ' ', -1) AS UNSIGNED) AS `level`, `name`, `race`, `class` FROM `characters` WHERE `online` =1"; 
$result = mysql_query($query) or die(mysql_error());

        $data = explode(' ',$row['data']);
        $gender = dechex($data[22]);
        $gender = str_pad($gender,16, 0, STR_PAD_LEFT);
        $gender = $gender{3};
		
while($row = mysql_fetch_array($result)){
	echo '<tr><td align="center">'. $row['name'] .'</td>';
	echo '<td align="center">'. convertFaction($row['race']) .'</td>';
	echo '<td align="center"><img src="./images/char/' . $row['race'] . '-' . $gender . '.gif" alt=""></td>';
	echo '<td align="center"><img src="./images/char/' . $row['class'] . '.gif" alt=""></td>';
	echo '<td align="center">'. $row['level'] .'</td>';
	echo '<td align="center">'. convertMap($row['map']) .'</td>';
	echo '<td align="center">'. convertZone($row['zone']) .'</td></tr>';
}
?>
</table>
<!-- Just a place to add personal notes to the page -->
<center><?php echo($config['Note']); ?></center>
          <!-- script stop -->
          <center><br/>
        </div>
      </div>
      <div align="center">
        </center>
      </div>
</div><br /></td>