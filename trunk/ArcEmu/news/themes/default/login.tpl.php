<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>phpns &raquo; login</title>
	<link rel="alternate" type="application/rss+xml" title="phpns rss feed" href="etc.php?do=rss"/>
	<link rel="stylesheet" href="{prepath}main.css" type="text/css" media="screen" />
	<link rel="shortcut icon" href="images/icons/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	{head_data}
	
</head>
	<body class="login">
		<noscript>Javascript is disabled on your browser, which will result in reduced features and limited accessability.</noscript>
		<div id="head_container">
			<h1><a href="index.php">phpns</a><span> <a href="about.php">{version}</a></span></h1>
			<div id="tabs"> <!-- navigation start -->
				<ul id="top_nav">
					<li><a href="http://phpns.alecwh.com/" title="phpns website"><span>phpns website</span></a></li>
				</ul>
				<ul>
					<li><a href="login.php" title="phpns login page"><span>login</span></a></li>
					<li><a href="help.php" title="phpns documentation/help"><span>phpns documentation</span></a></li>
				</ul>
				<script language="javascript" type="text/javascript">setPage()</script>
			</div> <!-- navigation end -->
		</div>
		<div id="main_container">
			<div id="main_content">
				<div style="float: right;">{page_image}</div>
				<h3>{current_page_name}</h3>				
				{content}
			</div>
		</div>
		<div id="copyright"> <!-- bottom notice/copyright -->
			Time: <?php echo date(DATE_RFC850); ?> | <a target="_blank" href="http://phpns.alecwh.com">phpns {version}</a> by <a target="_blank" href="http://alecwh.com">alec henriksen</a> under the GPL
		</div>
	</body>
	<!-- Template is copyrighted under the GPL. =) -->
	<!-- Done. :) If you need something, contact me at alecwh{at}gmail.com -->
</html>
