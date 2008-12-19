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

$globalvars['page_name'] = 'article management';

include("inc/header.php");
$do = $_GET['do'];

//determine pagintation variables and sorting
		//init page
		if (!@$_GET['page']) { $_GET['page'] = FALSE; }
	$page = $_GET['page'];
	if (!$page) {
		$page = 1;
	}
	$items_per_page = 20;
	$page_start = ($page*$items_per_page) - $items_per_page;
	$next_page = $page + 1;
	$prev_page = $page - 1;
		//get sorting info and view
			//init sort
			if (!@$_GET['sort']) { $_GET['sort'] = FALSE; }
		$sort = $_GET['sort'];
		$v = $_GET['v']; 
//END OF PAGINATION/SORTING

//we start the actual page generation. If there is no specific action being done ($do == ""), generate default view
if (!$do) {	

	//generate query, and execute function
	$item_list = load_items('articles',$page_start,$items_per_page,$sort,$v);
	
	if (mysql_num_rows($item_list) == NULL) { //if no results
		$table_rows = '<td class="noresults" colspan="7"><strong>No returned results...</strong></td>';
	}
	
	while ($item_row = mysql_fetch_array($item_list)) { //for each item in db
		//convert timestamp to readable/human date
		$item_row['timestamp'] = date($globalvars['time_format'],$item_row['timestamp']);
		$item_row['article_cat_name'] = gen_cat_name($item_row['article_cat']); //switch cat_id to readable name
		$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
		
			//switch active column to yes, draft, or unapproved.
			if ($item_row['active'] == 1) { $item_row['active'] = '<span class="positive">Yes</span>'; } elseif ($item_row['active'] == 0) { $item_row['active'] = '<span class="negative">Draft</span>'; }
			if ($item_row['approved'] == 0) { $item_row['active'] = '<span class="negative">Unapproved</span>'; }
			
			$item_row['comments'] = mysql_num_rows(general_query('SELECT * FROM '.$databaseinfo['prefix'].'comments WHERE article_id="'.$item_row['id'].'"'));
			
			if (strlen($item_row['article_title']) > 30) {
				$item_row['article_title'] = wordwrap($item_row['article_title'], 30, "<br />");
			}

		//generate the actual html rows
		$table_rows = $table_rows.'<tr bgcolor="'.$row_bg.'">
			<td>
				<a href="article.php?id='.$item_row['id'].'&do=edit"><img src="images/icons/edit.png" class="row_icon" alt="edit icon" title="edit &quot;'.$item_row['article_title'].'&quot;" /></a>
				<a href="article.php?id='.$item_row['id'].'&do=edit" title="edit &quot;'.$item_row['article_title'].'&quot;"><strong>'.$item_row['article_title'].'</strong></a>
			</td>
			<td><a href="manage.php?v='.$item_row['article_cat'].'">'.$item_row['article_cat_name'].'</a></td>
			<td>'.$item_row['timestamp'].'</td>
			<td><a href="manage.php?v='.$item_row['article_author'].'">'.$item_row['article_author'].'</a></td>
			<td align="center"><a href="article.php?do=comments&id='.$item_row['id'].'">'.$item_row['comments'].'</a></td>
			<td align="center">'.$item_row['active'].'</td>
			<td class="checkbox"><input type="checkbox" value="'.$item_row['id'].'" name="'.$item_row['id'].'"></td></tr>';
	} //end of each item in db generation
	
	$content = manage_form(); //generate form

} elseif ($do == "deleteitems") { //if we're deleting items

		//quick permission check (redir to error)
		if ($globalvars['rank'][16] == 0) {
			header("Location: index.php?do=permissiondenied");
			die();	
		}
	$items = $_POST; //get vars
	if (!$items) { //if no items, avoid mysql error by just redirecting
		header("Location: manage.php");
	}
		//we're going to create list of ids to be deleted from database.
		foreach($items as $key=>$value) {
			$items_f = $items_f."'$key',";
		}
		//remove last comma in list for SQL
		$items_f = substr_replace($items_f,"",-1);
	//delete the items in 'articles'
	delete('articles',$items_f);
	
	//log this action
	log_this('delete_items','User <i>'.$_SESSION['username'].'</i> has <strong>deleted</strong> the following articles: "'.$items_f.'"');
	
	//redirect back to manage.php
	header("Location: manage.php?delete_success=1");
	
} elseif ($do == "search") { //search
	$globalvars['page_name'] = 'search'; //set page name
	
		//get query and category from POST or from GET
		$search['query'] = $_POST['query'];
		if ($search['query'] == "") { $search['query'] = $_GET['q']; }
		$search['category'] = $_POST['category'];
		if (!$search['category']) { $search['category'] = $_GET['c']; }
	
	if ($search['query'] == "click here to start the search..." || $search['query'] == "") {
		header("Location: manage.php");
	}
	
	$searchres = search($search); //form and execute search query/cat
		//if no results
		if (mysql_num_rows($searchres) == 0) { $table_rows = '<td class="noresults" colspan="7"><strong>No returned results...</strong></td>'; }
	
	//for each item, generate html table row
	while ($item_row = mysql_fetch_assoc($searchres)) {
		//convert timestamp to readable/human date
		$item_row['timestamp'] = date($globalvars['time_format'],$item_row['timestamp']);
		$item_row['article_cat_name'] = gen_cat_name($item_row['article_cat']); //switch cat_id to readable name
		$row_bg = ($row_bg == $globalvars['altcolor'][2]) ? $globalvars['altcolor'][1] : $globalvars['altcolor'][2]; //current row bg
		
			//switch active column to yes, draft, or unapproved.
			if ($item_row['active'] == 1) { $item_row['active'] = '<span class="positive">Yes</span>'; } elseif ($item_row['active'] == 0) { $item_row['active'] = '<span class="negative">Draft</span>'; }
			if ($item_row['approved'] == 0) { $item_row['active'] = '<span class="negative">Unapproved</span>'; }
			
			$item_row['comments'] = mysql_num_rows(general_query('SELECT * FROM '.$databaseinfo['prefix'].'comments WHERE article_id="'.$item_row['id'].'"'));
			
		//generate the actual html rows
		$table_rows = $table_rows.'<tr bgcolor="'.$row_bg.'">
			<td>
				<a href="article.php?id='.$item_row['id'].'&do=edit"><img src="images/icons/edit.png" class="row_icon" alt="edit icon" title="edit &quot;'.$item_row['article_title'].'&quot;" /></a>
				<a href="article.php?id='.$item_row['id'].'&do=edit" title="edit &quot;'.$item_row['article_title'].'&quot;"><strong>'.$item_row['article_title'].'</strong></a>
			</td>
			<td><a href="manage.php?v='.$item_row['article_cat'].'">'.$item_row['article_cat_name'].'</a></td>
			<td>'.$item_row['timestamp'].'</td>
			<td><a href="manage.php?v='.$item_row['article_author'].'">'.$item_row['article_author'].'</a></td>
			<td align="center"><a href="article.php?do=comments&id='.$item_row['id'].'">'.$item_row['comments'].'</a></td>
			<td align="center">'.$item_row['active'].'</td>
			<td class="checkbox"><input type="checkbox" value="'.$item_row['id'].'" name="'.$item_row['id'].'"></td></tr>';
	} //end of table row creation
	
	$content = manage_form();
} //end if main do (search elseif)

include("inc/themecontrol.php");  //include theme script
?>
