CREATE TABLE showonpages_content (
	`id` int(10) unsigned NOT NULL auto_increment,
	`csscode` text,
	`cssfile` varchar(250) default NULL,
	`jscode` text,
	`jsfile` varchar(250) default NULL,
	`description` varchar(250) default NULL,
	`pages` varchar(250) NOT NULL default '',
	`userclass` varchar(250) NOT NULL default '',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;
