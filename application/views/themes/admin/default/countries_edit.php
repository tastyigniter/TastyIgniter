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
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Country:</label>
						<div class="col-sm-5">
							<input type="text" name="country_name" id="input-name" class="form-control" value="<?php echo set_value('country_name', $country_name); ?>" />
							<?php echo form_error('country_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-2" class="col-sm-2 control-label">ISO Code 2:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_2" id="input-iso-code-2" class="form-control" value="<?php echo set_value('iso_code_2', $iso_code_2); ?>" size="5" />
							<?php echo form_error('iso_code_2', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-3" class="col-sm-2 control-label">ISO Code 3:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_3" id="input-iso-code-3" class="form-control" value="<?php echo set_value('iso_code_3', $iso_code_3); ?>" size="5" />
							<?php echo form_error('iso_code_3', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-format" class="col-sm-2 control-label">Format:
							<span class="help-block">Address 1 = {address_1}<br />Address 2 = {address_2}<br />City = {city}<br />Postcode = {postcode}<br />State = {state}<br />Country = {country}</span>
						</label>
						<div class="col-sm-5">
							<textarea name="format" id="input-format" class="form-control" rows="7"><?php echo set_value('format', $format); ?></textarea>
							<?php echo form_error('format', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="status" id="input-status" class="form-control">
									<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
								<?php if ($status === '1') { ?>
									<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>