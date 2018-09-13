<?php

/**
 *  Smooth Gallery
 *
 *  Private L* 4.0 project
 *
 *  @package    LEPTON-CMS modules
 *  @module     Smooth Gallery
 *  @author     ToS, Matthias Gallas, Dietrich Roland Pehlke (last)
 *  @license    GNU General Public License
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('LEPTON_PATH'))
{
    include(LEPTON_PATH . '/framework/class.secure.php');
}
else
{
    $oneback = "../";
    $root    = $oneback;
    $level   = 1;
    while (($level < 10) && (!file_exists($root . '/framework/class.secure.php')))
    {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root . '/framework/class.secure.php'))
    {
        include($root . '/framework/class.secure.php');
    }
    else
    {
        trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
    }
}
// end include class.secure.php

/**
 *	Drop the table
 *
 */
$database->simple_query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_smoothgallery`");

/**
 *  Create new table
 *
 */
$table_fields="
	`section_id`	INT NOT NULL DEFAULT '0' ,
	`page_id`		INT NOT NULL DEFAULT '0' ,
	`galleryTitle`	VARCHAR(255) NOT NULL DEFAULT '' ,
	`galleryDesc`	VARCHAR(255) NOT NULL DEFAULT '' ,
	`path`			TEXT NOT NULL,
	`options`		TEXT NOT NULL,
	`width`			VARCHAR(10) NOT NULL DEFAULT '400' ,
	`height`		VARCHAR(10) NOT NULL DEFAULT '300' ,
	PRIMARY KEY (section_id)
";

LEPTON_handle::install_table('mod_smoothgallery', $table_fields);
