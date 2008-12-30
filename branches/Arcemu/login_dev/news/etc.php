<?php
//testing cia
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
$return_to = $_GET['return'];
	
	if ($do == "backup") { //send backup file to user, header info
		$file = $databaseinfo['dbname'].'.sql'; //the current dump
		if (@file_exists($file)) { //get size
			$size = filesize($file);
			
			//send metadata
			header('Content-Type: application/text');
			header('Content-Length: '.$size.'');
			header('Content-disposition: attachment; filename='.$file.'');
			readfile($file);
			log_this('backup_download','User <i>'.$_SESSION['username'].'</i> has <strong>downloaded</strong> the system database.');
		} else {
			header("Location: preferences.php?do=backup&success=no");
		}
	} elseif ($do == "rss") { //if it's the system-wide phpns
	
		$phpns['mode'] = 'rss';
		include('shownews.php');
		
	} elseif ($do == "news") {
	
		//include news for this part of etc.php
		include("shownews.php");
		
	} elseif ($do == "delete_backup") {
	
		//attempt to delete sql file
		@unlink($databaseinfo['dbname'].'.sql');
		
		//log
		log_this('delete_backup','User <i>'.$_SESSION['username'].'</i> has <strong>attempted (successful or not) to delete</strong> the database backup.');
		
		//redirect back to page.
		header("Location: $return_to");
		
	} elseif ($do == "delete_install") {
		//attempt to delete install directory
		@unlink('install/index.php');
		@unlink('install/install.inc.php');
		@unlink('install/install.tmp.php');
		@unlink('install/upgrade.php');
		if(@rmdir('install/'))
		{
		log_this('delete_install','User <i>'.$_SESSION['username'].'</i> has <strong>successfully deleted</strong> the install directory.');;
		}else{
		log_this('delete_install','User <i>'.$_SESSION['username'].'</i> has <strong>failed at deleting</strong> the install directory.');
		}
		header("Location: $return_to");
		
	} elseif ($do == "hide_warnings") {
		//set session var, and redirect to index. If TRUE, all warning messages at the top will be hidden.
		$_SESSION['hide_sessions'] = TRUE;
		header("Location: $return_to");
		
	} elseif ($globalvars['debug'] == "yes" && $do == "phpinfo") {
		phpinfo();
	} else {
		echo 'Bad $do ('.$do.'), could not find associated action.';
	}
	
if ($do == NULL) {
	echo "This file is only for special tasks that can't be done on other pages. Go away now. =D";
	die();
}
	
?>
