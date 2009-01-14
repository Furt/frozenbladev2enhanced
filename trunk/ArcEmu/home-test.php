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
<!-- vote -->

<!--  vote -->
<div class="maintile"><div class="blue"><div class="gryphon-right"><div class="gryphon-left"></div></div></div></div><div class="wowlogo"></div><div></div><div class="container">
<div class="top"></div>
<div class="banner"></div>
<div class="bar"><br /><center></center></div><div class="inner"><table align="center" width="718" border="0" cellspacing="1" cellpadding="1"><tr>
<?php
include('./lib/leftnavi.php')
?>
<td width="430" valign="top"><div class="main"></div>

<!-- Start News Post -->
<?php
/*
	This file is used to generate articles managed by the phpns system. 
	Place this code wherever you want your articles displayed on your 
	website. The page that this code is placed in should have a .php
	extension.
*/

	$phpns['limit'] = '5';
	include("news/shownews.php");
?>
<!-- End News Post -->

<br /></td>
<?php
include('./lib/rightnavi.php');
include('./lib/footer.php');
?>