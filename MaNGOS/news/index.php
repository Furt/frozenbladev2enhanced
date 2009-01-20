<?php

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/
include("inc/init.php");

$globalvars['page_name'] = 'index';
$globalvars['page_image'] = 'index';

include("inc/header.php");
	
	$do = $_GET['do'];

	if ($do == NULL) { //if no action, we display index as usual
		$num['article'] = content_num("articles",1,0);
		$num['users'] = content_num("users",1,0);
		$num['categories'] = content_num("categories",1,0);
		$num['pendarticle'] = content_num("articles",1,1);
		$num['logins'] = content_num("userlogin",1,0);
		$num['unapproved'] = content_num("articles",1,2);
	
		$load_recent = load_items('articles',0,4,'','','');  //load recent items (SQL)
		
		//init recent_row_gen
		$recent_row_gen = FALSE;
		
		while($recent_row = mysql_fetch_array($load_recent)) {
			//if it's the first result, <strong>, if not, no tag
			if (!$recent_row_1) {
				$recent_row_gen = $recent_row_gen.
				'<li><strong><a href="article.php?id='.$recent_row['id'].'&amp;do=edit">'.$recent_row['article_title'].'</a></strong></li>';
				$recent_row_1 = TRUE;
			} else {
				$recent_row_gen = $recent_row_gen.
				'<li><a href="article.php?id='.$recent_row['id'].'&amp;do=edit">'.$recent_row['article_title'].'</a></li>';
			}
		}
		
		$content = "			
			<h3>Information</h3>
			<div id=\"columnright\">
				<h4>Recent articles</h4>
				<ul>
					".$recent_row_gen."
				</ul>
			</div>
			<h4>Statistics</h4>
			<ul id=\"stats\">
				<li>There are currently <strong><a href=\"manage.php\">" . $num['article'] . " articles posted</a></strong> in <a href=\"preferences.php?do=categories\">" . $num['categories'] . " categories</a>.</li>
				<li>There are currently <a href=\"user.php\">" . $num['users'] . " active users</a>.</li>
				<li>There are currently <a href=\"manage.php?v=unactive\">" . $num['pendarticle'] . " drafts</a> and <a href=\"manage.php?v=unapproved\">" . $num['unapproved'] . " unapproved articles</a>.</li>
				<li>There are currently <a href=\"user.php?do=loginrec\">" . $num['logins'] . " login records</a>.</li>
			</ul>
			<div class=\"clear\"></div>
		";
	} elseif ($_GET['do'] == "permissiondenied") { //display permission denied error
		$globalvars['page_name'] = 'permission denied';
		$globalvars['page_image'] = 'lock';
		
		$content = '<h3>Why am I getting this?</h3>
		<p>When your rank was created, the author denied any members associated with this rank to view this feature/page. If you think you should have access, contact your admin. If this has just barely been changed for you, you will need to logout and log back in.</p> ';
	} elseif ($_GET['do'] == "lulz") {
		$globalvars['page_name'] = 'lulz all around!';
		$globalvars['page_image'] = 'none';
		echo <<<EDO
		<p>I love the whole world! (<a href="http://www.youtube.com/watch?v=at_f98qOGY0">http://www.youtube.com/watch?v=at_f98qOGY0</a>)</p> <p>(without the superstition...)</p> <pre>It never gets old huh?
Nope
It kinda make you wanna..break into song?
Yep
I love the mountains
I love the clear blue skies
I love big bridges
I love when great whites fly
<strong>I love the whole world</strong>
And all its sights and sounds
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
I love the ocean
I love real dirty things
I love to go fast
I love egyptian kings
I love the whole world
and all its craziness
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
I love tornadoes
I love Arachnids
I love hot magma
I love the giant squids
I love the whole world
Its such a brilliant place
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada
Boom De Yada </pre>- alec (alecwh)<hr />
<a href="http://kyleosborn.com/"><img src="http://imgs.xkcd.com/comics/compiling.png" /></a> - kyle (kyleO)
EDO;
		die(); //die!
	} elseif ($_GET['do'] == "welcome") {
		$globalvars['page_name'] = 'welcome to phpns';
		
		$content = '
		<h3>Things to remember</h3>
		<ul>
			<li>Check <a href="about.php">the about page</a> on a regular basis, so you can keep up with official updates.</li>
			<li>Phpns is completely free to use and modify without any restrictions. If you need to change anything, go ahead!</li>
			<li>Please rate (and review) us over at <a href="http://www.hotscripts.com/Detailed/66546.html">hotscripts.com</a>. This really helps.</li>
		</ul>
		<h3>Things to do</h3>
		<ul>
			<li>Read the <a href="help.php">phpns manual</a>.</li>
			<li>Post a <a href="article.php">new article</a>.</li>
			<li>Register <a href="user.php">new users</a> that can access this panel, and <a href="user.php?do=ranks">create new ranks</a> for them.</li>
			<li>Modify the <a href="http://localhost/2.2.2/preferences.php?do=display">default display options</a>.</li>
			<li><a href="http://localhost/2.2.2/preferences.php?do=templates">Change how news is displayed</a> to your users.</li>
		</ul>
		<p>Remember, if you have any questions, you can head over to <a href="http://phpns.alecwh.com/">the website</a>. Also, please remember to report any bugs to our <a href="https://bugs.launchpad.net/phpns">bug tracking system</a> at Launchpad.</p>';
	}
	
include("inc/themecontrol.php");  //include theme script
?>
