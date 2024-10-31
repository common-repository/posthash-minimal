<?php
/*
Plugin Name: Posthash minimal
Plugin URI: http://alferi.se/2007/07/28/wordpress-plugin-posthash-minimal/
Description: Posthash minimal shows the md5/sha1/crc32-hash of the post.
Version: 0.1
Author: Alfred Jacob Eriksson
Author URI: http://alferi.se
*/
/*  Copyright 2007  Alfred Jacob Eriksson  (email : somerunce@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_option('aje_phm_hash_md5', '1', 'Posthash minimal-plugin: Whether to use md5 or not.');
add_option('aje_phm_hash_md5_text', 'md5-hash:', 'Posthash minimal-plugin: The text to display befor the md5-hash');
add_option('aje_phm_hash_sha1', '1', 'Posthash minimal-plugin: Whether to use sha1 or not.');
add_option('aje_phm_hash_sha1_text', 'sha1-hash:', 'Posthash minimal-plugin: The text to display befor the sha1-hash');
add_option('aje_phm_hash_crc32', '1', 'Posthash minimal-plugin: Whether to use crc32 or not.');
add_option('aje_phm_hash_crc32_text', 'crc32-hash:', 'Posthash minimal-plugin: The text to display befor the crc32-hash');
add_option('aje_phm_font_size', '90%', 'Posthash minimal-plugin: Font size at hash.');
add_option('aje_phm_font_color', '#999999', 'Posthash minimal-plugin: Font color at hash.');

add_action( 'admin_menu', 'aje_phm_add_options' );

function aje_phm_add_options() {
	add_options_page('Posthash minimal', 'Posthash minimal', 8, __FILE__, 'aje_phm_options');
}

function aje_phm_options() {
	if (isset($_POST['phm_update'])) {
		check_admin_referer();

		$md5 = ($_POST['md5'] ? $_POST['md5'] : 0);
		$md5_text = ($_POST['md5_text'] ? $_POST['md5_text'] : 'md5-hash:');
		$sha1 = ($_POST['sha1'] ? $_POST['sha1'] : 0);
		$sha1_text = ($_POST['sha1_text'] ? $_POST['sha1_text'] : 'sha1-hash:');
		$crc32 = ($_POST['crc32'] ? $_POST['crc32'] : 0);
		$crc32_text = ($_POST['crc32_text'] ? $_POST['crc32_text'] : 'crc32-hash:');
		$fontsize = ($_POST['fontsize'] ? $_POST['fontsize'] : '90%');
		$fontcolor = ($_POST['fontcolor'] ? $_POST['fontcolor'] : '#999999');
		update_option('aje_phm_hash_md5', $md5);
		update_option('aje_phm_hash_md5_text', $md5_text);
		update_option('aje_phm_hash_sha1', $sha1);
		update_option('aje_phm_hash_sha1_text', $sha1_text);
		update_option('aje_phm_hash_crc32', $crc32);
		update_option('aje_phm_hash_crc32_text', $crc32_text);
		update_option('aje_phm_font_size', $fontsize);
		update_option('aje_phm_font_color', $fontcolor);
		
		echo '<div class="updated"><p><strong>Posthash minimals settings is updated</strong></p></div>';
	}
	?>
		<div class="wrap">
			<form method="post" action="options-general.php?page=aje_posthash_minimal.php">
			<h2>Posthash minimal options</h2>
			<fieldset class="options">
				<legend>General options</legend>
				Check the hashes you want to display on each post.<br/><br/>
				Font size:<br/>
				<input type="text" name="fontsize" value="<?=get_option('aje_phm_font_size')?>" size="7" /><br/>
				Font color:<br/>
				<input type="text" name="fontcolor" value="<?=get_option('aje_phm_font_color')?>" size="7" /><br/>
				<table class="editform" cellspacing="2" cellpadding="5">
					<tr>
						<th>
							Display text
						</th>
						<th>
							Check
						</th>
						<th>
							Hash
						</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="md5_text" value="<?=get_option('aje_phm_hash_md5_text')?>" size="7" />
						</td>
						<td>
							<input type="checkbox" name="md5" value="1" <?php echo (get_option('aje_phm_hash_md5') ? 'checked="checked" ' : ''); ?>/>
						</td>
						<td>
							md5
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="sha1_text" value="<?=get_option('aje_phm_hash_sha1_text')?>" size="7" />
						</td>
						<td>
							<input type="checkbox" name="sha1" value="1" <?php echo (get_option('aje_phm_hash_sha1') ? 'checked="checked" ' : ''); ?>/>
						</td>
						<td>
							sha1
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="crc32_text" value="<?=get_option('aje_phm_hash_crc32_text')?>" size="7" />
						</td>
						<td>
							<input type="checkbox" name="crc32" value="1" <?php echo (get_option('aje_phm_hash_crc32') ? 'checked="checked" ' : ''); ?>/>
						</td>
						<td>
							crc32
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="phm_update" value="Update" />
						</td>
					</tr>
				</table>

			</fieldset>
			</form>
		</div>
	<?php
}

function aje_phm_hash($string) {
	$md5 = get_option('aje_phm_hash_md5');
	$md5_text = get_option('aje_phm_hash_md5_text');
	$sha1 = get_option('aje_phm_hash_sha1');
	$sha1_text = get_option('aje_phm_hash_sha1_text');
	$crc32 = get_option('aje_phm_hash_crc32');
	$crc32_text = get_option('aje_phm_hash_crc32_text');
	$fontsize = get_option('aje_phm_font_size');
	$fontcolor = get_option('aje_phm_font_color');
	if($md5) {
		$return .= '<span style="color: ' . $fontcolor . '; font-size: ' . $fontsize . ';">' . $md5_text . ' ' . md5($string) . '</span><br/>
		';
	}
	if($sha1) {
		$return .= '<span style="color: ' . $fontcolor . '; font-size: ' . $fontsize . ';">' . $sha1_text . ' ' . sha1($string) . '</span><br/>
		';
	}
	if($crc32) {
		$return .= '<span style="color: ' . $fontcolor . '; font-size: ' . $fontsize . ';">' . $crc32_text . ' ' . crc32($string) . '</span><br/>
		';
	}
	$return = $string . '<br/>
	<br/>
	' . $return;
	return $return;
}

function aje_phm_hash_filter($content) {
	return aje_phm_hash($content);
}

add_filter('the_content', 'aje_phm_hash_filter');
?>