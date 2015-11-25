CREATE TABLE showonpages_content (
	`id` int(10) unsigned NOT NULL auto_increment,
	`type` varchar(250) default NULL,
	`position` varchar(250) default NULL,
	`order` varchar(250) default NULL,
	`code` text,
	`description` varchar(250) default NULL,
	`pages` varchar(250) NOT NULL default '',
	`userclass` varchar(250) NOT NULL default '',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;
