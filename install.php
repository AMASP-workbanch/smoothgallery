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
 *	Drop the table
 *
 */
$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_smoothgallery`");

/** 
 *	Create table
 *
 */
$mod_create_table = 'CREATE TABLE `'.TABLE_PREFIX.'mod_smoothgallery` (
	`section_id`	INT NOT NULL DEFAULT \'0\' ,
	`page_id`		INT NOT NULL DEFAULT \'0\' ,
	`galleryTitle`	VARCHAR(255) NOT NULL DEFAULT \'\' ,
	`galleryDesc`	VARCHAR(255) NOT NULL DEFAULT \'\' ,
	`path`			TEXT NOT NULL,
	`options`		TEXT NOT NULL,
	`width`			VARCHAR(10) NOT NULL DEFAULT \'400\' ,
	`height`		VARCHAR(10) NOT NULL DEFAULT \'300\' ,
	PRIMARY KEY (section_id))';
			
$database->query($mod_create_table);

/**
 *	Any errors?
 *
 */
if ( $database->is_error() )
{ 
    $admin->print_error($database->get_error(), $js_back);
}
