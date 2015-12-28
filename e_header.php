<?php
/*
 * ShowOnPages - A code displaying plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
if (!defined('e107_INIT')) { exit; }
$sql = e107::getDb();
$tp = e107::getParser();

if(e107::pref('showonpages', 'pageType') == 'lax')
	$currentPage = substr(strrchr($_SERVER['PHP_SELF'], "/"), 1);
else
	$currentPage = str_replace(SITEURL, '', SITEURLBASE.e_REQUEST_URI);

if($sql->count("showonpages_content", "(*)") > 0 && USER_AREA)
{
	$sql->gen("SELECT * FROM #showonpages_content ORDER BY `order` ASC");
	while($row = $sql->fetch())
	{
		if($row['pages'] == "*" && check_class($row['userclass']))
		{
			// TODO: Probably error checking to make sure the code being displayed works with the position selected.
			$code = ($row['position'] == 'url' ? $row['code'] : $tp->toHtml($row['code']));
			if($row['type'] == 'js') e107::js($row['position'], $code);
			else if($row['type'] == 'css') e107::css($row['position'], $code);      
			else if($row['type'] == 'meta') e107::meta($row['position'], $code);
		}
		else
		{
			$allowedPages = explode(",", $row['pages']);

			if(in_array($currentPage, $allowedPages) && check_class($row['userclass']))
			{
				// TODO: Probably error checking to make sure the code being displayed works with the position selected.
				$code = ($row['position'] == 'url' ? $row['code'] : $to->toHtml($row['code']));
				if($row['type'] == 'js') e107::js($row['position'], $code);
				else if($row['type'] == 'css') e107::css($row['position'], $code);      
				else if($row['type'] == 'meta') e107::meta($row['position'], $code);
			}
		}
	}
}
