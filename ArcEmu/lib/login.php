<?php
// LOGIN
include('config.php'); 
include('common-functions.php');

if(isset($_POST['email']) && isset($_POST['psw'])){ 

		// Clean Input
		$email		=	cleanInput($_POST['email']);
		$psw		=	cleanInput($_POST['psw']);
		
		// Verify login
		$login_sql	=	'SELECT * FROM USER WHERE EMAIL ="'.$email.'" AND PSW ="'.$psw.'"';
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
				redirect('../login-form.php?login=ok');
			}
		} else {
			echo $ciao;
			// in case of error set this var = 1.
			// a red box will appear in the page where is the login-form
				redirect('../login-form.php?error=1');
		}
}
?>
