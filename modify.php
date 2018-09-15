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

// Patch
$SGTEXT = $oSmoothgallery->language;

/**
 *	get infos from the Database
 *
 */
$fetch_page_content = array();
$database->execute_query(
    "SELECT * FROM `".TABLE_PREFIX."mod_smoothgallery` WHERE `section_id` = '".$section_id."'",
    true,
    $fetch_page_content,
    false
);

/**
 *	Set defaults
 *
 */
if (($fetch_page_content['options']) && ( $fetch_page_content['options'] != '' ) )
{
	$fetch_page_content['options'] = unserialize($fetch_page_content['options']);
} 
elseif (empty($fetch_page_content['options']) || ($fetch_page_content['options']!=Array()))
{
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

<form class="smooth_edit" action="<?php echo LEPTON_URL; ?>/modules/smoothgallery/save.php" method="post">

<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
<input type="hidden" name="hash_id" value="<?php echo $hash_id;  ?>" />
<table cellpadding="0" cellspacing="4" border="0" width="100%">
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['TITLE']; ?>:
		</td>
		<td>
			<input name="galleryTitle" type="text" value="<?php echo $fetch_page_content['galleryTitle']; ?>" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['DESCRIPTION']; ?>:
		</td>
		<td>
			<input name="galleryDesc" type="text" value="<?php echo $fetch_page_content['galleryDesc']; ?>" maxlength="255" />
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['DESCRIPTION_LOCATION']; ?>:
		</td>
		<td>
			<select name="options[x-putDescription]">
			    <option value="none" <?php if ($fetch_page_content['options']['x-putDescription']=='none') echo 'selected="selected"'; ?>><?php echo $SGTEXT['display_description_none']; ?></option>
				<option value="top" <?php if ($fetch_page_content['options']['x-putDescription']=='top') echo 'selected="selected"'; ?>><?php echo $SGTEXT['display_description_top']; ?></option>
				<option value="bottom" <?php if ($fetch_page_content['options']['x-putDescription']=='bottom') echo 'selected="selected"'; ?>><?php echo $SGTEXT['display_description_bottom']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="left" colspan="2">
			<p>&nbsp;</p>
		</td>
	</tr>
	<tr>
		<td class="setting_name sg2_left">
			<?php echo $SGTEXT['DIRECTORY']; ?>:
		</td>
		<td>
			<select name="path">
				<?php
				$folder_list=directory_list(LEPTON_PATH.MEDIA_DIRECTORY);
				array_push($folder_list,LEPTON_PATH.MEDIA_DIRECTORY);
				natsort($folder_list);
				foreach($folder_list AS $foldername) {
					$option_str  = '<option value="'.str_replace(LEPTON_PATH,'',$foldername).'"';
					$option_str .=  ($fetch_page_content['path']==str_replace(LEPTON_PATH,'',$foldername)) ? ' selected="selected"' : "" ;
					$option_str .= '>'.str_replace(LEPTON_PATH,'',$foldername)."</option>\n";
					
					echo $option_str;
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['LOAD_EXTENSIONS']; ?>:
		</td>
		<td>
			<input name="options[x-loadExtensions]" type="text" value="<?php echo $fetch_page_content['options']['x-loadExtensions']; ?>"/>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['SPLIT_CHAR']; ?>:
		</td>
		<td>
			<input name="options[x-splitChar]" type="text" value="<?php echo $fetch_page_content['options']['x-splitChar']; ?>" maxlength="1" /><span class="sg2_infotext"><?php echo $SGTEXT['SPLIT_CHAR_BANNED'] ?>: \*/|":?~&gt;&lt;</span>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['HEIGHT']; ?>:
		</td>
		<td>
			<input name="height" type="text" value="<?php echo $fetch_page_content['height']; ?>" style="width: 50px;" />&nbsp;<?php echo $SGTEXT['PX']; ?>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['WIDTH']; ?>:
		</td>
		<td>
			<input name="width" type="text" value="<?php echo $fetch_page_content['width']; ?>" style="width: 50px;" />&nbsp;<?php echo $SGTEXT['PX']; ?>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
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
		<td class="sg2_left">
			<?php echo $SGTEXT['FADE_DURATION']; ?>:
		</td>
		<td>
			<input name="options[fadeDuration]" type="text" value="<?php echo ($fetch_page_content['options']['fadeDuration'] != '') ? $fetch_page_content['options']['fadeDuration'] : 2000; ?>" />&nbsp;<?php echo $SGTEXT['MSEC']; ?>
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
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
		<td class="sg2_left">
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
		<td class="sg2_left">
			<?php echo $SGTEXT['TEXT_CARUSEL']; ?>:
		</td>
		<td>
			<input name="options[textShowCarousel]" type="text" value="<?php echo ($fetch_page_content['options']['textShowCarousel'] != '') ? $fetch_page_content['options']['textShowCarousel'] : 'Pictures'; ?>" />
		</td>
	</tr>
	<tr>
		<td class="sg2_left">
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
		<td class="sg2_left">
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
		<td class="sg2_left">
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
		<td class="sg2_left">
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
		<td class="sg2_left">
			<?php echo $SGTEXT['DELAY']; ?>:
		</td>
		<td>
			<input name="options[delay]" type="text" value="<?php echo ($fetch_page_content['options']['delay'] != '') ? $fetch_page_content['options']['delay']: 10000; ?>" maxlength="5" />&nbsp;<?php echo $SGTEXT['MSEC']; ?>
		</td>
	</tr>
<?php if(!is_dir(dirname(__FILE__).'/cache')) { ?>
	<tr>
		<td class="sg2_left">
			<?php echo $SGTEXT['CACHE_DIR']; ?>:
		</td>
		<td>
			<input name="cmd_enable" class="ui button orange" type="submit" value="<?php echo $SGTEXT['CACHE_ENABLE']; ?>" />
		</td>
	</tr>
<?php } else { ?>
	<tr>
		<td class="sg2_left">
			<?php
			$list = glob(dirname(__FILE__).'/cache/*'); 
			$dir_size = 0;
			if (is_array($list)) foreach ($list as $file_name) $dir_size += filesize($file_name);
			echo $SGTEXT['CACHE_DIR'].$SGTEXT['CACHE_SIZE'].':&nbsp;'.round( $dir_size/1024,2 ).'&nbsp;kB'; ?>
		</td>
		<td>
			<input name="cmd_empty" class="ui button green" type="submit" value="<?php echo $SGTEXT['CACHE_EMPTY']; ?>" />&nbsp;
			<input name="cmd_disable" class="ui button orange" type="submit" value="<?php echo $SGTEXT['CACHE_DISABLE']; ?>" />
		</td>
	</tr>
<?php } ?>
</table>

<table class="sg2_button">
	<tr>
		<td align="center">
			<input name="save" type="submit" class="ui button positive " value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;" />
		</td>
		<td align="center">
			<input type="button" class="ui button negative" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/index.php'; return false;" style="width: 100px; margin-top: 5px;" />
		</td>
	</tr>
</table>

</form>
<?php
	if (!defined("SMOOTH_LOADED"))
	{
	    define('SMOOTH_LOADED',true);
	}
?>