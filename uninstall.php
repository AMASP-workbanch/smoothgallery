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
if(!defined('LEPTON_PATH')) die( header('Location: ../../index.php') );

/**
 *	Delete the modul table
 *
 */
$database->query("DROP TABLE `".TABLE_PREFIX."mod_smoothgallery`");
