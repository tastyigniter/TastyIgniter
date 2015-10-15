<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#table-details" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="table-details" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="table_name" id="input-name" class="form-control" value="<?php echo set_value('table_name', $table_name); ?>" />
							<?php echo form_error('table_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-capacity" class="col-sm-3 control-label"><?php echo lang('label_min_capacity'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="min_capacity" id="input-min-capacity" class="form-control" value="<?php echo set_value('min_capacity', $min_capacity); ?>" />
							<?php echo form_error('min_capacity', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-max-capacity" class="col-sm-3 control-label"><?php echo lang('label_capacity'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="max_capacity" id="input-max-capacity" class="form-control" value="<?php echo set_value('max_capacity', $max_capacity); ?>" />
							<?php echo form_error('max_capacity', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($table_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="table_status" value="0" <?php echo set_radio('table_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="table_status" value="1" <?php echo set_radio('table_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="table_status" value="0" <?php echo set_radio('table_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="table_status" value="1" <?php echo set_radio('table_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('table_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>