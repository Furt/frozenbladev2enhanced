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
	$ip = "logon.crimson-storm.net";
	$port = "8093";
	
 /******* Account Creation Settings **********************************************************
 *
 *      mysql_host - MySQL Host Address
 *      mysql_port - MySQL port
 *      mysql_user - MySQL Username
 *      mysql_pass - MySQL Password
 *      mysql_account - logon Database Where The Accounts Stuff Resides
 *      mysql_character - character Database Where The character Stuff Resides
 *      mysql_world - world Database Where The arcemu Stuff Resides
 *      mysql_website - website Database Where The extra website Stuff Resides
 * 
 *********************************************************************************************/
 
    $config['mysql_host'] = 'localhost';
	$config['mysql_port'] = '3306';
    $config['mysql_user'] = 'root';
    $config['mysql_pass'] = 'danielle';
    $config['mysql_account'] = 'logon';
	$config['mysql_character'] = 'character';
	$config['mysql_world'] = 'world';
	$config['mysql_website'] = 'website';
    
 /******* OTHER SETTINGS **********************************************************************
 *
 *      PageTitle - Title of the page.. 
 *		Sitename - the url of your site
 *      MaxIPs - Set this to the allowed MAX accounts Per IP Address. Disabled: 0 
 *      MaxEmails - Set this to the allowed MAX accounts Per Email. Disabled: 0
 *      EncryptedPass - Encrypted passwords = 1, Uncrypted = 0
 *      RealmIP - Set this to the IP address of your realm server
 *      PatchVersion - The Client patch number that the server allows to connect
 *		PayPal - The email for your paypal donations
 *		Teleporter Settings - default = 50g/teleport. ex -  $TELEPORT_COST = 954,
 *		would mean 954 gold per transport
 * 
 *********************************************************************************************/

	$config['Title'] = "MySite";
	$config['Sitename'] = "yoursite.com";
    $config['MaxIPs'] = '4';
    $config['MaxEmails'] = '0';
    $config['EncryptedPass'] = '0';
    $config['RealmIP'] = 'your.realmlist.com';
    $config['PatchVersion'] = '3.0.3 WotLK';
	$config['PayPal'] = 'paypal@email.com';
	$TELEPORT_COST = 50;
	
/******* EMAIL SETTINGS **********************************************************************
 *
 *      EnableEmail -  If you know you can send mail then enable this, default: false -- (disabled)
 *      SiteEmail - Your admin email/Support email
 * 
 *********************************************************************************************/

    $config['EnableEmail'] = false;
    $config['SiteEmail'] = "noreply@your-site.com";

?>