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

require_once(WB_PATH.'/framework/functions.php');

if(!empty($div_name)) {
	$gallery_count++;
	echo("<br /><br />");
} else {
	$gallery_count=0;
}

/**
 *	get content from database
 *
 */
$query_content = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_smoothgallery` WHERE `section_id` = '".$section_id."'");

/**
 *	generate random name in case that there are two galleries in one page
 *
 */
$div_name = 'gallery_'.mt_rand(1,23876);

if ( $query_content->numRows() > 0 ) {
	$fetch_content = $query_content->fetchRow();
	$WB_PATH	= WB_PATH;
	$WB_URL		= WB_URL;
	$path		= $fetch_content['path'];
	$options	= unserialize($fetch_content['options']);
	$w			= $fetch_content['width'];
	$h			= $fetch_content['height'];
	$title		= $fetch_content['galleryTitle'];
	$description = $fetch_content['galleryDesc'];
	
	// store for second gallery
	if (!isset ($next_gallery)) $next_gallery = ""; $next_gallery .="start_".$div_name."();";

	/**
	 *	give the output
	 *
	 */
	if (!$gallery_count) {
	
		$html  = "<script src=\"".WB_URL."/modules/smoothgallery/scripts/mootools.js\" type=\"text/javascript\"></script>\n";
		$html .= "<script src=\"".WB_URL."/modules/smoothgallery/scripts/jd.gallery.js\" type=\"text/javascript\"></script>\n";
		$html .= "<!--[if IE]>\n";
		$html .= "<link rel=\"stylesheet\" href=\"".$WB_URL."/modules/smoothgallery/frontend_ie.css\"></link>\n";
		$html .= "<![endif]-->\n";
	
		echo $html;
	}	
	
	$div_style = " style=\"width:".$w. "px !important; height:".$h."px !important; z-index:5; display: none; border: 1px solid #000; \"";


	$script  = "<script type=\"text/javascript\">\n";
	$script .= "function start_".$div_name."() {\n";
	$script .="\tvar ".$div_name ."= new gallery($('".$div_name."'), {\n";

	foreach ($options as $key => $val) if (strtolower(substr($key,0,2))!='x-') $script .= "\t\t\t".$key.": ".($key=='textShowCarousel' ? "'".$val."'" : $val).",\n";
	
	$script .= "\n";
	$script .="\tthumbGenerator: '".$WB_URL."/modules/smoothgallery/resizer_interface.php'});\n";
		
	if ($options['x-windowedLinks']=='_blank') {
		$script .= $div_name.".currentLink.onclick = function() {\n";
		$script .= "\twindow.open(this.href);\n";
		$script .= "\treturn false;\n";
		$script .= "}.bind(".$div_name.".currentLink);\n";
	}
	$script .= "}\n";
	
	echo $script;
	
	if (!$gallery_count) { ?>
		// moved to frontend.js	
		window.onDomReady( rollGalleries );

	<?php } ?>
	funcList[<?php echo $gallery_count ?>]= 'start_<?php echo $div_name ?>()';
	</script>
	<?php
	// start HTML
	if ($title) {
		echo "<h2>".$title."</h2>";
	}
	if ($description && $options['x-putDescription']=='top') {
		echo "<p>".$description."</p>";
	} else if ($title) {
		echo '<br />';
	}

	// scan for & add files
	$arr = array();
	$file_ext = explode(',',$options['x-loadExtensions']);
	$file_list = file_list(WB_PATH.$path,array('*.php'));
	foreach ($file_list as $file) {
		if (is_integer(array_search(strtolower(substr(strrchr($file,'.'),1)), $file_ext)))
			$arr[]=basename($file);
	}
	natsort($arr);


	/** 
	 *	begin gallery DIV in a table
	 *
	 */
	?>
	<table width="98%" align="center" border="0">
		<tr>
			<td width="100%" align="center">
				<div id="<?php echo $div_name ?>" <?php echo $div_style; ?> >
					<?php
					// list files
					if (!empty($arr)) {
						foreach ($arr as $img_path) {
							// strip path & extension
							$file=basename($img_path);
							// generate description
							$temp = explode(".", $file);
							array_pop($temp);
							$desc[0]=implode(".", $temp);
							$desc[1]='&nbsp;';
							if (!empty($options['x-splitChar']) && !stristr('\\*|/":?~<>',$options['x-splitChar'][0] )) {
								$split=substr($options['x-splitChar'],0,1);
								if (substr_count(substr($file,0, -4),$split)) $desc = explode($split,substr($file,0, -4), 2);
							}
							
							/**
							 *
							 *
							 */
							$html  = "<div class=\"imageElement\">\n";
							$html .= "<h3>" . $desc[0] . "</h3>\n";
							$html .= "<p>" . $desc[1] . "</p>\n";
							
							$file_name = str_replace(
									array("'", " "), 
									array("%27", "%20"), 
									$file
								);
							
							if ($options['x-windowedLinks']=='jscript') {
								$html .= "<a href=\"javascript: opnWin('". $WB_URL.$path.'/'.$file_name."', ";
								
								$size = getimagesize($WB_PATH.$path.'/'.$file);
								
								$html .= $size[0].','.$size[1];
								
								$html .= ");\" title=\"open image\" class=\"open\" ></a>\n\n";
							
							} else {
								
								$html .= "<a href=\"". $WB_URL.$path.'/'. $file_name . "\" target=\"_top\" title=\"open image\" class=\"open\"></a>\n\n";
							}

							if ($options['x-useResizer']=='false') {
									$html .= "<img src=\"" . $WB_URL.$path.'/'. $file_name ."\" class=\"full\" alt=\"\" />\n";
							} else {
									$html .= "<img src=\"".$WB_URL."/modules/smoothgallery/resizer_interface.php?imgfile=". $WB_URL.$path.'/'.$file_name."&amp;max_width=" . $w ." &amp;max_height=" . $h . "\" class=\"full\" alt=\"\" />\n";
							}
							
							$html .= "<img src=\"" . $WB_URL . "/modules/smoothgallery/resizer_interface.php?imgfile=" . $WB_URL.$path.'/'. $file_name. "&amp;max_width=100&amp;max_height=75\" class=\"thumbnail\" alt=\"\" />\n\n";
							$html .= "\n</div>\n";
							
							echo $html;
						}
					}
					?>
				</div>
			</td>
		</tr>
	</table>
	<?php
	if ($description && $options['x-putDescription']=='bottom') {
		echo "<p>".$description."</p>";
	}
} else {
	echo "Page content not found";
}
