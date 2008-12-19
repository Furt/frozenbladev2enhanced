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

$globalvars['page_name'] = 'new article'; //set page name

include("inc/header.php");
$do = $_GET['do'];
	//if we're previewing an article... set do to preview
	if (isset($_POST['preview'])) { $do = 'preview'; }
	if (!$do) {

		//quick permission check (redir to error)
		if ($globalvars['rank'][10] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
	
	//The do var is empty; display new article form
	$content = article_form();  //display form (function in function.php)
	
	} elseif ($do == "preview") {  //preview article
	
		//quick permission check (redir to error)
		if ($globalvars['rank'][10] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();
		}
			$globalvars['page_name'] = 'preview article';
			$globalvars['page_image'] = 'new article';
		//define new item array from POST data
			$data['article_title'] = $_POST['article_title'];
			$data['article_subtitle'] = $_POST['article_subtitle'];
			$data['article_cat'] = $_POST['article_cat'];
			$data['article_text'] = $_POST['article_text'];
			$data['article_exptext'] = $_POST['article_exptext'];
			$data['acchecked'] = $_POST['acchecked'];
			$data['achecked'] = $_POST['achecked'];
			$data['start_date'] = $_POST['start_date'];
			$data['end_date'] = $_POST['end_date'];
			
			//define checked boxes...
			if ($data['achecked'] == "") {  //if no value (not selected)
				$data['achecked'] = 1;
			}
			if ($data['acchecked'] == "") {  //if no value (not selected)
				$data['acchecked'] = 1;
			}
			
			if ($data['allow_comments'] == 0) { //if the article DISALLOWS comments, check the box
				$data['acchecked_check'] = ' checked="checked"';
			}
			
			if ($data['active'] == 0) {  //if the article is NOT active, check the box
				$data['achecked_check'] = ' checked="checked"';
			}
		
		$content = '
			<hr />
			<h1 class="preview_title">'.$data['article_title'].'</h1>
			<div class="preview_main">
				'.$data['article_text'].'
			</div>
			<div class="preview_full">
				'.$data['article_exptext'].'
			</div>
			<hr />
			'.article_form().'
		';
	
	} elseif ($do == "p") { //if new form submitted
		
		//quick permission check (redir to error)
		if ($globalvars['rank'][10] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
		
		//now, if this user needs approval to post, we'll set the approve to 0 (which is 'no', or not approved) ELSE, 1
		if ($globalvars['rank'][10] == 2) {
			$data['approved'] = 0;
		} elseif ($globalvars['rank'][10] == 1) {
			$data['approved'] = 1;
		}
		
		if (isset($_POST)) {
		
			$proceed = "yes"; //for verification later
			
			//define new item array from POST data
			$data['article_title'] = $_POST['article_title'];
			$data['article_subtitle'] = $_POST['article_subtitle'];
			$data['article_cat'] = $_POST['article_cat'];
			$data['article_text'] = $_POST['article_text'];
			$data['article_exptext'] = $_POST['article_exptext'];
			$data['acchecked'] = $_POST['acchecked'];
			$data['achecked'] = $_POST['achecked'];;
			$data['start_date'] = $_POST['start_date'];
			$data['end_date'] = $_POST['end_date'];
			
			// we already have this set, nulled out here for reference
			// $data['approved'] = "0";
			
			$error_message = '<ol class="warning warning_new_article">';
			
			if (!trim($data['article_title'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>You must enter a title.</li>
				';
			}
			if (empty($data['article_text'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>You must enter a main article.</li>
				';
				
			}
			if (empty($data['article_cat'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>A category is necessary. You should NOT recieve this message, something is wrong. Make sure you have a category defined.</li>
				';
			}
			
			//check to see if user is ALLOWED to post to this category
			if (!strstr($_SESSION['category_list'], $data['article_cat']) && !strstr($_SESSION['category_list'], 'all')) {
				$proceed = "no";
				$error_message = $error_message.'<li>Your rank is not allowed to post to this category.</li>';
			}
				
			//convert start and end date times | function will do everything, it also returns errors.
			if ($data['start_date']) {
				$unixtime['start'] = validate_date($data,'start');
			}
			if ($data['end_date']) {
				$unixtime['end'] = validate_date($data,'end');
			}
			
			if ($data['achecked'] == "") {  //if no value (not selected)
				$data['achecked'] = 1;
			}
			
			if ($data['acchecked'] == "") {  //if no value (not selected)
				$data['acchecked'] = 1;
			}
			
			//new article process (clean data, then submit to database)
			foreach ($data as $key => $value) {
				//clean data (SQL injection security)
				$data[$key] = clean_data($value);
			}
			
			if ($proceed == "yes") {
				if ($_FILES['image']['name']) {
					if (!$data['image'] = upload_image($_FILES['image'])) {
						$proceed = "no";
						$error_message .= '<li>The image upload returned an error, which means the file was not an image, or we had trouble moving the file to (images/uploads). Check the permissions for the directory.</li>';
					}
				}

				if ($proceed == "yes") { //if we're STILL ok, even with file upload... we finish up.
				
					//generate sef_url
					$data['article_sef_title'] = create_sef($data['article_title']);
					
					$goto_edit_id = new_item($data,$_SESSION['username']); //submit the data(function in inc/function.php) with username
					$globalvars['page_name'] = 'article success'; //set page name
					$globalvars['page_image'] = 'success';
					
					//send email
					send_mail("New article: ".$data['article_title']."", "Hello,\nThe user '".$_SESSION['username']."' has posted a new article at ".$_SERVER['HTTP_HOST'].".\n\nTitle: ".$data['article_title']."\nMain Article:\n".$data['article_text']."\n\nTo edit this article, go to: http://".$globalvars['path_to_uri'].". This message was generated automatically, and responding to it is useless. If you do not want to recieve emails anymore, ask the administrator (or someone who has permissions to modify your profile) to stop email notifications for you.");
					
					//rediret to article edit
					header("Location: article.php?do=edit&id=".$goto_edit_id."&success=created");
				} else {
					$globalvars['page_name'] = 'new article'; //set page name
					$globalvars['page_image'] = 'error'; //error image
				
					$error_message = $error_message.'</ol>'; //end error message ordered list
					
					//we have to convert the date back from the UNIX timestamp, IF it's in the correct format. (We already did this above)
					if ($data['acchecked'] == 0) { //if the article DISALLOWS comments, check the box
						$data['acchecked_check'] = ' checked="checked"';
					}
					if ($data['achecked'] == 0) {  //if the article is NOT active, check the box
						$data['achecked_check'] = ' checked="checked"';
					}
					$content = article_form();  //display form (function in function.php)
				}
				
			} else { //problem. display form with vars. 
				$globalvars['page_name'] = 'new article'; //set page name
				$globalvars['page_image'] = 'error'; //error image
				
				$error_message = $error_message.'</ol>'; //end error message ordered list
				
				//we have to convert the date back from the UNIX timestamp, IF it's in the correct format. (We already did this above)
				
				if ($data['acchecked'] == 0) { //if the article DISALLOWS comments, check the box
					$data['acchecked_check'] = ' checked="checked"';
				}
				if ($data['achecked'] == 0) {  //if the article is NOT active, check the box
					$data['achecked_check'] = ' checked="checked"';
				}
				$content = article_form();  //display form (function in function.php)
			}
		}
	} elseif ($do == "edit") { //do elseif (edit)
	
		//quick permission check (redir to error)
		if ($globalvars['rank'][14] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
	
		$globalvars['page_name'] = 'edit article';  //set page name
		$globalvars['page_image'] = 'article management'; //set image
		$news_id = clean_data($_GET['id']);
			//sql and execution, grab update data from IP.
			$get_res = general_query("SELECT * FROM ".$databaseinfo['prefix']."articles WHERE id='$news_id' LIMIT 1");
		$data = mysql_fetch_assoc($get_res) or die(mysql_error());
		if ($data['start_date']) {
			$data['start_date'] = date('m/d/Y',$data['start_date']);
		}
		if ($data['end_date']) {
			$data['end_date'] = date('m/d/Y',$data['end_date']);
		}
			//define checked boxes...
			
			if ($data['allow_comments'] == 0) { //if the article DISALLOWS comments, check the box
				$data['acchecked_check'] = ' checked="checked"';
			}
			
			if ($data['active'] == 0) {  //if the article is NOT active, check the box
				$data['achecked_check'] = ' checked="checked"';
			}
		//display edit form
		$content = article_form();
		
	} elseif ($do == "editp") { //do elseif (edit process)
	
		//quick permission check (redir to error)
		if ($globalvars['rank'][14] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
		
		$globalvars['page_name'] = 'edit article';
			if (isset($_POST)) {
			$proceed = "yes"; //for verification later
			
			//define new item array from POST data
			$data['article_title'] = $_POST['article_title'];
			$data['article_subtitle'] = $_POST['article_subtitle'];
			$data['article_cat'] = $_POST['article_cat'];
			$data['article_text'] = $_POST['article_text'];
			$data['article_exptext'] = $_POST['article_exptext'];
			$data['acchecked'] = $_POST['acchecked'];
			$data['achecked'] = $_POST['achecked'];
			$data['start_date'] = $_POST['start_date'];
			$data['end_date'] = $_POST['end_date'];
			
			//now we need to check if the article is approved, and set the var accordingly for the form button for activation.
			$approved_fetch = general_query("SELECT approved FROM ".$databaseinfo['prefix']."articles WHERE id='".$_POST['id']."' LIMIT 1", TRUE);
			$data['approved'] = $approved_fetch['approved'];
			
			$error_message = '<ol class="warning">';
			if (!trim($data['article_title'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>You must enter a title.</li>
				';
			}
			if (empty($data['article_text'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>You must enter a main article.</li>
				';
				
			}
			if (empty($data['article_cat'])) {
				$proceed = "no";
				$error_message = $error_message.'<li>A category is necessary. You should NOT recieve this message, something is wrong. Make sure you have a category defined...</li>
				';
			}
			
			//check to see if user is ALLOWED to post to this category
			if (!strstr($_SESSION['category_list'], $data['article_cat']) && !strstr($_SESSION['category_list'], 'all')) {
				$proceed = "no";
				$error_message = $error_message.'<li>Your rank is not allowed to post or edit articles in this category.</li>';
			}
			
			//convert start and end date times | function will do everything, it also returns errors.
			if ($data['start_date']) {
				$unixtime['start'] = validate_date($data,'start');
			}
			if ($data['end_date']) {
				$unixtime['end'] = validate_date($data,'end');
			}
			
			
			if ($data['achecked'] == "") {  //if no value (not selected)
				$data['achecked'] = 1;
			}
			if ($data['acchecked'] == "") {  //if no value (not selected)
				$data['acchecked'] = 1;
			}
			
			//new article process (clean data, then submit to database)
			foreach($data as $key => $value) {
				//clean data (SQL injection security)
				$data[$key] = clean_data($value);
			}
			if ($proceed == "yes") {
				if ($_FILES['image']['name']) {
					if (!$data['image'] = upload_image($_FILES['image'])) {
						$proceed = "no";
						$error_message .= '<li>The image upload returned an error, which means the file was not an image, or we had trouble moving the file to (images/uploads). Check the permissions for the directory.</li>';
						
					}
				}
				
				if ($proceed == "yes") {
					$data['id'] = $_POST['id'];
					
					//generate sef_url
					$data['article_sef_title'] = create_sef($data['article_title']);
				
					edit_item($data,$_SESSION['username']); //submit the data(function in inc/function.php) with user
					
					header("Location: article.php?do=edit&id=".$data['id']."&success=1");
					
				} else { //edit error display form and errors
					$globalvars['page_name'] = 'edit article'; //set page name
					$globalvars['page_image'] = 'error';
					
					$news_id = clean_data($_GET['id']);
					
					$error_message = $error_message.'</ol>'; //end error message ordered list
					//if the form dates are correct, recreate the human readable for edit page...
				
				if ($data['acchecked'] == 0) { //if the article DISALLOWS comments, check the box
					$data['acchecked_check'] = ' checked="checked"';
				}
				if ($data['achecked'] == 0) {  //if the article is NOT active, check the box
					$data['achecked_check'] = ' checked="checked"';
				}
					$content = article_form();  //display form (function in function.php)
				}
			} else {
				$globalvars['page_name'] = 'edit article'; //set page name
				$globalvars['page_image'] = 'error'; //error image
				
				$news_id = clean_data($_GET['id']);
				
				$error_message = $error_message.'</ol>'; //end error message ordered list
				
				//we have to convert the date back from the UNIX timestamp, IF it's in the correct format. (We already did this above)
				if ($data['acchecked'] == 0) { //if the article DISALLOWS comments, check the box
					$data['acchecked_check'] = ' checked="checked"';
				}
				if ($data['achecked'] == 0) {  //if the article is NOT active, check the box
					$data['achecked_check'] = ' checked="checked"';
				}
				$content = article_form();  //display form (function in function.php)
			}
		}
	} elseif ($do == "activate") {
	
		if ($globalvars['rank'][12] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
		
		//activating the article, function and then redirect.
			$id = $_GET['id'];
			$action = $_GET['action'];
			
		change_active_status($id, $action); //updates article, sets to active, and updates timestamp.
		header("Location: article.php?do=edit&id=$id");
	
	} elseif ($do == "comments") {
		if ($_GET['action'] == 'delete') {
			$items = $_POST; //get vars
				if (!$items) { //if no items, avoid mysql error by just redirecting
					header("Location: ?do=comments&id=".$_GET['id']."");
				}
					//we're going to create list of ids to be deleted from database.
					foreach($items as $key=>$value) {
						$items_f = $items_f."'$key',";
					}
					//remove last comma in list for SQL
					$items_f = substr_replace($items_f,"",-1);
					//delete the items in 'articles'
					delete('comments',$items_f);
					
					//we deleted comments; display success
					$success .= '<div class="success">The selected item(s) have been deleted.</div>';
					
					//log this
					log_this('delete_comments','User <i>'.$_SESSION['username'].'</i> has <strong>deleted</strong> the comments: "'.$items_f.'"');
		}
		//if the id isn't numeric, kill the script. Injection protection.
		if (!is_numeric($_GET['id'])) { die("non numeric article id"); }
			$id = $_GET['id'];
		$globalvars['page_name'] = 'comment list';
		$globalvars['page_image'] = 'none';
		
		//now, we generate comments for this specific article
			//get the template currently active in the installation
			$template = fetch_template();
		$fetch_com_res = general_query("SELECT * FROM ".$databaseinfo['prefix']."comments WHERE article_id='".$id."' AND approved='1'");
			//for each row (or comment) generated, we translate the item and assign it to $content
			while ($row = mysql_fetch_assoc($fetch_com_res)) {
				$comment_list .= ''.translate_comment($row, $template['html_comment'], 'html_comment');
			}
				//if empty output (with comments)
				if (trim($comment_list) == NULL && mysql_num_rows($fetch_com_res) > 0) {
					$comment_list .= '<div class="warning">This article does have comments posted, however, no output was given. This is usually because your comment_template for your selected template is empty.</div>';
				}
				
				//if empty comments
				if (mysql_num_rows($fetch_com_res) == 0) {
					$comment_list .= '<div class="warning">There are no comments for this article.</div>';
				}
			//assign $comment_list to $content
			$content .= '
				<div><button class="activate" OnClick="window.location = \'?do=edit&id='.$id.'\';"><strong>Back to edit article</strong></button></div>
				'.$success.'
				<form action="?do=comments&id='.$id.'&action=delete" method="post">
					<div class="select_all_wrap"><label class="nofloat" for="selectall">Select all</label> <input id="selectall" type="checkbox" onClick="Checkall(this.form);" /></div>
					'.$comment_list.'
					<div class="alignr">
						<input type="submit" id="submit" value="Delete selected comments" />
					</div>
				</form>
			';
	
	} //end of main do


include("inc/themecontrol.php");  //include theme script
?>
