<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="currency_name" id="input-name" class="form-control" value="<?php echo set_value('currency_name', $currency_name); ?>" />
							<?php echo form_error('currency_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-3 control-label"><?php echo lang('label_country'); ?></label>
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
						<label for="input-code" class="col-sm-3 control-label"><?php echo lang('label_code'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="currency_code" id="input-code" class="form-control" value="<?php echo set_value('currency_code', $currency_code); ?>" />
							<?php echo form_error('currency_code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-symbol" class="col-sm-3 control-label"><?php echo lang('label_symbol'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="currency_symbol" id="input-symbol" class="form-control" value="<?php echo set_value('currency_symbol', $currency_symbol); ?>" />
							<?php echo form_error('currency_symbol', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-symbol" class="col-sm-3 control-label"><?php echo lang('label_symbol_position'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-2" data-toggle="buttons">
								<?php if ($symbol_position === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="symbol_position" value="0" <?php echo set_radio('symbol_position', '0'); ?>><?php echo lang('text_left'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="symbol_position" value="1" <?php echo set_radio('symbol_position', '1', TRUE); ?>><?php echo lang('text_right'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="symbol_position" value="0" <?php echo set_radio('symbol_position', '0', TRUE); ?>><?php echo lang('text_left'); ?></label>
									<label class="btn btn-default"><input type="radio" name="symbol_position" value="1" <?php echo set_radio('symbol_position', '1'); ?>><?php echo lang('text_right'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('symbol_position', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-currency-rate" class="col-sm-3 control-label"><?php echo lang('label_rate'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="currency_rate" id="input-currency-rate" class="form-control" value="<?php echo set_value('currency_rate', $currency_rate); ?>" />
							<?php echo form_error('currency_rate', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-thousand-sign" class="col-sm-3 control-label"><?php echo lang('label_thousand_sign'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="thousand_sign" id="input-thousand-sign" class="form-control" value="<?php echo set_value('thousand_sign', $thousand_sign); ?>" />
							<?php echo form_error('thousand_sign', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-decimal-sign" class="col-sm-3 control-label"><?php echo lang('label_decimal_sign'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="decimal_sign" id="input-decimal-sign" class="form-control" value="<?php echo set_value('decimal_sign', $decimal_sign); ?>" />
							<?php echo form_error('decimal_sign', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-decimal-position" class="col-sm-3 control-label"><?php echo lang('label_decimal_position'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="decimal_position" id="input-decimal-position" class="form-control" value="<?php echo set_value('decimal_position', $decimal_position); ?>" />
							<?php echo form_error('decimal_position', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($currency_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="currency_status" value="0" <?php echo set_radio('currency_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="currency_status" value="1" <?php echo set_radio('currency_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="currency_status" value="0" <?php echo set_radio('currency_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="currency_status" value="1" <?php echo set_radio('currency_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
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