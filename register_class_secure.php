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
 
$files_to_register = array(
	'add.php',
	'delete.php',
	'functions.php',
	'modify.php',
	'save.php',
	'resizer_interface.php',
	'resizer.php'
);

LEPTON_secure::getInstance()->accessFiles( $files_to_register );

