-- ----------------------------
-- AVS Database
-- ----------------------------

CREATE DATABASE /*!32312 IF NOT EXISTS*/`avs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `avs`;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `realms`;
CREATE TABLE `realms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `sqlhost` varchar(32) default NULL,
  `sqluser` varchar(32) default NULL,
  `sqlpass` varchar(32) default NULL,
  `chardb` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `votemodules`;
CREATE TABLE `votemodules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `image` varchar(128) default NULL,
  `url` varchar(128) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `voterewards`;
CREATE TABLE `voterewards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `realm` tinyint(3) unsigned default NULL,
  `name` varchar(32) default NULL,
  `description` text,
  `itemid` int(10) unsigned default NULL,
  `points` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `ip` varchar(16) default NULL,
  `account` varchar(16) default NULL,
  `module` tinyint(3) unsigned default NULL,
  `time` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `realms` VALUES ('1', 'Server Name', 'localhost', 'root', 'ascent', 'logon');
INSERT INTO `votemodules` VALUES ('1', 'Xtreme Top 100', 'http://reliable.uuuq.com/1/images/friends+vote/xtremetop.jpg', null);
INSERT INTO `votemodules` VALUES ('2', 'WoW Server List', 'http://reliable.uuuq.com/1/images/friends+vote/wowservers.png', null);
INSERT INTO `votemodules` VALUES ('3', 'Game Site 200', 'http://reliable.uuuq.com/1/images/friends+vote/game%20site%20200.JPG', null);
INSERT INTO `votemodules` VALUES ('4', 'Gtop 100', 'http://reliable.uuuq.com/1/images/friends+vote/gtop100.JPG', null);

-- ----------------------------
-- Account Table Change
-- ----------------------------

USE 'logon';

ALTER TABLE `accounts`
ADD COLUMN `reward_points` mediumint(10) unsigned NOT NULL default '0';