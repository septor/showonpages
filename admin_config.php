<?php
/*
 * ShowOnPages - A code displaying plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
require_once('../../class2.php');
if (!getperms('P'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}
e107::lan('showonpages', 'admin', true);

class showonpages_adminArea extends e_admin_dispatcher
{
	protected $modes = array(
		'main'	=> array(
			'controller' 	=> 'showonpages_content_ui',
			'path' 			=> null,
			'ui' 			=> 'showonpages_content_form_ui',
			'uipath' 		=> null
		),
	);

	protected $adminMenu = array(
		'main/list'			=> array('caption'=> LAN_SHOWONPAGES_MANAGE, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_SHOWONPAGES_CREATE, 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = 'ShowOnPages';
}

class showonpages_content_ui extends e_admin_ui
{
	protected $pluginTitle		= 'ShowOnPages';
	protected $pluginName		= 'showonpages';
	protected $table			= 'showonpages_content';
	protected $pid				= 'id';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $listOrder		= 'id DESC';

	protected $fields = array (
		'checkboxes' =>  array (
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
		),
		'id' => array (
			'title' => LAN_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'type' => array (
			'title' => 'Code Type',
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => 'The type of code you want displayed.',
			'readParms' => '',
			'writeParms' => array('optArray' => array(
				'js' => 'js',
				'css' => 'css',
				'meta' => 'meta',
			)),
			'class' => 'left',
			'thclass' => 'left',
		),
		'position' => array(
			'title' => 'Code Position',
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => 'The position the code will be in. "inline", "url", etc.',
			'readParms' => '',
			'writeParms' => array('optArray' => array(
				'inline' => 'inline',
				'header' => 'header',
				'header_inline' => 'header_inline',
				'footer' => 'footer',
				'footer_inline' => 'footer_inline',
				'url' => 'url',
			)),
			'class' => 'left',
			'thclass' => 'left',
		),
		'code' => array (
			'title' => 'Content Code',
			'type' => 'textarea',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => 'The code you want displayed.',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'order' => array(
			'title' => 'Order',
			'type' => 'number',
			'data' => 'int',
			'width' => 'auto',
			'inline' => true,
			'help' => 'The order you want the code to be displayed in relevance to other Content Codes.',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'description' => array (
			'title' => LAN_DESCRIPTION,
			'type' => 'text',
			'data' => 'str',
			'width' => '40%',
			'inline' => true,
			'tab' => 0,
			'help' => LAN_SHOWONPAGES_CODE_02,
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'pages' =>  array (
			'title' => LAN_SHOWONPAGES_CODE_03_A,
			'type' => 'text',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'tab' => 0,
			'help' => LAN_SHOWONPAGES_CODE_03_B,
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'userclass' => array (
			'title' => LAN_USERCLASS,
			'type' => 'userclass',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'tab' => 0,
			'help' => 'The userclass you want affected by the Content Code.',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'options' => array (
			'title' => LAN_OPTIONS,
			'type' => null,
			'data' => null,
			'width' => '10%',
			'thclass' => 'center last',
			'class' => 'center last',
			'forced' => '1',
		),
	);

	protected $prefs = array();

	public function init()
	{
	}

	public function beforeCreate($new_data)
	{
		$new_data['code'] = e107::getParser()->toDb($new_data['code'], true, false, 'no_html');
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
	}

	public function onCreateError($new_data, $old_data)
	{
	}

	// ------- Customize Update --------
	public function beforeUpdate($new_data, $old_data, $id)
	{
		if($old_data['code'] == "")
		{
			$new_data['code'] = e107::getParser()->toDb($old_dat['code'], true, false, 'no_html');
		}
		else
		{
			$new_data['code'] = $old_data['code'];
		}
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
	}

		/*
		// optional - a custom page.
		public function customPage()
		{
			$text = 'Hello World!';
			return $text;
		}
		*/
}

class showonpages_content_form_ui extends e_admin_form_ui
{
}

new showonpages_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
?>
