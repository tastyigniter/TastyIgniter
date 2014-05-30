<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" >
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#settings">Settings</a></li>
				<li><a rel="#manager">Image Manager</a></li>
			</ul>
		</div>

		<div id="manager" class="wrap_content" style="display:block;">
			<div id="image-manager" style="padding: 3px 0px 0px 0px;">
				<iframe src="<?php echo base_url('admin/image_manager?popup=iframe'); ?>" width="100%" height="550" frameborder="0"></iframe>
			</div>
		</div>

		<div id="settings" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><span class="red">*</span> <b>Root Folder:</b><br />
						<font size="1">Image root folder name with NO TRAILING SLASH. Default: data</font></td>
						<td><input type="text" name="root_folder" value="<?php echo set_value('root_folder', $root_folder); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><span class="red">*</span> <b>Maximum File Size:</b><br />
						<font size="1">The maximum size (in kilobytes) limit for file when uploading.</font></td>
						<td><input type="text" name="max_size" value="<?php echo set_value('max_size', $max_size); ?>" class="textfield" size="5" /></td>
					</tr>
					<tr>
						<td><span class="red">*</span> <b>Thumbnail Size:</b><br />
						<font size="1">(Height x Width)</font></td>
						<td><input type="text" name="thumb_height" value="<?php echo set_value('thumb_height', $thumb_height); ?>" class="mini" size="5" /> x 
							<input type="text" name="thumb_width" value="<?php echo set_value('thumb_width', $thumb_width); ?>" class="mini" size="5" /></td>
					</tr>
					<tr>
						<td><span class="red">*</span> <b>Mini Thumbnail Size:</b><br />
						<font size="1">(Height x Width)</font></td>
						<td><input type="text" name="thumb_height_mini" value="<?php echo set_value('thumb_height_mini', $thumb_height_mini); ?>" class="mini" size="5" /> x 
							<input type="text" name="thumb_width_mini" value="<?php echo set_value('thumb_width_mini', $thumb_width_mini); ?>" class="mini" size="5" /></td>
					</tr>
					<tr>
						<td><b>Mini Thumbnail:</b><br />
						<font size="1">Show mini thumbnail</font></td>
						<td><select name="show_mini">
						<?php if ($show_mini === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Show Extension:</b><br />
						<font size="1">Show or hide file extension</font></td>
						<td><select name="show_ext">
						<?php if ($show_ext === '1') { ?>
							<option value="1" selected="selected">Show</option>
							<option value="0">Hide</option>
						<?php } else { ?>
							<option value="1">Show</option>
							<option value="0" selected="selected">Hide</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Uploads:</b><br />
						<font size="1">Enable or disable file uploading</font></td>
						<td><select name="uploads">
						<?php if ($uploads === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>New Folder:</b><br />
						<font size="1">Enable or disable folder creation</font></td>
						<td><select name="new_folder">
						<?php if ($new_folder === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Copy:</b><br />
						<font size="1">Enable or disable file/folder copy</font></td>
						<td><select name="copy">
						<?php if ($copy === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Move:</b><br />
						<font size="1">Enable or disable moving file/folder</font></td>
						<td><select name="move">
						<?php if ($move === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Rename:</b><br />
						<font size="1">Enable or disable file/folder rename</font></td>
						<td><select name="rename">
						<?php if ($rename === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Delete:</b><br />
						<font size="1">Enable or disable deleting file/folder</font></td>
						<td><select name="delete">
						<?php if ($delete === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><span class="red">*</span> <b>Allowed Extensions:</b><br />
						<font size="1">List of extensions allowed to be uploaded separated with “|”. e.g png|jpg</font></td>
						<td><textarea name="allowed_ext" cols="50" rows="5"><?php echo set_value('allowed_ext', $allowed_ext); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Hidden Files:</b><br />
						<font size="1">List of files to hide separated with “|”. e.g file1.jpg|file2.txt</font></td>
						<td><textarea name="hidden_files" cols="50" rows="5"><?php echo set_value('hidden_files', $hidden_files); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Hidden Folders:</b><br />
						<font size="1">List of folders to hide separated with “|”. e.g folder1|folder2</font></td>
						<td><textarea name="hidden_folders" cols="50" rows="5"><?php echo set_value('hidden_folders', $hidden_folders); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Transliteration:</b><br />
						<font size="1">Enable or disable conversion of all unwanted characters</font></td>
						<td><select name="transliteration">
						<?php if ($transliteration === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
							<option value="0">Disabled</option>
						<?php } else { ?>
							<option value="1">Enabled</option>
							<option value="0" selected="selected">Disabled</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Remember Last Folder:</b><br />
						<font size="1">How long to save last opened folder in cookie.</font></td>
						<td><select name="remember_days">
						<?php if ($remember_days === '1') { ?>
							<option value="1" selected="selected">24 Hours</option>
							<option value="3">3 Days</option>
							<option value="5">5 Days</option>
							<option value="7">1 Week</option>
						<?php } else if ($remember_days === '3') { ?>
							<option value="1">24 Hours</option>
							<option value="3" selected="selected">3 Days</option>
							<option value="5">5 Days</option>
							<option value="7">1 Week</option>
						<?php } else if ($remember_days === '5') { ?>
							<option value="1">24 Hours</option>
							<option value="3">3 Days</option>
							<option value="5" selected="selected">5 Days</option>
							<option value="7">1 Week</option>
						<?php } else if ($remember_days === '7') { ?>
							<option value="1">24 Hours</option>
							<option value="3">3 Days</option>
							<option value="5">5 Days</option>
							<option value="7" selected="selected">1 Week</option>
						<?php } else { ?>
							<option value="1">24 Hours</option>
							<option value="3">3 Days</option>
							<option value="5">5 Days</option>
							<option value="7" selected="selected">1 Week</option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Thumbs:</b><br />
						<font size="1">This will delete all created thumbs. Note thumbs are automatically created.</font></td>
						<td><a id="" href="<?php echo $delete_thumbs; ?>">Delete thumbs</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('a').click(function(){
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('delete_thumbs', 1) != -1) {
			if (!confirm('Cache can not be restored! Are you sure you want to do this?')) {
				return false;
			}
		}
	});
});
$('#tabs a').tabs();
//--></script>