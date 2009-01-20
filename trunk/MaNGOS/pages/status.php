<td width="430" valign="top">
<div align="center">
<br/><br/><br/>
</div>
      <div align="center">
	  <center><img src="images/text/status.png"></center><br><br>
  <!-- script start -->
<?php
include "./lib/arrayXML.class.php";
include "./lib/StatsXML.class.php";
$xml = new StatsXML("./lib/stats.xml");
echo '<br />';
echo '<table align="center" border="1" width="340"><tr>';
echo '<td>Average Latency: ' . $xml->getLatency() . ' ms</td>';
echo '<td>Accepted Connections: ' . $xml->getAccCon () . '</td>';
echo '</tr><tr>';
echo '<td>Online Players: ' . $xml->getOnlinePlayers() . '</td>';
echo '<td>Connection Peak: ' . $xml->getConPeak() . '</td>';
echo '</tr><tr>';
echo '<td>Gamemasters: ' . $xml->getGMs() . '</td>';
echo '<td>Alliance: ' . $xml->getAlliance() . '</td>';
echo '</tr><tr>';
echo '<td>Queued Players: ' . $xml->getQplayers () . '</td>';
echo '<td>Horde: ' . $xml->getHorde() . '</td';
echo '</tr></table>';
echo '<br /><br />';
echo "<center><u>GM's Online</u></center>";
echo '<table align="center"><thead><TD ALIGN="center"><u>Name</u></td><TD ALIGN="center"><u>Faction</u></td><TD ALIGN="center"><u>Race</u></td><TD ALIGN="center"><u>Class</u></td><TD ALIGN="center"><u>Level</u></td><TD ALIGN="center"><u>Map</u></td><TD ALIGN="center"><u>Zone</u></td></thead>';
foreach ($xml->getGMsArray() as $player) {
echo '<tr><TD ALIGN="center">' . $player['name'] . '</td>';
echo '<TD ALIGN="center">' . convertFaction($player['race']) . '</td>';
echo '<TD ALIGN="center"><img src="images/char/race/' . $player['race'] . '-' . $player['gender'] . '.gif" alt=""></td>';
echo '<TD ALIGN="center"><img src="images/char/class/' . $player['class'] . '.gif" alt=""></td>';
echo '<TD ALIGN="center">' . $player['level'] . '</td>';
echo '<TD ALIGN="center">' . convertMap($player['map']) . '</td>';
echo '<TD ALIGN="center">' . convertZone($player['areaid']) . '</td></tr>';
}
echo '</table>';
echo '<br />';
echo '<center><u>Players Online</u></center>';
echo '<table align="center"><thead><TD ALIGN="center"><u>Name</u></td><TD ALIGN="center"><u>Faction</u></td><TD ALIGN="center"><u>Race</u></td><TD ALIGN="center"><u>Class</u></td><TD ALIGN="center"><u>Level</u></td><TD ALIGN="center"><u>Map</u></td><TD ALIGN="center"><u>Zone</u></td></thead>';
foreach ($xml->getPlayersArray() as $player) {
echo '<tr><TD ALIGN="center">' . $player['name'] . '</td>';
echo '<TD ALIGN="center">' . convertFaction($player['race']) . '</td>';
echo '<TD ALIGN="center"><img src="images/char/race/' . $player['race'] . '-' . $player['gender'] . '.gif" alt=""></td>';
echo '<TD ALIGN="center"><img src="images/char/class/' . $player['class'] . '.gif" alt=""></td>';
echo '<TD ALIGN="center">' . $player['level'] . '</td>';
echo '<TD ALIGN="center">' . convertMap($player['map']) . '</td>';
echo '<TD ALIGN="center">' . convertZone($player['areaid']) . '</td></tr>';
}
echo '</table>';
echo '<br />';
echo '<br /><center>';
echo 'Uptime: ' . $xml->getUptime();
echo '</center><br />';
?>
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