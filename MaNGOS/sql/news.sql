/*
SQLyog Community Edition- MySQL GUI v7.1 
MySQL - 5.0.51b-community-nt : Database - news
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`news` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `news`;

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `headline` text NOT NULL,
  `story` text NOT NULL,
  `name` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `news` */

insert  into `news`(`id`,`headline`,`story`,`name`,`email`,`timestamp`) values (1,'Test','Testing','Furt','lit_69@hotmail.com','0000-00-00 00:00:00');

/*Table structure for table `phpns_articles` */

DROP TABLE IF EXISTS `phpns_articles`;

CREATE TABLE `phpns_articles` (
  `id` int(25) NOT NULL auto_increment,
  `article_title` varchar(150) NOT NULL,
  `article_sef_title` varchar(150) NOT NULL,
  `article_subtitle` varchar(150) NOT NULL,
  `article_author` varchar(100) NOT NULL,
  `article_cat` varchar(15) NOT NULL,
  `article_text` varchar(20000) NOT NULL,
  `article_exptext` varchar(20000) NOT NULL,
  `article_imgid` varchar(100) NOT NULL,
  `allow_comments` varchar(1) NOT NULL,
  `start_date` varchar(15) NOT NULL,
  `end_date` varchar(15) NOT NULL,
  `active` varchar(1) NOT NULL,
  `approved` varchar(1) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `article_title` (`article_title`,`timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_articles` */

insert  into `phpns_articles`(`id`,`article_title`,`article_sef_title`,`article_subtitle`,`article_author`,`article_cat`,`article_text`,`article_exptext`,`article_imgid`,`allow_comments`,`start_date`,`end_date`,`active`,`approved`,`timestamp`,`ip`) values (1,'Welcome to phpns!','Welcome-to-phpns','','admin','all','&lt;p&gt;\r\nIf you see are viewing this message, the phpns installation was a success! This article is filed under &amp;quot;Site Wide News&amp;quot;, which is the default category that is created during installation.\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n&lt;font style=&quot;background-color: #999999&quot; color=&quot;#000000&quot;&gt;You are free to modify this message, or delete it all together&lt;/font&gt;. Why should you use phpns?\r\n&lt;/p&gt;\r\n&lt;ul&gt;\r\n	&lt;li&gt;&lt;strong&gt;It&#039;s free&lt;/strong&gt;. Phpns is released under the GPL license, which gives you the ability to change it, redistribute it, and use it personally or professionally.&lt;/li&gt;\r\n	&lt;li&gt;&lt;strong&gt;It&#039;s easy to integrate&lt;/strong&gt;. Only one line of code is necessary on your website (, and you have a dynamic, fully functional news system. &lt;/li&gt;\r\n	&lt;li&gt;&lt;strong&gt;It&#039;s easy to install&lt;/strong&gt;. The guided installation will have you up and running in minutes, asking you just a few questions about your database setup.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n','What does &amp;quot;free&amp;quot; mean? &lt;blockquote&gt;To the phpns developers, the word &amp;quot;free&amp;quot; means more than just the cost of the product. The word free means that &lt;strong&gt;you are free&lt;/strong&gt; to modify anything you want about phpns, without any license restrictions.&lt;/blockquote&gt;&lt;p&gt;Why is phpns free in both price and modification?&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;Because we believe in the open-source message. Closed source applications restrict the user from customizing the way the system works, and prevents the communitiy from contributing to the package. Plus, we love seeing our software being put to good use, and we love seeing modifications of our work!&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;Why don&#039;t you require a &amp;quot;Powered by phpns&amp;quot; message at the bottom of each page, like other news systems?&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;Because we hate that.&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;What can I do to help the project?&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;If you would like to be a part of the project, we always appreciate help. What you can do:&lt;/p&gt;&lt;ul&gt;&lt;li&gt;Spread the word. Recommend our system to your friends and co-workers!&lt;/li&gt;&lt;li&gt;Report bugs you&#039;ve encountered at the &lt;a href=&quot;http://launchpad.net/phpns&quot;&gt;phpns launchpad website&lt;/a&gt;. &lt;/li&gt;&lt;li&gt;Submit reviews to software review websites around the internet. As long as they are honest, this is a great way to help us.&lt;/li&gt;&lt;li&gt;Donate. This helps with hosting/domain costs, and you&#039;ll get your name on the website along with a message and URL of your blog/website.&lt;/li&gt;&lt;li&gt;Become a sponsor. If you&#039;re a hosting service, business, or organization, we&#039;re always looking for funding and bandwith.&lt;/li&gt;&lt;li&gt;Develop. Contact us on the website if you think we could use your services.&lt;/li&gt;&lt;/ul&gt;That&#039;s it. Enjoy phpns!&lt;br /&gt;&lt;/blockquote&gt;','imgid','0','','','1','1','1229681271','70.232.141.24'),(2,'New test','New-test203','Sub-test','admin','1','&lt;p&gt;\r\nTesting the new news system.\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nAdding more to check news width................................\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nlskd;fjaslkdjf;laskdjf;laskdjf;la ksjdf;oijso d;ije ;oijfsoeijfo;siejf;si oefj;osiejfo;isjeo;f ijsjefiseiiiiiiii iiiiiiiiiiiiiiiiiiii iiiiiiiiiiiiiiifoahs dfl;asjdlkfjal skdfjsldkfjasoid hiodshfoiah fsdiofhohs ;fiohs;df h;ioashf ;oisdfh;o siafh;osif h;oisfha;siof h;as oifh;soifh iosdhfi osdhfs; oidhf sio;d fhs;iodfh; asiohf;as oifhsio;dfh s;oidfhhisdf; oshdfio;h sdf;iosifh \r\n&lt;/p&gt;\r\n','','','1','','','1','1','1229681487','70.232.141.24');

/*Table structure for table `phpns_banlist` */

DROP TABLE IF EXISTS `phpns_banlist`;

CREATE TABLE `phpns_banlist` (
  `id` int(10) NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL,
  `banned_by` varchar(20) NOT NULL,
  `reason` varchar(5000) NOT NULL,
  `timestamp` varchar(12) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `phpns_banlist` */

/*Table structure for table `phpns_categories` */

DROP TABLE IF EXISTS `phpns_categories`;

CREATE TABLE `phpns_categories` (
  `id` int(15) NOT NULL auto_increment,
  `cat_name` varchar(100) NOT NULL,
  `cat_parent` varchar(10000) NOT NULL,
  `cat_author` varchar(100) NOT NULL,
  `cat_desc` varchar(1000) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_categories` */

insert  into `phpns_categories`(`id`,`cat_name`,`cat_parent`,`cat_author`,`cat_desc`,`timestamp`,`ip`) values (1,'Site Wide News','','admin','This is for general news on your website.','1229681271','70.232.141.24');

/*Table structure for table `phpns_comments` */

DROP TABLE IF EXISTS `phpns_comments`;

CREATE TABLE `phpns_comments` (
  `id` int(25) NOT NULL auto_increment,
  `article_id` varchar(25) NOT NULL,
  `comment_text` varchar(1000) NOT NULL,
  `website` varchar(100) NOT NULL,
  `comment_author` varchar(20) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `approved` varchar(1) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `phpns_comments` */

/*Table structure for table `phpns_cookielog` */

DROP TABLE IF EXISTS `phpns_cookielog`;

CREATE TABLE `phpns_cookielog` (
  `id` int(20) NOT NULL auto_increment,
  `user_id` varchar(15) NOT NULL,
  `rank_id` varchar(15) NOT NULL,
  `cookie_id` varchar(32) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `phpns_cookielog` */

/*Table structure for table `phpns_gconfig` */

DROP TABLE IF EXISTS `phpns_gconfig`;

CREATE TABLE `phpns_gconfig` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `v1` varchar(17) NOT NULL,
  `v2` varchar(10) NOT NULL,
  `v3` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_gconfig` */

insert  into `phpns_gconfig`(`id`,`name`,`v1`,`v2`,`v3`) values (15,'siteonline','0','0','0'),(16,'def_rsslimit','','','3'),(17,'def_rssorder','desc','',''),(18,'def_items_per_page','10','',''),(19,'def_rsstitle','','','RSS feed for logon.crimson-storm.net'),(20,'def_rssdesc','','','An RSS feed from logon.crimson-storm.net'),(21,'def_rssenabled','1','',''),(22,'def_limit','10','',''),(23,'def_order','desc','',''),(24,'def_offset','0','',''),(25,'timestamp_format','','','l F d, Y  g:i a'),(26,'def_comlimit','','','100000'),(27,'def_comenabled','1','',''),(28,'def_comorder','asc','',''),(29,'global_message','','','Welcome to the Enhanced news admin panel!'),(30,'siteonline','0','0','0'),(31,'wysiwyg','yes','',''),(32,'sys_time_format','l F d, Y  g:i a','',''),(33,'line','yes','','');

/*Table structure for table `phpns_images` */

DROP TABLE IF EXISTS `phpns_images`;

CREATE TABLE `phpns_images` (
  `id` int(15) NOT NULL auto_increment,
  `user_id` varchar(15) NOT NULL,
  `image_filepath` varchar(500) NOT NULL,
  `alt_description` varchar(100) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `phpns_images` */

/*Table structure for table `phpns_ranks` */

DROP TABLE IF EXISTS `phpns_ranks`;

CREATE TABLE `phpns_ranks` (
  `id` int(15) NOT NULL auto_increment,
  `rank_title` varchar(100) NOT NULL,
  `rank_desc` varchar(1000) NOT NULL,
  `rank_author` varchar(100) NOT NULL,
  `permissions` varchar(100) NOT NULL,
  `category_list` varchar(200) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_ranks` */

insert  into `phpns_ranks`(`id`,`rank_title`,`rank_desc`,`rank_author`,`permissions`,`category_list`,`timestamp`) values (1,'Administrators','Any user assigned to this rank will have full access.','admin','1,1,1,1,1,1,1,1,1,1,1,1','all','1229681271');

/*Table structure for table `phpns_syslog` */

DROP TABLE IF EXISTS `phpns_syslog`;

CREATE TABLE `phpns_syslog` (
  `id` int(24) NOT NULL auto_increment,
  `task` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `user` int(5) NOT NULL,
  `page` varchar(120) NOT NULL,
  `timestamp` varchar(12) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_syslog` */

insert  into `phpns_syslog`(`id`,`task`,`description`,`user`,`page`,`timestamp`) values (1,'INSTALL','User &lt;i&gt;admin&lt;/i&gt; has installed phpns!',1,'/phpns/install/','1229681272'),(12,'login','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;logged in&lt;/strong&gt;.',1,'login.php?do=p','1229681354'),(13,'notification_error','Phpns failed sending emails to  for an unknown reason. Attempted to send to: ',1,'article.php?do=p','1229681487'),(14,'logout','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;logged out&lt;/strong&gt;.',1,'login.php?do=logout','1229681738'),(15,'login','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;logged in&lt;/strong&gt;.',1,'login.php?do=p','1229681790'),(16,'edit_item','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;modified&lt;/strong&gt; article titled &quot;Welcome to phpns!&quot; (ID: 1)',1,'article.php?id=1&amp;do=editp','1229681880'),(17,'edit_item','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;modified&lt;/strong&gt; article titled &quot;New test&quot; (ID: 2)',1,'article.php?id=2&amp;do=editp','1229682004'),(18,'global_message','User &lt;i&gt;admin&lt;/i&gt; has &lt;strong&gt;edited&lt;/strong&gt; the default global message',1,'preferences.php?do=globalmessage&amp;action=update','1229683400');

/*Table structure for table `phpns_templates` */

DROP TABLE IF EXISTS `phpns_templates`;

CREATE TABLE `phpns_templates` (
  `id` int(15) NOT NULL auto_increment,
  `template_name` varchar(100) NOT NULL,
  `template_desc` varchar(1000) NOT NULL,
  `template_author` varchar(100) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `html_article` varchar(5000) NOT NULL,
  `html_comment` varchar(5000) NOT NULL,
  `html_form` varchar(5000) NOT NULL,
  `html_pagination` varchar(5000) NOT NULL,
  `template_selected` varchar(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_templates` */

insert  into `phpns_templates`(`id`,`template_name`,`template_desc`,`template_author`,`timestamp`,`html_article`,`html_comment`,`html_form`,`html_pagination`,`template_selected`) values (1,'Default','This is the default phpns template.','Phpns-team','1194252704','&lt;div style=&quot;margin-bottom: 30px; min-height: 130px;&quot;&gt;\r\n	&lt;h2 style=&quot;margin-bottom: 0pt&quot;&gt;&lt;a href=&quot;{article_href}&quot; style=&quot;text-decoration: none;&quot;&gt;{title}&lt;/a&gt;&lt;/h2&gt;\r\n	&lt;h3&gt;&lt;em&gt;{sub_title}&lt;/em&gt;&lt;/h3&gt;\r\n	&lt;h4 style=&quot;margin: 0 0 0 3em; font-weight: normal;&quot;&gt;Posted by &lt;a href=&quot;#&quot;&gt;{author}&lt;/a&gt; on {date}&lt;/h4&gt;\r\n	&lt;span style=&quot;float: right&quot;&gt;&lt;a href=&quot;{image_location}&quot;&gt;{image}&lt;/a&gt;&lt;/span&gt;\r\n&lt;div style=&quot;float:right; padding: 0 0 10px 10px&quot;&gt;{reddit} {digg}&lt;/div&gt;\r\n	{main_article}\r\n	{extended_article}\r\n	&lt;div id=&quot;comments&quot; style=&quot;text-align: right; clear: both;&quot;&gt;\r\n		&lt;strong&gt;&lt;a href=&quot;{article_href}#comments&quot;&gt;{comment_count} comments&lt;/a&gt;&lt;/strong&gt;\r\n	&lt;/div&gt;\r\n&lt;/div&gt;\r\n','&lt;div style=&quot;background: #eee; margin: 20px 0 0 5%; padding: 5px;&quot;&gt;\r\n	&lt;div style=&quot;border: 1px solid #ccc; padding: 3px; background: #ccc; margin-bo\r\nttom: 5px;&quot;&gt; \r\n		&lt;div style=&quot;text-align: right; float: right&quot;&gt; {timestamp} {admin}&lt;/div&gt;  \r\n		&lt;strong&gt;Posted by  &lt;a href=&quot;{website}&quot;&gt;{author}&lt;/a&gt;&lt;/strong&gt; as {ip}\r\n	&lt;/div&gt;\r\n	{comment}\r\n&lt;/div&gt;\r\n','&lt;form style=&quot;margin-top: 50px;&quot; action=&quot;{action}&quot; method=&quot;post&quot;&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;name&quot; id=&quot;name&quot; /&gt; &lt;label for=&quot;name&quot;&gt;Name (required)&lt;/label&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;email&quot; id=&quot;email&quot; /&gt; &lt;label for=&quot;email&quot;&gt;Email (not publishe\r\nd) (required)&lt;/label&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;website&quot; id=&quot;website&quot; /&gt; &lt;label for=&quot;website&quot;&gt;Website&lt;/label&gt;&lt;br /&gt;\r\n	&lt;textarea name=&quot;comment&quot; style=&quot;width:100%; height: 150px&quot;&gt;&lt;/textarea&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;captcha&quot; style=&quot;width: 100px&quot; /&gt; &lt;label for=&quot;captcha&quot;&gt;&lt;strong&gt;What is {captcha_question}?&lt;/strong&gt;&lt;/label&gt;&lt;br /&gt;\r\n	{hidden_data}\r\n	{captcha_answer}\r\n	&lt;input type=&quot;submit&quot; value=&quot;Submit comment&quot; id=&quot;submit&quot; /&gt;\r\n&lt;/form&gt;\r\n','&lt;a style=&quot;padding: 3px; margin: 10px; border: 1px solid #888;&quot; href=&quot;{previous_page}&quot;&gt;Previous Page&lt;/a&gt; {middle_pages} &lt;a  style=&quot;padding: 3px; margin: 10px; border: 1px solid #888;&quot; href=&quot;{next_page}&quot;&gt;Next Page&lt;/a&gt;',''),(9,'Enhanced','For FBEnhanced','admin','1229684908','&lt;div class=&quot;story-top&quot;&gt;&lt;div align=&quot;center&quot;&gt;\r\n&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;story&quot;&gt;&lt;center&gt;&lt;div style=&quot;width:300px; text-align:left&quot;&gt;&lt;center&gt;&lt;br/&gt;\r\n&lt;div style=&quot;min-height: 130px;&quot;&gt;\r\n	&lt;h2 style=&quot;margin-bottom: 0pt&quot;&gt;&lt;a href=&quot;{article_href}&quot; style=&quot;text-decoration: none;&quot;&gt;{title}&lt;/a&gt;&lt;/h2&gt;\r\n	&lt;h3&gt;&lt;em&gt;{sub_title}&lt;/em&gt;&lt;/h3&gt;\r\n	&lt;h4 style=&quot;margin: 0 0 0 3em; font-weight: normal;&quot;&gt;Posted by &lt;a href=&quot;#&quot;&gt;{author}&lt;/a&gt; on {date}&lt;/h4&gt;\r\n 	&lt;span style=&quot;float: right&quot;&gt;&lt;a href=&quot;{image_location}&quot;&gt;{image}&lt;/a&gt;&lt;/span&gt;\r\n&lt;div style=&quot;float:right; padding: 0 0 10px 10px&quot;&gt;{reddit} {digg}&lt;/div&gt;\r\n	{main_article}\r\n	{extended_article}\r\n	&lt;div id=&quot;comments&quot; style=&quot;text-align: right; clear: both;&quot;&gt;\r\n		&lt;strong&gt;&lt;a href=&quot;{article_href}#comments&quot;&gt;{comment_count} comments&lt;/a&gt;&lt;/strong&gt;\r\n	&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;&lt;/center&gt;&lt;/div&gt;&lt;div class=&quot;story-bot&quot; align=&quot;center&quot;&gt;&lt;br/&gt;&lt;/div&gt;\r\n','&lt;div style=&quot;background: #eee; margin: 20px 0 0 5%; padding: 5px;&quot;&gt;\r\n	&lt;div style=&quot;border: 1px solid #ccc; padding: 3px; background: #ccc; margin-bo\r\nttom: 5px;&quot;&gt; \r\n		&lt;div style=&quot;text-align: right; float: right&quot;&gt; {timestamp} {admin}&lt;/div&gt;  \r\n		&lt;strong&gt;Posted by  &lt;a href=&quot;{website}&quot;&gt;{author}&lt;/a&gt;&lt;/strong&gt; as {ip}\r\n	&lt;/div&gt;\r\n	{comment}\r\n&lt;/div&gt; ','&lt;form style=&quot;margin-top: 50px;&quot; action=&quot;{action}&quot; method=&quot;post&quot;&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;name&quot; id=&quot;name&quot; /&gt; &lt;label for=&quot;name&quot;&gt;Name (required)&lt;/label&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;email&quot; id=&quot;email&quot; /&gt; &lt;label for=&quot;email&quot;&gt;Email (not publishe\r\nd) (required)&lt;/label&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;website&quot; id=&quot;website&quot; /&gt; &lt;label for=&quot;website&quot;&gt;Website&lt;/label&gt;&lt;br /&gt;\r\n	&lt;textarea name=&quot;comment&quot; style=&quot;width:100%; height: 150px&quot;&gt;&lt;/textarea&gt;&lt;br /&gt;\r\n	&lt;input type=&quot;text&quot; name=&quot;captcha&quot; style=&quot;width: 100px&quot; /&gt; &lt;label for=&quot;captcha&quot;&gt;&lt;strong&gt;What is {captcha_question}?&lt;/strong&gt;&lt;/label&gt;&lt;br /&gt;\r\n	{hidden_data}\r\n	{captcha_answer}\r\n	&lt;input type=&quot;submit&quot; value=&quot;Submit comment&quot; id=&quot;submit&quot; /&gt;\r\n&lt;/form&gt; ','&lt;a style=&quot;padding: 3px; margin: 10px; border: 1px solid #888;&quot; href=&quot;{previous_page}&quot;&gt;Previous Page&lt;/a&gt; {middle_pages} &lt;a  style=&quot;padding: 3px; margin: 10px; border: 1px solid #888;&quot; href=&quot;{next_page}&quot;&gt;Next Page&lt;/a&gt;','1');

/*Table structure for table `phpns_themes` */

DROP TABLE IF EXISTS `phpns_themes`;

CREATE TABLE `phpns_themes` (
  `id` int(10) NOT NULL auto_increment,
  `theme_name` varchar(100) NOT NULL,
  `theme_author` varchar(100) NOT NULL,
  `theme_dir` varchar(200) NOT NULL,
  `base_dir` varchar(50) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `theme_selected` varchar(1) NOT NULL,
  `permissions` varchar(10000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_themes` */

insert  into `phpns_themes`(`id`,`theme_name`,`theme_author`,`theme_dir`,`base_dir`,`timestamp`,`theme_selected`,`permissions`) values (1,'default','phpns team','themes/default/','default','1229681271','1','');

/*Table structure for table `phpns_userlogin` */

DROP TABLE IF EXISTS `phpns_userlogin`;

CREATE TABLE `phpns_userlogin` (
  `id` int(20) NOT NULL auto_increment,
  `username` varchar(15) NOT NULL,
  `rank_id` varchar(15) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_userlogin` */

insert  into `phpns_userlogin`(`id`,`username`,`rank_id`,`timestamp`,`ip`) values (82,'admin','1','1229681354','70.232.141.24'),(83,'admin','1','1229681790','70.232.141.24');

/*Table structure for table `phpns_users` */

DROP TABLE IF EXISTS `phpns_users`;

CREATE TABLE `phpns_users` (
  `id` int(15) NOT NULL auto_increment,
  `user_name` varchar(100) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `msn` varchar(100) NOT NULL,
  `aim` varchar(100) NOT NULL,
  `yahoo` varchar(100) NOT NULL,
  `skype` varchar(100) NOT NULL,
  `display_picture` varchar(150) NOT NULL,
  `rank_id` varchar(15) NOT NULL,
  `notifications` varchar(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `phpns_users` */

insert  into `phpns_users`(`id`,`user_name`,`full_name`,`email`,`password`,`timestamp`,`ip`,`msn`,`aim`,`yahoo`,`skype`,`display_picture`,`rank_id`,`notifications`) values (1,'admin','admin','test@test.com','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3','1229681271','127.0.0.1','','','','','','1','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
