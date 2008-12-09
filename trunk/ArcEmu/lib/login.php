<?php
// LOGIN
include('config.php'); 
include('common-functions.php');

if(isset($_POST['login']) && isset($_POST['psw'])){ 

		// Clean Input
		$login		=	cleanInput($_POST['login']);
		$psw		=	cleanInput($_POST['psw']);
		
		// Verify login
		$login_sql	=	'SELECT * FROM accounts WHERE login ="'.$login.'" AND password ="'.$psw.'"';
		$login		=	mysql_query($login_sql);
				
		if(mysql_num_rows($login)>0){
			while ($row = mysql_fetch_array($login)) 
			{
				$userid = $row['ID_USER_PK'];
				session_start();
				// Save Session and redirect to Home Page
				$_SESSION['id']		=	session_id();
				$_SESSION['userid']	=	$userid;
				// Set te page where redirect the user after the login
				redirect('../home.php?login=ok');
			}
		} else {
			echo $ciao;
			// in case of error set this var = 1.
			// a red box will appear in the page where is the login-form
				redirect('../home.php?error=1');
		}
}
?>
