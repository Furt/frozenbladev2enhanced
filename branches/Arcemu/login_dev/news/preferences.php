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

include("inc/header.php");
$do = $_GET['do'];

	//quick permission check (redir to error)
	if ($globalvars['rank'][6] == 0) {
		header("Location: index.php?do=permissiondenied");
		die();	
	}

	if (!$do) { //just display the selection menu
		$globalvars['page_name'] = "preferences";
		$content = '
			<h3>News display options</h3>
			<div id="columnright">
				<ul>
					<li><a href="?do=sef">search engine friendly urls</a></li>
					<li><a href="?do=comments">comment options</a></li>
					<li><a href="?do=ban">ban options</a></li>
					<li><a href="?do=wizard">integration wizard</a></li>
				</ul>
			</div>
				<ul>
					<li><strong><a href="?do=display">general display options</a></strong></li>
					<li><a href="?do=categories">category management</a></li>
					<li><a href="?do=templates">template management</a></li>
					<li><a href="?do=feed">feed management</a></li>
					<li><a href="?do=freeze">freezing/cache management</a></li>
				</ul>
			<h3>Editing/System options</h3>
			<div id="columnright">
				<ul>
					<li><a href="?do=themes">theme options</a></li>
					<li><a href="?do=wysiwyg">WYSIWYG editor</a></li>
					<li><a href="?do=timestamp">timestamp options</a></li>
				</ul>
			</div>
				<ul>
					<li><strong><a href="?do=syslog">system log</a></strong></li>
					<li><a href="?do=backup">database backup</a></li>
					<li><a href="?do=line">online/offline options</a></li>
				</ul>
			<h3>User options</h3>
			<div id="columnright">
				<ul>
					<li><a href="user.php?do=ranks">rank management</a></li>
				</ul>
			</div>
				<ul>
					<li><a href="user.php?do=loginrec&amp;action=delall" onClick="return confirm(\'Are you sure you want to delete all login records?\');">delete login records</a></li>
				</ul>
			
			<h3>Misc options</h3>
				<ul>
					<li><a href="?do=globalmessage">global message</a></li>
				</ul>';
	} elseif ($do == "categories") { //if category
		$action = $_GET['action'];
		//if create new category
		if ($action == "new") { //if new category
			$data = $_POST;
				if (empty($data['name'])) {
					$proceed = "no";
					$error_messages = '<ol class="warning"><li>A name is required for the category!</li></ol>';
				}
			//execute SQL function if no errors
			if ($proceed != "no") {
				new_category($data,$_SESSION['username']);
				unset($data);
				
				//success message
				$success .= '<div class="success">The category has been successfully created.</div>';
			}
			
		} elseif($action == "deleteitems") {
			$items = $_POST; //get vars
			
			//unset post data move_cat so we can get a clean collection of #s
			unset($items['move_cat']);
			$move_cat = $_POST['move_cat'];
				
			if (!$items) { //if no items, avoid mysql error by just redirecting
				header("Location: preferences.php?do=categories");
			}
			
			foreach($items as $key=>$value) { //create list of ids to be deleted
				$items_f = $items_f."'$value',";
			}
			$items_f = substr_replace($items_f,"",-1); //remove last comma in list for SQL
			
			$res = general_query("DELETE FROM ".$databaseinfo['prefix']."categories WHERE id IN (".$items_f.")"); //delete all records where the id is in the list
			
			//log the deletion
			log_this('delete_categories','User <i>'.$_SESSION['username'].'</i> has <strong>deleted</strong> the following categories (ID(s)): '.$items_f.'');
			
			//form sql for deletion of sub cats
			$res_subdel = general_query("DELETE FROM ".$databaseinfo['prefix']."categories WHERE cat_parent IN (".$items_f.")"); //delete all records where the id is in the list
				//move items to selected cateogry
				$res_m = general_query('UPDATE '.$databaseinfo['prefix'].'articles SET article_cat="'.$move_cat.'" WHERE article_cat IN ('.$items_f.')');
			header("Location: preferences.php?do=categories&delete_success=1");
		}
		$globalvars['page_name'] = "categories";
		$globalvars['page_image'] = "preferences";
		$data['cat_list'] = gen_categories('option','top');
		$table_rows = gen_categories('row','');
		$move_selected = gen_categories('option','');
		
		if ($_GET['delete_success']) {
			$success .= '<div class="success">The item(s) have been successfully deleted.</div>';
		}
		
		$content = '
		'.$error_messages.'
		'.$success.'
		<h3>Create new category</h3>
		<div class="form">
			<form action="preferences.php?do=categories&amp;action=new" method="post">
				<label for="name">Category name</label><input type="text" id="category_name" name="name" maxlength="100" /> <input type="submit" value="Create category" id="submit" onclick="javascript:document.getElementById(\'submit\').disabled=true" /><br />
				<label for="description">Description</label><input type="text" id="category_desc" name="description" value="'.$data['description'].'" maxlength="1000" /><br />
				<label for="parent">Parent</label>
				<select name="parent">
					<option value="">None</option>
					<optgroup label="Categories">
						'.$data['cat_list'].'
					</optgroup>
				</select>
			</form>
		</div>
		<h3>Category list</h3>
		<form action="preferences.php?do=categories&amp;action=deleteitems" method="post">
			<table style="text-align: left; width: 100%;" border="1"
				 cellpadding="3" cellspacing="2">
				  <tbody>
				    <tr class="toprow">
				    	<td><strong>ID</strong></td>
				      <td><strong>Name</strong></td>
				      <td><strong>Parent (?)</strong></td>
				      <td><strong>Description</strong></td>
				      <td><strong>Date</strong></td>
				      <td style="width: 10px; text-align: center;"><strong><input type="checkbox" onClick="Checkall(this.form);" /></strong></td>
				    </tr>
				    '.$table_rows.'
				  </tbody>
			</table>
			<div style="text-align: right;">
				Move items from categories (that will be deleted) to: <select id="move_cat" name="move_cat" style=" margin: 0; width: 250px;">
					'.$move_selected.'
				</select>
				<input type="submit" id="submit" value="Delete Selected" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
			</div>
		</form>
		';
	
	} elseif ($do == "display") { //if displaly options
		//define page name and image
		$globalvars['page_name'] = "display options";
		$globalvars['page_image'] = "preferences";
		
			if ($_GET['action'] == "update") {
				change_config('def_limit',$_POST['def_limit']);
				change_config('def_offset',$_POST['def_offset']);
				change_config('timestamp_format',$_POST['timestamp_format']);
				change_config('def_order',$_POST['def_order']);
				change_config('def_items_per_page',$_POST['def_items_per_page']);
				$error_message = '<div class="success">Your preferences have been saved.</div>';
				
				//log the change
				log_this('display_config','User <i>'.$_SESSION['username'].'</i> has <strong>edited</strong> the default display options');
			}
		
		//generate gconfig values
		$timestamp_format = load_config('timestamp_format');
		$def_offset = load_config('def_offset');
		$def_items_per_page = load_config('def_items_per_page');
		$def_limit = load_config('def_limit');
		$def_order = load_config('def_order');
		
			if ($def_order['v1'] == "desc") {
				$def_order_display = "Descending";
			} elseif ($def_order['v1'] == "asc") {
				$def_order_display = "Ascending";
			}
		
		$content = '
			'.$error_message.'
		<h3>Display options</h3>
		<div class="form">
			<form action="preferences.php?do=display&amp;action=update" method="post">
				<div id="columnright">
				<br />
				<label for="def_limit">Display limit</label>
					<select name="def_limit">
						<optgroup label="Selected:">
						<option selected="selected" value="'.$def_limit['v1'].'">'.$def_limit['v1'].'</option>
						</optgroup>
						<optgroup label="Choose a limit:">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>5</option>
						<option>10</option>
						<option>15</option>
						<option>20</option>
						<option>30</option>
						<option>50</option>
						<option>100</option>
						<option>200</option>
						<option>500</option>
						<option>1000</option>
						</optgroup>
					</select>
					<br />
				<label for="def_order">Article order</label>
					<select name="def_order">
						<optgroup label="Selected:">
						<option selected="selected" value="'.$def_order['v1'].'">'.$def_order_display.'</option>
						</optgroup>
						<optgroup label="Choose an order:">
						<option value="asc">Ascending</option>
						<option value="desc">Descending</option>
						</optgroup>
					</select>
					</div>
					
				<label for="def_offset">Display offset</label>
					<input type="text" name="def_offset" value="'.$def_offset['v1'].'" style="width: 50px" maxlength="17" />
					<br />
				<label for="def_items_per_page">Items per page</label>
					<input type="text" name="def_items_per_page" value="'.$def_items_per_page['v1'].'" style="width: 50px" maxlength="17" />
					<br />
				<label for="timestamp_format">Date format</label>
					<input type="text" name="timestamp_format" value="'.$timestamp_format['v3'].'" maxlength="1000" /> <br />(<a href="http://us2.php.net/date">date function help</a>)
					<br />
				<div class="alignr">
					<input type="submit" id="submit" value="Save display options" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
	
	} elseif ($do == "comments") { //if comment options
		//define page name and image
		$globalvars['page_name'] = 'comment options';
		$globalvars['page_image'] = 'preferences';
		
			if ($_GET['action'] == "update") {
				change_config('def_comlimit',$_POST['def_comlimit']);
				change_config('def_comorder',$_POST['def_comorder']);
				change_config('def_comenabled',$_POST['def_comenabled']);
				
				$error_message = '<div class="success">Your preferences have been saved.</div>';
				
				//log the change
				log_this('comment_config','User <i>'.$_SESSION['username'].'</i> has <strong>edited</strong> the default comment options');
			}
		
		//generate gconfig values
		$def_comlimit = load_config('def_comlimit');
		$def_comorder = load_config('def_comorder');
		$def_comenabled = load_config('def_comenabled');
		
		if ($def_comorder['v1'] == "desc") {
				$def_comorder_display = "Descending";
			} elseif ($def_comorder['v1'] == "asc") {
				$def_comorder_display = "Ascending";
			}
			
		if ($def_comenabled['v1'] == 0) {
				$def_comenabled_display = "No";
			} elseif ($def_comenabled['v1'] == 1) {
				$def_comenabled_display = "Yes";
			}
		
		$content = '
			'.$error_message.'
		<h3>Display options</h3>
		<div class="form">
			<form action="preferences.php?do=comments&amp;action=update" method="post">
				<div id="columnright">
				<br />
				<label for="def_comlimit">Character Limit</label>
					<select name="def_comlimit">
						<optgroup label="Selected:">
						<option selected="selected" value="'.$def_comlimit['v3'].'">'.$def_comlimit['v3'].'</option>
						</optgroup>
						<optgroup label="Choose a limit:">
						<option>50</option>
						<option>100</option>
						<option>200</option>
						<option>300</option>
						<option>500</option>
						<option>750</option>
						<option>1000</option>
						<option>1050</option>
						<option>1100</option>
						<option>1200</option>
						<option>1500</option>
						<option>2000</option>
						<option>5000</option>
						<option>10000</option>
						<option>100000</option>
						</optgroup>
					</select>
					<br />
				
					</div>
					
				<label for="def_comenabled">Comments active</label>
					<select name="def_comenabled">
						<optgroup label="Selected:">
							<option selected="selected" value="'.$def_comenabled['v1'].'">'.$def_comenabled_display.'</option>
						</optgroup>
						<optgroup label="Active:">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</optgroup>
					</select>
					<br />
				<label for="def_comorder">Comment order</label>
					<select name="def_comorder">
						<optgroup label="Selected:">
							<option selected="selected" value="'.$def_comorder['v1'].'">'.$def_comorder_display.'</option>
						</optgroup>
						<optgroup label="Choose an order:">
						<option value="asc">Ascending</option>
						<option value="desc">Descending</option>
						</optgroup>
					</select>
					<br />
				<div class="alignr">
					<input type="submit" id="submit" value="Save comment options" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
		
	//} elseif ($do == "filter") { //if filter management
	//	$globalvars['page_name'] = 'filter management';
	//	$globalvars['page_image'] = 'preferences';
	//	
	//	$content = '
	//	<h3>New filter</h3>
	//	<form method="post" action="?do=filter&action=new">
	//		<p>Replace <input type="text" name="filter_trigger" /> with:</p>
	//		<textarea name="filter_replace"></textarea>
	//	</form>
		
	//	<h3>Active filters</h3>';
	} elseif ($do == "feed") { //if rss/atom
		$globalvars['page_name'] = 'rss/atom management';
		$globalvars['page_image'] = 'preferences'; //set preferences image
			if ($_GET['action'] == "update") {
				change_config('def_rsslimit',$_POST['def_rsslimit']);
				change_config('def_rssorder',$_POST['def_rssorder']);
				change_config('def_rsstitle',$_POST['def_rsstitle']);
				change_config('def_rssdesc',$_POST['def_rssdesc']);
				change_config('def_rssenabled',$_POST['def_rssenabled']);
				
				$error_message = '<div class="success">Your preferences have been saved.</div>';
				
				//log the change
				log_this('rss_config','User <i>'.$_SESSION['username'].'</i> has <strong>edited</strong> the default rss options');
			}
		
		//generate gconfig values
		$def_rsslimit = load_config('def_rsslimit');
		$def_rssorder = load_config('def_rssorder');
		$def_rssenabled = load_config('def_rssenabled');
		$def_rsstitle = load_config('def_rsstitle');
		$def_rssdesc = load_config('def_rssdesc');
		
		if ($def_rssorder['v1'] == "desc") {
				$def_rssorder_display = "Descending";
			} elseif ($def_rssorder['v1'] == "asc") {
				$def_rssorder_display = "Ascending";
			}
			
		if ($def_rssenabled['v1'] == 0) {
				$def_rssenabled_display = "No";
			} elseif ($def_rssenabled['v1'] == 1) {
				$def_rssenabled_display = "Yes";
			}
		
		$content = '
			'.$error_message.'
		<h3>Display options</h3>
		<div class="form">
			<form action="preferences.php?do=feed&amp;action=update" method="post">
				<div id="columnright">
				<br />
				<label for="def_rsslimit">Feed item limit</label>
					<select name="def_rsslimit">
						<optgroup label="Selected:">
						<option selected="selected" value="'.$def_rsslimit['v3'].'">'.$def_rsslimit['v3'].'</option>
						</optgroup>
						<optgroup label="Choose a limit:">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>5</option>
						<option>7</option>
						<option>10</option>
						<option>15</option>
						<option>20</option>
						<option>25</option>
						<option>30</option>
						<option>50</option>
						<option>75</option>
						<option>100</option>
						<option>150</option>
						<option>200</option>
						<option>500</option>
						<option>1000</option>
						<option>10000</option>
						<option>100000</option>
						</optgroup>
					</select>
					<br />
					
					<label for="def_rssorder">Feed order</label>
					<select name="def_rssorder">
						<optgroup label="Selected:">
							<option selected="selected" value="'.$def_rssorder['v1'].'">'.$def_rssorder_display.'</option>
						</optgroup>
						<optgroup label="Choose an order:">
						<option value="asc">Ascending</option>
						<option value="desc">Descending</option>
						</optgroup>
					</select>
					<br />
				
					</div>
					
				<label for="def_rssenabled">Feed online</label>
					<select name="def_rssenabled">
						<optgroup label="Selected:">
							<option selected="selected" value="'.$def_rssenabled['v1'].'">'.$def_rssenabled_display.'</option>
						</optgroup>
						<optgroup label="Active:">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</optgroup>
					</select>
					<br />
				<label for="def_rsstitle">Feed title</label>
					<input type="text" name="def_rsstitle" value="'.$def_rsstitle['v3'].'" maxlength="1000" />
					<br />
				<label for="def_rssdesc">Feed description</label>
					<input type="text" name="def_rssdesc" value="'.$def_rssdesc['v3'].'" maxlength="1000" />
					<br />
				<div class="alignr">
					<input type="submit" id="submit" value="Save feed options" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
		
	} elseif ($do == "freeze") { //freeze/cache management
		//define name and image
		$globalvars['page_name'] = 'freeze management';
		$globalvars['page_image'] = 'preferences'; //set preferences image
		
		$action = $_GET['action'];
		
		if ($action == "p") {
			//if the integration code has any illegal chars, stop. This means anything that could be used for malicious ways
			if (strstr($_POST['integration_code'], '(') || strstr($_POST['integration_code'], '{') || strstr($_POST['integration_code'], 'echo') || strstr($_POST['integration_code'], 'globalvars') || strstr($_POST['integration_code'], 'databaseinfo') || strstr($_POST['integration_code'], '$_')) {
				$success .= '<div class="warning">Only pre-include variables may be used!</div>';
			} else {
				ob_start(); //start output buffering to gather phpns articles into a var
			
					eval(stripslashes($_POST['integration_code']));
				
					$phpns['always_show_full_story'] = TRUE;
					$phpns['static'] = TRUE;
					include("shownews.php");
				$freeze_articles = ob_get_contents(); //get contents
				ob_end_clean(); //kill buffer
			}
			
			if ($freeze_articles) {
				$rand_file_token = md5(uniqid(rand(), true)); //generate unique id token for file creation
				
				if ($freeze_open = @fopen("inc/freeze/freeze.".$rand_file_token.".php",'w')) { //if file is created...
					fwrite($freeze_open, $freeze_articles);
					
					//generate include path
					$path_to = $_SERVER['SCRIPT_FILENAME'];
					$path_to = str_replace("preferences.php","inc/freeze/freeze.".$rand_file_token.".php",$path_to);
					
					$success = '
						<div class="success">Phpns created the freeze file successfully!</div>
						<h3>Freeze code</h3>
						<p>Your freeze code was successfully created. <strong>To activate the freeze, you need to add the following pre-include variable to your phpns instance!</strong></p>
						
						<textarea style="height: 50px;" readonly="readonly">$phpns[\'freeze_file\'] = "'.$path_to.'";</textarea>';
				} else {
					$warning .= '<div class="warning">Phpns could not create the freeze file (inc/freeze'.$rand_file_token.'.php). Make sure phpns has permission to write to the /inc/ directory!</div>';
				}
			} else {
				$warning .= '<div class="warning">Phpns could not generate the articles to be written to freeze file. Probably mal-formed integration code.</div>';
			}
		}
		
		//form the content for template
		$content = '
			'.$warning.'
			'.$success.'
			<h3>Integration code (pre-include variables):</h3>
			<form action="preferences.php?do=freeze&amp;action=p" method="post">
				<p>In this step, you may want to paste the pre-include variables you are using for the desired static phpns instance. This can be left blank if you want a default instance of phpns. Do not use &lt;?php or ?&gt;.</p>
				<textarea name="integration_code" style="height: 120px;"></textarea>
				<div class="warning">Pagination will not work with the freeze feature; only page 1 will be generated. Also, the full story will be included immediately below the main article.</div>
			
				<div class="alignr">
					<input type="submit" id="submit" value="Continue freeze instance" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
			';
	
	} elseif ($do == "templates") {
		//define page name & default image
		$globalvars['page_name'] = 'templates';
		$globalvars['page_image'] = 'preferences'; //set preferences image
		$action = $_GET['action'];
		
			if ($action == "switch") {  //switch default template
				$sw_id = $_POST['select'];
				
				if (switch_template($sw_id)) {
					$message = '<div class="success">The template you selected is now the default template.</div>';
				} else {
					$message = '<div class="warning">There was an error switching the template.</div>';
				}
				unset($action);
			}
		
		if (!$action) {
			//we're going to fetch all the available templates.
			$tres = general_query('SELECT * FROM '.$databaseinfo['prefix'].'templates'); //execute tsql
			
				while ($trow = mysql_fetch_assoc($tres)) { //get arrays
					$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
					$trow['timestamp'] = date($globalvars['time_format'],$trow['timestamp']);
						if ($trow['template_selected'] == TRUE) { //set the radio button to checked if it's currently selected
							$trow['template_selected'] = 'checked="checked"';
						}
						
					if ($trow['template_desc'] == NULL) { //if no reason set, we need to set to N/A
						$trow['template_desc'] = '<em>N/A</em>';
					}
					
					$template_rows .= '
					<tr bgcolor="'.$row_bg.'">
						<td><strong>'.$trow['id'].'</strong></td>
						<td>
							<a href="javascript:if(confirm(\'Are you sure you want to delete this template?\')) top.location=\'preferences.php?do=templates&amp;action=delete&amp;tid='.$trow['id'].'\'"><img src="images/icons/delete.png" class="row_icon" alt="delete icon" title="delete &quot;'.$trow['template_name'].'&quot;" /></a>
							<a href="preferences.php?do=templates&amp;action=edit&amp;tid='.$trow['id'].'"><img src="images/icons/edit.png" class="row_icon" alt="edit icon" title="edit &quot;'.$trow['template_name'].'&quot;" /></a>
							<strong><a href="preferences.php?do=templates&amp;action=edit&amp;tid='.$trow['id'].'">'.$trow['template_name'].'</a></strong></td>
						<td>'.$trow['template_desc'].'</td>
						<td>'.$trow['template_author'].'</td>
						<td>'.$trow['timestamp'].'</td>
						<td><input type="radio" name="select" value="'.$trow['id'].'" '.$trow['template_selected'].' /></td>
					</tr>';
				}
				
			if ($_GET['delete_success']) {
				$success .= '<div class="success">The item(s) have been successfully deleted.</div>';
			}
			
			if ($_GET['create_success']) {
				$success .= '<div class="success">The template has been succesfully created.</div>';
			}
			
			$content = '
			'.$message.'
			'.$success.'
			<h3>Options</h3>
			<ul>
				<li><strong><a href="preferences.php?do=templates&amp;action=new">create new template</a></strong></li>
			</ul>
			<h3>Template list</h3>
			<form action="preferences.php?do=templates&amp;action=switch" method="post">
				<table style="text-align: left; width: 100%;" border="1"
					 cellpadding="3" cellspacing="2">
					  <tbody>
					    <tr class="toprow">
					    	<td style="width: 10px"><strong>ID</td>
					      <td style="width: 200px;"><strong>Name</strong></td>
					      <td><strong>Description</strong></td>
					      <td style=""><strong>Author</strong></td>
					      <td><strong>Date</strong></td>
					      <td style="width: 10px"><strong>Active</strong></td>
					    </tr>
					    '.$template_rows.'
				</table>
				<div class="alignr">
					<input type="submit" id="submit" value="Switch template" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
			';
		} elseif ($action == "new") {
		
			$content = template_form();
			
		} elseif ($action == "newp") { //create new template process
			$data = $_POST;
			$continue = TRUE; //set continue var
				if ($data['template_name'] == "") {
					$continue = FALSE;
					$error_message = '<div class="warning">You must enter a title for this template before continuing.</div>';
				}
			
			if ($continue == TRUE) {
				//create template
				$res = new_template($data,$_SESSION['username']);
				//redirect to templates
				header("Location: preferences.php?do=templates&create_success=1");
			} else {
				$globalvars['page_name'] == 'templates';
				$globalvars['page_image'] == 'error';
				
				$content = template_form();
			}
		} elseif ($action == "edit") { //if editing a template
			$tid = $_GET['tid'];
			$tres = general_query('SELECT * FROM '.$databaseinfo['prefix'].'templates WHERE id='.$tid.'',1); //execute tsql
			$content = template_form($tres);
		} elseif ($action == "editp") {
			$data = $_POST;
			$continue = TRUE; //set continue var
				if ($data['template_name'] == NULL) {
					$continue = FALSE;
					$error_message = '<div class="warning">You must enter a title for this template before continuing.</div>';
				}
			
			if ($continue == TRUE) {
				$globalvars['page_name'] = "templates";
				$globalvars['page_image'] = "success";
				//give $data post vars
				$res = edit_template($data,$_SESSION['username']);
				
				//get template id
				$tid = $_POST['id'];
				
				//after the edit, redisplay form with edited values
				$tres = general_query('SELECT * FROM '.$databaseinfo['prefix'].'templates WHERE id='.$tid.'',1); //execute tsql
				$content = template_form($tres);
			} else {
				$globalvars['page_name'] == 'templates';
				$globalvars['page_image'] == 'error';
				
				$content = template_form($data);
			}
		} elseif ($action == "delete") {
			//get tid and delete from db
			$tid = clean_data($_GET['tid']);
			$dres = general_query('DELETE FROM '.$databaseinfo['prefix'].'templates WHERE id='.$tid.''); //execute tsql
			//redirect to templates
			header("Location: preferences.php?do=templates&delete_success=1");
		}
	} elseif ($do == "sef") { //search engine friendly urls page
		$globalvars['page_name'] = 'search engine friendly urls';
		$globalvars['page_image'] = "preferences";
		
		//edited out by alecwh: .htaccess is not necessary in the /phpns/ directory..., so it's not necessary to check for one.
		// if(is_file('.htaccess') ? $fileaccess = @file_get_contents(".htaccess") : $fileaccess = 'There is currently no .htaccess file, please make one!' );
		$content = '
		<p>The suggested .htaccess file:
				<textarea class="code"># .htaccess file for SEF URLs
# SEF URL .htaccess file. PLACE THIS FILE WHEREVER YOUR NEWS IS BEING INCLUDED.

	<IfModule mod_rewrite.c> 
		RewriteEngine on
		RewriteCond %{SCRIPT_FILENAME} !-d
		RewriteCond %{SCRIPT_FILENAME} !-f
		RewriteRule ^(.*)$ index.php?a=$1 [QSA]
	</IfModule></textarea>
			<p>Place this \'.htaccess\' file wherever your news is being displayed on your website. This is usually the root of your website, \'/\'. You may also change the \'index.php\' reference to whatever file phpns displays news in.</p>
			<p>The .htaccess file is not required for phpns to generate SEF URLs. You can activate using the $phpns[\'sef_override\'] pre-include variable to activate.</p>

		';
	} elseif ($do == "ban") { //if ban page
		$globalvars['page_name'] = "ban options";
		$globalvars['page_image'] = "preferences";
		
		if ($_GET['action'] == 'newp') { //if the action is new process
			$data = $_POST; //assign post to $data
			clean_data($data['reason']); //clean
			
			//if ip is empty or in an incorrect form, display error
			if (!$data['ip'] || !preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $data['ip'])) {
				$error_message = '<div class="warning">Please make sure the IP address is in correct form, or is not blank.</div>';
			} else {
				ban($data,$_SESSION['username']); //ban.
				
				//success message
				$success = '<div class="success">The IP address has been banned.</div>';
			}
		} elseif ($_GET['action'] == "delete") { //if we're deleting banned ip addresses
			$items = $_POST; //get vars
			foreach($items as $key=>$value) { //create list of ids to be deleted
				$items_f = $items_f."'$value',";
			}
			$items_f = substr_replace($items_f,"",-1); //remove last comma in list for SQL
			$res = general_query('DELETE FROM '.$databaseinfo['prefix'].'banlist WHERE id IN ('.$items_f.')'); //delete query
			//success message
			$success .= '<div class="success">The selected ban(s) have been lifted.</div>';
			
			//log the change
			log_this('lift_ban','User <i>'.$_SESSION['username'].'</i> has <strong>lifted bans</strong> for the following ids: '.$items_f.'');

		}

			//fetch banned ips
			$bres = general_query('SELECT * FROM '.$databaseinfo['prefix'].'banlist'); //fetch query
			while ($brow = mysql_fetch_assoc($bres)) { //get arrays
					$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
					$brow['timestamp'] = date($globalvars['time_format'],$brow['timestamp']);
					
					if ($brow['reason'] == NULL) { //if no reason set, we need to set to N/A
						$brow['reason'] = '<em>N/A</em>';
					}
					
					$ip_rows .= '
					<tr bgcolor="'.$row_bg.'">
						<td><strong><a href="http://'.$brow['ip'].'">'.$brow['ip'].'</a></strong></td>
						<td>'.$brow['reason'].'</td>
						<td>'.$brow['banned_by'].'</td>
						<td>'.$brow['timestamp'].'</td>
						<td><input type="checkbox" value="'.$brow['id'].'" name="'.$brow['id'].'" /></td>
					</tr>';
				}
				
			if (mysql_num_rows($bres) == 0) {
				$ip_rows = '<td class="noresults" colspan="5"><strong>No returned results...</strong></td>';
			}
			
		$content = '
		'.$error_message.'
		'.$success.'
		<h3>Ban an IP</h3>
			<form action="?do=ban&amp;action=newp" method="post" class="form">
				<label for="ip">IP address:</label> <input class="extended" type="text" name="ip" value="'.$_GET['ip'].'" maxlength="15" />	<input type="submit" id="submit" value="Ban this IP" onclick="javascript:document.getElementById(\'submit\').disabled=true" /><br />
				<label for="reason">Reason for ban*:</label> <input type="text" class="extended" name="reason" maxlength="5000" />
			</form>
		<h3>Ban list</h3>
			<form action="preferences.php?do=ban&amp;action=delete" method="post">
				<table style="text-align: left; width: 100%;" border="1"
					 cellpadding="3" cellspacing="2">
					  <tbody>
					    <tr class="toprow">
					      <td style="text-align: left;"><strong>IP</strong></td>
					      <td><strong>Reason for ban</strong></td>
					      <td style=""><strong>Banned by</strong></td>
					      <td><strong>Date of ban</strong></td>
					      <td style="width: 10px; text-align: center;"><strong><input type="checkbox" onClick="Checkall(this.form);" /></strong></td>
					    </tr>
					    '.$ip_rows.'
				</table>
				<div class="alignr">
					<input type="submit" id="submit" value="Lift selected bans" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
			';
		
	} elseif ($do == "wizard") {
		$globalvars['page_name'] = "integration wizard";
		$globalvars['page_image'] = "preferences";
		
			if ($_GET['action'] == "p") {
				//definitions based on what was submitted
				
				$generate['category'] = ($_POST['category']) ? ("\n\t".'$phpns[\'category\'] = \''.join($_POST['category'], ',').'\';') : ('');
				
				$generate['rss'] = ($_POST['rss']) ? ('$phpns[\'mode\'] = \'rss\';') : ('');
				$generate['limit'] = ($_POST['display_limit']) ? ("\n\t".'$phpns[\'limit\'] = \''.$_POST['display_limit'].'\';') : ('');
				$generate['template'] = ($_POST['template']) ? ("\n\t".'$phpns[\'template\'] = \''.$_POST['template'].'\';') : ('');
				$generate['order'] = ($_POST['order']) ? ("\n\t".'$phpns[\'order\'] = \''.$_POST['order'].'\';') : ('');
				$generate['offset'] = ($_POST['offset']) ? ("\n\t".'$phpns[\'offset\'] = \''.$_POST['offset'].'\';') : ('');
				$generate['script_path'] = ($_POST['script_path']) ? ("\n\t".'$phpns[\'script_path\'] = \''.$_POST['script_path'].'\';') : ('');
				$generate['disable_pagination'] = ($_POST['disable_pagination']) ? ("\n\t".'$phpns[\'disable_pagination\'] = \''.$_POST['disable_pagination'].'\';') : ('');
				$generate['items_per_page'] = ($_POST['items_per_page']) ? ("\n\t".'$phpns[\'items_per_page\'] = \''.$_POST['items_per_page'].'\';') : ('');
				$generate['sef'] = ($_POST['sef']) ? ("\n\t".'$phpns[\'sef\'] = \''.$_POST['sef'].'\';') : ('');
				$generate['override_comments'] = ($_POST['override_comments']) ? ("\n\t".'$phpns[\'override_comments\'] = \''.$_POST['override_comments'].'\';') : ('');
				$generate['static'] = ($_POST['static']) ? ("\n\t".'$phpns[\'static\'] = \''.$_POST['static'].'\';') : ('');
				$generate['always_show_extended_article'] = ($_POST['always_show_extended_article']) ? ("\n\t".'$phpns[\'always_show_extended_article\'] = \''.$_POST['always_show_extended_article'].'\';') : ('');
				$generate['disable_extended_article'] = ($_POST['disable_extended_article']) ? ("\n\t".'$phpns[\'disable_extended_article\'] = \''.$_POST['disable_extended_article'].'\';') : ('');
				
				//generate include path
				$path_to = $_SERVER['SCRIPT_FILENAME'];
				$path_to = str_replace("preferences.php","shownews.php",$path_to);

				$content .= '
				<h3>Generated code</h3>
				<p><strong>Your include code was successfully generated. Simply paste the following code wherever you want your news displayed:</strong></p>
				<textarea readonly="readonly" class="code" style="height: 120px">
<?php
/*
	This file is used to generate articles managed by the phpns system. 
	Place this code wherever you want your articles displayed on your 
	website. The page that this code is placed in should have a .php
	extension.
*/
'.$generate['rss'].''.$generate['category'].''.$generate['limit'].''.$generate['template'].''.$generate['order'].''.$generate['offset'].''.$generate['script_path'].''.$generate['disable_pagination'].''.$generate['items_per_page'].''.$generate['sef'].''.$generate['override_comments'].''.$generate['static'].''.$generate['always_show_extended_article'].''.$generate['disable_extended_article'].'
	
	//after variable declaration(s), include shownews.php
	include("'.$path_to.'");
?>
</textarea>';
			}
		
		$data['cat_list'] = gen_categories('option','');
		$data['template_list'] = gen_templates();
		
		//integration wizard form
		$content .= '
		<h3>Display configuration</h3>
		<div class="form">
			<form action="?do=wizard&amp;action=p" method="post">
				<div id="columnright">
					<br />
					<label for="category">Category</label>
						<select name="category[]" id="category" multiple="multiple" size="10">
							<option value="0">All categories</option>
							<optgroup label="Categories">
								'.$data['cat_list'].'
							</optgroup>
						</select>
						<br />
				</div>
					<label for="template">Template</label>
					<select name="template" id="template">
						<optgroup label="Select...">
							<option value="">Default</option>
						</optgroup>
						<optgroup label="Templates">
							'.$data['template_list'].'
						</optgroup>
					</select>
					<br />
					
					<label for="order">Order</label>
					<select name="order" id="order">
						<optgroup label="Select...">
							<option value="">Default</option>
							<option value="desc">Descending</option>
							<option value="asc">Ascending</option>
						</optgroup>
					</select><br />
					
					<label for="display_limit">Display limit</label>
					<input type="text" name="display_limit" id="display_limit" value="" /> (numeric, default if blank)<br />	
					<label for="offset">Offset</label>
					<input type="text" name="offset" id="offset" value="" /> (numeric, default if blank) <br />
					<label for="script_path">Script path</label>
						<input type="text" name="script_path" id="script_path" value="" /> (script where articles will be linked to, before <code>?a=xx</code>)<br />
					
					<h4>Pagination settings (<a href="javascript:expand(\'pagination_options\');">expand/collapse</a>)</h4>	
					<div id="pagination_options" class="advanced" style="display: none;">
						<label for="disable_pagination">Disable pagination</label> <input type="checkbox" value="1" name="disable_pagination" id="disable_pagination" /><br /><br />
						
						<label for="items_per_page">Items Per Page</label>
						<input type="text" name="items_per_page" id="items_per_page" value="" /> (numeric, 1 - 9999, or blank for default)<br />
					</div>
					
					<h4>Advanced (<a href="javascript:expand(\'advanced\');">expand/collapse</a>)</h4>	
					<div id="advanced" class="advanced" style="display: none;">
						<label for="sef">SEF URL path</label> 
						<input type="text" name="sef" id="sef" value="" /> (path for SEF URLs. The default is "/")<br />
						
						<label for="override_comments" class="nofloat"><input type="checkbox" value="1" name="override_comments" id="override_comments" /> Override Comments</label><br /><br />
						
						<label for="static" class="nofloat"><input type="checkbox" value="1" name="static" id="static" /> Static display</label><br /><br />
						<label for="always_show_extended_article" class="nofloat"><input type="checkbox" value="1" name="always_show_extended_article" id="always_show_extended_article" /> Always show extended article</label><br /><br />
						<label for="disable_extended_article" class="nofloat"><input type="checkbox" value="1" name="disable_extended_article" id="disable_extended_article" />Always disable (hide) extended article</label><br /><br />
						
					</div>
			<div class="alignr">
				<input type="submit" id="submit" value="Generate code" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
			</div>
			</form>
		</div>
		';
	
	} elseif ($do == "syslog") {
		$globalvars['page_name'] = "system log";
		$globalvars['page_image'] = "preferences";
		//determine pagintation variables and sorting
			$page = $_GET['page'];
			if (!$page) {
				$page = 1;
			}
			$items_per_page = 20;
			$page_start = ($page*$items_per_page) - $items_per_page;
			$next_page = $page + 1;
			$prev_page = $page - 1;
				//get sorting info and view
				$sort = $_GET['sort'];
				$v = $_GET['v']; 
		//END OF PAGINATION/SORTING
		
		$content = log_form();
	
	} elseif ($do == "backup") {
		$globalvars['page_name'] = "database backup";
		$globalvars['page_image'] = "preferences";
		
		if ($_GET['action'] == "backup") {
			
			//mysqldump -u alecwh --password=alecwh phpns2 > database.sql
			exec('mysqldump -u '.$databaseinfo['user'].' --password='.$databaseinfo['password'].' '.$databaseinfo['dbname'].' > '.$databaseinfo['dbname'].'.sql');
			
			//log the change
				log_this('backup_db','User <i>'.$_SESSION['username'].'</i> has <strong>backed up</strong> the system database.');
				
				//define filepaths and determine future gz file
				$file = $databaseinfo['dbname'].'.sql'; //the current dump
				// $file = file_get_contents($file);
  				/*
  					COMPRESSION FOR FILE, COMMENTED OUT UNTIL WE CAN SOLIDIFY THE PROCESS.
	  				//encode and write to file process
	  				$data = implode("", file($file));
					$gzdata = gzuncompress($data, 9); //encrypt to .gz, most compression possible (9)
					$fp = fopen($gz_file_to_produce, "w"); //open to write
					fwrite($fp, $gzdata); //write
					fclose($fp); //close
					
					> <meta http-equiv="content-type","application/download">
> <meta http-equiv="content-type","application/force-download">
> <meta http-equiv="content-type","application/octet-stream">
> <meta http-equiv="content-disposition","attachment; filename=list.txt">[/color]
				*/
					
					//redirect to etc for actual header info
					header("Location: etc.php?do=backup");
					
		} elseif ($_GET['action'] == "restore") { //if we're restoring the data
			//action for uploaded file, for db restore
			$target_path = basename($_FILES['file']['name']); 
			if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
				//the file has been uploaded, now we deal wtih manipulation.
				//de-gz the file
				//THIS WAS THE PROBLEM with .gz compression, the decompression was not widely supported. Maybe support in the future, but for now, we're not dealing with it.
				//execute and dump data
				exec('mysql -u '.$databaseinfo['user'].' --password='.$databaseinfo['password'].' '.$databaseinfo['dbname'].' < '.$target_path.'');
			} else {
				//log the change
				log_this('backup_restore','User <i>'.$_SESSION['username'].'</i> has <strong>restored</strong> a previous phpns database.');
				$error_message .= '<div class="warning">There was an error uploading the file.</div>';
			}
		}
		
			if ($_GET['success'] == 'no') {
				$output = '<div class="warning">Phpns could not create the database file. This is usually a problem with file permissions; make sure phpns can create files in this directory.</div>';
			}
		
		$content .= '
		'.$output.'
		<h3>Create backup</h3>
		<p>Once you click the button below, phpns will create a backup of the whole phpns database, and then compress to .sql when available.</p>
		<div id="button_container">
			<button class="backup" OnClick="window.location = \'?do=backup&amp;action=backup\';"><strong>Click here to backup the phpns database</strong></button>
		</div>
		
		<h3>Restore backup</h3>
		<p>Please browse to the backup file earlier created.</p>
		<form enctype="multipart/form-data" action="?do=backup&amp;action=restore" method="post" onsubmit="return confirm(\'Are you sure you want to restore this backup?\n\nThis will erase your database schema, and delete any articles/categories/users/settings that are not included in the backup.\');" >
			<label for="file">Select .sql file</label> <input name="file" type="file" /><br />
			<div class="alignr">
				<input type="submit" value="Restore backup" id="submit" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
			</div>
		</form>
		
		';
	
	
	} elseif ($do == "images") {
		$globalvars['page_name'] = "image uploads and settings";
		$globalvars['page_image'] = "preferences";
	
	
	} elseif ($do == "themes") { //if themes
		//define page name & default image
		$globalvars['page_name'] = 'themes';
		$globalvars['page_image'] = 'preferences'; //set preferences image
		$action = $_GET['action'];
		$path = $_POST['path'];
			if ($action == "switch" && $path != "") {  //if theme switch is underway....
				
				$theme_path = 'themes/'.$path.'/';  //construct filepath
				$themeinfo = simplexml_load_file('themes/'.$path.'/theme.xml');
				$timestamp = time();
				
				//first, we're going to delete previous theme selection(s). There should only ever be one.
				$sql_del = general_query('DELETE FROM '.$databaseinfo['prefix'].'themes');
				
				$res = general_query("INSERT INTO ".$databaseinfo['prefix']."themes 
				(theme_name,theme_author,theme_dir,base_dir,timestamp,theme_selected) VALUES (
				 '".$themeinfo->name."',
				 '".$themeinfo->author."',
				 '".$theme_path."',
				 '".$path."',
				 '".$timestamp."',
				 1)
				 "); //form query and execute
				//log the change
				log_this('change_theme','User <i>'.$_SESSION['username'].'</i> has <strong>changed</strong> the default system theme.');
				$content = '<div class="success">The theme has been saved.</div>';
			}
		
		$scanlisting = scandir("themes/");
		$dirlisting = array();
		foreach($scanlisting as $key => $value) {
			if (is_dir("themes/$value") == true && $value != '.' && $value != '..') {
				$dirlisting[] = $value;
			}
		}
		$themelist = '
		<form action="preferences.php?do=themes&action=switch" method="post">
			<table style="text-align: left; width: 100%;" border="1"
				 cellpadding="3" cellspacing="2">
				  <tbody>
				    <tr class="toprow">
				      <td style="width: 100px"><strong>Preview</strong></td>
				      <td style="width: 150px; text-align: left;"><strong>Name</strong></td>
				      <td style="width: 150px;"><strong>Author</strong></td>
				      <td><strong>Description</strong></td>
				      <td style="width: 10px"><strong>Active</strong></td>
				    </tr>';	
		foreach($dirlisting as $key => $value) {
			if (is_file("themes/$value/theme.xml")) {
				$themeinfo = simplexml_load_file('themes/'.$value.'/theme.xml');
				
				//sql to fetch current theme, so we can have the theme selected
				$stheme = general_query('SELECT * FROM '.$databaseinfo['prefix'].'themes WHERE theme_selected=1', TRUE);
				
				//radio button. selected or not?
				
				if ("$themeinfo->name" == $stheme['theme_name']) {
					$radio = '<td><input type="radio" id="path" name="path" value="'.$value.'" checked="checked" /></td>';
				} else {
					$radio = '<td><input type="radio" id="path" name="path" value="'.$value.'" /></td>';
				}
				
				$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
				
				$themelist = $themelist.'    
				<tr bgcolor="'.$row_bg.'">
					<td><img src="themes/'.$value.'/preview.png" alt="preview" /></td>
				 	<td valign="top"><strong>'."$themeinfo->name".'</strong></td>
					<td valign="top"><a href="'."$themeinfo->website".'"> '."$themeinfo->author".' </a></td>
					<td valign="top">'."$themeinfo->description".'</td>
					'.$radio.'
				</tr>';
			}
		}
		$themelist = $themelist.'
		   </tbody>
		</table>
		<div class="alignr">
			<input type="submit" id="submit" value="Switch and Save" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
		</div>
	</form>';
		
		//compile content for themes
		$content .= 
		'<h3>Detected themes (in the /themes directory)</h3>
		'.$themelist.'
		';
	} elseif ($do == "wysiwyg") {
		$globalvars['page_name'] = "wysiwyg options";
		$globalvars['page_image'] = "preferences";
			if ($_GET['action'] == 'update') {
				change_config('wysiwyg',$_POST['wysiwyg']);
				$message = "<div class=\"success\">The wysiwyg editor has been changed to '".$_POST['wysiwyg']."'</div>";
				//log the change
				log_this('wysiwyg_options','User <i>'.$_SESSION['username'].'</i> has <strong>disabled/enabled</strong> the wysiwyg editor');
			}
			
		$wysiwyg = load_config('wysiwyg');
		
		$content = '
		'.$message.'
		<h3>wysiwyg</h3>
		<div class="form">
			<form action="preferences.php?do=wysiwyg&action=update" method="post">
				<label for="wysiwyg">Enabled</label>
					<select name="wysiwyg" id="wysiwyg">
						<optgroup label="Selected:">
							<option value="'.$wysiwyg['v1'].'">'.$wysiwyg['v1'].'</option>
						<optgroup label="Select...">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</optgroup>
					</select><br />
					<p>*The WYSIWYG editor can be disabled/enabled by clicking "Toggle WYSIWYG" next to textareas ONLY if the editor is active.</p>
					<p>Phpns currently uses the <a href="http://tinymce.moxiecode.com">TinyMCE</a> wysiwyg textarea application, licensed under the <a href="inc/wysiwyg/license.txt">LGPL</a>. We also use the <a href="http://codepress.org/">codepress</a> code editor for template management. Thanks to these guys for awesome projects!</p>
				<div class="alignr">
					<input type="submit" id="submit" value="Save" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
		
	} elseif ($do == "timestamp") {
		$globalvars['page_name'] = "system timestamp format";
		$globalvars['page_image'] = "preferences";
			if ($_GET['action'] == 'update') {
				change_config('sys_time_format',$_POST['sys_time_format']);
				$message = "<div class=\"success\">The system timestamp format has been changed to '".$_POST['sys_time_format']."'</div>";
				//log the change
				log_this('system_timestamp','User <i>'.$_SESSION['username'].'</i> has <strong>modified</strong> the default system timestamp format to "'.$_POST['sys_time_format'].'"');
			}
			
		$sys_time_format = load_config('sys_time_format');
		
		$content = '
		<h3>system timestamp format</h3>
		'.$message.'
		<p>phpns uses the date(); function for formatting the system time. You can find a manual on the function at the <a href="http://php.net/date">php website</a>.</p>
		<div class="form">
			<form action="preferences.php?do=timestamp&action=update" method="post">
				<label for="format">Format</label>
					<input type="text" name="sys_time_format" id="format" value="'.$sys_time_format['v1'].'" maxlength="17" /><br />
				<div class="alignr">
					<input type="submit" id="submit" value="Save" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
	
	} elseif ($do == "line") {
		$globalvars['page_name'] = "online/offline options";
		$globalvars['page_image'] = "preferences";
			if ($_GET['action'] == 'update') {
				change_config('line',$_POST['line']);
				$message = "<div class=\"success\">The online/offline status has been changed to '".$_POST['line']."'</div>";
				
				//log the change
				log_this('site_line','User <i>'.$_SESSION['username'].'</i> has <strong>changed</strong> the online/offline status');
			}
			
		$line = load_config('line');
		
		$content = '
		'.$message.'
		<h3>Line options</h3>
		<div class="form">
			<form action="preferences.php?do=line&action=update" method="post">
				<label for="line">Online:</label>
					<select name="line" id="line">
						<optgroup label="Selected:">
							<option value="'.$line['v1'].'">'.$line['v1'].'</option>
						<optgroup label="Select...">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</optgroup>
					</select><br />
					<div>
						If the above option is set to \'no\' (or \'offline\'), users will <strong>not</strong> be able to view any articles on your website.
					</div>
				<div class="alignr">
					<input type="submit" id="submit" value="Save" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
			</form>
		</div>
		';
	
	} elseif ($do == "globalmessage") {
		$globalvars['page_name'] = "global message";
		$globalvars['page_image'] = "preferences";
		
			if ($_GET['action'] == "update") {
				change_config('global_message',$_POST['message']);
				$error_message = '<div class="success">Your message have been saved.</div>';
				//log the change
				log_this('global_message','User <i>'.$_SESSION['username'].'</i> has <strong>edited</strong> the default global message');
			}
		$global_message = load_config('global_message');
		
		$content = $error_message.'
		<h3>global message</h3>
		<div class="form">
			<form action="preferences.php?do=globalmessage&action=update" method="post">
				<label for="message" class="for_textarea_alt">Message <a href="javascript:togglewysiwyg(\'message\');">wysiwyg on/off</a> <a href="javascript:expandwysiwyg(\'message\');">expand editor</a></label><textarea name="message" id="message">'.$global_message['v3'].'</textarea>
				<br />*If you do not want any message, leave the above field blank.
				<div class="alignr">
					<input type="submit" id="submit" value="Save global message" onclick="javascript:document.getElementById(\'submit\').disabled=true" />
				</div>
				
			</form>
		</div>
		';
	}

include("inc/themecontrol.php");  //include theme script
?>
