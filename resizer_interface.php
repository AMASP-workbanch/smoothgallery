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

if (isset($_GET["imgfile"])) {

	if (!function_exists('divide_path_resizer')) {
		function divide_path_resizer($file,$self) {
			$self = str_replace('\\','/',$self);
			$file = str_replace('\\','/',$file);
			if (strtolower(substr($file,0,7))=='http://') $file = str_replace($_SERVER['HTTP_HOST'],'',substr($file,7));
			$self = str_replace($_SERVER['DOCUMENT_ROOT'],'',$self);
			$file = str_replace($_SERVER['DOCUMENT_ROOT'],'',$file);
	
			while (str_replace(stristr($file,'/'),'',$file)==str_replace(stristr($self,'/'),'',$self)) {
				$chunk=0;
				do $chunk++; while (substr($self,$chunk-1,1)==substr($file,$chunk-1,1) && substr($file,$chunk-1,1)!='/');
				$self=substr($self,$chunk);
				$file=substr($file,$chunk);
			}
	
			return str_repeat('../',substr_count($self,'/')).$file;
		}
	}

	if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
		$image = stripslashes( $_GET["imgfile"] );
	} else 	$image = $_GET["imgfile"];
	
	$image = divide_path_resizer($image,$_SERVER['PHP_SELF']);

	// prepare var & call resizer.php
	$_GET["imgfile"]=$image;

	include(dirname(__FILE__).'/resizer.php');
}
