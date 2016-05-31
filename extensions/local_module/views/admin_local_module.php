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
						<label for="input-display-search" class="col-sm-3 control-label"><?php echo lang('label_location_search_mode'); ?>
							<span class="help-block"><?php echo lang('help_location_search_mode'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($location_search_mode == 'multi') { ?>
									<label class="btn btn-default"><input type="radio" name="location_search_mode" value="single" <?php echo set_radio('location_search_mode', 'single'); ?>><?php echo lang('text_single'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="location_search_mode" value="multi" <?php echo set_radio('location_search_mode', 'multi', TRUE); ?>><?php echo lang('text_multi'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="location_search_mode" value="single" <?php echo set_radio('location_search_mode', 'single', TRUE); ?>><?php echo lang('text_single'); ?></label>
									<label class="btn btn-default"><input type="radio" name="location_search_mode" value="multi" <?php echo set_radio('location_search_mode', 'multi'); ?>><?php echo lang('text_multi'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('location_search_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="location-search-mode">
						<label for="input-use-location" class="col-sm-3 control-label"><?php echo lang('label_use_location'); ?>
							<span class="help-block"><?php echo lang('help_use_location'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="use_location" class="form-control">
								<option value="0"><?php echo lang('text_use_default'); ?></option>
								<?php foreach ($locations as $location) { ?>
									<?php if ($location['location_id'] === $use_location) { ?>
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('use_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('use_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('use_location', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('input[name="location_search_mode"]').on('change', function() {
			if (this.value == 'single') {
				$('#location-search-mode').fadeIn();
			} else {
				$('#location-search-mode').fadeOut();
			}
		});

		$('input[name="location_search_mode"]:checked').trigger('change');
	});
//--></script>