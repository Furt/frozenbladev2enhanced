<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->

<?php
 /******* Server Status Settings *************************************************************
 *
 *      IP - The ip used for connection to the server
 *      Port - The port used for connection to the server
 * 
 *********************************************************************************************/
	$ip = "your.site.com";
	$port = "8093";
	
 /******* Account Creation Settings **********************************************************
 *
 *      mysql_host - MySQL Host Address
 *      mysql_user - MySQL Username
 *      mysql_pass - MySQL Password
 *      mysql_dbname - Logon Database Where The Accounts Stuff Resides
 * 
 *********************************************************************************************/
 
    $config['mysql_host'] = 'localhost';
    $config['mysql_user'] = 'root';
    $config['mysql_pass'] = 'pass';
    $config['mysql_dbname'] = 'logon';
	
/******* IP & Ban Checker, Tele & Unstucker Settings **************************************************
 *
 *      EnableEmail -  If you know you can send mail then enable this, default: false -- (disabled)
 *      SiteEmail - Your admin email/Support email
 * 
 *********************************************************************************************/
 
	$aHost="localhost";
	$aDatabase="character";
	$aPort="3306";
	$aUsername="root";
	$aPass="pass";
	$cHost="localhost";
	$cDatabase="logon";
	$cPort="3306";
	$cUsername="root";
	$cPass="pass";
	// Teleporter Settings
	//default = 50g/teleport. ex -  $TELEPORT_COST = 954, would mean 954 gold per transport
	$TELEPORT_COST = 50;
    
 /******* OTHER SETTINGS **********************************************************************
 *
 *      PageTitle - Title of the page..  
 *      MaxIPs - Set this to the allowed MAX accounts Per IP Address. Disabled: 0 
 *      MaxEmails - Set this to the allowed MAX accounts Per Email. Disabled: 0
 *      EncryptedPass - Encrypted passwords = 1, Uncrypted = 0
 *      RealmIP - Set this to the IP address of your realm server
 *      PatchVersion - The Client patch number that the server allows to connect
 * 
 *********************************************************************************************/

	$config['Title'] = "MySite";
	$config['Sitename'] = "yoursite.com";
    $config['PageTitleACS'] = "Account Creation";
	$config['PageTitlePCS'] = "Password Change";
	$config['PageTitleFPS'] = "Forgotten Password";
    $config['MaxIPs'] = '4';
    $config['MaxEmails'] = '0';
    $config['EncryptedPass'] = '0';
    $config['RealmIP'] = 'your.realmlist.com';
    $config['PatchVersion'] = '3.0.3 WotLK';
	
/******* EMAIL SETTINGS **********************************************************************
 *
 *      EnableEmail -  If you know you can send mail then enable this, default: false -- (disabled)
 *      SiteEmail - Your admin email/Support email
 * 
 *********************************************************************************************/

    $config['EnableEmail'] = false;
    $config['SiteEmail'] = "noreply@yoursite.com";
	
/******* Account Login Settings **************************************************************
 *
 *      mysql_host - MySQL Host Address
 *      mysql_user - MySQL Username
 *      mysql_pass - MySQL Password
 *      mysql_dbname - Logon Database Where The Accounts Stuff Resides
 * 
 *********************************************************************************************/

	// REQUIRED! Parameters to connecto to your DB
	// CHANGE ONLY $db_host, $db_name, $username, $password
	$db_host="localhost";
	$db_name="logon";
	$username="root";
	$password="pass";

	// DON'T CHANGE THE FOLLOWING CODE!
	$db_con=mysql_connect($db_host,$username,$password);
	$connection_string=mysql_select_db($db_name);
	mysql_connect($db_host,$username,$password);
	mysql_select_db($db_name);

?>