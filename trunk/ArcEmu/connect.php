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
require_once('./includes/config.php')
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


<div class="bar"></div><div class="inner2"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('./includes/leftnavi.php')
?>
<td width="574" valign="top">

<div class="story-top8">

<div align="center" style="text-align:bottom"><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

	
			<!-- Header Text Image -->
		
			<img src="images/text/connect.png">	

			
</div></div><div class="story2"><center><div style="width:400px; text-align:left"><br>

			
			<!-- Introduction Line -->
			
This guide will show you how to configure your World of Warcraft client so you can play on our server.

<br><br><center><img src="images/temp/br.png"></center>


			<!-- Install World of Warcraft -->
	
<img src="images/temp/icon.gif"><strong> Install World of Warcraft</strong><br><br>

First you must make sure you have World of Warcaft and both expansions installed.<br><br>
You can get this either by buying it in gaming shops or you will find that there are downloads around which can be found.<br><br>
Here is the direct installer for classic and both expansions:<br><br>


			<!-- Official Installers Download Links -->
		
<center><a href="download/InstalWoW.exe" onMouseOver="image1.src='images/text/wow-installer2.png'" onMouseOut="image1.src='images/text/wow-installer.png'"><img src="images/text/wow-installer.png"; name="image1" border="0"></a><br /><br /><img src="images/temp/br.png"></center>

		
			<!-- Download and Install Patches -->		

<img src="images/temp/icon.gif"><strong> Download and Install Patches</strong><br><br>

To make sure your client is running the same supported version as our server you need to install some patches.<br /><br />


		<!-- Enter Your Supported Version Here -->

<center><font color="#FFFFFF">			Supported Version: <?php echo $config['PatchVersion']; ?>				</font></center><br>


		<!-- Patch Download Links -->

You can use your World of Warcraft client to download your patches automatically, or your can download them manually from these sites:<br/><br/>

<center><a href="http://www.wowwiki.com/Patch_mirrors"><u>http://www.wowwiki.com/Patch_mirrors</u></a><br>
<a hre="http://a.wirebrain.de/wow/"><u>http://a.wirebrain.de/wow/</u></a><br><br>

<img src="images/temp/br.png"></center>


		<!-- Change Your Realmlist -->

<img src="images/temp/icon.gif"><strong> Change Your Realmlist</strong><br><br>

Now go to the folder which you installed World of Warcraft, open the file called: 'realmlist.wtf' with Notepad and change it to say:<br/><br/>


		<!-- Put Your Server Realmlist Here -->

<center><font color="#FFFFFF">			set realmlist  <?php echo $config['RealmIP']; ?>			</font><br/><br/></center>


Then save the file and close.<br><br>

Do you play more than one WoW server and want no more realmlists? then check out this awesome program:<br/><br/>


		<!-- Advertising Virtue: Realmlister -->
		
<center><a href="http://virtue.nadasoft.net/"><img src="images/temp/virtue.png" border="0"><br>
<font color="#FFFFFF"><u>http://virtue.nadasoft.net/</u></font></a><br/><br/>
<img src="images/temp/br.png"></center>


		<!-- Make Your Server Account -->
		
<img src="images/temp/icon.gif"><strong> Make Your Server Account</strong><br><br>
			
You can now make your account on our Registration page.<br><br>
Once that is done, you are all ready to log in with your account information and get playing!<br><br>
Please wait up to at most 10 minutes before your new account will be loaded into our the logon server.



</div></center></div><div class="story-bot2"></div><br /></td></tr></table></div><div class="bottom"></div></div><div align="center" class="bot"><font class="style20"><br/></font><font class="style30">Copyright 2008 © <a href="http://wowps.org/forum">WoWps.org</a> and <?php  echo $config['Sitename']; ?>. All rights reserved.<br />Designed by <a href="http://wowps.org/forum/member-kitten.html">Kitten</a> and Coded by <a href="http://wowps.org/forum/member-furt.html">Furt</a> @ <a href="http://wowps.org/forum">WoWps.org</a></font></div></body></html>