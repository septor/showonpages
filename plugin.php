<?php
include_lan(e_PLUGIN."showonpages/languages/".e_LANGUAGE.".php");

// -- [ PLUGIN INFO ]
$eplug_name			= "ShowOnPages";
$eplug_version		= "0.1.1";
$eplug_author		= "Patrick Weaver";
$eplug_url			= "http://trickmod.com/";
$eplug_email		= "patrickweaver@gmail.com";
$eplug_description	= SOPLAN_PLUGIN_01;
$eplug_compatible	= "e107 v1.0+";
$eplug_readme		= "";
$eplug_compliant	= TRUE;
$eplug_folder		= "showonpages";
$eplug_menu_name	= "";
$eplug_conffile		= "admin_config.php";
$eplug_icon			= "";
$eplug_icon_small	= $eplug_icon;
$eplug_caption		= SOPLAN_PLUGIN_02; 

// -- [ DEFAULT PREFERENCES ]
$eplug_prefs = "";
	
// -- [ MYSQL TABLES ]

$eplug_table_names = array("showonpages_content");

$eplug_tables = array(
	"CREATE TABLE ".MPREFIX."showonpages_content (
		id int(10) unsigned NOT NULL auto_increment,
		code text,
		description varchar(255) default NULL,
		pages varchar(15) NOT NULL default '',
		userclass varchar(250) NOT NULL default '',
		PRIMARY KEY (id)
	) ENGINE=MyISAM;"
);

// -- [ MAIN SITE LINK ]
$eplug_link			= FALSE;
$eplug_link_name	= "";
$eplug_link_url		= "";

// -- [ INSTALLED MESSAGE ]
$eplug_done = $eplug_name." ".SOPLAN_PLUGIN_03;

// -- [ UPGRADE INFORMATION ]
$upgrade_add_prefs    = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done   = $eplug_name." ".SOPLAN_PLUGIN_04;

?>
