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


/**
 *	prevent this file from being accessed directly
 */
if(!defined('WB_PATH')) die( header('Location: ../../index.php') );


/**
 *	this adds a new line in the database when you add your modul to a page
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
$sQuery = "INSERT INTO `".TABLE_PREFIX."mod_smoothgallery` (`";
$sQuery .= implode("`,`", array_keys($fields))."`) VALUES ('";
$sQuery .= implode("','", array_values($fields))."')";


$database->query( $sQuery );

if($database->is_error())
{
    die($database->get_error());
}
