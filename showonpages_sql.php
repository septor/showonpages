CREATE TABLE showonpages_content (
	`id` int(10) unsigned NOT NULL auto_increment,
	`code` text,
	`description` varchar(255) default NULL,
	`pages` varchar(15) NOT NULL default '',
	`userclass` varchar(250) NOT NULL default '',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;
