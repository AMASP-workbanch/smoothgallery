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

/**
 *	Load Language file
 */
$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once ( !file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang );

/**
 *	get infos from the Database
 *
 */
$query_page_content = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_smoothgallery` WHERE `section_id` = '".$section_id."'");
$fetch_page_content = $query_page_content->fetchRow();

/**
 *	Set defaults
 *
 */
if (($fetch_page_content['options']) && ( $fetch_page_content['options'] != '' ) ) {
	$fetch_page_content['options'] = unserialize($fetch_page_content['options']);
} elseif (empty($fetch_page_content['options']) || ($fetch_page_content['options']!=Array())) {
	$fetch_page_content['options'] = array(
		'x-putDescription'	=> 'top',
    	'x-loadExtensions'	=> 'jpg,gif,png',
    	'x-splitChar'		=> '',
    	'x-useResizer'		=> 'false',
    	'fadeDuration'		=> '500',
    	'showArrows'		=> 'true',
    	'showCarousel'		=> 'true',
    	'showInfopane'		=> 'true',
    	'embedLinks'		=> 'true',
    	'x-windowedLinks'	=> 'jscript',
    	'timed'	=> 'false',
    	'delay'	=> '9000',
    	'textShowCarousel' => "Pictures"
	);
	
}

if (!isset($fetch_page_content['options']['x-loadExtensions']) || !$fetch_page_content['options']['x-loadExtensions']) 
	$fetch_page_content['options']['x-loadExtensions'] = 'jpg,gif,png';

if (!isset($fetch_page_content['options']['x-useResizer']) ||!$fetch_page_content['options']['x-useResizer'])
	$fetch_page_content['options']['x-useResizer'] = 'false';

if (!$fetch_page_content['width'])  $fetch_page_content['width'] = '400';
if (!$fetch_page_content['height']) $fetch_page_content['height'] = '300';

/**
 *	Building a hash_id
 *
 */
$hash_id = md5( time() );
$_SESSION['hash_id'] = $hash_id;

?>

<form class="smooth_edit" action="<?php echo WB_URL; ?>/modules/smoothgallery/save.php" method="post">

<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
<input type="hidden" name="hash_id" value="<?php echo $hash_id;  ?>" />
<table cellpadding="0" cellspacing="4" border="0" width="100%">
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['TITLE']; ?>:
		</td>
		<td>
			<input name="galleryTitle" type="text" value="<?php echo $fetch_page_content['galleryTitle']; ?>" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['DESCRIPTION']; ?>:
		</td>
		<td>
			<input name="galleryDesc" type="text" value="<?php echo $fetch_page_content['galleryDesc']; ?>" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['DESCRIPTION_LOCATION']; ?>:
		</td>
		<td>
			<select name="options[x-putDescription]">
				<option value="bottom" <?php if ($fetch_page_content['options']['x-putDescription']=='bottom') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="top" <?php if ($fetch_page_content['options']['x-putDescription']=='top') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="left" colspan="2">
			<hr size="1" />
		</td>
	</tr>
	<tr>
		<td class="setting_name" align="right">
			<?php echo $SGTEXT['DIRECTORY']; ?>:
		</td>
		<td>
			<select name="path">
				<?php
				$folder_list=directory_list(WB_PATH.MEDIA_DIRECTORY);
				array_push($folder_list,WB_PATH.MEDIA_DIRECTORY);
				natsort($folder_list);
				foreach($folder_list AS $foldername) {
					$option_str  = '<option value="'.str_replace(WB_PATH,'',$foldername).'"';
					$option_str .=  ($fetch_page_content['path']==str_replace(WB_PATH,'',$foldername)) ? ' selected="selected"' : "" ;
					$option_str .= '>'.str_replace(WB_PATH,'',$foldername)."</option>\n";
					
					echo $option_str;
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['LOAD_EXTENSIONS']; ?>:
		</td>
		<td>
			<input name="options[x-loadExtensions]" type="text" value="<?php echo $fetch_page_content['options']['x-loadExtensions']; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['SPLIT_CHAR']; ?>:
		</td>
		<td>
			<input name="options[x-splitChar]" type="text" value="<?php echo $fetch_page_content['options']['x-splitChar']; ?>" maxlength="1" />&nbsp;<font color="#990000"><?php echo $SGTEXT['SPLIT_CHAR_BANNED'] ?>: \*/|":?~&gt;&lt;</font>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['HEIGHT']; ?>:
		</td>
		<td>
			<input name="height" type="text" value="<?php echo $fetch_page_content['height']; ?>" style="width: 50px;" />&nbsp;<?php echo $SGTEXT['PX']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['WIDTH']; ?>:
		</td>
		<td>
			<input name="width" type="text" value="<?php echo $fetch_page_content['width']; ?>" style="width: 50px;" />&nbsp;<?php echo $SGTEXT['PX']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['USE_RESIZER_BIG']; ?>:
		</td>
		<td>
			<select name="options[x-useResizer]">
				<option value="true" <?php if ($fetch_page_content['options']['x-useResizer']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['x-useResizer']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['FADE_DURATION']; ?>:
		</td>
		<td>
			<input name="options[fadeDuration]" type="text" value="<?php echo ($fetch_page_content['options']['fadeDuration'] != '') ? $fetch_page_content['options']['fadeDuration'] : 2000; ?>" />&nbsp;<?php echo $SGTEXT['MSEC']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['PREV_NEXT']; ?>:
		</td>
		<td>
			<select name="options[showArrows]">
				<option value="true" <?php if ($fetch_page_content['options']['showArrows']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['showArrows']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['THUMBS']; ?>:
		</td>
		<td>
			<select name="options[showCarousel]">
				<option value="true" <?php if ($fetch_page_content['options']['showCarousel']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['showCarousel']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['TEXT_CARUSEL']; ?>:
		</td>
		<td>
			<input name="options[textShowCarousel]" type="text" value="<?php echo ($fetch_page_content['options']['textShowCarousel'] != '') ? $fetch_page_content['options']['textShowCarousel'] : 'Pictures'; ?>" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['INFO_PANEL']; ?>:
		</td>
		<td>
			<select name="options[showInfopane]">
				<option value="true" <?php if ($fetch_page_content['options']['showInfopane']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['showInfopane']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['DIRECT_LINK']; ?>:
		</td>
		<td>
			<select name="options[embedLinks]">
				<option value="true" <?php if ($fetch_page_content['options']['embedLinks']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['embedLinks']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['DIRECT_LINK_OPEN_OPTION']; ?>:
		</td>
		<td>
			<select name="options[x-windowedLinks]">
				<option value="jscript" <?php if ($fetch_page_content['options']['x-windowedLinks']=='jscript') echo 'selected="selected"'; ?>><?php echo $SGTEXT['WINDOW']; ?></option>
				<option value="_top" <?php if ($fetch_page_content['options']['x-windowedLinks']=='_top') echo 'selected="selected"'; ?>><?php echo $SGTEXT['_TOP']; ?></option>
				<option value="_blank" <?php if ($fetch_page_content['options']['x-windowedLinks']=='_blank') echo 'selected="selected"'; ?>><?php echo $SGTEXT['_BLANK']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['SLIDESHOW']; ?>:
		</td>
		<td>
			<select name="options[timed]">
				<option value="true" <?php if ($fetch_page_content['options']['timed']=='true') echo 'selected="selected"'; ?>><?php echo $SGTEXT['TRUE']; ?></option>
				<option value="false" <?php if ($fetch_page_content['options']['timed']=='false') echo 'selected="selected"'; ?>><?php echo $SGTEXT['FALSE']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['DELAY']; ?>:
		</td>
		<td>
			<input name="options[delay]" type="text" value="<?php echo ($fetch_page_content['options']['delay'] != '') ? $fetch_page_content['options']['delay']: 10000; ?>" maxlength="5" />&nbsp;<?php echo $SGTEXT['MSEC']; ?>
		</td>
	</tr>
<?php if(!is_dir(dirname(__FILE__).'/cache')) { ?>
	<tr>
		<td valign="top" align="right">
			<?php echo $SGTEXT['CACHE_DIR']; ?>:
		</td>
		<td>
			<input name="cmd_enable" type="submit" value="<?php echo $SGTEXT['CACHE_ENABLE']; ?>" style="width: 100px; margin-top: -2px;" />
		</td>
	</tr>
<?php } else { ?>
	<tr>
		<td align="right">
			<?php
			$list = glob(dirname(__FILE__).'/cache/*'); 
			$dir_size = 0;
			if (is_array($list)) foreach ($list as $file_name) $dir_size += filesize($file_name);
			echo $SGTEXT['CACHE_DIR'].$SGTEXT['CACHE_SIZE'].':&nbsp;'.round( $dir_size/1024,2 ).'&nbsp;kB'; ?>
		</td>
		<td>
			<input name="cmd_empty" type="submit" value="<?php echo $SGTEXT['CACHE_EMPTY']; ?>" style="width: 100px; margin-top: -2px;" />&nbsp;
			<input name="cmd_disable" type="submit" value="<?php echo $SGTEXT['CACHE_DISABLE']; ?>" style="width: 100px; margin-top: -2px;" />
		</td>
	</tr>
<?php } ?>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="left">
			<input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;" />
		</td>
		<td align="right">
			<input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/index.php'; return false;" style="width: 100px; margin-top: 5px;" />
		</td>
	</tr>
</table>
</form>
<hr size="1" />
<p>&nbsp;<br /></p>
<?php
	if (!defined("SMOOTH_LOADED"))
	{
	    define('SMOOTH_LOADED',true);
	}
?>