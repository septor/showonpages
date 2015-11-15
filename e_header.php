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

// Get the page we're on.
$currentPage = substr(strrchr($_SERVER['PHP_SELF'], "/"), 1);

// Cycle through the database and pull up all the Content Code listings.
if($sql->count("showonpages_content", "(*)") > 0)
{
	$sql->select("showonpages_content", "*", "ORDER BY id ASC", "no-where");
	while($row = $sql->fetch())
	{
		// If the Content Code is suppose to be displayed on every page, let's just get to it.
		if($row['pages'] == "*" && check_class($row['userclass']))
		{
			echo "\n\n<!-- ShowOnPages Content Codes  -->";
			echo "\n<!-- ".$row['description']." -->\n";
			echo html_entity_decode($row['code'])."\n\n";
		}
		// Otherwise, let's get serious.
		else
		{
			// We need to make an array of all the pages that the code can be displayed on.
			$allowedPages = explode(",", $row['pages']);

			// If the a page is "forum.php" we need to make sure that if the visitor is on any forum page that they are given the code too.
			if(in_array("forum.php", $allowedPages))
			{
				$currentPage = str_replace(array("_viewforum", "_viewtopic"), array("", ""), $currentPage);
			}

			// Now the good stuff, if the current page is in the array of pages to display the code, let's get to work!
			if(in_array($currentPage, $allowedPages) && check_class($row['userclass']))
			{
				echo "\n\n<!-- ShowOnPages Content Codes  -->";
				echo "\n<!-- ".$row['description']." -->\n";
				echo html_entity_decode($row['code'])."\n\n";
			}
		}
	}
}

?>
