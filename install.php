<?php

/**
 *	
 *	Website Baker Project <http://www.websitebaker.org/>
 *	Copyright (C) 2004-2007, Ryan Djurovich
 *	
 *	Website Baker is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *	
 *	Website Baker is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *	
 *	You should have received a copy of the GNU General Public License
 *	along with Website Baker; if not, write to the Free Software
 *	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
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
