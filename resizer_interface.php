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
 *	
 *	Image resizer (resizer.php) interface to Website Baker Smooth Gallery module
 *	Author: ToS
 *	Version: 0.1
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
