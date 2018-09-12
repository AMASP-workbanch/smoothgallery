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

require('../../config.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

/**
 *	Looking for the hash_id
 *
 */
$hash_id = $admin->get_post("hash_id");
$test_id = $_SESSION['hash_id'];
unset($_SESSION['hash_id']);

/**
 *	Hash doesn't match ... we are called from no-where ...
 *	
 */
if ($hash_id != $test_id) die ( header('Location: ../../index.php') );

if ($admin->get_post('cmd_empty')) {
	$list = glob(dirname(__FILE__).'/cache/*');
	if ($list) foreach ($list as $file_name) if (strrchr($file_name,'.')!='.') unlink($file_name);
	$admin->print_success('Cache empty', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}
if ($admin->get_post('cmd_enable')) {
	if (!mkdir(dirname(__FILE__).'/cache')) {
		$admin->print_error('Cache enable FAILED', $js_back);
	} else {
		$admin->print_success('Cache enabled', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}
if ($admin->get_post('cmd_disable')) {
	$list = glob(dirname(__FILE__).'/cache/*');
	if ($list) foreach ($list as $file_name) if (strrchr($file_name,'.')!='.') unlink($file_name);
	if (!rmdir(dirname(__FILE__).'/cache')) {
		$admin->print_error('Cache disable FAILED', $js_back);
	} else {
		$admin->print_success('Cache disabled', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

if ( $admin->get_post('save') ) {

	$fouls = array(
		"<?php", "<?", "?>", "<script", "</script>", "\"", "'"
	);
	
	$names = array(
		'galleryTitle', 'galleryDesc', 'options', 'path'
	);
	
	foreach($names as $item) $_POST[$item] = str_replace($fouls, "", $_POST[$item]);
	foreach($names as $item) if ($item != "options") $_POST[$item] = $database->escapeString($_POST[$item]);
	
	/**
	 *	Look for changes
	 *
	 */
	$w = $admin->get_post('width');
	$h = $admin->get_post('height');
	$path = $admin->get_post('path');
	
	$options = $admin->get_post('options');
	if (!$options['x-loadExtensions']) $options['x-loadExtensions'] = 'jpg,jpeg,gif,png'; // something must be shown
	
	foreach($options as &$ref) {
		$ref = $database->escapeString($ref);
	}
	
	$options = serialize($options);
	
	$galleryTitle=$admin->get_post('galleryTitle');
	$galleryDesc=$admin->get_post('galleryDesc');
	
	/** 
	 *	Save changes from modify settings in database
	 *
	 */
	$fields = array(
		'galleryDesc'	=> $galleryDesc,
		'galleryTitle'	=> $galleryTitle,
		'path'			=> $path,
		'width'			=> $w,
		'height'		=> $h,
		'options'		=> $options
	);
	
	$query = "UPDATE `".TABLE_PREFIX."mod_smoothgallery` SET ";
	foreach($fields as $key=>$value) $query .= "`".$key."`='".$value."',";
	$query = substr($query,0, -1) ." WHERE `section_id`='".$section_id."'";
	
	$database->query($query);
	
	// Check if there is a database error, otherwise say successful
	if($database->is_error()) {
		$admin->print_error($database->get_error(), $js_back);
	} else {
		$admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

// Print admin footer
$admin->print_footer();
