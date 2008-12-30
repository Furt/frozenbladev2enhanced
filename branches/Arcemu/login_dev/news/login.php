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

$globalvars['pagetype'] = "login";  //set page type

include("inc/header.php"); //include header file

$do = $_GET['do']; //get action
	
	if ($_GET['m'] == "out") {
		//if logging out, set message
		$message .= '<div class="warning warning_login">You are successfully logged out!</div>';
	} elseif ($_GET['m'] == "nologin") {
		//if rank is disallowing
		$message .= '<div class="warning">Your username and password are correct, however, your rank is disallowing logging in at this time. Contact your administrator if you think this is a mistake.</div>';
	}

if (!$do) {
	
	$content .= login_form($message);
	
} elseif ($do == "p") {
	$loginvar = array("username"=>$_POST['username'],"password"=>sha1($_POST['password']),"remember"=>$_POST['remember']);
	
		$loginvar = clean_data($loginvar); //clean the data
	
	//check if database has entry + password
	$lsql = "SELECT * FROM ".$databaseinfo['prefix']."users WHERE user_name='".$loginvar['username']."' AND  password='".$loginvar['password']."'";
	$lres = mysql_query($lsql) or die(mysql_error()); 
	$lnumcheck = mysql_num_rows($lres);
		if ($lnumcheck == 0) { //if no result was found...
			$content .= login_form('<div id="login_warning" class="warning warning_login">
				Incorrect username and/or password. Cookies must be enabled to login to the system!
		</div>');
		} else {
			//insert login record.
			$loginvar['timestamp'] = time();
			
				//get some vars from db
				$fdata = general_query('SELECT * FROM '.$databaseinfo['prefix'].'users WHERE user_name="'.$loginvar['username'].'"', TRUE);
					//get rank string
					$rdata = general_query('SELECT * FROM '.$databaseinfo['prefix'].'ranks WHERE id='.$fdata['rank_id'].'', TRUE);
					//insert login record
					$res = general_query("INSERT INTO ".$databaseinfo['prefix']."userlogin 
					(username,rank_id,timestamp,ip) 
					VALUES (
					'".$loginvar['username']."',
					'".$rdata['id']."',
					'".$loginvar['timestamp']."',
					'".$globalvars['ip']."')");
					
			//define session variables, set cookies
			//IF YOU MODIFY SOMETHING HERE, YOU NEED TO *ALSO* add it to auth.php!
			$_SESSION['username'] = $fdata['user_name'];
			$_SESSION['userID'] = $fdata['id'];
			$_SESSION['rankID'] = $fdata['rank_id'];
			$_SESSION['permissions'] = $rdata['permissions'];
			$_SESSION['category_list'] = $rdata['category_list'];
			$_SESSION['auth'] = "yes";
			$_SESSION['path'] = $globalvars['path_to'];
				
				//if the user wants to set a cookie, we have to do more stuff. (bleh.)
				if ($loginvar['remember']) {
						//generate randomized string for cookie identification
						//we'll generate it now.
						$cookie_string = md5(uniqid(rand(), true));
					$cookielog_res = general_query('INSERT INTO '.$databaseinfo['prefix'].'cookielog 
					(user_id,rank_id,cookie_id,timestamp,ip)
					VALUES (
					"'.$fdata['id'].'",
					"'.$fdata['rank_id'].'",
					"'.$cookie_string.'",
					"'.$loginvar['timestamp'].'",
					"'.$globalvars['ip'].'"
					)');
					
					setcookie('cookie_auth', $cookie_string, time()+604800); //set cookie to expire in a week
				}
				
				//quick permission check (redir to error)
				if ($rdata['permissions'][8] == 0) {
					session_destroy();
					header("Location: login.php?m=nologin");
					die(); //kill just in case
				}
			
			//log the login
			log_this('login','User <i>'.$_SESSION['username'].'</i> has <strong>logged in</strong>.');
			
			//if this is the first login, redir to welcome page
			if (content_num("userlogin",1,0) == 1) {
				header("Location: index.php?do=welcome");
			} else {
				//go to index
				header("Location: index.php"); //redirect to index
			}
		}
	
} elseif ($do == "logout") { //if we're logging out...
	log_this('logout','User <i>'.$_SESSION['username'].'</i> has <strong>logged out</strong>.');
	session_destroy(); //destroy session
	setcookie('cookie_auth', '', time()); //destroy cookie
	header("Location: login.php?m=out");
}
include("inc/themecontrol.php");
?>
