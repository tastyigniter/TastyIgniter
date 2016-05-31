<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-fixed-categories" class="col-sm-3 control-label"><?php echo lang('label_fixed_categories'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($fixed_categories == '1') { ?>
									<label class="btn btn-default"><input type="radio" name="fixed_categories" value="0" <?php echo set_radio('fixed_categories', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="fixed_categories" value="1" <?php echo set_radio('fixed_categories', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="fixed_categories" value="0" <?php echo set_radio('fixed_categories', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-default"><input type="radio" name="fixed_categories" value="1" <?php echo set_radio('fixed_categories', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('fixed_categories', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="categories-fixed-offset">
						<label for="input-fixed-top-offset" class="col-sm-3 control-label"><?php echo lang('label_fixed_offset'); ?>
							<span class="help-block"><?php echo lang('help_fixed_offset'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="fixed_top_offset" class="form-control" value="<?php echo $fixed_top_offset; ?>" />
								<input type="text" name="fixed_bottom_offset" class="form-control" value="<?php echo $fixed_bottom_offset; ?>" />
							</div>
							<?php echo form_error('fixed_top_offset', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('fixed_bottom_offset', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('input[name="fixed_categories"]').on('change', function() {
			if (this.value == '1') {
				$('#categories-fixed-offset').fadeIn();
			} else {
				$('#categories-fixed-offset').fadeOut();
			}
		});

		$('input[name="fixed_categories"]:checked').trigger('change');
	});
//--></script>