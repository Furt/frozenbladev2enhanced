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

$globalvars['page_name'] = 'about';

include("inc/header.php");

	//check some variables on the phpns server, timeout 5 secs...
	$version_check = version_check($globalvars['version']);
	$phpns_rss = phpns_rss();
	
if($_GET['version_check']) 
{
	echo '<link rel="stylesheet" href="./themes/default/main.css" type="text/css" media="screen" />';
	echo $version_check;
	die;
}

$content = '
<h3>Server information</h3>
<div id="columnright">
	<h4>Version check</h4>
	<iframe src="./about.php?version_check=1" scrolling="no" frameborder="0"></iframe>
</div>
	<h4>Latest news</h4>
	'.$phpns_rss.'

<h3>Help and Support</h3>
<p>If you are need standard help with any part of your phpns installation, please consult the <a href="help.php">internal documentation</a> first. If that doesn\'t answer your question, you can do the following (in order of fastest reply):
	<ol>
		<li>Search the <a href="http://phpns.alecwh.com/manual.php">project documentation</a>.</li>
		<li>Ask a question at <a href="http://launchpad.net/phpns">our Launchpad project page</a>.
			<blockquote><strong>This is the best way to get support for anything about Phpns. Go to the Answers section to post a question. You must register a Launchpad account.</strong></blockquote>
		</li>
		<li>Try <a href="http://phpns.alecwh.com/contact.php">contacting us</a> directly.</li>
	</ol>
	<p>Note: The IRC channel, forums, and mailing lists are now closed. Launchpad is now the only option (besides direct email, which we do not like) for support. The section is monitored daily for any new posts. You <strong>will</strong> get an answer!</p>

<h3>Development team</h3>
<p>First, we would like to thank the community! Not only for using our web application, but for your continued support and donations. Next, our sponsors have contributed so much to the development of phpns, we can\'t thank them enough!</p>
		<blockquote>
		<strong>Primary development</strong>
		<ul>
			<li><a href="http://alecwh.com">Alec Henriksen</a>, project lead and main developer.</li>
			
		</ul>
		
		<strong>Contributors and Help</strong>
		<ul>
			<li><a href="http://kyleosborn.org">Kyle Osborn <!--- That\'s me! --></a>, developer, usually offers advice and small code contributions.</li>
			<li><a href="http://aretegraphicdesign.com">Joe Lombardo</a>, HOWTO writeup (/docs/HOWTO).</li>
		</ul>
		
		<strong>Sponsors</strong>
		<ul>
			<li>No sponsors yet. <a href="http://phpns.alecwh.com/contact.php">Find out how to become one</a> and get listed here! Sponsors can donate funds, provide hosting, or provide other significant help.</li>
		</ul>
		</blockquote>

<h3>License (gpl)</h3>
	
	<p><img src="images/gplv2.png" alt="gpl v2 image" /></p>
<p>   <strong>Copyright (C) 2007-08  Alec Henriksen</strong></p>
<p>
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.
</p>
<p>
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
</p>
<p>
Please see the GPL at <a href="http://www.gnu.org/copyleft/gpl.html">gnu.org</a> for a complete understanding of what this license means and how to abide by it.
</p>

<h3>Support phpns</h3>
	<ul>
		<li>Rate phpns at <a href="http://www.hotscripts.com/Detailed/66546.html">hotscripts.com</a>.
			<blockquote>
				<form action="http://www.hotscripts.com/rate/66546.html" method="post">                  
					<select name="rating" size="1">
						<optgroup label="Select a rating...">
						<option selected="selected" value="5">Excellent!</option>
						<option value="4">Very Good</option>
						<option value="3">Good</option>
						<option value="2">Fair</option>
						<option value="1">Poor</option>
						</optgroup>
					</select><br />
					<input name="submit" value="Rate It!" type="submit" id="submit">
				</form>
			</blockquote>
		</li>
		<li>Rate and comment on phpns at <a href="http://php.resourceindex.com/detail/07608.html">the php resource index</a>.
			<blockquote>
				<form method="post" action="http://php.resourceindex.com/rate/index.cgi">
					<input name="link_code" value="07608" type="hidden">
					<input name="category_name" value="Complete Scripts/News Posting/" type="hidden">
					<input name="link_name" value="phpns (PHP News System)" type="hidden">
					<input name="referer" value="" type="hidden">
					<select name="rating">
						<optgroup label="Select a rating...">
							<option>10</option>
							<option>9</option>
							<option>8</option>
							<option>7</option>
							<option>6</option>
							<option>5</option>
							<option>4</option>
							<option>3</option>
							<option>2</option>
							<option>1</option>
						</optgroup>
					</select><br />
					<input name="submit" value="Rate It!" type="submit" id="submit">
				</form>
			</blockquote>
		</li>
		<li><a href="http://phpns.alecwh.com/donations.php">Donate</a> to the development team.</li>
		<li><a href="http://launchpad.net/phpns">Report a bug</a> in phpns.</li>
	</ul>

<h3>Miscellaneous</h3>
<p>
This program was created using open-source and free software, on the linux operating system. This web application takes as much advantage of the XHTML/CSS specifications as possible (provided by <a href="http://w3.org">w3C</a>) and is designed to generate compliant and semantic content. The following programs were used in the creation of this project:
</p>
	<div id="columnright">
		<ul>
		<li><a href="http://tango.freedesktop.org/Tango_Icon_Gallery">Tango Desktop Icons</a></li>
		<li><a href="http://tinymce.moxiecode.com/">TinyMCE WYSIWYG Editor</a></li>
		<li><a href="http://www.codepress.org/index.php">CodePress Editor</a></li>
		</ul>
	</div>
	<ul>
		<li><a href="http://bazaar-ng.org/">bazaar</a></li>
		<li><a href="http://www.gnome.org/projects/gedit/">gedit</a></li>
		<li><a href="http://inkscape.org/">Inkscape Vector Illistrator</a></li>
		<li><a href="http://www.phpmyadmin.net/home_page/index.php">phpMyAdmin</a></li>
	</ul>
';

include("inc/themecontrol.php");  //include theme script
?>
