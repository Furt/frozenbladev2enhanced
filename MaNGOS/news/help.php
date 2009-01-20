<?php

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/


//written by Alec Henriksen, took me quite awhile. Enjoy, masses! >_>

//defining some phpns example text (we need it to be sent through htmlspecialchars)

$html_code['example_html'] = htmlspecialchars('<html>
<head>
	<title>Phpns testing</title>
</head>
<body>
	<h1>Phpns testing</h1>
	<p>This is my phpns testing page. This does not have news inclusion yet!</p>
	
	<div class="news">
		
	</div>
</body>
</html>');

$html_code['example_phpns'] = htmlspecialchars('<html>
<head>
	<title>Phpns testing</title>
</head>
<body>
	<h1>Phpns testing</h1>
	<p>This is my phpns testing page. This <strong>does</strong> have news inclusion!</p>
	
	<div class="news">
		<?php include("path/to/shownews.php"); ?>
	</div>
</body>
</html>');

$php_code['pre_include_variables'] = highlight_string('<?php
	$phpns[\'limit\'] = \'15\';
	$phpns[\'category\'] = \'1,2,5\';
	$phpns[\'mode\'] = \'atom\';
	
	//include the phpns shownews.php
	include("path/to/shownews.php");
?>', TRUE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>phpns &raquo; manual</title>
		<link rel="shortcut icon" href="images/icons/favicon.ico" type="image/x-icon" />
		<style type="text/css" media="all">
			h2 {
				
				}
			h3, h4, h5, h6 {
				color: black;
				font-variant: italic;
				}
			ol ol {
				list-style: lower-roman;
				}
			img {
				margin-left: 15px;
				}
			#logo {
				float: right;
				}
			#topics {
				margin-left: 20px;
				}
				#topics .topic {
					margin-left: 10px;
					}
					#topics .topic .topic {
						margin-left: 30px;
						padding-left: 10px;
						padding-bottom: 10px;
						border-left: 1px dotted #333;
						}
						#topics .topic .topic .topic {
							margin-left: 37px;
							}
					#topics .topic p, #topics .topic table {
						margin-left: 10px;
						}
			textarea {
				width: 100%;
				height: 200px;
				}
			pre {
				margin-top: 27px;
				margin-left: 20px;
				padding: 6px;
				border: 1px inset #666;
				background: #F8F8F3;
				width: auto;
				white-space: pre;
				}
			table {
				width: 99%;
				}
				table tr td.table_value {
					width: 140px;
					}
			code {
				color: gray;
				}
		</style>
	</head>
	<body>
		<h1>phpns documentation and manual</h1>
		<p>Welcome to the the documentation and manual for phpns. The document aims to help you accomplish different tasks with the phpns software. The list below gives you a list of different topics explored:</p>
		<div>
			<img src="images/login.png" alt="phpns logo" id="logo" />
			<ol>
				<li><a href="#introduction">introduction</a>
					<ol>
						<li><a href="#introduction_license">license</a></li>
					</ol>
				</li>
				<li><a href="#install">installing phpns</a>
					<ol>
						<li><a href="#install_guided">guided installation</a></li>
					</ol>
				</li>
				<li><a href="#how_it_works">how it works</a>
					<ol>
						<li><a href="#how_it_works_admin">administration</a></li>
						<li><a href="#how_it_works_pres">presentation</a></li>
					</ol>
				</li>
				<li><a href="#pre_include_variables">pre-include variables</a>
					<ol>
						<li><a href="#pre_include_variables_how">how to use pre-include variables</a></li>
					</ol>
				</li>
				<li><a href="#example">example of use</a>
					<ol>
						<li><a href="#example_html">just the HTML</a></li>
						<li><a href="#example_phpns">adding the phpns code</a></li>
					</ol>
				</li>
				<li><a href="#admin_panel">the admin panel</a></li>
				<li><a href="#new_article">new article</a></li>
				<li><a href="#article_management">article management</a>
					<ol>
						<li><a href="#article_management_search">search</a></li>
						<li><a href="#article_management_sorting">sorting options</a></li>
						<li><a href="#article_management_other">other uses</a></li>
					</ol>
				</li>
				<li><a href="#user_management">user management</a>
					<ol>
						<li><a href="#user_management_new_user">new user</a></li>
					</ol>
				</li>
				<li><a href="#rank_management">rank management</a>
					<ol>
						<li><a href="#rank_management_new_rank">new rank</a></li>
					</ol>
				</li>
				<li><a href="#preferences">preferences</a>
					<ol>
						<li><a href="#preferences_display_options">general display options</a></li>
						<li><a href="#preferences_sef_urls">search engine friendly URLs</a></li>
						<li><a href="#preferences_categories">category management</a></li>
						<li><a href="#preferences_comment_options">comment options</a></li>
						<li><a href="#preferences_template_management">template management</a></li>
						<li><a href="#preferences_ban_options">ban options</a></li>
						<li><a href="#preferences_rss_options">feed options</a></li>
						<li><a href="#preferences_integration_wizard">integration wizard</a></li>
						<li><a href="#preferences_freeze">freeze/cache management</a></li>
						<li><a href="#preferences_system_log">system log</a></li>
						<li><a href="#preferences_theme_management">theme management</a></li>
						<li><a href="#preferences_database_backup">database backup/restore</a></li>
						<li><a href="#preferences_wyiwyg_editor">WYSIWYG editor</a></li>
						<li><a href="#preferences_online_offline_options">online/offline options</a></li>
						<li><a href="#preferences_timestamp_options">system timestamp options</a></li>
						<li><a href="#preferences_delete_login_records">delete login records</a></li>
						<li><a href="#preferences_global_message">global message</a></li>
					</ol>
				</li>
				<li><a href="#conclusion">conclusion</a></li>
			</ol>
		</div>
		<div id="topics">
			<div class="topic">
				<h2 id="introduction">introduction</h2>
				<p>Phpns is a software project, designed to ease the process of content management for websites. The intended purpose is to include, or "put" a dynamic news system into your website HTML code. With most content management systems, the CMS takes control of almost every aspect of your website, and customization of the "look" of the website calls for editing theme files, and skins. However, with phpns, you can design your website however you like, and phpns will squeeze into your design, wherever you like, with one line of code in your HTML. This method of "including a dynamic news system" eases your job, and doesn't require you to mess with tedious website templates [albeit phpns does have a certain kind of templates] and theme files.</p>
				<p>The project is FOSS (Free and Open Source Software), released under the GNU GPL license. The GPL gives you the freedom to modify the phpns source code without restriction.</p>
				<div class="topic">
					<h3 id="introduction_license">License</h3>
					<p><a href="docs/LICENSE">Go to the license file</a></p>
					<p><textarea><?php include("docs/LICENSE"); ?></textarea></p>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="install">installing phpns</h2>
				<p>Installing the phpns software is designed to be quick and simple. The guided installation is located in <code>/install</code>, and phpns will automatically redirect you to the installation script if you have not completed it.</p>
				
				<div class="topic">
					<h3 id="install_guided">Guided installation</h3>
					<p>When you are first directed to the phpns install script, you will be presented with the license (which you should read). Continue by clicking "Continue" near the bottom.</p>
					
					<div class="topic">
						<h4>Step 1</h4>
						<p>This installation step is where you need to enter all important data for phpns to function. Please complete the following:
						<ul>
							<li>database information: mysql host, mysql user, mysql user password, database name, and optionally a table prefix.</li>
							<li>administrator information: your desired username and password.</li>
						</ul>
						
						<p>In the "Advanced" drop-down, you have several options regarding the database.</p>
						
						<ul>
							<li>Create DB: Phpns will attempt to create the database specified in Database Name. The user will need to have the permissions to create databases.</li>
							<li>Existing DB: Phpns will NOT add, erase, or overwrite any data in the database. This is an ideal option if you are reinstalling the phpns package, without needing to touch the database.</li>
							<li>Overwrite DB: Phpns will delete all current tables in the database (having to do with phpns, this will not touch unrelated tables) and recreate them. This is ideal for corrupted phpns tables.</li>
						</ul>
						
						<p>After you are done supplying the information, and all information is valid, you can press "Continue" near the end of the page.</p>
					</div>
					
					<div class="topic">
						<h4>Step 2</h4>
						<p>After finishing step 1, you should be given a notice with a title of "<code>Configuration finished</code>". This message should inform you that phpns has successfully created the tables for phpns, and you will need to CHMOD  the file <code>/inc/config.php</code> so phpns can write important information to the database file.</p>
						<p>Once you have completed the instructions (or expect that the file permissions are already set correctly), click "Continue" near the bottom of the page.</p>
					</div>
					
					<div class="topic">
						<h4>Step 3</h4>
						<p>This is the final step in the installation process. If everything worked out, and <code>/inc/config.php</code> did indeed have proper write permissions, you should receive a successful message. You can now <strong>delete the whole <code>/install</code> directory.</strong> Return to your administration panel, and login with the data you provided in Step 1!</p>
						<p>In the event of an error (probably because <code>/inc/config.php</code> didn't have proper write permissions), phpns will give you the intended contents of the file in a text area. You can do one of two things:</p>
						
						<ol>
							<li>Try to correct the permissions for the <code>/inc/config.php</code> file and refresh the page, or</li>
							<li>Copy and paste the intended file contents into the <code>/inc/config.php</code>, save, and upload. <strong>If using this method, you do not need to refresh the installation page.</strong></li>
						</ol>
						
						<p>Assuming success, you can now <strong>Delete the entire <code>/install</code> directory</strong>, and return to your administration panel to login.
					</div>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="how_it_works">how it works</h2>
				<p>For the sake of understanding, we can safely "split up" phpns into two different categories of functionality: presentation and administration. The administration-end is the bulk of the project, where you can create and manage articles, create categories, manage templates, create users (co-admins), ban users... etc etc. The presentation-end is what the average site visitor will see, the actual news, generated by the administration-end.</p>
				<p>Below, we're going to go deeper into the administration and presentation end of phpns. You can click on the listed items to get a more detailed description of each topic.</p>
				<div class="topic">
					<h3 id="how_it_works_admin">Administration</h3>
					<p>As an administrator of the phpns installation, you can login to the panel, and do a variety of things, including:</p>
					<ul>
						<li><a href="#new_article">create new articles</a></li>
						<li><a href="#article_management">manage existing articles</a></li>
						<li><a href="#user_management">create/edit users</a></li>
						<li>and much more...</li>
					</ul>
					
					<p>All of these actions are protected from the general public, and only those who have user access can modify, or even look at them. <strong>You will spent the bulk of your phpns usage in the admin panel.</strong></p>
				</div>
				
				<div class="topic">
					<h3 id="how_it_works_pres">Presentation</h3>
					<p>While the administration-end of phpns is meant for the website admin, how will your viewers see the articles you have posted? This is where the presentation-end of phpns comes in, which will be held almost fully in the shownews.php file (/shownews.php).</p>
					<p>"shownews.php" is probably the most important file in the phpns software package, because it's the file that presents the articles you have created to the public. You will want to "include", or "put" the contents of shownews.php into any (PHP) file on your web server, to literally "inject" a news system into your current HTML template/design.</p>
					<p>Once again, the usage of shownews.php is used through an "include". Anywhere in your HTML design, as long as the file ends in .php, you can use <code>&lt;?php include("path/to/shownews.php"); ?&gt;</code> to fetch the phpns articles into your design. You can also use <a href="#pre_include_variables">pre-include variables</a> to customize how the articles are displayed. For an example of a phpns implementation, see: <a href="#example">example of use</a>.</p>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="pre_include_variables">pre-include variables</h2>
				<p>Pre-include variables are devices of customization that will "modify" how shownews.php generates news articles. There are a few pre-include variables, each for a specific use. See the table below for a complete list of variables, and examples of use further down.</p>
				<table border="1">
					<tbody>
						<tr>
							<td><strong>Variable</strong></td>
							<td><strong>Usage</strong></td>
							<td class="table_value"><strong>Values</strong></td>
						</tr>
						<tr>
							<td>$phpns['limit']</td>
							<td>Limits the number of articles displayed. This includes all articles in all pages.</td>
							<td>1-9999</td>
						</tr>
						<tr>
							<td>$phpns['order']</td>
							<td>Modifies the order (chronologically) of articles displayed.</td>
							<td>ASC | DESC</td>
						</tr>
						<tr>
							<td>$phpns['offset']</td>
							<td>Offset of article generation. "Skip" x number of articles before displaying.</td>
							<td>1-9999</td>
						</tr>
						<tr>
							<td>$phpns['category']</td>
							<td>Specifies that only articles belonging to category(ies) x should be displayed. Value should the the ID number of category. Default is all categories.</td>
							<td>1 [,2,3]</td>
						</tr>
						<tr>
							<td>$phpns['template']</td>
							<td>Specifies the template (made in the admin panel) that will be used. Default is the "selected" template. Value should be the ID number of template.</td>
							<td>1-9999</td>
						</tr>
						<tr>
							<td>$phpns['items_per_page']</td>
							<td>Specifies the number of articles for each page (when using pagination). Will only work with pagination enabled. Defaults to value specified in admin panel.</td>
							<td>1-9999</td>
						</tr>
						<tr>
							<td>$phpns['disable_pagination']</td>
							<td>Disables pagination for generated articles.</td>
							<td>TRUE | FALSE</td>
						</tr>
						<tr>
							<td>$phpns['always_show_extended_article']</td>
							<td>Will always show the extended article (along with the article list)</td>
							<td>TRUE | FALSE</td>
						</tr>
						<tr>
							<td>$phpns['disable_extended_article']</td>
							<td>Disables the full stories for all articles in the phpns instance.</td>
							<td>TRUE | FALSE</td>
						</tr>
						<tr>
							<td>$phpns['sef']</td>
							<td>Enables SEF URLs in generated articles. The value is the path on the server before article title is presented in the URL. Example: http://example.org/VALUE/Example-news-post
								<ul>
									<li>$phpns['sef'] = '/';</li>
									<li>$phpns['sef'] = 'mydirectory/';</li>
								</ul>
								<p><em>Note: This variable was named <code>$phpns['sef_override']</code> in previous versions. It has been changed to the current <code>$phpns['sef']</code>, but the old one will still work.</em></p>
							</td>
							<td>Path of SEF URL</td>
						</tr>
						<tr>
							<td>$phpns['comment_override']</td>
							<td>Automatically disables comments for all articles generated.</td>
							<td>TRUE | FALSE</td>
						</tr>
						<tr>
							<td>$phpns['static']</td>
							<td>Keeps phpns from displaying single articles. If news generation is set to static, the action (?a=whatever) will have no affect on this instance. This was designed so an admin could make a list of "recent articles" on every page, however, they will not be affected by clicking on the latest news post.</td>
							<td>TRUE | FALSE</td>
						</tr>
						<tr>
							<td>$phpns['mode']</td>
							<td>Sets the mode of article generation. Use this variable to generate RSS and ATOM feeds. If generating an rss or atom feed, <strong>there can be nothing in the file except the phpns include.</strong></td>
							<td>'rss' | 'atom'</td>
						</tr>
						<tr>
							<td>$phpns['script_link']</td>
							<td>Sets the file which all news articles will link to. Every article in the phpns instance requires a "link" to the item (where users can view the extended article, and comment). This will allow you to set where the link should be directed to. If you set as <code>http://example.com/example.php</code>, the resulting link: <code>http://example.com/example.php?a=42</code>. This variable can (and is preferred to) include a full URL beginning with <code>http://</code>; <strong>relative paths can be unreliable (and not tolerated with many RSS engines, when using RSS).</strong> It's also important to note that this variable won't affect the $phpns['sef_override'] pre-include variable.
							<td>http://example.com/example.php</td>
						<tr>
							<td>$phpns['freeze_file']</td>
							<td>A special pre-include variable that can only be used when there is a freeze_file in <code>/inc/freeze/</code>. You will need to generate this in freeze/cache management.</strong></td>
							<td>'path/to/freeze.xxx.php'</td>
						</tr>
					</tbody>
				</table>
				
				<div class="topic">
					<h3 id="pre_include_variables_how">How to use pre-include variables</h3>
					<p>To make use of the pre-include variables, they must be initialized, thus assigned values, before the actual include to shownews.php. An example of this process is below:</p>
					
					<pre class="code"><?php echo $php_code['pre_include_variables']; ?></pre>
					
					<p>To further the example, screenshots of a real-life examples of pre-include variables are shown below:</p>
					<img src="images/guide/rl_window1.png" alt="real life implimentation with pre-include variables" />
					
					<img src="images/guide/rl_window2.png" alt="real life implimentation with pre-include variables" />
				</div>
			</div>
			
			<div class="topic">
				<h2 id="example">example of use</h2>
				<p>Phpns is very easy to use; the entire program has been designed to work flawlessly with only one line of code: <code>&lt;?php include("path/to/shownews.php"); ?&gt;</code>. The process may seem complicated in writing, so we're going to give an example of a phpns implementation. </p>
				<div class="topic">
					<h3 id="example_html">Just the HTML</h3>
					<p>The following code is HTML without any phpns inclusion. Your document will look different, of course.</p>
					<pre class="code"><?php echo $html_code['example_html']; ?></pre>
					
					<p>And the HTML rendered...</p>
						<img src="images/guide/window1.png" alt="Just the HTML rendered" />
				</div>
				<div class="topic">
					<h3 id="example_phpns">Adding the phpns code</h3>
					<p>The following code is HTML INCLUDING the phpns code, which will generate the phpns articles.</p>
					<pre class="code"><?php echo $html_code['example_phpns']; ?></pre>
					
					<p>And the HTML and PHP rendered...</p>
						<img src="images/guide/window2.png" alt="HTML and PHP rendered (phpns!)" />
				</div>
				<p>Although this shows the bare minimum of phpns, there is much more you can do. You can customize the way your articles are displayed with <a href="#preferences_theme_management">template management</a>, and you can even use <a href="#pre_include_variables">pre-include variables</a> to customize which and how articles are displayed.
			</div>
			
			<div class="topic">
				<h2 id="admin_panel">the admin panel</h2>
				<p>The administration panel is designed to be usable and customizable. A screenshot (with area identification) is shown below:</p>
				
				<img src="images/guide/window_layout.png" alt="panel layout" />
				
				<p>The administration panel's HTML/CSS is contained in a theme directory (<code>/themes/</code>), with the default theme located at <code>/themes/default/</code>. You can learn more about phpns themes at <a href="#preferences_theme_management">theme management</a>.</p>
			</div>
			
			<div class="topic">
				<h2 id="new_article">new article</h2>
				<p>Creating a new article with phpns is very easy, as the process only requires 2 fields. When you rrive at the new article page (<code>Navigation->new article</code>), you will see several input fields:</p>
				<table border="1">
					<tbody>
						<tr>
							<td><strong>Input field</strong</td>
							<td><strong>Description</strong></td>
							<td><strong>Example</strong></td>
							<td><strong>Limit</strong></td>
						</tr>
						<tr>
							<td><strong>Article title*</strong></td>
							<td>Self-explanatory. Will be used in URLs when SEF URLs are turned on.</td>
							<td>Hello world!</td>
							<td>150</td>
						</tr>
						<tr>
							<td>Sub-title</td>
							<td>Self-explanatory. A subtitle (further describing the title)</td>
							<td>Hola, mundo!</td>
							<td>150</td>
						</tr>
						<tr>
							<td>Category</td>
							<td>Selected option will reflect "where" the article will be filed. Defaults to All Categories.</td>
							<td>All Categories</td>
							<td>N/A</td>
						</tr>
						<tr>
							<td><strong>Main article*</strong></td>
							<td>The foundation of the article post, (optionally) powered by the TinyMCE WYSIWYG editor. The main article will be displayed on the article list (when including shownews.php).</td>
							<td>Today I went to the market and we...</td>
							<td>20,000</td>
						</tr>
						<tr>
							<td>Full story</td>
							<td>The extended article, which users will be able to see by clicking on the article itself.</td>
							<td>After that we joined our other friends over at the....</td>
							<td>20,000</td>
						</tr>
						<tr>
							<td>Article image</td>
							<td>The image associated with the article. GIF/JPEG/TFF/PNG/SVG filetypes are accepted.</td>
							<td>N/A</td>
							<td>N/A</td>
						</tr>
						<tr>
							<td>Start date</td>
							<td>The start date is the timestamp when the article begins availability to the public. If no end date is specified, it will continue indefinitely.</td>
							<td>12/11/1991</td>
							<td>10</td>
						</tr>
						<tr>
							<td>End date</td>
							<td>The end date is the timestamp when the article ends availability to the public.</td>
							<td>12/11/2084</td>
							<td>10</td>
						</tr>
						<tr>
							<td>Disable comments</td>
							<td>Check this box to disallow users commenting on this specific article.</td>
							<td>N/A</td>
							<td>N/A</td>
						</tr>
						<tr>
							<td>Save as draft</td>
							<td>Check this box to keep the article away from the public's eye. This is a good option if you're working on an article, and it's not yet completed.</td>
							<td>N/A</td>
							<td>N/A</td>
						</tr>
					</tbody>
				</table>
				<p>* Required fields</p>
			</div>
			
			<div class="topic">
				<h2 id="article_management">article management</h3>
				<p>article management allows you to view the articles you have posted in different ways, orders, and with conditions. By default, articles are listed in a descending date order. That means, the latest article that has been created will be shown at the TOP of the news management table. Although this might suite you, sometimes you may require ordering in a different way, scroll down to sorting options.</p>
				
				<div class="topic">
					<h3 id="article_management_search">Search</h3>
					<p>Searching is really easy with phpns. At the top of article management, you will see a hyperlink named 'search' (with an expand/collapse option). Expand the search section, and you're presented with 2 fields: your query, and category. Whatever text you enter in the query box (the box with the text 'click here to start your search'), is the text we'll search for in every active article to date. The system will scan the title, subtitle, main article, and full story for that query entered. You also have the option to narrow your search by category. By default, it will search in all categories.</p>
				</div>
				
				<div class="topic">
					<h3 id="article_management_sorting">Sorting options</h3>
					<p>The article list can be sorted in various ways, so you can walk through your database articles easily. You have the following sorting options, which you can activate by clicking at the top of each column of the table.</p>
					
					<div class="topic">
						<h4>Sort by date</h4>
						<p>This will allow you to sort the articles based on the time they were posted. Descending is the default sorting order, however, you may also set this to ascending.</p>
				
						<h4>Sort by title name (alphabetically)</h4>
						<p>This will allow you to sort the articles based on the articles' title. Ascending will order it from 0-9,A-Z. Descending will reverse the order.</p>
		
						<h4>Sort by author</h4>
						<p>This will allow you to sort the articles based on the author of the article. Ascending will sort the articles based on the name of the author, in alphabetical order. Therefore, ascending would present: Alan, Billy, Caty, George, Veronica, Zack. Descending would reverse the order.</p>
		
						<h4>Sort by Active or Activity</h4>
						<p>This will allow you to sort the articles based on their status as active or inactive. This is very useful for weeding out articles that have been dormant for a long time.</p>
					</div>
				</div>
				
				<div class="topic">
					<h3 id="article_management_other">Other uses</h3>
					<h4>View articles by a certain author</h4>
					<p>You can view all the articles posted by a specific user. While viewing articles, you can simply click on the username in the column "Author", and it will load up a selection of articles by that selected author.</p>
					
					<h4>View articles by category</h4>
					<p>You can do the same thing with the author, except clicking on the category next to any article. It will bring up a list of articles posted in that category.</p>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="user_management">user management</h3>
				<p>User management is a tool which lets you control and see various users on your installation, like creating new users, editing users, deleting users, and viewing different aspects of users. You can learn about editing ranks <a href="#rank_management">here</a>.</p>
				<p>The user management page will show a list of options, and a list of users with their information. The table which lists users has the following information:
				<ul>
					<li>username</li>
					<li>full name</li>
					<li>date</li>
					<li>rank</li>
					<li>#/articles</li>
				</ul>
				
				<div class="topic">
					<h3 id="user_management_new_user">New user</h3>
					<p>Each user must have a <strong>unique username</strong>. A full list of required and optional fields are listed below:</p>
					<table border="1">
						<tbody>
							<tr>
								<td><strong>Input field</strong</td>
								<td><strong>Description</strong></td>
								<td><strong>Example</strong></td>
								<td><strong>Limit</strong></td>
							</tr>
							<tr>
								<td><strong>Rank*</strong></td>
								<td>The rank the user will be assigned to. The user will only have the permissions that the rank allows.</td>
								<td>Administrators</td>
								<td>N/A</td>
							</tr>
							<tr>
								<td><strong>Username*</strong></td>
								<td>The username to be used for login and identification. Must be unique!</td>
								<td>RDawk</td>
								<td>100</td>
							</tr>
							<tr>
								<td><strong>Full name*</strong></td>
								<td>The full (real) name of the user.</td>
								<td>John Doe</td>
								<td>150</td>
							</tr>
							<tr>
								<td><strong>Password*</strong></td>
								<td>The password the user will use to login. Must match the second "confirm password" field.</td>
								<td>mySecretPassword123</td>
								<td>N/A (No limit, hashed)</td>
							</tr>
							<tr>
								<td><strong>Confirm Pass*</strong></td>
								<td>Second password field for verification.</td>
								<td>mySecretPassword123</td>
								<td>N/A (No limit, hashed)</td>
							</tr>
							<tr>
								<td>Additional Information</td>
								<td>The AIM, EMAIL, MSN, YAHOO, SKYPE fields are optional, and should be used for communication information.</td>
								<td>N/A</td>
								<td>100</td>
							</tr>
						</tbody>
					</table>
					<p>* Required fields</p>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="rank_management">rank management</h2>
				<p>Phpns uses ranks to limit what users can accomplish with the phpns system. Sometimes, you don't want a user, or a group of users, to be able to post an article without being approved, or creating new users. Ranks can help you limit these users very easily.</p>
				
				<div class="topic">
					<h3 id="rank_management_new_rank">new rank</h3>
					
					<p>Creating a new rank is fairly simple, however, each option requires a description to get full understanding:</p>
					<table border="1">
						<tbody>
							<tr>
								<td><strong>Rank option</strong</td>
								<td><strong>Description</strong></td>
							</tr>
							<tr>
								<td><strong>Logging in</strong></td>
								<td>Determines if the user can login to the phpns system. If set to disallow, the user will get a message on their login attempt, telling them they can't login.</td>
							</tr>
							<tr>
								<td><strong>Create articles</strong></td>
								<td>Determines if the user can post articles in phpns. If set to <code>allow w/ approval</code>, a user who can approve articles can activate it for the public's eyes.</td>
							</tr>
							<tr>
								<td><strong>Approve articles</strong></td>
								<td>A user who can approve articles will be able to activate articles published by someone who can only post articles with approval.</td>
							</tr>
							<tr>
								<td><strong>Edit articles</strong></td>
								<td>Determines whether a user can edit articles already published.</td>
							</tr>
							<tr>
								<td><strong>Delete articles</strong></td>
								<td>Determines whether a user can delete users in article management.</td>
							</tr>
							<tr>
								<td><strong>Create users</strong></td>
								<td>Determines whether a user can create users to access the phpns system.</td>
							</tr>
							<tr>
								<td><strong>Edit users</strong></td>
								<td>Determines if a user can edit existing users.</td>
							</tr>
							<tr>
								<td><strong>Delete users</strong></td>
								<td>Determines whether a user can delete other users in user management.</td>
							</tr>
							<tr>
								<td><strong>Login records</strong></td>
								<td>Determines whether a user can access and review the login records.</td>
							</tr>
							<tr>
								<td><strong>Preferences</strong></td>
								<td>Determines whether a user can edit any preferences/settings in the phpns admin panel</td>
							</tr>
							<tr>
								<td><strong>Create ranks</strong></td>
								<td>Determines whether a user can create ranks in rank management.</td>
							</tr>
							<tr>
								<td><strong>Delete ranks</strong></td>
								<td>Determines whether a user can delete ranks in rank management.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="topic">
				<h2 id="preferences">preferences</h2>
				<p>In the preferences section of phpns, you can modify different aspects of the phpns system, and how news generation is formed.</p>
				
				<div class="topic">
					<h3 id="preferences_display_options">General display options</h3>
					<p>The display options (set in the administration panel, <code>Navigation->Preferences</code>) are used for setting the default values for article generation.</p>
					<p>The date function described in "date format" is the <code>date()</code> function described at the <a href="http://php.net/date">php website</a>.
				</div>
				
				<div class="topic">
					<h3 id="preferences_sef_urls">Search engine friendly URLs</h3>
					<p>Search Engine URLs in phpns make the URLs to each specific article more descriptive, and thus better for search engines to index. Instead of <code>http://example.com/index.php?a=23</code>, Phpns will display something like <code>http://example.com/My-first-article-in-phpns</code>.
					<p>SEF URLs can be enabled on a per-include basis, with the <a href="#pre_include_variables">pre-include variable</a> <code>$phpns['sef'] = '/'</code> (more descriptive in the pre-include variable section of this document). SEF URLs make heavy use of the apache module "mod_rewrite", which you must have to use SEF URLs with phpns. The preferences page regarding this topic will give you a suggested .htaccess to use with phpns.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_categories">Category management</h3>
					<p>Category management is a cornerstone of article management in phpns. Categories are like file cabinets for your articles, allowing you to separate articles into groups, which can be very useful (explained further below).</p>
					<p>By separating your articles into categories, you can refer to them, when including your news, as to only generate articles in that specific category. For example, you can have a "Site news" category, a "Blog" category, and a "Tutorials" category, each one displaying on a separate page on your website.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_comment_options">Comment options</h3>
					<p>This section, comment options, will dictate options and limitations set for comment posting by regular users. These settings <strong>are not</strong> overridable with pre-include variables.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_template_management">Template management</h3>
					<p>Templates are used to customize the format, in HTML, in which your articles are displayed to the end user. You can have an unlimited amount of templates, but only one can remain the "default template". The default template is the template that is used without specifically implying a different template using pre-include variables. (Yes, you can use different templates in different instances of phpns on your website.)</p>
					<div class="topic">
						<h4>New template</h4>
						<p>There are multiple variables that you can use in the templates, specified by using {}s. There is a list of them below:</p>
						<h5>Main article variables</h5>
						<ul>
							<li>{title} = article title</li>
							<li>{sub_title} = subtitle</li>
							<li>{date} = timestamp/date</li>
							<li>{image_src} = article image src. (ex: &lt;img src="{image_src}" alt="{title}" /&gt;
							<li>{main_article} = main article</li>
							<li>{extended_article} = the extended article</li>
							<li>{comment_count} = The number of articles this article has</li>
							<li>{author} = author</li>
							<li>{article_href} = the link to the article, but the actual href value</li>
							<li>{reddit} = reddit social networking link</li>
							<li>{digg} = digg social networking link</li>
						</ul>
						<h5>Comment variables</h5>
						<ul>
							<li>{author} = comment author</li>
							<li>{website} = website</li>
							<li>{comment} = comment</li>
							<li>{date} = comment date</li>
							<li>{ip} = comment ip address</li>
						</ul>
						<h5>Comment form variables</h5>
						<p><em>Please include ALL of the data in the form, or else things won't work.</em> If you're not sure how to use these, copy them over from the default template included with the phpns installation.</p>
						<ul>
							<li>{action} = value that goes inside the form</li>
							<li>{hidden_data} = required value somewhere inside the form</li>
							<li>{captcha_question} = In plain text, the question</li>
							<li>{captcha_answer} = The answer encoded and passed through form</li>
						</ul>
						<h5>Pagination variables</h5>
						<ul>
							<li>{previous_page} = previous page number (ex: &lt;a href="{previous_page}"&gt;)</li>
							<li>{middle_pages} = middle pages, includes links already</li>
							<li>{next_page} = next page number</li>
						</ul>
					</div>
				</div>
				<div class="topic">
					<h3 id="preferences_ban_options">Ban options</h3>
					<p>Ban options allow you to ban, or disallow, users from your website. This is a very useful function if a user is leaving inappropriate and/or offensive comments on your website.</p>
					<p>To ban a user, you will need to gain the IP address of the user (which is available in the comments viewer of each article, with a "ban this user" link!). Bans will last forever unless you lift the ban yourself.</p>
					<p>A list of valid IP addresses:</p>
				
					<ul>
						<li>127.0.0.7</li>
						<li>192.168.0.1</li>
						<li>601.923.334.20</li>
						<li>208.113.134.19</li>
					</ul>
				</div>
				
				<div class="topic">
					<h3 id="preferences_rss_options">Rss/atom options</h3>
					<p>RSS/ATOM options let you modify different aspects of rss and atom generation. These options are <strong>not</strong> overrideable in individual includes.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_integration_wizard">Integration wizard</h3>
					<p>The integration wizard is a tool designed to streamline, and help you generate a custom phpns include script that you can copy and paste into your HTML. Consider it a GUI for setting variables like <code>$phpns['category']</code> and <code>$phpns['template']</code>.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_freeze">Freeze/cache management</h3>
					<p>Freeze management is a feature in phpns to optimize your news when you are expecting, or are currently experiencing a traffic/visit burst from the internet. Sites like reddit.com, digg.com, and other social networking sites often send thousands of visitors to your websiite in the event of a feature on their respective front pages. Usually, when you have a few mySQL queries being executed for each visitor, your server will eventually slow down, and shut down if it's extreme enough.</p>
					<p>When you "freeze" a phpns instance (or shownews.php event), Phpns will create a static, HTML file of the current items on the phpns instance. That way, instead of executing SQL queries for each visitor, PHP will simply send a static HTML file to the user, saving a lot of processing power!</p>
					
					<div class="topic">
						<h4>How to activate</h4>
						<p>The freeze/cache management preference doesn't have an on/off switch, you need to activate it for every phpns instance (every page which calls "shownews.php"). You will be asked for all the pre-include variables you want to modify how the "freeze file" (the static HTML file to be generated) is generated. Paste all the <a href="#pre_include_variables">pre-include variables</a> in this textbox, and click continue.</p>
						<p>You will be given a new pre-include variable, that will look something like this:</p>
					
						<ul>
							<li>$phpns['freeze_file'] = "inc/freeze/freeze.0c5f1062347d7885ba3c2dc534c2dc21.php";</li>
						</ul>
					
						<p>Go back to the file where you want the freeze file to be used. Simply paste this line as another pre-include variable, and save. Phpns will now give the freeze file instead of dynamically generating a new version for each visitor!</p>
						<h4>Notes:</h4>
					
						<ul>
							<li>Comments cannot be used in a frozen instance.</li>
							<li>The full story will be immediately below the main article, without going to a specific article (like the <code>$phpns['always_show_full_story']</code> pre-include variable).</li>
							<li>No new articles will be posted until the freeze-file pre-include variable is removed.</li>
						</ul>
					</div>	
				</div>
				
				<div class="topic">
					<h3 id="preferences_system_log">System log</h3>
					<p>The system log is a dynamic reference for what's been going on with your phpns installation. The log will display (almost) every action taken by every user with any access.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_theme_management">Theme management</h3>
					<p>Phpns uses a very easy theme system that will allow you to customize how the phpns administration panel looks.</p>
					<p>Every theme has a theme directory, located in <code>/themes/{theme}/</code>. The theme file will have 3 required files:</p>
					<ol>
						<li><code>{theme}/theme.xml</code></li>
						<li><code>{theme}/admin.tpl.php</code></li>
						<li><code>{theme}/login.tpl.php</code></li>
					</ol>
					
					<div class="topic">
						<h4>Creating a theme</h4>
						<p>To start creating a theme with phpns, it is recommended to take a look at the default theme included with every phpns installation (<code>/themes/default/</code>). Check <a href="http://phpns.com/">phpns.com</a> for more help on creating theme.</p>
						<div class="topic">
							<h5>Theme replacement variables</h5>
							<p>Theme replacement variables can be used in admin.tpl.php, and login.tpl.php to add dynamic content to your HTML/source code. A list of theme replacement variables for the two files can be found below, respecively:</p>
							<h6>login.tpl.php</h6>
							<ul>
								<li>{content} = page content</li>
								<li>{logo} = phpns logo</li>
								<li>{version} = the phpns version installed</li>
								<li>{current_page_name} = the page name</li>
								<li>{head_data} = data that belongs in the &lt;head&gt; element/tag</li>
								<li>{page_image} = the current page image</li>
							</ul>
							
							<h6>admin.tpl.php</h6>
							<ul>
								<li>{content} = page content</li>
								<li>{username} = current user logged in</li>
								<li>{version} = the phpns version installed</li>
								<li>{current_page_name} = the page name</li>
								<li>{head_data} = data that belongs in the &lt;head&gt; element/tag</li>
								<li>{page_image} = the current page image</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="topic">
					<h3 id="preferences_database_backup">Database backup</h3>
					<p>You can (or anyone with access to the preferences page) backup the phpns database using the database backup tool. After some processing on the backend, phpns will send you the backup to download, allowing you to store the database file on your local computer for easy restoration later.</p>
					
					<p>Restoring the database is easy. Just Click "Browse" next to the input field, and find the database file you previously backed up. <strong>This will delete/overwrite your current database, be careful!</strong></p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_wyiwyg_editor">WYSIWYG editor</h3>
					<p>This preference page will allow you to turn TinyMCE (The WYSIWYG editor used for making articles on phpns, <code><a href="http://tinymce.moxiecode.com/">Website</a></code>, <code><a href="inc/js/tinymce/license.txt">License file</a></code>) on or off, depending on your needs as a publisher. If you set it to OFF, the editor will not load at all, you will need to write in HTML/CSS to design the post (of course, you can just use plain text too).</p>
					
					<div class="topic">
						<h4>TinyMCE license file:</h4>
						<p><textarea><?php include("inc/js/tinymce/license.txt"); ?></textarea></p>
					</div>
					
					<p>Phpns also uses CodePress (The Code editor used for editing templates on phpns, <code><a href="http://codepress.org">Website</a></code>, <code><a href="inc/js/codepress/license.txt">License file</a></code>) which currently cannot be turned on/off. This editor is disabled automatically with Opera browsers, due to incompatibility issues.</p>
					
					<div class="topic">
						<h4>CodePress license file:</h4>
						<p><textarea><?php include("inc/js/codepress/license.txt"); ?></textarea></p>
					</div>
					
					<p><em>Many thanks to both of these projects and their communities, they have improved the functionality of phpns greatly!</em></p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_online_offline_options">Offline/online options</h3>
					<p>This option will allow you to temporarily (or permanently!) shut down phpns to the public. This is very useful when you're trying to sort out a problem dealing with phpns.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_timestamp_options">Timestamp options</h3>
					<p>Timestamp options let you change how the <code>date()</code> function is formatted throughout the phpns administration panel. <em>Note: This does not affect any news generation on <code>shownews.php</code></em>.</p>
					<p>You can learn more about the <code>date()</code> function at the <a href="http://php.net/date">php website</a>.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_delete_login_records">Delete login records</h3>
					<p>Deletes all login records collected so far. Not recommended.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_rank_management">Rank management</h3>
					<p>See <a href="#rank_management">rank management</a>.</p>
				</div>
				
				<div class="topic">
					<h3 id="preferences_global_message">Global message</h3>
					<p>The global message is a message displayed on every administration page of phpns. This is useful when you want to notify fellow administrators about a problem going on, or something worth spreading. To delete this message, simply leave the textarea blank and save.</p>
				</div>
			</div>	
			
			<div class="topic">
				<h2 id="conclusion">conclusion</h2>
				<p>In closing, the phpns project aims to be a useful, yet simple application that can be used by website developers who need a reliable and easy-to-implement system. We're always looking for applications to embed in phpns, along with:</p>
				<ul>
					<li>TinyMCE</li>
					<li>CodePress</li>
				</ul>
				
				<p>If you have something to offer the project, please, don't hesitate to contact us!</p>
			</div>
		</div>
	</body>
</html>
