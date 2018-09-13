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
 *	Add new row in the table
 *
 */
$fields = [
    "page_id"   => $page_id,
    "section_id"    => $section_id,
    "galleryDesc"   => "",
    "galleryTitle"  => "",
    "path"          => "/".MEDIA_DIRECTORY,
    "options"       => "",
    "width"         => "400",   // !
    "height"        => "300"    // !
    
];

$database->execute_query(
    "insert",
    TABLE_PREFIX."mod_smoothgallery",
    $fields
);

if($database->is_error())
{
    die($database->get_error());
}
