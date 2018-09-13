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

$mod_headers = array(
	'backend' => array(
        'css' => array(
		array(
			'media'  => 'all',
			'file'  => 'modules/lib_semantic/dist/semantic.min.css'
			)		
 		),				
		'js' => array(
			'modules/lib_jquery/jquery-core/jquery-core.min.js',
			'modules/lib_jquery/jquery-core/jquery-migrate.min.js',
			'modules/lib_semantic/dist/semantic.min.js'
		),
	),
	'frontend'  => array(
	    'css'   => array(
	        array(
	            'media' => 'all',
	            'file'  => 'modules/smoothgallery/css/frontend_ie.css'
	        )
	    
	    ),	    
	    'js'    => array(
	        'modules/smoothgallery/scripts/mootools.js',
	        'modules/smoothgallery/scripts/jd.gallery.js'
	    )
	)
);
?>

