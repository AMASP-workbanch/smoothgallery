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

$oSmoothgallery = smoothgallery::getInstance();

if( false === $oSmoothgallery->bAlreadyInitialized )
{
	// echo("<br /><br />");
}

if(!empty($div_name)) 
{
	$gallery_count++;
	echo("<br /><br />");
} else {
	$gallery_count=0;
}

/**
 *	get content from database
 *
 */
$settings = array();
$database->execute_query(
    "SELECT * FROM `".TABLE_PREFIX."mod_smoothgallery` WHERE `section_id` = '".$section_id."'",
    true,
    $settings,
    false
);

/**
 *	Generate random name in case that there are two galleries in one page
 *
 */
LEPTON_handle::register("random_string");
$div_name = 'gallery_'.random_string(8);

if ( count($settings) > 0 ) {
	$path		= $settings['path'];
	$options	= unserialize($settings['options']);
	
	// store for second gallery 
	//  Aldus: not realy clear!
	if (!isset ($next_gallery))
	{
	    $next_gallery = ""; $next_gallery .="start_".$div_name."();";
    }
    	
	LEPTON_handle::register("file_list");
	$allFiles = file_list(
	    LEPTON_PATH.$path,
	    array(),
	    false,
	    "jpg|png|gif",
	    LEPTON_PATH
	);
	
	$split_str = (!empty($options['x-splitChar']) && !stristr('\\*|/":?~<>',$options['x-splitChar'][0] ))
	    ? $options['x-splitChar'][0]
	    : ""
	    ;

	$allImages = array();
	foreach($allFiles as $img_path)
	{
        $file=basename($img_path);
        if($split_str != "")
		{
            $desc = explode($split_str,substr($file,0, -4), 2);
            if(count($desc) < 2)
            {
                $desc[]="";
            }
		} else {
		
            $temp = explode(".", $file);
            array_pop($temp);
            $desc = array(
		        implode(".", $temp),
                '&nbsp;'
            );
		}

        $allImages[] = array(
            'file'          => LEPTON_URL.$img_path,
            'name'          => $desc[0],
            'description'   => str_replace("_", " ", $desc[1]),
            'size'          => getimagesize(LEPTON_PATH.$img_path)
        );  
	}
	// die(LEPTON_tools::display( $allImages ));
	
    $oTWIG = lib_twig_box::getInstance();
    $oTWIG->registerModule("smoothgallery");
    echo $oTWIG->render(
        "@smoothgallery/view.lte",
        [
            'module'        => $oSmoothgallery,
            'settings'      => $settings, 
            'gallery_name'  => $div_name,
            'options'       => $options,
            'allImages'     => $allImages
        ]
    );
}
$oSmoothgallery->iInternalCount++;
$oSmoothgallery->bAlreadyInitialized = true;