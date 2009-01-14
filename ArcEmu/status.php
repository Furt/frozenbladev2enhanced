<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
require_once('./lib/config.php');
include('./lib/header.php');
?>
<body>
<div class="maintile"><div class="blue"><div class="gryphon-right"><div class="gryphon-left"></div></div></div></div><div class="wowlogo"></div><div></div><div class="container"><div class="top"></div>
<div class="banner"></div>
<div class="bar"><?php include('./lib/topnavi.php') ?><br /></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<br /><center><img src="images/text/status.png"></center>
<br />

<!-- script -->
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
<!-- replace x with what u have your stats.xml set to update to -->
<center><b><u>Note:</u> This page only updates every x minutes via stats.xml</b></center>
<!-- script end -->

<?php
include('./lib/footer.php');
?>