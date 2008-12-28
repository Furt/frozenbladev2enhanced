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


<div class="bar"><?php include('./lib/topnavi.php') ?><br /></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<br/><br/><br/><center><img src="images/text/status.png"></center>

<!-- script -->
<br /><br />
<br /><center>
<?php
include "./lib/StatsXML.class.php";
$xml = new StatsXML("./lib/stats.xml");
echo "Online Players: " . $xml->getOnlinePlayers();
echo "&nbsp;&nbsp;Alliance: " . $xml->getAlliance();
echo "<br />";
echo "Gamemasters: " . $xml->getGMs();
echo "&nbsp;&nbsp;&nbsp;&nbsp;Horde: " . $xml->getHorde();
echo "<br />";
echo "Connection Peak: " . $xml->getConPeak();
echo "<br />";
echo "<br />";
echo "Players Online: ";
echo "<br />" . $xml->getPlayersArray();
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
echo "Uptime: " . $xml->getUptime();
?>
</center>
<!-- script end -->

</tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 � <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>