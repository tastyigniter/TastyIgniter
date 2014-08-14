<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" >
			<div class="tab-content">
				<div id="settings" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-root-folder" class="col-sm-2 control-label"><span class="red">*</span> Root Folder:
							<span class="help-block">Image root folder name with NO TRAILING SLASH. Default: data</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="root_folder" id="input-root-folder" class="form-control" value="<?php echo set_value('root_folder', $root_folder); ?>" />
							<?php echo form_error('root_folder', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-max-size" class="col-sm-2 control-label"><span class="red">*</span> Maximum File Size:
							<span class="help-block">The maximum size (in kilobytes) limit for file when uploading.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="max_size" id="input-max-size" class="form-control" value="<?php echo set_value('max_size', $max_size); ?>" size="5" />
							<?php echo form_error('max_size', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"><span class="red">*</span> Thumbnail Size:
							<span class="help-block">(Height x Width)</span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="thumb_height" class="form-control" value="<?php echo set_value('thumb_height', $thumb_height); ?>" class="mini" size="5" />
								<input type="text" name="thumb_width" class="form-control" value="<?php echo set_value('thumb_width', $thumb_width); ?>" class="mini" size="5" />
							</div>
							<?php echo form_error('thumb_height', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('thumb_width', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"><span class="red">*</span> Mini Thumbnail Size:
							<span class="help-block">(Height x Width)</span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="thumb_height_mini" class="form-control" value="<?php echo set_value('thumb_height_mini', $thumb_height_mini); ?>" class="mini" size="5" />
								<input type="text" name="thumb_width_mini" class="form-control" value="<?php echo set_value('thumb_width_mini', $thumb_width_mini); ?>" class="mini" size="5" />
							</div>
							<?php echo form_error('thumb_height_mini', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('thumb_width_mini', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-show-mini" class="col-sm-2 control-label">Mini Thumbnail:
							<span class="help-block">Show mini thumbnail</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($show_mini == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="show_mini" value="0" <?php echo set_radio('show_mini', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="show_mini" value="1" <?php echo set_radio('show_mini', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="show_mini" value="0" <?php echo set_radio('show_mini', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="show_mini" value="1" <?php echo set_radio('show_mini', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('show_mini', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-show-ext" class="col-sm-2 control-label">Show Extension:
							<span class="help-block">Show or hide file extension</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($show_ext == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="show_ext" value="0" <?php echo set_radio('show_ext', '0'); ?>>Hide</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="show_ext" value="1" <?php echo set_radio('show_ext', '1', TRUE); ?>>Show</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="show_ext" value="0" <?php echo set_radio('show_ext', '0', TRUE); ?>>Hide</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="show_ext" value="1" <?php echo set_radio('show_ext', '1'); ?>>Show</label>
								<?php } ?>  
							</div>
							<?php echo form_error('show_ext', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-uploads" class="col-sm-2 control-label">Uploads:
							<span class="help-block">Enable or disable file uploading</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($uploads == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="uploads" value="0" <?php echo set_radio('uploads', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="uploads" value="1" <?php echo set_radio('uploads', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="uploads" value="0" <?php echo set_radio('uploads', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="uploads" value="1" <?php echo set_radio('uploads', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('uploads', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-new-folder" class="col-sm-2 control-label">New Folder:
							<span class="help-block">Enable or disable folder creation</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($new_folder == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="new_folder" value="0" <?php echo set_radio('new_folder', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="new_folder" value="1" <?php echo set_radio('new_folder', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="new_folder" value="0" <?php echo set_radio('new_folder', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="new_folder" value="1" <?php echo set_radio('new_folder', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('new_folder', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-copy" class="col-sm-2 control-label">Copy:
							<span class="help-block">Enable or disable file/folder copy</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($copy == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="copy" value="0" <?php echo set_radio('copy', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="copy" value="1" <?php echo set_radio('copy', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="copy" value="0" <?php echo set_radio('copy', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="copy" value="1" <?php echo set_radio('copy', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('copy', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-move" class="col-sm-2 control-label">Move:
							<span class="help-block">Enable or disable moving file/folder</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($move == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="move" value="0" <?php echo set_radio('move', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="move" value="1" <?php echo set_radio('move', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="move" value="0" <?php echo set_radio('move', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="move" value="1" <?php echo set_radio('move', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('move', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-rename" class="col-sm-2 control-label">Rename:
							<span class="help-block">Enable or disable file/folder rename</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($rename == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="rename" value="0" <?php echo set_radio('rename', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="rename" value="1" <?php echo set_radio('rename', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="rename" value="0" <?php echo set_radio('rename', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="rename" value="1" <?php echo set_radio('rename', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('rename', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delete" class="col-sm-2 control-label">Delete:
							<span class="help-block">Enable or disable deleting file/folder</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($delete == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="delete" value="0" <?php echo set_radio('delete', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="delete" value="1" <?php echo set_radio('delete', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="delete" value="0" <?php echo set_radio('delete', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="delete" value="1" <?php echo set_radio('delete', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('delete', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-allowed-ext" class="col-sm-2 control-label"><span class="red">*</span> Allowed Extensions:
							<span class="help-block">List of extensions allowed to be uploaded separated with “|”. e.g png|jpg</span>
						</label>
						<div class="col-sm-5">
							<textarea name="allowed_ext" id="input-allowed-ext" class="form-control" rows="5"><?php echo set_value('allowed_ext', $allowed_ext); ?></textarea>
							<?php echo form_error('allowed_ext', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-hidden-files" class="col-sm-2 control-label">Hidden Files:
							<span class="help-block">List of files to hide separated with “|”. e.g file1.jpg|file2.txt</span>
						</label>
						<div class="col-sm-5">
							<textarea name="hidden_files" id="input-hidden-files" class="form-control" rows="5"><?php echo set_value('hidden_files', $hidden_files); ?></textarea>
							<?php echo form_error('hidden_files', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-hidden-folders" class="col-sm-2 control-label">Hidden Folders:
							<span class="help-block">List of folders to hide separated with “|”. e.g folder1|folder2</span>
						</label>
						<div class="col-sm-5">
							<textarea name="hidden_folders" id="input-hidden-folders" class="form-control" rows="5"><?php echo set_value('hidden_folders', $hidden_folders); ?></textarea>
							<?php echo form_error('hidden_folders', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-transliteration" class="col-sm-2 control-label">Transliteration:
							<span class="help-block">Enable or disable conversion of all unwanted characters</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($transliteration == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="transliteration" value="0" <?php echo set_radio('transliteration', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="transliteration" value="1" <?php echo set_radio('transliteration', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>  
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="transliteration" value="0" <?php echo set_radio('transliteration', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="transliteration" value="1" <?php echo set_radio('transliteration', '1'); ?>>Enabled</label>
								<?php } ?>  
							</div>
							<?php echo form_error('transliteration', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-remember-days" class="col-sm-2 control-label">Remember Last Folder:
							<span class="help-block">How long to save last opened folder in cookie.</span>
						</label>
						<div class="col-sm-5">
							<select name="remember_days" id="input-remember-days" class="form-control">
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
							</select>
							<?php echo form_error('remember_days', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Thumbs:
							<span class="help-block">This will delete all created thumbs. Note thumbs are automatically created.</span>
						</label>
						<div class="col-sm-5">
							<a class="text-danger" href="<?php echo $delete_thumbs; ?>">Delete thumbs</a>
						</div>
					</div>
				</div>
			</div>
		</form>
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
//--></script>
<?php echo $footer; ?>