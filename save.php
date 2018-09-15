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

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(LEPTON_PATH.'/modules/admin.php');

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
if ($hash_id != $test_id)
{
    die ( header('Location: ../../index.php') );
}

if ($admin->get_post('cmd_empty'))
{
	$list = glob(dirname(__FILE__).'/cache/*');
	if ($list) foreach ($list as $file_name) if (strrchr($file_name,'.')!='.') unlink($file_name);
	$admin->print_success('Cache empty', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

if ($admin->get_post('cmd_enable'))
{
	if (!mkdir(dirname(__FILE__).'/cache')) {
		$admin->print_error('Cache enable FAILED', $js_back);
	} else {
	    copy( __DIR__."/index.php", __DIR__."/cache/index.php");
		$admin->print_success('Cache enabled', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

if ($admin->get_post('cmd_disable'))
{
	LEPTON_handle::register("rm_full_dir");
	rm_full_dir( __DIR__.'/cache' );
	$admin->print_success('Cache disabled', ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

if ( $admin->get_post('save') ) {

	$fouls = array(
		"<?php", "<?", "?>", "<script", "</script>", "\"", "'"
	);
	
	$names = array(
		'galleryTitle', 'galleryDesc', 'options', 'path'
	);
	
	foreach($names as $item)
	{
	    $_POST[$item] = str_replace($fouls, "", $_POST[$item]);
	}
	
	/**
	 *	Look for changes
	 *
	 */
	$w = $admin->get_post('width');
	$h = $admin->get_post('height');
	$path = $admin->get_post('path');
	
	$options = $admin->get_post('options');
	if (!$options['x-loadExtensions']) $options['x-loadExtensions'] = 'jpg,jpeg,gif,png'; // something must be shown
	

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
	
	$database->build_and_execute(
	    'update',
	    TABLE_PREFIX."mod_smoothgallery",
	    $fields,
	    "`section_id`=".$section_id
	);
	
	// Check if there is a database error, otherwise say successful
	if($database->is_error()) {
		$admin->print_error($database->get_error(), $js_back);
	} else {
		$admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
}

// Print admin footer
$admin->print_footer();
