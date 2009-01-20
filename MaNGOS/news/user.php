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

	if (!$do) {
	$globalvars['page_name'] = 'user management';
	
	//form query
		$page = $_GET['page'];
			if (!$page) {
				$page = 1;
			}
		$items_per_page = 200;
		$page_start = ($page*$items_per_page) - $items_per_page;
		$next_page = $page + 1;
		$prev_page = $page - 1;
		$item_list = load_items('users',$page_start,$items_per_page,'','','');
		
		if (mysql_num_rows($item_list) == NULL) {
			$table_rows = '<td class="noresults" colspan="6"><strong>No returned results...</strong></td>';
		}
		

		while ($item_row = mysql_fetch_array($item_list)) {
			//convert timestamp to readable/human date
			$item_row['timestamp'] = date($globalvars['time_format'],$item_row['timestamp']);
			$item_row['rank_name'] = gen_rank_name($item_row['rank_id']);
			$usercount_sql = general_query("SELECT * FROM ".$databaseinfo['prefix']."articles WHERE article_author='".$item_row['user_name']."'");
			$num_items =  mysql_num_rows($usercount_sql);
			$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
				
			$table_rows = $table_rows.'
			<tr bgcolor="'.$row_bg.'">
				<td>
					<a href="user.php?id='.$item_row['id'].'&do=edit"><img src="images/icons/edit.png" class="row_icon" alt="edit icon" title="edit &quot;'.$item_row['user_name'].'&quot;" /></a>
					<strong><a href="user.php?id='.$item_row['id'].'&do=edit">'.$item_row['user_name'].'</a></strong>
				</td>
				<td>'.$item_row['full_name'].'</td>
				<td>'.$item_row['timestamp'].'</td>
				<td><a href="?id='.$item_row['rank_id'].'&do=editrank">'.$item_row['rank_name'].'</a></td>
				<td align="center"><a href="manage.php?v='.$item_row['user_name'].'">'.$num_items.'</a></td>
				<td class="checkbox"><input type="checkbox" value="'.$item_row['id'].'" name="'.$item_row['id'].'"></td>
			</tr>
			';
		} //end of WHILE statement
	
	if ($_GET['delete_success'] == 1) {
		$success .= '<div class="success">The user(s) have been successfully deleted.</div>';
	} elseif ($_GET['delete_success'] == "no") {
		$success .= '<div class="warning">The operation was cancelled, you cannot delete the first user (ID: 1), or yourself!</div>';
	}
	
	$content = '
		'.$success.'
		<h3>Actions</h3>
		<div id="columnright">
			
			<ul>
				<li><strong><a href="?do=newrank">new rank</a></strong></li>
				<li><a href="?do=ranks">manage ranks</a></li>
			</ul>
		</div>
		
		<ul>
			<li><strong><a href="?do=new">new user</a></strong></li>
			<li><a href="?do=loginrec">login records</a></li>
			
		</ul>
		
		<h3>User list</h3>
		<form id="useropt" method="post" action="?do=deleteusers" onsubmit="return confirm(\'Are you sure you want to delete the selected items?\');">
		<table style="text-align: left; width: 100%;" border="1"cellpadding="3" cellspacing="2">
			<tbody>
				<tr class="toprow">
					<td><strong>Username</strong></td>
					<td><strong>Full name</strong></td>
					<td><strong>Date</strong></td>
					<td><strong>Rank</strong></td>
					<td style="width: 80px"><strong>#/articles</strong></td>
					<td style="width: 10px; text-align: center;"><strong><input type="checkbox" onClick="Checkall(this.form);" /></strong></td>
				</tr>
				    '.$table_rows.'
			  </tbody>
		</table>
			<div style="text-align: right; width: 400px; float: right;">
				<input type="submit" id="submit" value="Delete Selected" />
			</div>
		</form>
		<div>
			<button class="previous" OnClick="window.location = \'?page='.$prev_page.'\';" />Previous ('.$prev_page.')</button>
			<button class="next" OnClick="window.location = \'?page='.$next_page.'\';" />Next ('.$next_page.')</button>
		</div>';
		
	} elseif ($do == "new") { //if action is new user
		
		if ($globalvars['rank'][18] == 0) {
			header("Location: index.php?do=permissiondenied");	
			die(); //if header doesn't work, kill the script.
		}
		
		$globalvars['page_name'] = "new user";
		$globalvars['page_image'] = "user management";
		$content = user_form();
	} elseif ($do == "newp") { //if process from new user
	
		if ($globalvars['rank'][18] == 0) {
			header("Location: index.php?do=permissiondenied");	
			die(); //if header doesn't work, kill the script.
		}
	
		if(isset($_POST)) {
			//generate vars
			$data['username_'] = $_POST['username_'];
			$data['fullname'] = $_POST['fullname'];
			$data['password_'] = $_POST['password_'];
			$data['cpassword_'] = $_POST['cpassword_'];
			$data['email'] = $_POST['email'];
			$data['msn'] = $_POST['msn'];
			$data['aim'] = $_POST['aim'];
			$data['yahoo'] = $_POST['yahoo'];
			$data['skype'] = $_POST['skype'];
			$data['rank'] = $_POST['rank'];
			$data['notifications'] = $_POST['notifications'];
			
			if (!$data['notifications']) {
				$data['notifications'] = 0;
			}

			foreach($data as $key => $value) {
				//clean data (SQL injection security)
				$data[$key] = clean_data($value);
			}

			$con = "yes";
			$error_message = '<ol class="warning">
			';
			if (!$data['username_']) {  //no username
				$con = "no";
				$error_message = $error_message.'<li>You must enter a username.</li>
				';
			}
			if (!$data['fullname']) { //no fullname
				$con = "no";
				$error_message = $error_message.'<li>You must enter a full name.</li>
				';
			}
			if (!$data['password_']) {
				$con = "no";
				$error_message = $error_message.'<li>You must enter a password.</li>
				';
			}
			//if passwords don't match
			if ($data['password_'] != $data['cpassword_']) {
				$con = "no";
				$error_message = $error_message.'<li>Your passwords do not match.</li>
				';
			}
				//check if username is already used
				$checkres = general_query("SELECT * FROM ".$databaseinfo['prefix']."users WHERE user_name='".$data['username_']."'");
				if (mysql_num_rows($checkres) > 0) {
					$con = "no";
					$error_message = $error_message.'<li>The username specified is already being used. Please choose another.</li>
				';
				}
				$error_message = $error_message.'</ol>';
			
			if ($con == "yes") { //if no problems
				$data['password_'] = sha1($data['password_']);
				$globalvars['page_name'] = "user success";
				$globalvars['page_image'] = "user management";
				$user_sql = new_user($data);
				
				//send email
				send_mail('New user: '.$data['username_'], "Hello,\nThe user '".$_SESSION['username']."' has created an additional user, '".$data['username_']."'\n\nTo edit this user, go to: ".$globalvars['path_to_uri']."");
				
			} else { // if there WERE problems
				$globalvars['page_name'] = "user management";
					//shortcut fix for a small bug...we'll need to add to the array
					$data['user_name'] = $data['username_'];
					$data['full_name'] = $data['fullname'];
				$content = user_form($data);
			}
		}
	} elseif ($do == "deleteusers") {
	
		if ($globalvars['rank'][22] == 0) {
			header("Location: index.php?do=permissiondenied");	
			die(); //if header doesn't work, kill the script.
		}
	
		$items = $_POST; //get vars
		if (!$items) { //if no items, avoid mysql error by just redirecting
			header("Location: user.php");
		}
		
		foreach($items as $key=>$value) { //create list of ids to be deleted
			$items_f = $items_f."'$key',";
		}
		
		//check to make sure user deleting isn't in the list
		if (strstr($items_f, $_SESSION['userID']) || strstr($items_f, '1')) {
			header("Location: user.php?delete_success=no");
			die(); //just in case!
		}
		
		$items_f = substr_replace($items_f,"",-1); //remove last comma in list for SQL
		$sql = general_query("DELETE FROM ".$databaseinfo['prefix']."users WHERE id IN ($items_f)"); //delete all records where the id is in the list
		header("Location: user.php?delete_success=1");
		
	} elseif ($do == "edit") {
			
		if ($globalvars['rank'][20] == 0) {
			header("Location: index.php?do=permissiondenied");	
			die(); //if header doesn't work, kill the script.
		}
			
		$globalvars['page_name'] = "edit user"; //declare page name
		$globalvars['page_image'] = "user management";
		$id = $_GET['id'];
		
		if ($id) {
			$id = clean_data($id);
			$fu_res = general_query("SELECT * FROM ".$databaseinfo['prefix']."users WHERE id='$id' LIMIT 1");
			//create the form with above query
			while ($data = mysql_fetch_assoc($fu_res)) {
				if ($data['notifications'] == 1) {
					$data['notifications_checked'] = ' checked="checked"';
				}
				$content = user_form($data);
			}
		}
	} elseif ($do == "editp") {
	
	if ($globalvars['rank'][20] == 0) {
		header("Location: index.php?do=permissiondenied");	
		die(); //if header doesn't work, kill the script.
	}
	
		if(isset($_POST)) {
			//generate vars
			$data['username_'] = $_POST['username_'];
			$data['fullname'] = $_POST['fullname'];
			$data['password_'] = $_POST['password_'];
			$data['cpassword_'] = $_POST['cpassword_'];
			$data['email'] = $_POST['email'];
			$data['msn'] = $_POST['msn'];
			$data['aim'] = $_POST['aim'];
			$data['yahoo'] = $_POST['yahoo'];
			$data['skype'] = $_POST['skype'];
			$data['rank'] = $_POST['rank'];
			$data['notifications'] = $_POST['notifications'];
			
			if (!$data['notifications']) {
				$data['notifications'] = 0;
			}
			
			$data['id'] = $_POST['id'];
			$data['original_username'] = $_POST['original_username'];

			foreach($data as $key => $value) {
				//clean data (SQL injection security)
				$data[$key] = clean_data($value);
			}

			$con = "yes";
			$error_message = '<ol class="warning">
			';
			if (!$data['username_']) {  //no username
				$con = "no";
				$error_message = $error_message.'<li>You must enter a username.</li>
				';
			}
			if (!$data['fullname']) { //no fullname
				$con = "no";
				$error_message = $error_message.'<li>You must enter a full name.</li>
				';
			}

			if ($data['password_']) {
				//if passwords don't match
				if ($data['password_'] != $data['cpassword_']) {
					$con = "no";
					$error_message = $error_message.'<li>Your passwords do not match.</li>
					';
				}
			}
				//check if username is already used
				$checkres = general_query("SELECT * FROM ".$databaseinfo['prefix']."users WHERE user_name='".$data['username_']."'");
				if (mysql_num_rows($checkres) > 0) {
						if ($data['original_username'] != $data['username_']) { //if the username is already being used (excluding current one)
							$con = "no";
							$error_message = $error_message.'<li>The username specified is already being used. Please choose another.</li>';
						}
				}
				$error_message = $error_message.'</ol>';
			
			if ($con == "yes") { //if no problems
				$globalvars['page_name'] = "edit user";
				$globalvars['page_image'] = "success";
				$user_sql = edit_user($data);
				
				header("Location: user.php?id=".$data['id']."&do=edit&success=1");
				
			} else { // if there WERE problems
				$globalvars['page_name'] = "user management";
					//shortcut fix for a small bug...we'll need to add to the array
					$data['user_name'] = $data['username_'];
					$data['full_name'] = $data['fullname'];
				$content = user_form($data);
			}
		}
		
	} elseif ($do == "ranks") { //rank management
			//quick permission check (redir to error) reference above this
			if ($globalvars['rank'][2] == 0) {
				header("Location: index.php?do=permissiondenied");	
				die(); //if header doesn't work, kill the script.
			}
		$globalvars['page_name'] = "rank management";
		$globalvars['page_image'] = "lock";
		
		//generate rank options for moving articles from deleted ranks
		$move_selected_sql = general_query("SELECT * FROM ".$databaseinfo['prefix']."ranks");
		
		while ($move_row = mysql_fetch_assoc($move_selected_sql)) {
			$move_selected = $move_selected."<option value=\"".$move_row['id']."\">".$move_row['rank_title']."</option>";
		}
		
		//generate list of ranks
		$item_list = load_items('ranks',0,5000,'','','');
		
		while ($item_row = mysql_fetch_array($item_list)) {
			//convert timestamp to readable/human date
			$item_row['timestamp'] = date($globalvars['time_format'],$item_row['timestamp']);
			$usercount_sql = general_query("SELECT * FROM ".$databaseinfo['prefix']."articles WHERE article_author='".$item_row['user_name']."'");
			$num_items =  mysql_num_rows($usercount_sql);
			$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
				
			$table_rows = $table_rows.'
			<tr bgcolor="'.$row_bg.'">
				<td>
					<a href="user.php?id='.$item_row['id'].'&do=editrank"><img src="images/icons/edit.png" class="row_icon" alt="edit icon" title="edit &quot;'.$item_row['rank_title'].'&quot;" /></a>
					<strong><a href="user.php?id='.$item_row['id'].'&do=editrank">'.$item_row['rank_title'].'</a></strong>
				</td>
				<td>'.$item_row['rank_desc'].'</td>
				<td>'.$item_row['timestamp'].'</td>
				<td>'.$item_row['permissions'].'</td>
				<td>'.$item_row['rank_author'].'</td>
				<td class="checkbox"><input type="checkbox" value="'.$item_row['id'].'" name="'.$item_row['id'].'"></td>
			</tr>
			';
		} //end of WHILE statement
		
		//success/error message
		if ($_GET['delete_success'] == 1) {
			$success =  '<div class="success">The item(s) have been successfully deleted.</div>';
		} elseif ($_GET['delete_success'] == 'no') {
			$success = '<div class="warning">The operation was cancelled, you cannot delete the first rank (ID: 1), or your own!</div>';
		}
		
		$content = '
		'.$success.'
		<h3>Actions</h3>
		<ul>
			<li><strong><a href="?do=newrank">new rank</a></strong></li>			
		</ul>
		
		<h3>Rank list</h3>
		<form id="rankopt" method="post" action="?do=deleteranks" onsubmit="return confirm(\'Are you sure you want to delete the selected items?\');">
			<table style="text-align: left; width: 100%;" border="1" cellpadding="3" cellspacing="2">
				<tbody>
					<tr class="toprow">
						<td style="width: 200px; text-align: left;"><strong>Rank title</strong></td>
						<td><strong>Rank description</strong></td>
						<td><strong>Date</strong></td>
						<td><strong>Permission string</strong></td>
						<td style="width: 80px"><strong>Author</strong></td>
						<td style="width: 10px; text-align: center;"><strong><input type="checkbox" onClick="Checkall(this.form);" /></strong></td>
					</tr>
					'.$table_rows.'
				</tbody>
			</table>
			<div style="text-align: right;">
				Move users from rank(s) (that will be deleted) to:
				<select id="move_rank" name="move_rank" style=" margin: 0; width: 250px;">
					'.$move_selected.'
				</select>
				<input type="submit" id="submit" value="Delete Selected" />
			</div>
		</form>';
	} elseif ($do == "deleteranks") {
			//quick permission check (redir to error) reference above this
			if ($globalvars['rank'][2] == 0) {
				header("Location: index.php?do=permissiondenied");	
				die(); //if header doesn't work, kill the script.
			}
		$items = $_POST; //get vars
		
		unset($items['move_rank']);
		
		if (!$items) { //if no items, avoid mysql error by just redirecting
				header("Location: user.php?do=ranks");
			}
		foreach($items as $key=>$value) { //create list of ids to be deleted
			$items_f = $items_f."'$key',";
		}
		$items_f = substr_replace($items_f,"",-1); //remove last comma in list for SQL
				
		//move users to the rank selected
		$res_m = general_query('UPDATE '.$databaseinfo['prefix'].'users SET rank_id="'.$_POST['move_rank'].'" WHERE rank_id IN ('.$items_f.')');
		
		//make sure it's not the rank the user is assigned to
		if (strstr($items_f, $_SESSION['rankID']) || strstr($items_f, '1')) {
			header("Location: user.php?do=ranks&delete_success=no");
			die();
		}
		
		$sql = general_query("DELETE FROM ".$databaseinfo['prefix']."ranks WHERE id IN ($items_f)"); //delete all records where the id is in the list
		header("Location: user.php?do=ranks&delete_success=1");
	
	} elseif ($do == "newrank") { //new rank
			//quick permission check (redir to error)
			if ($globalvars['rank'][0] == 0) {
				header("Location: index.php?do=permissiondenied");
				die();	
			}
		$globalvars['page_name'] = "new rank";
		$globalvars['page_image'] = "lock";
		$content = rank_form();
	
	} elseif ($do == "nrankp") {
			//quick permission check (redir to error)
			if ($globalvars['rank'][0] == 0) {
				header("Location: index.php?do=permissiondenied");
				die();	
			}
		$globalvars['page_name'] = "rank success";
		$globalvars['page_image'] = "success";
		
		//suppress error just in case it was a faulty submission.
		$category_list = @join($_POST['categories'], ',');
		
		//new rank creation process. Gather array
			$data = $_POST;
			
			//ok, so this gets a little complicated. We need to take all the data from the form, and make it into a string of 12 numbers, seperated by commas. The numbers will be 0s and 1s, 0 representing "disallow" and 1 "allow", 3 meaning a custom value.
			//the sequence is: '1,1,1,1,1,1,1,1,1,1,1,1'
			//the english sequence...
			// createranks,manageranks,loginrecords,preferences,loggingin,createarticles,approve,editarticles,deletearticles,createusers,editusers,deleteusers  
			//in that order. THE ORDER IS IMPORTANT, due to the splitting later. :)
			//now on to the boring part of forming the query for insertion into the db. str_replace should suffice with a foreach() statement.
			$rank = $data; //we'll use this later.
			//first, unset the vars we don't need for this part.
			unset($data['rank_title']);
			unset($data['rank_desc']);
			unset($data['categories']);
			
			$continue = TRUE;
			
			//check if any are missing
			foreach ($data as $key=>$value) { //foreach string, lets create
					//check if there is a value. we need every value.
					if ($data[$key] == "") {
						$continue = FALSE;
					}
					
				//replace 'allow' and 'disallow' with proper values. (0 and 1)
				$data[$key] = preg_replace('/^allow$/',1,$data[$key]);
				$data[$key] = str_replace('disallow',0,$data[$key]);
				
				//special
				$data[$key] = str_replace('allowapp',2,$data[$key]);

			}
			
			$permissions_string .= $data['createranks'].','.$data['manageranks'].','.$data['loginrecords'].','.$data['preferences'].','.$data['loggingin'].','.$data['createarticles'].','.$data['approve'].','.$data['editarticles'].','.$data['deletearticles'].','.$data['createusers'].','.$data['editusers'].','.$data['deleteusers'].','; //we form the string, putting a comma after each value.
			//here is the string, with that last comma removed.
			$permissions_string = substr_replace($permissions_string,"",-1);
			
			if ($rank['rank_title'] == NULL || $rank['rank_desc'] == NULL || $continue == FALSE) { //if we're missing any piece, error.
				$globalvars['page_name'] = "new rank";
				$globalvars['page_image'] = 'error';
				$error_message = '<div class="warning">You need values for each field, including the rank title and description.</div>';
				$content = rank_form($rank, $category_list);
			} else {
				new_rank($rank,$permissions_string,$category_list,$_SESSION['username']);
			}
	} elseif ($do == "editrank") { //if we're editing the rank
			//quick permission check (redir to error)
			if ($globalvars['rank'][2] == 0) {
				header("Location: index.php?do=permissiondenied");
				die();	
			}
		$globalvars['page_name'] = "edit rank"; //declare page name
		$globalvars['page_image'] = "lock";
		$id = $_GET['id'];
		
		if ($id) {
			$id = clean_data($id);
			$ru_res = general_query("SELECT * FROM ".$databaseinfo['prefix']."ranks WHERE id='$id' LIMIT 1");
			//while
			while ($data = mysql_fetch_assoc($ru_res)) {
				//we're going to convert the permissions from 1s ande 0s to proper form values.
				$data['permissions'] = str_replace('1','allow',$data['permissions']);
				$data['permissions'] = str_replace('0','disallow',$data['permissions']);
				$data['permissions'] = str_replace('2','allowapp',$data['permissions']);
				
					//now split string into array
					$data['permissions'] = split(',',$data['permissions']);
					
					//the sequence is: 1,1,1,1,1,1,1,1,1,1,1,1
					//the english sequence...
					// createranks,manageranks,loginrecords,preferences,loggingin,createarticles,approve,
					// editarticles,deletearticles,createusers,editusers,deleteusers
	
				//now we can assign new vars for form
				$data['createranks'] = $data['permissions'][0];
				$data['manageranks'] = $data['permissions'][1];
				$data['loginrecords'] = $data['permissions'][2];
				$data['preferences'] = $data['permissions'][3];
				$data['loggingin'] = $data['permissions'][4];
				$data['createarticles'] = $data['permissions'][5];
					//quick fix for label on create articles (allow w/ approval solution)
					if ($data['createarticles'] == 'allowapp') { $data['label'] = 'allow w/ approval'; } elseif ($data['createarticles'] == 'allow') { $data['label'] = 'allow'; } else { $data['label'] = 'disallow'; }
				$data['approve'] = $data['permissions'][6];
				$data['editarticles'] = $data['permissions'][7];
				$data['deletearticles'] = $data['permissions'][8];
				$data['createusers'] = $data['permissions'][9];
				$data['editusers'] = $data['permissions'][10];
				$data['deleteusers'] = $data['permissions'][11];
							
				$content = rank_form($data);
			}
		}
	} elseif ($do == "erankp") { //rank edit process
			//quick permission check (redir to error)
			if ($globalvars['rank'][2] == 0) {
				header("Location: index.php?do=permissiondenied");
				die();	
			}
		$globalvars['page_name'] = "rank success";
		$globalvars['page_image'] = "success";
		
			$category_list = join($_POST['categories'], ',');
			
		//new rank creation process. Gather array
			$data = $_POST;
			
			//ok, so this gets a little complicated. We need to take all the data from the form, and make it into a string of 12 numbers, seperated by commas. The numbers will be 0s and 1s, 0 representing "disallow" and 1 "allow", 3 meaning a custom value.
			//the sequence is: 1,1,1,1,1,1,1,1,1,1,1,1
			//the english sequence...
			// createranks,manageranks,loginrecords,preferences,loggingin,createarticles,approve,editarticles,deletearticles,createusers,editusers,deleteusers,  
			//in that order. THE ORDER IS IMPORTANT, due to the splitting later. :)
			//now on to the boring part of forming the query for insertion into the db. str_replace should suffice with a foreach() statement.
			$rank = $data; //we'll use this later.
			//first, unset the vars we don't need for this part.
			unset($data['rank_title']);
			unset($data['rank_desc']);
			unset($data['categories']);
			unset($data['id']);
			$continue = TRUE;
			foreach ($data as $key=>$value) { //foreach string, lets create
					//check if there is a value. we need every value.
					if ($data[$key] == "") {
						$continue = FALSE;
					}
					
				//replace 'allow' and 'disallow' with proper values. (0 and 1)
				$data[$key] = preg_replace('/^allow$/',1,$data[$key]);
				$data[$key] = str_replace('disallow',0,$data[$key]);
				
				//special
				$data[$key] = str_replace('allowapp',2,$data[$key]);

			}
			
			$permissions_string .= $data['createranks'].','.$data['manageranks'].','.$data['loginrecords'].','.$data['preferences'].','.$data['loggingin'].','.$data['createarticles'].','.$data['approve'].','.$data['editarticles'].','.$data['deletearticles'].','.$data['createusers'].','.$data['editusers'].','.$data['deleteusers'].','; //we form the string, putting a comma after each value.
			
			//here is the string, with that last comma removed. Wow, it's three in the morning.
			$permissions_string = substr_replace($permissions_string,"",-1);
			
			if ($rank['rank_title'] == NULL || $rank['rank_desc'] == NULL || $continue == FALSE) { //if we're missing any piece, error.
				$globalvars['page_name'] = "edit rank";
				$globalvars['page_image'] = 'error';
				$error_message = '<div class="warning">You need values for each field, including the rank title and description.</div>';
				$content = rank_form($rank,$category_list);
			} else {
				edit_rank($rank,$permissions_string,$category_list,$rank['id']);
				
				//after editing, redirect to edit page with success
				header("Location: user.php?id=".$rank['id']."&do=editrank&success=1");
			}
	
	
	} elseif ($do == "loginrec") { //login records
			//quick permission check (redir to error)
			if ($globalvars['rank'][4] == 0) {
				header("Location: index.php?do=permissiondenied");
				die();	
			}
		$globalvars['page_name'] = "login records";
		$globalvars['page_image'] = "user management";
		
		$action = $_GET['action'];
		
			//if delete all
			if ($action == "delall") {
				$sql = general_query("DELETE FROM ".$databaseinfo['prefix']."userlogin");
				
				$error_message = '<div class="success">All login records have been deleted.</div>';
			}
			
		//determine pagination
		$page = $_GET['page'];
			if (!$page) {
				$page = 1;
			}
		$items_per_page = 20;
		$page_start = ($page*$items_per_page) - $items_per_page;
		$next_page = $page + 1;
		$prev_page = $page - 1;
		
		
		$item_list = load_items('userlogin',$page_start,$items_per_page,$sort,$v);
		
		if (mysql_num_rows($item_list) == NULL) {
			$table_rows = '<td class="noresults" colspan="6"><strong>No returned results...</strong></td>';
		}
		
		while ($item_row = mysql_fetch_array($item_list)) {
			//convert timestamp to readable/human date
			$item_row['timestamp'] = date($globalvars['time_format'],$item_row['timestamp']);
			$item_row['name'] = gen_rank_name($item_row['rank_id']);
			$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
			
			//generate rows from login attempts
			$table_rows = $table_rows.'<tr bgcolor="'.$row_bg.'"><td><a href="manage.php?v='.$item_row['username'].'"><strong>'.$item_row['username'].'</strong></a></td><td><a href="user.php?do=editrank&id='.$item_row['rank_id'].'">'.$item_row['name'].'</a></td><td>'.$item_row['timestamp'].'</td><td><strong><a href="http://'.$item_row['ip'].'/">'.$item_row['ip'].'</a></strong></td></tr>
			';
		}
		$content = loginrec_form();
	
	
	} //end main conditional

include("inc/themecontrol.php");  //include theme script
?>
