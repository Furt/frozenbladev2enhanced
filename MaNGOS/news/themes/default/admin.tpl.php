<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>phpns &raquo; {current_page_name}</title>
	<link rel="stylesheet" href="{prepath}main.css" type="text/css" media="screen" />
	<link rel="shortcut icon" href="images/icons/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	{head_data}
	</head>
	
	<body class="admin">
		<noscript>
			<div id="messages">
				Javascript is disabled on your browser, which will result in reduced features and limited accessability.
			</div>
		</noscript>
		<div id="head_container">
			<h1><a href="index.php">phpns</a><span> <a href="about.php">{version}</a></span></h1>
			<div id="tabs"> <!-- navigation start -->
				<ul id="top_nav">
					<li><a href="preferences.php?do=wizard" title="integration wizard"><span>generate code!</span></a></li>
				</ul>
				<ul>
					<li><a href="index.php" title="phpns index"><span>index</span></a></li>
					<li><a href="article.php" title="post a new article"><span>new article</span></a></li>
					<li><a href="manage.php" title="manage current articles"><span>article management</span></a></li>
					<li><a href="user.php" title="manage user profiles"><span>user management</span></a></li>
					<li><a href="preferences.php" title="modify phpns preferences"><span>preferences</span></a></li>
					<li><a href="about.php" title="about the phpns project"><span>about</span></a></li>
					<li class="slast"><a href="javascript:if(confirm('Are you sure you want to logout ({username})?')) top.location='login.php?do=logout'" title="logout {username}"><span><strong>logout</strong> <em>({username})</em></span></a></li>
					<!-- <li class="last"><a href="" title="logout as {username}">logout ({username})</a></li> -->

				</ul>
					<script language="javascript" type="text/javascript">setPage()</script>
				</div> <!-- navigation end -->
		</div>
		<div id="main_container">
			<div id="main_content">
				{all_messages}

				{page_image}
				
				<h2>{current_page_name}</h2>
				<p class="caps">{page_desc}</p>
				{content}
				<div class="clear"></div>
			</div>
		</div>
		<div id="copyright"> <!-- bottom notice/copyright -->
			Time: <?php echo date(DATE_RFC850); ?> | <a target="_blank" href="http://phpns.alecwh.com">phpns {version}</a> by <a target="_blank" href="http://alecwh.com">alec henriksen</a> under the GPL | <a href="index.php?tourId=phpns">Tour</a> &raquo; <a href="javascript:new_window('help.php');">Help</a>
		</div>
	</body>
	<!-- Template is copyrighted under the GPL. =) -->
	<!-- Done. :) If you need something, contact me at alecwh{at}gmail.com -->
</html>
