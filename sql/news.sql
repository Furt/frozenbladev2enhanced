CREATE TABLE news (
   id smallint(5) unsigned NOT NULL auto_increment,
   headline text NOT NULL,
   story text NOT NULL,
   name varchar(255),
   email varchar(255),
   timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (id)
);