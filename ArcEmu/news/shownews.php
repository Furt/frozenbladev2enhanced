<?php

//error_reporting( E_ALL | E_STRICT ); //DEBUGGING, uncommment to activate

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/

/* This file will need little to NO modification. All customization can be done 
before including the file, using pre-set variables. If you need to make modifications 
to this file, it's important to comment your code. This is obviously the most important
file in the system, so understanding it is important. All functions are defined here are 
seperate from the main system (for security reasons.)

- Alec Henriksen (http://alecwh.com)
*/

/* Optional variables that can be called before user include:
   * $phpns['limit'] = 1-9999
   * $phpns['template'] = template_id
   * $phpns['category'] (multiple) = 'ID Number(s) (seperated by commas (cat1, cat2, cat3))'
   * $phpns['mode'] (RSS) = RSS, XML, ATOM;
   * $phpns['offset'] = 1-9999;
   * $phpns['order'] = 'asc|desc';
   * $phpns['sef'] = 'path'; (default: '/')
   * $phpns['comment_override'] = TRUE/FALSE;
   * $phpns['static'] = TRUE/FALSE;
   * $phpns['disable_pagination'] = TRUE/FALSE;
   * $phpns['items_per_page'] = 1-9999;
   * $phpns['always_show_extended_article'] = TRUE/FALSE;
   * $phpns['script_link'] = 'path/to/script.php' (relative or absolute)
   * $phpns['freeze_file'] = FILENAME; (given on freeze file preference page)
*/

//first, before anything, we need to check for "$phpns['freeze_file']". If it exists, skip all this stuff and just get that file.

if ($phpns['freeze_file'] && strstr($phpns['freeze_file'], 'freeze.')) {

	//include freeze file!
	include($phpns['freeze_file']);
	
} else { //if no freeze file, go into the article generation

	//define some variables, immediately protect against injection

		$phpns['do'] = htmlentities($_POST['do']);
		if (!$phpns['do'] && !strstr($_GET['a'], 'page:')) { $phpns['id'] = htmlentities($_GET['a']); }
		$phpns['mode'] = htmlentities($phpns['mode']);
		$phpns['offset'] = htmlentities($phpns['offset']);
	
		//generate current time, used globally
		$phpns['time'] = time();
		$phpns['ip'] = $_SERVER['REMOTE_ADDR'];
		
		//for backwards compatibility
		$phpns['sef'] = $phpns['sef'];
	
	//before continuing, protect from injection
	if ($phpns['sef'] == FALSE) {
		if (!is_numeric($phpns['id']) && $phpns['id'] && $phpns['id'] != 'do=rss') {
			$phpns['inject_error'] = '
				<h1>stop!</h1>
				<hr />
				ID paramater used: <strong>'.$phpns['id'].'</strong>
				<p>Phpns has detected a possible security breach, or a mal-formed URL. The ID paramater cannot contain a letter in non-SEF mode.</p>
			';
			die($phpns['inject_error']);
		}
	} else {
		//if sef is set to /, just blank it
		$phpns['sef_slash'] = ($phpns['sef'] == '/') ? '' : '/';
	
		if ($phpns['id'] && substr($phpns['id'],strlen($phpns['id'])-1,1) == '/') {
			$phpns['id'] = substr_replace($phpns['id'] ,"",-1);
		}
	}
	
	//include database information
		@require("inc/config.php");
	//connect.
	$phpns['connection'] = mysql_connect($databaseinfo['host'], $databaseinfo['user'], $databaseinfo['password'])
	or die ($error['connection']);
	//select mysql database
	$phpns['db'] = mysql_select_db($databaseinfo['dbname'],$phpns['connection'])
	or die ($error['database']);
	
	//define show_news functions, and check if functions are already defined.
		if (!function_exists('clean_data')) {
			function clean_data($data) {
				if (is_array($data)) {
					foreach ($data as $key => $value) {
						if(ini_get('magic_quotes_gpc')) { $data[$key] = stripslashes($value); }
						$data[$key] = htmlspecialchars($value);
						}
				} else {
					if(ini_get('magic_quotes_gpc')) { $data = stripslashes($data); }
					$data = htmlspecialchars($data, ENT_QUOTES);
				}
				return $data;
			}
		}
		if (!function_exists('decode_data')) {
			function decode_data($data) {
				if (is_array($data)) {
					foreach ($data as $key => $value) {
						$data[$key] = htmlspecialchars_decode($value);
						}
				} else {
					$data = htmlspecialchars_decode($data);
				}
				return $data;
			}
		}
		if (!function_exists('db_fetch')) {
			function db_fetch($query,$type,$clean=NULL) {
				//echo '<textarea width="100%">'.$query.'</textarea>'; //debugging, this will output every query.
					if ($clean == TRUE) {
						$query = clean_data($query); //clean
					}
				
				$res = mysql_query($query) or die(mysql_error().'<br /><br />Line '.__LINE__.'<br /><br /> query: '.$query.'');
				//return value or not?
					if ($type == 1) { //if we want a value
						$value = mysql_fetch_array($res) or die('fetch array failed, line: '.__LINE__.', query: <textarea>'.$query.'</textarea><p>'.mysql_error().'</p>');
						return $value;
					} else {
						return $res;
					}
			}
		}
		if (!function_exists('db_insert')) {
			function db_insert($query) {
				//sql construction
				$insert_res = mysql_query($query) or die(mysql_error());
				$affected = mysql_affected_rows();
				return $affected;
			}
		}
		if (!function_exists('fetch_template')) {
			function fetch_template() { //figure out default template, or use a user defined one.
				global $databaseinfo; //for table prefix
				global $phpns;
			
				if (!$phpns['template']) {  //if template is not defined by pre-var include... get default
					$res = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."templates WHERE template_selected='1' LIMIT 1", 1);
					return $res; //return default template (changeable in preferences)
				} else {
					$res = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."templates WHERE id='".$phpns['template']."' LIMIT 1", 1);
					return $res;
				}
			}
		}
		if (!function_exists('translate_item')) {
			function translate_item($item,$template,$type) {
				/* 
				HTML_ARTICLE:
					{title} = article title
					{subtitle} = subtitle
					{date} = timestamp/date
					{main_article} = main article
					{extended_article} = full story
					{image} = article image
					{author} = author
					{article_href} = the link to the article, but the actual href value
					{reddit} = reddit social networking link
					{digg} = digg social networking link
				HTML_COMMENT
					{author} = comment author
					{website} = website
					{comment} = comment
					{date} = comment date
					{ip} = comment ip address
				HTML_FORM:
					{action} = value that goes inside the <form>
					{hidden_data} = required value somewhere inside the <form>
					{captcha_question} = In plain text, the question
					{captcha_answer} = The answer encoded and passed through <form>
				
				*/
				global $phpns; //for various things
				global $databaseinfo; //for table prefix
			
				$template = decode_data($template);
			
				if ($type == "html_article") { //if we are working with the html_article
						//change back from htmlspecialchars to htmlspecialchars_decode, and define some other vars
						$item = decode_data($item);
						$item['timestamp'] = date($phpns['timestamp_format']['v3'], $item['timestamp']);
					
						if ($phpns['sef'] == TRUE) {
							//apply the safe url
							$url = 'http://'.$_SERVER['SERVER_NAME'].$phpns['sef_slash'].$phpns['sef'].$item['article_sef_title'];
						} else {
							if ($phpns['script_link']) {
								$url = $phpns['script_link'].'?a='.$item['id'];
							} else {
								$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?a='.$item['id'];
							}
						}
					$template = str_replace('{title}', $item['article_title'], $template);
					$template = str_replace('{id}', $item['id'], $template);
					$template = str_replace('{sub_title}', $item['article_subtitle'], $template);
					$template = str_replace('{main_article}', $item['article_text'], $template);
				
					if ($phpns['always_show_extended_article'] == TRUE) { $template = str_replace('{extended_article}', $item['article_exptext'], $template); }
				
					if ($phpns['id'] && $phpns['disable_extended_article'] != TRUE) { $template = str_replace('{extended_article}', $item['article_exptext'], $template); } else { $template = str_replace('{extended_article}', '', $template); }
					
					//replace image location (note: not image itself!)
					$template = str_replace('{image_location}', $item['article_imgid'], $template);
					
					//if there is an image
					if ($item['article_imgid']) { $template = str_replace('{image}', '<img src="'.$item['article_imgid'].'" alt="'.$item['article_title'].'" title="'.$item['article_title'].'" />', $template); } else { $template = str_replace('{image}', '', $template); }
					$template = str_replace('{date}', $item['timestamp'], $template);
					$template = str_replace('{author}', $item['article_author'], $template);
				
					//construct href for a
					$template = str_replace('{article_href}', $url, $template);
				
					//reddit, digg, del.icio.us buttons
					$template = str_replace('{reddit}', '
					<script>reddit_url=\''.$url.'\'</script>
					<script>reddit_title=\''.$item['article_title'].'\'</script>
					<script language="javascript" src="http://reddit.com/button.js?t=2"></script>
					', $template);
				
					//digg_url = \''.$url.'\'; is the real one
					$template = str_replace('{digg}', '
					<script type="text/javascript">
						digg_url = \''.$url.'\';
						digg_bgcolor = \'transparent\';
					</script>
					<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script> 
					', $template);
				
						//comment numeric representations
						$comment_num = db_fetch('SELECT COUNT(*) FROM '.$databaseinfo['prefix'].'comments WHERE article_id='.$item['id'].'',1,FALSE);
						$template = str_replace('{comment_count}', $comment_num[0], $template);
					return $template;	
				} elseif ($type == "html_comment") {
					$item['timestamp'] = date($phpns['timestamp_format']['v3'], $item['timestamp']);
					$item['comment_text'] = nl2br($item['comment_text']);
					$template = str_replace('{author}', $item['comment_author'], $template);
					$template = str_replace('{id}', $item['id'], $template);
					$template = str_replace('{timestamp}', $item['timestamp'], $template);
					$template = str_replace('{comment}', $item['comment_text'], $template);
					$template = str_replace('{website}', $item['website'], $template);
					$template = str_replace('{ip}', $item['ip'], $template);
					$template = str_replace('{admin}', '', $template);
					return $template;
				
				
				} elseif ($type == "html_form") {
					@require("inc/captcha.php"); //require captcha info
						//if SEF urls, we write a SEF url. ;) IF NOT, regular ?$phpns['id']
						if ($phpns['sef'] == TRUE) {
							$url = 'http://'.$_SERVER['SERVER_NAME'].$phpns['sef_slash'].$phpns['sef'].$phpns['article_sef_title'];
						} else {
							$url = '?a='.$phpns['id'];
						}
					//captcha determination
					$captcha['question'] = array_rand($captcha);
					$captcha['answer'] = base64_encode($captcha[$captcha['question']] + (60-20));
					//start translation for the html comment form
					$template = str_replace('{action}', $url, $template);
					$template = str_replace('{captcha_question}', $captcha['question'], $template);
					$template = str_replace('{captcha_answer}', '<input type="hidden" name="captcha_answer" value="'.$captcha['answer'].'" />', $template);
					$template = str_replace('{hidden_data}', '<input type="hidden" name="id" value="'.$phpns['id'].'" />', $template);
					return $template;
				
				} elseif ($type == "html_pagination") { //pagination template
			
						if ($item['previous']) {$template = str_replace('{previous_page}', '?a=page:'.$item['previous'], $template); } else { $template = str_replace('{previous_page}', '', $template); }
						if ($item['next']) {$template = str_replace('{next_page}', '?a=page:'.$item['next'], $template); } else { $template = str_replace('{next_page}', '', $template); }
						$template = str_replace('{middle_pages}', $item['middle'], $template);
						return $template;
					
				} elseif ($type == "rss") { //we translate each item with RSS syntax. <item>s and such.
						$url = 'http://'.$_SERVER['SERVER_NAME'].substr_replace(dirname($_SERVER['PHP_SELF']),"",-1); //get URL without the last comma
						if ($phpns['sef']) {
							$rss_link = 'http://'.$_SERVER['SERVER_NAME'].$phpns['sef_slash'].$phpns['sef'].$item['article_sef_title'];
						} else {
							if ($phpns['script_link']) {
								$rss_link = $phpns['script_link'].'?a='.$item['id'];
							} else {
								if (strstr($_SERVER['PHP_SELF'], 'etc.php')) {
									$url = $url.'/article.php?do=edit&amp;id='.$item['id'].'';
									$rss_link = $url;
								} else {
									$rss_link = $url.dirname($_SERVER['PHP_SELF']).'?a='.$item['id'];
								}
							}
						}

					
						$item['timestamp'] = date(DATE_RSS, $item['timestamp']);
					
					$template = '
		<item>
			<title>'.$item['article_title'].'</title>
			<author>'.$item['article_author'].'</author>
			<category>'.$item['article_cat'].'</category>
			<pubDate>'.$item['timestamp'].'</pubDate>
			<link>'.$rss_link.'</link>
			<description>'.$item['article_text'].'</description>
		</item>';
					return $template; //return template
				} elseif ($type == "atom") {
					$url = 'http://'.$_SERVER['SERVER_NAME'].substr_replace(dirname($_SERVER['PHP_SELF']),"",-1); //get URL without the last comma
						if ($phpns['sef']) {
							$rss_link = 'http://'.$_SERVER['SERVER_NAME'].$phpns['sef_slash'].$phpns['sef'].$item['article_sef_title'];
						} else {
							if ($phpns['script_link']) {
								$rss_link = $phpns['script_link'].'?a='.$item['id'];
							} else {
								if (strstr($_SERVER['PHP_SELF'], 'etc.php')) {
									$url = $url.'/article.php?do=edit&amp;id='.$item['id'].'';
									$rss_link = $url;
								} else {
									$rss_link = $url.dirname($_SERVER['PHP_SELF']).'?a='.$item['id'];
								}
							}
						}
					
						$item['timestamp'] = date(DATE_ATOM, $item['timestamp']);
					
					$template = '
		<entry>
			<title>'.$item['article_title'].'</title>
			<author><name>'.$item['article_author'].'</name></author>
			<published>'.$item['timestamp'].'</published>
			<link href="'.$atom_link.'"/>
			<id>'.$item['id'].'</id>
			<updated>'.$item['timestamp'].'</updated>
			<summary>'.$item['article_text'].'</summary>
		</entry>';
					return $template;
				}
			}
		}
			//check to see if the system is online. If yes, we continue, if no, well... no. ;)
			$phpns['siteonline'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='line'",1,FALSE);
				if ($phpns['siteonline']['v1'] == 'no') { 
					die('<div class="disabled_message">The administrator has disabled the news system.</div>'); 
				}	
			$phpns['banned'] = db_fetch("SELECT ip, reason FROM ".$databaseinfo['prefix']."banlist",0);
				while ($phpns['ip'] = mysql_fetch_assoc($phpns['banned'])) {
					if ($phpns['ip']['ip'] == $_SERVER['REMOTE_ADDR']) {
						die("<strong>You have been banned.</strong>
						<p><strong>Reason:</strong> ".$phpns['ip']['reason']."</p>
						");
					}
				}
		
			//timestamp format fetch
			$phpns['timestamp_format'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='timestamp_format'",1,FALSE);
		
			//fetch template. :)
			$phpns['template'] = fetch_template();

		//before anything else, we're going to detect if there is post data, and if there is, we'll insert the db. If there is no post data, just pass over this.
				if ($_POST && $phpns['static'] != TRUE) {
				
					//IF THERE IS POST DATA, then we're submitting the form. We need to clean data.
					$phpns['comment'] = clean_data($_POST);
				
					//set the continue to yes.
					$phpns['comment_continue'] = TRUE;
				
					//validate data (regex for email)
					if (!$phpns['comment']['name'] || !$phpns['comment']['email'] || !$phpns['comment']['comment'] || !preg_match("/^[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)$/", $phpns['comment']['email'])) {
						$phpns['comment_error'] = 'You need to enter all required fields, and a valid email. Press back to try again.';
						$phpns['comment_continue'] = FALSE;
					}
				
					if (!$phpns['def_comlimit']) { $phpns['def_comlimit']  = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_comlimit'",1); $phpns['def_comlimit'] = $phpns['def_comlimit']['v3']; }
				
					if (strlen($phpns['comment']['comment']) >= $phpns['def_comlimit']) {
							$phpns['comment_continue'] = FALSE;
							$phpns['comment_error'] .= 'Your comment exceeded the character limit ('.$phpns['def_comlimit'].').';
					}
					
					if ($phpns['comment']['captcha'] != base64_decode($phpns['comment']['captcha_answer'])-(60-20) || !$phpns['comment']['captcha']) {
							$phpns['comment_continue'] = FALSE;
							$phpns['comment_error'] .= ' The captcha answer was incorrect. Press "back" on your browser to try again.';
						}
		          		if ($phpns['sef'] == TRUE) {
		          			$phpns['sef']['title_id'] = str_replace('-', ' ', $phpns['comment']['id']);
						$article_id = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."articles WHERE article_title='".$phpns['sef']['title_id']."'",1);
						$article_id = $article_id['id'];
		          		} else {
						$article_id = $phpns['comment']['id'];
					}
		          		
		          		
		                  //if comment_id is not numeric, kill with message
					if (!is_numeric($phpns['comment']['id']) && $phpns['sef'] == FALSE) { die("non-numeric form id, invalid information."); }
						if ($phpns['comment_continue'] == TRUE) {
							$phpns['ip'] = $_SERVER['REMOTE_ADDR'];
							$insert = db_insert('INSERT INTO '.$databaseinfo['prefix'].'comments (article_id,comment_text,comment_author,website,timestamp,approved,ip) VALUES ("'.$article_id.'","'.$phpns['comment']['comment'].'","'.$phpns['comment']['name'].'","'.$phpns['comment']['website'].'","'.$phpns['time'].'","1","'.$phpns['ip'].'")');
						} else {
							$phpns['content'] .= '<div class="warning">'.$phpns['comment_error'].'</div>';
						}
				}

	
	
	
		/*
			ACTUAL CONTENT GENERATION.
			If there is no $phpns['do'], we're not using RSS or ATOM, and there is no specific $phpns['id'], we display the list.
		*/

		if (((!$phpns['do'] || $phpns['do'] == 'rss') && (!$phpns['id'] || $phpns['id'] == 'do=rss')) || $phpns['static'] == TRUE) { //if no defined action, show news as it is meant to be displayed.
			//gather some important variables from db.
			if ($phpns['category']) { $phpns['category'] = 'WHERE article_cat IN ('.$phpns['category'].',\'all\') &&'; } else { $phpns['category'] = "WHERE"; }
			if (!$phpns['offset']) { $phpns['offset'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_offset'",1); $phpns['offset'] = $phpns['offset']['v1']; } $phpns['original_offset'] = $phpns['offset']; //to be used later...
			if (!$phpns['limit']) { $phpns['limit'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_limit'",1); $phpns['limit'] = $phpns['limit']['v1']; }
			if (!$phpns['order']) { $phpns['order'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_order'",1); $phpns['order'] = $phpns['order']['v1']; }
			if (!$phpns['items_per_page']) { $phpns['items_per_page'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_items_per_page'",1); $phpns['items_per_page'] = $phpns['items_per_page']['v1']; }
		
				/* Pagination management:
						phpns works by using QUERY_STRING like this: filename.php?page:1
					So, if no page is defined, we're going to default to 1. */
			
				if (strstr($_GET['a'], "page:") && $phpns['static'] != TRUE) {
					//get the current page from the URI.
					$phpns['current_page'] = str_replace('page:','', $_GET['a']);
				}
			
					//if the string is empty, we assume page 1.
					if (!is_numeric($phpns['current_page']) && !$phpns['current_page']) {
						$phpns['current_page'] = 1;
					}
				
					//added this to balance problems in dealing with larger items_per_page than the limit itself. Works so far. =)
					if ($phpns['items_per_page'] > $phpns['limit']) {
						$phpns['items_per_page'] = $phpns['limit'];
					}
					
						if ($phpns['current_page'] == 1) {
							//determine offset
							$phpns['offset'] = ($phpns['current_page'] * $phpns['items_per_page'] - ($phpns['items_per_page'])) + $phpns['offset'];
						} else {
							$phpns['offset'] = ($phpns['current_page'] * $phpns['items_per_page'] - ($phpns['items_per_page']));
						}
					
		
		
					//MODE MODIFICATION
					if ($phpns['mode'] == "rss" || $phpns['mode'] == "atom") {
						//rss online?
						$phpns['enabled'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_rssenabled'",1);
						$phpns['enabled'] = $phpns['enabled']['v1'];
					
						if ($phpns['enabled'] == FALSE) {
							die("RSS is not enabled.");
						}
					
						//fetch rss limit
						$phpns['limit'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_rsslimit'",1);
							$phpns['limit'] = $phpns['limit']['v3'];
						//fetch rss order
						$phpns['order'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_rssorder'",1);
							$phpns['order'] = $phpns['order']['v1'];
						
							$phpns['items_per_page'] = $phpns['limit'];
					}
				
					if ($phpns['mode'] == NULL) {
						//form count query, then figure out the total amount of rows in the news generation (including all pages)
						$phpns['fetch_news_count'] = db_fetch("
						SELECT * FROM ".$databaseinfo['prefix']."articles
						".$phpns['category']."
						active='1' AND approved='1'
						LIMIT ".$phpns['original_offset'].",".$phpns['limit']."
						", 0);
						$phpns['total_news_count'] = mysql_num_rows($phpns['fetch_news_count']);
					}
			//forming actual news query.	
			$phpns['fetch_news'] = db_fetch("
				SELECT * FROM ".$databaseinfo['prefix']."articles
				".$phpns['category']."
				active='1' AND approved='1'
				ORDER BY timestamp ".$phpns['order']."
				LIMIT ".$phpns['offset'].",".$phpns['items_per_page']."
				", 0);
			
				//pagination determinaion continuation =)
			
			
			while ($phpns['row'] = mysql_fetch_assoc($phpns['fetch_news'])) {  //start fetch loop
		
				//if start time is greater than current time, and end time is less than current time, show.
				if (($phpns['row']['start_date'] <= $phpns['time'] || $phpns['row']['start_date'] == NULL) && ($phpns['row']['end_date'] >= $phpns['time'] || $phpns['row']['end_date'] == NULL)) {
			
					//put into $phpns['items'] if rss mode, else just $phpns['content']
					if ($phpns['mode'] == 'rss' || $phpns['mode'] == 'atom') {
						$phpns['returned_data'] = translate_item($phpns['row'], $phpns['template']['html_article'], ''.$phpns['mode'].''); //translate into template
						$phpns['items'] .= $phpns['returned_data'];
					} else {
						$phpns['returned_data'] = translate_item($phpns['row'], $phpns['template']['html_article'], 'html_article'); //translate into template
						$phpns['content'] .= $phpns['returned_data'];////////////////////
					}

				}
			}
		
			if (!$phpns['mode'] && $phpns['disable_pagination'] != TRUE) {
			
				//find the total number of pages
				$phpns['pages']['page_num'] = ceil($phpns['total_news_count'] / $phpns['items_per_page']); 
		
				//generate previous page link
				if ($phpns['current_page'] > 1) { 
			 		$phpns['page']['previous'] = $phpns['current_page'] - 1;
				}
		
				//generate next page link
				if ($phpns['current_page'] < $phpns['pages']['page_num']) {
					$phpns['page']['next'] = $phpns['current_page'] + 1;
				}
		
				//generate middle pages
		    		for($phpns['i'] = 1; $phpns['i'] <= $phpns['pages']['page_num']; $phpns['i']++){
		    			if ($phpns['i'] == $phpns['current_page']) {
		    				$phpns['page']['middle'] = $phpns['page']['middle'] . "\n".'<span class="pagination page_link_'.$phpns['i'].'"><a>'.$phpns['i'].'</a></span> ';
		    			} else {
						$phpns['page']['middle'] =  $phpns['page']['middle'] . "\n".'<span class="pagination page_link_'.$phpns['i'].'"><a href="?a=page:'.$phpns['i'].'">'.$phpns['i'].'</a></span> ';
					}
				} 
		
					//add pagination links to content
					$phpns['content'] .= translate_item($phpns['page'], $phpns['template']['html_pagination'], 'html_pagination');
			}
		
		} elseif ($phpns['id'] && !$phpns['mode'] && $phpns['static'] != TRUE) { //if we're dealing with singles, and the admin wants single articles to be displayed....
			if (!$phpns['comment_override']) { $phpns['allow_com'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_comenabled'",1); } else { $phpns['allow_com'] = TRUE; }
			//if SEF URLs are enabled, we need to change a few things, and make it search for titles instead of id
		
			if ($phpns['sef'] == TRUE) {
				$phpns['where_spec'] = "article_sef_title='".$phpns['id']."'";
			} else {
				$phpns['where_spec'] = "id='".$phpns['id']."'";
			}
		
			//forming actual news query.	
			$phpns['fetch_news'] = db_fetch("
				SELECT * FROM ".$databaseinfo['prefix']."articles
				WHERE
				active='1' AND approved='1' AND ".$phpns['where_spec']." LIMIT 1
				", 0);	
				//we're checking how many results were retrieved. If none, we set an error message and display it.
			if (mysql_num_rows($phpns['fetch_news']) == 0) {
		
				//set the error message, and display it.
				$phpns['error_message'] = '<div class="error_message">The article/page requested ('.$phpns['id'].' | '.$phpns['sef']['title_id'].') does not exist.</div>';
				$phpns['content'] .= $phpns['error_message'];
			
			} else { //if there IS an article, we proceed. =)
				while ($phpns['row'] = mysql_fetch_assoc($phpns['fetch_news'])) {  //start fetch loop
					if ($phpns['time'] >= $phpns['row']['start_date'] || $phpns['time'] <= $phpns['row']['end_date']  || $phpns['row']['start_date'] == NULL || $phpns['row']['end_date'] == NULL) { //if we're set for time landings
						$phpns['allow_com']['article_specific'] = $phpns['row']['allow_comments'];
						$phpns['returned_data'] = translate_item($phpns['row'], $phpns['template']['html_article'], 'html_article'); //translate into template
						$phpns['content'] .= $phpns['returned_data'];
							//if rss, we have to write it to $phpns['items']
					}
			
				}
				//echo var_dump($phpns['allow_com']); //debug
				//now, we generate comments for this specific article IF they are enabled
				if ($phpns['allow_com']['v1'] == TRUE) {
			
					//get order preference from db
					 $phpns['def_comorder'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_comorder'",1);
					 
					if ($phpns['sef'] == TRUE) {
						$phpns['sef']['title_id'] = $phpns['id'];
						$phpns['sef_article_id'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."articles WHERE article_sef_title='".$phpns['id']."'",1);
						
						//fixed: http://phpns.alecwh.com/forums/comments.php?DiscussionID=9 by jbdesignandphoto
						$phpns['fetch_com_res'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."comments WHERE article_id='".$phpns['sef_article_id']['id']."' AND approved='1' ORDER BY id ".$phpns['def_comorder']['v1']."", 0);
					} else {
						//or the default (no SEF)
						$phpns['fetch_com_res'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."comments WHERE article_id='".$phpns['id']."' AND approved='1' ORDER BY id ".$phpns['def_comorder']['v1']."", 0);
					}
				
					//define refer_id as 0
					$phpns['row']['refer_id'] = 0;
						//for each row (or comment) generated, we translate the item and assign it to $phpns['content']
						while ($phpns['row'] = mysql_fetch_assoc($phpns['fetch_com_res'])) {
							$phpns['row']['refer_id'] = $phpns['row']['refer_id'] + 1;
							$phpns['comment_list'] .= translate_item($phpns['row'], $phpns['template']['html_comment'], 'html_comment');
						}
				}
					//assign $phpns['comment_list'] to $phpns['content']
					$phpns['content'] .= $phpns['comment_list'];
		
				//translate html comment form, then add it to the end of $phpns['content'], if comments are enabled
				if (($phpns['allow_com']['v1'] == TRUE && $phpns['allow_com']['article_specific'] == 1 && $phpns['static'] != TRUE) || $phpns['comment_override'] == TRUE && $phpns['static'] != TRUE) {
					$phpns['form_template'] = translate_item('', $phpns['template']['html_form'], 'html_form');
				} else {
					$phpns['form_template'] = '';
				}
					//add it to $phpns['content'] ($phpns['form_template'] will be empty if comments are not enabled)
					$phpns['content'] .= '
					'.$phpns['form_template'];
			} //end of the ELSEIF of mysql_num_rows (there were results...)

		} //end main if
	
	
			//if we have a mode enabled (rss or atom....) then lets fetch some global data
			if ($phpns['mode']) {
				$rss['title'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_rsstitle'",1);
				$rss['desc'] = db_fetch("SELECT * FROM ".$databaseinfo['prefix']."gconfig WHERE name='def_rssdesc'",1);
			}
		
		if ($phpns['mode'] == 'rss') { //we generate the header information
			header('Content-Type: text/xml; charset=utf-8');
		
			$phpns['content'] .= '<?xml version="1.0" encoding="UTF-8"?>
	<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
		<channel>
			<title>'.$rss['title']['v3'].'</title>
			<link>http://'.$_SERVER['SERVER_NAME'].'</link>
			<description>'.$rss['desc']['v3'].'</description>
			'.$phpns['items'].'
		</channel>
	</rss>';
		} elseif ($phpns['mode'] == "atom") {
			header('Content-Type: text/xml; charset=utf-8');
			$phpns['content'] .= '<?xml version="1.0" encoding="utf-8"?>
		<feed xmlns="http://www.w3.org/2005/Atom">
		<link href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" rel="self"/>
		<link href="http://'.$_SERVER['SERVER_NAME'].'"/>
		<id>'.$_SERVER['SERVER_NAME'].'</id>
		<updated>'.date(DATE_ATOM).'</updated>
	
		'.$phpns['items'].'
	
		</feed>';
	
		}
	
		//if viewing shownews.php directly
		if (strstr($_SERVER['PHP_SELF'], "shownews.php")) {
			echo "<p><strong>You are viewing the shownews.php file directly! You probably want to include this file, instead of just directly linking to it.</strong> For a HOWTO, see <a href=\"help.php\">the help/manual file.</a></p>";
		}

		echo $phpns['content']; //and... finally post the content
	
	
	
		//if no $phpns['content'], something was wrong. Just display a friendly message....
		if (!$phpns['content']) {
			echo "<h2>Blank.</h2>
				<p>For some reason, there was no output in the shownews.php file. Either (a) no articles are active, or (b) the template that is being used is empty.</p>";
		}
} //end everything (this is the end to the freeze file if)
	
	//unset the $phpns variable, swiping all data.
	unset($phpns);

?>
