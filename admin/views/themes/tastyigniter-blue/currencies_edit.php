<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="currency_name" id="input-name" class="form-control" value="<?php echo set_value('currency_name', $currency_name); ?>" />
							<?php echo form_error('currency_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-3 control-label">Country:</label>
						<div class="col-sm-5">
							<select name="country_id" id="input-country" class="form-control">
								<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] === $country_id) { ?>
									<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('country_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Code:</label>
						<div class="col-sm-5">
							<input type="text" name="currency_code" id="input-code" class="form-control" value="<?php echo set_value('currency_code', $currency_code); ?>" />
							<?php echo form_error('currency_code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-symbol" class="col-sm-3 control-label">Symbol:</label>
						<div class="col-sm-5">
							<input type="text" name="currency_symbol" id="input-symbol" class="form-control" value="<?php echo set_value('currency_symbol', $currency_symbol); ?>" />
							<?php echo form_error('currency_symbol', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">ISO Alpha 2:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_alpha2" id="" class="form-control" value="<?php echo set_value('iso_alpha2', $iso_alpha2); ?>" />
							<?php echo form_error('iso_alpha2', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-alpha3" class="col-sm-3 control-label">ISO Alpha 3:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_alpha3" id="input-iso-alpha3" class="form-control" value="<?php echo set_value('iso_alpha3', $iso_alpha3); ?>" />
							<?php echo form_error('iso_alpha3', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-numeric" class="col-sm-3 control-label">ISO Numeric:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_numeric" id="input-iso-numeric" class="form-control" value="<?php echo set_value('iso_numeric', $iso_numeric); ?>" />
							<?php echo form_error('iso_numeric', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($currency_status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="currency_status" value="0" <?php echo set_radio('currency_status', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="currency_status" value="1" <?php echo set_radio('currency_status', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="currency_status" value="0" <?php echo set_radio('currency_status', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="currency_status" value="1" <?php echo set_radio('currency_status', '1'); ?>>Enabled</label>
								<?php } ?>
							</div>
							<?php echo form_error('currency_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>